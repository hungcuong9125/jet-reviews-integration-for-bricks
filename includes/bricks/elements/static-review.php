<?php
namespace JetReviews_Bricks_Bridge\Elements;

use Bricks\Element;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Bricks element: JetReviews Static Review.
 *
 * Self-contained static review widget that renders review fields,
 * summary and structured data. Equivalent to Elementor's "Jet Reviews"
 * (Static Review) widget.
 */
class Element_JetReviews_Static_Review extends Element {
	public $category     = 'jetreviews';
	public $name         = 'jetreviews-static-review';
	public $icon         = 'ti-write';
	public $css_selector = '.jetreviews-static-review';

	public function get_label() {
		return esc_html__( 'Static Review (JetReviews)', 'jet-reviews-bricks-bridge' );
	}

	public function set_control_groups() {
		$this->control_groups['content'] = [
			'title' => esc_html__( 'Content', 'jet-reviews-bricks-bridge' ),
			'tab'   => 'content',
		];

		$this->control_groups['header_settings'] = [
			'title' => esc_html__( 'Header Settings', 'jet-reviews-bricks-bridge' ),
			'tab'   => 'content',
		];

		$this->control_groups['fields_settings'] = [
			'title' => esc_html__( 'Fields Settings', 'jet-reviews-bricks-bridge' ),
			'tab'   => 'content',
		];

		$this->control_groups['summary_settings'] = [
			'title' => esc_html__( 'Summary Settings', 'jet-reviews-bricks-bridge' ),
			'tab'   => 'content',
		];

		$this->control_groups['structured_data'] = [
			'title' => esc_html__( 'Structured Data', 'jet-reviews-bricks-bridge' ),
			'tab'   => 'content',
		];
	}

