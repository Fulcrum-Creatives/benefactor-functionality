<?php
/**
 * Custom widget for displaying post archives
 *
 * @link       http://fulcrumcreatives.com/
 * @since      1.0.0
 *
 * @package    Benefactor
 * @subpackage Benefactor/public
 */

/**
 * Custom widget for displaying post archives
 *
 * @package    Benefactor
 * @subpackage Benefactor/public
 * @author     Fulcrum Creatives <info@fulcrumcreatives.com>
 */
class Benefactor_Childpage_widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
	 		'childpage_widget', // Base ID
			'Sub Page Listing Widget', // Name
			array( 'description' => __( 'List the Subpages', DOMAIN ), ) // Args
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
		global $do_not_duplicate;
		$title = $instance['title'];
		echo '<h2 class="widgettitle">' . $title . '</h2><ul>';
		$service_query = new WP_Query;
		$service_child = $service_query->query( array( 
			'post_type' => 'page', 
			'post_per_page' => -1, 
			'post__not_in' => $do_not_duplicate
		) ); 
		$services = get_page_by_title( 'Services' );
		$services_children = get_page_children( $services->ID, $service_child );
		foreach( $services_children as $child ) {
			echo '<li><a href="' . $child->guid . '"">' . $child->post_title . '</a></li>';
		}
		echo '</ul>';
		echo $after_widget;
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
		$instance = array(
			'title'			=> strip_tags( $new_instance['title'] ),
			'search_title'	=> strip_tags( $new_instance['search_title'] )
			);
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
		     $search_title = esc_attr($instance['search_title']);
		} else {
		     $title = '';
		     $search_title = '';
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php 
	}

}
add_action( 'widgets_init', 'childpage_widget' );
function childpage_widget() {
	register_widget( 'Benefactor_Childpage_widget' );
}