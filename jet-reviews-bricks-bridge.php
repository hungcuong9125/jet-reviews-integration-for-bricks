<?php
/**
 * Plugin Name: JetReviews x Bricks Bridge
 * Plugin URI:  https://crocoblock.com/plugins/jetreviews/
 * Description: Adds Bricks Builder elements to render JetReviews widgets (without modifying JetReviews).
 * Version:     0.1.3
 * Author:      toiuuwp
 * License:     GPL-2.0+
 * Text Domain: jet-reviews-bricks-bridge
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class JetReviews_Bricks_Bridge {

	const VERSION = '0.1.3';
	const OPTION_ENABLED = 'jrbbr_enabled';
	const SLUG    = 'jetreviews-bricks-bridge';

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
		$enabled = get_option( self::OPTION_ENABLED, '1' );
		return ( '1' === (string) $enabled || 1 === $enabled || true === $enabled );
	}

	public function register_i18n( $i18n ) {
		$i18n['jetreviews'] = esc_html__( 'JetReviews', 'jet-reviews-bricks-bridge' );
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

		if ( isset( \Bricks\Elements::$elements['jetreviews-reviews-listing'] ) ) {
			$this->runtime['element_registered'] = true;
		}
	}

	public function register_admin_page() {
		add_submenu_page(
			'jet-reviews',
			esc_html__( 'Bricks Bridge', 'jet-reviews-bricks-bridge' ),
			esc_html__( 'Bricks Bridge', 'jet-reviews-bricks-bridge' ),
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
			echo esc_html__( 'JetReviews Bridge: Bricks + JetReviews detected but the Bricks element is not registered yet on this request. Open JetReviews → Bricks Bridge to see details.', 'jet-reviews-bricks-bridge' );
			echo '</p></div>';
		}
	}

	public function render_admin_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( isset( $_POST['jrbbr_save'] ) ) {
			check_admin_referer( 'jrbbr_save_settings' );
			$enabled = isset( $_POST['jrbbr_enabled'] ) ? '1' : '0';
			update_option( self::OPTION_ENABLED, $enabled );
			echo '<div class="notice notice-success"><p>' . esc_html__( 'Settings saved.', 'jet-reviews-bricks-bridge' ) . '</p></div>';
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
		echo '<h1>' . esc_html__( 'JetReviews → Bricks Bridge', 'jet-reviews-bricks-bridge' ) . '</h1>';

		echo '<form method="post" action="">';
		wp_nonce_field( 'jrbbr_save_settings' );
		echo '<table class="form-table" role="presentation">';
		echo '<tr>';
		echo '<th scope="row">' . esc_html__( 'Enable integration', 'jet-reviews-bricks-bridge' ) . '</th>';
		echo '<td>';
		echo '<label><input type="checkbox" name="jrbbr_enabled" value="1" ' . checked( $enabled, true, false ) . ' /> ';
		echo esc_html__( 'Register Bricks elements for JetReviews', 'jet-reviews-bricks-bridge' ) . '</label>';
		echo '<p class="description">' . esc_html__( 'Turn OFF to disable the bridge (elements won\'t be registered).', 'jet-reviews-bricks-bridge' ) . '</p>';
		echo '</td>';
		echo '</tr>';
		echo '</table>';
		echo '<p><button class="button button-primary" type="submit" name="jrbbr_save" value="1">' . esc_html__( 'Save Changes', 'jet-reviews-bricks-bridge' ) . '</button></p>';
		echo '</form>';

		echo '<hr />';
		echo '<h2>' . esc_html__( 'Debug status', 'jet-reviews-bricks-bridge' ) . '</h2>';
		echo '<table class="widefat striped" style="max-width: 920px;">';
		echo '<tbody>';
		echo '<tr><td><strong>' . esc_html__( 'Bridge version', 'jet-reviews-bricks-bridge' ) . '</strong></td><td>' . esc_html( self::VERSION ) . '</td></tr>';
		echo '<tr><td><strong>' . esc_html__( 'Enabled', 'jet-reviews-bricks-bridge' ) . '</strong></td><td>' . ( $enabled ? '✅' : '❌' ) . '</td></tr>';
		echo '<tr><td><strong>' . esc_html__( 'Bricks detected', 'jet-reviews-bricks-bridge' ) . '</strong></td><td>' . ( $has_bricks ? '✅' : '❌' ) . ' <code>' . esc_html( $bricks_version ) . '</code></td></tr>';
		echo '<tr><td><strong>' . esc_html__( 'JetReviews detected', 'jet-reviews-bricks-bridge' ) . '</strong></td><td>' . ( $has_jetreviews ? '✅' : '❌' ) . ' <code>' . esc_html( $jetreviews_version ) . '</code></td></tr>';
		echo '<tr><td><strong>' . esc_html__( 'Element registered', 'jet-reviews-bricks-bridge' ) . '</strong></td><td>' . ( $element_registered ? '✅' : '❌' ) . '</td></tr>';
		echo '</tbody>';
		echo '</table>';

		echo '<hr />';
		echo '<h2>' . esc_html__( 'Support', 'jet-reviews-bricks-bridge' ) . '</h2>';
		echo '<p><strong>' . esc_html__( 'Author:', 'jet-reviews-bricks-bridge' ) . '</strong> toiuuwp</p>';
		echo '<ul style="list-style: disc; padding-left: 22px;">';
		echo '<li><strong>Web:</strong> <a href="https://toiuuwp.com" target="_blank" rel="noopener">toiuuwp.com</a></li>';
		echo '</ul>';

		echo '</div>';
	}


	/** Convenience getter for debug. */
	public function get_runtime() {
		return $this->runtime;
	}
}

JetReviews_Bricks_Bridge::instance();
