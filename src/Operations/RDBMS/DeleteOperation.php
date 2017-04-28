<?php namespace Talonon\Ooops\Operations\RDBMS;

use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Talonon\Ooops\Contexts\DbContext;
use Talonon\Ooops\Interfaces\SoftDeleteRepositoryInterface;
use Talonon\Ooops\Models\Entity;

class DeleteOperation extends BaseEntityOperation {

  public function __construct(DbContext $context, Entity $entity) {
    parent::__construct($context, get_class($entity));
    $this->entity = $entity;
  }

  protected function doExecute() {
    $table = $this->getTable();
    $this->addWherePrimaryKey($table);
    $this->getRepository() instanceof SoftDeleteRepositoryInterface ? $this->_softDelete($table) : $this->_hardDelete($table);
  }

  private function _softDelete(Builder $query) {
    $query->update(
      [
        $this->getRepository()->GetDeletedColumnName() => Carbon::now()
      ]
    );
  }

  private function _hardDelete(Builder $query) {
    $query->delete();
  }
}
