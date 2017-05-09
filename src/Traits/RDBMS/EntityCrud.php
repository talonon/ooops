<?php namespace Talonon\Ooops\Traits\RDBMS;

use Illuminate\Support\Collection;
use Talonon\Ooops\Contexts\DbContext;
use Talonon\Ooops\Exceptions\EntityNotFoundException;
use Talonon\Ooops\Interfaces\ResultInterface;
use Talonon\Ooops\Models\BaseGetMultipleParams;
use Talonon\Ooops\Models\BaseGetSingleParams;
use Talonon\Ooops\Models\Entity;
use Talonon\Ooops\Operations\BaseOperation;

trait EntityCrud {

  /**
   * @var DbContext
   */
  private $__context;

  /**
   * @param Entity $entity
   */
  protected function createEntity(Entity $entity) {
    $this->_crud('create', $entity);
  }

  /**
   * @param Entity $entity
   */
  protected function updateEntity(Entity $entity) {
    $this->_crud('update', $entity);
  }

  /**
   * @param Entity $entity
   */
  protected function deleteEntity(Entity $entity) {
    $this->_crud('delete', $entity);
  }

  /**
   * @param BaseGetSingleParams $params
   * @return Entity
   */
  protected function getEntity(BaseGetSingleParams $params) {
    return $this->_crud('get', $params)->GetResult();
  }

  /**
   * @param BaseGetSingleParams $params
   * @return Entity|null
   */
  protected function tryGetEntity(BaseGetSingleParams $params) {
    try {
      return $this->_crud('get', $params)->GetResult();
    } catch (EntityNotFoundException $nfex) {
      return null;
    }
  }

  /**
   * @param BaseGetSingleParams $params
   * @return Collection
   */
  protected function getEntities(BaseGetMultipleParams $params) {
    return $this->_crud('getList', $params)->GetResult();
  }

  /**
   * @param DbContext $context
   * @param callable $callable
   * @return mixed
   */
  protected function withContext(DbContext $context, Callable $callable) {
    try {
      $this->__context = $context;
      return $callable();
    } finally {
      $this->_context = null;
    }
  }

  /**
   * @param string $type
   * @param mixed $object
   * @return BaseOperation|ResultInterface
   */
  private function _crud($type, $object) {
    $dbContext = $this->__context ?: app('talonon.ooops.dbcontext');
    $alias = $this->_getOperation($type, $object);
    /** @var BaseOperation $op */
    $op = app($alias, [$dbContext, $object]);
    $op->Execute();
    return $op;
  }

  /**
   * @param string $type
   * @param mixed $object
   * @return string
   */
  private function _getOperation($type, $object) {
    /** @var Collection $overrides */
    $overrides = app('talonon.ooops.operations.overrides');
    /** @var Collection $repositories */
    $repositories = app('talonon.ooops.repositories');
    $repository = $repositories->get(get_class($object));
    return $overrides->get($repository . '.' . $type, 'talonon.ooops.operations.rdbms.' . $type);
  }
}