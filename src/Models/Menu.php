<?php

namespace AscentCreative\CMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;


/**
 * Used a convenient jumping off point for all models in the package.
 * Essentially just prefixes all child models' table names with 'checkout_'. 
 */
class Menu extends Base
{
    use HasFactory;

    public $fillable = ['title'];

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



    /**
     * Render out the menu items (UL)
     */
    public function render($maxDepth = 0, $classes='') {

        $items = MenuItem::scoped(['menu_id'=>$this->id])->defaultOrder()->get()->toTree();

        return $this->traverse($items, $maxDepth, 0, $classes);

    }

    public function traverse($items, $maxDepth, $depth = 0, $classes='') {

        if ($maxDepth != 0 && $depth == $maxDepth) {
            return '';
        }


        $out = '<UL class="menu ' . ($depth==0?('menu-' . $this->slug):'') . ' ' . $classes . '">';

        foreach($items as $item) {

            $newwin = '';
            if ($item->newWindow == 1) {
                $newwin = ' target="_blank"';
            }

            $out .= '<LI class="' . ( count($item->children) > 0 ? 'menu-branch' : 'menu-leaf' ) . '"><A href="' . $item->itemUrl . '"' . $newwin . '>' . $item->itemTitle . '</A>';
            
            if(count($item->children) > 0) {
                 $out .= $this->traverse($item->children, $maxDepth, $depth+1);
            }

            $out .= '</LI>';

        }

        $out .= "</UL>";

        return $out;

    }

}
