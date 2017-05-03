<?php namespace Talonon\Ooops\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Talonon\Ooops\Contexts\DbContext;
use Talonon\Ooops\Exceptions\InternalException;
use Talonon\Ooops\Interfaces\HasTimestampsInterface;
use Talonon\Ooops\Models\BaseGetMultipleParams;
use Talonon\Ooops\Models\BaseGetSingleParams;
use Talonon\Ooops\Models\Entity;

abstract class BaseDbRepository extends BaseRepository {

  public function __construct(DbContext $context) {
    $this->context = $context;
  }

  protected $context;

  protected $autoIncrementingID = true;

  /**
   * Sometimes tables don't use autoincrementing IDs, setting this to false will prevent the create from using
   * the LAST_INSERT_ID and passing it to SetID().  By default its on because most tables will use it.
   * @return boolean
   */
  public function HasAutoIncrementingID(): bool {
    return $this->autoIncrementingID;
  }

  /**
   * Gets an associated array of fields that are used to create a record in the database.  The key of the array
   * is the column name, the value of the element in the array is the value that will be saved in the database. Will
   * automagically change updated and created date for models that implement the TimestampsInterface
   * @param Entity $entity
   * @returns array
   * @throws InternalException
   */
  public function GetCreateFields(Entity $entity) {
    $fields = $this->doGetCreateFields($entity);
    if ($entity instanceof HasTimestampsInterface) {
      $fields += [
        'updated_at' => Carbon::now(),
        'created_at' => Carbon::now()
      ];
    }
    return $fields;
  }

  /**
   * Gets an associated array of fields that are used to update a record in the database.  The key of the array
   * is the column name, the value of the element in the array is the value that will be saved in the database.
   * This list should not include the primary key values.  Will automagically change updated date for models
   * that implement the TimestampsInterface
   * @param Entity $entity
   * @returns array
   * @throws InternalException
   */
  public function GetUpdateFields(Entity $entity) {
    $fields = $this->doGetUpdateFields($entity);
    if ($entity instanceof HasTimestampsInterface) {
      $fields += [
        'updated_at' => Carbon::now()
      ];
    }
    return $fields;
  }

  public function BuildGetSingleQuery(Builder $query, BaseGetSingleParams $params) {
    $query->where($this->GetPrimaryKey(), $params->GetId());
  }

  public function BuildGetMultipleQuery(Builder $query, BaseGetMultipleParams $params) {

  }

  abstract public function GetTableName();

  abstract public function GetPrimaryKey();

  /**
   * @param Entity $entity
   * @returns array
   * @throws InternalException
   */
  protected function doGetUpdateFields(Entity $entity) {
    throw new InternalException('Not Implemented');
  }

  /**
   * @param Entity $entity
   * @returns array
   * @throws InternalException
   */
  protected function doGetCreateFields(Entity $entity) {
    throw new InternalException('Not Implemented');
  }
}

