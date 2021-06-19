<?php

namespace AscentCreative\CMS\Settings;

use Spatie\LaravelSettings\Settings;

class SiteSettings extends Settings
{

    /* main / org schema */
    public string $site_name;

    // public string $org_name;
    // public string $org_address;
    // //public string


    // public ?string $social_facebook;
    // public ?string $social_twitter;
    // public ?string $social_instagram;
    // public ?string $social_youtube;
    // public ?string $social_linkedin;


    /* misc */
    public ?string $custom_head_tags;


    /* contact settings */
    public string $contact_from_name;
    public string $contact_from_address;
    public string $contact_to_addresses;
    public float $contact_recaptcha_threshold;


    
    public static function group(): string
    {
        return 'cms';
    }

}