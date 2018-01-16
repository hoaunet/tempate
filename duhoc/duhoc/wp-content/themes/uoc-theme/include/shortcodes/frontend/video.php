<?php

/*
 *
 * @Shortcode Name : Video
 * @retrun
 *
 */

if (!function_exists('cs_video_shortcode')) {

    function cs_video_shortcode($atts, $content = "") {
        $defaults = array(
            'column_size' => '',
            'cs_video_section_title' => '',
            'video_url' => '',
            'video_width' => '500',
            'video_height' => '300',
            'cs_video_custom_class' => '',
            'cs_video_custom_animation' => 'slide',
            'cs_video_custom_animation_duration' => ''
        );

;
        extract(shortcode_atts($defaults, $atts));
        $column_class = cs_custom_column_class($column_size);

        $width = isset($video_width) ? $video_width : '500';
        $height = isset($video_height) ? $video_height : '300';
        $cs_video_custom_class = isset($cs_video_custom_class) ? $cs_video_custom_class : '';
        $cs_video_custom_animation = isset($cs_video_custom_animation) ? $cs_video_custom_animation : '';
        $cs_video_custom_animation_duration = isset($cs_video_custom_animation_duration) ? $cs_video_custom_animation_duration : '';
        $cs_video_section_title = isset($cs_video_section_title) ? $cs_video_section_title : '';
        $video_url = isset($video_url) ? $video_url : '';
        $url = parse_url($video_url);
        $CustomId = '';
 
        if (isset($cs_video_custom_class) && $cs_video_custom_class) {

            $CustomId = 'id="' . $cs_video_custom_class . '"';
        }

        if (trim($cs_video_custom_animation) != '') {
            $cs_video_custom_animation = 'wow' . ' ' . $cs_video_custom_animation;
        } else {

            $cs_video_custom_animation = '';
        }
		
		$cs_frame = '<i'.'frame ';
		
        $column_class = cs_custom_column_class($column_size);
        $section_title = '';
        if ($url['host'] == $_SERVER["SERVER_NAME"]) {

            $video = '<div class="cs-holder col-md-12">';
            $video .= '<div class="cs-section-title ">';
            $video .= '<div class="section-inner "><h4>' . esc_html($cs_video_section_title) . '</h4></div>';
             $video .= '<div class="">';
            $video .= '<figure  class="' . $column_class . '  wow slide ' . $cs_video_custom_animation . '" style=" animation-duration: s;">
					<div class="image-frame frame-plane  lightbox">';
            $video .= '' . do_shortcode('[video width="' . $width . '" height="' . $height . '" src="' . esc_url($video_url) . '"][/video]') . '';
            $video .= '</div>
					</figure>';
            $video .= '</div>';
            $video .= '</div>';
            $video .= '</div>';
			return $video;
          
        } elseif($url['host'] == 'vimeo.com') {

           
                $content_exp = explode("/", $video_url);
                $content_vimo = array_pop($content_exp);

                $video = '<div class="cs-holder col-md-12">';
                $video .= '<div class="cs-section-title ">';
                $video .= '<div class="section-inner"><h2>' . esc_html($cs_video_section_title) . '</h2></div>';
                $video .= '<div class="">';
                $video .= '<figure  class="' . $column_class . '  wow slide ' . $cs_video_custom_animation . '" style=" animation-duration: s;">';
				$video .= '<div class="image-frame frame-plane  lightbox">';
                $video .= $cs_frame.' width="' . $width . '" height="' . $height . '" src="https://player.vimeo.com/video/' . $content_vimo . '" frameborder="0" 	webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
						   </div>';
                $video .= '</figure>';
                $video .= '</div>';
                $video .= '</div>';
                $video .= '</div>';
				return $video;
               
            }elseif($url['host'] == 'www.youtube.com'){  
				 
		  	 		$video = '';
                     $cs_youtube = explode('/', $video_url);
					 $cs_value = end($cs_youtube);
					 $cs_value = isset($cs_value) ? $cs_value : '';
                     $value = str_replace('watch?v=','/',$cs_value );
				     $value = isset($value) ? $value : '';
					 $video .= '<div class="cs-section-title ">';
                	 $video .= '<div class="section-inner"><h2>' . esc_html($cs_video_section_title) . '</h2></div></div>';
			 	     $video .=  '<iframe width="' . $width . '" height="' . $height . '" src="https://www.youtube.com/embed'.cs_allow_special_char($value).'" frameborder="0" allowfullscreen></iframe>'; 
					?>
                    <?php 
						 return $video;
					}
					else {
                $content = str_replace(array('watch?v=', 'http://www.dailymotion.com/'), array('embed/', '//www.dailymotion.com/embed/'), $video_url);
				
                $video = '<div class="cs-holder col-md-12">';
                $video .= '<div class="cs-section-title ">';
                $video .= '<div class="section-inner"><h2>' . esc_html($cs_video_section_title) . '</h2></div>';
                  $video .= '<div class="">';
                $video .= $cs_frame.'  class="' . $column_class . '  wow slide ' . $cs_video_custom_animation . '" style=" animation-duration: s;">';
                $video .= '<div class="fluid-width-video-wrapper">
							<div class="image-frame frame-plane  lightbox">
								'.$cs_frame.' width="' . $width . '" height="' . $height . '" src="' . $content . '" 
									frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
							</div>';
                $video .= '</figure>';
                $video .= '</div>';
				$video .= '</div>';
                $video .= '</div>';
                $video .= '</div>';
					 return $video;
					 
               
            }
		
        }

    
		

       
   

    if (function_exists('cs_short_code')) cs_short_code(CS_SC_VIDEO, 'cs_video_shortcode');
}