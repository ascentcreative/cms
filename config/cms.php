<?php

return [

    'wrapper_blade' => env('CMS_WRAPPER_BLADE', 'base'),
    'wrapper_blade_section' => env('CMS_WRAPPER_BLADE_SECTION', 'pagebody'),
 
    'page_wrapper_blade' => env('CMS_PAGE_WRAPPER_BLADE', 'cms.page.show'),

    // list of paths to try for Model Extender trait blades. Will be checked in the order specified.
    'traitbladepaths' => ['admin.trait', 'cms::trait', 'geo::trait', 'charts::trait'],

    // recaptcha keys
    'recaptcha_sitekey' => env('RECAPTCHA_SITEKEY', ''), //6Lf_PYsaAAAAANe6Uv_tzWjLVO-qwgfC9WWKkQ2u'),
    'recaptcha_secret' => env('RECAPTCHA_SECRET', ''), //6Lf_PYsaAAAAAAm5qVKdE95rI3YYc7yMSzY3ce0U'),
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


    'theme_stylesheets' => [
        "/vendor/ascent/cms/css/bootstrap.min.css",
        // @style('/css/bootstrap_custom.css')
        "https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css",
        "/vendor/ascent/cms/js/jquery-ui.min.css",
        '/vendor/ascent/cms/dist/css/ascent-cms-bundle.css',
        '/vendor/ascent/forms/dist/css/ascent-forms-bundle.css',
        '/css/screen.css',
    ],

    'theme_scripts' => [


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
