<?php namespace Talonon\Ooops\Database\Events;

use Talonon\Ooops\Contexts\DbContext;

class BeginTransaction {

  public function handle(DbContext $context) {
    $context->GetDatabase()->beginTransaction();
  }

}