<?php

return [

    'wrapper_blade' => env('CMS_WRAPPER_BLADE', 'base'),
    'wrapper_blade_section' => env('CMS_WRAPPER_BLADE_SECTION', 'pagebody'),
 
    'page_wrapper_blade' => env('CMS_PAGE_WRAPPER_BLADE', 'cms.page.show'),

    // list of paths to try for Model Extender trait blades. Will be checked in the order specified.
    'traitbladepaths' => ['admin.trait', 'cms::trait', 'geo::trait', 'charts::trait'],

    // recaptcha keys
    'recaptcha_sitekey' => env('RECAPTCHA_SITEKEY', ''), 
    'recaptcha_secret' => env('RECAPTCHA_SECRET', ''), 
    'recaptcha_threshold' => env('RECAPTCHA_THRESHOLD', 0.5),

    // content editor
    'content_editor' => 'ckeditor',

    'aliases' => [

        'Page' => AscentCreative\CMS\Facades\PageFacade::class,

    ],

    'core_page_blocks' => [
        
        'page-header' => 'Page Header',
        'contact-form' => 'Contact Form',
        'embed-code' => 'Embedded Third-Party Code',
        'instagram-feed' => 'Instagram Feed',
        // 'image-gallery' => 'Image Gallery',

    ],

    'custom_page_blocks' => [



    ],



    /**
     * CONTACT FORM SETTINGS
     */
    'contact' => [
        'notify' => ['kieran@ascent-creative.co.uk']
    ],
    


    /**
     * AUTH view path config
     */
    // 'authpaths' => [
    //     '' => 'auth',
    //     '/admin' => ['admin.auth', 'cms::auth'],
    // ],


    /**
     * Social Media Account options:
     */
    'socialplatforms' => [
        
        'facebook' => [
            'url' => 'https://facebook.com/',
            'longname' => 'Facebook',
            'shortname' => 'fb',
        ],
        'instagram' => [
            'url' => 'https://instagram.com/',
            'longname' => 'Instagram',
            'shortname' => 'ig',
        ],
        'twitter' => [
            'url' => 'https://twitter.com/',
            'longname' => 'Twitter',
            'shortname' => 'tw',
        ],
        'youtube' => [
            'url' => 'https://youtube.com/',
            'longname' => 'YouTube',
            'shortname' => 'yt',
        ],
        'linkedin' => [
            'url' => 'https://linkedin.com/',
            'longname' => 'LinkedIn',
            'shortname' => 'li',
        ],

    ],


];
