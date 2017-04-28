<?php namespace Talonon\Ooops\Interfaces;

use Carbon\Carbon;

/**
 * An indicator to the mapper that a BaseEntity model that implements this interface should have the columns
 * "created_at" and "updated_at" populated during create and updated operations.  The database table must
 * have these columns and they must be datetime/timestamp columns.
 *
 * Best used in conjunction with the HasTimestamps trait.
 * Interface TimestampsInterface
 * @package Talonon\Ooops\Interfaces
 */
interface HasTimestampsInterface {

  public function GetCreatedAt(): Carbon;

  public function SetCreatedAt(Carbon $date = null);

  public function GetUpdatedAt(): Carbon;

  public function SetUpdatedAt(Carbon $date = null);

}
