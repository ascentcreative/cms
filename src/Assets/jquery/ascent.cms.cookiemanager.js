
// Code (c) Kieran Metcalfe / Ascent Creative 2022
// Code may be used as part of a site built and hosted by Ascent Creative, but may not be transferred to 3rd parties

$.ascent = $.ascent?$.ascent:{};

var CookieManager = {
		

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
			
            $('.acm_manage').on('click', function(e) {
                e.preventDefault();
                $('#acm_modal').modal('show');
            });

            $('a[href$="manage-cookies"]').on('click', function(e) {
                e.preventDefault();
                $('#acm_modal').modal('show');
            });
			
		},
		
		manage: function() {
			this.prompt('manage');
		},
		
		
		prompt: function(changed) {
			
			var acm = this;

            if(changed) {
                var headertext = "Our cookies have changed - please review your preferences.";
            }
	
			
			$('.acm_cookietype').on('click', function() {
				$(this).toggleClass('acm_selected');
			});
			
			
			$('.acm_acceptselected').on('click', function() {
				
                $('.acm_cookietype').each(function() {

                    if ($(this).hasClass("acm_selected") || $(this).hasClass("acm_mandatory")) { //acm.options.types[item].mandatory || $('#acm_details_' + item).hasClass('acm_selected')) {

						$.cookie($(this).attr('data-cookie'), '1', {path: '/', expires: 365} );
						
					} else {
						
						$.cookie($(this).attr('data-cookie'), '0', {path: '/', expires: 365} );
						
					}

                });
					
				
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


                    var headtemplate = $('template#' + $(this).attr('data-cookie') + '_head');

                    if ($(headtemplate).length > 0) {
                        $('head').append(headtemplate.html());
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
