<?php namespace Talonon\Ooops\Models;

use Carbon\Carbon;

abstract class SoftDeleteEntity extends Entity {
  private $_deletedAt;

  /**
   * @return mixed
   */
  public function GetDeletedAt() {
    return $this->_deletedAt;
  }

  /**
   * @param Carbon $deletedAt
   * @return $this
   */
  public function SetDeletedAt($deletedAt) {
    $this->_deletedAt = $deletedAt;
    return $this;
  }
}
