<?php

namespace AscentCreative\CMS;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;


class CMSServiceProvider extends ServiceProvider
{
  public function register()
  {
    //

  }

  public function boot()
  {
    // Register the helpers php file which includes convenience functions:
    require_once (__DIR__.'/Helpers/ascenthelpers.php');


    $this->bootDirectives();
    $this->bootComponents();
    $this->bootPublishes();

    $this->loadViewsFrom(__DIR__.'/resources/views', 'cms');

    

  }

  // register the components
  public function bootComponents() {

      Blade::component('cms-form', 'AscentCreative\CMS\View\Components\Form');
      Blade::component('cms-form-input', 'AscentCreative\CMS\View\Components\Form\Input');
      Blade::component('cms-form-ckeditor', 'AscentCreative\CMS\View\Components\Form\CKEditor');


  }




  // create custom / convenience Blade @Directives 
  public function bootDirectives() {


    Blade::directive('script', function ($file) {
      return "<SCRIPT src=" . autoVersion($file) . "></SCRIPT>";
    });

    Blade::directive('style', function ($file) {
      return "<LINK rel=\"stylesheet\" href=\"" . autoVersion($file) . "\"/>";
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

    }



}