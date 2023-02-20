<?php

namespace AscentCreative\CMS\Helpers;

class PackageAssets {

    private $_css = array();
    private $_js = array();

   

    public static function addStylesheet($val, $context='global') {

        $inst = app(PackageAssets::class);

        $inst->_css[$context][] = $val;

        return $inst;

    }

    public static function addScript($val, $context='global') {

        $inst = app(PackageAssets::class);

        $inst->_js[$context][] = $val;

        return $inst;

    }

    public static function getStylesheets($context='global') {

        $inst = app(PackageAssets::class);

        return $inst->_css[$context];

    }

    public static function getScripts($context='global') {

        $inst = app(PackageAssets::class);

        return $inst->_js[$context];

    }




}