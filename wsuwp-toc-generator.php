<?php
/*
Plugin Name: WSUWP Table of Contents Generator
Version: 0.1.0
Plugin URI: http://web.wsu.edu
Description: Generates a DOM element containing the table of contents for a long page.
Author: washingtonstateuniversity, jeremyfelt
Author URI: http://web.wsu.edu
*/

class WSUWP_TOC_Generator {

	/**
	 * @var string Current version of this plugin.
	 */
	var $plugin_version = '0.1.0';

	/**
	 * Setup hooks.
	 */
	public function __construct() {
		add_filter( 'wsuwp_generate_toc', array( $this, 'generate_toc' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Determine whether TOC generation should occur on this page view.
	 *
	 * @return bool True if yes. False if no.
	 */
	public function generate_toc() {
		if ( is_page() ) {
			return true;
		}

		return false;
	}

	/**
	 * Enqueue the scripts used by the plugin.
	 */
	public function enqueue_scripts() {
		if ( apply_filters( 'wsuwp_generate_toc', false ) ) {
			wp_enqueue_style( 'wsuwp-toc-generator-css', plugins_url( 'css/wsuwp-toc-generator.css', __FILE__ ), array(), $this->plugin_version );

			wp_enqueue_script( 'toc-jquery', plugins_url( 'js/toc.min.js', __FILE__ ), array( 'jquery' ), $this->plugin_version, true );
			wp_enqueue_script( 'wsuwp-toc-generator', plugins_url( 'js/wsuwp-toc-generator.js', __FILE__ ), array( 'toc-jquery', 'jquery' ), $this->plugin_version, true );
		}
	}
}
new WSUWP_TOC_Generator();