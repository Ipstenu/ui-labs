<?php
/**
 * Uninstaller script
 *
 * @since 2.0
 */

//if uninstall not called from WordPress exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) exit();

// Delete 2.0+ options
if ( is_multisite() ) {
	delete_site_option('uilabs_network_options');
} else {
	delete_option('uilabs_options');
}

// Delete the old 1.x options in case they're lying around
delete_option( 'poststatuses' );
delete_option( 'adminbar' );
delete_option( 'identity' );
delete_option( 'servertype' );