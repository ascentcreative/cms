@php

    if (is_array($model->image_specs) && count($model->image_specs) > 0) {
        $specs = AscentCreative\CMS\Models\ImageSpec::whereIn('slug', $model->image_specs)->get();
    } else {
        $specs = AscentCreative\CMS\Models\ImageSpec::all();
    }

    // maybe, rather than defining on the model, we do this in the CMS config - use an array of model classes and the assoociated specs?

@endphp


@foreach($specs as $spec)

    <?php

        $alt = '';
        $image = '';
        $hi = $model->images()->where('image_spec_id', $spec->id)->first(); //BySpec($spec);
        if($hi) {
            $image = $hi->image;
            $alt = $hi->alt_text;
        }

    ?>

    <x-cms-form-croppie label="{{ $spec->title }}" name="_images[{{ $spec->slug }}][image]" value="{!! old('_images.' . $spec->slug . '.image', $image) !!}"  
                        width="{{ $spec->width }}" height="{{ $spec->height }}" previewScale="{{ $spec->preview_scale }}" quality="{{ $spec->quality }}">
    </x-cms-form-croppie>

    <x-cms-form-input type="text" label="Alt Text" name="_images[{{ $spec->slug }}][alt_text]" value="{!! old('_images.' . $spec->slug . '.alt_text', $alt) !!}">

    </x-cms-form-input>

@endforeach
