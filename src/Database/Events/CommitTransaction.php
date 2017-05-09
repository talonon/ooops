<?php namespace Talonon\Ooops\Database\Events;

use Talonon\Ooops\Contexts\DbContext;

class CommitTransaction {

  public function handle() {
    context()->GetDatabase()->commit();
  }

}