<?php

namespace AscentCreative\CMS\Engines;

use Illuminate\Support\LazyCollection;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Builder;
use Laravel\Scout\Engines\Engine;

class AscentEngine extends Engine
{
  
    public function __construct()
    {
       
    }


    public function update($models)
    {
        dd('AscentEngine: in update');
    }

    
    public function delete($models)
    {
        dd('AscentEngine: in delete');
    }

    /**
     * Pluck and return the primary keys of the given results.
     *
     * @param  mixed  $results
     * @return \Illuminate\Support\Collection
     */
    public function mapIds($results)
    {

        dd('AscentEngine: in mapIDs');
        return collect($results['results'])->map(function ($result) {
            return $result->getKey();
        });
    }

    /**
     * Perform the given search on the engine.
     *
     * @param Builder $builder
     *
     * @return mixed
     */
    public function search(Builder $builder)
    {
        
        // fires for each registered model...

        dump(($builder));

    //    dd('AscentEngine: in search');

       return   ['results' => $builder->model::whereNotNull('id')->get()]; //all(); //get();
        //return $result;
    }

    /**
     * Perform the given search on the engine.
     *
     * @param Builder $builder
     * @param int     $perPage
     * @param int     $page
     *
     * @return mixed
     */
    public function paginate(Builder $builder, $perPage, $page)
    {
        $builder->limit = $perPage;
        $builder->offset = ($perPage * $page) - $perPage;

        return $this->search($builder);
    }

    /**
     * Map the given results to instances of the given model.
     *
     * @param Laravel\Scout\Builder               $builder
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return Collection
     */
    public function map(Builder $builder, $results, $model)
    {
        return $results['results'];
    }

    /**
     * Get the total count from a raw result returned by the engine.
     *
     * @param mixed $results
     *
     * @return int
     */
    public function getTotalCount($results)
    {
        return $results['count'];
    }

    /**
     * Flush all of the model's records from the engine.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     *
     * @return void
     */
    public function flush($model)
    {
    }



    /**
     * Map the given results to instances of the given model via a lazy collection.
     *
     * @param  \Laravel\Scout\Builder  $builder
     * @param  mixed  $results
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return \Illuminate\Support\LazyCollection
     */
    public function lazyMap(Builder $builder, $results, $model)
    {
        if ($this->getTotalCount($results) === 0) {
            return LazyCollection::empty();
        }

        return LazyCollection::make($results['results']->all());
    }

    /**
     * Create a search index.
     *
     * @param  string  $name
     * @param  array  $options
     * @return mixed
     */
    public function createIndex($name, array $options = [])
    {

        dd('AscentEngine: in create Index');
    }

    /**
     * Delete a search index.
     *
     * @param  string  $name
     * @return mixed
     */
    public function deleteIndex($name)
    {

        dd('AscentEngine: in deleteIndex');

    }
  
}
