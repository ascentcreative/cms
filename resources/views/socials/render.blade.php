@foreach( app(AscentCreative\CMS\Settings\SiteSettings::class)->social_accounts as $account)

    @if($account['platform'] != null && $account['link'] != null)

        @includeFirst(['socials.item', 'cms::socials.item'], ['platform' => $account['platform'], 'link' => $account['link'] ])

    @endif

@endforeach
