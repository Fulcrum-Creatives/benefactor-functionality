<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the dashboard.
 *
 * @link       http://fulcrumcreatives.com/
 * @since      1.0.0
 *
 * @package    Benefactor
 * @subpackage Benefactor/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Benefactor
 * @subpackage Benefactor/includes
 * @author     Fulcrum Creatives <info@fulcrumcreatives.com>
 */
class Benefactor {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Benefactor_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $benefactor    The string used to uniquely identify this plugin.
	 */
	protected $benefactor;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->benefactor = 'benefactor';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Benefactor_Loader. Orchestrates the hooks of the plugin.
	 * - Benefactor_i18n. Defines internationalization functionality.
	 * - Benefactor_Admin. Defines all hooks for the dashboard.
	 * - Benefactor_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-benefactor-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-benefactor-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the Dashboard.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-benefactor-admin.php';

		/**
		 * The class responsible for featured posts
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-benefactor-featured-post.php';

		/**
		 * The class responsible for adding IDs to admin post columns
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-benefactor-show-post-ids.php';

		/**
		 * The class responsible for removeing menu items from admin
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-benefactor-add-menu-items.php';
		/**
		 * The class responsible for removeing menu items from admin
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-benefactor-remove-menu-items.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-benefactor-public.php';

		/**
		 * The class responsible for creating custom post types
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-benefactor-register-post-type.php';

		/**
		 * The class responsible for creating custom taxonomies
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-benefactor-register-taxonomies.php';

		/**
		 * The class responsible for creating the Download Widget
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/cpt-team.php';

		/**
		 * The class responsible for creating the features resources widget
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-benefactor-featured-resources-widget.php';

		/**
		 * The class responsible for creating the Facebook Widget
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-benefactor-facebook-widget.php';

		/**
		 * The class responsible for creating the LinkedIn Widget
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-benefactor-linkedin-widget.php';

		/**
		 * The class responsible for creating the Twitter Widget
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-benefactor-twitter-widget.php';

		/**
		 * The class responsible for creating the Download Widget
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-benefactor-download-widget.php';

		/**
		 * The class responsible for creating the Client Categories Widget
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-benefactor-clients-cat-widget.php';

		/**
		 * The class responsible for creating the Archive Widget
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-benefactor-archive-widget.php';

		/**
		 * The class responsible for creating the Team Widget
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-benefactor-team-widget.php';

		/**
		 * The class responsible for creating the Partners Widget
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-benefactor-partners-widget.php';

		/**
		 * The class responsible for creating the Child Pages Widget
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-benefactor-childpage-widget.php';

		/**
		 * The class responsible for creating the Resources Widget
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-benefactor-resources-widget.php';

		$this->loader = new Benefactor_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Benefactor_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Benefactor_i18n();
		$plugin_i18n->set_domain( $this->get_benefactor() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the dashboard functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Benefactor_Admin( $this->get_benefactor(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		/*$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );*/

		$show_post_ids = new Bebefactor_Show_Post_Ids();

		$featured_posts = new Benefactor_Featured_Post();

		/**
		 * Remove menu Items from admin
		 */
		//$remove_menu_items = new Benefactor_Remove_Menu_Items( array( 'edit-comments.php' ) );

		/**
		 * Add menu Items
		 * 
		 */
		$add_menu_items = new Benefactor_Add_Menu_Items();
		$this->loader->add_action( 'admin_menu', $add_menu_items, 'register_my_custom_menu_page' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		/*$plugin_public = new Benefactor_Public( $this->get_benefactor(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );*/

		/**
		 * Register custom post types
		 */
		$register_slider_post_type = new Benefactor_Register_Post_Type('Slider');
		$register_clients_post_type = new Benefactor_Register_Post_Type('Clients', '', array(), array('supports' => array( 'title', 'editor', 'thumbnail', 'excerpt')));
		$register_partners_post_type = new Benefactor_Register_Post_Type('Partners');
		$register_case_study_tax = new Benefactor_Register_Taxonomies( 'clients', 'Client Categories' );
		$register_tasks_tax = new Benefactor_Register_Taxonomies( 'clients', 'Tasks' );
		//$register_transfer_post_type = new Benefactor_Register_Post_Type('Transfer');
		
		

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_benefactor() {
		return $this->benefactor;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Benefactor_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
