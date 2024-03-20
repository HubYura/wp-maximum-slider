<?php

/**
 * Class CustomPostTypes
 *
 * Handles the registration of custom post types and theme support for thumbnails.
 */

namespace MaximumSlider;

use CPT;

/**
 * Class CustomPostTypes
 *
 * Handles the registration of custom post types and theme support for thumbnails.
 */
class CustomPostTypes
{
	/**
	 * @var array of CPT classes.
	 */
	public array $post_types = [];

	/**
	 * @return void
	 */
	public function init(): void
	{
        $this->register_post_types();
		$this->add_theme_support_thumbnails();
    }

	/**
	 * Registers a new post type with the specified name, labels, slug and options.
	 *
	 * @return void
	 */
	private function register_post_types(): void
	{
		$this->post_types = array(
			'slider' => new CPT(array(
				'post_type_name' => 'slider',
				'singular' => 'Slider',
				'plural' => 'Sliders',
				'slug' => 'slider'
			), array(
				'supports' => array('title', 'editor', 'thumbnail')
			))
		);
	}

	/**
     * Adds theme support for thumbnails.
     *
     * @return void
     */
	private function add_theme_support_thumbnails(): void
	{
		global $maximum_slider_conf;
		add_theme_support( 'post-thumbnails', array_keys($this->post_types));
		add_theme_support( $maximum_slider_conf->thumbnail['name'], array_keys($this->post_types));
		add_theme_support( $maximum_slider_conf->thumbnail_mob['name'], array_keys($this->post_types));
	}
}
