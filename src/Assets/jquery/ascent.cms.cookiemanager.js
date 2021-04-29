
// Code (c) Kieran Metcalfe / Ascent Creative 2014
// Code may be used as part of a site built and hosted by Ascent Creative, but may not be transferred to 3rd parties
// Wrapper for the Flickr Justified-Layout code - handles the layout for a given collection of images

$.ascent = $.ascent?$.ascent:{};

var CookieManager = {
		
		// Default options.
	    // options: {
	    //     types: {
	    //     		'essential': {title: "Essential Cookies", text: 'These cookies are required for the operation of the site and cannot be disabled.', mandatory: true},
	    //     	    'analytics': {title: "Analytics", text: 'Analytics cookies help us to monitor traffic and trends in usage of the site. They are anonymous and a huge help to us, but are not required.'},
	    //     	    'functionality': {title: "Functionality", text: 'While not strictly necessary, some cookies are used to store preferences and choices you have made. They provide a better experience on the site, but are not required.'},
	    //     	    'thirdparty': {title:"Third Party", text: 'Some of the features of the site require cookies from third parties. These are not required, but if you choose not to allow them, those features will not be available.'}
	    //     }
	        
	    // },

		_init: function () {

            var self = this;
			this.widget = this;
				
			var cookieCount = 0;
			var typeCount = 0;
			
			for (item in self.options.types) {
				
				var crumb = $.cookie('acm_' + item);
				
				if (crumb) {
					cookieCount++;
				} 
				
				typeCount++;
				
			}
			
			if (cookieCount == 0) {
				//var status = 'new';
				self.prompt(false);
				
			} else if (cookieCount == typeCount) {
				
				self.action();
				
				//var status = 'ok';
			} else {
				
				self.prompt(true)
				//var status = 'changed';
			}
			
			self.action();
		
		
			var opts = self.options;
			
			$(window).on('resize', function() {
			//	self.layout();
			});
			
			//self.layout();
			
            $('.acm_manage').on('click', function() {
                $('#acm_modal').modal('show');
            });
			
		},
		
		manage: function() {
			this.prompt('manage');
		},
		
		
		prompt: function(changed) {
			
			var acm = this;
			
			// switch(state) {
			
                // case 'manage':
                //         var headertext = "<H3>Manage your cookie settings</H3>";
                //         var formopen = true;
                //     break;
                    
                // case 'changed':
            //             var headertext = "Our cookies have changed - please review your preferences.";
            //             var formopen = false;
                    
			// 	default:
			// 		var headertext = "We use cookies on this site, but we need to know you\'re ok with that:";
			// 		var formopen = false;
			// 	break
			
			// }
			

            if(changed) {
                var headertext = "Our cookies have changed - please review your preferences.";
            }
			
			// $('BODY').append('<DIV id="acm_wrap"><DIV id="acm_prompt" class="' + (formopen?'acm_formopen':'') + '"><DIV id="acm_summary"><DIV id="acm_header">' + headertext + '</DIV> <P><A class="button nochevron" id="acm_acceptall">Accept All Cookies</A></P><A id="acm_choose" href="#">Let me choose</A></DIV></DIV></DIV>');
			
			// $('#acm_prompt').append('<DIV id="acm_details"/>');
			
			// for (item in acm.options.types) {
			
			// 	var type = acm.options.types[item];
				
			// 	if(type.mandatory || $('#acm_' + item).length > 0) {
					
			// 		$('#acm_details').append(

			// 			'<DIV class="acm_detailitem'  + (type.mandatory?' acm_mandatory':'') + ($.cookie('acm_' + item) == '1'?' acm_selected':'') + '" id="acm_details_' + item + '"><LABEL for="acm_select_' + item + '"><H3>' + type.title + '</H3><P>' + type.text + '</P></LABEL></DIV>'
							
			// 		);
					
			// 	}
				
			// }
			
			$('.acm_cookietype').on('click', function() {
				$(this).toggleClass('acm_selected');
			});
			
			// $('#acm_details').append('<P><A href="#" class="button nochevron" id="acm_acceptselected">Accept selected types</A></P>');
			
			$('.acm_acceptselected').on('click', function() {
				
				//for (item in acm.options.types) {

                $('.acm_cookietype').each(function() {

                    if ($(this).hasClass("acm_selected") || $(this).hasClass("acm_mandatory")) { //acm.options.types[item].mandatory || $('#acm_details_' + item).hasClass('acm_selected')) {

						$.cookie($(this).attr('data-cookie'), '1', {path: '/', expires: 365} );
						
					} else {
						
						$.cookie($(this).attr('data-cookie'), '0', {path: '/', expires: 365} );
						
					}

                });
					
				//}
				
				$('#acm_wrap').fadeOut(); //remove();
				
				acm.action();
				
				$('#acm_wrap').remove();

                $('#acm_modal').modal('hide');

				return false;
			});
			
			
			$('#acm_wrap').fadeIn();
			
			$('.acm_acceptall').on('click', function() { 

               // console.log('all');
				
                $('.acm_cookietype').each(function() {
                    $.cookie($(this).attr('data-cookie'), '1', {path: '/', expires: 365} );
                    $(this).addClass("acm_selected");
                });

				$('#acm_wrap').fadeOut(); //remove();
				
				acm.action();
				
				$('#acm_wrap').remove();

                $('#acm_modal').modal('hide');
				
				return false;
				
			});
			
			$('A#acm_choose').on('click', function() {
				
				$('#acm_choose').hide();
				// $('#acm_details').slideDown();
				
				return false;
				
			});
			
		},
		
		action: function() {
			
			var acm = this;
		
            $('.acm_cookietype').each(function() {

                // if the cookie is set to YES, copy the template into the DOM.
				
                if ($.cookie($(this).attr('data-cookie')) == '1') { 
			    
                    console.log($(this).attr('data-cookie'));

                    var template = $('template#' + $(this).attr('data-cookie'));
                    
                    if ($(template).length > 0) {
                        $('body').append(template.html());
                    }
				
				}

            });
				
                
		},
		
		check: function(type) {
			
			var val = $.cookie('acm_' + type);
			
			if (!val) {
				alert ('is null');
				return false;
			}
			if (val == '0') {
				alert ('is NO');
				return false;
			}
			if(val=='1') {
				alert ('is YES');
				return true;
			}
			
			
		},
		
		set: function(opts)  {
			
			// try to set a cookie, but if only if the relevant type agrees!
			
			
		}
		
		

}

$.widget('ascent.cookiemanager', CookieManager);
$.extend($.ascent.CookieManager, {
		 
		
}); 

$(document).ready(function() {
	$(document).cookiemanager();
});
