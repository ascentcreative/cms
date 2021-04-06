@php
    
$mi = $model->menuitem;

@endphp


<x-cms-form-input type="text" label="Menu Item Title" name="_menuitem[title]" value="{{ old('_menuitem.title', $mi->title ?? '')}}"></x-cms-form-input>



<x-cms-form-nestedset label="Menu" 

    name="_menuitem"

    scopeFieldName="_menuitem[menu_id]"
    relationshipFieldName="_menuitem[context_type]"
    relationFieldName="_menuitem[context_id]"
    :scopeData="AscentCreative\CMS\Models\Menu::query()"
    scopeKey="menu_id"
    :nestedSetData="AscentCreative\CMS\Models\MenuItem::query()"

    scopeValue="{{ old('_menuitem.menu_id', $mi->menu_id ?? '') }}"
    relationshipValue="{{ old('_menuitem.context_type', $mi ? $mi->context['position'] : '' ) }}"
    relationValue="{{ old('_menuitem.context_id', $mi ? $mi->context['reference'] : '' ) }}"

    nullScopeLabel="[Do not include in Menus]"

    >

</x-cms-form-nestedset>


