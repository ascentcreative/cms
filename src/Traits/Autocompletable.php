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
                            $q->where($fld, 'like', '%' . $term . '%');
                        }
                    });
                }

            }
            
        });

        // add some ordering where closer matches come higher up
        // should we be using fulltext for this? order by match?
        // requires specific fulltext indexes though... maybe not ideal

        // BUT, in some cases, the results of many model autocoompletes will be combined.
        // The sorting would break if all the itesm were returned as part of a single operation.

        // Maybe we pass options make different queries (exact match, all words, any words)
        // and these are executed in turn, and collated.


        // Also - slight complication here if we have a compound label (i.e. a product name and SellableGroup title)
        // - Just need to remember to add that to the autocomplete_search on the model

    }


}

