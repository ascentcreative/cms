@extends('cms::admin.base.edit')

@section('screentitle', 'Site Settings')

@section('screen-start')
        
    {{-- OPEN FORM TAG --}}
    <form action="/admin/settings" method="POST" id="frm_edit" enctype="application/x-www-form-urlencoded">
    @csrf

@overwrite


@push('scripts')
    @script('/vendor/ascent/cms/jquery/areyousure/jquery.are-you-sure.js')
    @script('/vendor/ascent/cms/jquery/areyousure/ays-beforeunload-shim.js')

    <script language="javascript">
        $(document).ready(function() {
            $('#frm_edit').areYouSure( {'message':'Your edits have not been saved!'} );
	
        });
    </script>

    <script>

        $(document).ready(function() {
            $('#myTab li:first-child a').tab('show');
        });

    </script>

@endpush







@section('editform')
    <div class="cms-screenblock-tabs bg-white rounded shadow" style="">

    {{--  <div class="cms-screenblock cms-screenblock-main bg-white rounded shadow" style=""> --}}

        <ul class="nav nav-tabs px-3 pt-3 bg-light" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link" id="main-tab" data-toggle="tab" href="#main" role="tab" aria-controls="main" aria-selected="true">Main Site Settings</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="code-tab" data-toggle="tab" href="#code" role="tab" aria-controls="code" aria-selected="false">Add-in Code</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact Form</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="reg-tab" data-toggle="tab" href="#reg" role="tab" aria-controls="registration" aria-selected="false">Registration</a>
            </li>

            {{-- <li class="nav-item">
              <a class="nav-link" id="menuitem-tab" data-toggle="tab" href="#menuitem" role="tab" aria-controls="menuitem" aria-selected="false">Menu Position</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="metadata-tab" data-toggle="tab" href="#metadata" role="tab" aria-controls="metadata" aria-selected="false">Metadata</a>
            </li> --}}
        </ul>
    
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane show p-3" id="main" role="tabpanel" aria-labelledby="main-tab">
                
                <x-cms-form-input type="text" name="site_name" label="Site Name" value="{{ old('site_name', $model->site_name) }}">
                    Shows in the tab label for all pages of the site
                </x-cms-form-input>

                <x-cms-form-fileupload type="text" name="favicon" label="Favicon" value="{{ old('favicon', $model->favicon) }}">
                   Favicon to use for the site
                </x-cms-form-input>

            </div>


            <div class="tab-pane show p-3" id="code" role="tabpanel" aria-labelledby="code-tab">
        
                <x-cms-form-code type="text" name="custom_head_tags" label="Custom HEAD Tags" value="{!! old('custom_head_tags', $model->custom_head_tags) !!}">
                   Adds this code to the HTML Head of the site. Best used for custom Meta tags (Facebook pixel verification etc).<br/><strong>Do not use for anything which would need to be covered by cookie opt-in code (i.e. analytics / tracking coode etc)</strong>
                </x-cms-form-code>

                <x-cms-form-code type="text" name="custom_body_tags_start" label="Custom Opening BODY Tags" value="{!! old('custom_body_tags_start', $model->custom_body_tags_start) !!}">
                    Adds this code to the HTML of the site, immediately AFTER the opening BODY tag. Take care not to add any HTML which may display in a visitor's browser.</strong>
                 </x-cms-form-code>

                 <x-cms-form-code type="text" name="custom_body_tags_end" label="Custom Closing BODY Tags" value="{!! old('custom_body_tags_end', $model->custom_body_tags_end) !!}">
                    Adds this code to the HTML of the site, immediately BEFORE the closing BODY tag. Take care not to add any HTML which may display in a visitor's browser.</strong>
                 </x-cms-form-code>

            </div>


            {{-- CONTACT FORM SETTINGS --}}
            <div class="tab-pane show p-3" id="contact" role="tabpanel" aria-labelledby="contact-tab">

                <x-cms-form-input type="text" name="contact_to_addresses" label="Send To" value="{{ old('contact_to_addresses', $model->contact_to_addresses) }}">
                    The email address(es) which should recieve contact form submissions - separate with commas.
                </x-cms-form-input>


                
                <x-cms-form-input type="text" name="contact_from_name" label="From Name" value="{{ old('contact_from_name', $model->contact_from_name) }}">
                    The name you'll receive contact form submissions from.
                </x-cms-form-input>

                <x-cms-form-input type="text" name="contact_from_address" label="From Address" value="{{ old('contact_from_address', $model->contact_from_address) }}">
                    The name you'll receive contact form submissions from.
                </x-cms-form-input>



                @if(config('cms.recaptcha_secret'))
                <x-cms-form-input type="text" name="contact_recaptcha_threshold" label="Google Recaptcha Threshold" value="{{ old('contact_recaptcha_threshold', $model->contact_recaptcha_threshold) }}">
                    The score below which enquiries will be rejected as spam.
                </x-cms-form-input>
                @endif
        
        
              
            </div>



            <div class="tab-pane show p-3" id="reg" role="tabpanel" aria-labelledby="reh-tab">

                <x-cms-form-input type="text" name="welcome_email_subject" label="Welcome Email Subject" value="{{ old('welcome_email_subject', $model->welcome_email_subject) }}">
                  
                </x-cms-form-input>
        
                <x-cms-form-ckeditor type="text" name="welcome_email_content" label="Welcome Email Content" value="{{ old('welcome_email_content', $model->welcome_email_content) }}">
                    
                </x-cms-form-input>
        
            </div>


        </div>

      


        {{-- <x-cms-form-input type="text" name="test[]" label="Test 1" :value="$model->test[0]">
            Shows in the tab label for all pages of the site
        </x-cms-form-input>

        <x-cms-form-input type="text" name="test[]" label="Test 2" :value="$model->test[1]">
            Shows in the tab label for all pages of the site
        </x-cms-form-input> --}}

    </div>


@endsection