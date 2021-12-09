<?php

namespace AscentCreative\CMS\StackEditor\TypeDescriptors;

use AscentCreative\StackEditor\TypeDescriptors\AbstractDescriptor; 

class InstagramFeed extends AbstractDescriptor { 

    public static $name = 'Instagram Feed';

    public static $bladePath = 'instagram-feed';

    public static $description = "Embed an instagram feed (requires authentication with the target account)";

    public static $category = "Integration";

}