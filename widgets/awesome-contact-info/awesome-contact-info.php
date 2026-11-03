<?php
/**
 * Awea Contact Info Widget.
 *
 * @since 1.0.0
 */
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget_Awesome_Contact_Info extends Widget_Base {

    public function get_name() {
        return 'awea-contact-info';
    }

    public function get_title() {
        return esc_html__( 'Contact Info', 'awesome-widgets-elementor' );
    }

    public function get_icon() {
        return 'eicon-unread';
    }

    public function get_categories() {
        return [ 'awesome-widgets-elementor' ];
    }

    public function get_keywords() {
        return [ 'contact', 'list', 'awea', 'info' ];
    }

    protected function register_controls() {

        // --- CONTENT SECTION ---
        $this->start_controls_section(
            'awea_contact_list_section',
            [
                'label' => esc_html__( 'Contact List', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'awea_contact_list_title',
            [
                'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Contact Details', 'awesome-widgets-elementor' ),
                'label_block' => true,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'awea_contact_list_item_label',
            [
                'label' => esc_html__( 'Label', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Label' , 'awesome-widgets-elementor' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'awea_contact_list_item_value',
            [
                'label' => esc_html__( 'Value', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Value Content' , 'awesome-widgets-elementor' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'awea_contact_list_item_icon',
            [
                'label' => esc_html__( 'Icon', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-envelope',
                    'library' => 'solid',
                ],
            ]
        );

        $repeater->add_control(
            'awea_contact_list_item_link',
            [
                'label' => esc_html__( 'Link', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'awesome-widgets-elementor' ),
            ]
        );

        $this->add_control(
            'awea_contact_list',
            [
                'label' => esc_html__( 'Contact Items', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'awea_contact_list_item_label' => esc_html__( 'Direct Email', 'awesome-widgets-elementor' ),
                        'awea_contact_list_item_value' => esc_html__( 'hello@infinityflame.com', 'awesome-widgets-elementor' ),
                        'awea_contact_list_item_icon'  => [ 'value' => 'fas fa-envelope', 'library' => 'solid' ],
                    ],
                    [
                        'awea_contact_list_item_label' => esc_html__( 'Phone Support', 'awesome-widgets-elementor' ),
                        'awea_contact_list_item_value' => esc_html__( '+1 (555) 000-8888', 'awesome-widgets-elementor' ),
                        'awea_contact_list_item_icon'  => [ 'value' => 'fas fa-phone', 'library' => 'solid' ],
                    ],
                    [
                        'awea_contact_list_item_label' => esc_html__( 'Studio Address', 'awesome-widgets-elementor' ),
                        'awea_contact_list_item_value' => esc_html__( '123 Innovation Dr, San Francisco', 'awesome-widgets-elementor' ),
                        'awea_contact_list_item_icon'  => [ 'value' => 'fas fa-map-marker-alt', 'library' => 'solid' ],
                    ],
                ],
                'title_field' => '{{{ awea_contact_list_item_label }}}',
            ]
        );

        $this->end_controls_section();

        // --- STYLE: TITLE PANEL ---
        $this->start_controls_section(
            'awea_contact_info_style_title',
            [
                'label' => esc_html__( 'Title', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'awea_contact_info_title_color',
            [
                'label' => esc_html__( 'Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-contact-header h2' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'awea_contact_info_title_border_color',
            [
                'label' => esc_html__( 'Border Color', 'awesome-widgets-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-contact-header' => 'border-color: {{VALUE}};' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'awea_contact_info_title_typo',
                'selector' => '{{WRAPPER}} .awea-contact-header h2',
            ]
        );
        $this->end_controls_section();

        // --- STYLE: LAYOUT (Tabs) ---
        $this->start_controls_section(
            'awea_contact_info_style_layout',
            [
                'label' => esc_html__( 'Layout', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'awea_contact_info_layout_tabs' );

        // Normal Tab
        $this->start_controls_tab( 'awea_contact_info_layout_normal', [ 'label' => esc_html__( 'Normal', 'awesome-widgets-elementor' ) ] );
        
        $this->add_control(
            'awea_contact_info_row_bg',
            [
                'label' => 'Background',
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-contact-list-row' => 'background-color: {{VALUE}};' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'awea_contact_info_row_border',
                'selector' => '{{WRAPPER}} .awea-contact-list-row',
            ]
        );

        $this->add_responsive_control(
            'awea_contact_info_row_padding',
            [
                'label' => 'Padding',
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [ '{{WRAPPER}} .awea-contact-list-row' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ]
        );

        $this->add_control(
            'awea_contact_info_row_radius',
            [
                'label' => 'Border Radius',
                'type' => Controls_Manager::SLIDER,
                'selectors' => [ '{{WRAPPER}} .awea-contact-list-row' => 'border-radius: {{SIZE}}px;' ],
            ]
        );

        $this->add_control(
            'awea_contact_info_row_spacing',
            [
                'label' => 'Spacing Bottom',
                'type' => Controls_Manager::SLIDER,
                'selectors' => [ '{{WRAPPER}} .awea-contact-list-row' => 'margin-bottom: {{SIZE}}px;' ],
            ]
        );

        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab( 'awea_contact_info_layout_hover', [ 'label' => esc_html__( 'Hover', 'awesome-widgets-elementor' ) ] );
        
        $this->add_control(
            'awea_contact_info_row_border_hover',
            [
                'label' => 'Border Color',
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-contact-list-row:hover' => 'border-color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'awea_contact_info_icon_bg_hover',
            [
                'label' => 'Icon Background',
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-contact-list-row:hover .awea-contact-list-icon' => 'background-color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'awea_contact_info_icon_color_hover',
            [
                'label' => 'Icon Color',
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-contact-list-row:hover .awea-contact-list-icon' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'awea_contact_info_arrow_icon_color_hover',
            [
                'label' => 'Arrow Icon Color',
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-contact-list-row:hover .awea-contact-list-arrow' => 'color: {{VALUE}};' ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        // --- STYLE: CONTENT PANEL ---
        $this->start_controls_section(
            'awea_contact_info_style_content',
            [
                'label' => esc_html__( 'Content', 'awesome-widgets-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control( 'awea_contact_info_icon_heading', [ 'label' => 'Icon', 'type' => Controls_Manager::HEADING, 'separator' => 'before' ] );

        $this->add_control(
            'awea_contact_info_icon_color',
            [
                'label' => 'Color',
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-contact-list-icon' => 'color: {{VALUE}};' ],
            ]
        );

        $this->add_control(
            'awea_contact_info_icon_bg',
            [
                'label' => 'Background',
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-contact-list-icon' => 'background-color: {{VALUE}};' ],
            ]
        );

        $this->add_responsive_control(
            'awea_contact_info_icon_padding',
            [
                'label' => 'Padding',
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem' ],
                'selectors' => [ '{{WRAPPER}} .awea-contact-list-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ]
        );

        $this->add_control(
            'awea_contact_info_icon_radius',
            [
                'label' => 'Border Radius',
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [ '{{WRAPPER}} .awea-contact-list-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
            ]
        );

        $this->add_control(
            'awea_contact_info_icon_size',
            [
                'label' => 'Icon Size',
                'type' => Controls_Manager::SLIDER,
                'selectors' => [ '{{WRAPPER}} .awea-contact-list-icon' => 'font-size: {{SIZE}}px;' ],
            ]
        );

        $this->add_control( 'awea_contact_info_label_heading', [ 'label' => 'Heading Settings', 'type' => Controls_Manager::HEADING, 'separator' => 'before' ] );
        $this->add_control(
            'awea_contact_info_label_color',
            [
                'label' => 'Color',
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-contact-list-label' => 'color: {{VALUE}};' ],
            ]
        );
        $this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'awea_contact_info_label_font', 'selector' => '{{WRAPPER}} .awea-contact-list-label' ] );

        $this->add_control( 'awea_contact_info_value_heading', [ 'label' => 'Description Settings', 'type' => Controls_Manager::HEADING, 'separator' => 'before' ] );
        $this->add_control(
            'awea_contact_info_value_color',
            [
                'label' => 'Color',
                'type' => Controls_Manager::COLOR,
                'selectors' => [ '{{WRAPPER}} .awea-contact-list-value' => 'color: {{VALUE}};' ],
            ]
        );
        $this->add_group_control( Group_Control_Typography::get_type(), [ 'name' => 'awea_contact_info_value_font', 'selector' => '{{WRAPPER}} .awea-contact-list-value' ] );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="awea-list-container">
            <?php if ( ! empty( $settings['awea_contact_list_title'] ) ) : ?>
                <div class="awea-contact-header">
                    <h2><?php echo esc_html( $settings['awea_contact_list_title'] ); ?></h2>
                </div>
            <?php endif; ?>

            <?php 
            if ( ! empty( $settings['awea_contact_list'] ) ) {
                foreach ( $settings['awea_contact_list'] as $index => $item ) {
                    $repeater_setting_key = $this->get_repeater_setting_key( 'awea_contact_list_item_link', 'awea_contact_list', $index );
                    $this->add_link_attributes( $repeater_setting_key, $item['awea_contact_list_item_link'] );
                    
                    $tag = ! empty( $item['awea_contact_list_item_link']['url'] ) ? 'a' : 'div';
                    ?>
                    <<?php echo tag_escape( $tag ); ?> <?php echo wp_kses_post( $this->get_render_attribute_string( $repeater_setting_key ) ); ?> class="awea-contact-list-row">
                        <div class="awea-contact-list-icon">
                            <?php Icons_Manager::render_icon( $item['awea_contact_list_item_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        </div>
                        <div class="awea-contact-list-content">
                            <span class="awea-contact-list-label"><?php echo esc_html( $item['awea_contact_list_item_label'] ); ?></span>
                            <span class="awea-contact-list-value"><?php echo esc_html( $item['awea_contact_list_item_value'] ); ?></span>
                        </div>
                        <div class="awea-contact-list-arrow"><i class="fas fa-chevron-right"></i></div>
                    </<?php echo esc_attr($tag); ?>>
                    <?php
                }
            }
            ?>
        </div>
        <?php
    }
}