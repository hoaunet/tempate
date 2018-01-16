<?php

if (!function_exists('cs_heading_shortcode')) {

    function cs_heading_shortcode($atts, $content = "") {

        $defaults = array(
            'column_size' => '1/1',
            'heading_title' => '',
            'color_title' => '',
            'heading_color' => '#000',
            'class' => 'cs-heading-shortcode',
            'heading_style' => '1',
            'heading_style_type' => '1',
            'heading_size' => '',
            'font_weight' => '',
            'sub_heading_title' => '',
            'heading_font_style' => '',
            'heading_align' => 'center',
            'heading_divider' => '',
            'heading_color' => '',
            'heading_content_color' => '',
			'bottom_border'=>''
        );
		
		
		
		
        extract(shortcode_atts($defaults, $atts));
        $column_class = cs_custom_column_class($column_size);
        $html = '';
		$he_font_style ='';
        $sub_heading_title = isset($sub_heading_title) ? $sub_heading_title : '';
        $heading_style = isset($heading_style) ? $heading_style : '';
		
		if(isset($bottom_border) && $bottom_border  =='on'){
			$border = 'style="border-bottom:1px solid #ebebe9 !important;"';
		}else{
			$border = 'style="border-bottom:none !important;"';
		}
		
			$html .= '<div class="cs-heading-sec col-md-12">';
			$html .= '<div class="inner-sec" '.$border.'  >';
			if($heading_title <>'') { 
		     $html .= '<h' . $heading_style . ' style="color:' . $heading_color . ' !important; font-size: ' . $heading_size . 'px !important; text-align:' . $heading_align . ';' . $he_font_style . ';">' . esc_html($heading_title) . '</h' . $heading_style . '>'; }
			$html .= '<div style="color:' . $heading_content_color . ' !important; text-align: ' . $heading_align . ';' . $he_font_style . ';">';
			 
         	$html .= '' . do_shortcode($content) . '';
			$html .= '</div>';
			$html .= '</div>';
			
			if ($heading_divider == 'on') {
				$html .= '<div class="cs-seprator"><div class="devider1"></div></div>';
			}
		$html .= '</div>';
			
		return do_shortcode($html);
    }

    if (function_exists('cs_short_code')) cs_short_code(CS_SC_HEADING, 'cs_heading_shortcode');
}