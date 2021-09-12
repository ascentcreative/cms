<?php


Route::middleware(['web'])->namespace('AscentCreative\CMS\Controllers')->group(function () {


    /** 
     * HOMEPAGE Routing
     */
    Route::get('/', function () {

        // get 'homepage' and render it.

        $page_id = app(AscentCreative\CMS\Settings\SiteSettings::class)->homepage_id;
        $page = \AscentCreative\CMS\Models\Page::find($page_id); // <- the page flagged as homepage.
        if($page) {
            return app()->make(\AscentCreative\CMS\Controllers\PageController::class)->show($page);
        } else {
            return view('welcome');
        }
    
    })->name('homepage');


    //Route::get('/contact', 'ContactController@showform'); // not needed as form can be placed in stacked page
    Route::get('/contact/submit', 'ContactController@submit');
    Route::get('/contact/confirm', function() {

        $page_id = app(AscentCreative\CMS\Settings\SiteSettings::class)->contact_confirm_page_id;
        $page = \AscentCreative\CMS\Models\Page::find($page_id); // <- the page flagged as homepage.
        if($page) {
            return app()->make(\AscentCreative\CMS\Controllers\PageController::class)->show($page);
        } else {
            return view('cms::public.contact.showconfirm');
        }

       
    });


    Route::get('/admin/login', function() {
        return view('cms::auth.login');
    })->name('admin-login');


    Route::prefix('admin')->namespace('Admin')->middleware(['useAdminLogin', 'auth', 'can:administer'])->group(function() {

        Route::get('/phpinfo', function() {
            phpinfo();
        });
  
        Route::match(['post', 'put'], '/previewtest', function() {

            // set the preview flag - used in some model traits to decide how to fetch the data
            // also causes "HeadTitle" to prepend a preview lable to the page title
            request()->isPreview = true;


            // Create an in-memory copy of the model using the POSTed/PUTed data
            // (Currently hardcoded to Page, but need to somehow detect the desired model and target controller / view)
            $page = new AscentCreative\CMS\Models\Page();
            $page->fill(request()->all());
            $contr = App::make('AscentCreative\CMS\Controllers\PageController');
            return $contr->show($page, true);


        });


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

       
      
        Route::get('/settings', [AscentCreative\CMS\Controllers\Admin\SettingsController::class, 'edit'])->middleware('can:change-settings');
        Route::post('/settings', [AscentCreative\CMS\Controllers\Admin\SettingsController::class, 'store'])->middleware('can:change-settings');
      
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


        Route::get('/stacks/{stack}/delete', [AscentCreative\CMS\Controllers\Admin\StackController::class, 'delete']);
        Route::resource('/stacks', StackController::class);
        Route::post('/stacks/updateblockorder', [AscentCreative\CMS\Controllers\Admin\StackController::class, 'updateblockorder']);
        

        Route::get('/blocks/{block}/delete', [AscentCreative\CMS\Controllers\Admin\BlockController::class, 'delete']);
        Route::resource('/blocks', BlockController::class);

        Route::get('/sitebanners/{sitebanner}/delete', [AscentCreative\CMS\Controllers\Admin\SiteBannerController::class, 'delete']);
        Route::resource('/sitebanners', SiteBannerController::class);

        Route::get('/savefilters', function() { 
            return view('cms::admin.savedfilters.modal.create'); //->with('batches', $batches );
        })->name('savefilters');

        Route::resource('savedfilters', SavedFiltersController::class, [
            'names' => [
                'store' => 'savedfilters.create',
            ]
        ]);

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

        Route::post('/video-embed/render', function() {
            return embedVideo(request()->url);
        });

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

    })->middleware('auth', 'can:upload-files');



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


    })->middleware('auth', 'can:upload-files');


});



Route::get('/cms/welcomeemail/{order}', function (\App\Models\User $user) {

    $mail = new AscentCreative\CMS\Notifications\WelcomeEmailNotification($user);
    return $mail->toMail('a@b.com');

});

/**
 * for pathless page routing, put this line at teh end of the App's web.php
 * 
 * Route::get('/{page:slug}', [AscentCreative\CMS\Controllers\PageController::class, 'show']);
 * 
 */



