<?php

Route::middleware(['web'])->namespace('AscentCreative\CMS\Controllers')->group(function () {

    Route::prefix('admin')->namespace('Admin')->middleware(['auth', 'can:administer'])->group(function() {

        
        Route::get('/', function() {

            if(view()->exists('admin.dashboard')) {
                return view('admin.dashboard');
            } else {
                return view('cms::admin.dashboard');
            }
            
        });

        Route::resource('/menus', MenuController::class);
        Route::resource('/menuitems', MenuItemController::class);
        Route::resource('/pages', PageController::class);


        Route::fallback(function () {
           return view('cms::admin.errors.404');
        });

    });

    Route::prefix('cms')->group(function() {

        Route::get('/bibleref/parse/{term}', [AscentCreative\CMS\Controllers\BibleRefController::class, 'parse']);

    });


});


/**
 * for pathless page routing, put this line at teh end of the App's web.php
 * 
 * Route::get('/{page:slug}', [AscentCreative\CMS\Controllers\PageController::class, 'show']);
 * 
 */


