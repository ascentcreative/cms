// ******

// ******
// Code (c) Kieran Metcalfe / Ascent Creative 2021


$.ascent = $.ascent?$.ascent:{};

var StackEdit = {
        
		rowCount: 0,

		_init: function () {
            
			var self = this;
			this.widget = this;
			
			idAry = (this.element)[0].id.split('-');
			
			var thisID = (this.element)[0].id;
			
			var fldName = idAry[1];
			
            var obj = this.element;
            
            // make the stack sortable (drag & drop)
           $(this.element).find('.stack-blocks').sortable({
                handle: '.block-handle',
                update: function(event, ui) {
                    // reapply field indexes to represent reordering
                }
            });


            //capture the submit event of the form to serialise the stack data
            $(this.element).parents('form').on('submit', function() {

                //console.log($('*[data-scope=stack-content]').serializeJSON());
               
                var data = $(self.element).find('INPUT, SELECT, TEXTAREA').not('.stack-output').serializeJSON();
                
                // remove the top level wrapper (which is just the field name):
                for(fld in data) {
                  
                    //console.log(data['fld'])

                    console.log(JSON.stringify(data[fld]));
                    $(self.element).find('.stack-output').val(
                        JSON.stringify(data[fld])
                    );

                    console.log($.parseJSON($(self.element).find('.stack-output').val()));
    

                }
//                return false;

            });

			
            // capture the click event of the add block button
            // (test for now - adds a new row block. Will need to be coded to ask user what block to add)
            $(this.element).find('.stack-add-block').on('click', function() {

                var type = 'row';
                var field = 'content';
                var idx = $(self.element).find('.block-edit').length;

            //    alert(idx);

                $.get('/admin/stackblock/make/' + type + '/' + field + '/' + idx, function(data) {
                   // $(self.element).find('.stack-output').before(data);
                   $(self.element).find('.stack-blocks').append(data);
                });

                return false;

            });


		}

}

$.widget('ascent.stackedit', StackEdit);
$.extend($.ascent.StackEdit, {
		 
		
}); 