<?php namespace Talonon\Ooops\Operations\RDBMS;

use Carbon\Carbon;
use Talonon\Ooops\Contexts\DbContext;
use Talonon\Ooops\Exceptions\InternalException;
use Talonon\Ooops\Interfaces\SoftDeleteRepositoryInterface;
use Talonon\Ooops\Models\Entity;

/**
 * The DeleteOperation should already handle soft deletes. This is here just in case you need to override the SoftDelete
 * functionality in an operation.
 */
abstract class BaseSoftDeleteOperation extends UpdateOperation {

  public function __construct(DbContext $context, Entity $entity) {
    parent::__construct($context, $entity);
    $this->entity = $entity;
  }

  protected function getFields() {
    return [
      $this->getRepository()->GetDeletedColumnName() => Carbon::now()
    ];
  }

  protected function getRepository() {
    $repository = parent::getRepository();
    if (!$repository instanceof SoftDeleteRepositoryInterface) {
      throw new InternalException('Repository for ' . $this->entityType . ' must extend BaseSoftDeleteDbRepository.');
    }
    return $repository;
  }
}
