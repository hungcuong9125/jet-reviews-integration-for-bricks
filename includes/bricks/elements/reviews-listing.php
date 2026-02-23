<?php
namespace JetReviews_Bricks_Bridge\Elements;

use Bricks\Element;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Bricks element: JetReviews Reviews Listing (Advanced).
 */
class Element_JetReviews_Reviews_Listing extends Element {
	public $category = 'jetreviews';
	public $name     = 'jetreviews-reviews-listing';
	public $icon     = 'ti-star';
	public $css_selector = '.jetreviews-reviews-listing';

	public function get_label() {
		return esc_html__( 'Reviews Listing (JetReviews)', 'jet-reviews-bricks-bridge' );
	}

	public function set_controls() {
		$source_options = [];
		if ( function_exists( 'jet_reviews' ) && isset( jet_reviews()->reviews_manager ) && isset( jet_reviews()->reviews_manager->sources ) ) {
			$source_options = jet_reviews()->reviews_manager->sources->get_registered_source_list();
		}

		$this->controls['source'] = [
			'tab'        => 'content',
			'label'      => esc_html__( 'Source', 'jet-reviews-bricks-bridge' ),
			'type'       => 'select',
			'options'    => $source_options,
			'default'    => 'post',
			'searchable' => true,
			'rerender'   => true,
		];

		$this->controls['ratingLayout'] = [
			'tab'      => 'content',
			'label'    => esc_html__( 'Rating layout', 'jet-reviews-bricks-bridge' ),
			'type'     => 'select',
			'options'  => [
				'stars-field'  => esc_html__( 'Stars', 'jet-reviews-bricks-bridge' ),
				'points-field' => esc_html__( 'Points', 'jet-reviews-bricks-bridge' ),
			],
			'default'  => 'stars-field',
			'rerender' => true,
		];

		$this->controls['ratingInputType'] = [
			'tab'      => 'content',
			'label'    => esc_html__( 'Rating input type', 'jet-reviews-bricks-bridge' ),
			'type'     => 'select',
			'options'  => [
				'slider-input' => esc_html__( 'Slider', 'jet-reviews-bricks-bridge' ),
				'stars-input'  => esc_html__( 'Stars', 'jet-reviews-bricks-bridge' ),
			],
			'default'  => 'slider-input',
			'rerender' => true,
		];

		$this->controls['reviewRatingType'] = [
			'tab'      => 'content',
			'label'    => esc_html__( 'Review rating type', 'jet-reviews-bricks-bridge' ),
			'type'     => 'select',
			'options'  => [
				'average' => esc_html__( 'Average', 'jet-reviews-bricks-bridge' ),
				'details' => esc_html__( 'Details', 'jet-reviews-bricks-bridge' ),
			],
			'default'  => 'average',
			'rerender' => true,
		];

		$this->controls['reviewsPerPage'] = [
			'tab'      => 'content',
			'label'    => esc_html__( 'Reviews per page', 'jet-reviews-bricks-bridge' ),
			'type'     => 'number',
			'min'      => 1,
			'max'      => 50,
			'default'  => 10,
			'rerender' => true,
		];

		$this->controls['reviewAuthorAvatarVisible'] = [
			'tab'      => 'content',
			'label'    => esc_html__( 'Show review author avatar', 'jet-reviews-bricks-bridge' ),
			'type'     => 'checkbox',
			'default'  => true,
			'rerender' => true,
		];

		$this->controls['reviewTitleVisible'] = [
			'tab'      => 'content',
			'label'    => esc_html__( 'Show review title', 'jet-reviews-bricks-bridge' ),
			'type'     => 'checkbox',
			'default'  => true,
			'rerender' => true,
		];

		$this->controls['reviewTitleInputVisible'] = [
			'tab'      => 'content',
			'label'    => esc_html__( 'Show review title input', 'jet-reviews-bricks-bridge' ),
			'type'     => 'checkbox',
			'default'  => true,
			'rerender' => true,
		];

		$this->controls['reviewContentInputVisible'] = [
			'tab'      => 'content',
			'label'    => esc_html__( 'Show review content input', 'jet-reviews-bricks-bridge' ),
			'type'     => 'checkbox',
			'default'  => true,
			'rerender' => true,
		];

		$this->controls['commentAuthorAvatarVisible'] = [
			'tab'      => 'content',
			'label'    => esc_html__( 'Show comment author avatar', 'jet-reviews-bricks-bridge' ),
			'type'     => 'checkbox',
			'default'  => true,
			'rerender' => true,
		];

		$this->controls['disableBuilderRender'] = [
			'tab'         => 'content',
			'label'       => esc_html__( "Don't render inside builder", 'jet-reviews-bricks-bridge' ),
			'type'        => 'checkbox',
			'default'     => false,
			'description' => esc_html__( 'Useful if the Vue widget slows down the builder. Frontend will still render.', 'jet-reviews-bricks-bridge' ),
			'rerender'    => true,
		];
	}

