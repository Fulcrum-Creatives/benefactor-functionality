<?php
/**
 * Register custom post type
 *
 * @link       http://fulcrumcreatives.com
 * @since      1.0.0
 *
 * @package    Benefactor
 * @subpackage Benefactor/public
 */

/**
 * Register custom post type
 *
 * Initialize the class
 *     $register_post_type = new Benefactor_Register_Post_Type( $post_type, $plural array(), array() );
 *
 * @package    Benefactor
 * @subpackage Benefactor/public
 * @author     Fulcrum Creatives <info@fulcrumcreatives.com>
 */

class Benefactor_Register_Post_Type {

    /**
     * The post type
     *
     * @var string
     */
    public $post_type;

    /**
     * Plural Version of Post Type
     *
     * @var string
     */
    public $plural;

    /**
     * The labels array
     *
     * @var array
     */
    public $post_type_labels;

    /**
     * The post type arguments
     *
     * @var array
     */
    public $post_type_args;

    /**
     * Initialize the class and set its properties.
     *
     * @param unknown $post_type        The post type's name
     * @param unknown $post_type_labels The post type labels
     * @param unknown $post_type_args   The post type arguments
     */
    public function __construct( $post_type, $plural = '', $post_type_labels = array(), $post_type_args = array() ) {
        $this->post_type        = strtolower( str_replace( array( ' ', '-' ), '_', $post_type ) );
        $this->plural           = ( !empty( $plural ) ? strtolower( str_replace( array( ' ', '-' ), '_', $plural ) ) : $this->post_type );
        $this->post_type_labels = $post_type_labels;
        $this->post_type_args   = $post_type_args;

        /**
         * If plugin is activated Flush the rewrite rules
         */
        if ( !post_type_exists( $this->post_type ) ) {
            register_activation_hook( __FILE__, 'flush_rewrite_rules' );
            add_action( 'init', array( $this, 'register_post_type' ) );
        }

    }

    /**
     * Flush rerwite rules on plugin activation
     */
    public static function flush_rewrite_rules() {
        flush_rewrite_rules( false );
    }

    /**
     * The post type labels. User defined labels override the default
     *
     * @return array The modified array of post type labels
     */
    private function post_type_labels() {
        $singular = ucwords( str_replace( '_', ' ', $this->post_type ) );
        $plural   = ucwords( str_replace( '_', ' ', $this->plural ) );
        $defaults = array(
            'name'                  => _x( $plural, 'post type general name' ),
            'singular_name'         => _x( $singular, 'post type singular name' ),
            'add_new'               => __( 'Add New' ),
            'all_items'             => __( 'All ' . $plural ),
            'add_new_item'          => __( 'Add New ' . $singular ),
            'edit_item'             => __( 'Edit ' . $singular ),
            'new_item'              => __( 'New ' . $singular ),
            'view_item'             => __( 'View ' . $singular ),
            'search_items'          => __( 'Search ' . $plural ),
            'not_found'             => __( 'No ' . $plural . ' Found' ),
            'not_found_in_trash'    => __( 'No ' . $plural . ' Found in Trash' ),
            'parent_item_colon'     => __( 'Parent ' . $singular . ' Post:' ),
            'menu_name'             => __( $plural ),
        );
        $args     = $this->post_type_labels;
        $labels   = array_merge( $defaults, $args );

        return $labels;
    }

    /**
     * The post type arguments. User defined arguments override the default
     *
     * @return array The modified array of post type arguments
     */
    private function post_type_args() {

        $labels   = $this->post_type_labels();
        $defaults = array(
            'labels'                => $labels,
            'description'           => '',
            'public'                => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'show_ui'               => true,
            'show_in_nav_menus'     => true,
            'show_in_menu'          => true,
            'show_in_admin_bar'     => true,
            'menu_position'         => NULL,
            'menu_icon'             => NULL,
            'capability_type'       => 'post',
            'capabilities'          => array(
                'edit_post',
                'read_post',
                'delete_post',
                'edit_posts',
                'edit_others_posts',
                'publish_posts',
                'read_private_posts'
            ),
            'map_meta_cap'          => true,
            'hierarchical'          => false,
            'supports'              => array(
                'title',
                'editor'
            ),
            'register_meta_box_cb'  => '',
            'taxonomies'            => array(),
            'has_archive'           => false,
            'permalink_epmask'      => EP_PERMALINK,
            'rewrite'               => array( 'slug'=> $this->post_type ),
            'query_var'             => true,
            'can_export'            => true,
            '_builtin'              => false
        );
        $args = $this->post_type_args;
        $arguments = array_merge( $defaults, $args );

        return $arguments;
    }

    /**
     * Register Post Type
     */
    public function register_post_type() {
        register_post_type( $this->post_type, $this->post_type_args() );
    }
}
