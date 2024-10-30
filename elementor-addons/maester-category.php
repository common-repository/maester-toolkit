<?php
	namespace Elementor;

	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	class Widget_Maester_Button extends Widget_Base {

		public function get_name() {
			return 'maester-button';
		}

		public function get_title() {
			return __( 'Maester Category', 'maester-toolkit' );
		}

		public function get_categories() {
			return [ 'maester-ecat' ];
		}

		public function get_icon() {
			return 'eicon-button';
		}

		protected function _register_controls() {
			$this->start_controls_section(
				'section_category',
				[
					'label' 		=> __( 'Category Settings', 'maester-toolkit' ),
				]
			);

			$this->add_control(
				'count',
				[
					'label' => __( 'Category count', 'maester-toolkit' ),
					'description' => __('Leave empty to show all categories'),
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

			$this->end_controls_section();
		}

		protected function render() {
			$settings = $this->get_settings();
			$count = !empty($settings['count']) ? (int) $settings['count'] : -1;
			$column = $settings['column'];

			$course_category = get_terms(maester_toolkit()->tutor_category);
			ob_start();
			?>
			<div class="maester-course-categories">
				<ul class="maester-course-category-list <?php echo esc_attr($column) ?>">
					<?php
						$index = 0;
						foreach ($course_category as $category){
							$index++;
							if(-1 != $count && $index > $count) break;
							$image_id = get_term_meta($category->term_id, 'thumbnail_id', true);
							$color = get_term_meta($category->term_id, 'color', true);
							$dummy_img = maester_toolkit()->url.'assets/img/category.jpg';
							$image_src = $image_id ? wp_get_attachment_image_src($image_id, 'post-vertical')[0] : $dummy_img;
							$term_link = get_term_link($category->term_id, maester_toolkit()->tutor_category);
							?>
							<li>
								<a style="--maester-category-color: #<?php echo $color; ?>" href="<?php echo esc_url($term_link); ?>">
									<img src="<?php echo esc_url($image_src); ?>" alt="">
									<h4><?php echo $category->name; ?>&nbsp; <strong> (<?php echo $category->count ?>)</strong></h4>
								</a>
							</li>
							<?php
						}
					?>
				</ul>
			</div>
			<?php
			$output = ob_get_clean();
			echo $output;
		}
	}

	Plugin::instance()->widgets_manager->register_widget_type( new Widget_Maester_Button() );
