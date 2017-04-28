<?php namespace Talonon\Ooops\Traits;

trait HasName {

  private $_name;

  /**
   * @return mixed
   */
  public function GetName() {
    return $this->_name;
  }

  /**
   * @param mixed $name
   * @return $this
   */
  public function SetName($name) {
    $this->_name = $name;
    return $this;
  }
}

