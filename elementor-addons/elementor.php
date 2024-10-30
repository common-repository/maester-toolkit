<?php

if (!did_action( 'elementor/loaded') ||  ! defined( 'ABSPATH' )) {
    exit;
}

// function maester_elementor_init(){
//     Elementor\Plugin::instance()->elements_manager->add_category(
//         'maester-ecat',
//         [
//             'title'  => 'Maester Elements',
//             'icon' => 'fa fa-link'
//         ],
//         0
//     );
// }
// add_action('elementor/init','maester_elementor_init');



function add_elementor_widget_categories($elements_manager) {
    $elements_manager->add_category(
        'maester-ecat',
        [
            'title'  => 'Maester Elements',
            'icon' => 'fa fa-link'
        ]
    );
}
add_action('elementor/elements/categories_registered', 'add_elementor_widget_categories');



function load_elementor_addons(){
    require_once plugin_dir_path( __FILE__ ).'maester-category.php';
    require_once plugin_dir_path( __FILE__ ).'maester-courses.php';
}
add_action('elementor/widgets/widgets_registered','load_elementor_addons');