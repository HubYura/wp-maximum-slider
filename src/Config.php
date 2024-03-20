<?php

namespace MaximumSlider;

/**
 * Class Config
 *
 * The Config class is responsible for initializing and setting configuration values for the application.
 */
class Config
{
	/**
	 * @var array $thumbnail The Size of the thumbnail image
	 */
	public array $thumbnail;

	/**
	 * @var array $thumbnail_mob The Size of the thumbnail image for mobile devices
	 */
	public array $thumbnail_mob;

	/**
	 * @var string $ajax_prefix The prefix used for AJAX endpoints.
	 * This variable is used to create the full URL for AJAX requests.
	 */
	public string $ajax_prefix;

	/**
	 * @var string $ajax_nonce_action The action name used for generating AJAX nonces.
	 * This variable is used as a unique identifier for the specific AJAX request.
	 * It is used in conjunction with the `wp_create_nonce` and `wp_verify_nonce` functions.
	 */
	public string $ajax_nonce_action;

	/**
	 * Initializes the object by setting the configuration.
	 *
	 * @return void
	 */
	public function init(): void
	{
		global $maximum_slider_conf;

		$this->set_config();

		$maximum_slider_conf = $this;
	}

	/**
	 * Sets the configuration for the object.
	 *
	 * @return void
	 */
	public function set_config(): void
	{
		$this->set_thumbnail_conf();
		$this->set_ajax_conf();
	}

	/**
	 * Sets the thumbnail configuration for the object.
	 *
	 * This method sets the size of the thumbnail for desktop and mobile devices.
	 *
	 * @return void
	 */
	public function set_thumbnail_conf(): void
	{
		$this->thumbnail = array(
			'name'   => 'maximum_slider_thumbnail',
			'width'  => 300,
            'height' => 370,
		);

		$this->thumbnail_mob = array(
            'name'   => 'maximum_slider_thumbnail_mob',
            'width'  => 240,
            'height' => 300,
        );
	}

	public function set_ajax_conf(): void
	{
		$this->ajax_prefix = 'maximum_slider_';
		$this->ajax_nonce_action = 'maximum_slider';
	}
}
