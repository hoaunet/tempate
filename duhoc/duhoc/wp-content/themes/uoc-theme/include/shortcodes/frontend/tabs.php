<?php

/*

 *

 *@Shortcode Name : Tabs

 *@retrun

 *

 */

if (!function_exists('cs_tabs_shortcode')) {

    function cs_tabs_shortcode( $atts, $content = null ) {

        global $tabs_content;
        $tabs_content = '';
        extract(shortcode_atts(array('cs_tab_style' => '','cs_tabs_class' => '','column_size'=>'1/1','cs_tabs_section_title' => ''), $atts));  
        $column_class  = cs_custom_column_class($column_size);
        $randid = rand(4248,9999);
        $section_title = '';
        $tabs_output = '';

        if ( isset($cs_tabs_section_title) && trim($cs_tabs_section_title) !='' ) {

            $section_title    = '<div class="cs-section-title"><h4>'.esc_html($cs_tabs_section_title).'</h4></div>';

        }
        $tabs_vertical_classs = (isset($cs_tab_style) and $cs_tab_style == 'vertical') ? 'vertical' : 'nav-position-top';

		$tabs_output .= '<div  id="cs-tab">';
				$tabs_output .= $section_title;
        		$tabs_output .= '<ul class="nav nav-tabs">';
				 	$tabs_output .= do_shortcode($content);
        		$tabs_output .= '</ul>'; 
       			$tabs_output .= '<div class="tab-content">'.do_shortcode($tabs_content).'</div>';
        $tabs_output .= '</div>';

		return '<div class="'.$column_class.' cs-tabs box">'.$tabs_output.'</div>';
	}  

    if (function_exists('cs_short_code')) cs_short_code(CS_SC_TABS, 'cs_tabs_shortcode');

}



/**

 *

 * @Tabs Item

 *

 */

if (!function_exists('cs_tab_item_shortcode')) {

    function cs_tab_item_shortcode($atts, $content = null) {  

        global $tabs_content;
        extract(shortcode_atts(array(  

            'cs_tab_icon' => '',
            'tab_title' => '',
            'cs_tab_icon' => '',
            'tab_active'=>'no' 

        ), $atts));  

		$activeClass = ($tab_active == 'yes' || $tab_active == 'Yes') ? 'active in' :'';
        $randid = rand(877,9999);

        $output = ' <li class="'.$activeClass.'"><a aria-expanded="true" href="#tab'.sanitize_title($tab_title).$randid.'" data-toggle="tab">'.esc_html($tab_title).'</a></li>';
		$tabs_content.= '<div class="tab-pane fade '.$activeClass.'" id="tab'.sanitize_title($tab_title).$randid.'">
							<div class="tab-contents">'.do_shortcode($content).'</div>
						</div>';

		return $output;

    }

    if (function_exists('cs_short_code')) cs_short_code( CS_SC_TABSITEM, 'cs_tab_item_shortcode' );

}

?>