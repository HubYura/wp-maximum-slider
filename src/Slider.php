<?php

namespace MaximumSlider;

use WP_Query;

class Slider
{
	private string $template_file_path = MAXIMUM_SLIDER_PLUGIN_DIR . '/templates/carousel/post-carousel.php';

	private string $template_file;

	private string $post_type = 'slider';

	private string $orderby = 'post_date';

	private string $order = 'DESC';

	public string $limit = '10';

	public bool $lazyload = true;

	private WP_Query $query;

//	public array $slider_conf = compact( 'slidestoshow','slidestoscroll', 'dots', 'arrows', 'autoplay', 'autoplay_interval', 'speed', 'rtl', 'centermode' , 'lazyload', 'variablewidth', 'loop', 'hover_pause' );
	public array $slider_conf = [];

	public string $image_size = 'full';

	public string $slider_img = MAXIMUM_SLIDER_IMAGES_URL . 'placeholder.svg';

	public function __construct()
	{
		$this->template_file = ( file_exists( $this->template_file_path ) ) ? $this->template_file_path : '';
	}

	private function query(): WP_Query
	{
		// WP Query Parameters
		$args = array (
			'post_type'			=> $this->post_type,
			'orderby'			=> $this->orderby,
			'order'				=> $this->order,
			'posts_per_page'	=> $this->limit,
		);

		$query = new WP_Query( $args );

		if ( $query->post_count == 0 ) {
			$import = new ImportData;
			$import->init();
			$query = new WP_Query( $args );
		}

		return $query;
	}

	public function render(): false|string
	{
		global $post, $maximum_slider_conf;

		$this->image_size = ( wp_is_mobile() ) ? $maximum_slider_conf->thumbnail_mob['name'] : $maximum_slider_conf->thumbnail['name'];

		ob_start();
		$this->query = $this->query();

		if ( $this->query->have_posts() ) : ?>
			<div class="maximum-slider-slick-carousal-wrp maximum-slider-clearfix splide" aria-labelledby="carousel-heading" data-conf="<?php echo htmlspecialchars( json_encode( $this->slider_conf )); ?>">
				<div id="maximum-slider-slick-carousal-<?php echo esc_attr( $this->get_unique() ); ?>" class="maximum-slider-slick-carousal splide__track">
					<ul class="splide__list">
						<?php while ( $this->query->have_posts() ) : $this->query->the_post();
							$slider_url = '';
							$slider_orig_img = $this->get_post_featured_image( $post->ID, $this->image_size );
							$slider_img	= $slider_orig_img;
							$lazyload	= $this->lazyload;

							if ( $lazyload ) {
								$slider_img	= $this->slider_img;
							}

							if( $this->template_file ) {
								include( $this->template_file );
							}
						endwhile; ?>
					</ul>
				</div>
			</div>
			<div id="maximum-slider-modal-<?php echo esc_attr( $this->get_unique() ); ?>" class="maximum-slider-modal-window">
				<div class="maximum-slider-modal-window__content">
					<a href="#" class="maximum-slider-modal-window__content-close">
						<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M13 1L1 13M1 1L13 13" stroke="#997F5A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</a>
					<div class="maximum-slider-modal-window__content-title">
						<?php esc_html_e( 'Description', 'maximum_slider' )?>
					</div>
					<div class="maximum-slider-modal-window__content-text"></div>
				</div>
			</div>
			<div class="maximum-slider-modal-window__backdrop hidden"></div>
		<?php
		endif;
		wp_reset_postdata(); // Reset WP Query
		return ob_get_clean();
	}

	private function get_unique(): string
	{
		static $unique = 0;
		$unique++;

		$unique = current_time('timestamp') . '-' . rand();

		return $unique;
	}

	private function get_post_featured_image( $post_id = '', $size = 'full' ) {
		$size   = ! empty( $size ) ? $size : 'full';
		$image  = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size );

		if( ! empty( $image ) ) {
			$image = $image[0] ?? '';
		}
		return $image;
	}
}
