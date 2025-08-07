<?php namespace Talonon\Ooops\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Talonon\LazyLoader\LazyLoaderProvider;
use Talonon\Ooops\Contexts\DbContext;
use Talonon\Ooops\Models\BaseGetMultipleParams;
use Talonon\Ooops\Models\BaseGetSingleParams;
use Talonon\Ooops\Models\Entity;
use Talonon\Ooops\Operations\RDBMS\CreateOperation;
use Talonon\Ooops\Operations\RDBMS\DeleteOperation;
use Talonon\Ooops\Operations\RDBMS\GetCountOperation;
use Talonon\Ooops\Operations\RDBMS\GetMultipleOperation;
use Talonon\Ooops\Operations\RDBMS\GetSingleOperation;
use Talonon\Ooops\Operations\RDBMS\UpdateOperation;

class CrudProvider extends ServiceProvider {

  /**
   * Indicates if loading of the provider is deferred.
   *
   * @var bool
   */
  protected $defer = false;

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
        'talonon.ooops.operations.rdbms.getCount',
    ];
  }

  /**
   * Register the service provider.
   *
   * @return void
   */
  public function register() {
      // Bind the generics
      $this->app->bind('talonon.ooops.operations.rdbms.create', function($app, $params) {
          return $this->Create(...$params);
      });
      $this->app->bind('talonon.ooops.operations.rdbms.update', function($app, $params) {
          return $this->Update(...$params);
      });
      $this->app->bind('talonon.ooops.operations.rdbms.delete', function($app, $params) {
          return $this->Delete(...$params);
      });
      $this->app->bind('talonon.ooops.operations.rdbms.get', function($app, $params) {
          $x = $this->GetSingle(...$params);
          return $x;
      });
    $this->app->bind('talonon.ooops.operations.rdbms.getList', function($app, $params) {
        return $this->GetMulti(...$params);
    });
      $this->app->bind('talonon.ooops.operations.rdbms.getCount', function($app, $params) {
         return  $this->GetCount(...$params);
      });
  }

  public function Create(DbContext $context, Entity $entity) {
      return new CreateOperation($context, $entity);
  }

    public function Update(DbContext $context, Entity $entity) {
        return new UpdateOperation($context, $entity);
    }

    public function Delete(DbContext $context, Entity $entity) {
        return new DeleteOperation($context, $entity);
    }

    public function GetSingle(DbContext $context, BaseGetSingleParams $params) {
        return new GetSingleOperation($context, $params);
    }

    public function GetMulti(DbContext $context, BaseGetMultipleParams $params) {
        return new GetMultipleOperation($context, $params);
    }

    public function GetCount(DbContext $context, BaseGetMultipleParams $params) {
       return new GetCountOperation($context, $params);
    }
}

