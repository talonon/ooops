<?php namespace Talonon\Ooops\Traits;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Talonon\Ooops\Models\Uuids\NullUuid;

trait HasUuid {

  /**
   * @var Uuid
   */
  private $_uuid;

  /**
   * @return UuidInterface
   */
  public function GetUuid(): UuidInterface {
    return $this->_uuid ?: new NullUuid();
  }

  /**
   * @param UuidInterface|null $uuid
   * @return $this
   */
  public function SetUuid(UuidInterface $uuid = null) {
    $this->_uuid = $uuid;
    return $this;
  }

}