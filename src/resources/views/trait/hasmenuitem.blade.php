
<?php

    $val = '';
    $hi = $model->menuitem;
    if($hi) {
        $val = $hi->context_id;
        $val2 = $hi->context_type;
    } 

?>



<x-cms-form-foreignkeyselect type="select" name="_menuitem[context_id]" label="Attach to:" 
model="AscentCreative\CMS\Models\MenuItem" :query="AscentCreative\CMS\Models\MenuItem::scoped( ['menu_id' => 1] )->orderBy('_lft')" value="{{ old('_menuitem.context_id', '') }}">
</x-cms-form-foreignkeyselect>

<select name="_menuitem[context_type]">
<option value="first-child">First Child Of</option>
<option value="before">Sibling Before</option> 
<option value="after">Sibling After</option>
</select>

