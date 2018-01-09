<?php namespace Talonon\Ooops\Interfaces;

interface AllowSoftDeletedInterface {
  public function GetAllowSoftDeleted(): bool;

  public function SetAllowSoftDeleted(bool $allow);
}