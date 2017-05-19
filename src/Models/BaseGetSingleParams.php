<?php namespace Talonon\Ooops\Models;

use Talonon\LazyLoader\LazyLoadInterface;
use Talonon\Ooops\Traits\HasID;

class BaseGetSingleParams implements LazyLoadInterface {
  use HasID;

  public function __construct($id = null) {
    $id && $this->SetId($id);
  }
}

