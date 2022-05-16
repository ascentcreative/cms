<?php
namespace AscentCreative\CMS\Filters;

class FilterManager {


    // need to somehow register the filters and sorters
    // I'm thinking by fieldname in the request data and the scope name
    
    // should we also grab a wrapper field name?
    // i.e. cfilters[themes] => wrapper[field]

    // allow a global wrapper to be set, but each individual registration might override it?

    public $filter_wrapper = 'filter';
    public $sorter_wrapper = 'sort';

    private $filters = [];
    private $statutoryFilters = [];
    private $sorters = [];


    public function setFilterWrapper($wrapper) {
        $this->filter_wrapper = $wrapper;
        return $this;
    }

    public function setSorterWrapper($wrapper) {
        $this->sorter_wrapper = $wrapper;
        return $this;
    }


    /**
     * Register a new filter
     * param: $field - the name of the field
     * param: $socpe - the eloquent scope name to apply on the model - i.e. scopeByTheme = 'byTheme';
     * param: $wrapper - override the wrapper for this field
     */
    public function registerFilter($field, $scope, $wrapper=null) {

        $this->filters[$field] = $scope;

        return $this;

    }


    /**
     * Register a new statutory filter
     * param: $socpe - the eloquent scope name to apply on the model - i.e. scopeByTheme = 'byTheme';
     * No params needed - it's always applied.
     */
    public function registerStatutoryFilter($scope) {

        $this->statutoryFilters[] = $scope;

        return $this;

    }

    /**
     * Register a new sorter
     * param: $field - the name of the field
     * param: $socpe - the eloquent scope name to apply on the model - i.e. scopeByTheme = 'byTheme';
     * param: $wrapper - override the wrapper for this field
     */
    public function registerSorter($field, $scope, $wrapper=null) {
 
        $this->sorters[$field] = $scope;

        return $this;

    }


    public function apply($query, $data=null) {

        $data = $data ?? request()->all();

        // dd($data);

        foreach($this->statutoryFilters as $key=>$scope) {
            $query->$scope();
        }


        $wrapper = $this->filter_wrapper;
        if ($wrapper == '') {
            $filter_data = $data;
        } else {
            $filter_data = $data[$wrapper] ?? [];
        }

        foreach($this->filters as $key=>$scope) {
            if(isset($filter_data[$key])) {

                // eager load for performance?
                //$query->with($key);

                $query->$scope($filter_data[$key]);
            }
        }

        // does this need to police only one sorter?

        $wrapper = $this->sorter_wrapper;
        if ($wrapper == '') {
            $sorter_data = $data;
        } else {
            $sorter_data = $data[$wrapper] ?? [];
        }

     //   dd($this->sorters);

        foreach($this->sorters as $key=>$scope) {
            
            if(isset($sorter_data[$key])) {
                //$query = 
                $query = $scope($query, $sorter_data[$key]);
            }
        }

        return $query;

    }


}
