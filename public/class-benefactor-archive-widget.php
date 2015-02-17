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
class Benefactor_Archive_widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
	 		'archive_widget', // Base ID
			'Archive Widget', // Name
			array( 'description' => __( 'List Archives with Search', DOMAIN ), ) // Args
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
		$search_title = $instance['search_title'];
		echo '<h2 class="widgettitle">' . $title . '</h2><ul>';
		wp_get_archives('type=monthly&limit=6');
		echo '</ul>
		<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" class="archive-search" >
			<input type="text" value="" name="s" id="s" placeholder="search"/>
			<input type="submit" id="searchsubmit" value="Search" class="button" />
		</form>';
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
		<p>
		<label for="<?php echo $this->get_field_id( 'search_title' ); ?>"><?php _e( 'Search Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'search_title' ); ?>" name="<?php echo $this->get_field_name( 'search_title' ); ?>" type="text" value="<?php echo esc_attr( $search_title ); ?>" />
		</p>
		<?php 
	}

}
add_action( 'widgets_init', 'archive_widget' );
function archive_widget() {
	register_widget( 'Benefactor_Archive_widget' );
}