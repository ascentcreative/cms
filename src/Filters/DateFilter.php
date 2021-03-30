<?php

namespace AscentCreative\CMS\Filters;

use Illuminate\Database\Eloquent\Builder;


class DateFilter {

    private $_label = '';
    private $_field = '';

    public function __construct($label, $field) {
        $this->_label = $label;
        $this->_field = $field;
    
    }

    public function createField() {

        return view('cms::filters.daterange');

    }

    public function applyFilter(Builder $query) {

        if (request()->has('from_' . $this->_field)) { 
            $query->where($this->_field, '<=', request()->{'from_' . $this->_field} );
        }
        
        return $query;

    } 


}