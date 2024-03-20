<?php

namespace MaximumSlider;

use WP_Query;

class ImportData
{
	/**
	 * @var int $limit The maximum number of items allowed
	 */
	public int $limit = 15;

	/**
	 * @var string $post_type The type of post being used for the slider
	 */
	public string $post_type = 'slider';

	/**
	 * @var array $images An array of image sizes.
	 * Each element represents the file name of an image, with the extension included.
	 * The array may contain any number of elements.
	 *
	 * Example usage:
	 * $image_sizes = array( 'img.png', 'img_1.png', 'img_2.png', 'img_3.png' );
	 */
	public array $images = array( 'img.png', 'img_1.png', 'img_2.png', 'img_3.png' );

	/**
	 * Initializes the application.
	 *
	 * This method checks if the query is successful and creates a post.
	 *
	 * @return void
	 */
	public function init(): void
	{
		if ( is_admin() && $this->query() )
			$this->create_post();
	}

	/**
	 * Executes a query to check if there are any posts of the specified post type.
	 *
	 * @return bool True if no posts of the specified post type are found, false otherwise.
	 */
	public function query(): bool
	{
		$query = new WP_Query( array( 'post_type' => $this->post_type ) );
		return $query->post_count === 0;
	}

	/**
	 * Creates multiple posts of the specified post type.
	 *
	 * This method creates posts with the provided post data and sets a random thumbnail for each post.
	 *
	 * @return void
	 */
	public function create_post(): void
	{
		$post_data = array(
            'post_type' => $this->post_type,
            'post_title' => 'Maximum Slider',
            'post_content' => 'Elegant and Metropolitan, our Wynn sectional in black top grain leather with split leather back and sides will be a bold statement piece you\'ll own for many years to come. The Wynn\'s sleek and modular design lets you personally customize any configuration to fit beautifully in your home. Adjustable headrests, extra-wide armrests, and a reversible dining tray/armrest give this piece the ultimate in function and sophistication. Slide forward seats extend an extra six inches for unsurpassed comfort. Available in stock colors of black, slate, silver gray, dark teal, orange or white.',
            'post_status' => 'publish',
            'post_author' => 1,
            'post_date' => date( 'Y-m-d H:i:s' ),
            'post_date_gmt' => date( 'Y-m-d H:i:s' ),
            'post_content_filtered' => '',
            'post_parent' => 0,
            'guid' => '',
            'menu_order' => 0,
            'post_mime_type' => 'post',
            'comment_status' => 'open',
            'ping_status' => 'open',
		);

		for ( $i = 1; $i <= $this->limit; $i++ ) {
			$post_data['post_title'] = 'Room '. $i;
			$post_id = wp_insert_post( $post_data );
			$this->set_post_thumbnail( MAXIMUM_SLIDER_IMAGES_URL . $this->images[array_rand( $this->images )], $post_id );
		}
	}

	/**
	 * Sets the post thumbnail for a specified post.
	 *
	 * @param string $image_url The URL of the image to set as the post thumbnail.
	 * @param int $post_id The ID of the post to set the thumbnail for.
	 * @return void
	 */
	public function set_post_thumbnail( $image_url, $post_id  ): void
	{
		$upload_dir = wp_upload_dir();
		$image_data = file_get_contents($image_url);
		$filename = basename($image_url);
		if(wp_mkdir_p($upload_dir['path']))
		  $file = $upload_dir['path'] . '/' . $filename;
		else
		  $file = $upload_dir['basedir'] . '/' . $filename;
		file_put_contents($file, $image_data);

		$wp_filetype = wp_check_filetype($filename, null );
		$attachment = array(
			'post_mime_type' => $wp_filetype['type'],
			'post_title' => sanitize_file_name($filename),
			'post_content' => '',
			'post_status' => 'inherit'
		);
		$attach_id = wp_insert_attachment( $attachment, $file, $post_id );
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
		wp_update_attachment_metadata( $attach_id, $attach_data );
		set_post_thumbnail( $post_id, $attach_id );
	}
}
