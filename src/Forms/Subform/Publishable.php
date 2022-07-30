<?php
namespace AscentCreative\CMS\Forms\Subform;

use AscentCreative\Forms\Structure\Subform;
use AscentCreative\Forms\Structure\HTML;
use AscentCreative\Forms\Fields\Checkbox;
use AscentCreative\Forms\Fields\DateTime;

class Publishable extends Subform {

    public function initialise() {
        return $this->children([

            HTML::make('<div class="border p-2 ml-5" style="flex-basis: 300px;">', '</div>')
                ->children([

                    Checkbox::make('publishable', 'Ready to Publish?')
                        ->uncheckedValue(0)->wrapper('inline'),
    
                    DateTime::make('publish_start', 'Publish At')
                        ->description('(leave blank to publish immediately)')
                        ->wrapper('simple')
                        ->class('mt-3'),

                    DateTime::make('publish_end', 'Publish Until')
                        ->description('(leave blank to publish indefinitely)')
                        ->wrapper('simple')
                        ->class('mt-3'),


                ])
    

        ]);
    }

}