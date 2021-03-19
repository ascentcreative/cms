<?php

namespace AscentCreative\CMS\Helpers;

class HeadTitle {

    private $_elements = array();

    public function __construct() {

        $this->_elements[] = config('app.name');

    }


    public static function add($val) {

        $inst = app(HeadTitle::class);

        $inst->_elements[] = $val;

        return $inst;

    }

    public function render($sep = ' - ') {

        $inst = app(HeadTitle::class);

        return join($sep, array_reverse($inst->_elements));

    }

}