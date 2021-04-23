$.ascent = $.ascent?$.ascent:{};

var ModalLink = {
        
    self: null,
    loginPath: '/modal/cms/modals.login',
    targetPath: '',
    
    _init: function () {

        var self = this;
        this.widget = this;
        var thisID = (this.element)[0].id;
        var obj = this.element;

        
        // We're calling this on click, so just launch straight into the business end...

       // window.location.href = $(this.element).attr('href');

        if (this.options.target) {
            this.targetPath = this.options.target
        } else {
            this.targetPath = $(this.element).attr('href');
        }

        //$('#ajaxModal').hide();

        //console.log(self.targetPath);
      
     //   $.get({ url: self.targetPath
        $.ajax({
            type: 'GET',
            url: self.targetPath,
            headers: {
                'Accept' : "application/json"
            }
        }).done(function(data, xhr, request) {

            var cType = request.getResponseHeader('content-type');

            if(cType.indexOf('text/html') != -1) {
                self.showResponseModal(data);
            } else {
             //   alert(cType);

                window.location.href = self.targetPath;
                // close any open modals!
                $('.modal').modal('hide');
                
            }



        }).fail(function(data) {
            // hopefully this won't ever fail as we did the HEAD first
      
            console.log(data);
            switch(data.status) {
                case 401:
                   
                    console.log(data);
                    //fire off a request to the login form instaead.
                    $.get(self.loginPath + '?intended=' + self.targetPath).done(function(data) {
                        self.showResponseModal(data);
                    }).fail(function(data) {
                        console.log('FAIL WITHIN FAIL!');
                        console.log(data.responseText);

                    });


                    break;

                default:
                    alert('An unexpected error occurred:\n' + data.responseJSON.message );
                    break;

            }

        });
           
        return false;

      
        
    },

    showResponseModal: function(data) {

        /* if we're already in a modal, detect it and remove the existing modal */
        inFlow = false;
        if($('body .modal').length > 0) {
            inFlow = true; // take note - we'll need this later
            $('body .modal, body .modal-backdrop').remove(); // kill the calling modal
        }
        
        // add the newly supplied modal
        $('body').append(data);
        
        if (inFlow) {
            // if we were already in a flow of modals, remove the fade class
            // stops the backdrop glitching
            $('body .modal').removeClass('fade');
        }

        // fire up the new modal
        $('#ajaxModal').modal();
         // if we removed the fade class, re-add it now so this one fades out nicely!
         if (inFlow) {
            $('body .modal').addClass('fade');
        }


        // handler to remove the HTML for this modal when it's done with
        $('#ajaxModal').on('hidden.bs.modal', function() {
            $(this).remove();
        });

        // all done

        /* grab forms... */
        var self = this;

        $('#ajaxModal FORM').not('.no-ajax').submit(function() {

            var form = this;
       
            $('.validation-error').remove();

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'), 
                 headers: {
                    'Accept' : "application/json"
                 },
                data: $(this).serialize(),
                statusCode: {
                    200: function(data, xhr, request) {

                        if(request.getResponseHeader('fireEvent')) {
                            $(document).trigger(request.getResponseHeader('fireEvent'));
                        }

                        if(data) {
                            self.showResponseModal(data);
                        } else {
                            switch($(form).attr('data-onsuccess')) {
                                case 'refresh':
                                    window.location.reload();
                                    break;

                                default:
                                    $('#ajaxModal').modal('hide');
                            }
                        }
                    },
                    302: function(data, xhr, request) {

                        if(data.getResponseHeader('fireEvent')) {
                            $(document).trigger(data.getResponseHeader('fireEvent'));
                        }

                        switch(data.responseJSON) {

                            case 'reload':
                            case 'refresh':
                                window.location.reload();
                                break;

                            default:

                                $('body').modalLink({
                                    target: data.responseJSON
                                });

                                break;

                        }

                       

                        //$('.modal').modal('hide');

                    },
                    422: function(data, xhr, request) {
                        for(fldname in data.responseJSON.errors) { 

                            console.log(fldname + " --- " + data.responseJSON.errors[fldname]);

                            $('[name="' + fldname + '"]').parents('.element-wrapper').find('.error-display').append('<small class="validation-error alert alert-danger form-text" role="alert">' +
                                data.responseJSON.errors[fldname] + 
                            '</small>');

                        }
                    },
                    500: function(data, xhr, request) {

                        alert('An unexpected error occurred');
                    

                    }
                }
            }); /*.fail(function(data, xhr, request) {
                alert('fail');
                self.showResponseModal(data);

            }); */


            return false;


        });

       

    }

}

$.widget('ascent.modalLink', ModalLink);
$.extend($.ascent.ModalLink, {
		 
		
}); 

/* Assign this behaviour by link class */
$(document).on('click', 'A.modalLink, A.modal-link', function(e) {

    $(this).modalLink();
    e.stopPropagation();
    return false; // stop the link firing normally!

});