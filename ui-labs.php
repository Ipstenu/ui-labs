<?php
/*
Plugin Name: UI Labs
Plugin URI: http://halfelf.org/plugins/ui-labs/
Description: Experimental WordPress admin UI features, ooo shiny!
Author: John O'Nolan, Mika A Epstein
Version: 2.1
Author URI: http://halfelf.org
License: GPL-2.0+
License URI: http://www.opensource.org/licenses/gpl-license.php
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
    var $option_defaults;
    
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

		//add admin init hooks
		add_action( 'admin_init', array( &$this, 'admin_init' ) );

		//add admin panel
		add_action( 'admin_menu', array( &$this, 'admin_menu' ) );

    	// Setting plugin defaults here:
		$this->option_defaults = array(
			'poststatuses' => 'yes',
	        'toolbar' => 'no',
	        'dashboard' => 'no',
	        'identity' => 'no',
	        'servertype' => 'uilabs-blank',
	        'db_version' => $this->db_version,
	    );

	}

	/**
	 * Admin init Callback
	 *
	 * @since 2.0
	 */
    function admin_init() {

		// Add link to settings from plugins listing page
		add_filter( 'plugin_action_links', array( $this, 'add_settings_link'), 10, 2 );
		
		// Register filter display_post_states
		add_filter( 'display_post_states', array( &$this, 'display_post_states') );

        //Fetch and set up options.
	    $this->options = wp_parse_args( get_option( 'uilabs_options' ), $this->option_defaults );
		
		// Allows experiments to be turned on/off, written by Ollie Read
		if( $this->options['poststatuses'] == 'yes') {
			wp_register_style('ui-labs-poststatuses', plugins_url('css/poststatuses.css', __FILE__), false, '9001');
			wp_enqueue_style('ui-labs-poststatuses');
		}
		if( $this->options['toolbar'] == 'yes') {
			wp_register_style('ui-labs-toolbar', plugins_url('css/toolbar.css', __FILE__), false, '9001');
			wp_enqueue_style('ui-labs-toolbar');
		}
		if( $this->options['dashboard'] == 'yes') {
			wp_register_style('ui-labs-dashboard', plugins_url('css/dashboard.css', __FILE__), false, '9001');
			wp_enqueue_style('ui-labs-dashboard');
		}
		if( $this->options['identity'] == 'yes') {
			wp_register_style('ui-labs-identity', plugins_url('css/identity.css', __FILE__), false, '9001');
			wp_enqueue_style('ui-labs-identity');
		}
		
		// Filter for the admin body class
		add_filter('admin_body_class', array( &$this, 'admin_body_class') );

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
		add_management_page( __('UI Labs'), __('UI Labs'), 'manage_options', 'ui-labs-settings', array( &$this, 'uilabs_settings' ) );
	}

	/**
	 * Register Admin Settings
	 *
	 * @since 2.0
	 */
    function register_settings() {
	    register_setting( 'ui-labs', 'uilabs_options', array( $this, 'uilabs_sanitize' ) );

		// The main section
		add_settings_section( 'uilabs-experiments', 'Experiments', array( &$this, 'uilabs_experiments_callback'), 'ui-labs-settings' );

		// The Fields
		add_settings_field( 'poststatuses', 'Colour-Coded Post Statuses', array( &$this, 'poststatuses_callback'), 'ui-labs-settings', 'uilabs-experiments' );
		add_settings_field( 'toolbar', 'WordPress Toolbar', array( &$this, 'toolbar_callback'), 'ui-labs-settings', 'uilabs-experiments' );
		add_settings_field( 'dashboard', 'Bigger Dashboard', array( &$this, 'dashboard_callback'), 'ui-labs-settings', 'uilabs-experiments' );
		add_settings_field( 'identity', 'Identify This Server', array( &$this, 'identity_callback'), 'ui-labs-settings', 'uilabs-experiments' );
		
		if( isset($this->options['identity'] ) && $this->options['identity'] == 'yes') {
			add_settings_field( 'servertype', 'Server Type', array( &$this, 'servertype_callback'), 'ui-labs-settings', 'uilabs-experiments' );
		}
	}

	/**
	 * UI Labs Experiments Callback
	 *
	 * @since 2.0
	 */
	function uilabs_experiments_callback() {
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
		<input type="checkbox" id="uilabs_options[poststatuses]" name="uilabs_options[poststatuses]" value="yes" <?php echo checked( $this->options['poststatuses'], 'yes', true ); ?> >
		<label for="uilabs_options[poststatuses]"><?php _e('Add color coded labels to posts to easily identity which needs addressing.', 'ui-labs'); ?></label>
		<?php
	}

	/**
	 * Clean up the Toolbar
	 *
	 * @since 2.0
	 */
	function toolbar_callback() {
		?>
		<input type="checkbox" id="uilabs_options[toolbar]" name="uilabs_options[toolbar]" value="yes" <?php echo checked( $this->options['toolbar'], 'yes', true ); ?> >
		<label for="uilabs_options[toolbar]"><?php _e('Adds spacing and padding to the toolbar.', 'ui-labs'); ?></label>
	    <?php
	}

	/**
	 * Make the fonts in the dashboard bigger
	 *
	 * @since 2.0
	 */
	function dashboard_callback() {
		?>
		<input type="checkbox" id="uilabs_options[dashboard]" name="uilabs_options[dashboard]" value="yes" <?php checked( $this->options['dashboard'], 'yes', true ); ?> >
		<label for="uilabs_options[dashboard]"><?php _e('Increase the fonts in the admin dashboard for old people.', 'ui-labs'); ?></label>
	    <?php
	}

	/**
	 * Identify This Server
	 *
	 * @since 2.0
	 */
	function identity_callback() {
		?>
		<input type="checkbox" id="uilabs_options[identity]" name="uilabs_options[identity]" value="yes" <?php checked( $this->options['identity'], 'yes', true ); ?> >
		<label for="uilabs_options[identity]"><?php _e('Enable colour coding for your different servers for quick identification.', 'ui-labs'); ?></label>
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
	
	function uilabs_settings() { 
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
	 * Options sanitization and validation
	 *
	 * @param $input the input to be sanitized
	 * @since 2.0
	 */
	function uilabs_sanitize( $input ) {
    	$options = $this->options;
    	
    	$input['db_version'] = $this->db_version;

    	foreach ($options as $key=>$value) {
            if ( !isset($input[$key]) || is_null( $input[$key] ) || $input[$key] == '0' ) {
	            $output[$key] = 'no';
            } else {
	            $output[$key] = sanitize_text_field($input[$key]);
            }
        }

		return $output;
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
	        $this->options['toolbar'] = get_option('adminbar');
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
	 * Modified to allow multiple languages: https://wordpress.org/support/topic/plugin-ui-labs-classes-translated
	 *
	 * @since 1.0.1
	 */
	function display_post_states( $post_states ) {		
		$post_state_array = array();
		foreach ( $post_states as $post_state => $post_state_title )
			$post_state_array[] = '<span class="' . strtolower( str_replace( ' ', '-', $post_state ) ) . '">' . $post_state_title . '</span>';
	   return $post_state_array;
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