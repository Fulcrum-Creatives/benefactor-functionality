<?php
/**
 * Custom widget for displaying the team list
 *
 * @link       http://fulcrumcreatives.com/
 * @since      1.0.0
 *
 * @package    Benefactor
 * @subpackage Benefactor/public
 */

/**
 * Custom widget for displaying the team list
 *
 * @package    Benefactor
 * @subpackage Benefactor/public
 * @author     Fulcrum Creatives <info@fulcrumcreatives.com>
 */
class Benefactor_Team_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
	 		'team_widget', // Base ID
			'Team Members Widget', // Name
			array( 'description' => __( 'List Team Menbers ', DOMAIN ), ) // Args
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
		echo '<h2 class="widgettitle">' . $title . '</h2><ul>';
		global $do_not_duplicate;
		$teamw_query = new WP_Query(array(
					    'post_type'         =>'team_member',
					    'posts_per_page'   	=> -1,
					    'order'				=> 'asc',
					    /*'meta_key'			=> 'profile_order',
					    'orderby'			=> 'meta_value',*/
					    'post__not_in'      => $do_not_duplicate

					));
		while ($teamw_query->have_posts()) : $teamw_query->the_post();
		echo '<li><a href="';
		the_permalink();
		echo '">';
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
		if( $instance) {
		     $title = esc_attr($instance['title']);
		} else {
		     $title = '';
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php 
	}

} // class custom_clients_widget
add_action( 'widgets_init', 'team_widget' );
function team_widget() {
	register_widget( 'Benefactor_Team_Widget' );
}