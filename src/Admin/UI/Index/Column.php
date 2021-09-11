<?php
namespace AscentCreative\CMS\Admin\UI\Index;

class Column {

    public $sortable = false;
    public $sortBy = '';
    public $sortQuery = null;

    public $sorted = 'blah';


    public $filterable = false;

    public $title = '';
    public $slug = '';

    public $value = '';
    
    public $isBlade = false;
    public $bladeProps;

    public $isLink = false;

    public $align = '';

    public $width = null;



  //  public abstract function renderitem($item);


    static function make($title = null, $value = null) {
        $col = new Column();
        if ($title) {
            $col->title($title);
        }
        if ($value)  {
            $col->valueProperty($value);
        }
        return $col;
    }

    public function width($val) {
        $this->width = $val;
        return $this;
    }

    public function title($val) {
        $this->title = $val;
        $this->slug = \Illuminate\Support\Str::slug($val);
        return $this;
    }

    public function isLink($bool=true) {
        $this->isLink = $bool;
        return $this;
    }

    public function value($val, $isLink=false) {
        $this->value = $val;
        $this->isLink = $isLink;
        return $this;
    }

    public function valueProperty($val, $isLink=false) {
        $this->value = function ($item) use ($val) {
            return $item->$val;
        };
        $this->isLink = $isLink;
        return $this;
    }

    public function valueBlade($blade, $props=[]) {
        $this->isBlade = true;
        $this->value = $blade;
        $this->bladeProps = $props;
        return $this;
    }


    public function align($align) {
        $this->align = $align;
        return $this;
    }


    public function sortable($bool=true) {
        $this->sortable = $bool;
        return $this;
    }

    public function sortableBy($prop) {
        $this->sortable();
        $this->sortQuery = function ($q, $dir='asc') use ($prop) {
            return $q->orderby($prop, $dir);
        };
        return $this;
    }

    public function sortableBySum($relation, $prop) {
        $this->sortable();
        $this->sortQuery = function ($q, $dir='asc') use ($relation, $prop) {
            return $q->withSum($relation, $prop)->orderby($relation . '_sum_' . $prop, $dir);
        };
        return $this;
    }

    public function sortableByQuery(\Closure $query) {
        $this->sortable();
        $this->sortQuery = $query;
        return $this;
    }

    public function buildSortUrl() {

        $url = url()->current();
        $query = request()->query();

        unset($query['sort']);

        // if not sorted, go asc
        switch($this->sorted) {
            case 'asc':
                $dir = 'desc';
                break;

            case 'desc':
                $dir = '';
                break;

            default:
                $dir = 'asc';
                break;
        }        

        if ($dir) {
            $query['sort'][$this->slug] = $dir;
        }

        return $url . (count($query) > 0 ? ('?' . http_build_query($query)) : '');
        
    }

    
}