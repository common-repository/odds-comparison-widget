<?php
/*
Plugin Name: Odds comparison Widget
Description: View highest odds for multiple sports, leagues and events.
Version: 1.0
Author: Odds.nu
Author URI: https://www.odds.nu
License: GPLv2
*/

// The widget class
class OddsComparisonWidget extends WP_Widget {
	// Main constructor
	public function __construct() {
		parent::__construct(
			'oddscomparisonwidget',
			__( 'Odds comparison Widget', 'text_domain' ),
			array(
				'customize_selective_refresh' => true,
			)
		);
	}
	// The widget form (for the backend )
	public function form( $instance ) {
		// Set widget defaults
		$defaults = array(
			'title'    => '',
			'url'    => '',
			'maxEvents'     => 5,
			'height'     => 400,
		);
		
		// Parse current settings with defaults
		extract( wp_parse_args( ( array ) $instance, $defaults ) ); ?>
		
		<?php // Widget Title ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Widget Title', 'text_domain' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<?php // Text field ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>"><?php _e( 'League/event relative url', 'text_domain' ); ?></label>
			<p></p>
			<ol>
				<li>Navigate to your league or event at <a href="https://www.odds.nu" target="_blank" rel="noopener">Odds.nu.</a></li>
				<li>Copy the relative url, for example "fotboll/internationellt/champions-league" or "fotboll/internationellt/champions-league/2019-08-13/fc-porto-fc-krasnodar"</li>
				<li>Paste into this field</li>
			</ol>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'url' ) ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>" />
		</p>

		<?php // Text Field ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'maxEvents' ) ); ?>"><?php _e( 'Max number of events:', 'text_domain' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'maxEvents' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'maxEvents' ) ); ?>" type="number" value="<?php echo esc_attr( $maxEvents ); ?>" />
		</p>
		
		<?php // Text Field ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>"><?php _e( 'Height of widget (pixels):', 'text_domain' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'height' ) ); ?>" type="number" value="<?php echo esc_attr( $height ); ?>" />
		</p>

	<?php }
	// Update widget settings
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title']    = isset( $new_instance['title'] ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
		$instance['url']    = isset( $new_instance['url'] ) ? wp_strip_all_tags( $new_instance['url'] ) : '';
		$instance['maxEvents']     = isset( $new_instance['maxEvents'] ) ? wp_strip_all_tags( $new_instance['maxEvents'] ) : '';
		$instance['height']     = isset( $new_instance['height'] ) ? wp_strip_all_tags( $new_instance['height'] ) : '';
		return $instance;
	}
	// Display the widget
	public function widget( $args, $instance ) {
		extract( $args );
		// Check the widget options
		$title    = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
		$url = isset( $instance['url'] ) ? $instance['url'] : '';
		$maxEvents = isset( $instance['maxEvents'] ) ? $instance['maxEvents'] : 5;
		$height = isset( $instance['height'] ) ? $instance['height'] : 400;
		// WordPress core before_widget hook (always include )
		echo $before_widget;
		// Display the widget
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
		echo '<iframe src="https://www.odds.nu/' . $url . '/embedded?maxEvents=' . $maxEvents . '" width="100%" height="' . $height . 'px" frameborder="0" scrolling="no" seamless="seamless">';
			
			
		echo '</iframe>';
		// WordPress core after_widget hook (always include )
		echo $after_widget;
	}
}
// Register the widget
function ocw_odds_comparison_widget() {
	register_widget( 'OddsComparisonWidget' );
}
add_action( 'widgets_init', 'ocw_odds_comparison_widget' );