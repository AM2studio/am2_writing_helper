<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    AM2_Writing_Helper
 * @subpackage AM2_Writing_Helper/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    AM2_Writing_Helper
 * @subpackage AM2_Writing_Helper/public
 * @author     Your Name <email@example.com>
 */
class AM2_Writing_Helper_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $am2_writing_helper    The ID of this plugin.
	 */
	private $am2_writing_helper;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $am2_writing_helper       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $am2_writing_helper, $version ) {

		$this->am2_writing_helper = $am2_writing_helper;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in AM2_Writing_Helper_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The AM2_Writing_Helper_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->am2_writing_helper, plugin_dir_url( __FILE__ ) . 'css/am2-writing-helper-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in AM2_Writing_Helper_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The AM2_Writing_Helper_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->am2_writing_helper, plugin_dir_url( __FILE__ ) . 'js/am2-writing-helper-public.js', array( 'jquery' ), $this->version, false );

	}

}
