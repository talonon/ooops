<?php namespace Talonon\Ooops\Database\Events;

class BeginTransaction {

  public function handle() {
    context()->GetDatabase()->beginTransaction();
  }

}