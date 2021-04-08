<?php

namespace AscentCreative\CMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NestedSet;
use Kalnoy\Nestedset\NodeTrait;

use Illuminate\Support\Str;

use AscentCreative\CMS\Traits\HasImages;


class MenuItem extends Base
{
   
    use HasFactory, NodeTrait, HasImages; //HasHeaderImage;

    public $fillable = ['menu_id', 'title', 'url', 'newWindow'];

    protected function getScopeAttributes()
    {
        return [ 'menu_id' ];
    }


    public function getItemTitleAttribute() {
        if (is_null($this->title)) {
            return $this->linkable->title;
        } else {
            return $this->title;
        }
    }

    public function getItemUrlAttribute() {
        if (is_null($this->url)) {
            return $this->linkable->url;
        } else {
            return $this->url;
        }
    }

    public function linkable() {
        return $this->morphTo();
    }


    public function getContextAttribute() {

        if ($this->id) {
        

            if ($this->getPrevSibling() == null) {
            
                if ($this->getParentId() == null) {
                    
                    $pos = 'before';
                    $ref = $this->getNextSibling()->id;
                    
                } else {
                    $pos = 'first-child';
                    $ref = $this->getParentId();
                }
                
                
            } else {
                
                $pos = 'after';
                $ref = $this->getPrevSibling()->id;
                
            }
        
            return array('position'=>$pos, 'reference'=>$ref);

        } else {

            return array('position'=>null, 'reference'=>null);

        }

    }

}
