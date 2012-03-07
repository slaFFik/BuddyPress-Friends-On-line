<?php
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
				'fol-widget',
				__('Friends on-line','fol'),
				array(
					'classname' => 'fol-widget',
					'description' => __('Friends on-line widget', 'fol')
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
					'per_page'        => $instance['friends_number'],
					'user_id'         => bp_loggedin_user_id()
				);
				if ( bp_has_members($searchArgs)){
					if ( file_exists( dirname(__File__) . '/bpfol-widget-template.php' ) ) {
						include (dirname(__File__) . "/bpfol-widget-template.php");
					}
				} else {
				?>
					<div id="message" class="info">
						<p><?php _e( "No friends on-line.", 'fol' ); ?></p>
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
			$instance['view_mode']  		   = $new_instance['view_mode'];
			$instance['display_avatar']   	   = $new_instance['display_avatar']? 1 : 0;
			$instance['display_name']     	   = $new_instance['display_name']? 1 : 0;
			$instance['display_last_activity'] = $new_instance['display_last_activity']? 1 : 0;
			$instance['friends_number'] 	   = $new_instance['friends_number'];
			return $instance;
		}

		/*
		 * Widget settings form
		 */
		function form($instance) {

			// Set up some default widget settings
			$defaults = array(
				'title' => __('Friends on-line', 'fol'),
				'view_mode' => 'standart',
				'display_avatar' => 1,
				'display_name' => 1,
				'display_last_activity' => 0,
				'friends_number' => 6
			);
			
			$instance = wp_parse_args((array) $instance, $defaults);
			$title = strip_tags($instance['title']);
			$view_mode = empty($instance['view_mode'])? $defaults['friends_number'] : $instance['view_mode'];
			$display_avatar = $instance['display_avatar'] ? 'checked="checked"' : '';
			$display_name = $instance['display_name'] ? 'checked="checked"' : '';
			$display_last_activity = $instance['display_last_activity'] ? 'checked="checked"' : '';
			$friends_number = (empty($instance['friends_number']) && is_numeric($instance['friends_number']))? $defaults['friends_number'] : $instance['friends_number'];
			?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'fol'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
			<p>
				<label for="<?php echo $this->get_field_id('display_avatar'); ?>"><?php _e('View mode', 'fol'); ?></label>
				<select name="<?php echo $this->get_field_name('view_mode'); ?>" id="<?php echo $this->get_field_name('view_mode'); ?>">
					<option value="standart" <?php echo ($view_mode == 'standart')? 'selected="selected"' : ''?>><?php _e('standart', 'fol')?></option>
					<option value="only_avatar" <?php echo ($view_mode == 'only_avatar')? 'selected="selected"' : ''?>><?php _e('only avatar', 'fol')?></option>
				</select>
			</p>
			<fieldset style="border:1px solid #ccc; padding: 10px 10px 0; margin:0 0 15px;">
				<legend style="color: #777;"><em><?php _e('Standart mode settings:', 'fol')?></em></legend>
				<p>
					<input class="checkbox" type="checkbox" <?php echo $display_avatar; ?> id="<?php echo $this->get_field_id('display_avatar'); ?>" name="<?php echo $this->get_field_name('display_avatar'); ?>" /> <label for="<?php echo $this->get_field_id('display_avatar'); ?>"><?php _e('Display avatar', 'fol'); ?></label>
					<br />
					<input class="checkbox" type="checkbox" <?php echo $display_name; ?> id="<?php echo $this->get_field_id('display_name'); ?>" name="<?php echo $this->get_field_name('display_name'); ?>" /> <label for="<?php echo $this->get_field_id('display_name'); ?>"><?php _e('Display name', 'fol'); ?></label>
					<br />
					<input class="checkbox" type="checkbox" <?php echo $display_last_activity; ?> id="<?php echo $this->get_field_id('display_last_activity'); ?>" name="<?php echo $this->get_field_name('display_last_activity'); ?>" /> <label for="<?php echo $this->get_field_id('display_last_activity'); ?>"><?php _e('Display last active date', 'fol'); ?></label>
				</p>
			</fieldset>
			<p><label for="<?php echo $this->get_field_id('friends_number'); ?>"><?php _e('Number of friends:', 'fol'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('friends_number'); ?>" name="<?php echo $this->get_field_name('friends_number'); ?>" type="text" value="<?php echo esc_attr($friends_number); ?>" /></p>
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