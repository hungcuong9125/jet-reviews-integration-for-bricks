<?php
namespace JetReviews_Bricks_Bridge\Elements;

use Bricks\Element;
use Bricks\Helpers;

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

	public function set_control_groups() {
		$this->control_groups['settings'] = [
			'title' => esc_html__( 'Settings', 'jet-reviews-bricks-bridge' ),
			'tab'   => 'content',
		];

		$this->control_groups['icons'] = [
			'title' => esc_html__( 'Icons', 'jet-reviews-bricks-bridge' ),
			'tab'   => 'content',
		];
	}

	public function set_controls() {
		$source_options = [];
		if ( function_exists( 'jet_reviews' ) && isset( jet_reviews()->reviews_manager ) && isset( jet_reviews()->reviews_manager->sources ) ) {
			$source_options = jet_reviews()->reviews_manager->sources->get_registered_source_list();
		}

		$this->controls['source'] = [
			'tab'        => 'content',
			'group'      => 'settings',
			'label'      => esc_html__( 'Source', 'jet-reviews-bricks-bridge' ),
			'type'       => 'select',
			'options'    => $source_options,
			'default'    => 'post',
			'searchable' => true,
			'rerender'   => true,
		];

		$this->controls['ratingLayout'] = [
			'tab'      => 'content',
			'group'    => 'settings',
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
			'group'    => 'settings',
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
			'group'    => 'settings',
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
			'group'    => 'settings',
			'label'    => esc_html__( 'Reviews per page', 'jet-reviews-bricks-bridge' ),
			'type'     => 'number',
			'min'      => 1,
			'max'      => 50,
			'default'  => 10,
			'rerender' => true,
		];

		$this->controls['reviewAuthorAvatarVisible'] = [
			'tab'      => 'content',
			'group'    => 'settings',
			'label'    => esc_html__( 'Show review author avatar', 'jet-reviews-bricks-bridge' ),
			'type'     => 'checkbox',
			'default'  => true,
			'rerender' => true,
		];

		$this->controls['reviewTitleVisible'] = [
			'tab'      => 'content',
			'group'    => 'settings',
			'label'    => esc_html__( 'Show review title', 'jet-reviews-bricks-bridge' ),
			'type'     => 'checkbox',
			'default'  => true,
			'rerender' => true,
		];

		$this->controls['reviewTitleInputVisible'] = [
			'tab'      => 'content',
			'group'    => 'settings',
			'label'    => esc_html__( 'Show review title input', 'jet-reviews-bricks-bridge' ),
			'type'     => 'checkbox',
			'default'  => true,
			'rerender' => true,
		];

		$this->controls['reviewContentInputVisible'] = [
			'tab'      => 'content',
			'group'    => 'settings',
			'label'    => esc_html__( 'Show review content input', 'jet-reviews-bricks-bridge' ),
			'type'     => 'checkbox',
			'default'  => true,
			'rerender' => true,
		];

		$this->controls['commentAuthorAvatarVisible'] = [
			'tab'      => 'content',
			'group'    => 'settings',
			'label'    => esc_html__( 'Show comment author avatar', 'jet-reviews-bricks-bridge' ),
			'type'     => 'checkbox',
			'default'  => true,
			'rerender' => true,
		];

		$this->controls['disableBuilderRender'] = [
			'tab'         => 'content',
			'group'       => 'settings',
			'label'       => esc_html__( "Don't render inside builder", 'jet-reviews-bricks-bridge' ),
			'type'        => 'checkbox',
			'default'     => false,
			'description' => esc_html__( 'Useful if the Vue widget slows down the builder. Frontend will still render.', 'jet-reviews-bricks-bridge' ),
			'rerender'    => true,
		];

		$this->controls['emptyStarIcon'] = [
			'tab'      => 'content',
			'group'    => 'icons',
			'label'    => esc_html__( 'Empty Star Icon', 'jet-reviews-bricks-bridge' ),
			'type'     => 'icon',
			'default'  => [
				'library' => 'fontawesome',
				'icon'    => 'far fa-star',
			],
			'rerender' => true,
		];

		$this->controls['filledStarIcon'] = [
			'tab'      => 'content',
			'group'    => 'icons',
			'label'    => esc_html__( 'Filled Star Icon', 'jet-reviews-bricks-bridge' ),
			'type'     => 'icon',
			'default'  => [
				'library' => 'fontawesome',
				'icon'    => 'fas fa-star',
			],
			'rerender' => true,
		];

		$this->controls['newReviewButtonIcon'] = [
			'tab'      => 'content',
			'group'    => 'icons',
			'label'    => esc_html__( 'New Review Button Icon', 'jet-reviews-bricks-bridge' ),
			'type'     => 'icon',
			'default'  => [
				'library' => 'fontawesome',
				'icon'    => 'fas fa-pen',
			],
			'rerender' => true,
		];

		$this->controls['showCommentsButtonIcon'] = [
			'tab'      => 'content',
			'group'    => 'icons',
			'label'    => esc_html__( 'Show Comments Button Icon', 'jet-reviews-bricks-bridge' ),
			'type'     => 'icon',
			'default'  => [
				'library' => 'fontawesome',
				'icon'    => 'fas fa-comment',
			],
			'rerender' => true,
		];

		$this->controls['newCommentButtonIcon'] = [
			'tab'      => 'content',
			'group'    => 'icons',
			'label'    => esc_html__( 'New Comment Button Icon', 'jet-reviews-bricks-bridge' ),
			'type'     => 'icon',
			'default'  => [
				'library' => 'fontawesome',
				'icon'    => 'fas fa-pen',
			],
			'rerender' => true,
		];

		$this->controls['pinnedIcon'] = [
			'tab'      => 'content',
			'group'    => 'icons',
			'label'    => esc_html__( 'Pinned Icon', 'jet-reviews-bricks-bridge' ),
			'type'     => 'icon',
			'default'  => [
				'library' => 'fontawesome',
				'icon'    => 'fas fa-thumbtack',
			],
			'rerender' => true,
		];

		$this->controls['reviewEmptyLikeIcon'] = [
			'tab'      => 'content',
			'group'    => 'icons',
			'label'    => esc_html__( 'Empty Like Icon', 'jet-reviews-bricks-bridge' ),
			'type'     => 'icon',
			'default'  => [
				'library' => 'fontawesome',
				'icon'    => 'far fa-thumbs-up',
			],
			'rerender' => true,
		];

		$this->controls['reviewFilledLikeIcon'] = [
			'tab'      => 'content',
			'group'    => 'icons',
			'label'    => esc_html__( 'Filled Like Icon', 'jet-reviews-bricks-bridge' ),
			'type'     => 'icon',
			'default'  => [
				'library' => 'fontawesome',
				'icon'    => 'fas fa-thumbs-up',
			],
			'rerender' => true,
		];

		$this->controls['reviewEmptyDislikeIcon'] = [
			'tab'      => 'content',
			'group'    => 'icons',
			'label'    => esc_html__( 'Empty Dislike Icon', 'jet-reviews-bricks-bridge' ),
			'type'     => 'icon',
			'default'  => [
				'library' => 'fontawesome',
				'icon'    => 'far fa-thumbs-down',
			],
			'rerender' => true,
		];

		$this->controls['reviewFilledDislikeIcon'] = [
			'tab'      => 'content',
			'group'    => 'icons',
			'label'    => esc_html__( 'Filled Dislike Icon', 'jet-reviews-bricks-bridge' ),
			'type'     => 'icon',
			'default'  => [
				'library' => 'fontawesome',
				'icon'    => 'fas fa-thumbs-down',
			],
			'rerender' => true,
		];

		$this->controls['replyButtonIcon'] = [
			'tab'      => 'content',
			'group'    => 'icons',
			'label'    => esc_html__( 'Reply Button Icon', 'jet-reviews-bricks-bridge' ),
			'type'     => 'icon',
			'default'  => [
				'library' => 'fontawesome',
				'icon'    => 'fas fa-reply',
			],
			'rerender' => true,
		];

		$this->controls['prevIcon'] = [
			'tab'      => 'content',
			'group'    => 'icons',
			'label'    => esc_html__( 'Prev Icon', 'jet-reviews-bricks-bridge' ),
			'type'     => 'icon',
			'default'  => [
				'library' => 'fontawesome',
				'icon'    => 'fas fa-chevron-left',
			],
			'rerender' => true,
		];

		$this->controls['nextIcon'] = [
			'tab'      => 'content',
			'group'    => 'icons',
			'label'    => esc_html__( 'Next Icon', 'jet-reviews-bricks-bridge' ),
			'type'     => 'icon',
			'default'  => [
				'library' => 'fontawesome',
				'icon'    => 'fas fa-chevron-right',
			],
			'rerender' => true,
		];
	}

	/**
	 * Convert Bricks checkbox value to proper boolean.
	 *
	 * Bricks checkbox behavior: when CHECKED, the key exists in
	 * $this->settings (truthy). When UNCHECKED, the key is completely
	 * ABSENT from $this->settings.
	 *
	 * @param string $key Settings key.
	 *
	 * @return bool
	 */
	private function get_bool_setting( $key ) {
		return ! empty( $this->settings[ $key ] );
	}

	/**
	 * Render a Bricks icon control value to an HTML string.
	 *
	 * Uses Bricks Helpers::render_control_icon() (which echoes), buffered
	 * into a string suitable for passing to Review_Listing_Render.
	 *
	 * @param string      $key     Settings key.
	 * @param string|null $default Fallback HTML if icon is not set.
	 *
	 * @return string|null Icon HTML or default.
	 */
	private function get_icon_html( $key, $default = null ) {
		if ( empty( $this->settings[ $key ] ) ) {
			return $default;
		}

		ob_start();
		Helpers::render_control_icon( $this->settings[ $key ] );
		$html = ob_get_clean();

		return ! empty( $html ) ? $html : $default;
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

		$prev_icon_html = $this->get_icon_html( 'prevIcon' );
		$next_icon_html = $this->get_icon_html( 'nextIcon' );

		$icons = [];

		$icon_keys = [
			'emptyStarIcon',
			'filledStarIcon',
			'newReviewButtonIcon',
			'showCommentsButtonIcon',
			'newCommentButtonIcon',
			'pinnedIcon',
			'reviewEmptyLikeIcon',
			'reviewFilledLikeIcon',
			'reviewEmptyDislikeIcon',
			'reviewFilledDislikeIcon',
			'replyButtonIcon',
		];

		foreach ( $icon_keys as $icon_key ) {
			$html = $this->get_icon_html( $icon_key );
			if ( $html ) {
				$icons[ $icon_key ] = $html;
			}
		}

		if ( $prev_icon_html ) {
			$icons['prevIcon'] = ! is_rtl() ? $prev_icon_html : $next_icon_html;
		}
		if ( $next_icon_html ) {
			$icons['nextIcon'] = ! is_rtl() ? $next_icon_html : $prev_icon_html;
		}

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
			'icons'                      => $icons,
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
