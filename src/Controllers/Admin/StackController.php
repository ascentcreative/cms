<?php

namespace AscentCreative\CMS\Controllers\Admin;

use AscentCreative\CMS\Controllers\AdminBaseController;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;

use AscentCreative\CMS\Models\Stack;
use AscentCreative\CMS\Models\Block;

class StackController extends AdminBaseController
{

    static $modelClass = 'AscentCreative\CMS\Models\Stack';
    static $bladePath = "cms::admin.stacks";



    public function rules($request, $model=null) {

       return [
            'name' => 'required',
        ]; 

    }


    public function autocomplete(Request $request, string $term) {

        echo $term;

    }


    public function updateblockorder() {

        $stack = Stack::find(request()->stack);

        $i = 0;
        foreach(request()->blockorder as $block_id) {
            $block = Block::find($block_id);
            if($block) {
                $block->sort = $i;
                $block->save();
                $i++;
            }

        }

    }


}