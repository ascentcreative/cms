<?php 

namespace AscentCreative\CMS\Traits;

trait Extender {

    private $extender_captured = [];
    private $capturable = [];
    private $captureDeleteCallbacks = [];

    /**
     * 
     * To extend a model:
     * 
     * 1) Create a new Trait representing the relationship - convention is "Has[ForeignModel]". This trait must use 'Extender'
     * 
     * 2) The 'Initialize[TraitName]' method is called automatically by Eloquent Models. 
     * 
     * Use this to add the field as 'capturable': 
     *      public function initializeFieldName {
     *          $this->addCapturable('fieldName');
     *      }
     * 
     * This adds the field to the model's fillable, but also to the list of fields to intercept before they hit the database
     * 
     * It also (by default) registers "deleteFieldName" as the method to call on deletion of the model to remove related records
     * This function name can be override as a 2nd parameter to addCapturable
     * 
     *      $this->addCapturable('fieldName', 'customFunction');
     *      (I suppose this should also be Closureable? Not implemented yet...)
     * 
     * The deletion registration can be overridden by passing 'false' as the 2nd param:
     * 
     *      $this->addCapturable('fieldName', false);
     * 
     * 
     * 3) Optional - add a method to determine if the data should be captured. If this needs any custom logic,
     *    define a canCaptureFieldName() function which returns a boolean. This will be called instead.
     * 
     * 
     * 
     * 3) Create a method to call when saving the model. This should be:
     * 
     *  public function saveFieldName($data) {
     *          ....
     *  }
     * 
     *  $data is the captured value for the field. This method should define how to store the data to the database.
     * 
     * 
     * 4) If the field needs to show on the form (likely), then you can add:
     * 
     *  public function adjustFormForFieldName($form) {
     *          ....
     *  }
     * 
     *  This function is given a $form object - the function can manipulate the structure of the form to pass in the required field elements.
     * 
     *   
     * 
     * 
     * 
     * 5) OLD>>> This trait auto-includes blades to add to the model's edit screens at 'admin.trait.[traitname]' and 'cms::trait.[traitname]'. 
     *      Other paths can be added to config/cms.php
     *      
     */

    // New code - uses code on the trait itself to adjust the form
    public function addModelTraitsToForm($form) {

        foreach(class_uses($this) as $trait) {
            if (array_search('AscentCreative\CMS\Traits\Extender', class_uses($trait)) !== false) {
                $fn = $this->getTraitFunction('adjustFormFor', $trait);
                if(method_exists($this, $fn)) {
                    $this->$fn($form);
                }
            }
        }

    }


    /**
     * Eloquent model event handlers:
     * 
     * @return [type]
     */
    public static function bootExtender() {

        // before save, capture any eligible data so it doesn't hit the DB with the main model record
        static::saving(function ($model) {
            // dump('saving extender');
            foreach($model->capturable as $field) {
               
                $method = 'canCapture' . ucfirst($field);
                if(method_exists($model, $method)) {
                    $canCapture = $model->$method();
                } else {
                    $canCapture = $model->canCapture($field);
                }

                if($canCapture) {
                    $model->capture($field);
                }

            }
        });

        // after save, call the trait functions to store the extended data
        static::saved(function($model) { 

           foreach(array_keys($model->extender_captured) as $key) {
                $method = 'save' . ucfirst($key);
                if(method_exists($model, $method)) {
                     $model->$method($model->getCapture($key));
                    //  $model->save
                } else {
                    throw new \Exception('Extender method ' . $method . ' not found - data may be lost');
                }
            }

        });


        // when the model is deleted, perform any required deletions.
        static::deleted(function ($model) {
            foreach($model->captureDeleteCallbacks as $method) {
                $model->$method();
            }
        });

    }


    /**
     * Register a field name for data capture, and optionally a delete callback too.
     * 
     * @param mixed $field
     * @param mixed $deleteFunction=true
     * 
     * @return [type]
     */
    public function addCapturable($field, $deleteFunction=true) {
        $this->fillable[] = $field;
        $this->capturable[] = $field;

        $fn = '';
        if(is_string($deleteFunction)) {
            $fn = $deleteFunction;
        } else if($deleteFunction) {
            $fn = 'delete' . ucfirst($field);
        }

        if($fn) {
            if(method_exists($this, $fn)) {
                $this->captureDeleteCallbacks[] = $fn;
            } else {
                throw new \Exception('Unable to register delete callback "' . $fn . '" - Method not found');
            }
        }

    }

    /**
     * Determine if the data exists to be captured
     * (note, a custom callback on the trait - canCaptureFieldName() - may override this functionality)
     * 
     * @param mixed $field
     * 
     * @return [type]
     */
    public function canCapture($field) {
        return array_key_exists($field, $this->getAttributes()) !== false;
    }

    /**
     * Determine whether data for a field was captured
     * 
     * @param mixed $field
     * 
     * @return [type]
     */
    public function hasCapture($field) {
        return array_key_exists($field, $this->extender_captured) !== false;
    }


    /**
     * Perform the capture of the data
     * 
     * @param mixed $field
     * 
     * @return [type]
     */
    public function capture($field) {
        $this->extender_captured[$field] = $this->$field;
        unset($this->attributes[$field]);
    }

    /**
     * Retrieve the captured data
     * 
     * @param mixed $field
     * 
     * @return [type]
     */
    public function getCapture($field) {
        return $this->extender_captured[$field];
    }



    // Below = Old code which used blades to insert trait fields


    protected $_requestedTraitBlades = [];

    public function getTraitBlades($trait=null, $key=null) {

        if (!is_null($trait)) {

            // only return the blade if the Model actually uses the trait.
            // currently, code will resolve the trait name and return the blades (and their data then won't be saved)

            // however, we also need to recurse the model's ancestry to get and check against all traits... 
           
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

                        $this->_requestedTraitBlades[] = strtolower($basename);

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