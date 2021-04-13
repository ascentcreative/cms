// ******

// ******
// Code (c) Kieran Metcalfe / Ascent Creative 2021


$.ascent = $.ascent?$.ascent:{};

var StackBlockEdit = {
        
		itemCount: 0,

		_init: function () {

            
			var self = this;
			this.widget = this;
			idAry = (this.element)[0].id.split('-');
			var thisID = (this.element)[0].id;
			var fldName = idAry[1];
            var obj = this.element;
            
            console.log('block edit init');
            
            $(this.element).on('click', 'A.blockitem-delete', function() {
                
                if (confirm("Delete this item?")) {
                    var row = $(this).parents('.items');
                
                    $(this).parents('.blockitem').remove();

                    $(row).trigger('change');
                    if($(row).find('.blockitem').length == 0) {
                        $(row).find('.placeholder').show();
                    }
                    
                }

                return false; 
            });

         
            $(this.element).find('.items').sortable({
                handle: '.blockitem-handle',
                axis: 'x',
                forcePlaceholderSize: true,
                revert: 100,
                start: function(event, ui) {
                    $(ui.placeholder).css('height', $(ui.item).height() + 'px');
                },
                update: function(event, ui) {

                    console.log($(ui.element).parents('.items').find('.ui-sortable-placeholder'));
                    // reapply field indexes to represent reordering
                    $('.items').each(function(rowidx) {

                        $(this).find('.blockitem').each(function(idx) {

                            $(this).find('INPUT:not([type=file]), SELECT, TEXTAREA').each(function(fldidx) {
                                //  console.log(idx + ' / ' + fldidx);
                                var ary = $(this).attr('name').split(/(\[|\])/);
                                ary[10] = idx; // need to careful not to break the index used here... can we be cleveredr about it?
                                $(this).attr('name', ary.join(''));

                                $(this).change();
                                
                            });

                        });

                    });

                }

            });


            $(this.element).find('.blockitem').each(function() {
                self.initBlockItem(this);
            });

            // ITEM ADD buttons:
            $(this.element).on('click', 'A.block-add-item-text', function() {
               self.loadBlockTemplate('text');
               $(this).closest('.show').removeClass('show');
              return false;
            });

            $(this.element).on('click', 'A.block-add-item-image', function() {
                self.loadBlockTemplate('image');
                $(this).closest('.show').removeClass('show');
                return false;
             });


             $(this.element).on('click', 'A.block-add-item-video', function() {
                self.loadBlockTemplate('video');
                $(this).closest('.show').removeClass('show');
                return false;
             });

		},

        loadBlockTemplate: function(type) {

            // check there's room
            var empty = 12;
            $(this.element).find(".item-col-count").each(function() {
                empty -= parseInt($(this).val());
            });

            if (empty < 1) {
                alert('This row is full - resize the other elements to make room, or add a new row block');
                return false;
            }

            var self = this;

            stackname = $(this.element).parents('.stack-edit').attr('id');

            blockid = $(this.element).parent().children().index(this.element);

            itemid = $(this.element).find('.blockitem').length;

            blockname = stackname + "[" + blockid + "][items][" + itemid + "]";

            console.log(blockname);

            $.get('/admin/stackblock/newitem/' + type + "/" + blockname + "/" + empty, function(data) {
                // $(self.element).find('.stack-output').before(data);
                
                var newItem = $(data);
                $(self.element).find('.items').append(newItem);
                console.log(newItem);

                self.initBlockItem(newItem);

                $(self.element).find('.placeholder').hide();

                self.updateBlockIndexes();
             
             });

        },

        updateBlockIndexes: function() {

            // reapply field indexes to represent reordering
            $(this.element).find('.blockitem').each(function(idx) {

                $(this).find('INPUT:not([type=file]), SELECT, TEXTAREA').each(function(fldidx) {
                    var ary = $(this).attr('name').split(/(\[|\])/);
                    ary[10] = idx;
                    $(this).attr('name', ary.join(''));
                    $(this).change();
                   // $('#frm_edit').addClass('dirty'); //trigger('checkform.areYouSure');
                    
                });

            });

            

        },

        initBlockItem: function(item) {

            $(item).resizable({
                handles: 'e',
                placeholder: 'ui-state-highlight',
                create: function( event, ui ) {
                    // Prefers an another cursor with two arrows
                    $(".ui-resizable-handle").css("cursor","ew-resize");
                },
                start: function(event, ui){
                    // sibTotalWidth = ui.originalSize.width + ui.originalElement.next().outerWidth();
                    console.log(ui.size);

                    var colcount = 12; // change this to alter the number of cols in the row.

                    var colsize = $(ui.element).parents('.items').width() / colcount;
                    // set the grid correctly - allows for window to be resized bewteen...
                    $(ui.element).resizable('option', 'grid', [ colsize, 0 ]);
                    

                    /**
                     * old code - fixed items to a single row. 
                     */
                    
                    // calc the max possible width for this item (to prevent dragging larger than the row)
                    // get the col counts of items in the row
                    var filled = 0;
                    $(ui.element).parents('.items').find('.blockitem').each(function() {
                        filled += parseInt($(this).find('.item-col-count').val());
                        console.log(filled);
                    });
                    // subtract the col count of this item
                    filled -= $(ui.element).find('.item-col-count').val();

                    // the difference is the max number of cols this can fill
                    empty = (colcount - filled);

                    console.log(empty);

                    // multiply to get a total max width.
                    $(ui.element).resizable('option', 'maxWidth', colsize * (colcount - filled));
                    

                    /** new code - just set max to row width. **/
                    //$(ui.element).resizable('option', 'maxWidth', $(ui.element).parents('.items').width());


                },

                resize: function(event, ui) {
                
                    console.log(ui.size.width + " :: " + $(ui.element).parents('.items').width());

                    // calculate the number of cols currently occupied and write to the col-count field
                    cols = (ui.size.width / $(ui.element).parents('.items').width()) * 12; // need to pull this from the same parameter as in 'start' - should probably widgetise this code...
                    console.log(Math.round(cols));
                    $(ui.element).find('.item-col-count').val(Math.round(cols));

                    
                },

                stop: function(event, ui) {

                    //$(ui.element).css('width', $(ui.element).width() + 'px');

                    var pct = $(ui.element).width() / $(ui.element).parents('.items').width() *100;
                    $(ui.element).css('width', pct + '%');

                    $(ui.element).trigger('change');
                }

            });

        }

}

$.widget('ascent.stackblockedit', StackBlockEdit);
$.extend($.ascent.StackBlockEdit, {
		 
		
}); 