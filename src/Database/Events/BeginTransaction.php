<?php namespace Talonon\Ooops\Database\Events;

class BeginTransaction {

  public function handle() {
    tixcontext()->GetDatabase()->beginTransaction();
  }

}