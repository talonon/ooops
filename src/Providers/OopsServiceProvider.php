<?php namespace Talonon\Ooops\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Talonon\LazyLoader\LazyLoaderProvider;
use Talonon\Ooops\Contexts\DbContext;
use Talonon\Ooops\Operations\RDBMS\CreateOperation;
use Talonon\Ooops\Operations\RDBMS\DeleteOperation;
use Talonon\Ooops\Operations\RDBMS\GetCountOperation;
use Talonon\Ooops\Operations\RDBMS\GetMultipleOperation;
use Talonon\Ooops\Operations\RDBMS\GetSingleOperation;
use Talonon\Ooops\Operations\RDBMS\UpdateOperation;

class OopsServiceProvider extends ServiceProvider {

  /**
   * Indicates if loading of the provider is deferred.
   *
   * @var bool
   */
  protected $defer = false;

  public static function compiles() {
    return [
      __DIR__ . '/../Models/NullEntity.php',
      __DIR__ . '/../Models/Entity.php',
      __DIR__ . '/../Interfaces/ResultInterface.php',
      __DIR__ . '/../Operations/BaseOperation.php',
      __DIR__ . '/../Operations/RDBMS/BaseDbOperation.php',
      __DIR__ . '/../Operations/RDBMS/BaseEntityOperation.php',
      __DIR__ . '/../Operations/RDBMS/BaseGetOperation.php',
      __DIR__ . '/../Operations/RDBMS/BaseSoftDeleteOperation.php',
      __DIR__ . '/../Operations/RDBMS/CreateOperation.php',
      __DIR__ . '/../Operations/RDBMS/UpdateOperation.php',
      __DIR__ . '/../Operations/RDBMS/DeleteOperation.php',
      __DIR__ . '/../Operations/RDBMS/GetSingleOperation.php',
      __DIR__ . '/../Operations/RDBMS/GetMultipleOperation.php',
      __DIR__ . '/../Models/BaseGetMultipleParams.php',
      __DIR__ . '/../Models/BaseGetSingleParams.php',
      __DIR__ . '/../Models/Struct.php',
      __DIR__ . '/../Interfaces/HasTimestampsInterface.php',
      __DIR__ . '/../Interfaces/HasUuidInterface.php',
      __DIR__ . '/../Exceptions/InternalException.php',
      __DIR__ . '/../Exceptions/ExternalException.php',
      __DIR__ . '/../Exceptions/EntityNotFoundException.php',
      __DIR__ . '/../Events/EventKeysStruct.php',
      __DIR__ . '/../Traits/RDBMS/EntityCrud.php',
      __DIR__ . '/../Database/Events/BeginTransaction.php',
      __DIR__ . '/../Database/Events/CommitTransaction.php',
      __DIR__ . '/../Database/Events/TransactionEvents.php',
      __DIR__ . '/../Controllers/ResponseWithJson.php',
      __DIR__ . '/../Controllers/ResponseWithView.php',
      __DIR__ . '/../Controllers/BaseController.php',
      __DIR__ . '/../Controllers/BaseViewController.php',
      __DIR__ . '/../Controllers/BaseJsonController.php',
      __DIR__ . '/../Repositories/BaseRepository.php',
      __DIR__ . '/../Repositories/BaseDbRepository.php',
      __DIR__ . '/../Repositories/BaseSoftDeleteDbRepository.php',
      __DIR__ . '/../Traits/HasID.php',
      __DIR__ . '/../Traits/HasName.php',
      __DIR__ . '/../Traits/HasPagination.php',
      __DIR__ . '/../Traits/HasTimestamps.php',
      __DIR__ . '/../Traits/HasUuid.php',
      __DIR__ . '/../Traits/ProvidesEvents.php',
      __DIR__ . '/../Traits/ProvidesOverrides.php',
      __DIR__ . '/../Traits/ProvidesRepositories.php',
    ];
  }

  /**
   * Get the services provided by the provider.
   *
   * @return array
   */
  public function provides() {
    return [
      'talonon.ooops.operations.rdbms.create',
      'talonon.ooops.operations.rdbms.update',
      'talonon.ooops.operations.rdbms.delete',
      'talonon.ooops.operations.rdbms.get',
      'talonon.ooops.operations.rdbms.getList',
      'talonon.ooops.operations.overrides',
      'talonon.ooops.repositories',
      'talonon.ooops.dbcontext',
    ];
  }

  /**
   * Register the service provider.
   *
   * @return void
   */
  public function register() {
    $this->app->register(LazyLoaderProvider::class);
    $this->app->bind('talonon.ooops.dbcontext', DbContext::class);

    $this->app->singleton(
      'talonon.ooops.repositories', function () {
      return new Collection();
    });
    $this->app->singleton(
      'talonon.ooops.operations.overrides', function () {
      return new Collection();
    });
  }

  public function boot() {
    if (config('database.fetch') != \PDO::FETCH_ASSOC) {
      config(['database.fetch' => \PDO::FETCH_ASSOC]);
    }
    $this->publishes(
      [
        __DIR__ . '/../../config/config.php' => config_path('operations.php'),
      ]
    );
  }

}

