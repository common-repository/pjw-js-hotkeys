/*
 * PJW JS Hotkeys front end js short keys based on P2
 */
jQuery(function($) {
	
	$("#pjw_js_hotkeys_help").click(function() {
		$(this).toggle();
	});
	
	
	//Trap key presses
	document.onkeydown = function(e) {
		e = e || window.event;
		if (e.target)
			element = e.target;
		else if (e.srcElement)
			element = e.srcElement;
		
		if( element.nodeType == 3)
			element = element.parentNode;
			
		if( e.ctrlKey == true || e.altKey == true || e.metaKey == true )
			return;
		
		var keyCode = (e.keyCode) ? e.keyCode : e.which;

		if (keyCode && (keyCode != 27 && (element.tagName == 'INPUT' || element.tagName == 'TEXTAREA') ) )
			return;
			
		switch(keyCode) {
			case 68://d
				window.location.href = pjw_js_hotkeys_dashboard_url;
				break;
			case 69://e
				if (pjw_js_hotkeys_is_single) {
					window.location.href = pjw_js_hotkeys_edit_post_page;
				}
				break;
			case 76://l
				if (!pjw_js_hotkeys_isUserLoggedIn)
					window.location.href = pjw_js_hotkeys_login_url;
				break;
			case 82: //r
				if (pjw_js_hotkeys_is_single) {
					jQuery("#comment").focus();
					if (e.preventDefault)
						e.preventDefault();
					else
						e.returnValue = false;
				}
				break;
			case 77: // m
				if (pjw_js_hotkeys_is_single) {
					window.location.href = pjw_js_hotkeys_comment_moderate_on_post;
				} else {
					window.location.href = pjw_js_hotkeys_comment_moderate_generic;
				}
				break;
			case 72: //h
				$("#pjw_js_hotkeys_help").toggle();
				break;
			case 0,191:
				$("#pjw_js_hotkeys_help").toggle();
				if (e.preventDefault)
					e.preventDefault();
				else
					e.returnValue = false;
				break;
		}
	}

});