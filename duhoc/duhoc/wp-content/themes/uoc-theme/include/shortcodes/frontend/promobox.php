<?php

/*
 *
 * @Shortcode Name : Promobox
 * @retrun
 *
 */

if (!function_exists('cs_promobox_shortcode')) {

    function cs_promobox_shortcode($atts, $content = "") {
        $defaults = array(
            'cs_promobox_section_title' => '',
            'cs_promo_image_url' => '',
            'cs_promobox_title' => '',
            'cs_promobox_contents' => '',
            'cs_promobox_btn_bg_color' => '',
            'cs_promobox_btn_text_color' => '',
            'cs_promobox_title_color' => '',
            'cs_promobox_background_color' => '',
            'cs_promobox_content_color' => '',
            'cs_link_title' => '',
            'text_align' => '',
            'cs_link' => '#',
            'column_size' => '',
            'cs_promobox_class' => '',
            'bg_repeat' => '',
            'text_align' => '',
            'target' => '_self',
            'thickborder' => '',
            'promobox_view' => ''
        );


        extract(shortcode_atts($defaults, $atts));
        $column_class = 'col-sm-12';
        $cs_promo_image_url = isset($cs_promo_image_url) ? $cs_promo_image_url : '';
        $cs_link_title = isset($cs_link_title) ? $cs_link_title : '';
        $cs_link = isset($cs_link) ? $cs_link : '';
        $cs_promobox_background_color = isset($cs_promobox_background_color) ? $cs_promobox_background_color : '';
        $cs_promobox_title_color = isset($cs_promobox_title_color) ? $cs_promobox_title_color : '';
        $cs_promobox_content_color = isset($cs_promobox_content_color) ? $cs_promobox_content_color : '';
        $cs_promobox_background_color = isset($cs_promobox_background_color) ? $cs_promobox_background_color : '';  // color


        if (isset($cs_promobox_btn_bg_color) && $cs_promobox_btn_bg_color <> "") {
            $cs_promobox_btn_bg_color = 'background:' . $cs_promobox_btn_bg_color . ';';
        }
        if (isset($cs_promobox_btn_text_color) && $cs_promobox_btn_text_color <> "") {
            $thickborder = 'border: 2px solid ' . $cs_promobox_btn_text_color . ';';
            $cs_promobox_btn_text_color = 'color:' . $cs_promobox_btn_text_color . ';';
        }

        $text_align = isset($text_align) ? $text_align : '';
        $color = '';
        $html = '';
        if (isset($text_align) && $text_align == 'left') {

            $colClass = 'col-lg-8 pull-right';
            $articleClass = 'plain-with-border text-background-left';
            $align = 'text-align:left !important;';
            $color = ' color:' . $cs_promobox_content_color . ';';
        } else {
            if (isset($text_align) && $text_align == 'right') {
                $articleClass = 'plain-with-border text-background-right';
                $colClass = 'col-lg-9';
                $align = 'text-align:right !important;';
            }
        }

        if (isset($cs_promobox_background_color) && $cs_promobox_background_color <> "") {
            $backrground = 'style="background:' . $cs_promobox_background_color . ' !important;  background-size:cover !important;"';
        } else {
            $backrground = 'style="background:url(' . $cs_promo_image_url . ') no-repeat  !important; background-size:cover !important;"';
        }


        if (isset($promobox_view) && $promobox_view == 'view1') {

            $html = '';
            $html .= '<div class="' . $column_class . '">';
            if (isset($cs_promobox_section_title) && $cs_promobox_section_title != '') {
                $html .= '<div class="cs-section-title"> <h2>' . esc_html($cs_promobox_section_title) . '</h2> </div>';
            }
            $html .= '<article class="' . $articleClass . '" ' . $backrground . '>';
            $html .= '<div class="' . $colClass . '">';
            $html .= '<h4 style="color:' . $cs_promobox_title_color . ' !important">' . esc_html($cs_promobox_title) . '</h4>';
            $html .= '<p style="color:' . $cs_promobox_content_color . '">' . $cs_promobox_contents . '</p>';
            $html .= '<button onclick="location.href=\'' . esc_url($cs_link) . '\'" 
				class="text-button-plain" style="' . $cs_promobox_btn_bg_color . ' ' . $cs_promobox_btn_text_color . ' ' . $thickborder . '">
				' . esc_html($cs_link_title) . '</button>';
            $html .= '</div>';
            $html .= '</article></div>';
        } else if (isset($promobox_view) && $promobox_view == 'view2') {

            $html = '<div class="' . $column_class . '">';
            if (isset($cs_promobox_section_title) && $cs_promobox_section_title != '') {
                $html .= '<div class="cs-section-title"> <h2>' . esc_html($cs_promobox_section_title) . '</h2> </div>';
            }
            $html .= '<div ' . $backrground . ' class="promo-box" > 
				<section style="' . $align . '">
				<h5  style="color:' . $cs_promobox_title_color . ' !important"> ' . esc_html($cs_promobox_title) . '</h5>
				<p style="color:' . $cs_promobox_content_color . '">' . $cs_promobox_contents . '</p>
				<a class="list-btn" href="' . esc_url($cs_link) . '" style="' . $cs_promobox_btn_bg_color . ' ' . $cs_promobox_btn_text_color . '">
				<i style="color:#344ea3;" class="icon-arrow-right10"></i>' . esc_html($cs_link_title) . '</a>
				</section>
				</div>
				</div>';
        } else if (isset($promobox_view) && $promobox_view == 'view3') {

            $html = '<div class="' . $column_class . '">';
            if (isset($cs_promobox_section_title) && $cs_promobox_section_title != '') {
                $html .= '<div class="cs-section-title"> <h2>' . esc_html($cs_promobox_section_title) . '</h2> </div>';
            }
            $html .= '<div class="image-frame frame-plane  lightbox">';
            $html .= '<section ' . $backrground . '>';
            $html .= '<h4 style="color:' . $cs_promobox_title_color . ' !important;' . $align . '"> ' . esc_html($cs_promobox_title) . ' </h4>';
            $html .= '<p style="color:' . $cs_promobox_content_color . ' ;' . $align . '">' . do_shortcode($content) . '</p>';
            $html .= '<a class="read-more" href="' . esc_url($cs_link) . '" style="' . $cs_promobox_btn_bg_color . ' ' . $cs_promobox_btn_text_color . ' ' . $align . '">';
            $html .= '<i class="icon-uniEAB5"></i>' . esc_html($cs_link_title) . '</a>';
            $html .= '</section>';
            $html .= '</div>';
            $html .= '</div>';
        } else if (isset($promobox_view) && $promobox_view == 'view4') {

            $html = '';
            $html .='<div class="' . $column_class . '">';
            if (isset($cs_promobox_section_title) && $cs_promobox_section_title != '') {
                $html .='<div class="cs-section-title"> <h2>' . esc_html($cs_promobox_section_title) . '</h2> </div>';
            }
            $html .='<figure class="cs-custom-add">
				<a>
				<img alt="" src="' . esc_url($cs_promo_image_url) . '"></a>
				<figcaption>
				<h4><a href="#" style="color:' . $cs_promobox_title_color . ' !important;">' . esc_html($cs_promobox_title) . '</a></h4>
				<p style="color:' . $cs_promobox_content_color . ' ;">' . do_shortcode($content) . '</p>
				<a class="download-btn" style="' . $cs_promobox_btn_bg_color . ' ' . $cs_promobox_btn_text_color . ' " href="' . esc_url($cs_link) . '">' . esc_html($cs_link_title) . '</a>
				</figcaption>
				</figure>
				</div>';
        } else if (isset($promobox_view) && $promobox_view == 'view5') {

            $html = '';
            $html .='<div class="' . $column_class . '">';
            if (isset($cs_promobox_section_title) && $cs_promobox_section_title != '') {
                $html .='<div class="cs-section-title"> <h2>' . esc_html($cs_promobox_section_title) . '</h2> </div>';
            }
            $html .='<div class="cs-newslist medium-news">
                      <article>
                        <figure><a href="#"><img alt="" src="' . esc_url($cs_promo_image_url) . '"></a> <figcaption><a href="' . esc_url($cs_link) . '"><i class="icon-video-camera2"></i> Video Tour</a></figcaption></figure>
                        <div class="news-info">
                          <h4><a href="#">' . esc_html($cs_promobox_title) . '</a></h4>
                          <p style="color:' . $cs_promobox_content_color . ' ;">' . do_shortcode($content) . '</p>
                          <a class="cs-readmore-btn cs-hovercolor" style="' . $cs_promobox_btn_bg_color . ' ' . $cs_promobox_btn_text_color . ' "
						   href="' . esc_url($cs_link) . '"><i class="icon-arrow-right10"></i> ' . esc_html($cs_link_title) . '</a>
                        </div>
                      </article>
                    </div>
                  </div>';
        }

        return $html;
    }

    if (function_exists('cs_short_code'))
        cs_short_code(CS_SC_PROMOBOX, 'cs_promobox_shortcode');
}