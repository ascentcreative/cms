<?php

namespace AscentCreative\CMS\Models;


use AscentCreative\CMS\Traits\HasHeaderImage;
use AscentCreative\CMS\Traits\HasImages;
use AscentCreative\CMS\Traits\HasMenuItem;
use AscentCreative\CMS\Traits\HasMetadata;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;


class Page extends Base
{
    use HasFactory, HasMetadata, HasImages, HasMenuItem; 

    public $fillable = ['title', 'content'];
    
    /*
     * MUTATORS
     * 
     * setTitleAttribute: takes the incoming title and sets the slug accordingly
     */
    public function setTitleAttribute($value) {
        // set the title so the value doesn't get lost
        $this->attributes['title'] = $value;

        if (!isset($this->attributes['slug']) || $this->attributes['slug']==='') {
            
            $slug = Str::slug(($value), '-');

            // check to see if any other slugs exist that are the same & count them
            $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();

            $this->attributes['slug'] = $count ? "{$slug}-{$count}" : $slug;

        }

    }

    public function getUrlAttribute() {
        return '/' . $this->slug;
    }


    /**
     * Sidebar... 
     * Maybe use trait "CanHasSidebar" (get me making an out-dated reference...)
     * 
     *  - Need methods to determine if a model requires the view to display a sidebar
     *  - Basically whether any sidebar panels/blocks/widgets have been defined
     *  - Model might need some defaults defined - i.e. submenu items etc for pages, categories for blog posts.
     *       - Perhaps this would be read from a $sidebar_panels array
     *       - Add to this by creating in admin, similar to how page blocks are created.
     *  - Might also need to check if the defined panels are displayable
     *       - i.e., if only a submenu panel is defined, but there's no items to include, then sidebar not needed.
     *  - But, also, for display consistency, might we want to force a sidebar area to at least be reserved in the layout?
     *       - perhaps that's an additional config option on the model / trait
     * 
     */

    public $sidebar_panels = [

        'top' => ['AscentCreative\CMS\Sidebar\Submenu'],
        'bottom' => []
    
    ]; // Should this be alias based? Ideally. 

    // or... maybe these just serve as default values?


    // merge class default panels with any from the database
    // should this also instantiate them? May need to in order to check renderable status...
    public function getSidebarPanelsAttribute() {



    }

    public function panels($section=null) {

        $q = $this->morphMany(SidebarPanel::class, 'sidebarable');
        if ($section) {
            $q->where('sidebar_section', $section);
        }   
        return $q;
    }

    public function getRequiresSidebarAttribute() {

        return true;

    }

}
