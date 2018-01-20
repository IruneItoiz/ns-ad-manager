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
				'amp'     => '',
			],
			$atts,
			'ns-ad' );

		$parameters = $this->parse_attributes( $atts );

		//Select a random ad
		$ad = $parameters['ad_slugs'][ array_rand( $parameters['ad_slugs'] ) ];


		$ad = $this->get_ad_by_slug( $ad );

		if (!empty($ad))
		{
			$ad_content = $ad->post_content;

			if ( $parameters['is_amp'] ) {
				$ad_content = $this->build_amp_ad( $ad_content ) ;
			}

		} else {
			$ad_content = '';
		}

		return $ad_content;
	}


	private function parse_attributes( $atts ) {
		//Default values
		$parameters = [
			'is_amp'   => false,
			'ad_slugs' => [],
		];

		if ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) {
			$parameters['is_amp'] = true;
			$slugs                = explode( ',', $atts['amp'] );
		} else {
			$slugs = explode( ',', $atts['regular'] );
		}

		if ( is_array( $slugs ) ) {
			foreach ( $slugs as $value ) {
				if ( '' !== $value ) {
					$parameters['ad_slugs'][] = trim( $value );
				}

			}
		}

		return $parameters;
	}

	private function get_ad_by_slug( $slug ) {

		$query =  new WP_Query( array
		(
			'name'   => $slug,
			'post_type'   => 'ns-ad',
			'numberposts' => 1,
		) );

		$posts = $query->get_posts();

		return array_shift($posts);

	}

	private function build_amp_ad( $original ) {
		preg_match( "/data-ad-client=\"(.*)\"/", $original , $results );
		$client_id = $results[1];

		preg_match( "/data-ad-slot=\"(.*)\"/", $original , $results );
		$ad_slot = $results[1];

		$amp_code = '
        <div class="amp-ad-wrapper">
            <amp-ad class="amp-ad-4"
            type="adsense"
            width=336 height=280
            data-ad-client="'.$client_id .'"
            data-ad-slot="'.$ad_slot.'"></amp-ad>
        </div>
        ';
		return $amp_code;
	}

	public function run() {
		add_shortcode( 'ns-ad', array( $this, 'show_ad' ) );
	}
}
