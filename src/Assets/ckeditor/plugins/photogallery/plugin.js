CKEDITOR.plugins.add( 'photogallery',  {
	requires: 'widget',
	
	icons: 'photogallery',
	
	init: function(editor) {
		
		editor.widgets.add('photogallery', {
			button: 'Insert a photo gallery',
			dialog: 'photogallery',
			
			allowedContent: 'p; div(codesnippet); div(codesnippet)[partial]; div(codesnippet)[gallerykey]; span(galleryname)',
			
			requiredContent: 'p; div(codesnippet); div(codesnippet)[partial]; div(codesnippet)[gallerykey]; span(galleryname)',
				
			template: '<div class="codesnippet" partial="photogallery">Gallery: <SPAN class="galleryname">Test</SPAN></div>',
			
			upcast: function (element) {
				
				return element.name=="div" && element.hasClass('codesnippet') && element.attributes.partial == 'photogallery';
			},
			
			init: function() {
				
				if (this.element.$.attributes.gallerykey != undefined) {				
					this.setData('gallerykey', this.element.$.attributes.gallerykey.nodeValue);
				} else {
					this.setData('gallerykey', '');
				}
				
				this.setData('galleryname', $(this.element.$).find('SPAN.galleryname').html());
				
			},
			
			data: function() {
				//alert(this.data.gallerykey);
				//alert(this.element.$.attributes.gallerykey.);
				this.element.setAttribute('gallerykey', this.data.gallerykey);
				$(this.element.$).find('SPAN.galleryname').html(this.data.galleryname);
			}
			
			
			
		});
		
		
		CKEDITOR.dialog.add( 'photogallery', this.path + 'dialogs/photogallery.js');
		
		
	}
});