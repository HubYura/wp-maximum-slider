<?php
namespace MaximumSlider;

use WpUtm\AssetsRegistration;

class Assets {
	public function init() {
		$this->ar->register_assets();

		\add_action( 'enqueue_block_assets', array( $this, 'enqueue_scripts_and_styles' ) );
		\add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_scripts_and_styles' ) );
	}

	public function __construct(
		public AssetsRegistration $ar,
	) {}

	public function enqueue_scripts_and_styles() {
		global $maximum_slider_conf;

		\wp_enqueue_style( 'maximum-slider-common' );
		\wp_enqueue_script( 'maximum-slider-script' );

		wp_localize_script( 'maximum-slider-script', 'maximum_slider_ajax_object', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( $maximum_slider_conf->ajax_nonce_action ),
		));
	}

}
