<?php

namespace AscentCreative\CMS\Settings;

use Spatie\LaravelSettings\Settings;

class SiteSettings extends Settings
{

    /* main / org schema */
    public string $site_name;

    public ?string $favicon;


    public ?int $homepage_id;

    // public string $org_name;
    // public string $org_address;
    // //public string


    /* Array of social media accounts */
    public ?array $social_accounts;

    /* misc */
    public ?string $custom_head_tags;
    public ?string $custom_body_tags_start;
    public ?string $custom_body_tags_end;

    /* contact settings */
    public ?string $contact_from_name;
    public ?string $contact_from_address;
    public ?string $contact_to_addresses;
    public ?float $contact_recaptcha_threshold;
    public ?float $contact_confirm_page_id;

    public ?string $welcome_email_subject;
    public ?string $welcome_email_content;

    
    public static function group(): string
    {
        return 'cms';
    }

}