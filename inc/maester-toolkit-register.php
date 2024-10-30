<?php



	/**
	 * Enqueue scripts and styles.
	 */
	if(!function_exists('maester_toolkit_scripts')){
		function maester_toolkit_scripts() {
			// Maester Styles
			wp_enqueue_style('maester-toolkit-main-style', plugin_dir_url(MAESTER_TOOLKIT_FILE). 'assets/css/main.css', array(), '1.0.0');

			//Maester JS
			wp_enqueue_script( 'maester-toolkit-main', plugin_dir_url(MAESTER_TOOLKIT_FILE) . 'assets/js/main.js', array('jquery'), '1.0.0', true );

		}
		add_action( 'wp_enqueue_scripts', 'maester_toolkit_scripts' );
	}

