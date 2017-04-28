<?php namespace Talonon\Ooops\Traits;

use Talonon\Ooops\Exceptions\InternalException;
use Talonon\Ooops\Repositories\BaseRepository;

trait ProvidesEvents {

  protected function addRepositoryEvent($repository, $eventKey, $handler, int $priority = 0) {
    if (is_object($repository) && is_subclass_of($repository, BaseRepository::class)) {
      $repository = get_class($repository);
    } else if (is_string($repository) && is_subclass_of($repository, BaseRepository::class)) {
      // Nothing.
    } else {
      throw new InternalException('Invalid repository');
    }
    $key = $repository . '.' . $eventKey;
    \Event::listen($key, $handler, $priority);
  }

}

