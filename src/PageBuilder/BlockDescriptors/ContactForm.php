<?php

namespace AscentCreative\CMS\PageBuilder\BlockDescriptors;

use AscentCreative\PageBuilder\BlockDescriptors\AbstractDescriptor; 
use Illuminate\Database\Eloquent\Model;

class ContactForm extends AbstractDescriptor { 

    public static $name = 'Contact Form';

    public static $bladePath = 'contact-form';

    public static $description = "Inserts a Contact Form";

    public static $category = "Functionality";

    public function extractText(Model $model, array $block) {
    
    }

}