// jQuery widget to manage state items for history API
// Idea is that it allows any item to request a new pushstate, 
// but then all other items/widgets can chuck in their data too

// but, who governs the URL that the state is pushed against? Darn.

$.ascent = $.ascent?$.ascent:{};

var StateManager = {
        
    self: null,
   
    _init: function () {

       $(document).on('state-manager-push', function(e, data) {
            
            // fire off another event as a push-state-instruction, along with the timestamp?
            console.log(e);
            console.log(data);

       });

       window.addEventListener('popstate', (e) => {
               
            console.log('state manager pop', e);

            // update the content of the 'stateful-components'

            // for each, fireoff a non-bubbling 'state-updated' event - the actual component will decide if it needs to handle it.
            for(id in e.state) {
                // console.log('setting #' + id, e.state[id]);
                $('#' + id).html(e.state[id]);
                $('#' + id).trigger('state-updated');
            }


            // $(document).trigger('state-manager-pop', {key: e.state});

            // load state from local storage
            // let state = self.loadState(); 
            // apply the loaded state
            // self.setState(state);
            // self.setState(e.state);

        });

    },


    pushState: function(uri, replace=false) {

        let data = {};
        // capture the content of every '.stateful-component'
         // store in an array, keyed by ID of the element
        $('.stateful-component').each(function(idx) {

            data[$(this).attr('id')] = $(this).html();
            
        });
        
    
        // push / replace state.
        console.log('pushing state: ', data);
        if(replace) {
            history.replaceState(data, null, uri);
        } else {
            history.pushState(data, null, uri);
        }

        // $(document).trigger('state-manager-push', {key: ts});

    }

}

$.widget('ascent.statemanager', StateManager);
$.extend($.ascent.StateManager, {
		 
		
}); 

// $(document).ready(function() {
    $(document).statemanager();
// });
