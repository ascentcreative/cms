<?php

namespace AscentCreative\CMS\Data;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\DB;
use Illuminate\Database\Eloquent\Builder;

class FilterManager {

    private $_model;

    public function __construct($model) {
        $this->_model = $model;
    }



    public function filter($filters, $sort) {

        // ignore pagination
      //  unset($filters['page']);

        $qry = $this->_model::orderBy('title');
        
        foreach($filters as $rel=>$vals) {

            if ($rel != 'page') {

                if (!is_array($vals)) {
                    $filtervals = array($vals);
                } else {
                    $filtervals = $vals;
                }

                $table = $this->_model::first()->$rel()->getRelated()->getTable();
                
                $qry->whereHas($rel, function (Builder $sub) use ($table, $filtervals) {
                    $sub->whereIn($table . '.id', $filtervals);
                }); 

            }

        }

        return $qry;

    }


    public function getFilterOptions($rel, $filters) {

        $cls = get_class($this->_model::first()->$rel()->getRelated());

        $fn = function (Builder $sub) use ($rel, $filters) {

            foreach($filters as $key=>$vals) {

                // need to ignore the filters for the request relationships as they'll skew the results
                // trust me...

                if ($key != $rel && $key != 'page') {
                    $table = $this->_model::first()->$key()->getRelated()->getTable(); 
                    
                    $sub->whereHas($key, function (Builder $sub2) use ($table, $vals) {
                        if (!is_array($vals)) {
                            $vals = array($vals);
                        }
                        $sub2->whereIn($table . '.id', $vals);
                    });

                }
            }
            
        };

        $qry = $cls::whereHas('songs', $fn)->withCount(['songs' => $fn]);

        return $qry->orderBy('songs_count', 'desc');

    }




}