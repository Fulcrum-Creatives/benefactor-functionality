<?php
/**
 * Custom widget for displaying the download widget
 *
 * @link       http://fulcrumcreatives.com/
 * @since      1.0.0
 *
 * @package    Benefactor
 * @subpackage Benefactor/public
 */

/**
 * Custom widget for displaying the download widget.
 *
 * @package    Benefactor
 * @subpackage Benefactor/public
 * @author     Fulcrum Creatives <info@fulcrumcreatives.com>
 */
class Benefactor_Download_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
	 		'download_widget', // Base ID
			'Download Widget', // Name
			array( 'description' => __( 'List the Download', 'benefactor' ), ) // Args
		);
		add_filter( 'dynamic_sidebar_params', array( $this, 'my_dynamic_sidebar_params' ) );
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
		$subtitle = $instance['subtitle'];
		$url = get_field( 'bene_widget_page_link', 'widget_' . $widget_id );
		echo '<div class="widget__download"><h2 class="widgettitle">' . $title . '</h2><div class="download__button button"><a href="'. $url .'">' . $subtitle . '</a></div></div>';
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
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['subtitle'] = ( ! empty( $new_instance['subtitle'] ) ) ? strip_tags( $new_instance['subtitle'] ) : '';
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
		$title = !empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'benefactor' );
		$subtitle = !empty( $instance['subtitle'] ) ? $instance['subtitle'] : __( 'New Subtitle', 'benefactor' );
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'subtitle' ); ?>"><?php _e( 'Button Text:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name( 'subtitle' ); ?>" type="text" value="<?php echo esc_attr( $subtitle ); ?>" />
		</p>
		<?php
	}

	/**
     * Get the Widget Parameters
     * @param  mixed $params 
     * @return array 
     */
    public function my_dynamic_sidebar_params( $params ) {
        // get widget vars
        $widget_name = $params[0]['widget_name'];
        $widget_id = $params[0]['widget_id'];
        // return
        return $params;
    }

} // class custom_archive_widget

add_action( 'widgets_init', 'download_widget' );

function download_widget() {
	register_widget( 'Benefactor_Download_Widget' );
}
?>