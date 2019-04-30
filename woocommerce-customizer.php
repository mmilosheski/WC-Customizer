<?php
/*
Plugin Name: WooCommerce Customizer
Plugin URI: https://linkedin.com/in/mmilosheski/
Description: A set of tweaks and addons for woocommerce tweaking
Version: 1.0.0
Author: Mile Milosheski
Author URI: http://linkedin.com/in/mmilosheski/
*/

if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

if ( class_exists( 'WCCustomizer' ) ) {

	register_activation_hook( __FILE__, [ 'WCCustomizer', 'activate' ] );
	register_deactivation_hook( __FILE__, [ 'WCCustomizer', 'deactivate' ] );

	new WCCustomizer();
}

class WCCustomizer {

	public function __construct() {

		add_action( 'admin_menu', [ $this, 'admin_page' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'load_admin_assets' ] );
		add_filter( 'woocommerce_sale_flash', [ $this, 'change_sale_text' ], 10, 3 );

		if ( is_admin() === true ) {
			add_action( 'wp_ajax_update_options', [ $this, 'update_options' ] );
			add_action( 'wp_ajax_reset_options', [ $this, 'activate' ] );
		}
	}

	/**
	 * Registering admin page, will register submenu page to wocommerce for the plugin settings section
	 *
	 * @param void
	 *
	 * @return void
	 *
	 * @author Mile B. Milosheski
	 */
	public function admin_page() {
		if ( is_admin() === true ) {
			add_submenu_page( 'woocommerce', 'WC Customizer', 'WC Customizer', 'manage_options', 'wc-customizer', [
				$this,
				'render_admin_page'
			] );
		}
	}

	/**
	 * Render admin page, will include the admin settings page of this plugin with all options listed for editing
	 *
	 * @param void
	 *
	 * @return ob_content html partial
	 *
	 * @author Mile B. Milosheski
	 */
	public function render_admin_page() {
		if ( is_admin() === true ) {
			include( 'templates/admin/admin.php' );
		}
	}

	/**
	 * Loading admin assets css and js
	 *
	 * @param string $hook. Optional
	 *
	 * @return void
	 *
	 * @author Mile B. Milosheski
	 */
	public function load_admin_assets( $hook ) {
		// Load only on ?page=mypluginname
		if ( 'woocommerce_page_wc-customizer' !== $hook ) {
			return;
		}

		wp_enqueue_style( 'wc-customizer-admin-css', plugins_url( 'assets/css/wc-customizer-admin.css', __FILE__ ) );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-form' );
		wp_enqueue_script( 'wc-customizer-admin-js', plugins_url( 'assets/js/wc-customizer-admin.js', __FILE__ ), [
			'jquery',
			'jquery-form'
		] );
		wp_enqueue_script( 'notifyjs', plugins_url( 'assets/js/notify.min.js', __FILE__ ) );
	}

	/**
	 * Update ajax callback, will save all the settings as separate option to the db!
	 *
	 * @param string $content. Required
	 *
	 * @return string $content
	 *
	 * @author Mile B. Milosheski
	 */
	public function change_sale_text( $content ) {
		$content = '<span class="onsale">' . __( get_option( 'wc-customizer-sale-text', 'On Sale' ), 'woocommerce' ) . '</span>';

		return $content;
	}

	/**
	 * Update ajax callback, will save all the settings as separate option to the db!
	 *
	 * @param void
	 *
	 * @return void
	 *
	 * @author Mile B. Milosheski
	 */
	public function update_options() {

		check_ajax_referer( 'wc-customizer-s', 'rpnonce' );

		if ( isset( $_POST['wc-customizer-sale-text'] ) ) {
			update_option( 'wc-customizer-sale-text', $_POST['wc-customizer-sale-text'] );
		}

		wp_die();
	}

	/**
	 * Activation hook, will add all the default options needed to the DB
	 *
	 * @param void
	 *
	 * @return void
	 *
	 * @author Mile B. Milosheski
	 */
	public function activate() {

		$config['wc-customizer-sale-text'] = 'On Sale!!!';

		foreach ( $config as $key => $value ) {
			delete_option( $key );
			add_option( $key, $value );
		}
	}

	/**
	 * Deactivation hook, will erase all options added from the activation hook from the DB
	 *
	 * @param void
	 *
	 * @return void
	 *
	 * @author Mile B. Milosheski
	 */
	public function deactivate() {
		$config = [ 'wc-customizer-sale-text' ];
		foreach ( $config as $key ) {
			delete_option( $key );
		}
	}
}