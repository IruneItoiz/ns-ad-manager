<?php
/**
 * Plugin Name: Northset Ad Manager
 * Plugin URI: https://www.northset.com/projects/ns-ad-manager/
 * Description: Ad Management for desktop and AMP
 * Version: 1.0.0
 * Author: Northset
 * Author URI: https://www.northset.com/
 */

// Exit if this file is called directly
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once __DIR__ . '/includes/class-ns-ad-manager.php';

$ns_ad_manager = new Ns_Ad_Manager;
