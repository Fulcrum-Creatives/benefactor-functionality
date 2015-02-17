<?php
/**
 * Register Custom Taxonomies
 *
 * @link       http://fulcrumcreatives.com
 * @since      1.0.0
 *
 * @package    Benefactor
 * @subpackage Benefactor/public
 */

/**
 * Register Custom Taxonomies
 *
 * Initialize the class
 *     $register_taxonomies = new Benefactor_Register_Taxonomies( $post_type, $taxonomy, $plural, array(), array() );
 *
 * @package    Benefactor
 * @subpackage Benefactor/public
 * @author     Fulcrum Creatives <info@fulcrumcreatives.com>
 */

class Benefactor_Register_Taxonomies {

    /**
     * Post type to attach taxonomy to
     *
     * @var string
     */
    public $post_type;

    /**
     * The taxonomy name
     *
     * @var string
     */
    public $taxonomy;

    /**
     * The plural version of the taxonomy
     *
     * @var string
     */
    public $plural;

    /**
     * The labels array
     *
     * @var array
     */
    public $tax_lables;

    /**
     * The arguments array
     *
     * @var array
     */
    public $tax_args;

    /**
     * Initialize the class and set its properties.
     */
    public function __construct( $post_type, $taxonomy, $plural = '',  $tax_labels = array(), $tax_args = array() ) {
        $this->post_type  = strtolower( str_replace( array( ' ', '-' ), '_', $post_type ) );
        $this->taxonomy   = strtolower( str_replace( array( ' ', '-' ), '_', $taxonomy ) );
        $this->plural     = ( !empty( $plural ) ? strtolower( str_replace( array( ' ', '-' ), '_', $plural ) ) : $this->taxonomy );
        $this->tax_labels = $tax_labels;
        $this->tax_args   = $tax_args;

        add_action( 'init', array( $this, 'register_taxonomy' ), 0 );
    }

    /**
     * The taxonomy labels. User defined labels override the default
     *
     * @return array  The modified array of taxomony labels
     * @since  1.0.0
     */
    private function taxonomy_labels() {
        $singular = ucwords( str_replace( '_', ' ', $this->taxonomy ) );
        $plural   = ucwords( str_replace( '_', ' ', $this->plural ) );
        $defaults = array(
            'name'                          => _x( $plural, 'taxonomy general name' ),
            'singular_name'                 => _x( $singular, 'taxonomy singular name' ),
            'all_items'                     => __( 'All ' . $plural ),
            'edit_item'                     => __( 'Edit ' . $plural ),
            'view_item'                     => __( 'View ' . $singular ),
            'update_item'                   => __( 'Update ' . $plural ),
            'add_new_item'                  => __( 'Add New ' . $singular ),
            'new_item_name'                 => __( 'New ' . $singular ),
            'parent_item'                   => __( 'Parent ' . $singular ),
            'parent_item_colon'             => __( 'Parent ' . $singular ),
            'search_items'                  => __( 'Search ' . $plural ),
            'popular_items'                 => __( 'Popular ' . $plural ),
            'separate_items_with_commas'    => __( 'Separate ' . $plural . ' with commas' ),
            'add_or_remove_items'           => __( 'Add or Remove ' . $singular ),
            'choose_from_most_used'         => __( 'Choose from the most used ' . $plural ),
            'not_found'                     =>  __( 'No ' . $plural . ' found.' ),
            'menu_name'                     => __(  $plural ),
        );
        $args   = $this->tax_labels;
        $labels = array_merge( $defaults, $args );

        return $labels;
    }

    /**
     * The taxonomy arguments. User defined arguments override the default
     *
     * @return array  The modified array of taxomony arguments
     * @since  1.0.0
     */
    private function taxanomy_args() {
        $defaults = array(
            'labels'                => $this->taxonomy_labels(),
            'public'                => true,
            'show_ui'               => true,
            'show_in_nav_menus'     => true,
            'show_tagcloud'         => false,
            'meta_box_cb'           => NULL,
            'show_admin_column'     => false,
            'hierarchical'          => true,
            'update_count_callback' => '',
            'query_var'             => $this->taxonomy,
            'rewrite'               => array( 'slug' => $this->taxonomy ),
            'capabilities'          => array(),
            'sort'                  => '',
            '_builtin'              => false
        );
        $arguments = $this->tax_args;
        $args      = array_merge( $defaults, $arguments );

        return $args;
    }

    /**
     * Register Taxomomy
     */
    public function register_taxonomy() {
        register_taxonomy( $this->taxonomy, $this->post_type, $this->taxanomy_args() );
    }
}
