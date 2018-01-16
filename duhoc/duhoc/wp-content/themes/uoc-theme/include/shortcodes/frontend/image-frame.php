<?php
/**
 *@Shortcode Name : Image Freame
 *@retrun
 *
 */
if (!function_exists('cs_image_shortcode')) {
	
    function cs_image_shortcode($atts, $content = "") {
		global $post;
   $defaults = array( 
         'column_size'=>'',
		 'cs_image_section_title' => '',
		 'image_style' => '',
		 'cs_image_url' => '#',
		 'cs_image_title' => '',
		 'cs_image_caption' => '',
		 'cs_image_custom_class'=>''
		 );
        extract( shortcode_atts( $defaults, $atts ) );
        $column_class = cs_custom_column_class($column_size);
 
        $CustomId    = '';
        if ( isset( $cs_image_custom_class ) && $cs_image_custom_class ) {
            $CustomId    = 'id="'.$cs_image_custom_class.'"';
        }

        $html = '';
        $section_title = '';
        
        if ($cs_image_section_title && trim($cs_image_section_title) !='') {
            $section_title    = '<div class="cs-section-title"><h4>'.esc_html($cs_image_section_title).'</h4></div>';
        }        
        $column_class     = cs_custom_column_class($column_size);
       	
	  if(isset($image_style) && $image_style =='simple'){
		 $style_class ='';
		}else
		if(isset($image_style) && $image_style =='classic'){
		 $style_class ='classic-frame';
		}else
		if(isset($image_style) && $image_style =='modern'){
		 $style_class ='box-frame';
		}
		
		
		$html  .= ' <article class="'.$column_class.' '.$style_class.'">';
		if( isset( $cs_image_url ) && $cs_image_url !='' ) {
			$html .= '<figure><img alt="'.cs_get_post_img_title($post->ID).'" src="'.esc_url($cs_image_url).'"> </figure>';
		}        
		
		
		if( isset( $cs_image_title ) && $cs_image_title !='' ) {
			
		$html    .= '<h4>'.esc_html($cs_image_title).'</h4>';
		
		} 
		if( isset( $content ) && $content !='' ) {
		$html    .= ''.do_shortcode($content).'';
		}        
		
		$html .= '</article>';
		if($section_title <> '') {  
		$html = '<div '.$CustomId.' class="' .$column_class. ' ' .$cs_image_custom_class. '">'.$section_title.' '.$html.'</div>';
	  }  
		return do_shortcode($html);
    }
    if (function_exists('cs_short_code')) cs_short_code(CS_SC_IMAGE, 'cs_image_shortcode');
}