<?php namespace Talonon\Ooops\Traits\RDBMS;

use Illuminate\Support\Collection;
use Talonon\Ooops\Interfaces\ResultInterface;
use Talonon\Ooops\Models\BaseGetMultipleParams;
use Talonon\Ooops\Models\BaseGetSingleParams;
use Talonon\Ooops\Models\Entity;
use Talonon\Ooops\Operations\BaseOperation;

trait EntityCrud {

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
   * @return Collection
   */
  protected function getEntities(BaseGetMultipleParams $params) {
    return $this->_crud('getList', $params)->GetResult();
  }

  /**
   * @param string $type
   * @param mixed $object
   * @return BaseOperation|ResultInterface
   */
  private function _crud($type, $object) {
    $dbContext = app('talonon.ooops.dbcontext');
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

