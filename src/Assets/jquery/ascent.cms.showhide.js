$.ascent = $.ascent?$.ascent:{};

// Show / Hide elements based on values of other fields
// - Basic version - fires on a change event, specify a single field to monitor, hide-if/show-if values to check against
// Very likely I'll need to make this cleverer in future...

var ShowHide = {
        
    self: null,
   
    _init: function () {

        let self = this;
        console.log('init ShowHide');
        $(document).on('change', this.process); 

        // need a call here to run all rules to set default state.
        // find all elements with data-showhide set and evaluate their rules.
        // more processor heavy than the incremental update on change...
        $('[data-showhide]').each(function(idx) {
            self.evaluateRule(this);
        });
        
    },

    // Process an event and toggle the changes needed.
    process: function(e) {
        console.log("processing");
        console.log($(e.target).attr('name'));
        let field = $(e.target).attr('name');

        let value = $(e.target).val();
        if($(e.target).attr('type') == 'checkbox' && !$(e.target).is(":checked")) {
            value = '';
        }
        
        
        console.log($(e.target).serialize());
        // get all elements with a rule based on this field.

        let elms = $('[data-showhide="' + field + '"]');

        console.log(elms.length + ' dependent elements');

        // let self = this;
        $(elms).each(function(idx) {

            // console.log(self);
            $(document).showhide('evaluateRule', this, value);

        });

    },

    evaluateRule: function(elm, value=null) {

        if (value === null) {
            // lookup the value if not supplied from the event:
            source = $('[name="' + $(elm).attr('data-showhide') + '"]').last();
            value = source.val();
            if(source.attr('type') == 'checkbox' && !source.is(":checked")) {
                value = '';
            }
        }

        if($(elm).attr('data-hide-if')) {

            if ($(elm).attr('data-hide-if') == value) {
                
                if($(elm).attr('data-showhide-animate') == 0) {
                    $(elm).hide();
                } else {
                    $(elm).slideUp('fast');
                }

            } else {
                if($(elm).attr('data-showhide-animate') == 0) {
                    $(elm).show();
                } else {
                    $(elm).slideDown('fast');
                }
            }

        } else if($(elm).attr('data-show-if')) {

            if ($(elm).attr('data-show-if') == value) {
                
                if($(elm).attr('data-showhide-animate') == 0) {
                    $(elm).show();
                } else {
                    $(elm).slideDown('fast');
                }
                
            } else {
                if($(elm).attr('data-showhide-animate') == 0) {
                    $(elm).hide();
                } else {
                    $(elm).slideUp('fast');
                }
            }


        }






    }


}

$.widget('ascent.showhide', ShowHide);
$.extend($.ascent.ShowHide, {
		 
		
}); 

// $(document).ready(function() {
    $(document).showhide();
// });

/* Assign this behaviour by link class */
// $(document).on('click', 'A.modalLink, A.modal-link', function(e) {

//     $(this).modalLink();
//     e.stopPropagation();
//     return false; // stop the link firing normally!

// });