<?php

/*
 *
 * @Shortcode Name : Testimonial
 * @retrun
 *
 */

if (!function_exists('cs_testimonials_shortcode')) {

    function cs_testimonials_shortcode($atts, $content = null) {
        global $testimonial_style, $cs_testimonial_class, $column_class, $testimonial_text_color, $section_title, $post,$testimonial_view_style,$counter;
        $randomid = rand(0, 999);
        $defaults = array('column_size' => '1/1', 'testimonial_style' => '', 'testimonial_text_color' => '', 'cs_testimonial_text_align' => '', 'cs_testimonial_section_title' => '', 'cs_testimonial_class' => '','testimonial_view_style'=>'','testimonial_bg_color'=>'');
        extract(shortcode_atts($defaults, $atts));
        $column_class = cs_custom_column_class($column_size);
        $html = '';
        $section_title = '';
		
		$counter =1;
		$bgColor ='';
		if(isset($testimonial_view_style) && $testimonial_view_style  == 'simple'){
		  	
		   if(isset($testimonial_bg_color) && $testimonial_bg_color <> ""){
			    $bgColor = $testimonial_bg_color;
		   }
		      if(isset($cs_testimonial_section_title) && $cs_testimonial_section_title <> ""){
		    $html .='<h4>'.esc_html($cs_testimonial_section_title).'</h4>';
			  }
			$html.= ' <div class="'.$column_class.'" style="background:'.$bgColor.';">';
				$html.= ' <div class="cs-testimonial">';
					$html .= '' . do_shortcode($content) . '';
				$html.= ' </div>';
			$html.= '  </div>';
		}else{ // slider
		?>
		        <script type='text/javascript'>
             
                   jQuery(window).load(function() {
                  jQuery('.cs-testimonial-slider').flexslider({
            slideshowSpeed: 4000,
            animationDuration: 1100,
            animation: 'slide',
            directionNav: true,
            controlNav: false,
            prevText: "<i class='icon-arrow-left10'></i>",
            nextText: "<i class='icon-arrow-right10'></i>",
        }); });
        </script>
		<?php	 cs_enqueue_flexslider_script();
			          $html .='<h4>'.esc_html($cs_testimonial_section_title).'</h4>';
					  	$html.= ' <div class="'.$column_class.'" style="background:'.$bgColor.';">';
					$html .='   <div class="cs-testimonial testimonial-slider">';
					$html .='    <div class="cs-testimonial-slider">';
					$html .='    <ul class="slides">';
					$html .= '' . do_shortcode($content) . '';	
					$html .='   </ul>';
					$html .='  </div>';
				   $html .=' </div>';
				    $html .=' </div>';
			 
		
		}
		
		
		
	
		return $html;
    }

    if (function_exists('cs_short_code')) cs_short_code(CS_SC_TESTIMONIALS, 'cs_testimonials_shortcode');
}
/*
 *
 * @Shortcode Name : Testimonial Item
 * @retrun
 *
 */
if (!function_exists('cs_testimonial_item')) {

    function cs_testimonial_item($atts, $content = null) {
        global $testimonial_style, $cs_testimonial_class, $column_class, $testimonial_text_color, $post,$testimonial_view_style,$counter;
        $defaults = array('testimonial_author' => '', 'testimonial_img' => '', 'cs_testimonial_text_align' => '', 'testimonial_company' => '','testimonial_author_company'=>'');
        extract(shortcode_atts($defaults, $atts));
		//echo "testimonial_view_style =".$testimonial_view_style;
        $figure = '';
        $html = '';
        if (isset($testimonial_img) && $testimonial_img <> '') {
            $testimonial_img_id = cs_get_attachment_id_from_url($testimonial_img);
            $width = 150;
            $height = 150;
            $testimonial_img_url = cs_attachment_image_src($testimonial_img_id, $width, $height);
        }
        
		$tc_color = '';
        if (isset($testimonial_text_color) && $testimonial_text_color <> '') {
            $tc_color = 'style=color:' . $testimonial_text_color . '!important';
        }
		
		
		
		if(isset($testimonial_view_style) && $testimonial_view_style  == 'simple'){ // simple
		    	   
				  $html.= ' <div class="question-mark">';
							if(isset($testimonial_img_url) and $testimonial_img_url<>''){$html.= ' <figure><img src="' . esc_url($testimonial_img_url) . '" alt="image"></figure>';}
							$html.= ' <p ' . $tc_color . '>' . do_shortcode($content) . '</p>';
							$html.= ' <div class="cs-author">';
							$html.= ' <h6>' . $testimonial_author . '</h6>';
							$html.= ' <span>'.$testimonial_author_company.'</span>';
							$html.= ' </div>';
						$html.= ' </div>';
						
					if($counter == 2){
					 	$html='';	
					}
				$counter++;			
		}else{
				
				
				$html .='<li>';
				$html .='<div class="question-mark">';
			if(isset($testimonial_img_url) and $testimonial_img_url<>''){ $html.= ' <figure><img src="' . esc_url($testimonial_img_url) . '"></figure>';}
				$html .='<p ' . $tc_color . '>' . do_shortcode($content) . '</p>';
				$html .='<div class="cs-author">';
			    $html .='<h6>' . $testimonial_author . '</h6>';
				$html .='<span>'.$testimonial_author_company.'</span>';
				$html .='</div>';
				$html .='</div>';
				$html .='</li>';
								
				 
		}
		
		return $html;
    }

    if (function_exists('cs_short_code')) cs_short_code(CS_SC_TESTIMONIALSITEM, 'cs_testimonial_item');
}