<?php

namespace AscentCreative\CMS\Filters;

use Illuminate\Database\Eloquent\Builder;


abstract class AbstractFilter {


    abstract public function createField();
		
		
	abstract public function applyFilter(Builder $query);
	

}