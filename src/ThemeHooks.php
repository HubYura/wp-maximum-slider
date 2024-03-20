<?php

namespace MaximumSlider;

class ThemeHooks
{
	public function init(): void
	{
		add_action('test_theme_content', [$this, 'render_slider']);
	}

	public function render_slider(): void
	{
		$slider = new Slider();
		echo $slider->render();
	}
}
