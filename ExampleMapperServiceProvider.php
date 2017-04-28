<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * This is an example of a mapper service provider to put into the application in the app/Providers directory, it should
 * be called "MapperServiceProvider", but you can call it whatever you want as long as you put it in the providers list
 * with the appropriate name.  The "App" namespace should be changed based on your application's namespace if you are
 * using a custom one.
 *
 * You will need to add the following line (with some customization) to your app.php in the "providers" array:
 *
 * 'App\Providers\MapperServiceProvider',
 *
 * Remember if you change your "App" namespace, "App" will need to be changed. If you change the name of the service
 * provider class "MapperServiceProvider" should be changed above as well.
 */
class MapperServiceProvider extends ServiceProvider {
  /**
   * Defines the mappers for entities.
   *
   * @return void
   */
  public function register() {
    $this->app->singleton(
      'App\\Entities\\SomeClass.Mapper', function () {
      return new SomeClassMapper();
    });
  }

}
