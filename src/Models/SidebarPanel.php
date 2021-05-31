<?php

namespace AscentCreative\CMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use Illuminate\Support\Str;


class SidebarPanel extends Base
{
    use HasFactory;

    public $table = "cms_sidebar_panels";

    public $fillable = ['sidebarable_type', 'sidebarable_id', 'sidebar_section', 'panel_template', 'data', 'sort'];

    public function render() {

        $cls = new $this->panel_class();

        return $cls->render();

        // how do we get from this to the actual rendered content?

        /**
         * A blade will be needed somewhere along the line
         * 
         */

    }


}

