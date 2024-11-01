<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Sidobe_Wp_Notif
 * @subpackage Sidobe_Wp_Notif/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Sidobe_Wp_Notif
 * @subpackage Sidobe_Wp_Notif/includes
 * @author     Sidobe <help@sidobe.com>
 */
class Sidobe_Wp_Notif {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Sidobe_Wp_Notif_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $sidobe_wp_notif    The string used to uniquely identify this plugin.
	 */
	protected $sidobe_wp_notif;

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
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'SIDOBE_WP_NOTIF_VERSION' ) ) {
			$this->version = SIDOBE_WP_NOTIF_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->sidobe_wp_notif = 'sidobe-wp-notif';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Sidobe_Wp_Notif_Loader. Orchestrates the hooks of the plugin.
	 * - Sidobe_Wp_Notif_i18n. Defines internationalization functionality.
	 * - Sidobe_Wp_Notif_Admin. Defines all hooks for the admin area.
	 * - Sidobe_Wp_Notif_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sidobe-wp-notif-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sidobe-wp-notif-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-sidobe-wp-notif-admin.php';

		$this->loader = new Sidobe_Wp_Notif_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Sidobe_Wp_Notif_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Sidobe_Wp_Notif_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Sidobe_Wp_Notif_Admin( $this->get_sidobe_wp_notif(), $this->get_version(), $this->loader );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'register_menu_page' );
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'register_submenu_main_page' );
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'register_submenu_options_page' );

        $this->loader->add_action( 'admin_init', $plugin_admin, 'form_options_init' );
        $this->loader->add_action( 'admin_post_handle_form_template', $plugin_admin, 'register_handle_form_template' );
        $this->loader->add_action( 'wp_ajax_sidobe_ajax_status_action', $plugin_admin, 'register_handle_ajax_status_template' );

        $this->loader->add_action( 'admin_notices', $plugin_admin, 'sidobe_wp_notif_admin_notices' );

        $plugin_admin->register_wc_hooks();
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
	public function get_sidobe_wp_notif() {
		return $this->sidobe_wp_notif;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Sidobe_Wp_Notif_Loader    Orchestrates the hooks of the plugin.
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