	/**
	 * Convert Bricks checkbox value to proper boolean.
	 *
	 * Bricks checkbox behavior: when CHECKED, the key exists in
	 * $this->settings (truthy). When UNCHECKED, the key is completely
	 * ABSENT from $this->settings — regardless of the 'default' value
	 * defined in set_controls(). Therefore:
	 *   - key exists   → user checked   → true
	 *   - key absent   → user unchecked → false
	 *
	 * @param string $key Settings key.
	 *
	 * @return bool
	 */
	private function get_bool_setting( $key ) {
		return ! empty( $this->settings[ $key ] );
	}

	public function render() {
		if ( ! function_exists( 'jet_reviews' ) ) {
			$this->render_element_placeholder( [ 'title' => esc_html__( 'JetReviews plugin is not active.', 'jet-reviews-bricks-bridge' ) ], 'warning' );
			return;
		}

		if ( ! class_exists( '\\Jet_Reviews\\Reviews\\Review_Listing_Render' ) ) {
			$this->render_element_placeholder( [ 'title' => esc_html__( 'JetReviews renderer class not found (plugin version mismatch).', 'jet-reviews-bricks-bridge' ) ], 'warning' );
			return;
		}

		$is_builder_context = ( function_exists( 'bricks_is_builder_call' ) && bricks_is_builder_call() )
			|| ( function_exists( 'bricks_is_builder_iframe' ) && bricks_is_builder_iframe() )
			|| ( function_exists( 'bricks_is_builder_main' ) && bricks_is_builder_main() );

		if ( $is_builder_context && ! empty( $this->settings['disableBuilderRender'] ) ) {
			$this->render_element_placeholder( [
				'title' => esc_html__( 'JetReviews: rendering disabled in builder.', 'jet-reviews-bricks-bridge' ),
				'text'  => esc_html__( 'Disable the "Don\'t render" option to preview, or check the frontend.', 'jet-reviews-bricks-bridge' ),
			] );
			return;
		}

		$source = ! empty( $this->settings['source'] ) ? $this->settings['source'] : 'post';

		$settings = [
			'source'                     => $source,
			'ratingLayout'               => $this->settings['ratingLayout'] ?? 'stars-field',
			'ratingInputType'            => $this->settings['ratingInputType'] ?? 'slider-input',
			'reviewRatingType'           => $this->settings['reviewRatingType'] ?? 'average',
			'reviewsPerPage'             => isset( $this->settings['reviewsPerPage'] ) ? intval( $this->settings['reviewsPerPage'] ) : 10,
			'reviewAuthorAvatarVisible'  => $this->get_bool_setting( 'reviewAuthorAvatarVisible' ),
			'reviewTitleVisible'         => $this->get_bool_setting( 'reviewTitleVisible' ),
			'reviewTitleInputVisible'    => $this->get_bool_setting( 'reviewTitleInputVisible' ),
			'reviewContentInputVisible'  => $this->get_bool_setting( 'reviewContentInputVisible' ),
			'commentAuthorAvatarVisible' => $this->get_bool_setting( 'commentAuthorAvatarVisible' ),
		];

		$html = '';

		try {
			$renderer = new \Jet_Reviews\Reviews\Review_Listing_Render( $settings );
			ob_start();
			$renderer->render();
			$html = ob_get_clean();
		} catch ( \Throwable $e ) {
			if ( function_exists( 'error_log' ) ) {
				error_log( '[JetReviews_Bricks_Bridge] ' . $e->getMessage() );
			}

			if ( current_user_can( 'manage_options' ) && $is_builder_context ) {
				$html = '<pre class="jetreviews-bricks-error" style="white-space:pre-wrap">' . esc_html( $e->getMessage() ) . '</pre>';
			}
		}

		if ( empty( $html ) ) {
			$this->render_element_placeholder( [ 'title' => esc_html__( 'JetReviews rendered empty output.', 'jet-reviews-bricks-bridge' ) ] );
			return;
		}

		echo '<div class="jetreviews-reviews-listing" ' . $this->render_attributes( '_root' ) . '>';
		echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '</div>';
	}
}
