<?php
/*
 *
 *@File : Call to action
 *@retrun
 *
 */	
if (!function_exists('cs_call_to_action_shortcode')) {
    function cs_call_to_action_shortcode($atts, $content = "") {
        $defaults = array(
		'column_size' => '1/1',
		'cs_call_to_action_section_title'=>'',
		'cs_content_type'=>'',
		'cs_call_action_title'=>'',
		'cs_call_to_action_text'=>'',
		'cs_call_to_action_view'=>'',
		 'cs_call_to_action_left_img'=>'',
		'cs_contents_color'=>'', 
		'cs_call_view' =>'',
		'cs_call_action_icon'=>'',
		'cs_icon_color'=>'#FFF',
		'cs_call_to_action_icon_background_color'=>'',
		'cs_call_to_action_button_text'=>'',
		'cs_call_to_action_button_link'=>'',
		'cs_call_to_action_bg_img'=>'',
		'cs_call_to_action_icon_button_color'=>'',
		'cs_call_to_action_button_bg_color'=>'',
       );
	 
	 
	   extract( shortcode_atts( $defaults, $atts ) );
       $column_class  = cs_custom_column_class($column_size);
       $cell_button = '';
       $CustomId    = '';
       $cs_call_action_title    = isset($cs_call_action_title) ? $cs_call_action_title : '';
	   $cs_call_to_action_text = isset($cs_call_to_action_text) ? $cs_call_to_action_text : '';
	   $cs_call_to_action_button_text = isset($cs_call_to_action_button_text) ? $cs_call_to_action_button_text : '';
       $cs_contents_color = isset($cs_contents_color) ? $cs_contents_color : '';
	   $cs_call_action_icon = isset($cs_call_action_icon) ? $cs_call_action_icon : '';
	   $cs_call_to_action_bg_img = isset($cs_call_to_action_bg_img) ? $cs_call_to_action_bg_img : '';
	    $cs_call_to_action_left_img = isset($cs_call_to_action_left_img) ? $cs_call_to_action_left_img : '';
		$cs_call_to_action_icon_background_color = isset($cs_call_to_action_icon_background_color) ? $cs_call_to_action_icon_background_color : '';
		
	   
		$cs_call_view  = isset($cs_call_view) ? $cs_call_view : '';
		$style='';
		
		if(isset($cs_call_to_action_icon_button_color) && $cs_call_to_action_icon_button_color <> ""){
		
			$style='style="background:'.$cs_call_to_action_button_bg_color.'; color:'.$cs_call_to_action_icon_button_color.';"';   
		}
		if(isset($cs_call_to_action_button_bg_color) && $cs_call_to_action_button_bg_color <> ""){
		
			$style='style="background:'.$cs_call_to_action_button_bg_color.' !important; color:'.$cs_call_to_action_icon_button_color.';"';
		}
		$logo='';   
 	
	if(isset($cs_call_to_action_view) && $cs_call_to_action_view  == 'simple'){
	
		
		$html='';
		$html .='<div style="background:url('.$cs_call_to_action_bg_img.') no-repeat; background-size:cover;" class="call-actions ac-classic">';
			$html .='<div class="cell heading">';
				$html .='<div class="ac-text">';
					$html .='<h4 style="color:'.$cs_contents_color.' !important">'.esc_html($cs_call_action_title).'</h4>';
					$html .='<p>'.$cs_call_to_action_text.'.</p>';
				$html .='</div>';
			$html .='</div>';
				$html .='<div class="cell call-btn">';
					$html .='<a class="csbg-color" href="'. esc_url( $cs_call_to_action_button_link ).'"  '.$style.'>'.$cs_call_to_action_button_text.'</a>';
				$html .='</div>';
		$html .='</div>';
		
	}else{
	
			$logo='<i class="'.$cs_call_action_icon.' offers-icon"></i>';
			if(isset($cs_call_view) && $cs_call_view =='image'){
				$logo ='<img src="'.esc_url($cs_call_to_action_left_img).'" alt="Call to action Image" />';
			}
	
	
	    	$html='';  
			$html .='<section class="page-section fullbackground-gray"  style="background:'.$cs_call_to_action_icon_background_color.' !important;">';	
			$html .='<div class="container">';
				$html .='<div class="row">';
					$html .='<div class="col-md-12 margin-bottom">';
					$html .='<div class="offers-icon-left">';
						//$html .='<i class="'.$cs_call_action_icon.' offers-icon"></i>';
						$html .=$logo;
					$html .='</div>';
					$html .='<div class="col-md-8">';
						$html .='<h4 style="color:'.$cs_contents_color.' !important">'.esc_html($cs_call_action_title).'</h4>';
						$html .='<p class="whitecolor-text" style="color:'.$cs_contents_color.' !important">';
						$html .= ''.$cs_call_to_action_text.'';
						$html .=' </p>';
						$html .='</div>';
						$html .='<div class="get-enrole-button">';
							$html .='<button onclick="location.href=\''.esc_url($cs_call_to_action_button_link).'\'" class="get-enrole"  '.$style.'>'.$cs_call_to_action_button_text.'  </button>';
						$html .='</div>';
					$html .='</div>';
				$html .='</div>';
			$html .='</div>';
		$html .='</section>'; 
		
		
		
}
												
	
 

		 
        return '<div ' . $CustomId . ' class="' . sanitize_html_class($column_class) . '">' . $html . '</div>';
    }
    if (function_exists('cs_short_code')) cs_short_code(CS_SC_CALLTOACTION, 'cs_call_to_action_shortcode');
}