<?php

namespace AscentCreative\CMS\Traits;

use AscentCreative\CMS\Traits\BaseTrait;
use AscentCreative\CMS\Models\MenuItem;

use Illuminate\Http\Request;

trait HasMenuItem {

    use Extender;

    public static function bootHasMenuItem() {
  
      static::deleted(function ($model) {
        $model->deleteMenuItem();
      });

      static::saving(function($model) { 
        $model->captureMenuItem();
      });

      static::saved(function($model) { 
        $model->savedMenuItem();
      });

    }

    public function initializeHasMenuItem() {
        $this->fillable[] = '_menuitem';
    }

    /* define the relationship */
    public function menuitem() {

        return $this->morphOne(MenuItem::class, 'linkable');
    }


    public function captureMenuItem() {

        echo 'pre save';

        session(['extenders._menuitem' => $this->_menuitem]);
        unset($this->attributes['_menuitem']);     
       
    }

    public function savedMenuItem() {
        echo 'done save...';

        $data = session()->pull('extenders._menuitem');

        if(!is_null($data)) {

            if (is_null($data['menu_id'])) {

                $item = $this->menuitem; 
                if($item) {
                    $item->delete();
                }
                
            } else {

                $item = $this->menuitem;
                
                if ($item && $item->menu_id != $data['menu_id']) {
                    $item->delete();
                    $item = null;
                } 

                if (is_null($item)) {
                    $item = $this->menuitem()->updateOrCreate([], ['menu_id'=>$data['menu_id']] );
                }
                
               

                $item->title = $data['title'];

                $context = MenuItem::find($data['context_id']); 

                if ($context) {

                    switch($data['context_type']) {
                        case 'first-child':
                            $item->prependToNode($context);
                            break;
                        case 'before':
                            $item->beforeNode($context);
                            break;
                        case 'after':
                            $item->afterNode($context);
                            break;
                    }

                } 

                $item->save();

            }

        }

    }

    public function saveMenuItem($key) {
        
        echo 'in Save';

        $data = session()->pull($key . '._menuitem');

        //dd($data);

        // if(!is_null($data)) {

        //     if (is_null($data['menu_id'])) {

        //         $item = $this->menuitem; 
        //         $item->delete();

        //     } else {

        //         $item = $this->menuitem;
                
        //         if ($item && $item->menu_id != $data['menu_id']) {
        //             $item->delete();
        //             $item = null;
        //         } 

        //         if (is_null($item)) {
        //             $item = $this->menuitem()->updateOrCreate([], ['menu_id'=>$data['menu_id']] );
        //         }
                
               

        //         $item->title = $this->title;

        //         $context = MenuItem::find($data['context_id']); 

        //         if ($context) {

        //             switch($data['context_type']) {
        //                 case 'first-child':
        //                     $item->prependToNode($context);
        //                     break;
        //                 case 'before':
        //                     $item->beforeNode($context);
        //                     break;
        //                 case 'after':
        //                     $item->afterNode($context);
        //                     break;
        //             }

        //         } 

        //         $item->save();

        //     }

        // }

    }


    protected function deleteMenuItem() {
        
        $item = $this->menuitem;

        if (!is_null($item)) {
            $item->delete();
        }
        
    }

    

}
