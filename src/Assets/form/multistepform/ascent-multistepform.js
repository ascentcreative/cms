// ******

// ******
// Code (c) Kieran Metcalfe / Ascent Creative 2022


$.ascent = $.ascent?$.ascent:{};

/*
 * THE HOST FORM
 */

var MultiStepForm = {

    _steps: null,

    _init: function () {

        var self = this;

        this._steps = $(this.element).find('.msf-step').multistepformstep();


        // remove the back button from the first step
        $(this._steps[0]).find('.msf-back').remove();

        $(this._steps[0]).multistepformstep('show');

        // handler for step-complete event (validation handled in the step)
        $(this.element).on('step-complete', function(e) {
           
            let nextStep = $(e.target).nextAll('.msf-step:not(.msf-disabled)').first()[0];
            
            if(nextStep) {
                  // if there's a next step, display it
                $(e.target).multistepformstep('hide');
                $(nextStep).multistepformstep('show');
            } else {
                // if not, we're on the final step, so we post the data (by simply submitting the form)
                $(self.element).submit();

            }


        });

        // back button handler
        $(this.element).on('step-back', function(e) {
  
            $(e.target).multistepformstep('hide');
            $(e.target).prevAll('.msf-step:not(.msf-disabled)').first().multistepformstep('show');

        });
        
    }, 

    setOptions: function($opts) {

        // replace the existing options with the provided array

    }, 

    disableStep: function($key) {
        // alert('disabling...');
        $('#msf-step-' + $key).multistepformstep('disable');
    },

    enableStep: function($key) {
        // alert('enabling...');
        $('#msf-step-' + $key).multistepformstep('enable');
    }

}


/*
 *   FORM STEP
 */

var MultiStepFormStep = {


    _init: function () {

       var self = this;

       // console.log(this);

    //    cosnsole.log($(this.element).data('validators'));

        // console.log($(this).attr('data-validators'));

       $(this.element).on('click', '.msf-continue', function() {
            if( self.validate() ) {
                // advance to next step.
                $(self.element).trigger('step-complete');
            }
       });

       $(this.element).on('click', '.msf-back', function() {
           // return to previous step (note - no validation needed)
            $(self.element).trigger('step-back');
        });

  
        
    }, 

    setOptions: function($opts) {

        // replace the existing options with the provided array

    },


    validate: function() {

        let success = false;

        let self = this;
        
        // clear any existing form errors
        $('.error-display').html('');

        console.log($(this.element).parents('form').serialize());
        
        $.ajax({
            url: '/msf-validate',
            method: 'post',
            data: {
                input: $(this.element).parents('form').serialize(),
                validators: $(self.element).data('validators')
            },
            async: false,
            headers: {
                'Accept' : "application/json"
            }
        }).done(function() {
        
            success = true;

        }).fail(function(data) {

            // console.log(data.responseJSON.errors);

            switch(data.status) {
                case 422:
                    // validation fail
                    // alert(data.responseJSON.errors);

                    // console.log(data.responseJSON.errors);

                    // console.log(flattenObject(data.responseJSON.errors));

                    let errors = flattenObject(data.responseJSON.errors);

                    for(fldname in errors) { 

                        val = errors[fldname];

                        if(typeof val == 'object') {
                            //fldname = fldname + '[]';
                            val = Object.values(val).join('<BR/>');
                        }

                        console.log(fldname);

                        msg = val;

                        // $('[name="' + fldname + '"], [name="' + fldname + '[]"]').parents('.element-wrapper').find('.error-display').last().append('<small class="validation-error alert alert-danger form-text" role="alert">' +
                        //     msg + 
                        // '</small>');

                        $('.error-display[for="' + fldname + '"]').append('<small class="validation-error alert alert-danger form-text" role="alert">' +
                        msg + 
                        '</small>');

                    }

                    // need to display these errors:
                break;

                default:
                    // something else
                    alert(data.statusText + " - " + data.responseJSON.message);
            }

        });

        return success;

    },

    // removes the step from the form flow
    disable: function() {
        console.log(this);

        $(this.element).addClass('msf-disabled');
        $('#progress-' + $(this.element).data('stepslug')).addClass('msf-disabled');

    },

    // adds the step back into the form flow
    enable: function() {
        $(this.element).removeClass('msf-disabled');
        $('#progress-' + $(this.element).data('stepslug')).removeClass('msf-disabled');
    },

    show: function() {
        $('ol li.current').removeClass('current');
        $('#progress-' + $(this.element).data('stepslug')).addClass('current');
        $(this.element).show(); //fadeIn('fast');
    },

    hide: function() {
        $(this.element).hide() //fadeOut('fast');
    }

}

$.widget('ascent.multistepformstep', MultiStepFormStep);
$.extend($.ascent.MultiStepFormStep, {
		
}); 

$.widget('ascent.multistepform', MultiStepForm);
$.extend($.ascent.MultiStepForm, {
		
}); 

$(document).ready(function(){
    $('form.multistepform').multistepform();
});


function flattenObject(ob) {
    var toReturn = {};

    for (var i in ob) {
        if (!ob.hasOwnProperty(i)) continue;

        if ((typeof ob[i]) == 'object' && ob[i] !== null) {
            var flatObject = flattenObject(ob[i]);
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