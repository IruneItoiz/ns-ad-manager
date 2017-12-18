<?php

class Ad_Shortcode {

	function __construct() {

	}

	/**
	 * Pick the right ad to show and show it
	 */
	public function show_ad( $atts ) {

		//Pick up the parameters
		$atts = shortcode_atts(
			[
				'regular' => '',
				'amp' => '',
			],
			$atts,
			'ns-ad' );

		$parameters = $this->parse_attributes( $atts );
	}


	private function parse_attributes( $atts )
	{
		//Default values
		$parameters = [
			'is_amp' => false,
			'ad_slugs' => [],
		];

		if ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) {
			$parameters['is_amp'] = true;
			$slugs = explode(',',$atts['amp']);
		} else {
			$slugs = explode(',',$atts['regular']);
		}

		if (is_array($slugs)) {
			foreach ($slugs as $value)
			{
				if ('' !== $value)
				{
					$parameters['ad_slugs'][] = trim($value);
				}

			}
		}

		var_dump($parameters);exit;
	}

	public function run() {
		add_shortcode( 'ns-ad', array( $this, 'show_ad' ) );
	}
}
