CKEDITOR.dialog.add('snippet', function (editor) {
	return {
		
		title: 'Select Snippet',
		minWidth: 300,
		minHeight: 100,
		contents: [
		           {
		        	   id: 'info',
		        	   elements: [
		        	       {
		        	       id: 'sel_snippet',
		        	       type: 'select',
		        	       label: 'Snippet:',
		        	       items: [
		        	               [editor.lang.common.notSet, ""],
		        	       ],
		        	       setup: function(widget) {
		        	    	 
		        	    	   var element_id = '#' + this.getInputElement().$.id;
		        	    	   
		        	    	   $(element_id + ' OPTION').remove();
		        	    	   
		        	    	   var w_this = this;
		        	    	   $.ajax({
		        	               type: 'POST',
		        	               url: '/admin/snippet/jsondata',
		        	               contentType: 'application/json; charset=utf-8',
		        	               dataType: 'json',
		        	               async: false,
		        	               success: function(data) {
		        	            	   
		        	            	   $(element_id).get(0).options[$(element_id).get(0).options.length] = new Option(editor.lang.common.notSet, "");
		        	            	   
		        	                   $.each(data, function(index, item) {
		        	                       $(element_id).get(0).options[$(element_id).get(0).options.length] = new Option(item['title'], item['key']);
		        	                   });
		        	                   // after values have been added, set the field value
		        	                   w_this.setValue(widget.data.snippetkey);
		        	                   
		        	               },
		        	               error:function (xhr, ajaxOptions, thrownError){
		        	                   alert(xhr.status);
		        	                   alert(thrownError);
		        	               } 
		        	           });
		        	    	   
		        	       },
		        	       commit: function( widget ) {
		        	    	   
		        	    	   var element_id = '#' + this.getInputElement().$.id;
		        	    
		        	    	   widget.setData('snippetname', $(element_id).find(':selected').text());
		        	    	   widget.setData('snippetkey', this.getValue() );
		        	       }
		        	       
		        	    }
		        	       
		        	   ]
		           
		        	
		           
		           }
		           ]
		
	};
});