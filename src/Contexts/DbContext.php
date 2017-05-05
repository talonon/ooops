<?php namespace Talonon\Ooops\Contexts;

class DbContext extends Context {

  /**
   * @return \Illuminate\Database\Connection
   */
  public function GetDatabase() {
    return \DB::connection();
  }
}