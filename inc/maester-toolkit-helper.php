<?php

	if(!function_exists('maester_toolki_customizer_pro_notice')){
		function maester_toolki_customizer_pro_notice($screenshot = ''){
			$pro_url = maester_toolkit()->pro_url;
			$screenshot = !empty($screenshot) ? maester_toolkit()->url .'assets/img/customizer-features/'.$screenshot : '';
			ob_start();
			?>
			<div class="maester-toolkit-customizer-pro-notice">
				<h4 style="color: #AF3C5E; margin-bottom: 8px;"><?php esc_html_e('Pro features (Locked)', 'maester-toolkit') ?></h4>
				<img style="cursor: not-allowed; opacity: .5;" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_html_e('Pro Screenshot', 'maester-toolkit') ?>">
				<p><i><?php printf("Get the %s Pro version %s for more stunning elements and customization options.", "<a style='color: #AF3C5E;' href='$pro_url' target='_blank'>", "</a>"); ?></i></p>
			</div>
			<?php
			$output = ob_get_contents();
			ob_end_clean();
			return $output;
		}
	}


	/**
	 * Get possible search post types
	 * @return array
	 */

	function maester_toolkit_search_post_types (){
		$get_post_types = get_post_types(array('public'=>true));
		$value = array();
		foreach ($get_post_types as $post){
			if(function_exists('tutor') && tutor()->course_post_type == $post) $value[$post] = 'Course';
			if('product' == $post) $value[$post] = 'Product';
			if('post' == $post) $value[$post] = 'Post';
		}
		return $value;
	}


	/**
	 * @param string $taxonomy
	 * @return array
	 * Category List Funtion
	 */
	function maester_toolkit_category_list($taxonomy = 'category'){
		$terms = get_terms($taxonomy);
		$term_array = array();
		foreach ($terms as $term){
			$term_array[$term->slug] = $term->name;
		}
		return $term_array;
	}


	/**
	 * @param string $post_type
	 * @return array
	 * Get post list as array
	 */
	function maester_toolkit_get_post_lists($post_type = 'post'){
		wp_reset_query();
		query_posts(array(
			'post_type' => $post_type,
			'post_status' => 'publish'
		));
		$post_list = array();

		if(have_posts()){
			while(have_posts()){
				the_post();
				$post_list[get_the_ID()] = get_the_title();
			}
		}
		wp_reset_query();
		return $post_list;
	}




	/**
	 * Get formatted price with cart form
	 */

	if ( ! function_exists('maester_toolkit_course_loop_price')) {
		function maester_toolkit_course_loop_price() {
			ob_start();
			$course_id = get_the_ID();
			$enroll_btn = '<a class="button" href="'. get_the_permalink(). '">'.__('Get Enrolled', 'maester-toolkit'). '</a>';
			$price_html = '<div class="price"><span>'.__('Free', 'maester-toolkit').'</span>'.$enroll_btn. '</div>';
			if(tutor_utils()->is_course_purchasable()){
				$enroll_btn = tutor_course_loop_add_to_cart(false);
				$enable_wc = tutor_utils()->get_option('enable_course_sell_by_woocommerce');
				if('1' == $enable_wc){
					$product_id = tutor_utils()->get_course_product_id($course_id);
					$product    = wc_get_product( $product_id );
					if($product){
						$price_html = '<div class="price"> '.$product->get_price_html().$enroll_btn.' </div>';
					}
				}else{
					$price_html = '<div class="price"> '.$enroll_btn.' </div>';
				}
			}

			echo $price_html;
			$output = ob_get_clean();
			echo $output;
		}
	}


/**
 * Get Post Types for header search
 * @param $post_type
 * @return string
 */
function maester_toolkit_get_search_category_slug_by_post_type($post_type = 'post'){
    if(function_exists('tutor') && tutor()->course_post_type == $post_type){
        return 'course-category';
    }elseif(function_exists('WC') && 'product' == $post_type){
        return 'product_cat';
    }elseif('post' == $post_type){
        return 'category';
    }else{
        return false;
    }
}




if ( ! function_exists( 'maester_toolkit_header_cart' ) ) {
    /**
     * Display Header Cart
     *
     * @since  1.0.0
     * @uses  maester_lite_is_woocommerce_activated() check if WooCommerce is activated
     * @return void
     */
    function maester_toolkit_header_cart() {
        if ( maester_lite_is_woocommerce_activated() ) {
            if ( is_cart() ) {
                $class = 'current-menu-item';
            } else {
                $class = '';
            }
            ob_start();
            ?>
            <ul id="site-header-cart" class="site-header-cart menu">
                <li class="<?php echo esc_attr( $class ); ?>">
                    <?php maester_lite_cart_link(); ?>
                </li>
                <li>
                    <?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
                </li>
            </ul>
            <?php
            return ob_get_clean();
        }
    }
}
