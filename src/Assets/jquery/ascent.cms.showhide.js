$.ascent = $.ascent?$.ascent:{};

// Show / Hide elements based on values of other fields
// - Basic version - fires on a change event, specify a single field to monitor, hide-if/show-if values to check against
// Very likely I'll need to make this cleverer in future...

var ShowHide = {
        
    self: null,
   
    _init: function () {

        let self = this;
        $(document).on('change', this.process); 

        // need a call here to run all rules to set default state.
        // find all elements with data-showhide set and evaluate their rules.
        // more processor heavy than the incremental update on change...
        $('[data-showhide]').each(function(idx) {
            // console.log("this");
            self.evaluate(this, null, false);
        });

        // mutation observer to run on newly added elements:
        MutationObserver = window.MutationObserver || window.WebKitMutationObserver;

        var observer = new MutationObserver(function(mutations, observer) {
            $('[data-showhide]').each(function(idx) {
                self.evaluate(this);
            });
        });

        // run on changes to the childList across the subtree
        observer.observe(document, {
            subtree: true,
            childList: true
        });
                    
    },

    // Process an event and toggle the changes needed.
    process: function(e) {
        // console.log("processing", e);
        // console.log($(e.target).attr('name'));
        let field = $(e.target).attr('name');

        let value = $(e.target).val();
        if($(e.target).attr('type') == 'checkbox' && !$(e.target).is(":checked")) {
            value = '';
        }
        
        
        // console.log($(e.target).serialize());
        // get all elements with a rule based on this field.

        let elms = $('[data-showhide="' + field + '"]');

        // console.log(elms.length + ' dependent elements');

        // let self = this;
        $(elms).each(function(idx) {

            // console.log(self);
            $(document).showhide('evaluate', this, value);

        });

    },

    evaluate: function(elm, value=null, animate=true) {

        if (value === null) {
            // lookup the value if not supplied from the event:
            source = $('[name="' + $(elm).attr('data-showhide') + '"]').last();
            if(source.attr('type') == 'checkbox' || source.attr('type') == 'radio') {
                checked = $('[name="' + $(elm).attr('data-showhide') + '"]:checked')[0];
                if(checked) {
                    source = $(checked);
                }
            }
            value = source.val();
            if(source.attr('type') == 'checkbox' && !source.is(":checked")) {
                value = '';
            }
        }

        // console.log('animate?', animate);

        if($(elm).attr('data-hide-if')) {

            if (this.valueMatch($(elm).attr('data-hide-if'), value)) {
                
                if(animate && $(elm).attr('data-showhide-animate') != 0) {
                    $(elm).slideUp('fast');
                } else {
                    $(elm).hide();
                }

            } else {
                if(animate && $(elm).attr('data-showhide-animate') != 0) {
                    $(elm).slideDown('fast');
                } else {
                    $(elm).show();
                }
            }

        } else if($(elm).attr('data-show-if')) {

            if (this.valueMatch($(elm).attr('data-show-if'), value)) {
                
                if(animate && $(elm).attr('data-showhide-animate') != 0) {
                    $(elm).slideDown('fast');
                } else {
                    $(elm).show();
                }
                
            } else {
                if(animate && $(elm).attr('data-showhide-animate') != 0) {
                    $(elm).slideUp('fast');
                } else {
                    $(elm).hide();
                }
            }


        }






    }, 

    valueMatch: function(rule, value) {

        // first, is check an array (i.e. does it have | separators)
        rule = rule.split('|');
        
        // quick sweep for actual values:
        if (rule.indexOf(value) !== -1) {
            return true;
        }

        // null value matcher
        if (rule.indexOf('@null') !== -1 && value == '') {
            return true;
        }

        // not null matcher
        if (rule.indexOf('@notnull') !== -1 && value != '') {
            return true;
        }

        return false;
        
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