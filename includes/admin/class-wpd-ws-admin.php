<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Admin Pages Class
 *
 * Handles generic Admin functionailties
 *
 * @package WP Settings & Widget Page
 * @since 1.0.0
 */

class Wpd_Ws_Admin_Pages {

	public $model, $scripts;

	public function __construct()	{		

		global $wpd_ws_model,$wpd_ws_scripts;
		$this->model = $wpd_ws_model;
		$this->scripts = $wpd_ws_scripts;
	}

	/**
	 * Create menu page
	 *
	 * Adding required menu pages and submenu pages
	 * to manage the plugin functionality
	 * 
	 * @package WP Settings & Widget Page
	 * @since 1.0.0
	 */
	
	public function wpd_ws_add_menu_page() {
		
		$wpd_ws_setting = add_menu_page( esc_html__( 'WP Settings & Widget Page', 'wpdws' ), esc_html__( 'WP Settings & Widget Page', 'wpdws' ), wpdwslevel,'wpd-ws-settings', array($this, 'wpd_ws_settings') );
		
		add_action( "admin_head-$wpd_ws_setting", array( $this->scripts, 'wpd_ws_settings_scripts' ) );
	}

	/**
	 * Register Settings
	 *
	 * @package WP Settings & Widget Page
	 * @since 1.0.0
	 */

	public function wpd_ws_admin_init() {
		
		register_setting( 'wpd_ws_plugin_options', 'wpd_ws_options', array($this, 'wpd_ws_validate_options') );
		
	}

	public function wpd_ws_validate_options( $input ) {
	
		// sanitize text input (strip html tags, and escape characters)
		$input['title']	=  $this->model->wpd_ws_escape_slashes_deep( $input['title'] );
		$input['desc']	=  $this->model->wpd_ws_escape_slashes_deep( $input['desc'] );
		$input['date']	=  $this->model->wpd_ws_escape_slashes_deep( $input['date'] );
		$input['image']	=  $this->model->wpd_ws_escape_slashes_deep( $input['image'] );
		
		return $input;
	}
	
	/**
	 * Includes Plugin Settings
	 * 
	 * Including File for plugin settings
	 *
	 * @package WP Settings & Widget Page
	 * @since 1.0.0
	 */
	public function wpd_ws_settings() {
		
		include_once( WPD_WS_ADMIN . '/forms/wpd-ws-plugin-settings.php' );
		
	}
	
	/**
	 * Function to replace the shortcode in the text widget
	 *
	 * @package WP Settings & Widget Page
	 * @since 1.0.0
	 */
	public function wpd_ws_widget_shortcode_replace( $text ) {
		
		//$text = do_shortcode('[gallery]');
		$text = do_shortcode($text);
		
		return $text;
	}
	
	/**
	 * Adding Hooks
	 *
	 * @package WP Settings & Widget Page
	 * @since 1.0.0
	 */

	public function add_hooks() {
		
		add_action( 'admin_menu', array( $this, 'wpd_ws_add_menu_page' ) );
			
		add_action('admin_init', array($this, 'wpd_ws_admin_init'));
		
		// Filter to replace the shortcode in the text widget
		add_filter('widget_text', array( $this, 'wpd_ws_widget_shortcode_replace') );
	}

}
