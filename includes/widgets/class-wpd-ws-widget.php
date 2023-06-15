<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

add_action( 'widgets_init', 'wpd_ws_example_widget' );

/**
 * Register the Vendor Widget
 *
 * @package Social Deals Engine - Vendors Extension
 * @since 1.0.0
 */
function wpd_ws_example_widget() {
	
	register_widget( 'Wpd_Ws_Example_Widget' );
}
/**
 * Widget Class
 *
 * Handles generic functionailties
 *
 * @package WP Settings & Widget Page
 * @since 1.0.0
 */

class Wpd_Ws_Example_Widget extends WP_Widget {
	
	public $model;
	
	function __construct() {
		global $wpd_ws_model;
		$widget_ops = array('classname' => 'widget_text', 'description' => esc_html__('Wpd Ws Example Widget Description'));		
		parent::__construct( 'wpd-ws-example-widget', esc_html__('Wpd Ws Example Widget', 'wpdws'), $widget_ops);
		$this->model = $wpd_ws_model;
	}

	public function form($instance) {
		
		// outputs the options form on admin
		$instance = wp_parse_args( (array) $instance, array( 'title' => esc_html__('Demo widget', 'wpdws'), 'fname' => esc_html__('John', 'wpdws'), 'lname' => esc_html__('Doe', 'wpdws'), 'sex' => '', 'show_sex' => '' ) );
		$title = $this->model->wpd_ws_escape_attr($instance['title']);
		$fname = $this->model->wpd_ws_escape_attr($instance['fname']);
		$lname = $this->model->wpd_ws_escape_attr($instance['lname']);
		$sex = $instance['sex'];
		$show_sex = $instance['show_sex'];
		?>
		
		<!-- Title: Text Box -->
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:', 'wpdws'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		
		<!-- First Name: Text Box -->
		<p>
			<label for="<?php echo $this->get_field_id('fname'); ?>"><?php esc_html_e('First Name:', 'wpdws'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('fname'); ?>" name="<?php echo $this->get_field_name('fname'); ?>" type="text" value="<?php echo esc_attr($fname); ?>" />
		</p>
		
		<!-- Last Name: Text Box -->
		<p>
			<label for="<?php echo $this->get_field_id('lname'); ?>"><?php esc_html_e('Last Name:', 'wpdws'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('lname'); ?>" name="<?php echo $this->get_field_name('lname'); ?>" type="text" value="<?php echo esc_attr($lname); ?>" />
		</p>
		
		<!-- Sex: Select Box -->
		<p>
			<label for="<?php echo $this->get_field_id( 'sex' ); ?>"><?php esc_html_e('Sex:', 'wpdws'); ?></label> 
			<select id="<?php echo $this->get_field_id( 'sex' ); ?>" name="<?php echo $this->get_field_name( 'sex' ); ?>" class="widefat" style="width:100%;">
				<option value="male" <?php selected( $sex, 'male' ); ?> ><?php esc_html_e('Male', 'wpdws'); ?></option>
				<option value="female" <?php selected( $sex, 'female' ); ?> ><?php esc_html_e('Female', 'wpdws'); ?></option>
			</select>
		</p>

		<!-- Show Sex? Checkbox -->
		<p>
			<input class="checkbox" type="checkbox" value="1" <?php checked( $show_sex, 1 ); ?> id="<?php echo $this->get_field_id( 'show_sex' ); ?>" name="<?php echo $this->get_field_name( 'show_sex' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'show_sex' ); ?>"><?php esc_html_e('Display sex publicly?', 'wpdws'); ?></label>
		</p>

		<?php
	}

	public function update($new_instance, $old_instance) {
		// processes widget options to be saved
		$instance = $old_instance;
		$instance['title'] = $this->model->wpd_ws_escape_slashes_deep($new_instance['title']);
		$instance['fname'] = $this->model->wpd_ws_escape_slashes_deep($new_instance['fname']);
		$instance['lname'] = $this->model->wpd_ws_escape_slashes_deep($new_instance['lname']);
		$instance['sex'] = $new_instance['sex'];
		$instance['show_sex'] = $new_instance['show_sex'];
		return $new_instance;
	}

	public function widget($args, $instance) {
		// outputs the content of the widget
		extract($args);
		
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$fname = empty( $instance['fname'] ) ? '' : $instance['fname'];
		$lname = empty( $instance['lname'] ) ? '' : $instance['lname'];
		$sex = empty( $instance['sex'] ) ? '' : $instance['sex'];
		$show_sex = empty( $instance['show_sex'] ) ? '' : $instance['show_sex']; 
		
		echo $before_widget;
		
		if ( $title )
			echo $before_title . $title . $after_title;
		
		if( !empty($fname) || !empty($lname)) 
			echo '<p>'.sprintf( esc_html__('Hello, My Name is %s %s','wpdws'),$fname , $lname ).'</p>';
		
		if ( $show_sex )
			echo '<p>'.sprintf(esc_html__( 'I am a %s.', 'wpdws' ),$sex).'</p>';
		
		echo $after_widget;
	}

}