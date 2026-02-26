<?php
/**
 * Plugin Name: JetReviews Integration For Bricks
 * Plugin URI:  https://crocoblock.com/plugins/jetreviews/
 * Description: Adds Bricks Builder elements to render JetReviews widgets (without modifying JetReviews).
 * Version:     0.1.6.2
 * Author:      Toiuuwp
 * Author URI:  https://toiuuwp.com
 * Requires at least: 5.0
 * Requires PHP: 7.0
 * License:     GPL-2.0+
 * Text Domain: jetreviews-integration-bricks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class JetReviews_Integration_Bricks {

	const VERSION = '0.1.6.2';
	const OPTION_ENABLED = 'jrib_enabled';
	const OPTION_ENABLED_LEGACY = 'jrbbr_enabled';
	const SLUG    = 'jetreviews-integration-bricks';

	private static $instance = null;

	/** @var array<string,mixed> */
	private $runtime = [
		'bootstrapped' => false,
		'has_bricks'   => false,
		'has_jetreviews' => false,
		'element_registered' => false,
		'errors' => [],
	];

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		add_action( 'init', [ $this, 'bootstrap' ], 1 );

		add_action( 'admin_menu', [ $this, 'register_admin_page' ], 99 );
		add_action( 'admin_notices', [ $this, 'maybe_admin_notice' ] );
	}

	public function bootstrap() {
		$this->runtime['has_bricks'] = defined( 'BRICKS_VERSION' ) && class_exists( '\Bricks\Elements' );

		$this->runtime['has_jetreviews'] = function_exists( 'jet_reviews' );

		if ( ! $this->runtime['has_bricks'] || ! $this->runtime['has_jetreviews'] ) {
			return;
		}

		if ( ! $this->is_enabled() ) {
			return;
		}

		$this->runtime['bootstrapped'] = true;

		add_action( 'init', [ $this, 'register_elements' ], 11 );

		add_filter( 'bricks/builder/i18n', [ $this, 'register_i18n' ] );

		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_builder_assets' ] );
	}

	public function is_enabled() {
		$enabled = get_option( self::OPTION_ENABLED, null );
		if ( null === $enabled ) {
			// Backward compatibility: previous versions stored the flag under a different option key.
			$enabled = get_option( self::OPTION_ENABLED_LEGACY, '1' );
		}
		return ( '1' === (string) $enabled || 1 === $enabled || true === $enabled );
	}

	public function register_i18n( $i18n ) {
		$i18n['jetreviews'] = esc_html__( 'JetReviews', 'jetreviews-integration-bricks' );
		return $i18n;
	}

	public function enqueue_builder_assets() {
		if ( function_exists( 'bricks_is_builder' ) && bricks_is_builder() && function_exists( 'jet_reviews' ) ) {
			wp_enqueue_style(
				'jet-reviews-icons-for-bricks',
				jet_reviews()->plugin_url( 'assets/lib/jetreviews-icons/icons.css' ),
				[],
				jet_reviews()->get_version() . '-icons'
			);
		}
	}

	public function register_elements() {
		if ( ! class_exists( '\Bricks\Elements' ) ) {
			$this->runtime['errors'][] = 'Bricks\\Elements not available when registering elements.';
			return;
		}

		$base = plugin_dir_path( __FILE__ ) . 'includes/bricks/elements/';

		\Bricks\Elements::register_element( $base . 'reviews-listing.php' );
		\Bricks\Elements::register_element( $base . 'static-review.php' );

		if (
			isset( \Bricks\Elements::$elements['jetreviews-reviews-listing'] )
			|| isset( \Bricks\Elements::$elements['jetreviews-static-review'] )
		) {
			$this->runtime['element_registered'] = true;
		}
	}

	public function register_admin_page() {
		add_submenu_page(
			'jet-reviews',
			esc_html__( 'Bricks Integration', 'jetreviews-integration-bricks' ),
			esc_html__( 'Bricks Integration', 'jetreviews-integration-bricks' ),
			'manage_options',
			self::SLUG,
			[ $this, 'render_admin_page' ],
			99
		);
	}

	public function maybe_admin_notice() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
		if ( ! $screen || $screen->id !== 'plugins' ) {
			return;
		}

		if ( $this->runtime['has_bricks'] && $this->runtime['has_jetreviews'] && $this->is_enabled() && ! $this->runtime['element_registered'] ) {
			echo '<div class="notice notice-warning"><p>';
			echo esc_html__( 'JetReviews Integration For Bricks: Bricks + JetReviews detected but the Bricks element is not registered yet on this request. Open JetReviews → Bricks Integration to see details.', 'jetreviews-integration-bricks' );
			echo '</p></div>';
		}
	}

	public function render_admin_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( isset( $_POST['jrib_save'] ) ) {
			check_admin_referer( 'jrib_save_settings' );
			$enabled = isset( $_POST['jrib_enabled'] ) ? '1' : '0';
			update_option( self::OPTION_ENABLED, $enabled );
			echo '<div class="notice notice-success"><p>' . esc_html__( 'Settings saved.', 'jetreviews-integration-bricks' ) . '</p></div>';
		}

		$enabled          = $this->is_enabled();
		$bricks_version   = defined( 'BRICKS_VERSION' ) ? BRICKS_VERSION : '—';
		$jetreviews_version = function_exists( 'jet_reviews' ) ? jet_reviews()->get_version() : '—';

		$has_bricks    = defined( 'BRICKS_VERSION' ) && class_exists( '\\Bricks\\Elements' );
		$has_jetreviews = function_exists( 'jet_reviews' );

		$element_registered = false;
		if ( $has_bricks && class_exists( '\\Bricks\\Elements' ) && isset( \Bricks\Elements::$elements['jetreviews-reviews-listing'] ) ) {
			$element_registered = true;
		}

		echo '<div class="wrap">';
		echo '<h1>' . esc_html__( 'JetReviews → Bricks Integration', 'jetreviews-integration-bricks' ) . '</h1>';

		echo '<form method="post" action="">';
		wp_nonce_field( 'jrib_save_settings' );
		echo '<table class="form-table" role="presentation">';
		echo '<tr>';
		echo '<th scope="row">' . esc_html__( 'Enable integration', 'jetreviews-integration-bricks' ) . '</th>';
		echo '<td>';
		echo '<label><input type="checkbox" name="jrib_enabled" value="1" ' . checked( $enabled, true, false ) . ' /> ';
		echo esc_html__( 'Register Bricks elements for JetReviews', 'jetreviews-integration-bricks' ) . '</label>';
		echo '<p class="description">' . esc_html__( 'Turn OFF to disable the bridge (elements won\'t be registered).', 'jetreviews-integration-bricks' ) . '</p>';
		echo '</td>';
		echo '</tr>';
		echo '</table>';
		echo '<p><button class="button button-primary" type="submit" name="jrib_save" value="1">' . esc_html__( 'Save Changes', 'jetreviews-integration-bricks' ) . '</button></p>';
		echo '</form>';

		echo '<hr />';
		echo '<h2>' . esc_html__( 'Debug status', 'jetreviews-integration-bricks' ) . '</h2>';
		echo '<table class="widefat striped" style="max-width: 920px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">';
		echo '<tbody>';
		echo '<tr><td><strong>' . esc_html__( 'JetReviews Integration For Bricks', 'jetreviews-integration-bricks' ) . '</strong></td><td>' . esc_html( self::VERSION ) . '</td></tr>';
		echo '<tr><td><strong>' . esc_html__( 'Enabled', 'jetreviews-integration-bricks' ) . '</strong></td><td>' . ( $enabled ? '✅' : '❌' ) . '</td></tr>';
		echo '<tr><td><strong>' . esc_html__( 'Bricks detected', 'jetreviews-integration-bricks' ) . '</strong></td><td>' . ( $has_bricks ? '✅' : '❌' ) . ' <code>' . esc_html( $bricks_version ) . '</code></td></tr>';
		echo '<tr><td><strong>' . esc_html__( 'JetReviews detected', 'jetreviews-integration-bricks' ) . '</strong></td><td>' . ( $has_jetreviews ? '✅' : '❌' ) . ' <code>' . esc_html( $jetreviews_version ) . '</code></td></tr>';
		echo '<tr><td><strong>' . esc_html__( 'Element registered', 'jetreviews-integration-bricks' ) . '</strong></td><td>' . ( $element_registered ? '✅' : '❌' ) . '</td></tr>';
		echo '</tbody>';
		echo '</table>';

		echo '<div style="margin-top: 30px; max-width: 920px;">';
		echo '<div style="background: #fff; border: 1px solid #ccd0d4; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); padding: 25px;">';
		echo '<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">';

		// Column 1: Contact
		echo '<div>';
		echo '<h2 style="margin-top: 0; margin-bottom: 20px; font-size: 20px;">' . esc_html__( 'Support & Community', 'jetreviews-integration-bricks' ) . '</h2>';
		echo '<h3 style="margin-top: 0; font-size: 16px;">' . esc_html__( 'Contact Author', 'jetreviews-integration-bricks' ) . '</h3>';
		echo '<p style="margin-bottom: 15px;"><strong>' . esc_html__( 'Author:', 'jetreviews-integration-bricks' ) . '</strong> Toiuuwp</p>';

		echo '<div style="display: flex; flex-direction: column; gap: 10px;">';
		echo '<a href="https://toiuuwp.com" target="_blank" rel="noopener" style="text-decoration: none; color: #2271b1; display: flex; align-items: center; gap: 8px;"><span class="dashicons dashicons-admin-site"></span> toiuuwp.com</a>';
		echo '<a href="https://www.facebook.com/hungcuong2591" target="_blank" rel="noopener" style="text-decoration: none; color: #2271b1; display: flex; align-items: center; gap: 8px;"><span class="dashicons dashicons-facebook"></span> Facebook</a>';
		echo '<a href="#" target="_blank" rel="noopener" style="text-decoration: none; color: #2271b1; display: flex; align-items: center; gap: 8px;"><span class="dashicons dashicons-groups"></span> Discord: hungcuong259</a>';
		echo '</div>';
		echo '</div>';

		// Column 2: Donation
		echo '<div style="background: #fdfaf3; border: 1px solid #f9e3b4; border-radius: 6px; padding: 20px;">';
		echo '<h3 style="margin-top: 0; font-size: 16px; color: #856404;">' . esc_html__( 'Support My Work', 'jetreviews-integration-bricks' ) . '</h3>';
		echo '<p style="margin-bottom: 18px; line-height: 1.5;">' . esc_html__( 'If you like this plugin and find it useful, please consider supporting its development. Your contribution helps keep this project alive and updated!', 'jetreviews-integration-bricks' ) . '</p>';

		echo '<div style="display: flex; align-items: center; flex-wrap: wrap; gap: 15px;">';
		echo '<script type="text/javascript" src="https://cdnjs.buymeacoffee.com/1.0.0/button.prod.min.js" data-name="bmc-button" data-slug="hungcuong259" data-color="#FFDD00" data-emoji="☕"  data-font="Cookie" data-text="Buy me a coffee" data-outline-color="#000000" data-font-color="#000000" data-coffee-color="#ffffff" ></script>';
		echo '<a href="https://buymeacoffee.com/hungcuong259" target="_blank" rel="noopener" style="text-decoration: none; font-weight: bold; color: #000; border-bottom: 2px solid #FFDD00; padding: 2px 0;">' . esc_html__( 'Buy me a coffee', 'jetreviews-integration-bricks' ) . '</a>';
		echo '</div>';
		echo '</div>';

		echo '</div>'; // End grid
		echo '</div>'; // End card
		echo '</div>'; // End wrapper

		echo '</div>';
	}

	/** Convenience getter for debug. */
	public function get_runtime() {
		return $this->runtime;
	}
}

JetReviews_Integration_Bricks::instance();
