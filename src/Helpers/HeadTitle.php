<?php

namespace AscentCreative\CMS\Helpers;

class HeadTitle {

    private $_elements = array();

    public function __construct() {

        // this line is a test for spatie/laravel-settings
        $this->_elements[] = app(\AscentCreative\CMS\Settings\SiteSettings::class)->site_name ?? config('app.name');
        
        //$this->_elements[] = config('app.name');

    }
    

    public static function rebase($val) {
        $inst = app(HeadTitle::class);
        $inst->_elements[0] = $val;
        return $inst;
    }

    public static function add($val) {

        $inst = app(HeadTitle::class);

        $inst->_elements[] = $val;

        return $inst;

    }

    public function render($sep = ' - ') {

        $inst = app(HeadTitle::class);

        $ary = array_reverse($inst->_elements);
        if (request()->isPreview) {
            array_unshift($ary, '[PREVIEW]');
        }

        return join($sep, $ary);

    }

}