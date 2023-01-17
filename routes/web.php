<?php


Route::prefix('admin')->middleware(['web', 'auth', 'can:administer'])->group(function() {

    Route::get('/users/autocomplete', [config('cms.models.user-controller'), 'autocomplete']);
    Route::get('/users/{user}/delete', [config('cms.models.user-controller'), 'delete']);
    Route::resource('/users', config('cms.models.user-controller')); //AscentCreative\CMS\Facades\UserController::class);

});

Route::middleware(['web'])->namespace('AscentCreative\CMS\Controllers')->group(function () {


    Route::get('logintest', function() {
        echo 'ok';
    })->middleware('auth');


    Route::get('/longrunprogress', function() {
        // fake the progress for now
        $prog = session()->get('prog');
        if(!is_numeric($prog)) {
            $prog = 1;
        } else {
            $prog++;
        }

        session()->put('prog', $prog);

        return response()->json($prog);

    });

    Route::get('/lrptest', function() {
        return view('cms::lrptest');
    });

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

    /**
     * FULL TEXT SEARCH (Using Scout)
     */
    Route::get('/cmssearch',  'SearchController@search');


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


    Route::prefix('admin')->namespace('Admin')->middleware(['auth', 'can:administer'])->group(function() {

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



        /* Routes for HasMany component modal and validation */
        /* TODO - Move this routes to the Forms package... */

        // load modal - either empty or with data values for editing
        Route::get('/cms/components/hasmany/{package}/{source}/{target}/{fieldname}', function($package, $source, $target, $fieldname) {
            /* present the modal */
            // Not sure we need the source? would the dialog not be the same regardless of that (ini polymorphic sitautions?)
            //return view('admin.' . $source . '.hasmany.' . $target . '.modal');

            // dd($fieldname);

            // extract incoming data
            if(request()->$fieldname) {
                $idx = array_key_first(request()->$fieldname);
                $item = request()->$fieldname[$idx];
                $action = 'Edit';
            } else {
                $idx = '0';
                $item = [];
                $action = 'New';
            }

            // divert to specified blade if given
            $blade = request()->blade ?? "modal";
            
            $pkg = $package == 'app' ? '' : $package . '::';

            // return $pkg;

            // need to be able to specify which package holds the relevant view.
            return view($pkg . 'components.hasmany.' . $target . '.' . $blade, ['idx' =>  $idx, 'item' => (object) $item, 'action' => $action ] );
            
        })->name('cms.components.hasmany');


        Route::post('/cms/components/hasmany/{package}/{source}/{target}/{fieldname}', function($package, $source, $target, $fieldname) {
            /* validate modal data */
            $cls = session()->get('modelTableCache.' . $target);
            
            if(method_exists($cls, 'getRules')) {
                $inst = new $cls();
                $rules = $inst->getRules();
            } else {
                $rules = $cls::$rules;
            }
        
            $messages = $cls::$messages;
            Validator::make(request()->all(), $rules, $messages)->validate();

            /* If pass, return the new item to add to the field */
            /* Item = the data submitted (converted to an object for compatibility) */
            /* Name = the field name and a new unique index (replaced by a numeric ID on save) */
            /* Note - this doesn't actually create the new record in the database. The save process for the parent model needs to do that */
            //return view('admin.' . $source . '.hasmany.' . $target . '.item', ['item' => (object) request()->all(), 'name' => $target . '[' . uniqid() . ']']);

            // // Original Option: simple StdClass
            // $obj = (object) request()->all(); 
            // // doing it this way means that any extra attributes are set (id, relationship values)
            // // bypasses fillables etc as it's just an object not a model. 
            // // But, it's reliant on the item blade to convert it to a Model instance
            // // while handling the fact that when the parent form loads, the item will already be a Model instance...
            // // In that regard, maybe it should be converted to a model...
            

            // New Approach: Make a model instance and fill it?
            // NB - extender traits mean that the extended fields are fillable.
            // - although they themselves won't be models, so why do we bother using a model here?
            $obj = $cls::make(request()->all()); 
            
            // Need to set the ID as it's not normally fillable. 
            // Otherwise, an edited item will be treated as new and will break references
            $obj->id = request()->id; 

            // dump($obj);

            $pkg = $package == 'app' ? '' : $package . '::';

            // return $pkg;

            // need to be able to specify which package holds the relevant view.
            return view($pkg . 'components.hasmany.' . $target . '.item', ['item' => $obj, 'name' => $fieldname . '[' . request()->idx . ']', 'idx' => request()->idx]);

        })->name('cms.components.hasmany');


        // HasManyImages... 
        // need a route which accepts multiple files and returns a block for each?
        // or maybe this is a future enhancement?



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

        // log croppie data:
        activity()->withProperties(request()->all())->log('croppie-upload');

        $path = Storage::disk('public')->putFile(request()->destination, request()->file('payload'));

        $multiSizeImage = new Guizoxxv\LaravelMultiSizeImage\MultiSizeImage();
        $multiSizeImage->processImage($_SERVER['DOCUMENT_ROOT'] . '/storage/' . $path);

        return response()->json([
            'path' => '/storage/' . $path,
        ]);

    })->middleware('auth', 'can:upload-files');





    Route::post('/cms/ajaxupload', function() {

        $disk = request()->disk;
        $path = request()->path;
        $payload = request()->file('payload');

        $sanitise = $payload->getClientOriginalName();
        $sanitise = str_replace(array('?', '#', '/', '\\', ','), '', $sanitise);
        
        if ((bool) request()->preserveFilename) {
            $filepath = Storage::disk($disk)->putFileAs($path, $payload, $sanitise);
        } else {
            $filepath = Storage::disk($disk)->putFile($path, $payload);
        }
        
        $file = new AscentCreative\CMS\Models\File();
        $file->disk = $disk;
        $file->filepath = $filepath;
        $file->original_name = $sanitise; //$payload->getClientOriginalName();
        $file->save();
        return $file;


    })->middleware('auth', 'can:upload-files');


     // MultiStepForm Step Validation endpoint:
     Route::post('/msf-validate', function() {

        $input = [];
        parse_str(request()->input, $input);

        // dd($input);

        $validatorSetup = (array) json_decode(Crypt::decryptString(request()->validators)) ?? [];

        // loop through validators and check if any are classes:
        $validators = [];
        foreach((array) $validatorSetup['validators'] as $field=>$list) {
            $valAry = explode('|', $list);
            $valOut = [];
            foreach($valAry as $val) {
                if(substr($val, 0, 4) == 'new ') {
                    $cls = substr($val, 4);
                    $valOut[] = new $cls;
                } else {
                    $valOut[] = $val;
                }
               
            }
            $validators[$field] = $valOut;
        }


        
        Validator::validate(
                $input, 
                $validators ?? [],
                (array) $validatorSetup['messages'] ?? []
            );

        
    })->name('msf.validate');


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



