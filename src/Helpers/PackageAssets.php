<?php

namespace AscentCreative\CMS\Helpers;

class PackageAssets {

    private $_css = array();
    private $_js = array();

   

    public static function addStylesheet($val) {

        $inst = app(PackageAssets::class);

        $inst->_css[] = $val;

        return $inst;

    }

    public static function addScript($val) {

        $inst = app(PackageAssets::class);

        $inst->_js[] = $val;

        return $inst;

    }

    public static function getStylesheets() {

        $inst = app(PackageAssets::class);

        return $inst->_css;

    }

    public static function getScripts() {

        $inst = app(PackageAssets::class);

        return $inst->_js;

    }




}