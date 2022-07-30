<?php

namespace AscentCreative\CMS\Traits;


use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;


trait Autocompletable {


    public function scopeAutocomplete($q, $term) {

        $search = $this->autocomplete_search ?? [];

        $terms = explode(" ", $term);

        $q->where(function($q) use ($search, $terms) { 
         
            foreach($search as $fld) {

                if(str_contains($fld, '.')) {
                    $split = explode('.', $fld);
                    $q->orWhereHas($split[0], function ($q) use ($split, $terms) {
                        $q->where(function($q) use ($split, $terms)  {
                            foreach($terms as $term) {
                                $q->where($split[1], 'like', '%' . $term . '%');
                            }
                        });
                    });
                } else {
                    $q->where(function($q) use ($terms, $fld) {
                        foreach($terms as $term) {
                            $q->orWhere($fld, 'like', '%' . $term . '%');
                        }
                    });
                }

            }
            
        });
        

    }


}

