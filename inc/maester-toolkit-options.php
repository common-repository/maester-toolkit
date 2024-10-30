<?php



if(!function_exists('maester_theme_options')){
    add_action('init', 'maester_theme_options');
    function maester_theme_options () {
        $config_id = 'maester_options';
        if(class_exists('Kirki')){

            Kirki::add_config( $config_id, array(
                'capability'    => 'edit_theme_options',
                'option_type'   => 'theme_mod'
            ));
            Kirki::add_panel( 'maester_options_panel', array(
                'priority'    => 10,
                'title'       => esc_html__( 'Maester Settings', 'maester-toolkit' ),
                'description' => esc_html__( 'Maester Theme Customization Options', 'maester-toolkit' ),
            ));

            /**
             * Top Bar Options
             */

            Kirki::add_section( 'maester_topbar_options', array(
                'title'          => esc_html__( 'Top Bar', 'maester-toolkit' ),
                'description'    => esc_html__( 'Top Bar Settings.', 'maester-toolkit' ),
                'panel'          => 'maester_options_panel',
                'priority'       => 160,
            ) );

            Kirki::add_field( $config_id, array(
                'type'        => 'toggle',
                'settings'    => 'enable_topbar',
                'label'       => esc_html__( 'Top Bar Enable/Disable', 'maester-toolkit' ),
                'section'     => 'maester_topbar_options',
                'default'     => '1',
                'priority'    => 10,
            ) );

            Kirki::add_field( $config_id, array(
                'type'     => 'text',
                'settings' => 'topbar_text',
                'label'    => esc_html__( 'Header Top Text', 'maester-toolkit' ),
                'section'  => 'maester_topbar_options',
                'default'  => esc_html__( 'Maester | Multipurpose WordPress LMS Theme with Elementor Page Builder', 'maester-toolkit' ),
                'priority' => 10,
                'partial_refresh'    => array(
                    'topbar_text' => array(
                        'selector'        => '.top-bar-description',
                        'render_callback' => function() {
                            return get_theme_mod('topbar_text');
                        },
                    )
                ),
            ));

            Kirki::add_field( $config_id, array(
                'type'        => 'select',
                'settings'    => 'topbar_custom_links',
                'label'       => esc_html__( 'Menu Custom Links', 'maester-toolkit' ),
                'section'     => 'maester_topbar_options',
                'default'     => array('login', 'profile', 'logout' ),
                'priority'    => 10,
                'multiple'    => 999,
                'choices'     => array(
                    'search' => esc_html__( 'Search Icon', 'maester-toolkit' ),
                    'login' => esc_html__( 'Login Link', 'maester-toolkit' ),
                    'profile' => esc_html__( 'Profile Link', 'maester-toolkit' ),
                    'logout' => esc_html__( 'Sign Out Link', 'maester-toolkit' ),
                ),
            ));

            Kirki::add_field( $config_id, array(
                'type'        => 'repeater',
                'label'       => esc_html__( 'Top Bar Social Icons', 'maester-toolkit' ),
                'section'     => 'maester_topbar_options',
                'priority'    => 10,
                'row_label' => array(
                    'type'  => 'text',
                    'value' => esc_html__('Social Icon: ', 'maester-toolkit' ),
                ),
                'button_label' => esc_html__('Add New Soical Icon', 'maester-toolkit' ),
                'settings'     => 'topbar_social',
                'default'      => array(),
                'fields' => array(
                    'topbar_social_icon'  => array(
                        'type'        => 'text',
                        'label'       => esc_html__( 'Icon Class Name', 'maester-toolkit' ),
                        'description' => sprintf('<a target="_blank" href="%s">%s</a> %s <br><span style="color: green">%s</span>', esc_url('https://fontawesome.com/cheatsheet/'), __('Click Here', 'maester-toolkit'), __('to get icons list', 'maester-toolkit'), __('Note: Use prefix `fab` for brand, `far` for regular, `fas` for solid icons', 'maester-toolkit')),
                        'default'     => 'fab fa-facebook',
                    ),
                    'topbar_social_link'  => array(
                        'type'        => 'link',
                        'label'       => esc_html__( 'Icon URL', 'maester-toolkit' ),
                        'description' => __( 'Example: <span style="color: green;">https://fb.com/your_user_name</span>', 'maester-toolkit' ),
                        'default'     => '#',
                    ),
                    'topbar_social_link_target' => array(
                        'type'        => 'radio',
                        'label'       => esc_html__( 'Link target', 'maester-toolkit' ),
                        'default'     => '_self',
                        'priority'    => 10,
                        'choices'     => array(
                            '_blank'   => esc_html__( 'Open in new tab', 'maester-toolkit' ),
                            '_self' => __( 'Don\'t open in new tab', 'maester-toolkit' )
                        ),
                    )
                )
            ) );

            do_action('optons/maester_topbar_options', $config_id);


            /**
             * Header Options
             */

            Kirki::add_section( 'maester_header_options', array(
                'title'          => esc_html__( 'Header & Menu Bar', 'maester-toolkit' ),
                'description'    => esc_html__( 'Header Settings.', 'maester-toolkit' ),
                'panel'          => 'maester_options_panel',
                'priority'       => 160,
            ) );


            Kirki::add_field( $config_id, array(
                'type'        => 'toggle',
                'settings'    => 'maester_en_menubar',
                'label'       => esc_html__( 'Enable Menubar', 'maester-toolkit' ),
                'section'     => 'maester_header_options',
                'default'     => '1',
                'priority'    => 10
            ) );

            Kirki::add_field( $config_id, array(
                'type'        => 'toggle',
                'settings'    => 'enable_header_search',
                'label'       => esc_html__( 'Header Search Enable/Disable', 'maester-toolkit' ),
                'section'     => 'maester_header_options',
                'default'     => '1',
                'priority'    => 10,
                'partial_refresh'    => array(
                    'enable_header_search' => array(
                        'selector'        => '.custom-search-form-column',
                        'render_callback' => function() {
                            return get_theme_mod('enable_header_search');
                        },
                    )
                ),
            ));

            Kirki::add_field( $config_id, array(
                'type'        => 'select',
                'settings'    => 'header_search_post_types',
                'label'       => esc_html__( 'Header Search Post Types', 'maester-toolkit' ),
                'section'     => 'maester_header_options',
                'default'     => 'post',
                'priority'    => 10,
                'multiple'    => 0,
                'choices'     => maester_toolkit_search_post_types()
            ));

            Kirki::add_field( $config_id, array(
                'type'        => 'toggle',
                'settings'    => 'enable_header_cart',
                'label'       => esc_html__( 'Enable Menubar Cart', 'maester-toolkit' ),
                'description' => __("NB: WooCommerce must be installed to see the cart icon", 'maester-toolkit'),
                'section'     => 'maester_header_options',
                'default'     => '1',
                'priority'    => 10,
                'partial_refresh'    => array(
                    'enable_header_cart' => array(
                        'selector'        => '.header-cart-menu',
                        'render_callback' => function() {
                            return get_theme_mod('enable_header_cart');
                        },
                    )
                ),
            ) );

            Kirki::add_field( $config_id, array(
                'type'        => 'toggle',
                'settings'    => 'enable_menubar_search_icon',
                'label'       => esc_html__( 'Enable Menubar Search Icon', 'maester-toolkit' ),
                'section'     => 'maester_header_options',
                'default'     => '1',
                'priority'    => 10,
                'partial_refresh'    => array(
                    'enable_menubar_search_icon' => array(
                        'selector'        => '.menubar-search-icon',
                        'render_callback' => function() {
                            return get_theme_mod('enable_menubar_search_icon');
                        },
                    )
                ),
            ));

            Kirki::add_field( $config_id, array(
                'type'        => 'toggle',
                'settings'    => 'enable_header_login_icon',
                'label'       => esc_html__( 'Enable Menubar Login Icon', 'maester-toolkit' ),
                'section'     => 'maester_header_options',
                'default'     => '1',
                'priority'    => 10,
                'partial_refresh'    => array(
                    'enable_header_login_icon' => array(
                        'selector'        => '.menubar-login-icon',
                        'render_callback' => function() {
                            return get_theme_mod('enable_header_login_icon');
                        },
                    )
                ),
            ) );

            Kirki::add_field( $config_id, array(
                'type'        => 'repeater',
                'label'       => esc_html__( 'Menu Bar Social Icons', 'maester-toolkit' ),
                'section'     => 'maester_header_options',
                'priority'    => 10,
                'row_label' => array(
                    'type'  => 'text',
                    'value' => esc_html__('Social Icon: ', 'maester-toolkit' ),
                ),
                'button_label' => esc_html__('Add New Soical Icon', 'maester-toolkit' ),
                'settings'     => 'menubar_social',
                'default'      => array(),
                'fields' => array(
                    'menubar_social_icon'  => array(
                        'type'        => 'text',
                        'label'       => esc_html__( 'Icon Class Name', 'maester-toolkit' ),
                        'description' => sprintf('<a target="_blank" href="%s">%s</a> %s <br><span style="color: green">%s</span>', esc_url('https://fontawesome.com/cheatsheet/'), __('Click Here', 'maester-toolkit'), __('to get icons list', 'maester-toolkit'), __('Note: Use prefix `fab` for brand, `far` for regular, `fas` for solid icons', 'maester-toolkit')),
                        'default'     => 'fab fa-facebook',
                    ),
                    'menubar_social_link'  => array(
                        'type'        => 'link',
                        'label'       => esc_html__( 'Icon URL', 'maester-toolkit' ),
                        'description' => __( 'Example: <span style="color: green;">https://fb.com/your_user_name</span>', 'maester-toolkit' ),
                        'default'     => '#',
                    ),
                    'menubar_social_link_target' => array(
                        'type'        => 'radio',
                        'label'       => esc_html__( 'Link target', 'maester-toolkit' ),
                        'default'     => '_self',
                        'priority'    => 10,
                        'choices'     => array(
                            '_blank'   => esc_html__( 'Open in new tab', 'maester-toolkit' ),
                            '_self' => __( 'Don\'t open in new tab', 'maester-toolkit' )
                        ),
                    )
                )
            ) );

            do_action('optons/maester_header_options', $config_id);

            /**
             * Blog Options
             */

            Kirki::add_section( 'maester_blog_options', array(
                'title'          => esc_html__( 'Blog Settings', 'maester-toolkit' ),
                'panel'          => 'maester_options_panel',
                'priority'       => 160,
            ) );

            Kirki::add_field( $config_id, array(
                'type'        => 'select',
                'settings'    => 'post_column_count',
                'label'       => esc_html__( 'Post Column', 'maester-toolkit' ),
                'tooltip'       => esc_html__( 'Choose how many post want to show in one row', 'maester-toolkit' ),
                'section'     => 'maester_blog_options',
                'default'     => '6',
                'priority'    => 10,
                'multiple'    => 0,
                'choices'     => array(
                    '12' => esc_html__( 'One Column', 'maester-toolkit' ),
                    '6' => esc_html__( 'Two Column', 'maester-toolkit' ),
                    '4' => esc_html__( 'Three Column', 'maester-toolkit' ),
                    '3' => esc_html__( 'Four Column', 'maester-toolkit' ),
                ),
            ));
            //maester_excerpt_length


            Kirki::add_field( $config_id, [
                'type'        => 'number',
                'settings'    => 'maester_excerpt_length',
                'label'       => esc_html__( 'Blog content/excerpt length', 'maester-toolkit' ),
                'section'     => 'maester_blog_options',
                'default'     => 25
            ] );


            Kirki::add_field( $config_id, array(
                'type'        => 'toggle',
                'settings'    => 'enable_blog_thumbnail',
                'label'       => esc_html__( 'Enable Blog Thumbnail', 'maester-toolkit' ),
                'section'     => 'maester_blog_options',
                'default'     => '1',
                'priority'    => 10,
            ) );

            Kirki::add_field( $config_id, array(
                'type'        => 'toggle',
                'settings'    => 'enable_blog_category',
                'label'       => esc_html__( 'Enable Blog Category', 'maester-toolkit' ),
                'section'     => 'maester_blog_options',
                'default'     => '1',
                'priority'    => 10,
            ) );

            Kirki::add_field( $config_id, array(
                'type'        => 'toggle',
                'settings'    => 'enable_blog_content',
                'label'       => esc_html__( 'Enable Blog Content', 'maester-toolkit' ),
                'section'     => 'maester_blog_options',
                'default'     => '1',
                'priority'    => 10,
            ) );

            /*Kirki::add_field( $config_id, array(
                'type'        => 'toggle',
                'settings'    => 'enable_blog_readmore',
                'label'       => esc_html__( 'Enable Blog Readmore', 'maester-toolkit' ),
                'section'     => 'maester_blog_options',
                'default'     => '0',
                'priority'    => 10,
            ) );*/

            Kirki::add_field( $config_id, array(
                'type'        => 'toggle',
                'settings'    => 'enable_blog_author',
                'label'       => esc_html__( 'Enable Blog author', 'maester-toolkit' ),
                'section'     => 'maester_blog_options',
                'default'     => '1',
                'priority'    => 10,
            ) );

            Kirki::add_field( $config_id, array(
                'type'        => 'toggle',
                'settings'    => 'enable_blog_date',
                'label'       => esc_html__( 'Enable Blog Date', 'maester-toolkit' ),
                'section'     => 'maester_blog_options',
                'default'     => '1',
                'priority'    => 10,
            ) );

            do_action('optons/maester_blog_options', $config_id);


            /**
             * Single Blog Options
             */

            Kirki::add_section( 'maester_single_blog_options', array(
                'title'          => esc_html__( 'Single Blog Settings', 'maester-toolkit' ),
                'panel'          => 'maester_options_panel',
                'priority'       => 160,
            ) );


            Kirki::add_field( $config_id, array(
                'type'        => 'toggle',
                'settings'    => 'enable_single_blog_date',
                'label'       => esc_html__( 'Enable Single Blog Date', 'maester-toolkit' ),
                'section'     => 'maester_single_blog_options',
                'default'     => '1',
                'priority'    => 10,
            ) );


            Kirki::add_field( $config_id, array(
                'type'        => 'toggle',
                'settings'    => 'enable_single_blog_author',
                'label'       => esc_html__( 'Enable Single Blog Author', 'maester-toolkit' ),
                'section'     => 'maester_single_blog_options',
                'default'     => '1',
                'priority'    => 10,
            ) );

            Kirki::add_field( $config_id, array(
                'type'        => 'toggle',
                'settings'    => 'enable_single_blog_comment_number',
                'label'       => esc_html__( 'Enable Single Blog Comment Number', 'maester-toolkit' ),
                'section'     => 'maester_single_blog_options',
                'default'     => '1',
                'priority'    => 10,
            ) );

            Kirki::add_field( $config_id, array(
                'type'        => 'toggle',
                'settings'    => 'enable_single_blog_category',
                'label'       => esc_html__( 'Enable Single Blog Category', 'maester-toolkit' ),
                'section'     => 'maester_single_blog_options',
                'default'     => '1',
                'priority'    => 10,
            ) );


            Kirki::add_field( $config_id, array(
                'type'        => 'toggle',
                'settings'    => 'enable_single_blog_tag',
                'label'       => esc_html__( 'Enable Single Blog Tag', 'maester-toolkit' ),
                'section'     => 'maester_single_blog_options',
                'default'     => '1',
                'priority'    => 10,
            ) );

            Kirki::add_field( $config_id, array(
                'type'        => 'toggle',
                'settings'    => 'enable_single_blog_navigation',
                'label'       => esc_html__( 'Enable Single Blog Navigation', 'maester-toolkit' ),
                'section'     => 'maester_single_blog_options',
                'default'     => '1',
                'priority'    => 10,
            ) );

            Kirki::add_field( $config_id, array(
                'type'        => 'toggle',
                'settings'    => 'enable_single_blog_comments',
                'label'       => esc_html__( 'Enable Single Blog Comments', 'maester-toolkit' ),
                'section'     => 'maester_single_blog_options',
                'default'     => '1',
                'priority'    => 10,
            ) );

            do_action('optons/maester_single_blog_options', $config_id);

            /**
             * Sidebar Options
             */

            Kirki::add_section( 'maester_sidebar_options', array(
                'title'          => esc_html__( 'Sidebar Settings', 'maester-toolkit' ),
                'panel'          => 'maester_options_panel',
                'priority'       => 160,
            ));

            Kirki::add_field( $config_id, array(
                'type'        => 'toggle',
                'settings'    => 'enable_blog_sidebar',
                'label'       => esc_html__( 'Enable Blog Sidebar', 'maester-toolkit' ),
                'section'     => 'maester_sidebar_options',
                'default'     => '1',
                'priority'    => 10,
            ) );

            Kirki::add_field( $config_id, array(
                'type'        => 'toggle',
                'settings'    => 'enable_single_blog_sidebar',
                'label'       => esc_html__( 'Enable Single Blog Sidebar', 'maester-toolkit' ),
                'section'     => 'maester_sidebar_options',
                'default'     => '1',
                'priority'    => 10,
            ));

            Kirki::add_field( $config_id, array(
                'type'        => 'toggle',
                'settings'    => 'enable_archive_sidebar',
                'label'       => esc_html__( 'Enable Archive Sidebar', 'maester-toolkit' ),
                'section'     => 'maester_sidebar_options',
                'default'     => '1',
                'priority'    => 10,
            ));

            Kirki::add_field( $config_id, array(
                'type'        => 'toggle',
                'settings'    => 'enable_search_sidebar',
                'label'       => esc_html__( 'Enable Search Sidebar', 'maester-toolkit' ),
                'section'     => 'maester_sidebar_options',
                'default'     => '1',
                'priority'    => 10,
            ));

            do_action('optons/maester_sidebar_options', $config_id);

            /**
             * Footer Options
             */

            Kirki::add_section( 'maester_footer_options', array(
                'title'          => esc_html__( 'Footer Settings', 'maester-toolkit' ),
                'panel'          => 'maester_options_panel',
                'priority'       => 160,
            ));
            Kirki::add_field( $config_id, array(
                'type'        => 'toggle',
                'settings'    => 'enable_footer',
                'label'       => esc_html__( 'Enable Footer (Widget Area)', 'maester-toolkit' ),
                'section'     => 'maester_footer_options',
                'default'     => '1',
                'priority'    => 10,
            ));
            Kirki::add_field( $config_id, array(
                'type'        => 'toggle',
                'settings'    => 'enable_footer_bottom',
                'label'       => esc_html__( 'Enable Footer Bottom (Copyright Area)', 'maester-toolkit' ),
                'section'     => 'maester_footer_options',
                'default'     => '1',
                'priority'    => 10,
            ));
            Kirki::add_field( $config_id, array(
                'type'     => 'text',
                'settings' => 'footer_text',
                'label'    => esc_html__( 'Footer Text', 'maester-toolkit' ),
                'section'  => 'maester_footer_options',
                'default'  => sprintf("&copy; %s %s. ", date('Y') , get_bloginfo('name')),
                'priority' => 10,
                'partial_refresh'    => array(
                    'footer_text' => array(
                        'selector'        => '.site-info p',
                        'render_callback' => function() {
                            return get_theme_mod('footer_text');
                        },
                    )
                ),
            ));

            Kirki::add_field( $config_id, array(
                'type'        => 'select',
                'settings'    => 'footer_credit',
                'label'       => esc_html__( 'Developer Credit', 'maester-toolkit' ),
                'section'     => 'maester_footer_options',
                'default'     => 'credit_1',
                'priority'    => 10,
                'choices'     => function_exists('maester_get_copyright_credits') ?  maester_get_copyright_credits(true) : array(),
            ));

            if(!maester_toolkit()->pro){
                Kirki::add_field( $config_id, [
                    'type'        => 'custom',
                    'settings'    => 'footer_copyright_get_pro',
                    'section'     => 'maester_footer_options',
                    'default'     => maester_toolki_customizer_pro_notice('disable-developer-credits.jpg'),
                    'priority'    => 10,
                ] );
            }

            do_action('optons/maester_footer_options', $config_id);


            /**
             * Notice Panel
             */

            Kirki::add_section( 'maester_notice_options', array(
                'title'          => esc_html__( 'Notice', 'maester-toolkit' ),
                'panel'          => 'maester_options_panel',
                'priority'       => 160,
            ) );


            Kirki::add_field( $config_id, array(
                'type'        => 'toggle',
                'settings'    => 'maester_enable_notice',
                'label'       => esc_html__( 'Enable Single Blog Date', 'maester-toolkit' ),
                'section'     => 'maester_notice_options',
                'default'     => '0',
                'priority'    => 10,
            ) );

            Kirki::add_field( $config_id, [
                'type'     => 'text',
                'settings' => 'maester_notice_text',
                'label'    => esc_html__( 'Notice text', 'maester-toolkit' ),
                'section'  => 'maester_notice_options',
                'default'  => esc_html__( 'Notice text here', 'maester-toolkit' ),
                'priority' => 10,
            ] );

            do_action('optons/maester_notice_options', $config_id);

        }
    }
}