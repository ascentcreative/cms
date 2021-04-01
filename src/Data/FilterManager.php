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

        if (!isset($filters['sort'])){
            $filters['sort'] = 'rank';
        }

        $qry = $this->_model::select('songs.*'); //orderBy('title');
        
        foreach($filters as $rel=>$vals) {

            // ignore pagination parameters
            // probably need more robust error handling to 
            // only process relationships we know about...
            if ($rel != 'page' && $rel != '_token') {


                // for now, just hard code this for the song model. 
                // we'll abstract it later when we understand how it works!

                switch($rel) {

                    case 'keyword':
                        // this is a 'LIKE' text search in a number of other fields:
                        // Title, First Line, Lyrics
                        // SIDENOTE - what about Authors, Themes?, Bible Books? (maybe search those if the specific filters aren't set?)
                        //echo 'a';

                        if ($vals != '') {

                            $qry->where(function($qry) use($vals) {

                                $targets = ['title', 'firstline', 'lyrics.text', 'ccli', 'writers.firstname', 'writers.lastname'];

                                foreach($targets as $srch) {
                                    if (strstr($srch, '.') !== false) {

                                        // relationship...
                                        // Last part of the string is the property
                                        $parts = explode('.', $srch);
                                        $prop = array_pop($parts);
                                        $srch = join('.', $parts);
                    
                                        $qry->orWhereHas($srch, function($query) use ($prop, $vals) { 
                                            $query->where($prop, 'LIKE', '%' . $vals . '%');
                                        });
                    
                                    } else {
                                        $qry->orWhere($srch, 'LIKE', '%' . $vals . '%');
                                    }
                                }
                            });

                        }
                            

                        break;

                    case 'biblerefs':
                        // not implemented...
                        if ($vals['book'] != '') {
                        $table = $this->_model::first()->$rel()->getRelated()->getTable();
                        
                        $qry->whereHas($rel, function (Builder $sub) use ($table, $vals) {

                            $sc = str_pad ( $vals['startChapter'] , 3 , "0", STR_PAD_LEFT ); 
	                        $sv = str_pad ( $vals['startVerse'] , 3 , "0", STR_PAD_LEFT );
	                        $ec = str_pad ( $vals['endChapter'] , 3 , "0", STR_PAD_LEFT ); 
	                        $ev = str_pad ( $vals['endVerse'] , 3 , "0", STR_PAD_LEFT );

                            $start = $sc . ":" . $sv;
                            $end = $ec . ":" . $ev;

                            
                                $sub->where('book', $vals['book']); 
                                if ($start != '000:000' && $end != '000:000') {
                                    $sub->whereRaw("? <= concat(LPAD(endChapter, 3, '0'), ':', LPAD(endVerse, 3, '0'))", $start)
                                    ->whereRaw("? >= concat(LPAD(startChapter, 3, '0'), ':', LPAD(startVerse, 3, '0'))", $end);
                                }
                            
                        }); 

                    }

                        break;

                    case 'sort':
                        // not implemented ...

                        switch ($vals) {
                            case 'rank':
                                $qry->join('popularity', 'songs.muma', '=', 'popularity.muma')
                                    ->orderBy(request()->sort ?? 'rank');
                                break;

                            case 'date':
                                $qry->orderBy('created_at', 'desc');
                                break;

                               
                        }
                       
                       
                        break;

                    default:
                   // echo 'b';

                        // Default is just using 'id in (xyz)' on a defined table. 
                        // (Themes, writers etc)

                        if (!is_array($vals)) {
                            $filtervals = array($vals);
                        } else {
                            $filtervals = $vals;
                        }
        
                        $table = $this->_model::first()->$rel()->getRelated()->getTable();
                        
                        $qry->whereHas($rel, function (Builder $sub) use ($table, $filtervals) {
                            $sub->whereIn($table . '.id', $filtervals);
                        }); 

                        break;

                }

               

            }

        }


    //    echo $qry->toSql();

      // dd($qry->toSql());

        // add a default sort (which will run second to any override sorting statements above)
        $qry->orderBy('title');

        return $qry;

    }


    public function getFilterOptions($rel, $filters, $sort=null) {

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

        if (is_null($sort)) {
            return $qry->orderBy('songs_count', 'desc');
        } else {
            foreach($sort as $field) {
                $qry->orderBy($field);
            }
            return $qry;
        }
        

    }




}