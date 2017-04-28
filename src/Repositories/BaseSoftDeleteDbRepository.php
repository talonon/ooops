<?php namespace Talonon\Ooops\Repositories;

use Talonon\Ooops\Interfaces\SoftDeleteRepositoryInterface;

abstract class BaseSoftDeleteDbRepository extends BaseDbRepository implements SoftDeleteRepositoryInterface {

  public function GetDeletedColumnName() {
    return 'deleted_at';
  }

}

