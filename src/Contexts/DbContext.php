<?php namespace Talonon\Ooops\Contexts;

class DbContext extends Context {

  public function GetDatabase() {
    return \DB::connection();
  }
}