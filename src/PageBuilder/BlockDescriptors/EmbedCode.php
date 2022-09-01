<?php

namespace AscentCreative\CMS\PageBuilder\BlockDescriptors;

use AscentCreative\PageBuilder\BlockDescriptors\AbstractDescriptor; 

class EmbedCode extends AbstractDescriptor { 

    public static $name = 'Embedded Third-Party Code';

    public static $bladePath = 'embed-code';

    public static $description = "Paste in 'Embed Code' supplied by a third party website";

    public static $category = "Integration";

}