<?php 

namespace AscentCreative\CMS\Traits;

trait Extender {

    /**
     * 
     * To extend a model:
     * 
     * 1) Create a new Trait representing the relationship - convention is "Has[ForeignModel]". This trait must use 'Extender'
     * 
     * 2) The 'Initialize[TraitName]' method is called automatically by Eloquent Models. 
     * Use this to add the extender's fields to 'fillable' (so they can be filled en-masse)
     * Normally, use a single parent field like _foreignmodel, and arrayfield any constituent ones
     * 
     * 3) Create a boot[TraitName] function. Set up delete, saving and saved handlers:
     * 
     *   - Delete - deletes the foreign models on deletion of the extended model
     *   - Saving (Capture) - remove the _foreignmodel fields from the model and put in the session. Normally extenders._foreignmodel
     *   - Saved - The model has updated, so now we write the _foreignmodel fields to relevant model and link them up. Ensure data is PULLed from the session
     * 
     * 4) Maybe step 2 could be called by a 'created' handler instead?
     * 
     * 5) This trait auto-includes blades to add to the model's edit screens at 'admin.trait.[traitname]' and 'cms::trait.[traitname]'. 
     *      Other paths can be added to config/cms.php
     *      
     */


    protected $_requestedTraitBlades = [];

    public function getTraitBlades($trait=null) {

        if (!is_null($trait)) {

            $this->_requestedTraitBlades[] = strtolower($trait);

            $aryPaths = array();
            foreach(config('cms.traitbladepaths') as $path) {
                $aryPaths[] = $path . '.' . strtolower($trait);
            }

            return $aryPaths;

        } else {


            $blades = array();
            foreach(class_uses($this) as $trait) {

                if (array_search('AscentCreative\CMS\Traits\Extender', class_uses($trait)) !== false) {


                    $ary = explode('\\', $trait);
                    $basename = array_pop($ary);


                    if(array_search(strtolower($basename), $this->_requestedTraitBlades) === false) {

                        $aryPaths = array();
                        foreach(config('cms.traitbladepaths') as $path) {
                            $aryPaths[] = $path . '.' . strtolower($basename);
                        }

                        $blades[$basename] = $aryPaths;

                    }
                    
                }

            }

            return $blades;

        }

        

    }


    // probably need a function here to parse trait names etc
    private function getTraitFunction($fn, $trait) {

        $ary = explode('\\', $trait);

        $trait = array_pop($ary);
        
        // trait begins Has...
        $trimmed = substr($trait, 3);
        return $fn . $trimmed;

    }





}