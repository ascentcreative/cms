<?php

namespace AscentCreative\CMS\PageBuilder\BlockDescriptors;

use AscentCreative\PageBuilder\BlockDescriptors\AbstractDescriptor; 
use Illuminate\Database\Eloquent\Model;

class EmbedCode extends AbstractDescriptor { 

    public static $name = 'Embedded Third-Party Code';

    public static $bladePath = 'embed-code';

    public static $description = "Paste in 'Embed Code' supplied by a third party website";

    public static $category = "Integration";

    public function extractText(Model $model, array $block) {
    
    }

}