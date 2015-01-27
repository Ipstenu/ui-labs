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
$option_name = 'uilabs_options';
delete_option( $option_name );

// Delete the old 1.x options
delete_option( 'poststatuses' );
delete_option( 'adminbar' );
delete_option( 'identity' );
delete_option( 'servertype' );