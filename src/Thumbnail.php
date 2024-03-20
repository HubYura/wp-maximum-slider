<?php

namespace MaximumSlider;

class Thumbnail
{
	/**
	 * @var array $thumbnail_conf The configuration for thumbnail generation.
	 */
	public array $thumbnail_conf = array();

	/**
	 * Initializes the object.
	 *
	 * Global variables are accessed to retrieve the maximum_slider_conf and stores it into the thumbnail_conf property of the current object. It also adds an action hook "after_setup_theme
	 *" with the method "add_thumbnail_support()" as a callback.
	 *
	 * @return void
	 */
	public function init(): void
	{
		global $maximum_slider_conf;
		$this->thumbnail_conf = array($maximum_slider_conf->thumbnail, $maximum_slider_conf->thumbnail_mob);
		add_action( 'after_setup_theme', array( $this, 'add_thumbnail_support' ) );
	}

	/**
	 * Adds thumbnail support to the theme.
	 *
	 * Loops through the thumbnail configuration stored in the thumbnail_conf property of the current object.
	 * For each thumbnail and its corresponding sizes, it adds theme support and registers the image size.
	 *
	 * @return void
	 */
	public function add_thumbnail_support(): void
	{
		foreach ( $this->thumbnail_conf as $thumbnail ) {
			add_theme_support( $thumbnail['name'] );
			add_image_size( $thumbnail['name'], $thumbnail['width'], $thumbnail['height'], true );
		}
	}
}
