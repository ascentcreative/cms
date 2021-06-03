@extends('cms::admin.base.index')


@section('indextable-head')

  
        <tr>
            
           {{--}} <th colspan="2">Actions</th>--}}

            <th width="200">Stack Name</th>

            <th width="">Stack Items</th>

        </tr>

@endsection

@section('indextable-body')
  
    
    @foreach ($models as $item)
    
        <tr class="indexitem">

            <td class="title" style="vertical-align: top" valign="top">
                <div class="pt-1"><a href="{{ action([controller(), 'edit'], [$modelInject => $item->id]) }}">{{$item->name}}</a></div>

                <div class="btn-group dropright">
                    <A class="btn btn-secondary btn-sm dropdown-toggle" href="#" data-toggle="dropdown" >Add Block</A>
                    <div class="dropdown-menu dropdown-menu-right" style="">
                        @foreach(\AscentCreative\CMS\Models\BlockTemplate::orderBy('name')->get() as $template)
                        <a class="dropdown-item text-sm btn-delete" href="{{ action([AscentCreative\CMS\Controllers\Admin\BlockController::class, 'create'], ['stack_id' => $item->id, 'blocktemplate_id'=>$template->id]) }}">
                        <b>{{ $template->name }}</b>
                        <br/>
                        <span class="text-sm text-muted">{{ $template->description }}</span>

                        </a> 
                        @endforeach
                    </div>
              </div>    


                {{-- <div class="pt-1"><a class="btn btn-secondary btn-sm" href="{{ action([AscentCreative\CMS\Controllers\Admin\BlockController::class, 'create'], ['stack_id' => $item->id, 'blocktemplate_id'=>1]) }}">New Block</a></div> --}}
            </td>

            <td valign="top">

                @php
                
                    //$tree = \AscentCreative\CMS\Models\MenuItem::scoped(['menu_id'=>$item->id])->withDepth()->defaultOrder()->get();

                    //$blocks = $item->blocks()

                @endphp

                <table class="menuitems" id="stackblocks">
                    @foreach($item->blocks as $block)
                        <tr class="{{ $block->published ? 'published' : 'hidden' }}">
                            <td>
                                <A href="{{ action([AscentCreative\CMS\Controllers\Admin\BlockController::class, 'edit'], ['block' => $block->id]) }}">{{ $block->name }}</A>
                                <input name="blockorder[]" type="hidden" value="{{ $block->id }}" /></td>
                            </td>
                            <td>{{ $block->template->name }}</td>
                            <td><A class="modal-link" href="{{ action([AscentCreative\CMS\Controllers\Admin\BlockController::class, 'delete'], ['block' => $block->id]) }}">[x]</A></td>
                        </tr>
                    @endforeach
                    <tfoot style="display: none"><tr><td><input name="stack" value="{{ $item->id }}" /></td></tr></tfoot>
                </table>

            </td>

        </tr> 
     @endforeach

@endsection

@push('scripts')
    <script>
       $("#stackblocks tbody").sortable({
           update: function() {
               $.ajax({
                   url: '/admin/stacks/updateblockorder',
                   method: 'post',
                   data: $('#stackblocks INPUT').serialize()
               });
           }
       });
    </script>
@endpush