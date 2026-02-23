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

	public function set_control_groups() {
		$this->control_groups['settings'] = [
			'title' => esc_html__( 'Settings', 'jet-reviews-bricks-bridge' ),
			'tab'   => 'content',
		];

		$this->control_groups['icons'] = [
			'title' => esc_html__( 'Icons', 'jet-reviews-bricks-bridge' ),
			'tab'   => 'content',
		];

		$this->control_groups['labels'] = [
			'title' => esc_html__( 'Labels', 'jet-reviews-bricks-bridge' ),
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
				'label'    => esc_html__( $config[0], 'jet-reviews-bricks-bridge' ),
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
			'label' => esc_html__( 'Header', 'jet-reviews-bricks-bridge' ),
		];

		$this->controls['noReviewsLabel'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'No Reviews Message', 'jet-reviews-bricks-bridge' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'No reviews found', 'jet-reviews-bricks-bridge' ),
			'rerender'    => true,
		];

		$this->controls['singularReviewCountLabel'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Singular Review Count Label', 'jet-reviews-bricks-bridge' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Review', 'jet-reviews-bricks-bridge' ),
			'rerender'    => true,
		];

		$this->controls['pluralReviewCountLabel'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Plural Review Count Label', 'jet-reviews-bricks-bridge' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Reviews', 'jet-reviews-bricks-bridge' ),
			'rerender'    => true,
		];

		$this->controls['newReviewButton'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'New Review Button', 'jet-reviews-bricks-bridge' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Write a review', 'jet-reviews-bricks-bridge' ),
			'rerender'    => true,
		];

		$this->controls['alreadyReviewedMessage'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Already Reviewed Message', 'jet-reviews-bricks-bridge' ),
			'type'        => 'text',
			'placeholder' => esc_html__( '*Already reviewed', 'jet-reviews-bricks-bridge' ),
			'rerender'    => true,
		];

		$this->controls['moderatorCheckMessage'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Moderator Check Message', 'jet-reviews-bricks-bridge' ),
			'type'        => 'text',
			'placeholder' => esc_html__( '*Your review must be approved by the moderator', 'jet-reviews-bricks-bridge' ),
			'rerender'    => true,
		];

		// --- Labels: Review Form ---
		$this->controls['labelReviewFormSeparator'] = [
			'tab'   => 'content',
			'group' => 'labels',
			'type'  => 'separator',
			'label' => esc_html__( 'Review Form', 'jet-reviews-bricks-bridge' ),
		];

		$this->controls['notValidFieldMessage'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Not Valid Field Message', 'jet-reviews-bricks-bridge' ),
			'type'        => 'text',
			'placeholder' => esc_html__( '*This field is required or not valid', 'jet-reviews-bricks-bridge' ),
			'rerender'    => true,
		];

		$this->controls['authorNamePlaceholder'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Author Name Placeholder', 'jet-reviews-bricks-bridge' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Your Name', 'jet-reviews-bricks-bridge' ),
			'rerender'    => true,
		];

		$this->controls['authorMailPlaceholder'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Author Mail Placeholder', 'jet-reviews-bricks-bridge' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Your Mail', 'jet-reviews-bricks-bridge' ),
			'rerender'    => true,
		];

		$this->controls['reviewContentPlaceholder'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Review Content Placeholder', 'jet-reviews-bricks-bridge' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Your review', 'jet-reviews-bricks-bridge' ),
			'rerender'    => true,
		];

		$this->controls['reviewTitlePlaceholder'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Review Title Placeholder', 'jet-reviews-bricks-bridge' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Title of your review', 'jet-reviews-bricks-bridge' ),
			'rerender'    => true,
		];

		$this->controls['submitReviewButton'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Submit Review Button', 'jet-reviews-bricks-bridge' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Submit a review', 'jet-reviews-bricks-bridge' ),
			'rerender'    => true,
		];

		$this->controls['cancelButtonLabel'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Cancel Button', 'jet-reviews-bricks-bridge' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Cancel', 'jet-reviews-bricks-bridge' ),
			'rerender'    => true,
		];

		// --- Labels: Comment Form ---
		$this->controls['labelCommentFormSeparator'] = [
			'tab'   => 'content',
			'group' => 'labels',
			'type'  => 'separator',
			'label' => esc_html__( 'Comment Form', 'jet-reviews-bricks-bridge' ),
		];

		$this->controls['newCommentButton'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'New Comment Button', 'jet-reviews-bricks-bridge' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Leave a comment', 'jet-reviews-bricks-bridge' ),
			'rerender'    => true,
		];

		$this->controls['commentPlaceholder'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Comments Placeholder', 'jet-reviews-bricks-bridge' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Leave your comments', 'jet-reviews-bricks-bridge' ),
			'rerender'    => true,
		];

		$this->controls['showCommentsButton'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Show Comments Button', 'jet-reviews-bricks-bridge' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Show Comments', 'jet-reviews-bricks-bridge' ),
			'rerender'    => true,
		];

		$this->controls['hideCommentsButton'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Hide Comments Button', 'jet-reviews-bricks-bridge' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Hide Comments', 'jet-reviews-bricks-bridge' ),
			'rerender'    => true,
		];

		$this->controls['commentsTitle'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Comments Title', 'jet-reviews-bricks-bridge' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Comments', 'jet-reviews-bricks-bridge' ),
			'rerender'    => true,
		];

		$this->controls['submitCommentButton'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Submit Comment Button', 'jet-reviews-bricks-bridge' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Submit Comment', 'jet-reviews-bricks-bridge' ),
			'rerender'    => true,
		];

		// --- Labels: Reply Form ---
		$this->controls['labelReplyFormSeparator'] = [
			'tab'   => 'content',
			'group' => 'labels',
			'type'  => 'separator',
			'label' => esc_html__( 'Reply Form', 'jet-reviews-bricks-bridge' ),
		];

		$this->controls['replyButton'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Reply Comment Button', 'jet-reviews-bricks-bridge' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Reply', 'jet-reviews-bricks-bridge' ),
			'rerender'    => true,
		];

		$this->controls['replyPlaceholder'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Reply Placeholder', 'jet-reviews-bricks-bridge' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Leave your reply', 'jet-reviews-bricks-bridge' ),
			'rerender'    => true,
		];

		$this->controls['submitReplyButton'] = [
			'tab'         => 'content',
			'group'       => 'labels',
			'label'       => esc_html__( 'Submit Reply Button', 'jet-reviews-bricks-bridge' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Submit a reply', 'jet-reviews-bricks-bridge' ),
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

		// commentsTitle uses Cyrillic 'с' in JetReviews source for backward compatibility
		if ( ! empty( $this->settings['commentsTitle'] ) ) {
			$labels["\xD1\x81ommentsTitle"] = esc_attr( $this->settings['commentsTitle'] );
		}

		return $labels;
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
		echo $html;
		echo '</div>';
	}
}
