<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Themo_Widget_Appointments extends Widget_Base {

	public function get_name() {
		return 'themo-appointments';
	}

	public function get_title() {
		return __( 'Booked Appointment Calendar', 'th-widget-pack' );
	}

	public function get_icon() {
		return 'eicon-countdown';
	}

	public function get_categories() {
		return [ 'themo-elements' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_tooltip',
			[
				'label' => __( 'Tooltip Title', 'th-widget-pack' ),
			]
		);

		$this->add_control(
			'tooltip_title',
			[
				'label' => __( 'Tooltip Title', 'th-widget-pack' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Book Today', 'th-widget-pack' ),
				'placeholder' => __( 'Book here', 'th-widget-pack' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'tooltip_background',
			[
				'label' => __( 'Tooltip Background', 'th-widget-pack' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .th-cal-tooltip' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .th-cal-tooltip:after' => 'border-top-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_calendar',
			[
				'label' => __( 'Calendar', 'th-widget-pack' ),
			]
		);

		$this->add_control(
			'calendar_shortcode',
			[
				'label' => __( 'Shortcode', 'th-widget-pack' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '[booked-calendar]', 'th-widget-pack' ),
				'placeholder' => __( '[add_shortcode_here]', 'th-widget-pack' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'calendar_size',
			[
				'label' => __( 'Calendar Size', 'th-widget-pack' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'large',
				'options' => [
					'large' => __( 'Large', 'th-widget-pack' ),
					'small' => __( 'Small', 'th-widget-pack' ),
				],
			]
		);

		$this->add_control(
			'calendar_align',
			[
				'label' => __( 'Align Calendar', 'th-widget-pack' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'centered',
				'options' => [
					'left' => __('Left', 'th-widget-pack'),
					'centered' => __('Center', 'th-widget-pack'),
					'right' => __('Right', 'th-widget-pack'),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_tooltip',
			[
				'label' => __( 'Tooltip Title', 'th-widget-pack' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'tooltip_color',
			[
				'label' => __( 'Tooltip Color', 'th-widget-pack' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .th-cal-tooltip h3' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings();

        $this->add_render_attribute( 'th-cal-wrap', 'class', 'th-book-cal-' . esc_attr( $settings['calendar_size'] ) );
        $this->add_render_attribute( 'th-cal-wrap', 'class', 'th-' . esc_attr( $settings['calendar_align'] ) );
        $this->add_render_attribute( 'th-cal-tooltip', 'class', 'th-cal-tooltip' );

		?>
		<div <?php echo $this->get_render_attribute_string( 'th-cal-wrap'); ?>>
			<?php if( $settings['tooltip_title'] ) : ?>
				<div <?php echo $this->get_render_attribute_string( 'th-cal-tooltip'); ?>><h3><?php echo esc_html( $settings['tooltip_title'] ); ?></h3></div>
			<?php endif; ?>
			<?php echo do_shortcode( sanitize_text_field( $settings['calendar_shortcode'] ) ); ?>
		</div>
		<?php
	}

	protected function _content_template() {}
}

Plugin::instance()->widgets_manager->register_widget_type( new Themo_Widget_Appointments() );
