<?php

namespace AscentCreative\CMS;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Schema;

use Illuminate\Routing\Router;
use Laravel\Fortify\Fortify;

use Laravel\Scout\EngineManager;

use Spatie\Activitylog\Models\Activity;

use AscentCreative\CMS\Helpers\HeadTitle;
use AscentCreative\CMS\Helpers\PackageAssets;
use AscentCreative\CMS\Helpers\AdminMenu;

use Jenssegers\Agent\Agent;

class CMSServiceProvider extends ServiceProvider
{
  public function register()
  {

    $this->app->register(\AscentCreative\CMS\Providers\EventServiceProvider::class);

    $this->app->register(\Jenssegers\Agent\AgentServiceProvider::class);

    //
    $this->app->singleton(HeadTitle::class, function() {
      return new HeadTitle();
    });

    $this->app->singleton(PackageAssets::class, function() {
        return new PackageAssets();
    });

    $this->app->singleton(AdminMenu::class, function() {
        return new AdminMenu();
      });


    $this->mergeConfigFrom(
        __DIR__.'/../config/cms.php', 'cms'
    );

    $this->mergeConfigFrom(
        __DIR__.'/../config/cms.models.php', 'cms.models'
    );

    $this->mergeConfigFrom(
        __DIR__.'/../config/multiSizeImage.php', 'multiSizeImage'
    );

    $this->mergeConfigFrom(
        __DIR__.'/../config/scout.php', 'scout'
    );


    /* Model facades */

    $aliases = array();

    $aliases['Agent'] = \Jenssegers\Agent\Facades\Agent::class;

    // For each model:
    // 1) Set up an alias for the Facade (allows Page::method() calls)
    $aliases['Page'] = \AscentCreative\CMS\Facades\PageFacade::class;

    // 2) resolve the key in getFacadeAccessor()
    $this->app->bind('page',function(){
        $cls = config('cms.models.page');
        return new $cls();
    });

    // 3) Use Interface/Implementation binding to allow TypeHinting to resolve the right class.
    $this->app->bind(\AscentCreative\CMS\Models\Page::class, $cls = config('cms.models.page'));


    $this->app->bind('menu',function(){
        $cls = config('cms.models.menu');
        return new $cls();
    });


    foreach(config('cms.models') as $key => $cls) {
        $this->app->bind($key, $cls);
    }

    // $this->app->bind('user-controller', function() {
    //     $cls = config('cms.controllers.user');
    //     return new $cls();
    // });


    // print_r(config('cms.models'));

    // \Illuminate\Database\Eloquent\Relations\Relation::morphMap(config('cms.models'));

    // bind the aliases...
    $loader = \Illuminate\Foundation\AliasLoader::getInstance($aliases);

    //this->bootAliases();

    $this->registerBlueprintMacros();

    $this->registerRelationMacros();

    $this->registerRouteMacros();

  }


  public function registerRelationMacros() {

       

  }


  public function registerBlueprintMacros() {


        \Illuminate\Database\Schema\Blueprint::macro('publishable', function() {
            if(!Schema::hasColumn($this->table, 'publishable')) {
                $this->boolean("publishable")->default(0)->index();
            }
            if(!Schema::hasColumn($this->table, 'publish_start')) {
                $this->datetime("publish_start")->nullable()->index();
            }
            if(!Schema::hasColumn($this->table, 'publish_end')) {
                $this->datetime("publish_end")->nullable()->index();
            }
        });

        \Illuminate\Database\Schema\Blueprint::macro('dropPublishable', function() {
            if(Schema::hasColumn($this->table,'publishable')) {
                $this->dropColumn('publishable');
            }
            if(Schema::hasColumn($this->table,'publish_start')) {
                $this->dropColumn('publish_start');
            }
            if(Schema::hasColumn($this->table,'publish_end')) {
                $this->dropColumn('publish_end');
            }
        });


  }


