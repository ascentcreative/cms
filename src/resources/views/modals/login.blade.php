@extends('cms::modal')

@section('modalContent')

    @includeFirst(['auth.loginform', 'cms::auth.loginform'], ['intended'=>request()->intended])

    {{-- Prevent the form submittting normally - need to ajax it --}}
    <SCRIPT>

        $('A#btn-register').addClass('modal-link').attr('href', '/modal/cms::modals.register?intended=' + $('#form_login input[name="intended"]').val());

        // $('#form_login').submit(function() {

        //     $('.validation-error').remove();

        //     $.ajax({
        //         type: 'POST',
        //         url: '/login', 
        //          headers: {
        //             'Accept' : "application/json"
        //          },
        //         data: $('#form_login').serialize()
        //     })
        //         .done(function(data, xhr, request) {

        //             if(request.status == 201) {

        //                 $('body').modalLink({
        //                     target: $('#form_login input[name="intended"]').val()
        //                 });

        //             }

        //         })

        //         .fail(function(data, xhr, request) {

        //             if(data.status == 422) {

        //                 for(name in data.responseJSON.errors) { 

        //                     console.log(name + " --- " + data.responseJSON.errors[name]);

        //                     $('INPUT[name="' + name + '"]').parents('.element-wrapper').append('<small class="validation-error alert alert-danger form-text" role="alert">' +
        //                         data.responseJSON.errors[name] + 
        //                      '</small>');

        //                 }
                      
                      
        //             } else {

        //                 alert('An unknown error occured while logging in.');

        //             }

        //         });
        //     return false;

         
        // });


         /* {{-- Also need to do registration in popup? --}} */
     /*   $('A.button#btn-register').on('click', function() {
            //alert('intercepted');
            $.get('/modal/cms::modals.register?intended=' + $('#form_login input[name="intended"]').val())
                .done(function(data) {

                    $('#ajaxModal .modal-dialog').html($(data).find('.modal-content'));
                    //$('.modal').replaceWith(data);
                    
                })
                .fail(function(data) {
                    alert('Reg Load Fail');
                });
            return false;
        }); */

    </SCRIPT>

    


@endsection