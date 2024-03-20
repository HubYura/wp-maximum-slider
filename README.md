# Maximum Slider

## Demo

https://maximum-slider.test.te.ua/

## Description

Maximum Slider is a powerful WordPress plugin that enhances your website with a fully customizable slider feature.

## Installation

- Upload `maximum-slider.zip` to `/wp-content/plugins/`.
- Unzip the file and rename the folder to `maximum-slider`.
- Login to WordPress admin and go to Plugins menu.
- Locate "Maximum Slider" in the list and click "Activate".
- Use Composer to install the plugin dependencies by running `composer install` in the plugin directory.
```
composer install
```
- Install necessary npm packages by running `npm install` in the plugin directory.
```
npm install
```
```
npm run start
```

## Usage

To add a slider to your page, insert the hook in code:

```
<?php do_action('test_theme_content'); ?>
```

If you need to regenerate a thumbnail, you can use the Regenerate Thumbnails plugin. Firstly, [install and activate the plugin](https://kinsta.com/blog/regenerate-thumbnails/#:~:text=To%20start%2C-,install%20and%20activate,-the%20Regenerate%20thumbnails). Once the plugin is activated, navigate to `Tools > Regenerate Thumbnails` in your WordPress admin area to use the functionality.

## Reference


- [WP Utilitatem](https://github.com/crosslink-ch/wp-utilitatem)

## Support

For support, please visit the [WP Utilitatem](https://github.com/crosslink-ch/wp-utilitatem) repository.