  /**
   * 
   * Route macros to allow sites to create utility routes
   * 
   * @return [type]
   */
  public function registerRouteMacros() {

    \Illuminate\Support\Facades\Route::macro('autocomplete', function($segment, $class, $label='title') {

        Route::match(['post','get'], '/autocomplete/' . $segment, function() use ($class, $label) {

            $term = request()->term;

            // $cls = new $class();
            $items = $class::autocomplete($term)->get();

            $items->transform(function($item) use ($label) {
                return [
                    'label' => $item->$label, // may need to accept a closure here...
                    'type' => get_class($item),
                    'id' => $item->id
                ];
            });

            return $items;

            

        })->name($segment . '.autocomplete');

    });

  }
 

  public function boot()
  {

    $this->bootFortify();

    // Register the helpers php file which includes convenience functions:
    require_once (__DIR__.'/Helpers/ascenthelpers.php');

    $this->bootDirectives();
    $this->bootComponents();
    $this->bootPublishes();

    $this->bootActivityLogging();
  

    $this->loadViewsFrom(__DIR__.'/../resources/views', 'cms');

    $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

    $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    $this->loadMigrationsFrom(__DIR__.'/../database/settings');

    $router = $this->app->make(Router::class);
    $router->aliasMiddleware('cms-nocache', \AscentCreative\CMS\Middleware\NoCache::class);

    $this->commands([
        \AscentCreative\CMS\Commands\CreateAdminUser::class,
        \AscentCreative\CMS\Commands\ObfuscateUserData::class,
        \AscentCreative\CMS\Commands\RefreshMultiSizeImages::class,
        \AscentCreative\CMS\Commands\ZendImportUsers::class,
    ]);

    // for web requests, work out what the menu item might be.
    if (!app()->runningInConsole()) {
        $this->resolveMenuItem();
    }
    

    if(env('LOG_QUERIES')) {
        \DB::listen(function ($query) {
            \Log::info($query->sql . ' - Bind: [' . join(', ', $query->bindings) . '] - Time: ' . $query->time);
       });   
    }


    resolve(EngineManager::class)->extend('ascent', function () {
        return new \AscentCreative\CMS\Engines\AscentEngine;
    });


    // x-litespeed file download response
    Response::macro('xlitespeed', function ($path) {
            
        set_time_limit(0);

        // the path can't be outside the document root.
        // it can however go into the doc root and then back out. 
        // so, replace the storage path with that maneouver.
        // feels like a fudge and is specific to this app structure...
        $path = str_replace(storage_path(''), $_SERVER['DOCUMENT_ROOT'] . '/..', $path);
        
        return Response::make()   
            ->header("X-LiteSpeed-Location", $path)
            // ->header("Content-type", mime_content_type($path))
            ->header("Content-Disposition", 'attachment; filename="' . basename($path) . '"');

    });
   


  }

  public function bootActivityLogging() {

    Activity::saving(function (Activity $activity) {

        $activity->properties = $activity->properties->put('session', session()->getId());
        $activity->properties = $activity->properties->put('ip', request()->ip());

        $agent = new Agent();
        if(isset($_SERVER['HTTP_USER_AGENT'])) {
            $activity->properties = $activity->properties->put('agent', $_SERVER['HTTP_USER_AGENT']);
        }
        $activity->properties = $activity->properties->put('robot', $agent->isRobot());
        
        
    });

    
  }


  /**
   * 
   */
  public function resolveMenuItem() {

    /**
     * do the logic here so it only executes once?
     * then pass it into the view composer
     */
   // $result = $model;

    $menuitem = \AscentCreative\CMS\Models\MenuItem::where('url', '/' . request()->path())->first();

    view()->composer('*', function ($view) use ($menuitem) {

        $view->with('menuitem', $menuitem);

    });

  }

