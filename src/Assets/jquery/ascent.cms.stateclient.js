// jQuery widget to manage state items for history API
// Idea is that it allows any item to request a new pushstate, 
// but then all other items/widgets can chuck in their data too

// but, who governs the URL that the state is pushed against? Darn.

$.ascent = $.ascent?$.ascent:{};

var StateClient = {
        
    self: null,
   
    _init: function () {

       $(document).on('push-state', function(e) {


            
       });
                    
    },

  

}

$.widget('ascent.stateclient', StateClient);
$.extend($.ascent.StateClient, {
		 
		
}); 

$(document).ready(function() {
    $(document).stateclient();
});
