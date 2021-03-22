<?php

return [

    'wrapper_blade' => env('CMS_WRAPPER_BLADE', 'base'),
    'wrapper_blade_section' => env('CMS_WRAPPER_BLADE_SECTION', 'pagebody'),
 

    // list of paths to try for Model Extender trait blades. Will be checked in the order specified.
    'traitbladepaths' => ['admin.trait', 'cms::trait']


];
