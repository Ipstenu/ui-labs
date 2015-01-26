<?php
/*
Plugin Name: UI Labs
Plugin URI: 
Description: Experimental WordPress admin UI features, ooo shiny!
Author: John O'Nolan, Mika A Epstein
Version: 2.0-Beta
Author URI: http://john.onolan.org
*/

/**
 * Create a singleton class
 *
 * @since 2.0
 */

class UI_Labs {
	
	/*
	 * Starter defines and vars for use later
	 *
	 * @since 2.0
	 */

	// Holds option data.
    var $option_name = 'uilabs_options';
    var $options = array();
    var $poststatuses = 'yes';
    var $adminbar = 'yes';
    var $identify = 'no';
    var $servertype = 'no';
    
    // DB version, for schema upgrades.
    var $db_version = 1;

	// Instance
	static $instance;

    /**
     * Constuct
     * Fires when class is constructed, adds init hook
     *
     * @since 2.0
     */
    function __construct() {
	    
	    //allow this instance to be called from outside the class
        self::$instance = $this;

        //add init hook
		add_action( 'init', array( &$this, 'init' ) );

		//add admin init hooks
		add_action( 'admin_init', array( &$this, 'admin_init' ) );

		//add admin panel
		add_action( 'admin_menu', array( &$this, 'admin_menu' ) );
	}

	/**
	 * Init Callback
	 *
	 * @since 2.0
	 */

	function init() {
		
		// Add link to settings from plugins listing page
		add_filter( 'plugin_action_links', array( $this, 'add_settings_link'), 10, 2 );
		
		// Register filter display_post_states
		add_filter( 'display_post_states', array( &$this, 'display_post_states') );

        //Fetch and set up options.
	    $this->options = get_option( 'uilabs_options' );
	    
	    if ( ! empty( $this->options ) ) {
		    foreach ( $this->options as $key => &$value ) {
			    if ( ! empty( $this->options[$key] ) ) {
				    $this->$key = $this->options[$key];
			    }
		    }
		    update_option( $this->option_name, $this->options );
		}
		
		// Allows experiments to be turned on/off, written by Ollie Read
		if( $this->options['poststatuses'] == 'yes') {
			wp_register_style('ui-labs-poststatuses', plugins_url('css/poststatuses.css', __FILE__), false, '9001');
			wp_enqueue_style('ui-labs-poststatuses');
		}
		if( $this->options['adminbar'] == 'yes') {
			wp_register_style('ui-labs-adminbar', plugins_url('css/adminbar.css', __FILE__), false, '9001');
			wp_enqueue_style('ui-labs-adminbar');
		}
		if( $this->options['identify'] == 'yes') {
			wp_register_style('ui-labs-identify', plugins_url('css/identify.css', __FILE__), false, '9001');
			wp_enqueue_style('ui-labs-identify');
		}
		if( $this->options['servertype'] == 'yes') {
			wp_register_style('ui-labs-servertype', plugins_url('css/servertype.css', __FILE__), false, '9001');
			wp_enqueue_style('ui-labs-servertype');
		}
		
		// Filter for the admin body class
		add_filter('admin_body_class', array( &$this, 'admin_body_class') );
	}

	/**
	 * Admin init Callback
	 *
	 * @since 2.0
	 */
    function admin_init() {

	    // check if DB needs to be upgraded (this will merge old settings to new)
	    if ( false === $this->options || ! isset( $this->options['db_version'] ) || $this->options['db_version'] < $this->db_version ) {
	    	//init options array
	        if ( ! is_array( $this->options ) ) {
	            $this->options = array();          
	            //establish DB version
	            $current_db_version = isset( $this->options['db_version'] ) ? $this->options['db_version'] : 0;

	            //run upgrade and store new version #
	            $this->upgrade( $current_db_version );
	            $this->options['db_version'] = $this->db_version;
	            update_option( $this->option_name, $this->options );
	        }        
	    }
	    
	    // Register Settings
		$this::register_settings();
	}

	/**
	 * Admin Menu Callback
	 *
	 * @since 2.0
	 */
    function admin_menu() {
		// Add settings page on Tools
		add_management_page( __('UI Labs'), __('UI Labs'), 'manage_options', 'ui-labs-settings', array( &$this, 'ui_labs_settings' ) );
	}

	/**
	 * Register Admin Settings
	 *
	 * @since 2.0
	 */
    function register_settings() {
	    register_setting( 'ui-labs', 'uilabs_options');

		// The main section
		add_settings_section( 'ui-lab-experiments', 'Experiments', array( &$this, 'ui_lab_experiments_callback'), 'ui-labs-settings' );

		// The Fields
		add_settings_field( 'poststatuses', 'Colour-Coded Post Statuses', array( &$this, 'poststatuses_callback'), 'ui-labs-settings', 'ui-lab-experiments' );
		add_settings_field( 'adminbar', 'Classic WordPress Admin Bar', array( &$this, 'adminbar_callback'), 'ui-labs-settings', 'ui-lab-experiments' );
		add_settings_field( 'identify', 'Identify This Server', array( &$this, 'identify_callback'), 'ui-labs-settings', 'ui-lab-experiments' );
		add_settings_field( 'servertype', 'Server Type', array( &$this, 'servertype_callback'), 'ui-labs-settings', 'ui-lab-experiments' );
	}

	/**
	 * UI Labs Experiments Callback
	 *
	 * @since 2.0
	 */
	function ui_lab_experiments_callback() {
	    ?>
	    <p><?php _e('The following experiments are available:', 'ui-labs'); ?></p>
	    <?php
	}

