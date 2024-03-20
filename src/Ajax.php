<?php
namespace MaximumSlider;

defined( 'ABSPATH' ) || exit;

/**
 * Manage Ajax actions
 */
class Ajax
{

	/**
	 * Ajax request handler
	 * Handles ajax requests by calling the appropriate method based on the action
	 *
	 * @param string $action The action to be performed
	 *
	 * @return void
	 */
	private $ajax;

	public object $slider_conf;

	public function __construct()
	{
		$this->ajax = new AjaxManager();
	}

	/**
	 * Ajax request prefix For action
	 * Example: Use maximum_slider_my_function
	 * For call my_function method in this class
	 * @var string
	 */
	private $prefix = 'maximum_slider_';

	/**
	 * Listen to wordpress ajax with prefix 'maximum_slider' and trigger suffix method
	 * @throws ReflectionException
	 */
    public function listen()
	{
		global $maximum_slider_conf;
		$this->slider_conf = $maximum_slider_conf;

		if ( defined('DOING_AJAX') && DOING_AJAX ) {
			$this->prefix = $this->slider_conf->ajax_prefix;
			$action 	= sanitize_text_field( $_REQUEST['action'] );
			$methodName = str_replace( $this->prefix, '', $action );
			if(
				strpos( $action, $this->prefix ) === 0
				&&
				method_exists( $this, $methodName )
			){
				add_action( 'wp_ajax_' . $action, array( $this, $methodName ) );
				$method = new \ReflectionMethod( $this, $methodName );
				$params = $method->getParameters();
				if( $params ){
					$public = $params[0];
					if(
						$public->isOptional()
						&&
						$public->getDefaultValue()
					){
						add_action( 'wp_ajax_nopriv_' . $action, array( $this, $methodName ) );
					}
				}
			}
		}
	}

    /**
     * Send json result
     * @return array if request not ajax send $this
     */
	public function send()
	{
	    return $this->ajax->send();
    }

    /**
     * Set success with successful message
     * @param  string $message Successfully message
     * @return AjaxManager
     */
    public function success( $message = '', $httcode = 200 )
	{
        return $this->ajax->success( $message, $httcode );
    }

    /**
     * Set error with failed message
     * @param  string $message Failed message
     * @return AjaxManager
     */
    public function error( $message = '', $error_code = 'error', $http_code = 400 )
	{
        return $this->ajax->error( $message, $error_code, $http_code );
    }

    /**
     * Set extra data for ajax result
     * @param string $key extra data key
     * @param mixed $value extra data value
     * @return AjaxManager
     */
    public function set( $key, $value )
	{
        return $this->ajax->set( $key, $value );
    }

    /**
     * Send ajax error when nonce invalid with action
     * @param $nonce nonce hashed value
     * @param $action action that nonce create by that
     * @param bool $message message on invalid nonce
     */
    public function on_invalid_nonce( $nonce, $action, $message = false )
	{
        $this->ajax->on_invalid_nonce( $nonce, $action, $message );
    }

	public function slide_click( $public = true )
	{
		$nonce = sanitize_text_field( $_REQUEST['nonce'] );

		$this->on_invalid_nonce( $nonce, $this->slider_conf->ajax_nonce_action, true );

		try {
			$id = sanitize_text_field( $_REQUEST['id'] );

			if ( $post = get_post( $id ) ) {
				$this->ajax->set( 'success', true );
				$this->ajax->set( 'http_code', 200 );
				$this->ajax->set( 'message', 'success' );
				$this->ajax->set( 'title', $post->post_title );
				$this->ajax->set( 'content', $post->post_content );
			}

		} catch ( \ReflectionException $e ) {
			$this->ajax->error( $e->getMessage() );
		}

		$this->send();
	}


}
