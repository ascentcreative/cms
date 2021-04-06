/**
 * @license Copyright (c) 2003-2020, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_config.html
	
	config.skin = "bootstrapck";
	config.width = 800;
	//config.height = 600;
	config.contentsCss = '/css/fck_editorarea.css';
	config.extraAllowedContent = 'div(codesnippet)[*]; codesnippet[contenteditable]; codesnippet[partial]';
	config.disallowedContent = 'div[dir]';
	config.extraPlugins = 'font,richcombo,justify,colorbutton,floatpanel,button,panel,panelbutton';
	config.basicEntities = false;
	
	
	
	config.toolbar_admin = [
	              	//{ name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
	              	{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
	              	{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
	              	{ name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
	              	//'/',
	              	{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
	              	{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
	              	
	              	{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
	              	{ name: 'insert', items: [ 'Image', 'Photogallery', 'Snippet', 'Table', 'HorizontalRule' ] },
	              	//'/',
	              	{ name: 'styles', items: [ 'Format', 'FontSize' ] },
	              	{ name: 'colors', items: [ 'TextColor' ] },
	              	{ name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
	              	{ name: 'others', items: [ '-' ] },
	              	{ name: 'about', items: [ 'Source' ] }
	              	
	              ];
	
	config.toolbar_basic = [
		[ 'Bold', 'Italic', 'Underline', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', '-', 'NumberedList', 'BulletedList', '-',  'Link', 'Unlink' ]
	];
	
	
	

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'about' }
	];

	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript,about';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';
	
	
	
	
	
};
