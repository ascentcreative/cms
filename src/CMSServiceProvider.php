<?php

namespace AscentCreative\CMS;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Routing\Router;

use AscentCreative\CMS\Helpers\HeadTitle;
use AscentCreative\CMS\Helpers\AdminMenu;

class CMSServiceProvider extends ServiceProvider
{
  public function register()
  {
    //
    $this->app->singleton(HeadTitle::class, function() {
      return new HeadTitle();
    });

    $this->app->singleton(AdminMenu::class, function() {
        return new AdminMenu();
      });


    $this->mergeConfigFrom(
        __DIR__.'/config/cms.php', 'cms'
    );

  }

  public function boot()
  {
    // Register the helpers php file which includes convenience functions:
    require_once (__DIR__.'/Helpers/ascenthelpers.php');

    $this->bootDirectives();
    $this->bootComponents();
    $this->bootPublishes();

    $this->loadViewsFrom(__DIR__.'/resources/views', 'cms');

    $this->loadRoutesFrom(__DIR__.'/routes/web.php');

    $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

    $router = $this->app->make(Router::class);
    $router->aliasMiddleware('cms-nocache', \AscentCreative\CMS\Middleware\NoCache::class);
    
  }

  // register the components
  public function bootComponents() {

    Blade::component('cms-form', 'AscentCreative\CMS\View\Components\Form');
    Blade::component('cms-form-input', 'AscentCreative\CMS\View\Components\Form\Input');
    Blade::component('cms-form-button', 'AscentCreative\CMS\View\Components\Form\Button');
    Blade::component('cms-form-checkbox', 'AscentCreative\CMS\View\Components\Form\Checkbox');
    Blade::component('cms-form-textarea', 'AscentCreative\CMS\View\Components\Form\Textarea');

    Blade::component('cms-form-ckeditor', 'AscentCreative\CMS\View\Components\Form\CKEditor');
    Blade::component('cms-form-foreignkeyselect', 'AscentCreative\CMS\View\Components\Form\ForeignKeySelect');
    Blade::component('cms-form-blockselect', 'AscentCreative\CMS\View\Components\Form\BlockSelect');
    
    Blade::component('cms-form-pivotlist', 'AscentCreative\CMS\View\Components\Form\PivotList');
    Blade::component('cms-form-biblereflist', 'AscentCreative\CMS\View\Components\Form\BibleRefList');

    Blade::component('cms-form-menuposition', 'AscentCreative\CMS\View\Components\Form\MenuPosition');
    Blade::component('cms-form-nestedset', 'AscentCreative\CMS\View\Components\Form\NestedSet');


  }




  // create custom / convenience Blade @Directives 
  public function bootDirectives() {


    Blade::directive('script', function ($file, $min=true) {
      return '<SCRIPT src="<?php echo autoVersion(' . $file . ', ' . $min . '); ?>"></SCRIPT>';
    });

    Blade::directive('style', function ($file) {
      return '<LINK rel="stylesheet" href="<?php echo autoVersion(' . $file . '); ?>"/>';
    });

    Blade::directive('autoVersion', function($file){
      return autoVersion($file);
    });

    Blade::directive('controller', function(){
      return controller();
    });

    //
  }

  

    public function bootPublishes() {

      $this->publishes([
        __DIR__.'/Assets' => public_path('vendor/ascent/cms'),
    
      ], 'public');

      $this->publishes([
        __DIR__.'/config/cms.php' => config_path('cms.php'),
      ]);

    }



}