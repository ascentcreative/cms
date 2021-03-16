<?php 

namespace AscentCreative\CMS\Traits;

trait Extender {



    public function save(array $options = []) {

        // create a unique identifier
        // we're going to dump the incoming Trait data into the session so the model itself can save safely
        $sessionid = uniqid();

        foreach(class_uses($this) as $trait) {

            // chuck all the incoming data into the session...
            if (array_search('AscentCreative\CMS\Traits\Extender', class_uses($trait)) !== false) {
                $fn = $this->getTraitFunction('capture', $trait);
                $this->$fn($sessionid);
            }

        }

        // Save the model
        parent::save($options);

     //   dd(session()->all());

        // Ok, now the model's been saved, we can associate the data from the session
        foreach(class_uses($this) as $trait) {

            // grab all the data back from the session and create the associated models
            if (array_search('AscentCreative\CMS\Traits\Extender', class_uses($trait)) !== false) {
                $fn = $this->getTraitFunction('save', $trait);
                $this->$fn($sessionid);
            }

        }
        //dd(session()->all());

        // finally, kill off that data. Let's not leave it lying around in the session
        session()->pull($sessionid);

    }


    public function getTraitBlades() {

        $blades = array();
        foreach(class_uses($this) as $trait) {

            // chuck all the incoming data into the session...
            if (array_search('AscentCreative\CMS\Traits\Extender', class_uses($trait)) !== false) {

                $ary = explode('\\', $trait);
                $basename = array_pop($ary);
                $blades[] = 'cms::trait.' . strtolower($basename);
                
            }

        }

        return $blades;

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