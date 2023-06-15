<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Scripts Class
 *
 * Handles adding scripts functionality to the admin pages
 * as well as the front pages.
 *
 * @package WP Settings & Widget Page
 * @since 1.0.0
 */
class Wpd_Ws_Scripts {
	
	public function __construct() {
		
		
	}
	
	/**
	 * Enqueue Scripts
	 * 
	 * Loads Javascript for managing 
	 * metaboxes in plugin settings page
	 * 
	 * @package WP Settings & Widget Page
	 * @since 1.0.0
	 */
	public function wpd_ws_admin_meta_scripts($hook_suffix) {
		
		// loads the required scripts for the meta boxes
		if (  $hook_suffix == 'toplevel_page_wpd-ws-settings' ) { //check hoo suffix of page
			
			wp_enqueue_script( 'common' );

			wp_enqueue_script( 'wp-lists' );

			wp_enqueue_script( 'postbox' );
			
		}
		
	}
	
	/**
	 * Enqueue Scripts
	 * 
	 * Loads Javascript file for managing datepicker 
	 * and other functionality in backend
	 *
	 * @package WP Settings & Widget Page
	 * @since 1.0.0
	 */
	public function wpd_ws_admin_scripts( $hook_suffix ) {
		
		global $wp_version;
		
		$pages_hook_suffix = array( 'toplevel_page_wpd-ws-settings' );
	
		if( in_array( $hook_suffix, $pages_hook_suffix ) ) {

			wp_enqueue_script( array( 'jquery', 'thickbox', 'jquery-ui-datepicker' ) );

			// Register & Enqueue admin script
			wp_register_script('wpd-ws-admin-script',  WPD_WS_PLUGIN_URL.'includes/js/wpd-ws-admin.js', array(), WPD_WS_VERSION , true );
			wp_enqueue_script('wpd-ws-admin-script');

			//localize script
			$newui = $wp_version >= '3.5' ? '1' : '0'; //check wp version for showing media uploader
			wp_localize_script( 'wpd-ws-admin-script', 'WpdWsSettings', array( 
																					'new_media_ui'	=>	$newui,
																				));
			//for new media uploader
			wp_enqueue_media();
			
			//If the WordPress version is greater than or equal to 3.5, then load the new WordPress color picker.
		    if ( $wp_version >= 3.5 ){
		        //Both the necessary css and javascript have been registered already by WordPress, so all we have to do is load them with their handle.
		        wp_enqueue_script( 'wp-color-picker' );
		    }
		    //If the WordPress version is less than 3.5 load the older farbtasic color picker.
		    else {
		        //As with wp-color-picker the necessary css and javascript have been registered already by WordPress, so all we have to do is load them with their handle.
		        wp_enqueue_script( 'farbtastic' );
		    }
		}
			
	}
	
	/**
	 * Enqueue Styles
	 * 
	 * Loads CSS file for managing datepicker 
	 * and other functionality in backend
	 *
	 * @package WP Settings & Widget Page
	 * @since 1.0.0
	 */
	public function wpd_ws_admin_styles( $hook_suffix ) {
		
			global $wp_version;
			
			$pages_hook_suffix = array( 'toplevel_page_wpd-ws-settings' );
		
			if( in_array( $hook_suffix, $pages_hook_suffix ) ) {
			
				wp_enqueue_style('thickbox');
			
				// Register & Enqueue admin datepicker style
				wp_register_style('wpd-ws-admin-datepicker-css',  WPD_WS_PLUGIN_URL.'includes/css/jquery-ui-1.8.21.custom.css', array(), WPD_WS_VERSION );
				wp_enqueue_style('wpd-ws-admin-datepicker-css');
				
				// Register & Enqueue admin style
				wp_register_style('wpd-ws-admin-style',  WPD_WS_PLUGIN_URL.'includes/css/wpd-ws-admin.css', array(), WPD_WS_VERSION );
				wp_enqueue_style('wpd-ws-admin-style');
				
				//for color picker
				
				//If the WordPress version is greater than or equal to 3.5, then load the new WordPress color picker.
			    if ( $wp_version >= 3.5 ){
			        //Both the necessary css and javascript have been registered already by WordPress, so all we have to do is load them with their handle.
			        wp_enqueue_style( 'wp-color-picker' );
			    }
			    //If the WordPress version is less than 3.5 load the older farbtasic color picker.
			    else {
			        //As with wp-color-picker the necessary css and javascript have been registered already by WordPress, so all we have to do is load them with their handle.
			        wp_enqueue_style( 'farbtastic' );
			    }
		    
			}
	}
	
	/**
	 * Loading Additional Java Script
	 *
	 * Loads the JavaScript required for toggling the meta boxes add coupon page.
	 *
	 * @package WP Settings & Widget Page
	 * @since 1.0.0
	 */

	 public function wpd_ws_settings_scripts() { 

		echo '<script type="text/javascript">

				//<![CDATA[

				jQuery(document).ready( function($) {

					$(".if-js-closed").removeClass("if-js-closed").addClass("closed");
					
					postboxes.add_postbox_toggles( "admin_page_wpd-ws-settings" );
					
				});

				//]]>

			</script>';

	}
	
	/**
	 * Adding Hooks
	 *
	 * Adding hooks for the styles and scripts.
	 *
	 * @package WP Settings & Widget Page
	 * @since 1.0.0
	 */
	public function add_hooks() {
		
		//add style for setting & widget
		add_action( 'admin_enqueue_scripts', array( $this, 'wpd_ws_admin_styles' ) );
		
		//add js for setting & widget
		add_action( 'admin_enqueue_scripts', array( $this, 'wpd_ws_admin_scripts' ) );
		
		// add meta scripts for backend
		add_action( 'admin_enqueue_scripts', array( $this, 'wpd_ws_admin_meta_scripts' ) );
	}
}