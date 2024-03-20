<?php

namespace MaximumSlider;

class Main {
	/**
	 * Initializes the necessary components for the current object.
	 *
	 * This method initializes the assets, custom post types, and import data components
	 * that are required for the current object to function properly.
	 *
	 * @return void
	 */
	public function init(): void
	{
		$this->config->init();
		$this->thumbnail->init();
		$this->assets->init();
		$this->ajax->listen();
		$this->custom_post_types->init();
		$this->themeHooks->init();
	}

	public function __construct(
		public Config $config,
		public Thumbnail $thumbnail,
		public Assets $assets,
		public Ajax $ajax,
		public CustomPostTypes $custom_post_types,
		public ThemeHooks $themeHooks
	) {}
}
