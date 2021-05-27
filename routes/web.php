<?php


Route::middleware(['web'])->namespace('AscentCreative\CMS\Controllers')->group(function () {

    Route::get('/contact', 'ContactController@showform');
    Route::get('/contact/submit', 'ContactController@submit');
    Route::get('/contact/confirm', function() {
       return view('cms::public.contact.showconfirm');
    });


    Route::get('/admin/login', function() {
        return view('cms::auth.login');
    })->name('admin-login');

    Route::prefix('admin')->namespace('Admin')->middleware(['useAdminLogin', 'auth', 'can:administer'])->group(function() {

        Route::get('/phpinfo', function() {
            return phpinfo();
        });

        Route::get('/', function() {

            if(view()->exists('admin.dashboard')) {
                return view('admin.dashboard');
            } else {
                return view('cms::admin.dashboard');
            }
            
        });

        Route::resource('/menus', MenuController::class);

       

        Route::get('/settings', [AscentCreative\CMS\Controllers\Admin\SettingsController::class, 'edit'])->middleware('can:view-settings');
        Route::post('/settings', [AscentCreative\CMS\Controllers\Admin\SettingsController::class, 'store'])->middleware('can:change-settings');
        //Route::resource('/settings', SettingsController::class);

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



        Route::resource('/stacks', StackController::class);
        Route::post('/stacks/updateblockorder', [AscentCreative\CMS\Controllers\Admin\StackController::class, 'updateblockorder']);
        Route::get('/blocks/{block}/delete', [AscentCreative\CMS\Controllers\Admin\BlockController::class, 'delete']);
        Route::resource('/blocks', BlockController::class);



        /** Content Stack */
        Route::get('/stackblock/make/{type}/{name}/{key}', function($type, $name, $key) {
            return view('cms::stack.block.make')->with('type', $type)->with('name', $name)->with('key', $key)->with('value', null);
           // return view('cms::stack.block.' . $type . '.edit')->with('name', $name . '[' . $key . ']')->with('value', null);
        });
        Route::get('/stackblock/newitem/{type}/{name}/{cols}', function($type, $name, $cols) {
            return view('cms::stack.block.row.makeitem')->with('type', $type)->with('name', $name)->with('cols', $cols); //->with('key', $key)->with('value', null);
           // return view('cms::stack.block.' . $type . '.edit')->with('name', $name . '[' . $key . ']')->with('value', null);
        });


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


    Route::post('/cms/croppieupload', function() {

       $path = Storage::disk('public')->putFile(request()->destination, request()->file('payload'));

        return response()->json([
            'path' => '/storage/' . $path,
        ]);

    })->middleware('auth', 'can:uploadfiles');



    Route::post('/cms/ajaxupload', function() {

        $disk = request()->disk;
        $path = request()->path;
        $payload = request()->file('payload');
        
        if ((bool) request()->preserveFilename) {
            $filepath = Storage::disk($disk)->putFileAs($path, $payload, $payload->getClientOriginalName());
        } else {
            $filepath = Storage::disk($disk)->putFile($path, $payload);
        }
        
        $file = new AscentCreative\CMS\Models\File();
        $file->disk = $disk;
        $file->filepath = $filepath;
        $file->original_name = $payload->getClientOriginalName();
        $file->save();
        return $file;


    })->middleware('auth', 'can:uploadfiles');


});


/**
 * for pathless page routing, put this line at teh end of the App's web.php
 * 
 * Route::get('/{page:slug}', [AscentCreative\CMS\Controllers\PageController::class, 'show']);
 * 
 */


