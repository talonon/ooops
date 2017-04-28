<?php namespace Talonon\Ooops\Operations\RDBMS;

use Illuminate\Database\Query\Builder;
use Talonon\Ooops\Contexts\DbContext;
use Talonon\Ooops\Exceptions\InternalException;
use Talonon\Ooops\Models\Entity;
use Talonon\Ooops\Repositories\BaseDbRepository;
use Talonon\Ooops\Repositories\BaseSoftDeleteDbRepository;

abstract class BaseEntityOperation extends BaseDbOperation {
  public function __construct(DbContext $context, $class) {
    parent::__construct($context);
    $this->entityType = $class;
  }

  /**
   * @var Entity
   */
  protected $entity;
  /**
   * @var string
   */
  protected $entityType;
  /**
   * @var BaseDbRepository
   */
  private $_repository;

  public function Execute() {
    $this->validate();
    $this->beforeEvent();
    $this->beforeExecute();
    $this->doExecute();
    $this->afterExecute();
    $this->afterEvent();
  }

  protected function beforeEvent() {
    $this->fireEvent('Before', $this->entity);
  }

  protected function afterEvent() {
    $this->fireEvent('After', $this->entity);
  }

  protected function eventName() {
    return str_replace('Operation', '', (new \ReflectionClass($this))->getShortName());
  }

  protected function fireEvent(string $eventKey = '', ...$params) {
    $key = get_class($this->getRepository()) . '.' . $eventKey . $this->eventName();
    print_r($params);
    event($key, ...$params);
  }

  /**
   * @return BaseDbRepository|BaseSoftDeleteDbRepository
   * @throws InternalException
   */
  protected function getRepository() {
    if (!$this->_repository) {
      $repositories = app('talonon.ooops.repositories');
      $repo = $repositories->get($this->entityType);
      if (!$repo) {
        throw new InternalException('Repository for ' . $this->entityType . ' not found');
      } else if (is_string($repo)) {
        $this->_repository = app($repo);
      }
    }
    return $this->_repository;
  }

  /**
   * @return Builder
   */
  protected function getTable() {
    return $this->getDatabase()->table($this->getRepository()->GetTableName());
  }

  /**
   * Helper for adding the where statement for soft deletes
   * @param Builder $query
   */
  protected function addWhereSoftDeleted(Builder $query) {
    if ($this->getRepository() instanceof BaseSoftDeleteDbRepository) {
      $query->whereNull($this->getRepository()->GetTableName() . '.' . $this->getRepository()->GetDeletedColumnName());
    }
  }

  /**
   * Adds the simple or complex primary key to the where statement in the query.
   * @param Builder $query
   */
  protected function addWherePrimaryKey(Builder $query, $id = null) {
    $pk = $this->getRepository()->GetPrimaryKey();
    $id = $id ?: $this->entity->GetId();
    if (is_array($pk)) {
      $query->where(
        function (Builder $inner) use (&$pk, &$id) {
          for ($x = 0, $c = count($pk); $x < $c; $x++) {
            $inner->where($this->getRepository()->GetTableName() . '.' . $pk[$x], $id[$x] ?? null);
          }
        });
    } else {
      $query->where($this->getRepository()->GetTableName() . '.' . $this->getRepository()->GetPrimaryKey(), $id);
    }
  }
}
