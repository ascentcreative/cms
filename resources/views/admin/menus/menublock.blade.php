

        <tr class="indexitem">

            <td class="title" style="vertical-align: top" valign="top">

                <div class="pt-1 lead">
                @if($item)
                    <a href="{{ action([controller(), 'edit'], [$modelInject => $item->id]) }}">{{$item->title}}</a>
                @else 
                    Pages not in menus
                @endif
                </div>

                <div class="pt-1 btn-group dropright">
                    
                    <A class="btn btn-secondary btn-sm dropdown-toggle" href="#" data-toggle="dropdown" >Add</A>

                    <div class="dropdown-menu dropdown-menu-right" style="">
        
                        @if($item)
                        <a class="btn btn-secondary btn-sm dropdown-item" href="{{ action([AscentCreative\CMS\Controllers\Admin\MenuItemController::class, 'create'], ['menu_id' => ($item ? $item->id : '') ]) }}">Menu Item</a>
                        @endif
                        <a class="btn btn-secondary btn-sm dropdown-item" href="{{ action([AscentCreative\CMS\Controllers\Admin\PageController::class, 'create'], ['_menuitem[menu_id]' => ($item ? $item->id : '') ]) }}">Page</a>
        
                    </div>
              </div>    

               
            </td>

            <td valign="top">

                @php

                    if ($item) {
                        $tree = \AscentCreative\CMS\Models\MenuItem::scoped(['menu_id'=>$item->id])->withDepth()->defaultOrder()->get();
                    } else {

                        $tree = [];

                        $tree = \AscentCreative\CMS\Models\Page::whereDoesntHave('menuitem')->orderBy('title')->get();
                      //  $tree = \AscentCreative\CMS\Models\MenuItem::scoped(['menu_id'=>$item->id])->withDepth()->defaultOrder()->get();
                    }

                @endphp

                <table class="menuitems">
                @foreach($tree as $mi)
                    <tr>


                        @php
                            $homeid = app(AscentCreative\CMS\Settings\SiteSettings::class)->homepage_id;
                            $is_home = false;
                            if (
                                ($item && $mi->linkable_type == \AscentCreative\CMS\Models\Page::class && $mi->linkable_id == $homeid) || (!$item && $mi->id == $homeid)
                                ) {
                                    $is_home = true;
                                }
                        @endphp

                        <td style="padding-left: {{10 + (20 * $mi->depth)}}px">

                           

                            @if($item)

                                @switch($mi->linkable_type)

                                    @case(\AscentCreative\CMS\Models\Page::class)
                                        <A href="{{ action([AscentCreative\CMS\Controllers\Admin\PageController::class, 'edit'], ['page' => $mi->linkable_id]) }}">{{ $mi->itemTitle }}</A>
                                    @break

                                    @default
                                        <A href="{{ action([AscentCreative\CMS\Controllers\Admin\MenuItemController::class, 'edit'], ['menuitem' => $mi->id]) }}">{{ $mi->itemTitle }}</A>
                                

                                @endswitch

                            @else

                                <A href="{{ action([AscentCreative\CMS\Controllers\Admin\PageController::class, 'edit'], ['page' => $mi->id]) }}">{{ $mi->title }}</A>

                            @endif

                            @if($is_home)
                                <i class="bi-house-door-fill"></i>
                            @endif


                            
                        </td>
                        <td> @if($mi->linkable) {{ $mi->linkable->url }} @else {{ $mi->url }} @endif</td>
                        <td>
                            
                            
                            <A class="modal-link" href="@if($item)
                            
                                @switch($mi->linkable_type)
                            
                                    @case(\AscentCreative\CMS\Models\Page::class)
                                    {{   action([AscentCreative\CMS\Controllers\Admin\PageController::class, 'delete'], ['page' => $mi->linkable_id])  }}
                                    @break
                            
                                    @default 
                                    {{   action([AscentCreative\CMS\Controllers\Admin\MenuItemController::class, 'delete'], ['menuitem' => $mi->id])  }}
                                    @endswitch

                                @else
                                    {{   action([AscentCreative\CMS\Controllers\Admin\PageController::class, 'delete'], ['page' => $mi->id])  }}
                                @endif">[x]</A></td>
                    </tr>
                @endforeach
                </table>

            </td>

        </tr> 