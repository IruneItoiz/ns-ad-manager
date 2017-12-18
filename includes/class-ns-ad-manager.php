<?php

class Ns_Ad_Manager {
	/**
	 * Load the dependencies and set the hooks for the admin and
	 * public sections of the site.
	 */
	public function __construct() {
		$this->load_dependencies();
		$this->define_public_hooks();
		$this->run();
	}

	/**
	 * Load the required dependencies for this plugin.
	 */
	private function load_dependencies() {
		/**
		 * Data Models
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ad-cpt.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-utils.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ad-shortcode.php';
	}

	/**
	 * Register all hooks related to the public-facing functionality
	 */
	private function define_public_hooks() {
		add_action( 'wp_enqueue_scripts', [$this, 'enqueue_public_styles'] );
	}

	/**
	 * Enqueue public stylesheets
	 */
	public function enqueue_public_styles() {

	}

	/**
	 * Start plugin functionality
	 */
	private function run() {
		$cpt = new AdCPT;
		$cpt->init();
		$shortcode = new Ad_Shortcode;
		$shortcode->run();
	}
}
