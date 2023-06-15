<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Settings Page
 *
 * Handle settings
 * 
 * @package WP Settings & Widget Page
 * @since 1.0.0
 */

global $wpd_ws_model;

$model = $wpd_ws_model;
	
	//all settings will reset as per default
	if(isset($_POST['wpd_ws_reset_settings']) && !empty($_POST['wpd_ws_reset_settings']) && $_POST['wpd_ws_reset_settings'] == esc_html__( 'Reset All Settings', 'wpdws' )) { //check click of reset button
		
		wpd_ws_default_settings(); // set default settings
		
		echo '<div class="updated" id="message">
			<p><strong>'. esc_html__("All Settings Reset Successfully.",'wpdws') .'</strong></p>
		</div>';
		
	}
	//check settings updated or not
	if(isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true') {
		
		echo '<div class="updated" id="message">
			<p><strong>'. esc_html__("Changes Saved Successfully.",'wpdws') .'</strong></p>
		</div>';
	}	
?>
	<!-- . begining of wrap -->
	<div class="wrap">
		<?php 
			echo "<h2>" . esc_html__('WP Settings & Widget Page', 'wpdws') . "</h2>";
		?>	
		<div class="wpd-ws-reset-setting">
			<form method="post" action="">
				<input id="wpd-ws-reset-all-options" type="submit" class="button-primary" name="wpd_ws_reset_settings" value="<?php echo esc_html__( 'Reset All Settings', 'wpdws' ); ?>" />
			</form>
		</div>
			
		<!-- beginning of the plugin options form -->
		<form  method="post" action="options.php">		
		
			<?php
				settings_fields( 'wpd_ws_plugin_options' );
				$wpd_ws_options = get_option( 'wpd_ws_options' );
			?>
		<!-- beginning of the settings meta box -->	
			<div id="wpd-ws-settings" class="post-box-container">
			
				<div class="metabox-holder">	
			
					<div class="meta-box-sortables ui-sortable">
			
						<div id="settings" class="postbox">	
			
							<div class="handlediv" title="<?php echo esc_html__( 'Click to toggle', 'wpdws' ) ?>"><br /></div>
			
								<!-- settings box title -->					
								<h3 class="hndle">					
									<span style="vertical-align: top;"><?php echo esc_html__( 'WP Settings & Widget Page', 'wpdws' ) ?></span>					
								</h3>
			
								<div class="inside">			

									<table class="form-table wpd-ws-settings-box"> 
										<tbody>
							
											<tr>
												<td colspan="2">
													<input type="submit" class="button-primary wpd-ws-settings-save" name="wpd_ws_settings_save" class="" value="<?php echo esc_html__( 'Save Changes', 'wpdws' ) ?>" />
												</td>
											</tr>
									
											<tr>
												<th scope="row">
													<label><strong><?php echo esc_html__( 'Title:', 'wpdws' ) ?></strong></label>
												</th>
												<td><input type="text" id="wpd-ws-settings-title" name="wpd_ws_options[title]" value="<?php echo $model->wpd_ws_escape_attr($wpd_ws_options['title']) ?>" size="63" /><br />
													<span class="description"><?php echo esc_html__( 'Enter a title.', 'wpdws' ) ?></span>
												</td>
											 </tr>
												
											<tr>
												<th scope="row">
													<label><strong><?php echo esc_html__( 'Description:', 'wpdws' ) ?></strong></label>
												</th>
												<td><textarea id="wpd-ws-settings-desc" name="wpd_ws_options[desc]" cols="60" rows="4" /><?php echo $model->wpd_ws_escape_attr($wpd_ws_options['desc']) ?></textarea><br />
													<span class="description"><?php echo esc_html__( 'Enter a description.', 'wpdws' ) ?></span>
												</td>
											</tr>
												
											<tr>
												<th scope="row">
													<label><strong><?php echo esc_html__( 'Editor content:', 'wpdws' ) ?></strong></label>
												</th>
												<td>
													<div class="wpd-ws-textarea-editor">
												
													<?php 
														wp_editor( $wpd_ws_options['content'], 'wpd_ws_options_content', array( 'textarea_rows' => '4', 'media_buttons' => true, 'textarea_name' => 'wpd_ws_options[content]') );
													?>											
									
													</div>
													<span class="description"><?php	echo esc_html__( 'Enter the editor content.', 'wpdws' ) ?></span>
												</td>
											</tr>
										
											<tr>
												<th scope="row">
													<label><strong><?php echo esc_html__( 'Date:', 'wpdws' ) ?></strong></label>
												</th>
												<td><input type="text" id="wpd-ws-settings-date" name="wpd_ws_options[date]" value="<?php echo $model->wpd_ws_escape_attr($wpd_ws_options['date']) ?>" size="39" /><br />
													<span class="description"><?php echo esc_html__( 'Enter a date.', 'wpdws' ) ?></span>
												</td>
											</tr>
											<?php
											if(!empty($wpd_ws_options['image'])) { //check connect button image
												$show_img_connect = ' <img src="'.esc_url($wpd_ws_options['image']).'" alt="'.esc_html__('Image','wpdws').'" />';
											} else {
												$show_img_connect = '';
											}
											?>											
									
											<tr>
												<th scope="row">
													<label><strong><?php echo esc_html__( 'Image:', 'wpdws' ) ?></strong></label>
												</th>
												<td><input type="text" id="wpd-ws-settings-image" name="wpd_ws_options[image]" value="<?php echo $wpd_ws_options['image'] ?>" size="63" />
													<input type="button" class="button-secondary wpd-ws-img-uploader" id="wpd-ws-img-btn" name="wpd_ws_img" value="<?php echo esc_html__( 'Choose image.', 'wpdws' ) ?>"><br />
													<span class="description"><?php echo esc_html__( 'Choose image.', 'wpdws' ) ?></span>
													<div id="wpd-ws-setting-image-view"><?php echo $show_img_connect ?></div>
												</td>
											</tr>
									
											<tr>
												<th scope="row">
													<label><strong><?php echo esc_html__( 'Color Picker:', 'wpdws' ) ?></strong></label>
												</th>
												<td>
													<?php		
													global $wp_version;
												
													if( $wp_version >= 3.5 ) {
														
														echo '<input type="text" value="'.$wpd_ws_options['color'].'" name="wpd_ws_options[color]" class="wpd-ws-color-box" data-default-color="#effeff" />';
														
													} else {
														
														echo '<div style="position:relative;">
																	<input type="text" name="wpd_ws_options[color]" value="'.$wpd_ws_options['color'].'" id="wpd_ws_options_color" />
																	<input type="button" class="wpd-ws-color-box button-secondary" value="'.esc_html__('Select Color','wpdws').'">
																	<div class="colorpicker" style="z-index:100; position:absolute; display:none;"></div>
														</div>';
													}
													?>													
													<br/><span class="description"><?php echo esc_html__( 'Choose color.', 'wpdws' ) ?></span>
												</td>
											</tr>
									
											<tr>
												<td colspan="2">
													<input type="submit" class="button-primary wpd-ws-settings-save" name="wpd_ws_settings_save" class="" value="<?php echo esc_html__( 'Save Changes', 'wpdws' ) ?>" />
												</td>
											</tr>
									
							
										</tbody>
									</table>
						
							</div><!-- .inside -->
				
						</div><!-- #settings -->
			
					</div><!-- .meta-box-sortables ui-sortable -->
			
				</div><!-- .metabox-holder -->
			
			</div><!-- #wps-settings-general -->
			
		<!-- end of the settings meta box -->		

		</form><!-- end of the plugin options form -->
	
	</div><!-- .end of wrap -->