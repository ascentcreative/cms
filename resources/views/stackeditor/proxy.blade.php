{{-- Used to prevent errors if the stackeditor package isn't installed --}}
<x-stackeditor label="" 
name="content" 
:value="old('content', $model->content)" 
wrapper="none"
:model="$model ?? null"/>