$.ascent = $.ascent?$.ascent:{};

var AjaxLink = {
        
    self: null,
    targetPath: null,
    responseTarget: null,
    
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

        if(obj.data('response-target')) {
            this.responseTarget = obj.data('response-target');
        }

        //$('#ajaxModal').hide();

        console.log(self.targetPath);
      
        $.ajax({ 
            
            type: 'GET',
            url: self.targetPath,
            headers: {
                'Accept' : "application/json"
            }

        }).done(function(data, xhr, request) {

            console.log(self.responseTarget);

            if (self.responseTarget) {

                switch(self.responseTarget) {

                    case 'reload':
                    case 'refresh':
                      //  alert('refreshing...');
                        window.location.reload();
                        break;


                    default:
                        $(self.responseTarget).html(data);
                    break;

                }
               
           } else {
                alert(data);
           }

        }).fail(function(data) {
            // hopefully this won't ever fail as we did the HEAD first
      
            console.log(data);
            switch(data.status) {
               

                default:
                    alert('An unexpected error occurred:\n' + data.responseJSON.message );
                    break;

            }

        });
           
        return false;
  
    } 


}

$.widget('ascent.ajaxLink', AjaxLink);
$.extend($.ascent.ajaxLink, {
		 
		
}); 

/* Assign this behaviour by link class */
$(document).on('click', 'A.ajaxLink, A.ajax-link', function(e) {

    $(this).ajaxLink();
    e.stopPropagation();
    return false; // stop the link firing normally!

});