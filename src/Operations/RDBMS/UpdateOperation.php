<?php namespace Talonon\Ooops\Operations\RDBMS;

use Talonon\Ooops\Contexts\DbContext;
use Talonon\Ooops\Models\Entity;

class UpdateOperation extends BaseEntityOperation {

  public function __construct(DbContext $context, Entity $entity) {
    parent::__construct($context, get_class($entity));
    $this->entity = $entity;
  }

  /**
   * @var Entity
   */
  protected $entity;

  protected function doExecute() {
    $table = $this->getTable();
    $this->addWherePrimaryKey($table);
    $table->update($this->getFields());
  }

  protected function getFields() {
    return $this->getRepository()->GetUpdateFields($this->entity);
  }
}
