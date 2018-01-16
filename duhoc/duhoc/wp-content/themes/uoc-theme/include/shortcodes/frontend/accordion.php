<?php
/*
 *
 *@Shortcode Name : Accordion
 *@retrun
 *
 */

if (!function_exists('cs_accordion_shortcode')) {
    function cs_accordion_shortcode($atts, $content = "") {
        global $acc_counter,$accordian_style;
        $acc_counter = rand(40, 9999999);;
        $html    = '';
        $defaults = array(
		'column_size'=>'1/1', 
		'class' => 'cs-accrodian',
		'accordian_style' => '',
		'accordion_class' => '',
		'accordion_animation' => '',
		'cs_accordian_section_title'=>''
		);
        extract( shortcode_atts( $defaults, $atts ) );
        $column_class  = cs_custom_column_class($column_size);
        
        $CustomId    = '';
        if ( isset( $accordion_class ) && $accordion_class ) {
            $CustomId = 'id="'.$accordion_class.'"';
        }
        
        if ( trim($accordion_animation) !='' ) {
            $accordion_animation    = 'wow'.' '.$accordion_animation;
        } else {
            $accordion_animation    = '';
        }
        $section_title = '';
        if(isset($cs_accordian_section_title) && trim($cs_accordian_section_title) <> ''){
            $section_title = '<div class="cs-section-title"><h4>'.esc_html($cs_accordian_section_title).'</h4></div>';
        }
        if ( $accordian_style == 'default' ) {
            $styleClass    = 'default';
        }else{
            $styleClass    = 'default';
        }
        $html .= '<div '.$CustomId.' class="'.$column_class.'">';
        $html .= '<div class="panel-group simple-veiw '.$styleClass.' '.$accordion_class.' '.$accordion_animation.'" id="accordion-' . $acc_counter . '">'.$section_title.do_shortcode($content).'</div>';
        $html .= '</div>';
        return $html;
    }
    
    if (function_exists('cs_short_code')) cs_short_code(CS_SC_ACCORDION, 'cs_accordion_shortcode');
}

/*
 *
 *@Accordion Item
 *@retrun
 *
 */
if (!function_exists('cs_accordion_item_shortcode')) {
    function cs_accordion_item_shortcode($atts, $content = "") {
        global $acc_counter,$accordian_style,$accordion_animation;
        $defaults = array( 'accordion_title' => 'Title','accordion_active' => 'yes','cs_accordian_icon' => '');
        extract( shortcode_atts( $defaults, $atts ) );
        $accordion_count = 0;
        $accordion_count = rand(40, 9999999);
        $html = "";
        $active_in = '';
        $active_class = '';
        $styleColapse = 'collapse collapsed';
        
        if(isset($accordion_active) && $accordion_active == 'yes'){
            $active_in = 'in';
            $styleColapse = '';
        }
        else{
            $active_class = 'collapsed';
        }
        $faq_style = '';
        
        $cs_accordian_icon_class = '';
        if(isset($cs_accordian_icon)){
            $cs_accordian_icon = '<i class="'.$cs_accordian_icon.'"></i>';
        }
        $html = '<div class="panel panel-default">
                    <div class="panel-heading">
                      <a data-toggle="collapse" data-parent="#accordion-'.$acc_counter.'" href="#accordion-'.$accordion_count.'" class="'.sanitize_html_class($active_class).'">
                         ' . $cs_accordian_icon . $accordion_title . '
                      </a>
                    </div>
                    <div id="accordion-'.$accordion_count.'" class="panel-collapse collapse '.$active_in.' ">
                      <div class="panel-body"><p>'.$content.'</p></div>
                    </div>
                  </div>';
        return $html;
    }
    if (function_exists('cs_short_code')) cs_short_code(CS_SC_ACCORDIONITEM, 'cs_accordion_item_shortcode');
}

?>