<?php

/**
 * Plugin Name: Maximum Slider
 * Description:
 * Requires at least: 6.1
 * Requires PHP: 8.1
 * Version: 1.0.0
 * Author:
 * Text Domain: maximum-slider
 */

/**
 * define plugin constants
 */
define( 'MAXIMUM_SLIDER_PLUGIN_FILE', __FILE__ );
define( 'MAXIMUM_SLIDER_PLUGIN_DIR', dirname( __FILE__ ) );
define( 'MAXIMUM_SLIDER_URL', plugin_dir_url( __FILE__ ) );
define( 'MAXIMUM_SLIDER_ASSETS_URL', MAXIMUM_SLIDER_URL . 'assets/' );
define( 'MAXIMUM_SLIDER_CSS_URL', MAXIMUM_SLIDER_URL . 'assets/css/' );
define( 'MAXIMUM_SLIDER_JS_URL', MAXIMUM_SLIDER_URL . 'assets/js/' );
define( 'MAXIMUM_SLIDER_IMAGES_URL', MAXIMUM_SLIDER_URL . 'assets/images/' );

/**
 * global plugin
 *
 * @global object $maximum_slider_conf
 */
global $maximum_slider_conf;

/**
 * Autoload
 */
require 'vendor/autoload.php';

/**
 * Loads the textdomain for the Maximum Slider plugin.
 *
 * This function is responsible for loading the translation files for the Maximum Slider plugin based on the user's locale.
 * It first checks if there is a translation file specific to the current locale in the global translation directory.
 * If the translation file exists, it loads the textdomain using the file.
 * If the translation file does not exist, it loads the textdomain using the translation files in the plugin directory.
 *
 * @return void
 * @global string $wp_version The WordPress version.
 *
 */
function maximum_slider_get_load_textdomain() {

	global $wp_version;

	$maximum_slider_lang_dir = apply_filters( 'maximum_slider_languages_directory', MAXIMUM_SLIDER_PLUGIN_DIR . '/languages/' );

	$get_locale = get_locale();

	if ( $wp_version >= 4.7 ) {
		$get_locale = get_user_locale();
	}

	$locale = apply_filters( 'plugin_locale',  $get_locale, 'maximum_slider' );
	$mo_file = sprintf( '%1$s-%2$s.mo', 'maximum_slider', $locale );

	$mo_file_global  = WP_LANG_DIR . '/plugins/' . basename( MAXIMUM_SLIDER_PLUGIN_DIR ) . '/' . $mo_file;

	if ( file_exists( $mo_file_global ) ) {
		load_textdomain( 'maximum_slider', $mo_file_global );
	} else {
		load_plugin_textdomain( 'maximum_slider', false, $maximum_slider_lang_dir );
	}
}

/**
 * Do stuff once all the plugin has been loaded
 *
 */
function maximum_slider_get_plugins_loaded() {
	maximum_slider_get_load_textdomain();
}
add_action('plugins_loaded', 'maximum_slider_get_plugins_loaded');

/**
 * Initializes the Maximum Slider plugin.
 *
 * This method creates an instance of the `\WpUtm\Main` class using the provided
 * definitions. The definitions include the dynamic CSS and JS classes, the main file,
 * the plugin type, and the prefix. After creating the instance, the `init` method
 * of the `\MaximumSlider\Main` class is called to initialize the plugin.
 *
 * @return void
 */
function maximum_slider_init() {
	$wputm = new \WpUtm\Main(
		array(
			'definitions' => array(
				\WpUtm\Interfaces\IDynamicCss::class => \DI\autowire( \MaximumSlider\DynamicCss::class ),
				\WpUtm\Interfaces\IDynamicJs::class  => \DI\autowire( \MaximumSlider\DynamicJs::class ),
				'main_file'                          => MAXIMUM_SLIDER_PLUGIN_FILE,
				'type'                               => 'plugin',
				'prefix'                             => 'maximum-slider',
			),
		)
	);

	$wputm->get( \MaximumSlider\Main::class )->init();
}

maximum_slider_init();
