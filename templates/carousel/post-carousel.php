<?php
/**
* Template for Carousel
*
* @package Slick Slider Carousel
* @since 1.0.0
*
* @var string $slider_url
* @var string $lazyload
* @var string $slider_orig_img
* @var string $slider_img
*/


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<li class="maximum-slide splide__slide" data-id="<?php the_ID(); ?>">
	<?php if( $slider_url != '' ) { ?>
		<a href="<?php echo esc_url( $slider_url ); ?>">
			<div class="maximum-slider-image-slide-wrap">
				<img <?php if( $lazyload ) { ?>data-splide-lazy="<?php echo esc_url( $slider_orig_img ); ?>"<?php } ?> src="<?php echo esc_url( $slider_img ); ?>" aria-label="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>" />
				<div class="splide__label">
					<?php the_title(); ?>
				</div>
			</div>
		</a>
	<?php } else { ?>
		<div class="maximum-slider-image-slide-wrap">
			<img <?php if( $lazyload ) { ?>data-splide-lazy="<?php echo esc_url( $slider_orig_img ); ?>"<?php } ?> src="<?php echo esc_url( $slider_img ); ?>" aria-label="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>" />
			<div class="splide__label">
				<?php the_title(); ?>
			</div>
		</div>
	<?php } ?>
</li>
