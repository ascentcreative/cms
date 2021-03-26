@extends('cms::modal')

@section('modalContent')

    @includeFirst(['auth.registerform', 'cms::auth.registerform'], ['intended'=>request()->intended])

     {{-- Prevent the form submittting normally - need to ajax it --}}
     <SCRIPT>

         $(document).ready(function () {
            $('A#btn-login').addClass('modal-link').attr('href', '/modal/cms::modals.login?intended=' + $('#form_register input[name="intended"]').val());
         });


        // $('#form_register').submit(function() {

        //     $('.validation-error').remove();

        //     $.ajax({
        //         type: 'POST',
        //         url: '/register', 
        //          headers: {
        //             'Accept' : "application/json"
        //          },
        //         data: $('#form_register').serialize(),
        //         statusCode: {
        //             302: function(data, xhr, request) {

        //                 console.log(data);
        //                 console.log(xhr);
        //                 console.log(request);

        //                 $('body').modalLink({
        //                     target: data.responseJSON
        //                 });

        //                 //$('.modal').modal('hide');

        //             },
        //             422: function(data, xhr, request) {
        //                 for(name in data.responseJSON.errors) { 

        //                     console.log(name + " --- " + data.responseJSON.errors[name]);

        //                     $('INPUT[name="' + name + '"]').parents('.element-wrapper').append('<small class="validation-error alert alert-danger form-text" role="alert">' +
        //                         data.responseJSON.errors[name] + 
        //                     '</small>');

        //                 }
        //             }
        //         }
        //     });
            
        //     return false;

         
        // });

    </SCRIPT>

@endsection