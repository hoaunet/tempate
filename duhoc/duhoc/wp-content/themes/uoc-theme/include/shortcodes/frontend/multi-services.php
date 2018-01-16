<?php
/*
*
*@Shortcode Name : Multiple Service
*@retrun
*
*/

if (!function_exists('cs_multiple_services_shortcode')){
    function cs_multiple_services_shortcode($atts, $content = "") {
        $defaults = array(
            'column_size' => '1/1',
            'cs_multiple_service_section_title' => '',
            'multiple_services_element_size' => '',
            'cs_multiple_services_view' => ''
        );

        global $post,$cs_multiple_services_view, $multiple_services_element_size,$slider_counter;
        extract(shortcode_atts($defaults, $atts));
        $column_class = cs_custom_column_class($column_size);
        $cs_section_title = '';
        if (isset($cs_multiple_service_section_title) && trim($cs_multiple_service_section_title) <> '') {
        	$cs_section_title = '<div class="cs-section-title col-md-12"><h4>' . esc_attr($cs_multiple_service_section_title) . '</h4></div>';
        }

        $cs_html = '';

        $cs_html .= $cs_section_title;
		
		if( $cs_multiple_services_view == 'slider' ) {
		cs_owl_carousel();
		?>
        <script type="text/javascript">
			var $ = jQuery;
			$(document).ready(function(){
			$('.cs-carousel').owlCarousel({
					nav: true,
					margin: 0,
					navText: [
					  "<i class=' icon-angle-left'></i>",
					  "<i class='icon-angle-right'></i>"
					],
					responsive: {
					  0: {
						items: 1 // In this configuration 1 is enabled from 0px up to 479px screen size 
					  },
		
					  480: {
						items: 2, // from 480 to 677 
						nav: false // from 480 to max 
					  },
		
					  678: {
						items: 3, // from this breakpoint 678 to 959
						center: false // only within 678 and next - 959
					  },
		
					  960: {
						items: 3, // from this breakpoint 960 to 1199
						center: false,
						loop: false
		
					  },
		
					  1200: {
						items: 3,
					  }
					}
		
				  });
				  });
		</script>
        <?php
		$cs_html .= '<div class="cs-blog cs-blog-grid owl-carousel cs-carousel">';
		}
		
		$cs_html .= do_shortcode($content);
		
		if( $cs_multiple_services_view == 'slider' ) {
		$cs_html .= '</div>';
		}
		
		return do_shortcode($cs_html);
	}

    if (function_exists('cs_short_code')) cs_short_code(CS_SC_MULTPLESERVICES, 'cs_multiple_services_shortcode');
}

/*
*
*@Multiple Service Item
*@retrun
*
*/

if ( ! function_exists('cs_multiple_services_item_shortcode') ) {
	
    function cs_multiple_services_item_shortcode($atts, $content = "") {
        $defaults = array(
            'cs_title_color' => '',
            'cs_text_color' => '',
            'cs_bg_color' => '',
            'cs_website_url' => '',
            'cs_multiple_service_title' => '',
            'cs_multiple_service_logo' => '',
        );
        global $post,$cs_multiple_services_view, $multiple_services_element_size, $slider_counter;
        extract(shortcode_atts($defaults, $atts));
        $cs_html = '';
        $cs_title_color = $cs_title_color <> '' ? ' style="color:' . $cs_title_color . ' !important;"' : '';
        $cs_text_color = $cs_text_color <> '' ? ' style="color:' . $cs_text_color . ' !important;"' : '';
        $cs_bg_color = $cs_bg_color <> '' ? ' style="background-color:' . $cs_bg_color . ' !important;"' : '';
		
		if( $cs_multiple_services_view == 'classic' ) {
		$cs_html .= '
		<div class="element-size-25">
			<div class="cs-services cs-modren col-md-12">
				<div class="cs-img-holder">';
					
					if( $cs_multiple_service_logo <> '' ) {
					$cs_html .= '
					<figure>
						<img alt="'.cs_get_post_img_title($post->ID).'" src="'.esc_url($cs_multiple_service_logo).'">
					</figure>';
					}
				
				$cs_html .= '
				</div>
				<div class="cs-text">';
					if( $cs_multiple_service_title <> '' ) {
						if( $cs_website_url <> '' ) {
							$cs_html .= '<h4'.$cs_title_color.'><a'.$cs_title_color.' href="'.esc_url($cs_website_url).'">'.esc_attr($cs_multiple_service_title).'</a></h4>';
						}
						else{
							$cs_html .= '<h4'.$cs_title_color.'>'.esc_attr($cs_multiple_service_title).'</h4>';
						}
					}
					if( $content <> '' ) {
					$cs_html .= '<p'.$cs_text_color.'>'.do_shortcode($content).'</p>';
					}
					
				$cs_html .= '
				</div>
			</div>
		</div>';
		
		} else if( $cs_multiple_services_view == 'modren' ) {
		$cs_html .= '
		<div class="element-size-25">
			<article'.$cs_bg_color.' class="cs-services cs-box">';
				if( $cs_multiple_service_logo <> '' ) {
				$cs_html .= '
				<figure>
					<img alt="'.cs_get_post_img_title($post->ID).'" src="'.esc_url($cs_multiple_service_logo).'">
				</figure>';
				}
				$cs_html .= '
				<div class="cs-text">';
					if( $cs_multiple_service_title <> '' ) {
						if( $cs_website_url <> '' ) {
							$cs_html .= '<h3'.$cs_title_color.'><a'.$cs_title_color.' href="'.esc_url($cs_website_url).'">'.esc_attr($cs_multiple_service_title).'</a></h3>';
						}
						else{
							$cs_html .= '<h3'.$cs_title_color.'>'.esc_attr($cs_multiple_service_title).'</h3>';
						}
					}
					if( $content <> '' ) {
					$cs_html .= '<p'.$cs_text_color.'>'.do_shortcode($content).'</p>';
					}
				$cs_html .= '
				</div>
			</article>
		</div>';
		
		} else {
			
		$cs_html .= '
		<article class="col-md-4">
			<div class="cs-media">';
				if( $cs_multiple_service_logo <> '' ) {
				$cs_html .= '
				<figure>
					<img alt="'.cs_get_post_img_title($post->ID).'" src="'.esc_url($cs_multiple_service_logo).'">
					<figcaption></figcaption>
				</figure>';
				}
				$cs_html .= '
				<div class="cs-bloginfo-sec">';
					if( $cs_multiple_service_title <> '' ) {
						if( $cs_website_url <> '' ) {
							$cs_html .= '<h3'.$cs_title_color.'><a'.$cs_title_color.' href="'.esc_url($cs_website_url).'">'.esc_attr($cs_multiple_service_title).'</a></h3>';
						}
						else{
							$cs_html .= '<h3'.$cs_title_color.'>'.esc_attr($cs_multiple_service_title).'</h3>';
						}
					}
					if( $content <> '' ) {
					$cs_html .= '<p'.$cs_text_color.'>'.do_shortcode($content).'</p>';
					}
				$cs_html .= '
				</div>
			</div>
		</article>';
		}
   
        return do_shortcode($cs_html);
    }

	if (function_exists('cs_short_code')) cs_short_code(CS_SC_MULTPLESERVICESITEM, 'cs_multiple_services_item_shortcode');
}

?>