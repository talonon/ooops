<?php namespace Talonon\Ooops\Traits;

use Illuminate\Support\Collection;
use Talonon\Ooops\Exceptions\InternalException;
use Talonon\Ooops\Operations\RDBMS\BaseSoftDeleteOperation;
use Talonon\Ooops\Operations\RDBMS\CreateOperation;
use Talonon\Ooops\Operations\RDBMS\DeleteOperation;
use Talonon\Ooops\Operations\RDBMS\GetMultipleOperation;
use Talonon\Ooops\Operations\RDBMS\GetSingleOperation;
use Talonon\Ooops\Operations\RDBMS\UpdateOperation;

trait ProvidesOverrides {

  /**
   * Add an override when you need to use a custom operation instead of the generic crud operations.
   * @param string|array $entityClass
   * @param string|array|null $operationClass
   * @throws InternalException
   */
  protected function addOverride(string $entityClass, string $operationClass) {
    if (is_subclass_of($operationClass, GetSingleOperation::class)) {
      $type = 'get';
    } else if (is_subclass_of($operationClass, GetMultipleOperation::class)) {
      $type = 'getList';
    } else if (is_subclass_of($operationClass, BaseSoftDeleteOperation::class) || is_subclass_of($operationClass, DeleteOperation::class)) {
      $type = 'delete';
    } else if (is_subclass_of($operationClass, CreateOperation::class)) {
      $type = 'create';
    } else if (is_subclass_of($operationClass, UpdateOperation::class)) {
      $type = 'update';
    } else {
      throw new InternalException('Invalid operation override');
    }

    $overrides = app('talonon.ooops.operations.overrides');
    /** @var Collection $repositories */
    if (!$overrides) {
      throw new InternalException('OopsServiceProvider has not been loaded');
    }

    /** @var Collection $repositories */
    $repositories = app('talonon.ooops.repositories');
    $repository = $repositories->get($entityClass);
    $repository = is_object($repository) ? get_class($repository) : $repository;

    $overrides->put($repository . '.' . $type, $operationClass);
  }
}

