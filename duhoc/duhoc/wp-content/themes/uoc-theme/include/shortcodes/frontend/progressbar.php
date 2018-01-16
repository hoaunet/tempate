<?php

/*
 *
 * @Shortcode Name : Progressbar
 * @retrun
 *
 */

if (!function_exists('cs_progressbars_shortcode')) {

    function cs_progressbars_shortcode($atts, $content = "") {
        global $cs_progressbars_style;
        $defaults = array(
            'column_size' => '1/1',
            'cs_progressbars_style' => 'skills-sec',
            'section_title' => '',
            'progressbars_class' => ''
        );
        extract(shortcode_atts($defaults, $atts));
        $column_class = cs_custom_column_class($column_size);
        $CustomId = '';
        $section_title = isset($section_title) ? $section_title : '';
        if (isset($progressbars_class) && $progressbars_class) {
            $CustomId = 'id="' . $progressbars_class . '"';
        }
		
		cs_skillbar_script();
      
        $progressbars_style_class = '';
        $progressbars_bar_class_v2 = '';
        $progressbars_bar_class = 'skills-v3';
	
        $heading_size = 'h5';
       
        $output = '';
        /*$output .= '<div id="cs-skills" class="col-md-12">';
        $output .= '<div class="cs-section-title">';
        $output .= '<h2>'.$section_title.'</h2>';
        $output .= '</div>';
        $output .= '<div class="cs-skills cs-plain">';
        $output .= do_shortcode($content);
        $output .= '</div></div>';*/

		$output .='<div class="col-md-12" id="progressbar">
					<div class="skills-sec">';
					if(isset($section_title) && $section_title <> ""){
						$output .='<h4>'.$section_title.'</h4>';
					}
							
		$output .= do_shortcode($content);				
		$output .= '</div>
		</div>';

      return $output;
        
    }

    if (function_exists('cs_short_code')) cs_short_code(CS_SC_PROGRESSBAR, 'cs_progressbars_shortcode');
}

if (!function_exists('cs_progressbar_item_shortcode')) {

    function cs_progressbar_item_shortcode($atts, $content = "") {
        global $cs_progressbars_style;
        $defaults = array('progressbars_title' => '', 'progressbars_color' => '#4d8b0c', 'progressbars_percentage' => '50');
		
		extract(shortcode_atts($defaults, $atts));
		$output = '';
		$output_title = '';
		$progressbars_style_class = '';
		$heading_size = 'h5';
		$progressbars_color = isset($progressbars_color) ? $progressbars_color : '';
		$output = '';
		
		$output .= '<h5>'.esc_html($progressbars_title).'</h5>
					<div class="skillbar" data-percent="'.$progressbars_percentage.'%">
						<div class="skillbar-bar" style="background: '.$progressbars_color.';"><small>'.$progressbars_percentage.'%</small></div>
					</div>';
		
		return $output;
		
	}

    if (function_exists('cs_short_code')) cs_short_code(CS_SC_PROGRESSBARITEM, 'cs_progressbar_item_shortcode');
}
?>