<?php
/*
 *
 *@Shortcode Name : Clients
 *@retrun
 *
 */

if (!function_exists('cs_clients_shortcode')) {
    function cs_clients_shortcode($atts, $content = "") {
        global  $post, $cs_clients_view,$cs_client_border,$cs_client_gray;
        $defaults = array(
		'column_size'=>'',
		'cs_clients_view' => 'Grid View',
		'cs_client_gray' => 'Yes',
		'cs_client_border' => 'Yes',
		'cs_client_section_title' => 'Our Partners',
		'cs_client_class' => ''
		);
        extract( shortcode_atts( $defaults, $atts ) );
        	
		
        $CustomId    = '';
        if ( isset( $cs_client_class ) && $cs_client_class ) {
            $CustomId    = 'id="'.$cs_client_class.'"';
        }

        $column_class  = cs_custom_column_class($column_size);
        $owlcount = rand(40, 9999999);
        $cs_client_section_title = isset($cs_client_section_title) ? $cs_client_section_title : '';
        $html  = '';
		cs_owl_carousel();
		cs_enqueue_flexslider_script();
        
		$html .='<div '.$CustomId.' class="'.$column_class.'">';
			$html .='<div class="cs-section-title"> <h4>'.esc_html($cs_client_section_title).'</h4> </div>';
			$html .='<div class="cs-custom-nav cs-partner">';
				$html .= do_shortcode($content);
			$html .='</div>';
		$html .='</div>';
		
		return $html;
    }
    if (function_exists('cs_short_code')) cs_short_code(CS_SC_CLIENTS, 'cs_clients_shortcode');
}

/*
 *
 *@Clinets Item
 *@retrun
 *
 */
if (!function_exists('cs_clients_item_shortcode')) {
    function cs_clients_item_shortcode($atts, $content = "") {
        global $post,$cs_clients_view,$cs_client_border,$cs_client_gray;
        $defaults = array('cs_bg_color'=>'','cs_website_url'=>'','cs_client_title'=>'','cs_client_logo'=>'');
        extract( shortcode_atts( $defaults, $atts ) );
	 
        $html         = '';
       $grayScale = (isset($cs_client_gray) && $cs_client_gray == 'yes')? 'grayscale' : '';
	   $cs_client_logo = isset($cs_client_logo) ? $cs_client_logo : '';
        $tooltip    = '';
        if ( isset ( $cs_client_title ) && $cs_client_title != '' ) {
            $tooltip    = 'title="'.esc_html($cs_client_title).'"';
        }
        $cs_url = $cs_website_url ?  $cs_website_url : 'javascript:;';
         
        $html .='<div class="item">
					<figure>
						<a href="'.esc_url( $cs_url ).'"><img src="'.esc_url($cs_client_logo).'" alt="'.cs_get_post_img_title($post->ID).'"></a>
					</figure>
				</div>';		
		return $html;
    }
    if (function_exists('cs_short_code')) cs_short_code(CS_SC_CLIENTSITEM, 'cs_clients_item_shortcode');
}