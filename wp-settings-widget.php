<?php
/**
 * Plugin Name: WP Settings & Widget Page
 * Plugin URI: https://www.wpwebelite.com/
 * Description: pulgin contains sample Settings page with Image uploader, Date picker, Editor and 1 sample Widget. 
 * Version: 1.0.0
 * Author: WPWeb
 * Author URI: https://www.wpwebelite.com/
 * Text Domain: wpdws
 * Domain Path: languages
 * 
 * @package WP Settings & Widget Page
 * @category Core
 * @author WPWeb
 */   

/**
 * Basic plugin definitions 
 * 
 * @package WP Settings & Widget Page
 * @since 1.0.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

global $wpdb;

/**
 * Basic Plugin Definitions 
 * 
 * @package WP Settings & Widget Page
 * @since 1.0.0
 */
if( !defined( 'WPD_WS_VERSION' ) ) {
	define( 'WPD_WS_VERSION', '1.0.0' ); //version of plugin
}
if( !defined( 'WPD_WS_DIR' ) ) {
	define( 'WPD_WS_DIR', dirname( __FILE__ ) ); // plugin dir
}
if( !defined( 'WPD_WS_TEXT_DOMAIN' )) {
	define( 'WPD_WS_TEXT_DOMAIN', 'wpdws' ); // text domain for languages
}
if( !defined( 'WPD_WS_ADMIN' ) ) {
	define( 'WPD_WS_ADMIN', WPD_WS_DIR . '/includes/admin' ); // plugin admin dir
}
if( !defined( 'WPD_WS_PLUGIN_URL' ) ) {
	define( 'WPD_WS_PLUGIN_URL', plugin_dir_url( __FILE__ ) ); // plugin url
}
if( !defined( 'wpdwslevel' ) ) {
	define( 'wpdwslevel', 'manage_options' ); // this is capability in plugin
}
if( !defined( 'WPD_WS_PLUGIN_BASENAME' ) ) {
	define( 'WPD_WS_PLUGIN_BASENAME', basename( WPD_WS_DIR ) ); //Plugin base name
}
/**
 * Load Text Domain
 * 
 * This gets the plugin ready for translation.
 * 
 * @package WP Settings & Widget Page
 * @since 1.0.0
 */
function wpd_ws_load_textdomain() {
	
 // Set filter for plugin's languages directory
	$wpd_ws_lang_dir	= dirname( plugin_basename( __FILE__ ) ) . '/languages/';
	$wpd_ws_lang_dir	= apply_filters( 'wpd_ws_languages_directory', $wpd_ws_lang_dir );
	
	// Traditional WordPress plugin locale filter
	$locale	= apply_filters( 'plugin_locale',  get_locale(), 'wpdws' );
	$mofile	= sprintf( '%1$s-%2$s.mo', 'wpdws', $locale );
	
	// Setup paths to current locale file
	$mofile_local	= $wpd_ws_lang_dir . $mofile;
	$mofile_global	= WP_LANG_DIR . '/' . WPD_WS_PLUGIN_BASENAME . '/' . $mofile;
	
	if ( file_exists( $mofile_global ) ) { // Look in global /wp-content/languages/wp-settings-widget folder
		load_textdomain( 'wpdws', $mofile_global );
	} elseif ( file_exists( $mofile_local ) ) { // Look in local /wp-content/plugins/wp-settings-widget/languages/ folder
		load_textdomain( 'wpdws', $mofile_local );
	} else { // Load the default language files
		load_plugin_textdomain( 'wpdws', false, $wpd_ws_lang_dir );
	}
  
}
/**
 * Activation hook
 * 
 * Register plugin activation hook.
 * 
 * @package WP Settings & Widget Page
 * @since 1.0.0
 */

register_activation_hook( __FILE__, 'wpd_ws_install' );

/**
 * Deactivation hook
 *
 * Register plugin deactivation hook.
 * 
 * @package WP Settings & Widget Page
 * @since 1.0.0
 */

register_deactivation_hook( __FILE__, 'wpd_ws_uninstall' );

/**
 * Plugin Setup Activation hook call back 
 *
 * Initial setup of the plugin setting default options 
 * and database tables creations.
 * 
 * @package WP Settings & Widget Page
 * @since 1.0.0
 */

function wpd_ws_install() {
	
	global $wpdb;
		
	//if plugin is first time going to activated then set all default options
	$wpd_ws_options = get_option('wpd_ws_options');
	
	if(empty($wpd_ws_options)) {
		
		wpd_ws_default_settings(); // set default settings
		
	}
	
}

/**
 * Plugin Setup (On Deactivation)
 *
 * Does the drop tables in the database and
 * delete  plugin options.
 *
 * @package WP Settings & Widget Page
 * @since 1.0.0
 */

function wpd_ws_uninstall() {
	global $wpdb;
			
}

/**
 * Plugin default settings
 *  
 * @package WP Settings & Widget Page
 * @since 1.0.0
 */

function wpd_ws_default_settings() {
	
	$options = array(
						'title'		=>	esc_html__( 'WP Settings & Widget Page', 'wpdws' ),
						'desc'		=>	esc_html__( 'This is a demo plugin.'."\n\n".'1) WP Settings & Widget Page page ( Editor, Date picker, Image uploader )'."\n".'2) Wpd Ws Example Widget', 'wpdws' ),
						'content'	=>	'',
						'date'		=>	'',
						'image'		=>	'',
						'color'		=>	''
					);
					
	update_option('wpd_ws_options',$options);
}
/**
 * Load Plugin
 * 
 * Handles to load plugin after
 * dependent plugin is loaded
 * successfully
 * 
 * @package WP Settings & Widget Page
 * @since 1.0.0
 */
function wpd_ws_plugin_loaded() {
 
	// load first plugin text domain
	wpd_ws_load_textdomain();
}

//add action to load plugin
add_action( 'plugins_loaded', 'wpd_ws_plugin_loaded' );

/**
 * Initialize all global variables
 * 
 * @package WP Settings & Widget Page
 * @since 1.0.0
 */

global $wpd_ws_model,$wpd_ws_scripts,$wpd_ws_admin;

/**
 * Includes
 *
 * Includes all the needed files for our plugin
 *
 * @package WP Settings & Widget Page
 * @since 1.0.0
 */

//includes model class file
require_once ( WPD_WS_DIR . '/includes/class-wpd-ws-model.php');
$wpd_ws_model = new Wpd_Ws_Model();

//includes script class file
require_once ( WPD_WS_DIR . '/includes/class-wpd-ws-scripts.php');
$wpd_ws_scripts = new Wpd_Ws_Scripts();
$wpd_ws_scripts->add_hooks();

/**
 * Includes all required files for admin
 * 
 * @package WP Settings & Widget Page
 * @since 1.0.0
 */

require_once ( WPD_WS_ADMIN . '/class-wpd-ws-admin.php');
$wpd_ws_admin = new Wpd_Ws_Admin_Pages();
$wpd_ws_admin->add_hooks();

//includes widget file
require_once ( WPD_WS_DIR . '/includes/widgets/class-wpd-ws-widget.php');

/**
 * Add function to widgets_init that'll load our widget.
 *
 * @package WP Settings & Widget Page
 * @since 1.0.0
 */
add_action( 'widgets_init', 'wpd_ws_example_load_widgets' );

/**
 * Register our widget.
 * 'Wpd_Ws_Example_Widget' is the widget class used below.
 *
 * @package WP Settings & Widget Page
 * @since 1.0.0
 */
function wpd_ws_example_load_widgets() {
	
	register_widget('Wpd_Ws_Example_Widget');
}

?>