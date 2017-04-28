<?php namespace Talonon\Ooops\Models;

class Entity {
  private $_id;

  /**
   * @return mixed
   */
  public function GetId() {
    return $this->_id;
  }

  /**
   * @param mixed $id
   * @return $this
   */
  public function SetId($id) {
    $this->_id = $id;
    return $this;
  }
}

