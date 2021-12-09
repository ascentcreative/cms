<?php

namespace AscentCreative\CMS\StackEditor\TypeDescriptors;

use AscentCreative\StackEditor\TypeDescriptors\AbstractDescriptor; 

class PageHeader extends AbstractDescriptor { 

    public static $name = 'Page Header';

    public static $bladePath = 'page-header';

    public static $description = "Insert the header for a page";

    public static $category = "Functionality";

}