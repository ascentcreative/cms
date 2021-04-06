
<?php

    $val = '';
    $hi = $model->headerimage;
    if($hi) {
        $val = $hi->alt_text;
    }

?>

<x-cms-form-input type="text" label="Alt Text" name="_headerimage[alt_text]" value="{!! old('_headerimage.alt_text', $val) !!}" height="600">

</x-cms-form-input>
