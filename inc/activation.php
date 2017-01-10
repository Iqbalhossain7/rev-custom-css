<?php
/**
 * @package Rev Custom css
 */

function rev_custom_css_activation(){
	if(version_compare(get_bloginfo('version'), '3.7.0', '<')){
		wp_die('To active this plugin you need to atlest wordpress 3.7 or avove version. update your wordpress then active again.' );
	}
}
