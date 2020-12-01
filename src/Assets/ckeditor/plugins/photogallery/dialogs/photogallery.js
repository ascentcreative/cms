CKEDITOR.dialog.add('photogallery', function (editor) {
	return {
		
		title: 'Select Photo Gallery',
		minWidth: 300,
		minHeight: 100,
		contents: [
		           {
		        	   id: 'info',
		        	   elements: [
		        	       {
		        	       id: 'sel_gallery',
		        	       type: 'select',
		        	       label: 'Gallery:',
		        	       items: [
		        	               [editor.lang.common.notSet, ""],
		        	       ],
		        	       setup: function(widget) {
		        	    	 
		        	    	   var element_id = '#' + this.getInputElement().$.id;
		        	    	   
		        	    	   $(element_id + ' OPTION').remove();
		        	    	   
		        	    	   var w_this = this;
		        	    	   $.ajax({
		        	               type: 'POST',
		        	               url: '/admin/gallery/jsondata',
		        	               contentType: 'application/json; charset=utf-8',
		        	               dataType: 'json',
		        	               async: false,
		        	               success: function(data) {
		        	            	   
		        	            	   $(element_id).get(0).options[$(element_id).get(0).options.length] = new Option(editor.lang.common.notSet, "");
		        	            	   
		        	                   $.each(data, function(index, item) {
		        	                       $(element_id).get(0).options[$(element_id).get(0).options.length] = new Option(item['title'], item['key']);
		        	                   });
		        	                   // after values have been added, set the field value
		        	                   w_this.setValue(widget.data.gallerykey);
		        	                   
		        	               },
		        	               error:function (xhr, ajaxOptions, thrownError){
		        	                   alert(xhr.status);
		        	                   alert(thrownError);
		        	               } 
		        	           });
		        	    	   
		        	       },
		        	       commit: function( widget ) {
		        	    	   
		        	    	   var element_id = '#' + this.getInputElement().$.id;
		        	    
		        	    	   widget.setData('galleryname', $(element_id).find(':selected').text());
		        	    	   widget.setData('gallerykey', this.getValue() );
		        	       }
		        	       
		        	    }
		        	       
		        	   ]
		           
		        	
		           
		           }
		           ]
		
	};
});