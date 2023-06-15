<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Plugin Model Class
 *
 * Handles generic functionailties
 *
 * @package WP Settings & Widget Page
 * @since 1.0.0
 */
 class Wpd_Ws_Model {
 	 	
 	//class constructor
	public function __construct()	{		

	}
		
	/**
	  * Escape Tags & Slashes
	  *
	  * Handles escapping the slashes and tags
	  *
	  * @package WP Settings & Widget Page
	  * @since 1.0.0
	  */
	   
	 public function wpd_ws_escape_attr($data){
	  
	 	return esc_attr(stripslashes($data));
	 }
	 
	 /**
	  * Stripslashes 
 	  * 
  	  * It will strip slashes from the content
	  *
	  * @package WP Settings & Widget Page
	  * @since 1.0.0
	  */
	   
	public function wpd_ws_escape_slashes_deep($data = array(),$flag=false){
		
		if($flag != true) {
			$data = $this->wpd_ws_nohtml_kses($data);
		}
		$data = stripslashes_deep($data);
		return $data;
	}
	 	
	/**
	 * Strip Html Tags 
	 * 
	 * It will sanitize text input (strip html tags, and escape characters)
	 * 
	 * @package WP Settings & Widget Page
	 * @since 1.0.0
	 */
	public function wpd_ws_nohtml_kses($data = array()) {
		
		
		if ( is_array($data) ) {
			
			$data = array_map(array($this,'wpd_ws_nohtml_kses'), $data);
			
		} elseif ( is_string( $data ) ) {
			
			$data = wp_filter_nohtml_kses($data);
		}
		
		return $data;
	}	
		
 }