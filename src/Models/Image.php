<?php

namespace AscentCreative\CMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use AscentCreative\CMS\Models\ImageSpec;

class Image extends Base
{
    use HasFactory;

    public function spec() {
        return $this->belongsTo(ImageSpec::class, 'image_spec_id');
    }

    static function getSpecForModel($model, $spec) {

        return Image::where('imageable_type', get_class($model))
            ->where('imageable_id', $model->id)
            ->whereHas('spec', function($q) use ($spec) {
                $q->where('slug', $spec);
            })->first();

    }

}
