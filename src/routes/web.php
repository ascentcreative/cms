<?php

Route::middleware(['web'])->namespace('AscentCreative\CMS\Controllers')->group(function () {

    Route::get('/contact', 'ContactController@showform');
    Route::get('/contact/submit', 'ContactController@submit');
    Route::get('/contact/confirm', function() {
       return view('cms::public.contact.showconfirm');
    });

    Route::prefix('admin')->namespace('Admin')->middleware(['auth', 'can:administer'])->group(function() {

        
        Route::get('/', function() {

            if(view()->exists('admin.dashboard')) {
                return view('admin.dashboard');
            } else {
                return view('cms::admin.dashboard');
            }
            
        });

        Route::resource('/menus', MenuController::class);

        Route::resource('/settings', SettingsController::class);

        Route::get('/menuitems/{menuitem}/delete', [AscentCreative\CMS\Controllers\Admin\MenuItemController::class, 'delete']);
        Route::resource('/menuitems', MenuItemController::class);

        Route::get('/pages/{page}/delete', [AscentCreative\CMS\Controllers\Admin\PageController::class, 'delete']);
        Route::resource('/pages', PageController::class);
       

        Route::get('/users/{user}/delete', [AscentCreative\CMS\Controllers\Admin\UserController::class, 'delete']);
        Route::resource('/users', UserController::class);

        Route::get('/roles/{role}/delete', [AscentCreative\CMS\Controllers\Admin\RoleController::class, 'delete']);
        Route::resource('/roles', RoleController::class);

        Route::get('/permissions/{permission}/delete', [AscentCreative\CMS\Controllers\Admin\PermissionController::class, 'delete']);
        Route::resource('/permissions', PermissionController::class);


        Route::fallback(function () {
           return view('cms::admin.errors.404');
        });

    });

    Route::prefix('cms')->group(function() {

        Route::get('/bibleref/parse/{term}', [AscentCreative\CMS\Controllers\BibleRefController::class, 'parse']);

    });

    Route::get('/modal/{path}', function($path) {

        return view($path); // assumed to extend cms::modal blade

    });

    Route::get('/modal/{namespace}/{path}', function($namespace, $path) {

        return view($namespace . '::' . $path); // assumed to extend cms::modal blade

    });


});


/**
 * for pathless page routing, put this line at teh end of the App's web.php
 * 
 * Route::get('/{page:slug}', [AscentCreative\CMS\Controllers\PageController::class, 'show']);
 * 
 */


