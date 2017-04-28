<?php namespace Talonon\Ooops\Traits;

use Illuminate\Support\Collection;
use Talonon\Ooops\Exceptions\InternalException;

trait ProvidesRepositories {

  /**
   * Links an Entity to its Repository class so it can be used transparently by Ooops
   * @param string|array $entityClass
   * @param string|array|null $repositoryClass
   * @throws InternalException
   */
  protected function addRepository($entityClass, $repositoryClass = null) {
    if (is_string($entityClass) && is_string($repositoryClass)) {
      /** @var Collection $repositories */
      $repositories = app('talonon.ooops.repositories');
      if (!$repositories) {
        throw new InternalException('OopsServiceProvider has not been loaded');
      }
      $repositories->put($entityClass, $repositoryClass);
    } else if (is_array($entityClass) && is_null($repositoryClass)) {
      foreach ($entityClass as $eClass => $rClass) {
        $this->addRepository($entityClass, $rClass);
      }
    } else if (is_array($entityClass) && is_string($repositoryClass)) {
      for ($x = 0, $c = count($entityClass); $x < $c; $x++) {
        $this->addRepository($entityClass[$x], $repositoryClass);
      }
    } else {
      throw new InternalException('Invalid repository definition passed to addRepository');
    }
  }
}

