<?php namespace Talonon\Ooops\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Talonon\Ooops\Contexts\DbContext;
use Talonon\Ooops\Operations\RDBMS\CreateOperation;
use Talonon\Ooops\Operations\RDBMS\DeleteOperation;
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

  /**
   * Register the service provider.
   *
   * @return void
   */
  public function register() {
    app()->bind('talonon.ooops.dbcontext', DbContext::class);

    app()->singleton(
      'talonon.ooops.repositories', function () {
      return new Collection();
    });
    app()->singleton(
      'talonon.ooops.operations.overrides', function () {
      return new Collection();
    });


    // Bind the generics
    app()->bind('talonon.ooops.operations.rdbms.create', CreateOperation::class);
    app()->bind('talonon.ooops.operations.rdbms.update', UpdateOperation::class);
    app()->bind('talonon.ooops.operations.rdbms.delete', DeleteOperation::class);
    app()->bind('talonon.ooops.operations.rdbms.get', GetSingleOperation::class);
    app()->bind('talonon.ooops.operations.rdbms.getList', GetMultipleOperation::class);


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

}

