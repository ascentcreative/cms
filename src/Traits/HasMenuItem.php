<?php

namespace AscentCreative\CMS\Traits;

use AscentCreative\CMS\Traits\BaseTrait;
use AscentCreative\CMS\Models\MenuItem;

use Illuminate\Http\Request;

trait HasMenuItem {

    use Extender;

    public function initializeHasMenuItem() {
        $this->fillable[] = '_menuitem';
    }

    /* define the relationship */
    public function menuitem() {
        return $this->morphOne(MenuItem::class, 'linkable');
    }


    public function captureMenuItem($key) {

        session([$key . '._menuitem' => $this->_menuitem]);

        unset($this->attributes['_menuitem']);

    }

    public function saveMenuItem($key) {

        $data = session()->pull($key . '._menuitem');

        if(!is_null($data)) {

            $item = $this->menuitem()->updateOrCreate([], ['menu_id'=>'1']);

            $context = MenuItem::find($data['context_id']); 
        
            $item->appendToNode($context);  

            $item->save();

        }

    }

    

}
