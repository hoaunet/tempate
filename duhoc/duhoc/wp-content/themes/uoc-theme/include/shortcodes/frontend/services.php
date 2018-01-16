<?php

/*
 *
 * @Shortcode Name : Services
 * @retrun
 *
 */

if (!function_exists('cs_services_shortcode')) {

    function cs_services_shortcode($atts, $content = null) {
        global $service_type, $post;

        $defaults = array(
            'column_size' => '1/1',
            'cs_service_icon_type' => '',
            'cs_service_border_right' => '',
			'cs_link_url'=>'',
            'cs_service_icon' => '',
            'cs_service_icon_color' => '',
            'cs_service_bg_image' => '',
            'cs_service_bg_color' => '',
            'service_icon_size' => '',
            'cs_service_postion_modern' => '',
            'cs_service_title' => '',
            'cs_service_title_color' => '',
            'cs_service_content_color' => '',
            'cs_service_btn_text_color' => '',
            'cs_service_content' => '',
            'cs_service_link_text' => '',
            'cs_service_link_color' => '',
            'cs_service_url' => '',
            'cs_service_class' => '',
			'cs_view_style' =>''
        );
		
		
        extract(shortcode_atts($defaults, $atts));
		$column_class = cs_custom_column_class($column_size);

        $html = '';
        $bgColor = '';
        $bgColorClass = '';
        $align = '';
        $linkColor = '';
        $LinkIcon = '';

        $CustomId = '';
        if (isset($cs_service_class) && $cs_service_class) {
            $CustomId = 'id="' . $cs_service_class . '"';
        }


        if (isset($cs_service_link_text) && $cs_service_link_text != '') {
            $more = $cs_service_link_text;
        } else {
            $more = __('Read More', 'uoc');
        }

        if (isset($cs_service_icon_color) && $cs_service_icon_color != '') {
            $iconColor = 'style="color:' . $cs_service_icon_color . ' !important;"';
        } else {
            $iconColor = '';
        }
        $align = $cs_service_postion_modern;
        $LinkIcon = '<i class="icon-angle-right"></i>';
        if (isset($cs_service_link_color) && $cs_service_link_color != '') {
            $linkColor = 'style="color: ' . $cs_service_link_color . ' !important;"';
        } else {
            $linkColor = '';
        }
		
		if(isset($cs_link_url) && $cs_link_url <> ""){
		 	$cs_link_url = $cs_link_url;	
		}else{
			$cs_link_url='#';	
		}
		
		

        $cs_service_border_class = $cs_service_border_right == 'yes' ? ' no-right-border' : '';
        $cs_service_title_color = $cs_service_title_color <> '' ? ' style="color:' . $cs_service_title_color . ' !important;"' : '';
        $cs_service_content_color = $cs_service_content_color <> '' ? ' style="color:' . $cs_service_content_color . ' !important;"' : '';
        $cs_service_btn_text_color = $cs_service_btn_text_color <> '' ? ' color:' . $cs_service_btn_text_color . ' !important;' : '';
		$heading='';
		$class = '';
		$classAlign='';
        if(isset($cs_service_postion_modern) && $cs_service_postion_modern == 'left'){ // LEFT
			$classAlign = 'left';
			$heading =' <h4 '.$cs_service_title_color.'>'.esc_html($cs_service_title).'</h4>';
			$class='cs-services cs-classic';
		}else{
			
			if(isset($cs_service_postion_modern) && $cs_service_postion_modern == 'top'){ // RIGHT
				$classAlign = 'to-center';
				$heading =' <h4 '.$cs_service_title_color.'>'.esc_html($cs_service_title).'</h4>';
				$class='cs-services cs-classic';
			}else{
				  if(isset($cs_service_postion_modern) && $cs_service_postion_modern == 'top_left'){ // TOP LEFT
				 	   $classAlign = '';
					   $heading =' <h4 '.$cs_service_title_color.'>'.esc_html($cs_service_title).'</h4>';
					   $class='cs-services';
					  
				  }
			  }
		}
		
			if(isset($cs_service_icon_type) && $cs_service_icon_type  == 'icon'){
				$icon = '<i class="'.$cs_service_icon.'"></i>';		
			}else{
				$icon = '<img alt="#" src="'.esc_url($cs_service_bg_image).'">';	
			}
			
			
			
			$html .= '<div class="'.$class.' '.$classAlign.' '.$column_class.'">';
				$html .= '<figure>';
					$html .= '<a href='.esc_url($cs_link_url).'>'.$icon.'</a>';
					$html .= '<figcaption><a href='.esc_url($cs_link_url).'></a></figcaption>'; 
				$html .= '</figure>';
					$html .= '<div class="text">';
						$html .= '<a href='.esc_url($cs_link_url).'>'.$heading.'</a>';
						$html .= '<p ' . $cs_service_content_color . '>'.do_shortcode($content).'</p>';
					$html .= '</div>';
			$html .= '</div>';

		return $html;
    }

    if (function_exists('cs_short_code')) cs_short_code(CS_SC_SERVICES, 'cs_services_shortcode');
}

/*
 *
 * @Services Contents
 * @retrun
 *
 */
if (!function_exists('cs_service_content')) {

    function cs_service_contentt($atts, $content = null) {
        $defaults = array('content' => '');
        extract(shortcode_atts($defaults, $atts));
        return '<p ' . $cs_service_content_color . '>' . $content . '</p>';
    }

    if (function_exists('cs_short_code')) cs_short_code('content', 'cs_service_content');
}
?>