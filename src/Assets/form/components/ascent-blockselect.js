// ******

// ******
// Code (c) Kieran Metcalfe / Ascent Creative 2021


$.ascent = $.ascent?$.ascent:{};

var BlockSelect = {

    _init: function () {

        var self = this;
        self.trackOrder = [];
        
        $(this.element).on('change', '.cms-blockselect-option INPUT', function() {

            if($(this).is(':checked')) {
                $(this).parents('.cms-blockselect-option').addClass('selected');

                self.trackOrder.push($(this).attr('id'));

                if(self.element.data('max-select') != -1 && self.trackOrder.length > self.element.data('max-select')) {
                    elm = self.trackOrder.shift();
                    $('.cms-blockselect-option INPUT#' + elm).prop('checked', false).parents('.cms-blockselect-option').removeClass('selected');
                }

            } else {
               
                $(this).parents('.cms-blockselect-option').removeClass('selected');

                self.trackOrder.splice(self.trackOrder.indexOf($(this).attr('id')), 1);    
            }

            
   
        });
        
    }

}

$.widget('ascent.blockselect', BlockSelect);
$.extend($.ascent.BlockSelect, {
		 
		
}); 

$(document).ready(function(){
    $('.cms-blockselect').blockselect();
});