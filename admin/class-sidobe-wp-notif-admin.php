<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://sidobe.com
 * @since      1.0.0
 *
 * @package    Sidobe_Wp_Notif
 * @subpackage Sidobe_Wp_Notif/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Sidobe_Wp_Notif
 * @subpackage Sidobe_Wp_Notif/admin
 * @author     Sidobe <help@sidobe.com>
 */
class Sidobe_Wp_Notif_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $sidobe_wp_notif    The ID of this plugin.
	 */
	private $sidobe_wp_notif;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
    private $loader;

    private $page_url;
    private $menu_title;

    private $sidobe_db;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $sidobe_wp_notif       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $sidobe_wp_notif, $version, $loader ) {

		$this->sidobe_wp_notif = $sidobe_wp_notif;
		$this->version = $version;
        $this->loader = $loader;
        $this->page_url = 'sidobe-wp-notif';
        $this->menu_title = 'Sidobe Notif';

        include_once plugin_dir_path( __FILE__ ) . 'class-sidobe-wp-notif-admin-db.php';
        $sidobe_db = new Sidobe_Wp_Notif_Admin_Db( $sidobe_wp_notif, $version );
        $this->sidobe_db = $sidobe_db;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Sidobe_Wp_Notif_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sidobe_Wp_Notif_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->sidobe_wp_notif, plugin_dir_url( __FILE__ ) . 'css/sidobe-wp-notif-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Sidobe_Wp_Notif_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sidobe_Wp_Notif_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->sidobe_wp_notif, plugin_dir_url( __FILE__ ) . 'js/sidobe-wp-notif-admin.js', array( 'jquery' ), $this->version, false );
        wp_localize_script( $this->sidobe_wp_notif , 'sidobe_ajax_obj', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('sidobe_ajax_nonce')
        ));

	}

    /**
     * Helper for generate menu title on browser
     *
     * @param   string  $menu
     */
    private function get_menu_title($menu) {
        return $menu . ' - ' . $this->menu_title;
    }

    /**
     * Helper for generate menu url
     *
     * @param   string  $menu | nullable
     */
    private function get_menu_url($menu = null) {
        switch ($menu) {
            case 'options':
                return $this->page_url . '-options';
                break;

            default:
                return $this->page_url;
                break;
        }
    }

    /**
     * This function for get list options event WooCommerce
     */
    private function get_template_contents() {
        $templates = [
            [
                'title' => 'Order Pending',
                'code' => 'WC_ORDER_PENDING'
            ],
            [
                'title' => 'Order Processing',
                'code' => 'WC_ORDER_PROCESSING'
            ],
            [
                'title' => 'Order On Hold',
                'code' => 'WC_ORDER_ON_HOLD'
            ],
            [
                'title' => 'Order Completed',
                'code' => 'WC_ORDER_COMPLETED'
            ],
            [
                'title' => 'Order Canceled',
                'code' => 'WC_ORDER_CANCELED'
            ],
            [
                'title' => 'Order Refunded',
                'code' => 'WC_ORDER_REFUNDED'
            ],
            [
                'title' => 'Order Failed',
                'code' => 'WC_ORDER_FAILED'
            ]
        ];

        return $templates;
    }

    /**
     * Callback for main menu
     */
    function callback_menu_main_view() {
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $req_edit_template_code = isset($_GET['template_code']) ? sanitize_text_field(wp_unslash($_GET['template_code'])) : '';
        $template_contents = $this->get_template_contents();

        if (!empty($req_edit_template_code)) {
            $current_content = array_filter($template_contents, function($val) use ($req_edit_template_code) {
                return $val['code'] == $req_edit_template_code;
            });
            $current_content = array_shift($current_content);
            $current_content_db = $this->sidobe_db->get_content($req_edit_template_code);

            include_once plugin_dir_path( __FILE__ ) . 'class-sidobe-wp-notif-admin-shortcode.php';
            $shortcode = new Sidobe_Wp_Notif_Admin_Shortcode( $this->sidobe_wp_notif, $this->version );
            $wc_shortcodes = $shortcode->get_wc_shortcodes();

            if ( is_file( plugin_dir_path( __FILE__ ) . 'partials/page_edit_template.php' ) ) {
                include_once plugin_dir_path( __FILE__ ) . 'partials/page_edit_template.php';
            }
        }else{
            $sidobe_db = $this->sidobe_db;
            if ( is_file( plugin_dir_path( __FILE__ ) . 'partials/menu_main.php' ) ) {
                include_once plugin_dir_path( __FILE__ ) . 'partials/menu_main.php';
            }
        }
    }

    /**
     * Register menu on sidebar admin
     */
    public function register_menu_page() {
        add_menu_page(
            'Sidobe WP Notif',
            $this->menu_title,
            'manage_options',
            $this->get_menu_url(),
            array($this, 'callback_menu_main_view'),
            'dashicons-whatsapp',
            null
        );
    }

    /**
     * Register submenu main or override default name from add_menu_page
     */
    public function register_submenu_main_page() {
        add_submenu_page(
            $this->page_url,
            $this->get_menu_title('General'),
            'General',
            'manage_options',
            $this->get_menu_url(),
            array($this, "callback_menu_main_view"),
            null
        );
    }

    /**
     * Callback for submenu Options
     */
    function callback_submenu_options_view() {
        if ( is_file( plugin_dir_path( __FILE__ ) . 'partials/menu_options.php' ) ) {
            include_once plugin_dir_path( __FILE__ ) . 'partials/menu_options.php';
        }
    }

    /**
     * Register submenu options page
     */
    public function register_submenu_options_page() {
        add_submenu_page(
            $this->page_url,
            $this->get_menu_title('Options'),
            'Options',
            'manage_options',
            $this->get_menu_url('options'),
            array($this, 'callback_submenu_options_view')
        );
    }

    /**
     * Function for register field setting options to store secret key.
     */
    public function form_options_init() {
        // Register form input, ID this form is `sidobe_wp_notif_form_options` and `sidobe_wp_notif_options` as key on database
        register_setting( 'sidobe_wp_notif_form_options', 'sidobe_wp_notif_options' );

        // Register a new section or block
        // add_settings_section( $id:string, $title:string, $callback:callable, $page:string, $args:array )
        add_settings_section(
            'sidobe_wp_notif_section_credential',
            __( 'Configuration Credential', 'sidobe-notification' ),
            array($this, 'sidobe_wp_notif_section_credential_callback'),
            $this->get_menu_url('options')
        );

        // Register a new field in the "sidobe_wp_notif_section_credential" section, inside the "options" page.
        // add_settings_field( $id:string, $title:string, $callback:callable, $page:string, $section:string, $args:array )
        add_settings_field(
            'sidobe_wp_notif_field_secret_key', // Field or Key Name value inside sidobe_wp_notif_options on db
            __( 'Secret Key', 'sidobe-notification' ), // Label name input
            array($this, 'sidobe_wp_notif_field_secret_key_cb'),
            $this->get_menu_url('options'),
            'sidobe_wp_notif_section_credential', // This field in section / block credentials
            array(
                'label_for'         => 'sidobe_wp_notif_field_secret_key',
                'class'             => 'sidobe_wp_notif_row',
                'sidobe_wp_notif_custom_data' => 'custom',
            )
        );
    }

    /**
     * Callback section for form options or menu options
     */
    public function sidobe_wp_notif_section_credential_callback($args) {
        ?>
        <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Please insert your secret key from console Sidobe, if dont have please register it from sidobe.com', 'sidobe-notification' ); ?></p>
        <?php
    }

    /**
     * Callback for form options or menu options secret key
     */
    public function sidobe_wp_notif_field_secret_key_cb( $args ) {
        // Get the value of the setting we've registered with register_setting()
        $options = get_option( 'sidobe_wp_notif_options' );
        $options_value = !empty($options) ? $options[ $args['label_for'] ] : null;

        ?>
        <input
            type="text"
            id="<?php echo esc_attr( $args['label_for'] ); ?>"
            data-custom="<?php echo esc_attr( $args['sidobe_wp_notif_custom_data'] ); ?>"
            name="sidobe_wp_notif_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
            value="<?php echo esc_attr( $options_value )  ?>"
            style="width: 50%"
        >
        <p class="description">
            Get Secret Key from <b>Developer Tools</b> -> <b>Credential</b> in <a href="https://console.sidobe.com">Console Sidobe</a>.
        </p>
        <?php
    }

    /**
     * Function for register edit template notification
     */
    public function register_handle_form_template(){
        include_once plugin_dir_path( __FILE__ ) . 'class-sidobe-wp-notif-admin-form-template.php';

        $form_template = new Sidobe_Wp_Notif_Admin_Form_Template( $this->sidobe_wp_notif, $this->version );
        $form_template->handle_submit_edit_template();
    }

    /**
     * Function to general notification admin area
     */
    public function sidobe_wp_notif_admin_notices() {
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        if (isset($_GET['sidobe_wp_notif_status']) && $_GET['sidobe_wp_notif_status'] === 'success') {
            ?>
            <div class="notice notice-success is-dismissible">
                <p><?php esc_html_e('Options saved successfully.', 'sidobe-notification'); ?></p>
            </div>
            <?php
        }
    }

    /**
     * Function for register ajax update status template
     */
    public function register_handle_ajax_status_template(){
        include_once plugin_dir_path( __FILE__ ) . 'class-sidobe-wp-notif-admin-form-template.php';

        $form_template = new Sidobe_Wp_Notif_Admin_Form_Template( $this->sidobe_wp_notif, $this->version );
        $form_template->handle_ajax_status_template();
    }

    /**
     * Function for register sub feature register WooCommerce Hooks
     */
    public function register_wc_hooks(){
        include_once plugin_dir_path( __FILE__ ) . 'class-sidobe-wp-notif-admin-wc-hook.php';

        $wc = new Sidobe_Wp_Notif_Admin_Wc_Hook( $this->sidobe_wp_notif, $this->version, $this->loader, $this->sidobe_db );
        $wc->register_hooks();
    }
}
