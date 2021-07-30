<?php

return [

    'wrapper_blade' => env('CMS_WRAPPER_BLADE', 'base'),
    'wrapper_blade_section' => env('CMS_WRAPPER_BLADE_SECTION', 'pagebody'),
 
    'page_wrapper_blade' => env('CMS_PAGE_WRAPPER_BLADE', 'cms.page.show'),

    // list of paths to try for Model Extender trait blades. Will be checked in the order specified.
    'traitbladepaths' => ['admin.trait', 'cms::trait'],

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

    ],

    'custom_page_blocks' => [



    ],



    /**
     * CONTACT FORM SETTINGS
     */
    'contact' => [
        'notify' => ['kieran@ascent-creative.co.uk']
    ],

];
