<?php
namespace JetReviews_Integration_Bricks\Elements;

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
		return esc_html__( 'Reviews Listing', 'jetreviews-integration-bricks' );
	}

	public function set_control_groups() {
		$this->control_groups['settings'] = [
			'title' => esc_html__( 'Settings', 'jetreviews-integration-bricks' ),
			'tab'   => 'content',
		];

		$this->control_groups['icons'] = [
			'title' => esc_html__( 'Icons', 'jetreviews-integration-bricks' ),
			'tab'   => 'content',
		];

		$this->control_groups['labels'] = [
			'title' => esc_html__( 'Labels', 'jetreviews-integration-bricks' ),
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
			'label'      => esc_html__( 'Source', 'jetreviews-integration-bricks' ),
			'type'       => 'select',
			'options'    => $source_options,
			'default'    => 'post',
			'searchable' => true,
			'rerender'   => true,
		];

		$this->controls['ratingLayout'] = [
			'tab'      => 'content',
			'group'    => 'settings',
			'label'    => esc_html__( 'Rating layout', 'jetreviews-integration-bricks' ),
			'type'     => 'select',
			'options'  => [
				'stars-field'  => esc_html__( 'Stars', 'jetreviews-integration-bricks' ),
				'points-field' => esc_html__( 'Points', 'jetreviews-integration-bricks' ),
			],
			'default'  => 'stars-field',
			'rerender' => true,
		];

		$this->controls['ratingInputType'] = [
			'tab'      => 'content',
			'group'    => 'settings',
			'label'    => esc_html__( 'Rating input type', 'jetreviews-integration-bricks' ),
			'type'     => 'select',
			'options'  => [
				'slider-input' => esc_html__( 'Slider', 'jetreviews-integration-bricks' ),
				'stars-input'  => esc_html__( 'Stars', 'jetreviews-integration-bricks' ),
			],
			'default'  => 'slider-input',
			'rerender' => true,
		];

		$this->controls['reviewRatingType'] = [
			'tab'      => 'content',
			'group'    => 'settings',
			'label'    => esc_html__( 'Review rating type', 'jetreviews-integration-bricks' ),
			'type'     => 'select',
			'options'  => [
				'average' => esc_html__( 'Average', 'jetreviews-integration-bricks' ),
				'details' => esc_html__( 'Details', 'jetreviews-integration-bricks' ),
			],
			'default'  => 'average',
			'rerender' => true,
		];

		$this->controls['reviewsPerPage'] = [
			'tab'      => 'content',
			'group'    => 'settings',
			'label'    => esc_html__( 'Reviews per page', 'jetreviews-integration-bricks' ),
			'type'     => 'number',
			'min'      => 1,
			'max'      => 50,
			'default'  => 10,
			'rerender' => true,
		];

		$this->controls['reviewAuthorAvatarVisible'] = [
			'tab'      => 'content',
			'group'    => 'settings',
			'label'    => esc_html__( 'Show review author avatar', 'jetreviews-integration-bricks' ),
			'type'     => 'checkbox',
			'default'  => true,
			'rerender' => true,
		];

		$this->controls['reviewTitleVisible'] = [
			'tab'      => 'content',
			'group'    => 'settings',
			'label'    => esc_html__( 'Show review title', 'jetreviews-integration-bricks' ),
			'type'     => 'checkbox',
			'default'  => true,
			'rerender' => true,
		];

		$this->controls['reviewTitleInputVisible'] = [
			'tab'      => 'content',
			'group'    => 'settings',
			'label'    => esc_html__( 'Show review title input', 'jetreviews-integration-bricks' ),
			'type'     => 'checkbox',
			'default'  => true,
			'rerender' => true,
		];

		$this->controls['reviewContentInputVisible'] = [
			'tab'      => 'content',
			'group'    => 'settings',
			'label'    => esc_html__( 'Show review content input', 'jetreviews-integration-bricks' ),
			'type'     => 'checkbox',
			'default'  => true,
			'rerender' => true,
		];

		$this->controls['commentAuthorAvatarVisible'] = [
			'tab'      => 'content',
			'group'    => 'settings',
			'label'    => esc_html__( 'Show comment author avatar', 'jetreviews-integration-bricks' ),
			'type'     => 'checkbox',
			'default'  => true,
			'rerender' => true,
		];

		$this->controls['disableBuilderRender'] = [
			'tab'         => 'content',
			'group'       => 'settings',
			'label'       => esc_html__( "Don't render inside builder", 'jetreviews-integration-bricks' ),
			'type'        => 'checkbox',
			'default'     => false,
			'description' => esc_html__( 'Useful if the Vue widget slows down the builder. Frontend will still render.', 'jetreviews-integration-bricks' ),
			'rerender'    => true,
		];

		// --- Icons ---
		$icon_controls = [
			'emptyStarIcon'           => [ 'Empty Star Icon',           'far fa-star' ],
			'filledStarIcon'          => [ 'Filled Star Icon',          'fas fa-star' ],
			'newReviewButtonIcon'     => [ 'New Review Button Icon',    'fas fa-pen' ],
			'showCommentsButtonIcon'  => [ 'Show Comments Button Icon', 'fas fa-comment' ],
			'newCommentButtonIcon'    => [ 'New Comment Button Icon',   'fas fa-pen' ],
			'pinnedIcon'              => [ 'Pinned Icon',               'fas fa-thumbtack' ],
			'reviewEmptyLikeIcon'     => [ 'Empty Like Icon',           'far fa-thumbs-up' ],
			'reviewFilledLikeIcon'    => [ 'Filled Like Icon',          'fas fa-thumbs-up' ],
			'reviewEmptyDislikeIcon'  => [ 'Empty Dislike Icon',        'far fa-thumbs-down' ],
			'reviewFilledDislikeIcon' => [ 'Filled Dislike Icon',       'fas fa-thumbs-down' ],
			'replyButtonIcon'         => [ 'Reply Button Icon',         'fas fa-reply' ],
			'prevIcon'                => [ 'Prev Icon',                 'fas fa-chevron-left' ],
			'nextIcon'                => [ 'Next Icon',                 'fas fa-chevron-right' ],
		];

		foreach ( $icon_controls as $key => $config ) {
			$this->controls[ $key ] = [
				'tab'      => 'content',
				'group'    => 'icons',
				'label'    => esc_html__( $config[0], 'jetreviews-integration-bricks' ),
				'type'     => 'icon',
				'default'  => [
					'library' => 'fontawesome',
					'icon'    => $config[1],
				],
				'rerender' => true,
			];
		}

		// --- Labels: Header ---
		$this->controls['labelHeaderSeparator'] = [
			'tab'   => 'content',
			'group' => 'labels',
			'type'  => 'separator',
			'label' => esc_html__( 'Header', 'jetreviews-integration-bricks' ),
		];

		$this->controls['noReviewsLabel'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'No Reviews Message', 'jetreviews-integration-bricks' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'No reviews found', 'jetreviews-integration-bricks' ),
			'rerender'    => true,
		];

		$this->controls['singularReviewCountLabel'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Singular Review Count Label', 'jetreviews-integration-bricks' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Review', 'jetreviews-integration-bricks' ),
			'rerender'    => true,
		];

		$this->controls['pluralReviewCountLabel'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Plural Review Count Label', 'jetreviews-integration-bricks' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Reviews', 'jetreviews-integration-bricks' ),
			'rerender'    => true,
		];

		$this->controls['newReviewButton'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'New Review Button', 'jetreviews-integration-bricks' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Write a review', 'jetreviews-integration-bricks' ),
			'rerender'    => true,
		];

		$this->controls['alreadyReviewedMessage'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Already Reviewed Message', 'jetreviews-integration-bricks' ),
			'type'        => 'text',
			'placeholder' => esc_html__( '*Already reviewed', 'jetreviews-integration-bricks' ),
			'rerender'    => true,
		];

		$this->controls['moderatorCheckMessage'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Moderator Check Message', 'jetreviews-integration-bricks' ),
			'type'        => 'text',
			'placeholder' => esc_html__( '*Your review must be approved by the moderator', 'jetreviews-integration-bricks' ),
			'rerender'    => true,
		];

		// --- Labels: Review Form ---
		$this->controls['labelReviewFormSeparator'] = [
			'tab'   => 'content',
			'group' => 'labels',
			'type'  => 'separator',
			'label' => esc_html__( 'Review Form', 'jetreviews-integration-bricks' ),
		];

		$this->controls['notValidFieldMessage'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Not Valid Field Message', 'jetreviews-integration-bricks' ),
			'type'        => 'text',
			'placeholder' => esc_html__( '*This field is required or not valid', 'jetreviews-integration-bricks' ),
			'rerender'    => true,
		];

		$this->controls['authorNamePlaceholder'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Author Name Placeholder', 'jetreviews-integration-bricks' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Your Name', 'jetreviews-integration-bricks' ),
			'rerender'    => true,
		];

		$this->controls['authorMailPlaceholder'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Author Mail Placeholder', 'jetreviews-integration-bricks' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Your Mail', 'jetreviews-integration-bricks' ),
			'rerender'    => true,
		];

		$this->controls['reviewContentPlaceholder'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Review Content Placeholder', 'jetreviews-integration-bricks' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Your review', 'jetreviews-integration-bricks' ),
			'rerender'    => true,
		];

		$this->controls['reviewTitlePlaceholder'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Review Title Placeholder', 'jetreviews-integration-bricks' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Title of your review', 'jetreviews-integration-bricks' ),
			'rerender'    => true,
		];

		$this->controls['submitReviewButton'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Submit Review Button', 'jetreviews-integration-bricks' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Submit a review', 'jetreviews-integration-bricks' ),
			'rerender'    => true,
		];

		$this->controls['cancelButtonLabel'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Cancel Button', 'jetreviews-integration-bricks' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Cancel', 'jetreviews-integration-bricks' ),
			'rerender'    => true,
		];

		// --- Labels: Comment Form ---
		$this->controls['labelCommentFormSeparator'] = [
			'tab'   => 'content',
			'group' => 'labels',
			'type'  => 'separator',
			'label' => esc_html__( 'Comment Form', 'jetreviews-integration-bricks' ),
		];

		$this->controls['newCommentButton'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'New Comment Button', 'jetreviews-integration-bricks' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Leave a comment', 'jetreviews-integration-bricks' ),
			'rerender'    => true,
		];

		$this->controls['commentPlaceholder'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Comments Placeholder', 'jetreviews-integration-bricks' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Leave your comments', 'jetreviews-integration-bricks' ),
			'rerender'    => true,
		];

		$this->controls['showCommentsButton'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Show Comments Button', 'jetreviews-integration-bricks' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Show Comments', 'jetreviews-integration-bricks' ),
			'rerender'    => true,
		];

		$this->controls['hideCommentsButton'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Hide Comments Button', 'jetreviews-integration-bricks' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Hide Comments', 'jetreviews-integration-bricks' ),
			'rerender'    => true,
		];

		$this->controls['commentsTitle'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Comments Title', 'jetreviews-integration-bricks' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Comments', 'jetreviews-integration-bricks' ),
			'rerender'    => true,
		];

		$this->controls['submitCommentButton'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Submit Comment Button', 'jetreviews-integration-bricks' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Submit Comment', 'jetreviews-integration-bricks' ),
			'rerender'    => true,
		];

		// --- Labels: Reply Form ---
		$this->controls['labelReplyFormSeparator'] = [
			'tab'   => 'content',
			'group' => 'labels',
			'type'  => 'separator',
			'label' => esc_html__( 'Reply Form', 'jetreviews-integration-bricks' ),
		];

		$this->controls['replyButton'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Reply Comment Button', 'jetreviews-integration-bricks' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Reply', 'jetreviews-integration-bricks' ),
			'rerender'    => true,
		];

		$this->controls['replyPlaceholder'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Reply Placeholder', 'jetreviews-integration-bricks' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Leave your reply', 'jetreviews-integration-bricks' ),
			'rerender'    => true,
		];

		$this->controls['submitReplyButton'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Submit Reply Button', 'jetreviews-integration-bricks' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Submit a reply', 'jetreviews-integration-bricks' ),
			'rerender'    => true,
		];
	}

	/**
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
	 * @param string      $key     Settings key.
	 * @param string|null $default Fallback HTML if icon is not set.
	 *
	 * @return string|null
	 */
	private function get_icon_html( $key, $default = null ) {
		if ( empty( $this->settings[ $key ] ) || ! is_array( $this->settings[ $key ] ) ) {
			return $default;
		}

		$icon_data = $this->settings[ $key ];

		if ( ! empty( $icon_data['library'] ) && 'svg' === $icon_data['library'] ) {
			if ( ! empty( $icon_data['url'] ) ) {
				$svg_content = @file_get_contents( esc_url( $icon_data['url'] ) );
				return ! empty( $svg_content ) ? $svg_content : $default;
			}

			if ( ! empty( $icon_data['id'] ) ) {
				$url = wp_get_attachment_url( $icon_data['id'] );
				if ( $url ) {
					$svg_content = @file_get_contents( $url );
					return ! empty( $svg_content ) ? $svg_content : $default;
				}
			}

			return $default;
		}

		if ( ! empty( $icon_data['icon'] ) ) {
			return '<i class="' . esc_attr( $icon_data['icon'] ) . '"></i>';
		}

		return $default;
	}

	/**
	 * Build the labels array from Bricks settings.
	 *
	 * Only includes labels that the user has explicitly set (non-empty).
	 * Review_Listing_Render merges these with its own defaults,
	 * so empty/missing labels will use the JetReviews defaults.
	 *
	 * @return array
	 */
	private function build_labels() {
		$label_keys = [
			'noReviewsLabel',
			'singularReviewCountLabel',
			'pluralReviewCountLabel',
			'newReviewButton',
			'alreadyReviewedMessage',
			'moderatorCheckMessage',
			'notValidFieldMessage',
			'authorNamePlaceholder',
			'authorMailPlaceholder',
			'reviewContentPlaceholder',
			'reviewTitlePlaceholder',
			'submitReviewButton',
			'cancelButtonLabel',
			'newCommentButton',
			'commentPlaceholder',
			'showCommentsButton',
			'hideCommentsButton',
			'submitCommentButton',
			'replyButton',
			'replyPlaceholder',
			'submitReplyButton',
		];

		$labels = [];

		foreach ( $label_keys as $key ) {
			if ( ! empty( $this->settings[ $key ] ) ) {
				$labels[ $key ] = esc_attr( $this->settings[ $key ] );
			}
		}

		if ( ! empty( $this->settings['commentsTitle'] ) ) {
			$labels["\xD1\x81ommentsTitle"] = esc_attr( $this->settings['commentsTitle'] );
		}

		return $labels;
	}

	public function render() {
		if ( ! function_exists( 'jet_reviews' ) ) {
			$this->render_element_placeholder( [ 'title' => esc_html__( 'JetReviews plugin is not active.', 'jetreviews-integration-bricks' ) ], 'warning' );
			return;
		}

		if ( ! class_exists( '\\Jet_Reviews\\Reviews\\Review_Listing_Render' ) ) {
			$this->render_element_placeholder( [ 'title' => esc_html__( 'JetReviews renderer class not found (plugin version mismatch).', 'jetreviews-integration-bricks' ) ], 'warning' );
			return;
		}

		$is_builder_context = ( function_exists( 'bricks_is_builder_call' ) && bricks_is_builder_call() )
			|| ( function_exists( 'bricks_is_builder_iframe' ) && bricks_is_builder_iframe() )
			|| ( function_exists( 'bricks_is_builder_main' ) && bricks_is_builder_main() );

		if ( $is_builder_context && ! empty( $this->settings['disableBuilderRender'] ) ) {
			$this->render_element_placeholder( [
				'title' => esc_html__( 'JetReviews: rendering disabled in builder.', 'jetreviews-integration-bricks' ),
				'text'  => esc_html__( 'Disable the "Don\'t render" option to preview, or check the frontend.', 'jetreviews-integration-bricks' ),
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

		if ( $prev_icon_html || $next_icon_html ) {
			$icons['prevIcon'] = ! is_rtl() ? $prev_icon_html : $next_icon_html;
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
			'labels'                     => $this->build_labels(),
		];

		$html = '';

		try {
			$renderer = new \Jet_Reviews\Reviews\Review_Listing_Render( $settings );
			ob_start();
			$renderer->render();
			$html = ob_get_clean();
		} catch ( \Throwable $e ) {
			if ( function_exists( 'error_log' ) ) {
				error_log( '[JetReviews_Integration_Bricks] ' . $e->getMessage() );
			}

			if ( current_user_can( 'manage_options' ) && $is_builder_context ) {
				$html = '<pre class="jetreviews-bricks-error" style="white-space:pre-wrap">' . esc_html( $e->getMessage() ) . '</pre>';
			}
		}

		if ( empty( $html ) ) {
			$this->render_element_placeholder( [ 'title' => esc_html__( 'JetReviews rendered empty output.', 'jetreviews-integration-bricks' ) ] );
			return;
		}

		echo '<div class="jetreviews-reviews-listing" ' . $this->render_attributes( '_root' ) . '>';
		echo $html;
		echo '</div>';
	}
}
