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
      $this->addRepositoryEvent($repositoryClass, 'Before' . $operationClass, BeginTransaction::class, 99);
      $this->addRepositoryEvent($repositoryClass, 'After' . $operationClass, CommitTransaction::class, 99);
    }
  }

}