  // fortify commands
  public function bootFortify() {

     

        // Override a couple of Fortify controllers as we want to 
        // return content in Json responses.
        $this->app->singleton(
            \Laravel\Fortify\Http\Controllers\ProfileInformationController::class, 
            \AscentCreative\CMS\Fortify\Controllers\ProfileInformationController::class);

        $this->app->singleton(
            \Laravel\Fortify\Http\Controllers\PasswordController::class, 
            \AscentCreative\CMS\Fortify\Controllers\PasswordController::class);

        // register new LoginResponse
        $this->app->singleton(
            \Laravel\Fortify\Contracts\RegisterResponse::class,
            \App\Http\Responses\RegisterResponse::class
            );

        $this->app->singleton(
            \Laravel\Fortify\Contracts\LoginResponse::class,
            \App\Http\Responses\LoginResponse::class
        );

        $this->app->singleton(
            \Laravel\Fortify\Contracts\LogoutResponse::class,
            \App\Http\Responses\LogoutResponse::class
        );

        // seperate login and register views


        Fortify::loginView(function () {
            try {
                return View::first(resolveAuthBladePaths('login'));
            } catch (\Exception $e) {
                abort(404);
            }
        });

        Fortify::registerView(function () {
            //return view('auth.register');
            try {
                return View::first(resolveAuthBladePaths('register'));
            } catch (\Exception $e) {
                abort(404);
            }
        });

        Fortify::requestPasswordResetLinkView(function () {
            // return view('auth.forgot-password');
            try {
                return View::first(resolveAuthBladePaths('forgot-password'));
            } catch (\Exception $e) {
                abort(404);
            }
        });

        Fortify::resetPasswordView(function ($request) {
            // return view('auth.reset-password', ['request' => $request]);
            try {
                return View::first(resolveAuthBladePaths('reset-password'), ['request' => $request]);
            } catch (\Exception $e) {
                abort(404);
            }
        });


    }

  // register the components
  public function bootComponents() {

    Blade::component('cms-multistepform', 'AscentCreative\CMS\View\Components\MultiStepForm');
    Blade::component('cms-multistepform-step', 'AscentCreative\CMS\View\Components\MultiStepForm\FormStep');

    Blade::component('cms-multisizeimage', 'AscentCreative\CMS\View\Components\Display\MultiSizeImage');

    Blade::component('cms-forms-structure-screenblock', 'AscentCreative\CMS\View\Components\Forms\Structure\Screenblock');


    //** Old - being phased out */
    
    Blade::component('cms-form-datetime', 'AscentCreative\CMS\View\Components\Form\DateTime');
    Blade::component('cms-form-code', 'AscentCreative\CMS\View\Components\Form\Code');
    Blade::component('cms-form-statictext', 'AscentCreative\CMS\View\Components\Form\StaticText');
  
    Blade::component('cms-form-ckeditor', 'AscentCreative\CMS\View\Components\Form\CKEditor');
    Blade::component('cms-form-autocomplete', 'AscentCreative\CMS\View\Components\Form\Autocomplete');
    
    Blade::component('cms-form-relatedtokens', 'AscentCreative\CMS\View\Components\Form\RelatedTokens');
    
    Blade::component('cms-form-biblereflist', 'AscentCreative\CMS\View\Components\Form\BibleRefList');

    Blade::component('cms-form-menuposition', 'AscentCreative\CMS\View\Components\Form\MenuPosition');
    Blade::component('cms-form-nestedset', 'AscentCreative\CMS\View\Components\Form\NestedSet');

    
    Blade::component('cms-form-videoembed', 'AscentCreative\CMS\View\Components\Form\VideoEmbed');


    Blade::component('cms-form-stack', 'AscentCreative\CMS\View\Components\Form\Stack');
    Blade::component('cms-form-stackblock', 'AscentCreative\CMS\View\Components\Form\StackBlock');
    Blade::component('cms-form-stackblock-rowitem', 'AscentCreative\CMS\View\Components\Form\StackBlock\RowItem');

    Blade::component('cms-modal', 'AscentCreative\CMS\View\Components\Modal');

  }


//   public function bootAliases() {

//     $loader = \Illuminate\Foundation\AliasLoader::getInstance(config('cms.aliases'));

//   }


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


    // Blade::directive('renderStack', function($content) {
    //     return view('cms::stack.render')->with('content', $content);
    // });

    //
  }

  

    public function bootPublishes() {

      $this->publishes([
        __DIR__.'/Assets' => public_path('vendor/ascent/cms'),
    
      ], 'public');

      $this->publishes([
        __DIR__.'/../config/cms.php' => config_path('cms.php'),
      ]);

      $this->publishes([
        __DIR__.'/../config/cms.models.php' => config_path('cms.models.php'),
      ]);

      $this->publishes([
        __DIR__.'/../config/multiSizeImage.php' => config_path('multiSizeImage.php'),
      ]);

      $this->publishes([
        __DIR__.'/../config/scout.php' => config_path('scout.php'),
      ]);


    }



}