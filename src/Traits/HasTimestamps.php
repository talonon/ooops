<?php namespace Talonon\Ooops\Traits;

use Carbon\Carbon;

trait HasTimestamps {

  /**
   * The date and time the fare was created.
   * @var Carbon
   */
  private $_createdAt;

  /**
   * The date and time the fare was updated.
   * @var Carbon
   */
  private $_updatedAt;

  /**
   * @return Carbon
   */
  public function GetCreatedAt(): Carbon {
    return $this->_createdAt;
  }

  /**
   * @param Carbon $created_at
   * @return $this
   */
  public function SetCreatedAt(Carbon $created_at = null) {
    $this->_createdAt = $created_at;
    return $this;
  }

  /**
   * @return Carbon
   */
  public function GetUpdatedAt(): Carbon {
    return $this->_updatedAt;
  }

  /**
   * @param Carbon $updated_at
   * @return $this
   */
  public function SetUpdatedAt(Carbon $updated_at = null) {
    $this->_updatedAt = $updated_at;
    return $this;
  }
}