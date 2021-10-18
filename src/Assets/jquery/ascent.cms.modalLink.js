$.ascent = $.ascent?$.ascent:{};

var ModalLink = {
        
    self: null,
    loginPath: '/modal/cms/modals.login',
    targetPath: '',
    backdrop: true,
    keyboard: true,
    
    _init: function () {

        var self = this;
        this.widget = this;
        var thisID = (this.element)[0].id;
        var obj = this.element;


        if (this.element.data('backdrop') != null) {
            this.backdrop = this.element.data('backdrop'); 
        }

        if (this.element.data('keyboard')  != null ) {
            this.keyboard = this.element.data('keyboard');
        }


       
        
        // We're calling this on click, so just launch straight into the business end...

        if (this.options.target) {
            this.targetPath = this.options.target
        } else {
            this.targetPath = $(this.element).attr('href');
        }

        if( this.element.data('serialiseForModal') ) {
             self.targetPath += '?' + $( this.element.data('serialiseForModal') ).serialize();
        }
        
        
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
            $('body .modal#ajaxModal, body .modal-backdrop').remove(); // kill the calling modal
        }
        
        // add the newly supplied modal
        $('body').append(data);
        
        if (inFlow) {
            // if we were already in a flow of modals, remove the fade class
            // stops the backdrop glitching
            $('body .modal').removeClass('fade');
        }

        // fire up the new modal
        $('#ajaxModal').modal({
            backdrop: this.backdrop,
            keyboard: this.keyboard
        });
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

            try {

                var form = this;
        
                $('.validation-error').remove();

                // switched to use formdata to allow files.
                var formData = new FormData($(form)[0]); 

                // console.log(...formData);
              
                $.ajax({
                    type: 'POST',
                    contentType: false,
                    processData: false,
                    url: $(this).attr('action'), 
                    headers: {
                        'Accept' : "application/json"
                    },
                    data: formData,
                    statusCode: {
                        200: function(data, xhr, request) {

                            

                            console.log('200!');
                            console.log(data);
                            
                            var disposition = request.getResponseHeader('content-disposition');
                            
                            if (disposition && disposition.indexOf('attachment') !== -1) {
                                /** INCOMING DOWNLOAD!  */
                                var contentType = request.getResponseHeader('content-type');
                                var file = new Blob([data], { type: contentType });

                                console.log(request.getResponseHeader('content-disposition'));
                                var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                                var matches = filenameRegex.exec(disposition);
                                if (matches != null && matches[1]) { 
                                    filename = matches[1].replace(/['"]/g, '');
                                }

                                if ('msSaveOrOpenBlob' in window.navigator) {
                                    window.navigator.msSaveOrOpenBlob(file, filename);
                                }
                                // For Firefox and Chrome
                                else {
                                    // Bind blob on disk to ObjectURL
                                    var data = URL.createObjectURL(file);
                                    var a = document.createElement("a");
                                    a.style = "display: none";
                                    a.href = data;
                                    a.download = filename;
                                    document.body.appendChild(a);
                                    a.click();
                                    // For Firefox
                                    setTimeout(function(){
                                    document.body.removeChild(a);
                                    // Release resource on disk after triggering the download
                                    window.URL.revokeObjectURL(data);
                                    }, 100);
                                }

                                $('#ajaxModal').modal('hide');

                            } else {



                                if(request.getResponseHeader('fireEvent')) {
                                    $(document).trigger(request.getResponseHeader('fireEvent'));
                                }

                                if(data) {

                                    if($(data).hasClass('modal')) { 
                                        self.showResponseModal(data);
                                    } else {
                                        $('#ajaxModal').modal('hide');
                                        $(document).trigger({
                                            type: 'modal-link-response',
                                            response: data
                                        });
                                    }
                                   
                                    
                                } else {
                                    switch($(form).attr('data-onsuccess')) {
                                        case 'refresh':
                                            window.location.reload();
                                            break;

                                        default:
                                            $('#ajaxModal').modal('hide');
                                    }
                                }

                            }

                        },

                        201: function (data, xhr, request) {

                            switch($(form).attr('data-onsuccess')) {
                                case 'refresh':
                                    window.location.reload();
                                    break;

                                default:
                                    if(data) {
                                        self.showResponseModal(data);
                                    } else {
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

                                $('[name="' + fldname + '"]').parents('.element-wrapper').find('.error-display').last().append('<small class="validation-error alert alert-danger form-text" role="alert">' +
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
            } catch(e) {

                console.log(e);
                return false;

            }

        

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