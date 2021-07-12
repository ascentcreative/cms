<?php

namespace AscentCreative\CMS\Settings;

use Spatie\LaravelSettings\Settings;

class SiteSettings extends Settings
{

    /* main / org schema */
    public string $site_name;

    public ?string $favicon;

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
    public ?string $custom_body_tags_start;
    public ?string $custom_body_tags_end;


    /* contact settings */
    public ?string $contact_from_name;
    public ?string $contact_from_address;
    public ?string $contact_to_addresses;
    public ?float $contact_recaptcha_threshold;



    public ?string $welcome_email_subject;
    public ?string $welcome_email_content;

    
    public static function group(): string
    {
        return 'cms';
    }

}