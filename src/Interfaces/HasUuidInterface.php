<?php namespace Talonon\Ooops\Interfaces;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

interface HasUuidInterface {

  public function GetUuid(): UuidInterface;

  public function SetUuid(UuidInterface $uuid);

}
