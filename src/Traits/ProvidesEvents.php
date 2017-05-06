<?php namespace Talonon\Ooops\Traits;

use Talonon\Events\EventKeysStruct;
use Talonon\Ooops\Exceptions\InternalException;
use Talonon\Ooops\Repositories\BaseRepository;

trait ProvidesEvents {

  protected function addBeforeEvent($repository, $operationClass, $handler, int $priority = 0) {
    $this->addRepositoryEvent($repository, $operationClass, $handler, EventKeysStruct::BEFORE, $priority);
  }

  protected function addAfterEvent($repository, $operationClass, $handler, int $priority = 0) {
    $this->addRepositoryEvent($repository, $operationClass, $handler, EventKeysStruct::AFTER, $priority);
  }

  /**
   * @param string $repository Repository class name for entity type that this event affects.
   * @param string|string[] $operationClass Class name(s) of the operations.
   * @param string $handler Class name for the event that will be called.
   * @param string $when When to fire the event in the operation.
   * @param int $priority
   * @throws InternalException
   */
  protected function addRepositoryEvent($repository, $operationClass, $handler, $when = EventKeysStruct::AFTER, int $priority = 0) {
    if (is_object($repository) && is_subclass_of($repository, BaseRepository::class)) {
      $repository = get_class($repository);
    } else if (is_string($repository) && is_subclass_of($repository, BaseRepository::class)) {
      // Nothing.
    } else {
      throw new InternalException('Invalid repository');
    }
    $key = $repository . '.' . $when . $operationClass;
    \Event::listen($key, $handler, $priority);
  }

}

