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

        this.targetPath = $(this.element).attr('href');
        
        // We're calling this on click, so just launch straight into the business end...

       // window.location.href = $(this.element).attr('href');

        // run a type check:
        $.ajax({
            type: 'HEAD',
            url: self.targetPath
        }).done(function(data, xhr, request) {

            // check the response is one a modal can handle!
            //console.log(request.getAllResponseHeaders());
            console.log(request.getResponseHeader('content-type'));
       //     return false;

         //   if(request.getResponseHeader('content-type').indexOf('text/html') != -1) {

         console.log(request);
                // fire off the live request
                $.get(self.targetPath).done(function(data) {
                    self.showResponseModal(data);
                }).fail(function() {
                    // hopefully this won't ever fail as we did the HEAD first
                });

          //  } else {

                window.location.href = self.targetPath;

          //  }


        }).fail(function(data) {

            console.log(data);
            switch(data.status) {
                case 401:
                   
                    //fire off a request to the login form instaead.
                    $.get(self.loginPath + '?intended=' + self.targetPath).done(function(data) {
                        self.showResponseModal(data);
                    }).fail(function(data) {
                        // hopefully this won't ever fail as we did the HEAD first
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

      //  console.log(data);
        $('body').append(data);
        $('#ajaxModal').modal();

        $('#ajaxModal').on('hidden.bs.modal', function() {
            $(this).remove();
        });

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
$(document).on('click', 'A.modalLink, A.modal-link', function() {

    $(this).modalLink();
    
    return false; // stop the link firing normally!

});