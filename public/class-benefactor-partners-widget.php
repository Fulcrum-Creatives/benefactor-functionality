<?php

add_action( 'widgets_init', 'partners_widget' );

function partners_widget() {
	register_widget( 'Benefactor_Partners_Widget' );
}
class Benefactor_Partners_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
	 		'partners_widget', // Base ID
			'Partners Widget', // Name
			array( 'description' => __( 'List Our Partners ', DOMAIN ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		extract( $args );
		echo $args['before_widget'];
		$title = $instance['title'];
		$text = $instance['text'];
		
		echo '<div class="partners-widget">
				<h2 class="widgettitle">' . $title . '</h2>
				<div class="widget-content">' . $text . '</div>
				<ul>';
		$partnersw_query = new WP_Query(array(
					    'post_type'         =>'partners',
					    'posts_per_page'   	=> -1,
					));
		while ($partnersw_query->have_posts()) : $partnersw_query->the_post();
		$partner_link = ( get_field( 'partner_link' ) ? get_field( 'partner_link' ) : '' );
		echo '<li><a href="' . $partner_link . '">';
		the_title();
		echo '</a></li>';
		endwhile; wp_reset_query();
		echo '</ul>';
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['text'] = strip_tags( $new_instance['text'] );
		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( $instance ) {
			$title = $instance[ 'title' ];
			$text = $instance[ 'text' ];
		}
		else {
			$title ='';
			$text ='';
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Text:' ); ?></label> 
		<textarea class="widefat" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo esc_attr( $text ); ?></textarea>
		</p>
		<?php 
	}

} // class custom_clients_widget
?>