<?php namespace Talonon\Ooops\Models;

use Talonon\Ooops\Traits\HasID;

class BaseGetSingleParams {
  use HasID;

  public function __construct($id = null) {
    $id && $this->SetId($id);
  }
}

