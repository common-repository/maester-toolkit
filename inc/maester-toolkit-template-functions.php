<?php



/**
 * Top Bar Menu Customize
 */

function maester_header_links ($items, $args) {
    global $wp;
    $topbar_custom_links = get_theme_mod('topbar_custom_links', array('login', 'profile', 'logout'));
    $topbar_social = get_theme_mod('topbar_social', array());
    $current_page = home_url($wp->request);

    if('topbar' == $args->theme_location){

        foreach ($topbar_social as $social){
            $social_icon = esc_attr($social['topbar_social_icon']);
            $social_link = esc_url($social['topbar_social_link']);
            $topbar_social_link_target = esc_attr($social['topbar_social_link_target']);
            $items .= "<li class='top-bar-custom-links top-bar-social'><a target='$topbar_social_link_target' href='$social_link'><i class='$social_icon'></i></a></li>";
        }


        if(in_array('search', $topbar_custom_links)){
            $items .= "<li class='top-bar-custom-links'><a href='#open_search_popup'><i class='fas fa-search'></i></a></li>";
        }

        if(is_user_logged_in()){
            $logout_url =  wp_logout_url($current_page);
            if(in_array('logout', $topbar_custom_links)){
                $items .= "<li class='top-bar-custom-links'><a href='$logout_url'><i class='fas fa-sign-out-alt'></i></a></li>";
            }
        }else{
            if(in_array('login', $topbar_custom_links)){
                $items .= "<li class='top-bar-custom-links'><a href='#open_user_modal'><i class='fas fa-lock'></i></a></li>";

            }
        }
    }
    return $items;
}

add_filter('wp_nav_menu_items', 'maester_header_links', 10, 2);



/**
 * Menubar Right Icons
 */

function maester_menubar_right_icons(){
    global $wp;
    $enable_header_cart = function_exists('WC') ? get_theme_mod('enable_header_cart', true) : false;
    $enable_header_login_icon = get_theme_mod('enable_header_login_icon', true);
    $enable_menubar_search_icon = get_theme_mod('enable_menubar_search_icon', true);
    $menubar_social = get_theme_mod('menubar_social', array());
    $menubar_social_markup = '';
    foreach ($menubar_social as $social){
        $social_icon = esc_attr($social['menubar_social_icon']);
        $social_link = esc_url($social['menubar_social_link']);
        $link_target = esc_attr($social['menubar_social_link_target']);
        $menubar_social_markup .= "<li><a href='$social_link' target='$link_target'><i class='$social_icon'></i></a></li>";
    }

    ?>
    <div class="col-auto">
        <ul class="header-right-menu clearfix">
            <?php if($enable_header_cart) {?>
                <li class="header-cart-menu">
                    <div class="cart-menu-parent">
                        <?php echo maester_toolkit_header_cart(); ?><i class="fas fa-shopping-basket"></i>
                    </div>
                </li>
            <?php } ?>
            <?php echo wp_kses_post($menubar_social_markup); ?>

            <?php if($enable_menubar_search_icon) {?>
                <li class='menubar-search-icon'>
                    <a href='#open_search_popup'>
                        <i class='fas fa-search'></i>
                    </a>
                </li>
            <?php } ?>

            <?php if($enable_header_login_icon) {
                if(is_user_logged_in()){ ?>
                    <li class='menubar-login-icon'>
                        <a href='<?php echo esc_url(wp_logout_url(home_url($wp->request))); ?>'>
                            <i class='fas fa-sign-out-alt'></i>
                        </a>
                    </li>
                    <?php

                }else{ ?>
                    <li><a href='#open_user_modal'><i class='fas fa-lock'></i></a></li>
                    <?php
                }
            }
            ?>

        </ul>
    </div>
    <?php
}

add_action('maester_lite_menubar_item_hook', 'maester_menubar_right_icons');


