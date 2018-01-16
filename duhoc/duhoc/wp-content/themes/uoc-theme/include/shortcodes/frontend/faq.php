<?php

/*
 *
 * @Shortcode Name : FAQ
 * @retrun
 *
 */

if (!function_exists('cs_faq_shortcode')) {

    function cs_faq_shortcode($atts, $content = "") {
        global $acc_counter, $cs_faq_view_title, $cs_faq_view;
        $acc_counter = rand(40, 9999999);
        $html = '';
        $defaults = array(
            'column_size' => '1/1',
            'class' => 'cs-faq',
            'faq_class' => '',
            'cs_faq_section_title' => '',
            'cs_faq_view' => 'simple'
        );
        extract(shortcode_atts($defaults, $atts));
        $column_class = cs_custom_column_class($column_size);

        $CustomId = '';
        if (isset($faq_class) && $faq_class) {
            $CustomId = 'id="' . $faq_class . '"';
        }

		$faq_style_class='';

        $section_title = '';
        if (isset($cs_faq_section_title) && trim($cs_faq_section_title) <> '') {
            $section_title = '<div class="cs-section-title"><h4>' . esc_html($cs_faq_section_title) . '</h4></div>';
        }
		
		if (isset($cs_faq_view) && $cs_faq_view == 'modern') {
		
			$faq_view = 'simple';
			$html .= '<div ' . $CustomId . ' class="' . $column_class . '">';
			$html .= $section_title;
			$html .= '<div class="panel-group cs-default ' . $faq_style_class . ' ' . $faq_view . '" id="accordion-' . $acc_counter . '">' . do_shortcode($content) . '</div>';
			$html .= '</div>';
			
		} else if (isset($cs_faq_view) && $cs_faq_view == 'simple') {
			
			$html .= '<div ' . $CustomId . ' class="' . $column_class . '">';
			$html .= $section_title;
			$html .= '<div class="panel-group cs-default" id="accordion-' . $acc_counter . '">' . do_shortcode($content) . '</div>';
			$html .= '</div>';
			
		} else {
			
		   		$section_title = '<div class="cs-section-title"><h4>'.esc_html($cs_faq_section_title).'</h4></div>';
				$html .= '<div class="col-md-12 cs-list" id="cs-list' . $acc_counter . '">';
				$html .= $section_title;
				$html .= '<div class="liststyle">';
				$html .= '<div class="panel-group cs-default cs-accordion-list" id="accordion-' . $acc_counter . '">';
					$html .= do_shortcode($content) ;
				$html .= '</div>';
				$html .= '</div>';
				$html .= '</div>';
			
		}
		
		
		

        return $html;
    }

    if (function_exists('cs_short_code')) cs_short_code(CS_SC_FAQ, 'cs_faq_shortcode');
}

/*
 *
 * @FAQ Item
 * @retrun
 *
 */
if (!function_exists('cs_faq_item_shortcode')) {

    function cs_faq_item_shortcode($atts, $content = "") {
        global $acc_counter, $faq_animation, $cs_faq_view_title, $cs_faq_view;
		
        $defaults = array('faq_title' => 'Title', 'faq_active' => '', 'cs_faq_icon' => '');
        extract(shortcode_atts($defaults, $atts));
		
        $faq_count = 0;
        $faq_count = rand(40, 9999999);
        $html = "";
        $active_in = '';
        $active_class = '';
        $styleColapse = '';
        $styleColapse = 'collapse collapsed';
        $cs_faq_icon = isset($cs_faq_icon) ? $cs_faq_icon : '';
       
		if (isset($faq_active) && $faq_active == 'yes') {
				$styleColapse = '';
				$active_in = 'in';
				$open  = 'class="" aria-expanded="true" ';
		} else {
				$active_in = 'collapsed';
				$open  = 'class="collapsed" aria-expanded="true" '; 
		}
		
		
		/*$cs_faq_icon_class = '';
		if (isset($cs_faq_icon)) {
		$cs_faq_icon_class = '<i class="' . $cs_faq_icon . '"></i>';
		}
*/            
		  $html = '';
		 if (isset($cs_faq_view) && $cs_faq_view == 'simple') {


            $html .= '<div class="panel panel-default">';
            $html .= '<div class="panel-heading">';
            $html .= '<h4 class="panel-title">';
            $html .= '<a class="" href="#accordion-' . $faq_count . '" data-parent="#accordion-' . $faq_count . '" data-toggle="collapse">';
             $html .=  'Q.'.esc_attr($faq_title) ;
            $html .= '</a>';
            $html .= ' </h4>';
            $html .= '</div>';
            $html .= '<div class="panel-collapse collapse ' . $active_in . '" id="accordion-' . $faq_count . '">';
            $html .= '<div class="panel-body">';
            $html .= '<p>' . do_shortcode($content) . '</p>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= ' </div>';
      
	    } else if (isset($cs_faq_view) && $cs_faq_view == 'modern') {


		    $html .= '<div class="panel panel-default">';
            $html .= '<div class="panel-heading">';
            $html .= '<h4 class="panel-title">';
            $html .= '<a  href="#accordion-'.$faq_count.'" data-parent="#accordion-' . $faq_count . '" data-toggle="collapse" '.$open.'>';
            $html .=  'Q.'.esc_attr($faq_title) ;
            $html .= '</a>';
            $html .= '</h4>';
            $html .= '</div>';
            $html .= '<div class="panel-collapse  collapse ' .$active_in.'" id="accordion-' .$faq_count. '">';
            $html .= '<div class="panel-body">';
            $html .= '<p>' . do_shortcode($content) . '</p>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
			
        }  else {
         
		 $html .= '<div class="panel panel-default">';
				$html .= '<div class="panel-heading">';
				$html .= '<h4 class="panel-title">';
				$html .= '<a  href="#accordion-' . $faq_count . '" data-parent="#accordion-' . $faq_count . '" data-toggle="collapse" '.$open.'>';
				$html .=    	esc_attr($faq_title);
				$html .= '</a>';
				$html .= '</h4>';
				$html .= '</div>';
				$html .= '<div class="panel-collapse collapse ' . $active_in . '" id="accordion-' . $faq_count . '">';
				$html .= '<div class="panel-body">';
					$html .= '<ul>';
						$html .= '<li>' . do_shortcode(cs_allow_special_char($content)) . '</li>';
					$html .= '</ul>';
				$html .= '</div>';
				$html .= '</div>';
			$html .= '</div>';
        }


        return $html;
    }

    if (function_exists('cs_short_code')) cs_short_code(CS_SC_FAQITEM, 'cs_faq_item_shortcode');
}
?>