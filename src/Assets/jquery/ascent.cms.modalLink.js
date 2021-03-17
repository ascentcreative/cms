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

        console.log(self.targetPath);
      
        $.get(self.targetPath).done(function(data, xhr, request) {

            var cType = request.getResponseHeader('content-type');

            if(cType.indexOf('text/html') != -1) {
                self.showResponseModal(data);
            } else {

                window.location.href = self.targetPath;
                
            }



        }).fail(function(data) {
            // hopefully this won't ever fail as we did the HEAD first
      
            console.log(data);
            switch(data.status) {
                case 401:
                   
                    //fire off a request to the login form instaead.
                    $.get(self.loginPath + '?intended=' + self.targetPath).done(function(data) {
                        self.showResponseModal(data);
                    }).fail(function(data) {
                        console.log('FAIL WITHIN FAIL!');
                        console.log(data.responseText);

                    });


                    break;

                default:
                    alert('There was an error...');
                    break;

            }

        });
           
        return false;

        // get the href and fire off a request
        $.get($(this.element).attr('href'))

            .done(function(data, status, request) {

                console.log(request.getAllResponseHeaders());
                //if ()
                self.showResponseModal(data);               

            })
            .fail(function(data) {

                // error: function(data) {
                console.log(data);
                switch(data.status) {
                    case 401:
                        alert('Ah - unaiutheorissed');
                        break;

                    default:
                        alert('There was an error...');
                        break;

                }

               

            });

        //});

        return false; // stop the link firing normally!
        
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
        $('#ajaxModal').on('hidden.bs.modal', function() {
            $(this).remove();
        });

        // all done

    }

}

$.widget('ascent.modalLink', ModalLink);
$.extend($.ascent.ModalLink, {
		 
		
}); 

// this way?
// $(document).ready(function() {

//     $('A.modalLink').modalLink();

// });

// or this? Allows for dynamically added ones. Try this frist...
$(document).on('click', 'A.modalLink, A.modal-link', function(e) {

    console.log('captured');

    
    $(this).modalLink();

    
    e.stopPropagation();
    return false; // stop the link firing normally!

});