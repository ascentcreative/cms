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


        /* I think, actually, we should read these from the loaded Modal... 
            Makes it more flexible in a run of dialogs so each can be specified individually */

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

            $(self.element).parents(".dropdown-menu").dropdown('toggle');

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
                    // responseType: 'blob',
                    xhr: function () {
                        var xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function () {

                        //   alert('here');
                        if (xhr.readyState == 2) {
                            
                            // detect if we're getting a file in the response
                            var disposition = xhr.getResponseHeader('content-disposition');
                            if (disposition && disposition.indexOf('attachment') !== -1) {
                                // if so, we'll interpret it as an arraybuffer (to create a BLOB to return to the user)
                                xhr.responseType = "arraybuffer";
                            } else {
                                // no attachment? Must be text-based / json / html etc
                                xhr.responseType = "text";
                            }
                           
                        }
                            
                        };
                        return xhr;
                    },
                    data: formData,
                    statusCode: {
                        200: function(data, xhr, request) {

                            var disposition = request.getResponseHeader('content-disposition');
                            
                            if (disposition && disposition.indexOf('attachment') !== -1) {
                                /** INCOMING DOWNLOAD!  */
                                // convert to a blob and pass to the DOM as an object which gets downloaded.
                               
                                var contentType = request.getResponseHeader('content-type');
                               
                                var file = new Blob([data], { type: contentType });

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
                                        $(document).trigger({
                                            type: 'modal-link-response',
                                            response: data
                                        });
                                        $('#ajaxModal').modal('hide');
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

                            if(data.responseJSON.hard) {
                                window.location = data.responseJSON.url;
                                return;
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

                            console.log(422);
                            console.log(data.responseJSON.errors);

                            let errors = self.flattenObject(data.responseJSON.errors);

                            for(fldname in errors) { 

                                let undotArray = fldname.split('.');
                                for(i=1;i<undotArray.length;i++) {
                                    undotArray[i] = '[' + undotArray[i] + ']';
                                }
                                aryname = undotArray.join('');

                                val = errors[fldname];

                                if(typeof val == 'object') {
                                    //fldname = fldname + '[]';
                                    val = Object.values(val).join('<BR/>');
                                }
                            
                                $('.error-display[for="' + aryname + '"]').append('<small class="validation-error alert alert-danger form-text" role="alert">' +
                                val + 
                                '</small>');

                            }
                        },
                        500: function(data, xhr, request) {

                            alert('An unexpected error occurred:' + "\n\n" + data.responseJSON.message);
                        

                        }
                    }
                });
            } catch(e) {

                console.log(e);
                return false;

            }

        

            return false;


        });

       

    },

    
    flattenObject: function (ob) {
        var toReturn = {};

        for (var i in ob) {
            if (!ob.hasOwnProperty(i)) continue;

            if ((typeof ob[i]) == 'object' && ob[i] !== null) {
                var flatObject = this.flattenObject(ob[i]);
                for (var x in flatObject) {
                    if (!flatObject.hasOwnProperty(x)) continue;

                    toReturn[i + '.' + x] = flatObject[x];
                }
            } else {
                toReturn[i] = ob[i];
            }
        }
        return toReturn;
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
