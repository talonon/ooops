<?php namespace Talonon\Ooops\Traits;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Talonon\Ooops\Models\NullUuid;

trait HasUuid {

  /**
   * @var Uuid
   */
  private $_uuid;

  public function GetUuid(): UuidInterface {
    return $this->_uuid ?: new NullUuid();
  }

  /**
   * @param Uuid|null $uuid
   * @return $this
   */
  public function SetUuid(Uuid $uuid = null) {
    $this->_uuid = $uuid;
    return $this;
  }

}