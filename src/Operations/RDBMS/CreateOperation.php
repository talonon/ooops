<?php namespace Talonon\Ooops\Operations\RDBMS;

use Ramsey\Uuid\Uuid;
use Talonon\Ooops\Contexts\DbContext;
use Talonon\Ooops\Interfaces\HasUuidInterface;
use Talonon\Ooops\Models\Entity;
use Talonon\Ooops\Models\Uuids\NullUuid;

class CreateOperation extends BaseEntityOperation {

  public function __construct(DbContext $context, Entity $entity) {
    parent::__construct($context, get_class($entity));
    $this->entity = $entity;
  }

  protected function beforeExecute() {
    parent::beforeExecute();
    if ($this->entity instanceof HasUuidInterface && $this->entity->GetUuid() instanceof NullUuid) {
      $this->entity->SetUuid(Uuid::uuid4());
    }
  }

  protected function doExecute() {
    $method = $this->getRepository()->HasAutoIncrementingID() ? 'insertGetId' : 'insert';
    $id = $this->getTable()->$method(
      $this->getFields()
    );
    $this->getRepository()->HasAutoIncrementingID() && $this->entity->SetId($id);
  }

  protected function getFields() {
    return $this->getRepository()->GetCreateFields($this->entity);
  }
}
