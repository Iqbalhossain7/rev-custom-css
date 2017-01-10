<?php
/**
 * @package Rev Custom css
 */
/*
Plugin Name: Rev Custom css
Plugin URI: https://#
Description: A simple and easy custom css plugin. editor field is like as nice sublime text. solid way to add custom CSS to your WordPress website. Rev Custom CSS allows you to add your own styles or override the default CSS of a plugin or theme.
Version: 1.0
Author: Iqbal hossain
Author URI: https://#
License: GPLv2 or later
Text Domain: Rev_custom_css

Copyright 2017  Iqbal Hossain  (email: mdiqbal.info@gmail.com)
*/


// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

define( 'REV_CUSTOM_CSS_PATH', plugin_dir_path( __FILE__ ) );

// includes
require_once(REV_CUSTOM_CSS_PATH.'/inc/activation.php');

register_activation_hook( __FILE__, 'rev_custom_css_activation' );
register_deactivation_hook( __FILE__, 'rev_custom_css_dactivation' );

// call style in header area
function show_rev_custom_css_here(){?>
<style type="text/css">
<?php 
$data = get_option( 'revcss_settings_content');
echo wp_strip_all_tags($data); ?>
</style>
<?php }
add_action('wp_head', 'show_rev_custom_css_here',90);

/**
 * Register a custom sub menu page.
 */
function register_custom_css_admin_page() {
	add_submenu_page( 'themes.php', 'Rev custom css', __('Custom CSS', 'Rev_custom_css'), 'administrator', 'rev-custom-css', 'manage_custom_css_options');
}
add_action( 'admin_menu', 'register_custom_css_admin_page' );

// ace code editor scripts here
function rev_custom_css_editor_sctipt() {
        wp_enqueue_script( 'rev_css_code_core_js', plugin_dir_url( __FILE__ ) . 'editors/ace.js', array('jquery'),'1.0', true);
        wp_enqueue_script( 'rev_css_code_theme', plugin_dir_url( __FILE__ ) . 'editors/theme-monokai.js', array('jquery'),'1.0', true);
}
add_action( 'admin_enqueue_scripts', 'rev_custom_css_editor_sctipt' );

// rev custom css settigs call here
function revcss_register_settings() {
	register_setting( 'revcss_settings_group', 'revcss_settings' );
	register_setting( 'revcss_settings_group', 'revcss_settings_content' );
}
add_action( 'admin_init', 'revcss_register_settings' );

function manage_custom_css_options(){
	?>
	<div class="wrap">
		<?php
		echo "<h2>Rev Custom Css:</h2><br>";
		 if ( isset( $_GET['settings-updated'] ) ) : ?>
		<div style="margin-left:0px;" id="setting-error-settings_updated" class="updated notice is-dismissible"><p><?php _e( 'Custom CSS updated successfully.', 'Rev_custom_css' ); ?></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss</span></button></div>
		<?php endif; ?>

		<form action="options.php" method="post" >
			<?php settings_fields( 'revcss_settings_group' ); ?>
			<?php do_settings_sections( 'revcss_settings_group' ); ?>
			<div id="rev_code_editor" style="height: 480px; width: 100%;"><?php echo esc_attr(get_option( 'revcss_settings_content')); ?></div> 
			<textarea hidden id="rev_css_editor" name="revcss_settings_content"  rows="2" style="width: 90%;"><?php echo esc_attr(get_option( 'revcss_settings_content')); ?></textarea>
			<?php submit_button(); ?>
			<i>If you satisfied with our plugin. Please don't forget to give us <strong>5 Star</strong> feedback. If you have any question, feel free contact us. Thank you for use our service. :). <a href="#">Rev Team</a></i>
		</form>
		<script>
jQuery(document).ready(function($) {
   var textarea = jQuery('#rev_css_editor');
   var editor = ace.edit("rev_code_editor");
   editor.setTheme("ace/theme/monokai");
   editor.setFontSize(20);
   editor.getSession().setMode("ace/mode/css");
   editor.getSession().setUseWorker(true);
   editor.getSession().on('change', function () {
       textarea.val(editor.getSession().getValue());
   });
   textarea.val(editor.getSession().getValue());
});
		</script>
	</div>
<?php 
}