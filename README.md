# Ascent Creative CMS For Laravel 

This package is designed to serve as an admin area for Laravel websites and provide scaffolding for websites and web applications. 

## Installation

If you're reading this, my guess is that the CMS is already set up on your site. If you are looking at starting to use it though:

`composer require ascentcreative/cms` should install this, although you might need to add a link to the repository to your composer file. 

`php artisan migrate` should then allow all the necessary tables to be created.


## Core Concepts


## Items which really should be their own packages

Being a little blinkered at first, I have built some utilties and elements which, while extremely useful in this context, may actually be more appropriate to being in their own packages. There are:

### Modal Links


### Extender Traits

Laravel Models are normally one-to-one with their underlying tables. While Eloquent then allows relations to be described and coded, I was finding it cumbersome to ensure that relationship data was being written in the correct places in the application. Extender traits are a means of allowing a Model to know how to save relationship data so that a single `save()` call will update all the necessary tables. 

I will admit the name is perhaps a little vague... 

Taking the example of Post Model which has a `tags()` Eloquent relation pointing to a `tags` table via a `post_tags` pivot - we can handle this relationship data using an Extender trait we might call 'HasTags'. 

```
<?php

namespace App\Traits;

use AscentCreative\CMS\Traits\Extender;
use App\Models\Tag;
use App\Models\PostTag;

use Illuminate\Http\Request;

trait HasTags {

    use Extender;

    public function initializeHasTags() {
        $this->addCapturable('tags');
    }

    public function saveTags($data) {

        // insert the necessary save logic here
        // sync(), attach(), a loop, what ever fits the relation you're using

    }   

    public function deleteTags() {
        // runs when the parent Model is being deleted to remove relationship data.
        $this->tags()->detach();
    }


    public function tags() {
        return $this->belongsToMany(Tag::class, PostTag::class);
    }

     public function tagPivots() {
        return $this->hasMany(PostTag::class);
    }

 
}
```

Now, when we're saving a Model, if we pass data into the `$post->tags` property, it will be passed to the trait and saved to the database (once the main Model) has saved.

 - A model can have multiple Extender traits so many different relationships can be represented, each with their own logic.
 - This trait could also be reusable so, if the post_tags table used Polymorphic Relationships, it could apply to any Model in the database. In these cases, it's best to define all the Eloquent relationships in the trait so they're fully portable.


#### How it works

The first step is the 'initialize[TraitName]' function. This method calls `$this->addCapturable('[fieldname]')`. The Fieldname should be the name of your relationship. When this call is made, that field is silently added to the '$fillable' for the model so that values may be mass-filled.

 - The field name is added to Extender's internal list of 'capturable' fields - the list of relationships it is dealing with. These are then processed when a model is saved.
 - The delete callback function `delete[Fieldname]()` is registered. If you do not wish to implement a delete method, you can set the second parameter of `addCapturable()` to `false`: `$this->addCapturable('[fieldname]', false)`
     - Alternatively, a string may be passed in to override the name of the delete callack function.
 - The save callback function - `save[Fieldname]` - is then registered.
 - When the model is saved, the `saving` event is used to extract all the data for the 'capturable' fields. This prevents Laravel attempting to write those columns to the model's table
 - After the model has saved, the various data items are sent to their respective save handlers.

This means that any `save()` call against a model can update any defined relationships as needed, without the developer needing to consider what data may or may not be being adjusted across the relationships.

One important note - the Extender will also only process data which has been set in the Model. 

 - If the relationship field has data, it will be saved
 - If the relationship field is set to NULL - IT WILL BE SAVED, and probably treated as a blank value
 - However, if the relationship field has not been set, the Extender will not cause any updates to the stored values.



#### Advanced use

##### Custom save callbacks:

In some complex cases, a Model may use the same extender mutiple times (see the HasFiles trait in [ascentcreative/files](https://github.com/ascentcreative/files) which allows for multiple file upload fields on one model, some taking single files, others mutiple). In this case, the third parameter to `addCapturable` is used to override the default naming of the save callback function:

```
// initalizeHasFiles()
foreach($this->multifile_fields as $file) {
  $this->addCapturable($field, 'deleteMultiFiles', 'saveMultiFiles');
}
```

In this instance we're registering multiple fields and the incoming data for each field will be passed to the saveMultiFiles method. Note that in these cases, the Extender trait changes the callback signature from `saveField($data)` to `saveMultiFiles($field, $data)` so that we have the context of where the data is coming from.










### Show-Hide Toggles
