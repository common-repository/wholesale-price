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
 * @package    Dynamic_Wholesale_Price
 * @subpackage Dynamic_Wholesale_Price/includes
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
 * @package    Dynamic_Wholesale_Price
 * @subpackage Dynamic_Wholesale_Price/includes
 * @author     Your Name <email@example.com>
 */
class Dynamic_Wholesale_Price {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Dynamic_Wholesale_Price_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $dynamic_wholesale_price    The string used to uniquely identify this plugin.
	 */
	protected $dynamic_wholesale_price;

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
		if ( defined( 'DYNAMIC_WHOLESALE_PRICE_VERSION' ) ) {
			$this->version = DYNAMIC_WHOLESALE_PRICE_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->dynamic_wholesale_price = 'dynamic-wholesale-price';

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
	 * - Dynamic_Wholesale_Price_Loader. Orchestrates the hooks of the plugin.
	 * - Dynamic_Wholesale_Price_i18n. Defines internationalization functionality.
	 * - Dynamic_Wholesale_Price_Admin. Defines all hooks for the admin area.
	 * - Dynamic_Wholesale_Price_Public. Defines all hooks for the public side of the site.
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
                require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-dynamic-wholesale-price-activator.php';
                require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-dynamic-wholesale-price-deactivator.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-dynamic-wholesale-price-loader.php';
                require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-dynamic-wholesale-price-dbhandler.php';
                
		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-dynamic-wholesale-price-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-dynamic-wholesale-price-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-dynamic-wholesale-price-public.php';

		$this->loader = new Dynamic_Wholesale_Price_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Dynamic_Wholesale_Price_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Dynamic_Wholesale_Price_i18n();

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

		$plugin_admin = new Dynamic_Wholesale_Price_Admin( $this->get_dynamic_wholesale_price(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
                $this->loader->add_action('woocommerce_process_product_meta', $plugin_admin, 'wholesale_product_tab_content_process');
                $this->loader->add_action('woocommerce_product_data_panels', $plugin_admin, 'wholesale_product_tab_content');
                $this->loader->add_action('woocommerce_product_write_panel_tabs', $plugin_admin,'wholesale_product_tab'); 
                $this->loader->add_action( 'admin_menu', $plugin_admin, 'wholesale_price_admin_menu' );
                
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Dynamic_Wholesale_Price_Public( $this->get_dynamic_wholesale_price(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
                //$this->loader->add_filter( 'woocommerce_get_price_html',$plugin_public, 'wholesale_price_html', 100, 2 );               
                $this->loader->add_action('woocommerce_before_add_to_cart_button',$plugin_public,'wholesale_price_html_before_cart');
                $this->loader->add_action( 'woocommerce_before_calculate_totals',$plugin_public, 'wholesale_price_before_calculate_total', 1, 1 );
                $this->loader->add_filter( 'woocommerce_cart_item_price',$plugin_public,  'wholesale_price_filter_cart_item_price', 10, 2 );
                $this->loader->add_filter( 'woocommerce_cart_item_subtotal',$plugin_public, 'wholesale_price_filter_cart_subtotal_price' , 10, 2 );
                $this->loader->add_filter( 'woocommerce_checkout_item_subtotal',$plugin_public, 'wholesale_price_filter_cart_subtotal_price' , 10, 2 ); 
                $this->loader->add_filter( 'woocommerce_order_formatted_line_subtotal',$plugin_public, 'wholesale_price_filter_subtotal_order_price' , 10, 3 );

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
	public function get_dynamic_wholesale_price() {
		return $this->dynamic_wholesale_price;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Dynamic_Wholesale_Price_Loader    Orchestrates the hooks of the plugin.
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
