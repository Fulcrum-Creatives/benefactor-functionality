<?php
/**
 * Show ID's for Posts, Pages, Taxonomies, Media, Comments, and Users
 * on the post tabels
 *
 * @link       http://fulcrumcreatives.com
 * @since      1.0.0
 *
 * @package    Benefactor
 * @subpackage Benefactor/public
 */

/**
 * Show ID's for Posts, Pages, Taxonomies, Media, Comments, and Users
 * on the post tabels
 *
 * Initialize the class
 *     $variable = new new Show_Post_Ids();
 *
 * @package    Benefactor
 * @subpackage Benefactor/public
 * @author     Fulcrum Creatives <info@fulcrumcreatives.com>
 */
class Bebefactor_Show_Post_Ids {

    /**
     * Initialize the class and set its properties.
     */
    public function __construct() {
        add_action( 'admin_init', array( $this, 'post_id_add' ) );
    }

    /**
     * Column ID Filter
     *
     * @return string the column ID to use
     * @example function post_id_column_id() {
     *              return 'custom_id';
     *          }
     *          add_filter( 'post_id_column_id_filter' , 'post_id_column_id' );
     *
     */
    public function post_id_column_id_filter() {
        $post_id_column_id = 'post_id';
        if ( has_filter( 'post_id_column_id_filter' ) ) {
            $post_id_column_id = apply_filters( 'post_id_column_id_filter', $post_id_column_id );
        }
        return $post_id_column_id;
    }

    /**
     * Column Title Filter
     *
     * @return string The title of the column to use
     * @example function post_id_column_title() {
     *              return 'Custom Column Title';
     *          }
     *          add_filter( 'post_id_column_title_filter' , 'post_id_column_title' );
     */
    public function post_id_column_title_filter() {
        $post_id_column_title = 'ID';
        if ( has_filter( 'post_id_column_title_filter' ) ) {
            $post_id_column_title = apply_filters( 'post_id_column_title_filter', $post_id_column_title );
        }
        return $post_id_column_title;
    }

    /**
     * The Column Width
     *
     * @return string the width of the column
     * @example function post_id_column_width() {
     *              return '100%';
     *          }
     *          add_filter( 'post_id_column_width_filter' , 'post_id_column_width' );
     */
    public function post_id_column_width_filter() {
        $post_id_column_width = '6%';
        if ( has_filter( 'post_id_column_width_filter' ) ) {
            $post_id_column_width = apply_filters( 'post_id_column_width_filter', $post_id_column_width );
        }
        return $post_id_column_width;
    }

    /**
     * The pages to include the ID columns
     *
     * @return array The pages to include the ID columns
     * @example function post_id_page_types( $pages ) {
     *              // to add pages
     *              $add_pages = array(
     *                  'new_page.php'
     *              );
     *              $pages = array_merge( $add_pages, $pages );
     *              // to remove pages
     *              $remove_pages = array(
     *                  'edit.php',
     *                  'upload.php'
     *              )
     *              $pages = unsearray_difft( $pages, $remove_pages );
     *              return $pages;
     *           }
     *           add_filter( 'page_type_filter' , 'post_id_page_types' );
     */
    public function page_type_filter() {
        $pages = array(
            'edit.php',
            'edit-tags.php',
            'upload.php',
            'edit-comments.php',
            'users.php'
        );
        if ( has_filter( 'page_type_filter' ) ) {
            $pages = apply_filters( 'page_type_filter', $pages );
        }
        return $pages;
    }

    /**
     * Create the new column
     *
     * @param array   $defaults The default columns
     * @return array           The default columns with the custom column now added
     */
    public function post_id_column( $defaults ) {
        $defaults[ 'post_id' ] = __( 'ID' );
        return $defaults;
    }

    /**
     * The value for the columns
     *
     * @param string  $column_name The columns name
     * @param string  $id          The column ID
     * @return string              The value for the column
     */
    public function posts_id_value( $column_name, $id ) {
        if ( $column_name === 'post_id' ) {
            echo $id;
        }
    }

    /**
     * The Value for taxonomies and users
     *
     * @param string  $value       The value for the column
     * @param string  $column_name The columns name
     * @param string  $id          The column ID
     * @return string              The value for the column
     */
    public function posts_id_return_value( $value, $column_name, $id ) {
        $post_id_column_id = $this->post_id_column_id_filter();
        if ( $column_name == $post_id_column_id ) {
            $value = $id;
        }
        return $value;
    }
    /**
     * CSS for the columns
     */
    public function post_id_css() {
        global $pagenow;
        $pages = $this->page_type_filter();
        $post_id_column_id = $this->post_id_column_id_filter();
        $post_id_column_width = $this->post_id_column_width_filter();
        if ( in_array( $pagenow, $pages ) ) {
            echo "\r\n";
            echo '<style>
.fixed .column-' . $post_id_column_id . ' {
    width: ' . $post_id_column_width . ';
}
</style>';
        }
    }

    /**
     * Initiat the new columns
     */
    public function post_id_add() {
        $pages = $this->page_type_filter();
        /**
         * Css
         */
        add_action( 'admin_head', array( $this, 'post_id_css' ), 1, 2 );
        /**
         * Post Types
         */
        add_filter( 'manage_edit-slider_columns', array( $this, 'post_id_column' ) );
        add_action( 'manage_slider_posts_custom_column', array( $this, 'posts_id_value' ), 10, 2 );
        /**
         * Pages
         */
        /*add_filter( 'manage_pages_columns', array( $this, 'post_id_column' ) );
        add_action( 'manage_pages_custom_column', array( $this, 'posts_id_value' ), 10, 2 );*/
        /**
         * Media Attachments
         */
        /*add_filter( 'manage_media_columns', array( $this, 'post_id_column' ), 1 );
        add_action( 'manage_media_custom_column', array( $this, 'posts_id_value' ), 1, 2 );*/
        /**
         * Comments
         */
        /*add_action( 'manage_edit-comments_columns', array( $this, 'post_id_column' ) );
        add_action( 'manage_comments_custom_column', array( $this, 'posts_id_value' ), 10, 2 );*/
        /**
         * Taxonomies
         */
        /*foreach ( get_taxonomies() as $taxonomy ) {
            add_action( "manage_edit-${taxonomy}_columns", array( $this, 'post_id_column' ) );
            add_filter( "manage_${taxonomy}_custom_column", array( $this, 'posts_id_return_value' ), 10, 3 );
        }*/
        /**
         * Users
         */
        /*add_action( 'manage_users_columns', array( $this, 'post_id_column' ) );
        add_filter( 'manage_users_custom_column', array( $this, 'posts_id_return_value' ), 10, 3 );*/
    }
}