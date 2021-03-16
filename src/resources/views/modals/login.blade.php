@extends('cms::modal')

@section('modalContent')

    @includeFirst(['auth.loginform', 'cms::auth.loginform'], ['intended'=>request()->intended])

    {{-- Prevent the form submittting normally - need to ajax it --}}
    <SCRIPT>
        $('#form_login').submit(function() {

            $.ajax({
                type: 'POST',
                url: '/login', 
                headers: {
                   'Accept' : "application/json"
                },
                data: $('#form_login').serialize()
            })
                .done(function(data, xhr, request) {

                    if(request.status == 201) {
                        window.location.href = $('#form_login input[name="intended"]').val()
                        $('.modal').modal('hide');
                    }

                })
                
                .fail(function(data, xhr, request) {

                    if(data.status == 422) {



                    } else {



                    }

                    console.log('LOGIN FAIL');
                    console.log(data);
                    console.log(xhr);
                    console.log(request); //.getAllResponseHeaders());
                });
            return false;

         
        });
    </SCRIPT>

    {{-- Also need to do registration in popup? --}}

@endsection