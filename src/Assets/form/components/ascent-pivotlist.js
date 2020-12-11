// ******
// Custom form component to enter & edit pivot records
// ******
// Code (c) Kieran Metcalfe / Ascent Creative 2020


$.ascent = $.ascent?$.ascent:{};

var PivotList = {
		
		rowCount: 0,

		_init: function () {
            
            
         //alert('ok');

			var self = this;
			this.widget = this;
			
			idAry = (this.element)[0].id.split('-');
			
			var thisID = (this.element)[0].id;
			
			var fldName = idAry[1];
			
            var obj = this.element;
            
            // build the basic UI
            var outer = $('<div class="pivotlist"></div>');

            obj.wrap(outer);

            

            outer = obj.closest('.pivotlist');

            obj.remove();
			
            var opts = self.options;
            
            //console.log(opts.data);

			if(opts.width) {
				
				if (typeof opts.width === 'string' && opts.width.slice(-1) == '%') {
					    outer.css('width', opts.width);
					} else {
						outer.css('width', opts.width + 'px');
					}
				
			} else {
				outer.css('width', '600px');
			}
			
			if (!opts.placeholder) {
				opts.placeholder = '';
			}
			
			$(outer).append('<UL class="pivotlist-list"></UL>');
			
			$(outer).find(".pivotlist-list").append('<LI class="emptyDisp">No items selected</LI>');
			
			$(outer).append('<DIV class="inputbar"><DIV class="inputwrap"><INPUT type="text" id="' + thisID + '-input" spellcheck="false" placeholder="' + opts.placeholder + '"/></DIV><!--<A href="#" id="' + thisID + '-addlink">Add</A>--></DIV>');
		
			// autocomplete and events
			$("#" + thisID + "-input").autocomplete({
				source: opts.autocompleteURL,
			    minLength: 2,
			    select: function( event, ui ) {
			    	
			    		console.log(ui);
			    	
			    		if (  $("#" + thisID + " #" + ui.item.id).length > 0 ) {
						// check for duplicates (across all source fields)
						alert ("That item has already been added.")
			    		} else {
			    			self.createBlock('', ui.item.id, ui.item.label);
			    			console.log(event);
			    			$("#" + thisID + "-input").val('');
			    		}
			     	
			     	
			     	return false;
			   
			    //	$("#" + thisID + "-input").data('idModel', ui.item.id);
			    	//$("#" + thisID + "-input").data('display', ui.item.label);
    			},
    			
			});
			
			$("#" + thisID + "-input").keypress(function(){
				$("#" + thisID + "-input").removeData();
			});
			
			
			// Add button and events
			$("#" + thisID + "-addlink").button({
				
			}).click(function (event) {
				 
				var sel = $("#" + thisID + "-input").data();
				
				if (sel['display']) {
					
					if (  $("#" + thisID + " #" + sel['idModel']).length > 0 ) {
						// check for duplicates (across all source fields)
						alert ("That item has already been added.")
					} else {
						// add block to current source field
						self.createBlock('', sel['idModel'], sel['display']);
						$("#" + thisID + "-input").removeData();
						$("#" + thisID + "-input")[0].value = "";
					
					}
					
				} else {
					alert ('Nothing Selected');
				}
				
				return false;
			});
			
			
			this.element.children('.idLinkField').each(function() {
				
				aryName = $(this).attr('id').split('-');
			
				self.createBlock($('#' + aryName[0] + '-' + aryName[1] + '-' + 'idLink')[0].value, $('#' + aryName[0] + '-' + aryName[1] + '-' + 'idModel')[0].value, $('#' + aryName[0] + '-' + aryName[1] + '-' + 'display')[0].value, aryName[1]);
				
				// remove fields
				$('#' + aryName[0] + '-' + aryName[1] + '-' + 'idModel').remove();
				$('#' + aryName[0] + '-' + aryName[1] + '-' + 'display').remove();
				$('#' + aryName[0] + '-' + aryName[1] + '-' + 'idLink').remove();
				
			}); 
			
			if (opts.allowItemDrag) {
	
				$("#" + thisID + " .HQLinkList-list").sortable({
					axis: "y",
					connectWith: '#' + thisID + ' ul',
					containment: '#' + thisID,
				
				update: function(event, ui) {
					
					console.log(opts);
					//alert (thisID);
					opts.widget.updateData();
					
				},
				
				stop: function(event, ui) {
					
				}
				
			}); 
			}
			
			$(".HQLinkList-list").disableSelection();
			
			opts.widget = this;
			
			
		},
		
		createBlock: function (idLink, idModel, display) {
			
			console.log(idLink + ' : ' + idModel + ' : ' + display);
			
			var thisID = (this.element)[0].id;
			var fldName = thisID.split('-')[1];
			var widget = this.widget;
			
			idx = $("#" + thisID + " .HQLinkList-list LI.link").length; // + 1;
			
			liStr = display;
		//	liStr += '<INPUT type="hidden" class="sourceOrder" name="' + fldName + '[' + idx + '][sourceOrder]" value="' + idx + '">';
			liStr += '<INPUT type="hidden" class="idModel" name="' + fldName + '[' + idx + '][idModel]" value="' + idModel + '">';
			liStr += '<INPUT type="hidden" class="display" name="' + fldName + '[' + idx + '][display]" value="' + display + '">';
			liStr += '<INPUT type="hidden" class="idLink" name="' + fldName + '[' + idx + '][idLink]" value="' + idLink + '">';
			liStr += '<A href="#" class="deleteLink">x</A>';
			
			safeid = idModel.replace('~', '_');
			
			
			$("#" + thisID + " .HQLinkList-list").append('<LI class="link" id="' + safeid + '">' + liStr + '</LI>');
			
			$("#" + thisID + " .HQLinkList-list LI.emptyDisp").hide();
			
			
			
			$("#" + thisID + " LI#" + safeid + " A.deleteLink").click(function (event) {
				
				
				pSrc = $(this).parents(".linklist");
				
				//$(pSrc).find("LI.link#" + safeid).remove();
				
				$(this).parents("LI.link").remove();
				
				if(pSrc.find("LI.link").length > 0) {
					pSrc.find("LI.emptyDisp").hide();
				} else {
					pSrc.find("LI.emptyDisp").show();
				}
				
				widget.updateData();
				return false;
				
			});
			
		},
		
		updateData: function() {
			
			
			
			thisID = (this.widget.element)[0].id;
			
		//	alert('updating ' + thisID);
			
			// update the sortOrder fields so they're ready for saving into the database
			// (or at least, the data heading to the database is ordered correctly...);
			//$(this).find(".sourceOrder").each(function(i) {
			//	this.value = i+1;
			//});
			
			
			
			if($(this.widget.element).find("LI.link").length > 0) {
				$(this.widget.element).find("LI.emptyDisp").hide();
			} else {
				$(this.widget.element).find("LI.emptyDisp").show();
			}
			
			
			// need to ensure all field names start with the right element id
			// i.e. if drag and drop between fields keeps the hidden fields linked to the old element id
			// data will be sent and processed incorrectly
			
			$(this.widget.element).find('LI.link').each(function(i) {
		//		alert(i);
				console.log(i);
				// regex match - does the field name begin with the right string
				fldName = thisID.split('-')[1];
				//alert(this.id);
				$(this).find('.idModel')[0].name = fldName + '[' + i + '][idModel]';
				$(this).find('.display')[0].name = fldName + '[' + i + '][display]';
				$(this).find('.idLink')[0].name = fldName + '[' + i + '][idLink]';
				//if (!this.name.match("^" + fldName)) {
			//		nameAry = this.name.split('[');
			//		this.name = fldName + '[' + (i+1) + '][' + nameAry[2];
				//}
				
			});
			
			
		}

}

$.widget('ascent.pivotlist', PivotList);
$.extend($.ascent.PivotList, {
		 
		
}); 