	/**
	 * Colour-Coded Post Statuses Callback
	 *
	 * @since 2.0
	 */
	function poststatuses_callback() {
		?>
		<input type="checkbox" id="uilabs_options[poststatuses]" name="uilabs_options[poststatuses]" value="yes" <?php echo checked( yes, $this->options['poststatuses'], false ); ?> >
		<label for="uilabs_options[poststatuses]"><?php _e('EXPLAIN', 'ui-labs'); ?></label>
		<?php
	}

	/**
	 * Classic WordPress Admin Bar
	 *
	 * @since 2.0
	 */
	function adminbar_callback() {
		?>
		<input type="checkbox" id="uilabs_options[adminbar]" name="uilabs_options[adminbar]" value="yes" <?php echo checked( yes, $this->options['adminbar'], false ); ?> >
		<label for="uilabs_options[adminbar]"><?php _e('EXPLAIN', 'ui-labs'); ?></label>
	    <?php
	}

	/**
	 * Identify This Server
	 *
	 * @since 2.0
	 */
	function identify_callback() {
		?>
		<input type="checkbox" id="uilabs_options[identify]" name="uilabs_options[identify]" value="yes" <?php echo checked( yes, $this->options['identify'], false ); ?> >
		<label for="uilabs_options[identify]"><?php _e('EXPLAIN', 'ui-labs'); ?></label>
		<?php
	}

	/**
	 * Server Type Server
	 *
	 * @since 2.0
	 */
	function servertype_callback() {
		?>
			<select id="uilabs_options[servertype]" name="uilabs_options[servertype]">
				<option value="uilabs-blank" <?php echo $this->options['servertype'] == 'uilabs-blank' ? ' selected' : '';?> > -- </option>
				<option value="uilabs-development" <?php echo $this->options['servertype'] == 'uilabs-development' ? ' selected' : '';?> ><?php _e('Development', 'ui-labs'); ?></option>
				<option value="uilabs-staging" <?php echo $this->options['servertype'] == 'uilabs-staging' ? ' selected' : '';?> ><?php _e('Staging', 'ui-labs'); ?></option>
				<option value="uilabs-live" <?php echo $this->options['servertype'] == 'uilabs-live' ? ' selected' : '';?> ><?php _e('Live', 'ui-labs'); ?></option>
			</select>
		<?php
	}

	/**
	 * Call settings page
	 *
	 * @since 1.0
	 */
	
	function ui_labs_settings() { 
		?>

		<div class="wrap">
			
		<h2><?php _e( 'UI Labs', 'ui-labs' ); ?></h2>
		
		<form action="options.php" method="POST" >
		    <?php 
			    settings_fields('ui-labs');
			    do_settings_sections( 'ui-labs-settings' );
			    submit_button();
		    ?>
		</form>
		</div>
		<?php
	}

    /**
	 * Plugin Activation
	 *
	 * @since 1.0
	 */
	function ui_labs_activation() {
		$activate_options = get_option( 'uilabs_options' );

		$activate_options['poststatuses'] = 'yes';
	    $activate_options['adminbar'] = 'yes';
	    $activate_options['identity'] = 'no';
	    $activate_options['servertype'] = 'uilabs-blank';
	    update_option( 'uilabs_options', $activate_options );
	}

    /**
	 * Upgrades Database
	 *
	 * @param int $current_db_version the current DB version
	 * @since 2.0
	 */
	function upgrade( $current_db_version ) {
	    if ( $current_db_version < 1 ) {
		    // Migrate old options to new
	        $this->options['poststatuses'] = get_option('poststatuses');
	        $this->options['adminbar'] = get_option('adminbar');
	        $this->options['identity'] = get_option('identity');
	        $this->options['servertype'] = get_option('servertype');
	        update_option( $this->option_name, $this->options );
	        
	        // Delete old options
	        delete_option( 'poststatuses' );
	        delete_option( 'adminbar' );
	        delete_option( 'identity' );
	        delete_option( 'servertype' );
	    }
    }

	/**
	 * Modify the output of post statuses
	 *
	 * Allows for fine-grained control of styles and targetin protected
	 * posts, written by Pete Mall
	 *
	 * @since 1.0.1
	 */
	function display_post_states( $post_states ) {
	   foreach ( $post_states as &$post_state )
	       $post_state = '<span class="' . strtolower( str_replace( ' ', '-', $post_state ) ) . '">' . $post_state . '</span>';
	   return $post_states;
	}
	
	/**
	 * Identify Server UI Experiment
	 *
	 * Allows users to easily spot whether they are logged in
	 * to their developemnt, staging, or live server.
	 *
	 * @since 1.2
	 */
	function admin_body_class( $classes ) {
		if ( is_admin() && current_user_can( 'administrator' ) ) {
			$classes .= $this->options['servertype'];
		}
		// Return the $classes array
		return $classes;
	}

	/**
	 * Add settings link on plugin
	 *
	 * @since 2.0
	 */
	function add_settings_link( $links, $file ) {
		if ( plugin_basename( __FILE__ ) == $file ) {
			$settings_link = '<a href="' . admin_url( 'tools.php?page=ui-labs-settings' ) .'">' . __( 'Settings', 'ui-labs' ) . '</a>';
			array_unshift( $links, $settings_link );
		}
		return $links;
	}

}

new UI_Labs();

/**
 * Register Activation Hook
 *
 * @since 1.0
 */
register_activation_hook( __FILE__, array( 'UI_Labs', 'ui_labs_activation' ) );