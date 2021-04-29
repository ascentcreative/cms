/**
 * jQuery Cookie plugin
 *
 * Copyright (c) 2010 Klaus Hartl (stilbuero.de)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 *
 * Customised by Kieran Metcalfe to add ability to set length of cookie in seconds as well as days
 *
 */
 jQuery.cookie = function (key, value, options) {

    // key and at least value given, set cookie...
    if (arguments.length > 1 && String(value) !== "[object Object]") {
        options = jQuery.extend({}, options);

        if (value === null || value === undefined) {
            options.expires = -1;
        }

        if (typeof options.expires === 'number') {
			if (typeof options.expiretype === 'undefined') {
				options.expiretype = "days";	
			}
			
			switch (options.expiretype) {
			
				case 'seconds':
					var sec = options.expires, t = options.expires = new Date();
            		t.setSeconds(t.getSeconds() + sec);
					break;
					
				case 'minutes':
					var min = options.expires, t = options.expires = new Date();
            		t.setMinutes(t.getMinutes() + min);
					break;
					
				default:
					var days = options.expires, t = options.expires = new Date();
            		t.setDate(t.getDate() + days);
					break;
					
				
			
			}
			
            
        }

        value = String(value);

        return (document.cookie = [
            encodeURIComponent(key), '=',
            options.raw ? value : encodeURIComponent(value),
            options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
            options.path ? '; path=' + options.path : '',
            options.domain ? '; domain=' + options.domain : '',
            options.secure ? '; secure' : ''
        ].join(''));
    }

    // key and possibly options given, get cookie...
    options = value || {};
    var result, decode = options.raw ? function (s) { return s; } : decodeURIComponent;
    return (result = new RegExp('(?:^|; )' + encodeURIComponent(key) + '=([^;]*)').exec(document.cookie)) ? decode(result[1]) : null;
};
