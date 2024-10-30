<?php
	namespace Elementor;

	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	class Widget_Maester_Courses extends Widget_Base {

		public function get_name() {
			return 'maester-courses';
		}

		public function get_title() {
			return __( 'Maester Courses', 'maester-toolkit' );
		}

		public function get_categories() {
			return [ 'maester-ecat' ];
		}

		public function get_icon() {
			return 'eicon-button';
		}

		protected function _register_controls() {
			$this->start_controls_section(
				'section_basic',
				[
					'label' 		=> __( 'Course Settings', 'maester-toolkit' ),
					'tab' => Controls_Manager::TAB_CONTENT
				]
			);

			$this->add_control(
				'count',
				[
					'label' => __( 'Course count', 'maester-toolkit' ),
					'description' => __('Leave empty to show all courses'),
					'type' => Controls_Manager::NUMBER,
					'min' => 1,
					'max' => 30,
					'step' => 1,
					'default' => 6
				]
			);

			$this->add_control(
				'column',
				[
					'label' => __( 'Column Count', 'maester-toolkit' ),
					'description' => __( 'Columns per row', 'maester-toolkit' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'column-1' => __('1 Column', 'maester-toolkit'),
						'column-2' => __('2 Column', 'maester-toolkit'),
						'column-3' => __('3 Column', 'maester-toolkit'),
						'column-4' => __('4 Column', 'maester-toolkit'),
						'column-5' => __('5 Column', 'maester-toolkit'),
					],
					'default' => 'column-4'
				]
			);

			$this->add_control(
				'order',
				[
					'label' => __( 'Order', 'maester-toolkit' ),
					'description' => __( 'Course Order', 'maester-toolkit' ),
					'type' => Controls_Manager::SELECT,
					'multiple' => false,
					'options' => [
						'DESC' => 'Descending',
						'ASC'   => 'Ascending'
					],
					'default' => 'DESC'
				]
			);

			$this->add_control(
				'order_by',
				[
					'label' => __( 'Order By', 'maester-toolkit' ),
					'type' => Controls_Manager::SELECT,
					'multiple' => false,
					'options' => [
						'none' => 'None',
						'date' => 'Date',
						'ID' => 'Course ID',
						'author' => 'Author',
						'title' => 'Title',
						'name' => 'Name (Post slug)',
						'modified' => 'Last Modified',
						'rand' => 'Random',
						'comment_count' => 'Comment Count'
					],
					'default' => 'date'
				]
			);

			$this->add_control(
				'more_settings',
				[
					'label' => __( 'Additional Settings', 'maester-toolkit' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_control(
				'rating',
				[
					'label' => __( 'Show Ratings', 'maester-toolkit' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', 'maester-toolkit' ),
					'label_off' => __( 'Hide', 'maester-toolkit' ),
					'return_value' => 'yes',
					'default' => 'yes'
				]
			);
			$this->add_control(
				'meta',
				[
					'label' => __( 'Show Meta (Author & Category)', 'maester-toolkit' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', 'maester-toolkit' ),
					'label_off' => __( 'Hide', 'maester-toolkit' ),
					'return_value' => 'yes',
					'default' => 'yes'
				]
			);
			$this->add_control(
				'wishlist',
				[
					'label' => __( 'Show Wishlist/Bookmark Button', 'maester-toolkit' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', 'maester-toolkit' ),
					'label_off' => __( 'Hide', 'maester-toolkit' ),
					'return_value' => 'yes',
					'default' => 'yes'
				]
			);
			$this->add_control(
				'price',
				[
					'label' => __( 'Show Price', 'maester-toolkit' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', 'maester-toolkit' ),
					'label_off' => __( 'Hide', 'maester-toolkit' ),
					'return_value' => 'yes',
					'default' => 'yes'
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'section_advance',
				[
					'label' 		=> __( 'Advance Settings', 'maester-toolkit' ),
					'tab' => Controls_Manager::TAB_CONTENT
				]
			);
			$this->add_control(
				'category',
				[
					'label' => __( 'Category', 'maester-toolkit' ),
					'description' => __( 'Show course by specific category', 'maester-toolkit' ),
					'type' => Controls_Manager::SELECT2,
					'multiple' => true,
					'options' => maester_toolkit_category_list('course-category')
				]
			);

			$this->add_control(
				'courses',
				[
					'label' => __( 'Show specific courses', 'maester-toolkit' ),
					'description' => __( 'Leave empty to show all courses', 'maester-toolkit' ),
					'label_block' => true,
					'type' => Controls_Manager::SELECT2,
					'multiple' => true,
					'options' => maester_toolkit_get_post_lists(tutor()->course_post_type)
				]
			);

			$this->add_control(
				'exclude_courses',
				[
					'label' => __( 'Exclude courses', 'maester-toolkit' ),
					'description' => __( 'Leave empty to show all courses', 'maester-toolkit' ),
					'label_block' => true,
					'type' => Controls_Manager::SELECT2,
					'multiple' => true,
					'options' => maester_toolkit_get_post_lists(tutor()->course_post_type),
				]
			);


			$this->end_controls_section();
		}

		protected function render() {
			$settings = $this->get_settings();

			$count = $settings['count'];
			$order = $settings['order'];
			$order_by = $settings['order_by'];
			$rating = $settings['rating'];
			$meta = $settings['meta'];
			$wishlist = $settings['wishlist'];
			$price = $settings['price'];
			$column = $settings['column'];
			$category = is_array($settings['category']) && !empty($settings['category']) ? implode(",", $settings['category']) : '';
			$courses = is_array($settings['courses']) && !empty($settings['courses']) ? implode(",", $settings['courses']) : '';
			$exclude_courses = is_array($settings['exclude_courses']) && !empty($settings['exclude_courses']) ? implode(",", $settings['exclude_courses']) : '';


			ob_start();
			echo do_shortcode("[maester_course count='$count' column='$column' order='$order' order_by='$order_by' rating='$rating' meta='$meta' wishlist='$wishlist' price='$price' category='$category' id='$courses' exclude_ids='$exclude_courses']");
			$output = ob_get_clean();
			echo $output;
			return;
		}

		/*
			protected function _content_template() {}
			protected function render_text() {}
		*/

	}

	Plugin::instance()->widgets_manager->register_widget_type( new Widget_Maester_Courses() );
