<?php

/***
 * CPT For Ads
 *
 **/

class AdCPT {

	public function init() {
		$this->hooks();
	}

	public function hooks() {
		add_action( 'init', array( $this, 'create' ) );
		add_filter( 'user_can_richedit', array( $this, 'disable_for_cpt' ) );
	}

	public function create() {
		register_post_type(
			'ns-ad', array(
				'labels'                => array(
					'name'               => __( 'Ads', 'ns-ad-manager' ),
					'singular_name'      => __( 'Ad', 'ns-ad-manager' ),
					'all_items'          => __( 'All Ads', 'ns-ad-manager' ),
					'new_item'           => __( 'New Ad', 'ns-ad-manager' ),
					'add_new'            => __( 'Add New', 'ns-ad-manager' ),
					'add_new_item'       => __( 'Add New Ad', 'ns-ad-manager' ),
					'edit_item'          => __( 'Edit Ad', 'ns-ad-manager' ),
					'view_item'          => __( 'View Ad', 'ns-ad-manager' ),
					'search_items'       => __( 'Search Ads', 'ns-ad-manager' ),
					'not_found'          => __( 'No Ads found', 'ns-ad-manager' ),
					'not_found_in_trash' => __( 'No Ads found in trash', 'ns-ad-manager' ),
					'parent_item_colon'  => __( 'Parent Ad', 'ns-ad-manager' ),
					'menu_name'          => __( 'Ads', 'ns-ad-manager' ),
				),
				'public'                => false,
				'hierarchical'          => false,
				'show_ui'               => true,
				'show_in_nav_menus'     => false,
				'supports'              => array( 'title', 'editor', 'thumbnail', 'author', 'revisions' ),
				'has_archive'           => false,
				'rewrite'               => false,
				'query_var'             => false,
				'menu_icon'             => 'dashicons-groups',
				'show_in_rest'          => true,
				'rest_base'             => 'ns-ad',
				'rest_controller_class' => 'WP_REST_Posts_Controller',
			)
		);
	}

	function disable_for_cpt( $default ) {
		global $post;

		if ( 'ns-ad' == get_post_type( $post ) )
			return false;

		return $default;
	}
}