<?php namespace Talonon\Ooops\Repositories;

use Talonon\Ooops\Models\Entity;

abstract class BaseRepository {

  /**
   * @param array $data
   * @return Entity
   */
  public function BuildMultiple(array $data): Entity {
    return $this->BuildSingle($data);
  }

  /**
   * @param array $data
   * @return Entity
   */
  abstract public function BuildSingle(array $data): Entity;
}

