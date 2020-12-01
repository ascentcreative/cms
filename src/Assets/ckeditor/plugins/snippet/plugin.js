CKEDITOR.plugins.add( 'snippet',  {
	requires: 'widget',
	
	icons: 'snippet',
	
	init: function(editor) {
		
		//	alert('snippet init');
		
		editor.widgets.add('snippet', {
			button: 'Insert a Rich Text Snippet',
			dialog: 'snippet',
			
			allowedContent: 'p; div(codesnippet); div(codesnippet)[partial]; div(codesnippet)[snippetkey]; span(snippetname)',
			
			requiredContent: 'p; div(codesnippet); div(codesnippet)[partial]; div(codesnippet)[snippetkey]; span(snippetname)',
				
			template: '<div class="codesnippet" partial="snippet">Snippet: <SPAN class="snippetname">Test</SPAN></div>',
			
			upcast: function (element) {
				
				return element.name=="div" && element.hasClass('codesnippet') && element.attributes.partial == 'snippet';
			},
			
			init: function() {
				
				if (this.element.$.attributes.snippetkey != undefined) {				
					this.setData('snippetkey', this.element.$.attributes.snippetkey.nodeValue);
				} else {
					this.setData('snippetkey', '');
				}
				
				this.setData('snippetname', $(this.element.$).find('SPAN.snippet').html());
				
			},
			
			data: function() {
				//alert(this.data.gallerykey);
				//alert(this.element.$.attributes.gallerykey.);
				this.element.setAttribute('snippetkey', this.data.snippetkey);
				$(this.element.$).find('SPAN.snippetname').html(this.data.snippetname);
			}
			
			
			
		});
		
		
		CKEDITOR.dialog.add( 'snippet', this.path + 'dialogs/snippet.js');
		
		
	}
});