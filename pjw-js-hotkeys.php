<?php
/*
   Plugin Name: PJW JS Hotkeys 
   Plugin URI: http://blog.ftwr.co.uk/wordpress/js-hotkeys/
   Description: Gives you a number of javascript hotkeys on the frontend of your blog like P2 does
   Author: Peter Westwood
   Version: 0.70-alpha
   Author URI: http://blog.ftwr.co.uk/
 */

/*  Copyright 2009  Peter Westwood  (email : peter.westwood@ftwr.co.uk)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

class pjw_js_hotkeys {
	function init() {
		if ( !is_admin() ) {
			add_action('wp_print_scripts', array('pjw_js_hotkeys', 'action_wp_print_scripts') );
			add_action('wp_print_styles', array('pjw_js_hotkeys', 'action_wp_print_styles') );
			add_action('wp_head', array('pjw_js_hotkeys', 'action_wp_head'));
			add_action('wp_footer', array('pjw_js_hotkeys', 'action_wp_footer'));
		}
		load_plugin_textdomain('pjw-js-hotkeys', false , basename(dirname(__FILE__)).'/languages');
	}	
	
	function action_wp_head() {
		global $wp_query;
		$page_options['isUserLoggedIn'] = (int)is_user_logged_in();
		$page_options['login_url'] = '"' . wp_login_url( ( ( !empty($_SERVER['HTTPS'] ) && strtolower($_SERVER['HTTPS']) == 'on' ) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ) . '"';
		$page_options['dashboard_url'] = '"' . admin_url() . '"';
		$page_options['is_single'] = (int) is_single();
		$page_options['comment_moderate_on_post'] = '"' . admin_url('edit-comments.php?comment_status=moderated&p='.$wp_query->posts[0]->ID) . '"';
		$page_options['comment_moderate_generic'] = '"' . admin_url('edit-comments.php?comment_status=moderated') . '"';
		$page_options['edit_post_page'] = '"' .get_edit_post_link($wp_query->posts[0]->ID, 'js') . '"';
		?>
	<script type="text/javascript" charset="<?php bloginfo('charset'); ?>">
		// <![CDATA[
		// PJW JS Hotkeys Configuration
		<?php
			foreach ($page_options as $name => $value) { ?>
				var pjw_js_hotkeys_<?php echo $name ?> = <?php echo $value; ?>;
			<?php  } ?>
		 // ]]>
	</script>
	<?php	
	}
	
	function action_wp_footer() {
	?>
<div id="pjw_js_hotkeys_help">
	<dl>
		<dt>d</dt> <dd><?php _e('go to dashboard', 'pjw-js-hotkeys'); ?></dd>
		<dt>l</dt> <dd><?php _e('go to login', 'pjw-js-hotkeys'); ?></dd>
		<dt>h</dt> <dd><?php _e('show/hide help', 'pjw-js-hotkeys'); ?></dd>
		<dt>e</dt> <dd><?php _e('edit post/page', 'pjw-js-hotkeys'); ?></dd>
		<dt>r</dt> <dd><?php _e('comment on post/page', 'pjw-js-hotkeys'); ?></dd>
		<dt>m</dt> <dd><?php _e('go to moderate comments', 'pjw-js-hotkeys'); ?></dd>
		<dt>esc</dt> <dd><?php _e('cancel', 'pjw-js-hotkeys'); ?></dd>
	</dl>
</div>
	<?php
	}
	
	function action_wp_print_scripts() {
		wp_enqueue_script( 'pjw-js-hotkeys-js', plugin_dir_url(__FILE__) . 'js/pjw-js-hotkeys.js', array( 'jquery', 'utils' ), filemtime(plugin_dir_path(__FILE__) . 'js/pjw-js-hotkeys.js') );
	}

	function action_wp_print_styles() {
		wp_enqueue_style( 'pjw-js-hotkeys-css', plugin_dir_url(__FILE__) . 'css/pjw-js-hotkeys.css', array(), filemtime(plugin_dir_path(__FILE__) . 'css/pjw-js-hotkeys.css') );
	}
}

//Initialise ourselves on the init hook.
add_action( 'init', array('pjw_js_hotkeys', 'init') );

?>
