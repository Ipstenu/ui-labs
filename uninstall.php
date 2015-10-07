<?php
/**
 * Uninstaller script
 *
 * @since 2.0
 */

//if uninstall not called from WordPress exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) 
    exit();

// Delete 2.0+ options
delete_option( 'uilabs_options' );

// Delete the old 1.x options
delete_option( 'poststatuses' );
delete_option( 'adminbar' );
delete_option( 'identity' );
delete_option( 'servertype' );