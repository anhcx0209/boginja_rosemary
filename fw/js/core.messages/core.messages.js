// Popup messages
//-----------------------------------------------------------------
jQuery(document).ready(function(){
	"use strict";

	ROSEMARY_GLOBALS['message_callback'] = null;
	ROSEMARY_GLOBALS['message_timeout'] = 5000;

	jQuery('body').on('click', '#rosemary_modal_bg,.rosemary_message .rosemary_message_close', function (e) {
		"use strict";
		rosemary_message_destroy();
		if (ROSEMARY_GLOBALS['message_callback']) {
			ROSEMARY_GLOBALS['message_callback'](0);
			ROSEMARY_GLOBALS['message_callback'] = null;
		}
		e.preventDefault();
		return false;
	});
});


// Warning
function rosemary_message_warning(msg) {
	"use strict";
	var hdr  = arguments[1] ? arguments[1] : '';
	var icon = arguments[2] ? arguments[2] : 'cancel';
	var delay = arguments[3] ? arguments[3] : ROSEMARY_GLOBALS['message_timeout'];
	return rosemary_message({
		msg: msg,
		hdr: hdr,
		icon: icon,
		type: 'warning',
		delay: delay,
		buttons: [],
		callback: null
	});
}

// Success
function rosemary_message_success(msg) {
	"use strict";
	var hdr  = arguments[1] ? arguments[1] : '';
	var icon = arguments[2] ? arguments[2] : 'check';
	var delay = arguments[3] ? arguments[3] : ROSEMARY_GLOBALS['message_timeout'];
	return rosemary_message({
		msg: msg,
		hdr: hdr,
		icon: icon,
		type: 'success',
		delay: delay,
		buttons: [],
		callback: null
	});
}

// Info
function rosemary_message_info(msg) {
	"use strict";
	var hdr  = arguments[1] ? arguments[1] : '';
	var icon = arguments[2] ? arguments[2] : 'info';
	var delay = arguments[3] ? arguments[3] : ROSEMARY_GLOBALS['message_timeout'];
	return rosemary_message({
		msg: msg,
		hdr: hdr,
		icon: icon,
		type: 'info',
		delay: delay,
		buttons: [],
		callback: null
	});
}

// Regular
function rosemary_message_regular(msg) {
	"use strict";
	var hdr  = arguments[1] ? arguments[1] : '';
	var icon = arguments[2] ? arguments[2] : 'quote';
	var delay = arguments[3] ? arguments[3] : ROSEMARY_GLOBALS['message_timeout'];
	return rosemary_message({
		msg: msg,
		hdr: hdr,
		icon: icon,
		type: 'regular',
		delay: delay,
		buttons: [],
		callback: null
	});
}

// Confirm dialog
function rosemary_message_confirm(msg) {
	"use strict";
	var hdr  = arguments[1] ? arguments[1] : '';
	var callback = arguments[2] ? arguments[2] : null;
	return rosemary_message({
		msg: msg,
		hdr: hdr,
		icon: 'help',
		type: 'regular',
		delay: 0,
		buttons: ['Yes', 'No'],
		callback: callback
	});
}

// Modal dialog
function rosemary_message_dialog(content) {
	"use strict";
	var hdr  = arguments[1] ? arguments[1] : '';
	var init = arguments[2] ? arguments[2] : null;
	var callback = arguments[3] ? arguments[3] : null;
	return rosemary_message({
		msg: content,
		hdr: hdr,
		icon: '',
		type: 'regular',
		delay: 0,
		buttons: ['Apply', 'Cancel'],
		init: init,
		callback: callback
	});
}

// General message window
function rosemary_message(opt) {
	"use strict";
	var msg = opt.msg != undefined ? opt.msg : '';
	var hdr  = opt.hdr != undefined ? opt.hdr : '';
	var icon = opt.icon != undefined ? opt.icon : '';
	var type = opt.type != undefined ? opt.type : 'regular';
	var delay = opt.delay != undefined ? opt.delay : ROSEMARY_GLOBALS['message_timeout'];
	var buttons = opt.buttons != undefined ? opt.buttons : [];
	var init = opt.init != undefined ? opt.init : null;
	var callback = opt.callback != undefined ? opt.callback : null;
	// Modal bg
	jQuery('#rosemary_modal_bg').remove();
	jQuery('body').append('<div id="rosemary_modal_bg"></div>');
	jQuery('#rosemary_modal_bg').fadeIn();
	// Popup window
	jQuery('.rosemary_message').remove();
	var html = '<div class="rosemary_message rosemary_message_' + type + (buttons.length > 0 ? ' rosemary_message_dialog' : '') + '">'
		+ '<span class="rosemary_message_close iconadmin-cancel icon-cancel"></span>'
		+ (icon ? '<span class="rosemary_message_icon iconadmin-'+icon+' icon-'+icon+'"></span>' : '')
		+ (hdr ? '<h2 class="rosemary_message_header">'+hdr+'</h2>' : '');
	html += '<div class="rosemary_message_body">' + msg + '</div>';
	if (buttons.length > 0) {
		html += '<div class="rosemary_message_buttons">';
		for (var i=0; i<buttons.length; i++) {
			html += '<span class="rosemary_message_button">'+buttons[i]+'</span>';
		}
		html += '</div>';
	}
	html += '</div>';
	// Add popup to body
	jQuery('body').append(html);
	var popup = jQuery('body .rosemary_message').eq(0);
	// Prepare callback on buttons click
	if (callback != null) {
		ROSEMARY_GLOBALS['message_callback'] = callback;
		jQuery('.rosemary_message_button').click(function(e) {
			"use strict";
			var btn = jQuery(this).index();
			callback(btn+1, popup);
			ROSEMARY_GLOBALS['message_callback'] = null;
			rosemary_message_destroy();
		});
	}
	// Call init function
	if (init != null) init(popup);
	// Show (animate) popup
	var top = jQuery(window).scrollTop();
	jQuery('body .rosemary_message').animate({top: top+Math.round((jQuery(window).height()-jQuery('.rosemary_message').height())/2), opacity: 1}, {complete: function () {
		// Call init function
		//if (init != null) init(popup);
	}});
	// Delayed destroy (if need)
	if (delay > 0) {
		setTimeout(function() { rosemary_message_destroy(); }, delay);
	}
	return popup;
}

// Destroy message window
function rosemary_message_destroy() {
	"use strict";
	var top = jQuery(window).scrollTop();
	jQuery('#rosemary_modal_bg').fadeOut();
	jQuery('.rosemary_message').animate({top: top-jQuery('.rosemary_message').height(), opacity: 0});
	setTimeout(function() { jQuery('#rosemary_modal_bg').remove(); jQuery('.rosemary_message').remove(); }, 500);
}
