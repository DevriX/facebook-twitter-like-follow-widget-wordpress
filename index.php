<?php

/*
Plugin Name: Facebook and Twitter Like/Follow Widget
Description: Facebook and Twitter Like/Follow Widget shows a light box containing a like and follow button.
Author: Samuel Elh
Version: 1.0
Author URI: http://profiles.wordpress.org/elhardoum
*/

class elh_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'elh_widget',
			__('Facebook and Twitter Like/Follow Widget', 'wordpress'),
			array( 'description' => __( 'Facebook and Twitter Like/Follow Widget shows a light box containing a like and follow button.', 'wordpress' ), )
		);
	}

	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		$fb = apply_filters( 'widget_title', $instance['fb'] );
		$tw = apply_filters( 'widget_title', $instance['tw'] );
		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
		if(function_exists(elh_social_widget))
			echo elh_social_widget($fb, $tw);
		echo $args['after_widget'];
	}

	public function form( $instance ) {

		$title = ( isset( $instance[ 'title' ] ) ) ? esc_attr( $instance[ 'title' ] ) : '';
		$fb = ( isset( $instance[ 'fb' ] ) ) ? esc_attr( $instance[ 'fb' ] ) : '';
		$tw = ( isset( $instance[ 'tw' ] ) ) ? esc_attr( $instance[ 'tw' ] ) : '';

		?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Widget title:' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'fb' ); ?>"><?php _e( 'Facebook URL/Username:' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'fb' ); ?>" name="<?php echo $this->get_field_name( 'fb' ); ?>" type="text" value="<?php echo esc_attr( $fb ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'tw' ); ?>"><?php _e( 'Twitter URL, tag or username:' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'tw' ); ?>" name="<?php echo $this->get_field_name( 'tw' ); ?>" type="text" value="<?php echo esc_attr( $tw ); ?>" />
			</p>
			<p>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>			<script src="https://apis.google.com/js/platform.js" async defer></script>
				<a href="https://twitter.com/samuel_elh" class="twitter-follow-button unit" data-show-count="true" data-size="large">Follow @samuel_elh</a>
			</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['fb'] = ( ! empty( $new_instance['fb'] ) ) ? strip_tags( $new_instance['fb'] ) : '';
		$instance['tw'] = ( ! empty( $new_instance['tw'] ) ) ? strip_tags( $new_instance['tw'] ) : '';
		return $instance;
	}
}

function elh_load_widget() {
	register_widget( 'elh_widget' );
}
add_action( 'widgets_init', 'elh_load_widget' );


function elh_social_head() {
	?>
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4&appId=712320088891230";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>			<script src="https://apis.google.com/js/platform.js" async defer></script>
		<style type="text/css" media="all">
		.elh_fb_tw_wp {
			border: 1px solid #ddd;
			overflow: hidden;
			padding: 1em;
			position: relative;
		}
		.elh_fb_tw_wp .unit {
			max-width: 100%;
			width: 100%;
			overflow: hidden;
			position: relative;
		}
		.elh_fb_tw_wp hr {
			color: #ddd;
			width: 100%;
			margin-left: -1em;
			margin-right: 1em;
			width: 150%;
		}
		</style>
	<?php
}
add_action('wp_head', 'elh_social_head');

function elh_social_widget($fb, $tw) {
	if ( !$tw )
		$tw = esc_attr( "samuel_elh" );

	$fbu = ( is_numeric( strpos($fb, "http") ) ) ? esc_attr( $fb ) : "https://www.facebook.com/$fb";
	$twu = ( is_numeric( strpos($tw, "http") ) ) ? esc_attr( $tw ) : "https://twitter.com/$tw";
	?>
		<div class="elh_fb_tw_wp">
			<div class="fb-like unit" data-href="<?php echo $fbu; ?>" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
			<hr>
			<a href="<?php echo $twu; ?>" class="twitter-follow-button unit" data-show-count="true" data-size="large">Follow @<?php echo $twu; ?></a>
		</div>

	<?php
}

function ftlfw_donate_link( $links ) {
    $settings_link = '<a href="http://go.elegance-style.com/donate/" target="_new">' . __( 'Donate' ) . '</a>';
    array_push( $links, $settings_link );
  	return $links;
}
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'ftlfw_donate_link' );
