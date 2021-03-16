$.ascent = $.ascent?$.ascent:{};

var ModalLink = {
        
    self: null,
    
    _init: function () {
        
        var self = this;
        this.widget = this;
        var thisID = (this.element)[0].id;
        var obj = this.element;
        
        // We're calling this on click, so just launch straight into the business end...

        // get the href and fire off a request
        $.get($(this.element).attr('href'))

            .done(function(data) {
            
            //success: function(data) {

                // put the response in a modal
                
                // or do we assume that the returned blade view is a modal already?

               // alert(data);
               console.log(data);
                $('body').append(data);
                $('#ajaxModal').modal();

                $('#ajaxModal').on('hidden.bs.modal', function() {
                    $(this).remove();
                })

            })
            .fail(function(data) {

                // error: function(data) {

                alert('There was an error...');

            });

        //});

        return false; // stop the link firing normally!
        
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