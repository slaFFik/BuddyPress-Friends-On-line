<?php
/*
Plugin Name: BuddyPress Friends On-line (FOL)
Plugin URI: http://cosydale.com/my-plugin-buddypress-friends-on-line.html
Description: Plugin will display on your Friends page a new tab called Online with a list of currently online friends.
Author: slaFFik
Version: 0.2.1
Author URI: http://ovirium.com/
*/
if (!class_exists('FOL_Widget')) :
/**
 * Friends on-line widget class
 * @author ____
 *
 */
	class FOL_Widget extends WP_Widget {
		/*
		 * Construcotr
		 */
		function FOL_Widget() {
			// Create the widget
			$this->WP_Widget(
				'FOL-widget',
				'Friend on-line',
				array(
					'classname' => 'fol-widget',
					'description' => 'Friends on-line widget'
				) 
			);
		}
		
		/*
		 * Display widget function
		 */
		function widget($args, $instance) {
			// if user is loggedin
			if(bp_loggedin_user_id()) {
				// User-selected settings
				extract($args);
				$title = apply_filters('widget_title', $instance['title']);
				// Before widget (defined by themes)
				echo $before_widget;
				// Title of widget (before and after defined by themes)
				if (!empty($title)) echo $before_title . $instance['title'] . $after_title;
				// widget content
				$searchArgs  = array(
					'type'            => 'online',
					'page'            => 1,
					'per_page'        => 0,
					'user_id'         => bp_loggedin_user_id()
				);
				if ( bp_has_members($searchArgs)){
					include('widget-template.php');
				} else {
				?>
					<div id="message" class="info">
						<p><?php _e( "No friends on-line.", 'buddypress' ); ?></p>
					</div>
				<?php 
				}
				// After widget (defined by themes)
				echo $after_widget;
			}
		}

		/*
		 * On widget setting updates in admin bar
		 */
		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title']   		  	   = $new_instance['title'];
			$instance['display_avatar']   	   = $new_instance['display_avatar']? 1 : 0;;
			$instance['display_name']     	   = $new_instance['display_name']? 1 : 0;;
			$instance['display_last_activity'] = $new_instance['display_last_activity']? 1 : 0;
			return $instance;
		}

		/*
		 * Widget settings form
		 */
		function form($instance) {

			// Set up some default widget settings
			$defaults = array(
				'title' => 'Friends online',
				'display_avatar' => 1,
				'display_name' => 1,
				'display_last_activity' => 0
			);
			
			$instance = wp_parse_args((array) $instance, $defaults);
			$title = strip_tags($instance['title']);
			$display_avatar = $instance['display_avatar'] ? 'checked="checked"' : '';
			$display_name = $instance['display_name'] ? 'checked="checked"' : '';
			$display_last_activity = $instance['display_last_activity'] ? 'checked="checked"' : '';
			?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
			<p>
				<input class="checkbox" type="checkbox" <?php echo $display_avatar; ?> id="<?php echo $this->get_field_id('display_avatar'); ?>" name="<?php echo $this->get_field_name('display_avatar'); ?>" /> <label for="<?php echo $this->get_field_id('display_avatar'); ?>"><?php _e('Display avatar'); ?></label>
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php echo $display_name; ?> id="<?php echo $this->get_field_id('display_name'); ?>" name="<?php echo $this->get_field_name('display_name'); ?>" /> <label for="<?php echo $this->get_field_id('display_name'); ?>"><?php _e('Display name'); ?></label>
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php echo $display_last_activity; ?> id="<?php echo $this->get_field_id('display_last_activity'); ?>" name="<?php echo $this->get_field_name('display_last_activity'); ?>" /> <label for="<?php echo $this->get_field_id('display_last_activity'); ?>"><?php _e('Display last activity'); ?></label>
			</p>
			<?php 
			
		}
		
	}
endif;

// Register the plugin/widget
if (class_exists('FOL_Widget')) :

	function loadFOLWidget() {
		register_widget('FOL_Widget');
	}

	add_action('widgets_init', 'loadFOLWidget');

endif;