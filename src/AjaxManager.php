<?php
namespace MaximumSlider;

/**
 * Class AjaxManager
 */
class AjaxManager
{

    /**
	 * Data in array
	 * @var array
	 */
	private $data = [

		/**
		 * Success Status
		 */
		'success'	=> false,

		/**
		 * Response message on error or success
		 */
		'message'	=> '',

		/**
		 * Http response code
		 */
		'http_code'	=> 400,
	];

	private function set_debug_trace()
	{
		if( current_user_can( 'manage_options' ) && defined('WP_DEBUG') && WP_DEBUG ){
			$this->data['debug'] =  debug_backtrace();
		}
	}


	/**
	 * Set success with successful message
	 * @param  string $message Successfuly message
	 * @return AjaxManager
	 */
	public function success( $message = '', $http_code = 200 )
	{
		$this->data['success']		= true;
		$this->data['message'] 		= $message;
		$this->data['http_code'] 	= $http_code;
		return $this;
	}

	/**
	 * Set error with failed message
	 * @param  string $message Failed message
	 * @return AjaxManager
	 */
	public function error( $message = '', $error_code = 'error', $http_code = 400 )
	{
		$this->success 				= 0;
		$this->data['message'] 		= $message;
		$this->data['code'] 		= $error_code;
		$this->data['http_code'] 	= $http_code;
		return $this;
	}

    /**
     * Set extra data for ajax result
     * @param string $key extra data key
     * @param mixed $value extra data value
     * @return AjaxManager
     */
	public function set( $key, $value )
	{
		$this->data[$key] = $value;
		return $this;
	}

    /**
     * Send ajax error when nonce invalid with action
     * @param string $nonce nonce hashed value
     * @param string $action action that nonce create by that
     * @param bool $message message on invalid nonce
     */
    public function on_invalid_nonce(string $nonce, string $action, bool $message = false ): void
	{
        if(
        ! wp_verify_nonce( $nonce, $action )
        ){
            $errorMessage = '';

            if( $message ){
                $errorMessage = $message;
            }

            $this->error( $errorMessage, 'token_error', 403 )->send();

        }

    }

	/**
	 * Send result as Json
	 * @return array if request not ajax send $this
	 */
	public function send()
	{
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			wp_send_json( $this->data, $this->data['http_code'] );
		}

		return $this->data;

	}
}