	public function set_controls() {

		// --- Content ---
		$this->controls['reviewFields'] = [
			'tab'           => 'content',
			'group'         => 'content',
			'label'         => esc_html__( 'Review Fields', 'jet-reviews-bricks-bridge' ),
			'type'          => 'repeater',
			'titleProperty' => 'label',
			'fields'        => [
				'label' => [
					'label' => esc_html__( 'Label', 'jet-reviews-bricks-bridge' ),
					'type'  => 'text',
				],
				'value' => [
					'label'   => esc_html__( 'Value', 'jet-reviews-bricks-bridge' ),
					'type'    => 'number',
					'min'     => 0,
					'max'     => 100,
					'step'    => 0.1,
				],
				'max' => [
					'label'   => esc_html__( 'Max', 'jet-reviews-bricks-bridge' ),
					'type'    => 'number',
					'min'     => 1,
					'max'     => 100,
					'step'    => 0.1,
				],
			],
			'default' => [
				[
					'label' => esc_html__( 'Design', 'jet-reviews-bricks-bridge' ),
					'value' => 9,
					'max'   => 10,
				],
				[
					'label' => esc_html__( 'Features', 'jet-reviews-bricks-bridge' ),
					'value' => 8,
					'max'   => 10,
				],
				[
					'label' => esc_html__( 'Performance', 'jet-reviews-bricks-bridge' ),
					'value' => 9.5,
					'max'   => 10,
				],
			],
			'rerender' => true,
		];

		$this->controls['summaryTitle'] = [
			'tab'         => 'content',
			'group'       => 'content',
			'label'       => esc_html__( 'Summary Title', 'jet-reviews-bricks-bridge' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Review Summary Title', 'jet-reviews-bricks-bridge' ),
			'default'     => esc_html__( 'Review Summary Title', 'jet-reviews-bricks-bridge' ),
			'rerender'    => true,
		];

		$this->controls['summaryText'] = [
			'tab'         => 'content',
			'group'       => 'content',
			'label'       => esc_html__( 'Summary Text', 'jet-reviews-bricks-bridge' ),
			'type'        => 'textarea',
			'placeholder' => esc_html__( 'Review Summary Description', 'jet-reviews-bricks-bridge' ),
			'default'     => esc_html__( 'Review Summary Description', 'jet-reviews-bricks-bridge' ),
			'rerender'    => true,
		];

		$this->controls['summaryLegend'] = [
			'tab'         => 'content',
			'group'       => 'content',
			'label'       => esc_html__( 'Summary Legend', 'jet-reviews-bricks-bridge' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Nice!', 'jet-reviews-bricks-bridge' ),
			'default'     => esc_html__( 'Nice!', 'jet-reviews-bricks-bridge' ),
			'rerender'    => true,
		];

		// --- Header Settings ---
		$this->controls['reviewTitle'] = [
			'tab'         => 'content',
			'group'       => 'header_settings',
			'label'       => esc_html__( 'Title', 'jet-reviews-bricks-bridge' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Product Review', 'jet-reviews-bricks-bridge' ),
			'rerender'    => true,
		];

		$this->controls['totalAverageLayout'] = [
			'tab'      => 'content',
			'group'    => 'header_settings',
			'label'    => esc_html__( 'Average Layout', 'jet-reviews-bricks-bridge' ),
			'type'     => 'select',
			'options'  => [
				'stars'      => esc_html__( 'Stars', 'jet-reviews-bricks-bridge' ),
				'percentage' => esc_html__( 'Percentage', 'jet-reviews-bricks-bridge' ),
				'points'     => esc_html__( 'Points', 'jet-reviews-bricks-bridge' ),
			],
			'default'  => 'points',
			'rerender' => true,
		];

		$this->controls['totalAverageProgressbar'] = [
			'tab'      => 'content',
			'group'    => 'header_settings',
			'label'    => esc_html__( 'Show Progressbar', 'jet-reviews-bricks-bridge' ),
			'type'     => 'checkbox',
			'default'  => false,
			'rerender' => true,
			'required' => [ 'totalAverageLayout', '!=', 'stars' ],
		];

		$this->controls['totalAverageValuePosition'] = [
			'tab'      => 'content',
			'group'    => 'header_settings',
			'label'    => esc_html__( 'Value Position', 'jet-reviews-bricks-bridge' ),
			'type'     => 'select',
			'options'  => [
				'above'  => esc_html__( 'Above Progressbar', 'jet-reviews-bricks-bridge' ),
				'inside' => esc_html__( 'Inside Progressbar', 'jet-reviews-bricks-bridge' ),
			],
			'default'  => 'above',
			'rerender' => true,
			'required' => [ 'totalAverageProgressbar', '!=', '' ],
		];

		// --- Fields Settings ---
		$this->controls['fieldsLayout'] = [
			'tab'      => 'content',
			'group'    => 'fields_settings',
			'label'    => esc_html__( 'Layout', 'jet-reviews-bricks-bridge' ),
			'type'     => 'select',
			'options'  => [
				'stars'      => esc_html__( 'Stars', 'jet-reviews-bricks-bridge' ),
				'percentage' => esc_html__( 'Percentage', 'jet-reviews-bricks-bridge' ),
				'points'     => esc_html__( 'Points', 'jet-reviews-bricks-bridge' ),
			],
			'default'  => 'points',
			'rerender' => true,
		];

		$this->controls['fieldsProgressbar'] = [
			'tab'      => 'content',
			'group'    => 'fields_settings',
			'label'    => esc_html__( 'Show Progressbar', 'jet-reviews-bricks-bridge' ),
			'type'     => 'checkbox',
			'default'  => true,
			'rerender' => true,
			'required' => [ 'fieldsLayout', '!=', 'stars' ],
		];

		$this->controls['fieldsValuePosition'] = [
			'tab'      => 'content',
			'group'    => 'fields_settings',
			'label'    => esc_html__( 'Value Position', 'jet-reviews-bricks-bridge' ),
			'type'     => 'select',
			'options'  => [
				'above'  => esc_html__( 'Above Progressbar', 'jet-reviews-bricks-bridge' ),
				'inside' => esc_html__( 'Inside Progressbar', 'jet-reviews-bricks-bridge' ),
			],
			'default'  => 'above',
			'rerender' => true,
			'required' => [ 'fieldsProgressbar', '!=', '' ],
		];

		$this->controls['fieldsLabelSuffix'] = [
			'tab'         => 'content',
			'group'       => 'fields_settings',
			'label'       => esc_html__( 'Label Suffix', 'jet-reviews-bricks-bridge' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'e.g. :', 'jet-reviews-bricks-bridge' ),
			'rerender'    => true,
		];

		// --- Summary Settings ---
		$this->controls['summaryResultPosition'] = [
			'tab'      => 'content',
			'group'    => 'summary_settings',
			'label'    => esc_html__( 'Results Block Position', 'jet-reviews-bricks-bridge' ),
			'type'     => 'select',
			'options'  => [
				'right'  => esc_html__( 'Right', 'jet-reviews-bricks-bridge' ),
				'bottom' => esc_html__( 'Bottom', 'jet-reviews-bricks-bridge' ),
				'left'   => esc_html__( 'Left', 'jet-reviews-bricks-bridge' ),
				'top'    => esc_html__( 'Top', 'jet-reviews-bricks-bridge' ),
			],
			'default'  => 'right',
			'rerender' => true,
		];

		$this->controls['summaryLayout'] = [
			'tab'      => 'content',
			'group'    => 'summary_settings',
			'label'    => esc_html__( 'Summary Average Layout', 'jet-reviews-bricks-bridge' ),
			'type'     => 'select',
			'options'  => [
				'stars'      => esc_html__( 'Stars', 'jet-reviews-bricks-bridge' ),
				'percentage' => esc_html__( 'Percentage', 'jet-reviews-bricks-bridge' ),
				'points'     => esc_html__( 'Points', 'jet-reviews-bricks-bridge' ),
			],
			'default'  => 'points',
			'rerender' => true,
		];

		$this->controls['summaryProgressbar'] = [
			'tab'      => 'content',
			'group'    => 'summary_settings',
			'label'    => esc_html__( 'Show Progressbar', 'jet-reviews-bricks-bridge' ),
			'type'     => 'checkbox',
			'default'  => false,
			'rerender' => true,
			'required' => [ 'summaryLayout', '!=', 'stars' ],
		];

		$this->controls['summaryValuePosition'] = [
			'tab'      => 'content',
			'group'    => 'summary_settings',
			'label'    => esc_html__( 'Value Position', 'jet-reviews-bricks-bridge' ),
			'type'     => 'select',
			'options'  => [
				'above'  => esc_html__( 'Above Progressbar', 'jet-reviews-bricks-bridge' ),
				'inside' => esc_html__( 'Inside Progressbar', 'jet-reviews-bricks-bridge' ),
			],
			'default'  => 'above',
			'rerender' => true,
			'required' => [ 'summaryProgressbar', '!=', '' ],
		];

		// --- Structured Data ---
		$this->controls['addSdata'] = [
			'tab'      => 'content',
			'group'    => 'structured_data',
			'label'    => esc_html__( 'Add Structured Data', 'jet-reviews-bricks-bridge' ),
			'type'     => 'checkbox',
			'default'  => false,
			'rerender' => true,
		];

		$this->controls['sdataItemName'] = [
			'tab'         => 'content',
			'group'       => 'structured_data',
			'label'       => esc_html__( 'Review Item Name', 'jet-reviews-bricks-bridge' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Product Name', 'jet-reviews-bricks-bridge' ),
			'rerender'    => true,
			'required'    => [ 'addSdata', '!=', '' ],
		];

		$this->controls['sdataItemImage'] = [
			'tab'      => 'content',
			'group'    => 'structured_data',
			'label'    => esc_html__( 'Review Item Image', 'jet-reviews-bricks-bridge' ),
			'type'     => 'image',
			'rerender' => true,
			'required' => [ 'addSdata', '!=', '' ],
		];

		$this->controls['sdataItemDescription'] = [
			'tab'         => 'content',
			'group'       => 'structured_data',
			'label'       => esc_html__( 'Review Item Description', 'jet-reviews-bricks-bridge' ),
			'type'        => 'textarea',
			'placeholder' => esc_html__( 'Item description for structured data', 'jet-reviews-bricks-bridge' ),
			'rerender'    => true,
			'required'    => [ 'addSdata', '!=', '' ],
		];

		$this->controls['sdataReviewAuthor'] = [
			'tab'         => 'content',
			'group'       => 'structured_data',
			'label'       => esc_html__( 'Review Author Name', 'jet-reviews-bricks-bridge' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Author Name', 'jet-reviews-bricks-bridge' ),
			'rerender'    => true,
			'required'    => [ 'addSdata', '!=', '' ],
		];
	}

	/**
	 * Get stars rating HTML.
	 *
	 * @param float $value Current value.
	 * @param float $max   Max value.
	 *
	 * @return string
	 */
	private function get_stars_html( $value, $max ) {
		$width   = $max > 0 ? round( ( 100 * $value ) / $max, 3 ) : 0;
		$stars_f = str_repeat( '<i class="fa fa-star" aria-hidden="true"></i>', 5 );
		$stars_e = str_repeat( '<i class="fa fa-star-o" aria-hidden="true"></i>', 5 );

		return sprintf(
			'<div class="jet-review__stars"><div class="jet-review__stars-filled" style="width:%1$s%%">%3$s</div><div class="jet-review__stars-empty" style="width:%2$s%%">%4$s</div><div class="jet-review__stars-adjuster">%4$s</div></div>',
			$width,
			100 - $width,
			$stars_f,
			$stars_e
		);
	}

	/**
	 * Get progress bar HTML.
	 *
	 * @param float  $value    Current value.
	 * @param float  $max      Max value.
	 * @param string $val_pos  'above' or 'inside'.
	 * @param string $type     'points' or 'percentage'.
	 *
	 * @return string
	 */
	private function get_progressbar_html( $value, $max, $val_pos = 'above', $type = 'points' ) {
		$inner_label = '';

		if ( 'inside' === $val_pos ) {
			$inner_label = ( 'points' === $type )
				? $value
				: round( ( 100 * $value ) / $max, 0 ) . '%';
		}

		$percent = $max > 0 ? round( ( $value * 100 ) / $max ) : 0;

		return sprintf(
			'<div class="jet-review__progress"><div class="jet-review__progress-bar" style="width:%1$s%%"><div class="jet-review__progress-val">%2$s</div></div></div>',
			$percent,
			$inner_label
		);
	}

	/**
	 * Calculate average from review fields.
	 *
	 * @param array $fields Review fields (repeater items).
	 *
	 * @return array
	 */
	private function calc_average( $fields ) {
		$default = [
			'valid'   => true,
			'val'     => 0,
			'max'     => 10,
			'percent' => 0,
		];

		if ( empty( $fields ) ) {
			return $default;
		}

		$totals  = [];
		$all_max = [];

		foreach ( $fields as $field ) {
			$val = isset( $field['value'] ) ? floatval( $field['value'] ) : 0;
			$max = isset( $field['max'] ) ? floatval( $field['max'] ) : 10;

			if ( ! $max ) {
				continue;
			}

			$totals[]  = round( ( 100 * $val ) / $max, 2 );
			$all_max[] = $max;
		}

		if ( empty( $totals ) ) {
			return $default;
		}

		$average = round( array_sum( $totals ) / count( $totals ), 2 );
		$all_max = array_unique( $all_max );
		$valid   = 1 === count( $all_max );

		return [
			'valid'   => $valid,
			'val'     => $valid ? round( $average * ( $all_max[0] / 100 ), 2 ) : $average,
			'max'     => $valid ? $all_max[0] : 100,
			'percent' => $average,
		];
	}

	/**
	 * Render a value display for the given layout type.
	 *
	 * @param float  $val      Value.
	 * @param float  $max      Max.
	 * @param string $layout   'stars', 'points', or 'percentage'.
	 * @param string $val_pos  'above' or 'inside'.
	 * @param bool   $progress Show progressbar.
	 *
	 * @return string
	 */
	private function render_value_display( $val, $max, $layout, $val_pos, $progress ) {
		$html = '';

		if ( 'stars' === $layout ) {
			$html .= $this->get_stars_html( $val, $max );
		} elseif ( 'percentage' === $layout ) {
			if ( 'above' === $val_pos || ! $progress ) {
				$html .= '<div class="jet-review__field-val">' . round( ( 100 * $val ) / $max, 0 ) . '%</div>';
			}
			if ( $progress ) {
				$html .= $this->get_progressbar_html( $val, $max, $val_pos, 'percentage' );
			}
		} else {
			if ( 'above' === $val_pos || ! $progress ) {
				$html .= '<div class="jet-review__field-val">' . $val . '</div>';
			}
			if ( $progress ) {
				$html .= $this->get_progressbar_html( $val, $max, $val_pos, 'points' );
			}
		}

		return $html;
	}

	public function render() {
		$fields = ! empty( $this->settings['reviewFields'] ) ? $this->settings['reviewFields'] : [];

		if ( empty( $fields ) ) {
			$this->render_element_placeholder( [
				'title' => esc_html__( 'Add review fields to display.', 'jet-reviews-bricks-bridge' ),
			] );
			return;
		}

		$review_title    = ! empty( $this->settings['reviewTitle'] ) ? $this->settings['reviewTitle'] : '';
		$summary_title   = ! empty( $this->settings['summaryTitle'] ) ? $this->settings['summaryTitle'] : '';
		$summary_text    = ! empty( $this->settings['summaryText'] ) ? $this->settings['summaryText'] : '';
		$summary_legend  = ! empty( $this->settings['summaryLegend'] ) ? $this->settings['summaryLegend'] : '';
		$label_suffix    = ! empty( $this->settings['fieldsLabelSuffix'] ) ? $this->settings['fieldsLabelSuffix'] : '';

		$fields_layout   = ! empty( $this->settings['fieldsLayout'] ) ? $this->settings['fieldsLayout'] : 'points';
		$fields_progress = ! empty( $this->settings['fieldsProgressbar'] );
		$fields_val_pos  = ! empty( $this->settings['fieldsValuePosition'] ) ? $this->settings['fieldsValuePosition'] : 'above';

		$avg_layout      = ! empty( $this->settings['totalAverageLayout'] ) ? $this->settings['totalAverageLayout'] : 'points';
		$avg_progress    = ! empty( $this->settings['totalAverageProgressbar'] );
		$avg_val_pos     = ! empty( $this->settings['totalAverageValuePosition'] ) ? $this->settings['totalAverageValuePosition'] : 'above';

		$sum_layout      = ! empty( $this->settings['summaryLayout'] ) ? $this->settings['summaryLayout'] : 'points';
		$sum_progress    = ! empty( $this->settings['summaryProgressbar'] );
		$sum_val_pos     = ! empty( $this->settings['summaryValuePosition'] ) ? $this->settings['summaryValuePosition'] : 'above';
		$sum_result_pos  = ! empty( $this->settings['summaryResultPosition'] ) ? $this->settings['summaryResultPosition'] : 'right';

		$average = $this->calc_average( $fields );

		if ( $average['valid'] ) {
			$avg_val = $average['val'];
			$avg_max = $average['max'];
		} else {
			$avg_val = $average['percent'];
			$avg_max = 100;
		}

		echo '<div class="jetreviews-static-review jet-review" ' . $this->render_attributes( '_root' ) . '>';

		echo '<div class="jet-review__header">';
		echo '<div class="jet-review__header-top">';

		if ( ! empty( $review_title ) ) {
			echo '<h4 class="jet-review__title">' . esc_html( $review_title ) . '</h4>';
		}

		if ( $average['percent'] > 0 ) {
			echo '<div class="jet-review__total-average">';
			echo $this->render_value_display( $avg_val, $avg_max, $avg_layout, $avg_val_pos, $avg_progress );
			echo '</div>';
		}

		echo '</div>';
		echo '</div>';

		echo '<div class="jet-review__item">';

		echo '<div class="jet-review__fields">';
		foreach ( $fields as $field ) {
			$label = isset( $field['label'] ) ? $field['label'] : '';
			$val   = isset( $field['value'] ) ? floatval( $field['value'] ) : 0;
			$max   = isset( $field['max'] ) ? floatval( $field['max'] ) : 10;

			if ( ! $max ) {
				continue;
			}
			if ( $val > $max ) {
				$val = $max;
			}

			$field_class = 'jet-review__field jet-layout-' . esc_attr( $fields_layout );

			echo '<div class="' . esc_attr( $field_class ) . '">';
			echo '<div class="jet-review__field-heading">';
			echo '<div class="jet-review__field-label">' . esc_html( $label );
			if ( ! empty( $label_suffix ) ) {
				echo '<span class="jet-review__field-label-suffix">' . esc_html( $label_suffix ) . '</span>';
			}
			echo '</div>';

			if ( 'stars' === $fields_layout ) {
				echo $this->get_stars_html( $val, $max );
			} else {
				if ( 'above' === $fields_val_pos ) {
					if ( 'percentage' === $fields_layout ) {
						echo '<div class="jet-review__field-val">' . round( ( 100 * $val ) / $max, 0 ) . '%</div>';
					} else {
						echo '<div class="jet-review__field-val">' . $val . '</div>';
					}
				}
			}

			echo '</div>';

			if ( 'stars' !== $fields_layout && $fields_progress ) {
				$pb_type = ( 'percentage' === $fields_layout ) ? 'percentage' : 'points';
				echo $this->get_progressbar_html( $val, $max, $fields_val_pos, $pb_type );
			}

			echo '</div>';
		}
		echo '</div>';

		echo '<div class="jet-review__summary jet-review-summary-' . esc_attr( $sum_result_pos ) . '">';

		echo '<div class="jet-review__summary-content">';
		if ( ! empty( $summary_title ) ) {
			echo '<h5 class="jet-review__summary-title">' . esc_html( $summary_title ) . '</h5>';
		}
		if ( ! empty( $summary_text ) ) {
			echo '<div class="jet-review__summary-text">' . wp_kses_post( $summary_text ) . '</div>';
		}
		echo '</div>';

		echo '<div class="jet-review__summary-data">';
		echo $this->render_value_display( $avg_val, $avg_max, $sum_layout, $sum_val_pos, $sum_progress );
		if ( ! empty( $summary_legend ) ) {
			echo '<div class="jet-review__summary-legend">' . esc_html( $summary_legend ) . '</div>';
		}
		echo '</div>';

		echo '</div>';
		echo '</div>';

		if ( ! empty( $this->settings['addSdata'] ) ) {
			$this->render_structured_data( $fields, $average );
		}

		echo '</div>';
	}

	/**
	 * Output JSON-LD structured data for the review.
	 *
	 * @param array $fields  Review fields.
	 * @param array $average Calculated average.
	 */
	private function render_structured_data( $fields, $average ) {
		$item_name    = ! empty( $this->settings['sdataItemName'] ) ? $this->settings['sdataItemName'] : get_the_title();
		$item_desc    = ! empty( $this->settings['sdataItemDescription'] ) ? $this->settings['sdataItemDescription'] : '';
		$author_name  = ! empty( $this->settings['sdataReviewAuthor'] ) ? $this->settings['sdataReviewAuthor'] : '';
		$item_image   = '';

		if ( ! empty( $this->settings['sdataItemImage']['url'] ) ) {
			$item_image = $this->settings['sdataItemImage']['url'];
		} elseif ( ! empty( $this->settings['sdataItemImage']['id'] ) ) {
			$item_image = wp_get_attachment_url( $this->settings['sdataItemImage']['id'] );
		}

		if ( $average['valid'] ) {
			$best_rating = $average['max'];
			$rating_val  = $average['val'];
		} else {
			$best_rating = 100;
			$rating_val  = $average['percent'];
		}

		$sdata = [
			'@context' => 'https://schema.org/',
			'@type'    => 'Review',
			'itemReviewed' => [
				'@type' => 'Thing',
				'name'  => $item_name,
			],
			'reviewRating' => [
				'@type'       => 'Rating',
				'ratingValue' => $rating_val,
				'bestRating'  => $best_rating,
			],
		];

		if ( ! empty( $item_image ) ) {
			$sdata['itemReviewed']['image'] = $item_image;
		}

		if ( ! empty( $item_desc ) ) {
			$sdata['itemReviewed']['description'] = $item_desc;
		}

		if ( ! empty( $author_name ) ) {
			$sdata['author'] = [
				'@type' => 'Person',
				'name'  => $author_name,
			];
		}

		echo '<script type="application/ld+json">' . wp_json_encode( $sdata, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>';
	}
}
