<?php
/*
 *
 * @File : List
 * @retrun
 *
 */
if (!function_exists('cs_list_openinghours')) {

    function cs_list_openinghours($atts, $content = "") {
        global $cs_border, $cs_list_type;
        $defaults = array(
			 'column_size' =>'', 
			 'cs_list_section_title' =>'',
			 'cs_list_type' =>'', 
			 'cs_list_icon' =>'', 
			 'cs_border' =>'', 
			 'cs_list_item' =>'', 
			 'cs_list_class' =>'',
			 'cs_schadule_text'=>''
			 
			 );
		extract(shortcode_atts($defaults, $atts));
        $customID = '';
        if (isset($column_size) && $column_size != '') {
            $column_class = cs_custom_column_class($column_size);
        } else {
            $column_class = '';
        }
        if (isset($cs_list_class) && $cs_list_class != '') {
            $customID = 'id="' . $cs_list_class . '"';
        }
        $html = "";
        $cs_list_typeClass = '';
        $section_title = '';
        if ($cs_list_section_title && trim($cs_list_section_title) != '') {
         
			$section_title = '<div class="cs-section-title"><h4>'.esc_html($cs_list_section_title).'</h4></div>';
		}
		
           $html .= '
		   <div class="opening-hours '.$column_class.'">';
				$html .=$section_title;
				$html .='<div class="cs-opening">';
				$html .= '<ul>';
				$html .= do_shortcode($content);		
				$html .= '</ul>';
				$html .= '</div>
			</div>';
		return $html;
    }

    if (function_exists('cs_short_code')) cs_short_code(CS_SC_OPENINGHOURS, 'cs_list_openinghours');
}

if (!function_exists('cs_openinghours_item_shortcode')) {

    function cs_openinghours_item_shortcode($atts, $content = "") {
        global $cs_border, $cs_list_type;
        $html = '';
        $defaults = array('cs_list_icon' =>
            '', 'cs_list_item' =>
            '', 'cs_cusotm_class' =>
            '', 'cs_custom_animation' =>
            '', 'cs_custom_animation' =>
            '',
			'cs_schadule_text'=>''
			);
		 extract(shortcode_atts($defaults, $atts));
        if ($cs_border == 'yes') {
            $border = 'border-bottom:1px solid #e4e4e4;';
        } else {
            $border = '';
        }
		
		$html .= '<li>
				<span class="day">'.$cs_list_item.'</span>
				<div class="timehoure">
					<span class="time-start"><i class="icon-clock"></i>' . do_shortcode(htmlspecialchars_decode($content)) . '</span>
				</div>
			</li>';
		
		return $html;
    }

    if (function_exists('cs_short_code')) cs_short_code(CS_SC_OPENINGHOURS_LISTITEM, 'cs_openinghours_item_shortcode');
}