function maester_toolkit_search_shortcode(){
    $post_type = get_theme_mod('header_search_post_types', 'post');
    if(('product' == $post_type && !function_exists('WC')) || ('post' != $post_type && !function_exists('tutor'))){
        $post_type = 'post';
    }

    $en_search = get_theme_mod('enable_header_search', true);
    $values = array(
        'class' => '',
        'all_category'  => 'All Category',
        'placeholder'   => __('Search anything...', 'maester-toolkit'),
        'post_type'     => $post_type,
        'taxonomy'     => maester_toolkit_get_search_category_slug_by_post_type($post_type)
    );

    $cat_list = maester_toolkit_category_list($values['taxonomy']);
    if($en_search) {
        ?>
        <div class="col-12 col-md-auto text-right custom-search-form-column">
            <form action="<?php echo esc_url(home_url()); ?>" class="custom-search-form">
                <input type="hidden" name="post_type" value="<?php echo $values['post_type']; ?>">
                <select name="category">
                    <option value=""><?php echo $values['all_category']; ?></option>
                    <?php
                    foreach ($cat_list as $key => $value){
                        echo "<option value='$key'>$value</option>";
                    }
                    ?>

                </select>
                <input type="search" placeholder="<?php echo esc_html($values['placeholder']); ?>" name="s" value="<?php echo get_search_query(); ?>">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
        <?php
    }
}

add_action('maester_lite_header_item_hook', 'maester_toolkit_search_shortcode');




	/**
	 * Course Loop Function
	 * @param bool $rating
	 * @param bool $meta
	 * @param bool $wishlist
	 * @param bool $price
	 */
	if(!function_exists('maester_toolkit_course_loop')){
		function maester_toolkit_course_loop($rating = true, $meta = true, $wishlist = true, $price = true, $column = 'column-4'){
			ob_start();
			if( function_exists('tutor') && have_posts()){
				?>
				<div class="maester-tutor-courses <?php echo esc_attr($column); ?>">
					<?php
						while (have_posts()){
							the_post();
							$profile_url = tutor_utils()->profile_url(get_the_author_meta('ID'));
							$post_thumbnail_id = (int) get_post_thumbnail_id( get_the_ID() );

							if($post_thumbnail_id){
								$image = wp_get_attachment_image($post_thumbnail_id, 'maester-post-thumbnail');
							}else{
								$image = sprintf('<img alt="%s" src="' . get_template_directory_uri().'/img/course.jpg' . '" />', __('Placeholder', 'maester-toolkit'));
							}

							?>
							<div class="maester-tutor-course">
								<a class="maester-course-image-wrap" href="<?php the_permalink() ?>" title="<?php the_title() ?>">
									<?php echo $image; ?>
								</a>
								<div class="maester-course-content">
									<?php
										if($rating){
											tutor_course_loop_rating();
										}
									?>
									<?php if($meta) { ?>
										<ul class="maester-course-meta">
											<li>
												<strong><?php esc_html_e('By', 'maester-toolkit') ?> </strong>
												<a href="<?php esc_url($profile_url); ?>"><?php the_author(); ?></a>
											</li>
											<li>
												<?php
													$category = get_tutor_course_categories();
													if(!empty($category) && is_array($category ) && count($category)){
														?>
														<strong><?php esc_html_e('In', 'maester-toolkit') ?> </strong>
														<?php
														foreach ($category as $course_category){
															$category_name = $course_category->name;
															$category_link = get_term_link($course_category->term_id);
															echo "<a href='$category_link'>$category_name </a>";
														}
													}
												?>
											</li>
										</ul>
									<?php } ?>
									<h3>
										<?php
											if($wishlist) {
												$is_wishlisted = tutor_utils()->is_wishlisted(get_the_ID());
												$wishlist_class = $is_wishlisted ? 'wishlisted' : '';
												$bookmark_msg = $is_wishlisted ? __('Remove from bookmark', 'maester-toolkit') : __('Add to bookmark', 'maester-toolkit');
												?>
												<i data-course-id="<?php echo get_the_ID(); ?>" title="<?php echo esc_attr($bookmark_msg); ?>" class="<?php echo esc_attr($wishlist_class); ?> far fa-bookmark course-bookmark-icon"></i>
												<?php
											}
										?>
										<a href="<?php the_permalink() ?>"><?php the_title() ?></a>
									</h3>
									<?php
										if($price){
											maester_toolkit_course_loop_price();
										}
									?>
								</div>
							</div>
							<?php
						}
					?>
				</div>
				<?php
			}
			$output = ob_get_clean();
			echo $output;
		}
	}


/**
 * Filter the except length to 150 words.
 *
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
function maester_toolkit_custom_excerpt_length( $length ) {
    $maester_toolkit_excerpt_lenght = get_theme_mod('maester_excerpt_length', 25);
    return $maester_toolkit_excerpt_lenght;
}

add_filter( 'excerpt_length', 'maester_toolkit_custom_excerpt_length', 999 );
