<?php

	/*
	Plugin Name: Maester Toolkit
	Plugin URI: https://www.feeha.net/
	Description: An essential toolkit plugin for Maester Theme
	Author: feehatheme
	Version: 1.0.8
	Author URI: https://feeha.net
	Requires at least: 4.5
	Tested up to: 5.2
	Text Domain: maester-toolkit
	Domain Path: /languages/
	*/


	if ( ! defined( 'ABSPATH' ) )
		exit;

	/**
	 * Defined the maester const
	 */
	define('MAESTER_VERSION', '1.0.6');
	define('MAESTER_TOOLKIT', __DIR__);
	define('MAESTER_TOOLKIT_FILE', __FILE__);


	if ( ! function_exists('maester_toolkit')) {
		function maester_toolkit(){
			$path = plugin_dir_path( MAESTER_TOOLKIT_FILE );
			$info = array(
				'pro'                   => file_exists(MAESTER_TOOLKIT.'/pro/maester-toolkit-pro.php'),
				'pro_url'               => "https://feeha.net",
				'path'                  => $path,
				'basename'              => plugin_basename( MAESTER_TOOLKIT_FILE ),
				'url'                   => plugin_dir_url( MAESTER_TOOLKIT_FILE ),
				'tutor_category'        => 'course-category',
			);
			return (object) $info;
		}
	}


	/**
	 * Load maester text domain for translation
	 */
	add_action( 'init', 'maester_language_load' );
	function maester_language_load(){
		load_plugin_textdomain( 'maester-toolkit', false, basename( dirname( __FILE__ ) ) . '/languages' );
	}


	add_action('after_setup_theme', 'load_maester_toolkit_files');

	function load_maester_toolkit_files(){
		/**
		 * Load Core Files
		 */

		require(MAESTER_TOOLKIT.'/inc/maester-toolkit-helper.php');
		require(MAESTER_TOOLKIT.'/inc/maester-toolkit-register.php');
        require(MAESTER_TOOLKIT.'/inc/maester-toolkit-options.php');
		require(MAESTER_TOOLKIT.'/inc/maester-toolkit-shortcode.php');
		require(MAESTER_TOOLKIT.'/inc/maester-toolkit-login-forms.php');
		require(MAESTER_TOOLKIT.'/inc/maester-toolkit-login.php');
		require(MAESTER_TOOLKIT.'/inc/maester-toolkit-template-functions.php');
		require(MAESTER_TOOLKIT.'/inc/maester-toolkit-taxonomy.php');

		/**
		 * Load Elementor Addons
		 */

		include_once(ABSPATH . 'wp-admin/includes/plugin.php');
		if(is_plugin_active('elementor/elementor.php') && function_exists( 'tutor')){
			require(MAESTER_TOOLKIT.'/elementor-addons/elementor.php');
		}

		if(maester_toolkit()->pro){
			require(MAESTER_TOOLKIT.'/pro/maester-toolkit-pro.php');
		}

	}
