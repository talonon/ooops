<?php namespace Talonon\Ooops\Database\Events;

use Talonon\Ooops\Traits\ProvidesEvents;

trait TransactionEvents {
  use ProvidesEvents;

  protected function addTransactionEvents(string $repositoryClass, $operationClass) {
    if (is_array($operationClass)) {
      foreach ($operationClass as $class) {
        $this->addTransactionEvents($repositoryClass, $class);
      }
    } else {
      $this->addBeforeEvent($repositoryClass, $operationClass, BeginTransaction::class, 99);
      $this->addAfterEvent($repositoryClass, $operationClass, CommitTransaction::class, 99);
    }
  }

}