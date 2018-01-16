<?php
/*
 *
 * @File : List
 * @retrun
 *
 */
if (!function_exists('cs_list_shortcode')) {

    function cs_list_shortcode($atts, $content = "") {
        global $cs_border, $cs_list_type;
        $defaults = array(
			 'column_size' =>'', 
			 'cs_list_section_title' =>'',
			 'cs_list_type' =>'', 
			 'cs_list_icon' =>'', 
			 'cs_border' =>'', 
			 'cs_list_item' =>'', 
			 'cs_list_class' =>''
			 
			 );
        extract(shortcode_atts($defaults, $atts));
		$cs_list = rand(0,999999);
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
       if($cs_list_type == 'simple'){
			 $cs_list_typeClass ='class="cs-linked-list"';
		}else
		if($cs_list_type == 'icon'){
			 $cs_list_typeClass = 'cs-iconlist';
		}
		
		
		 $html .= '<div class="col-md-12  cs-list" id="cs-list'.$cs_list.'" >';
					$html .=$section_title;
						$html .= '<div class="liststyle" >';
							$html .='<ul class="'.$cs_list_typeClass.'">';
								$html .= do_shortcode($content);
							$html .='</ul>
						</div>
				</div>';
		
		
        return $html;
    }

    if (function_exists('cs_short_code')) cs_short_code(CS_SC_LIST, 'cs_list_shortcode');
}

if (!function_exists('cs_list_item_shortcode')) {

    function cs_list_item_shortcode($atts, $content = "") {
        global $cs_border, $cs_list_type;
        $html = '';
        $defaults = array('cs_list_icon' =>
            '', 'cs_list_item' =>
            '', 'cs_cusotm_class' =>
            '', 'cs_custom_animation' =>
            '', 'cs_custom_animation' =>
            '');
        extract(shortcode_atts($defaults, $atts));
        if ($cs_border == 'yes') {
            $border = 'border-bottom:1px solid #e4e4e4;';
        } else {
            $border = '';
        }
		
        if ($cs_list_icon && $cs_list_type == 'icon') {
			$bullets ='';
            $html .= '<li   style="'.$border.'"><i class="' . $cs_list_icon . '" ></i>&nbsp;' . do_shortcode(htmlspecialchars_decode($content)) . '</li>';
        } else if ($cs_list_icon && $cs_list_type == 'bullets') {
			$bullets='list-style-type: disc;';
            $html .= '<li   style="'.$border.''.$bullets.'">' . do_shortcode(htmlspecialchars_decode($content)) . '</a></li>';
        }  else if ($cs_list_icon && $cs_list_type == 'simple') {
			$bullets ='';
            $html .= '<li  style="'.$border.'">' . do_shortcode(htmlspecialchars_decode($content)) . '</a></li>';
        }
		
		return $html;
    }

    if (function_exists('cs_short_code')) cs_short_code(CS_SC_LISTITEM, 'cs_list_item_shortcode');
}