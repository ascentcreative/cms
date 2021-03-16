@extends('cms::modal')

@section('modalContent')

    @includeFirst(['auth.registerform', 'cms::auth.registerform'], ['intended'=>request()->intended])

     {{-- Prevent the form submittting normally - need to ajax it --}}
     <SCRIPT>
        $('#form_register').submit(function() {

            $('.validation-error').remove();

            
            $.ajax({
                type: 'POST',
                url: '/register', 
                 headers: {
                    'Accept' : "application/json"
                 },
                data: $('#form_register').serialize()
            })
                .done(function(data, xhr, request) {

                    if(request.status == 201) {
                        window.location.href = $('#form_register input[name="intended"]').val()
                        $('.modal').modal('hide');
                        
                    }

                })

                .fail(function(data, xhr, request) {

                    if(data.status == 422) {

                        for(name in data.responseJSON.errors) { 

                            console.log(name + " --- " + data.responseJSON.errors[name]);

                            $('INPUT[name="' + name + '"]').parents('.element-wrapper').append('<small class="validation-error alert alert-danger form-text" role="alert">' +
                                data.responseJSON.errors[name] + 
                             '</small>');

                        }
                      
                      
                    } else {

                        alert('An unknown error occured while registering.');

                    }

                });
            return false;

         
        });


        /* {{-- Also need to do registration in popup? --}} */
        $('A#btn-login').on('click', function() {
           
            $.get('/modal/cms::modals.login?intended=' + $('input[name="intended"]').val())
                .done(function(data) {

                    $('#ajaxModal .modal-dialog').html($(data).find('.modal-content'));
                    //$('.modal').replaceWith(data);
                    
                })
                .fail(function(data) {
                    alert('Login Load Fail');
                });
            return false;
        });

    </SCRIPT>

@endsection