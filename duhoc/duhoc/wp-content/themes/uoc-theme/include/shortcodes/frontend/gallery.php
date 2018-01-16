<?php
/*
 *
 *@File : Gallery
 *@retrun
 *
 */	
 
if (!function_exists('cs_gallery_shortcode')) {
    function cs_gallery_shortcode($atts, $content = "") {
        global $cs_node,$cs_counter_node;
        $defaults = array(
		'column_size' => '',
		'cs_gallery_section_title' => '',
		'cs_gal_header_title' => '',
		'cs_gal_layout' => '',
		'cs_gal_album' => '',
		'cs_gal_pagination' => '',
		'cs_gal_media_per_page' => '',
		'cs_gallery_class' => '',
		'cs_gallery_animation' => '',
		'cs_custom_animation_duration' => ''
		);
        extract( shortcode_atts( $defaults, $atts ) );
        $column_class             = cs_custom_column_class($column_size);
        
        $CustomId    = '';
        if ( isset( $cs_gallery_class ) && $cs_gallery_class ) {
            $CustomId    = 'id="'.$cs_gallery_class.'"';
        }
        
        $html = '';
        if(!empty($cs_gal_album)){
        cs_prettyphoto_enqueue();
            $count_post = 0;
            $section_title = '';
            if ($cs_gallery_section_title && trim($cs_gallery_section_title) !='') {
                $section_title    = '<div class="cs-section-title"><h2>'.esc_html($cs_gallery_section_title).'</h2></div>';
            }
        // galery slug to get id start
        
            $args=array(
                'name' => (string)$cs_gal_album,
                'post_type' => 'cs_gallery',
                'post_status' => 'publish',
                'showposts' => 1,
            );
            $get_posts = get_posts($args);
            if($get_posts){
                $gal_album_db = $get_posts[0]->ID;
            }
        // galery slug to get id end
        $cs_meta_gallery_options = get_post_meta((int)$gal_album_db, "cs_meta_gallery_options", true);
        if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;
        // pagination start
        if ( $cs_meta_gallery_options <> "" ) {
            $cs_xmlObject = new SimpleXMLElement($cs_meta_gallery_options);
            if ($cs_gal_media_per_page > 0 ) {
                $limit_start = $cs_gal_media_per_page * ($_GET['page_id_all']-1);
                $limit_end = $limit_start + $cs_gal_media_per_page;
                $count_post = count($cs_xmlObject);
                    if ( $limit_end > count($cs_xmlObject) ) 
                        $limit_end = count($cs_xmlObject);
            } else {
                $limit_start = 0;
                $limit_end   = count($cs_xmlObject);
                $count_post  = count($cs_xmlObject);
            }
        }
        
        $column_class    = cs_custom_column_class($column_size);
        $html .= '<div '.$CustomId.' class="'. $column_class . ' '. $cs_gallery_class . ' ' . $cs_gallery_animation . '" style=" animation-duration: '.$cs_custom_animation_duration.'s;">';
        $html .= $section_title;
        if ($cs_gal_layout == 'gallery-slider') {    
            $html .= '<div class="flexslider '. $cs_gallery_class . ' ' . $cs_gallery_animation .'" style=" animation-duration: '.$cs_custom_animation_duration.'s;">';
            $html .= '<ul class="slides">';
            if ( $cs_meta_gallery_options <> "" ) {
                for ( $i = $limit_start; $i < $limit_end; $i++ ) {
                $path                 = $cs_xmlObject->gallery[$i]->path;
                $title                 = $cs_xmlObject->gallery[$i]->title;
                $social_network     = $cs_xmlObject->gallery[$i]->social_network;
                $use_image_as         = $cs_xmlObject->gallery[$i]->use_image_as;
                $video_code         = $cs_xmlObject->gallery[$i]->video_code;
                $link_url             = $cs_xmlObject->gallery[$i]->link_url;
                $image_url_full     = cs_attachment_image_src((int)$path, 0, 0);
                $id                    = trim( $path );
                $image_title         = get_the_title($id);
                    if (isset($image_url_full)  && $image_url_full !="" ) { 
                        $html .= '<li data-thumb="'.$image_url_full.'"><img src="'.esc_url($image_url_full).'" alt='.esc_html($image_title).'></li>';
                    }
                }

            }
            $html .= '</ul>';
            $html .= '</div>';
            //==Pagination Start
             if ( $cs_gal_pagination == "Show Pagination" and $count_post > $cs_gal_media_per_page and $cs_gal_media_per_page > 0 ) {
                $qrystr = '';
                if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
                $html .=  cs_pagination($count_post, $cs_gal_media_per_page,$qrystr,'Show Pagination');
             }
            //==Pagination End
        } else if ($cs_gal_layout == 'gallery-four-col') {
            $html .= '<div class="gallerylist js-isotope row lightbox clearfix '. $cs_gallery_class . ' ' . $cs_gallery_animation .'" style=" animation-duration: '.$cs_custom_animation_duration.'s;" id="containerth">';
            if ( $cs_meta_gallery_options <> "" ) {
                for ( $i = $limit_start; $i < $limit_end; $i++ ) {
                $path                 = $cs_xmlObject->gallery[$i]->path;
                $title                 = $cs_xmlObject->gallery[$i]->title;
                $social_network     = $cs_xmlObject->gallery[$i]->social_network;
                $use_image_as         = $cs_xmlObject->gallery[$i]->use_image_as;
                $video_code         = $cs_xmlObject->gallery[$i]->video_code;
                $link_url             = $cs_xmlObject->gallery[$i]->link_url;
                $image_url_full     = cs_attachment_image_src((int)$path, 0, 0);
                $id                    = trim( $path );
                $image_title         = get_the_title($id);
                
                    if (isset($image_url_full)  && $image_url_full !="" ) { 
                        $html .= '<article class="item col-md-3 has_border">';
                        $html .= '<figure>';
                        $html .= '<a data-rel="prettyPhoto[gallery-four-col]>" data-title="'.esc_html($image_title).'"  href="'.esc_url($image_url_full).'">'. "<img src='".esc_url($image_url_full)."' data-alt='".$image_title."' alt='".$image_title."' />" .'</a>';
                        if (isset($image_title) && $image_title != "") {
                            $html .= '<figcaption>';
                            $html .= '<a href="javascript:;">'.esc_html($image_title).'</a>';
                            $html .= '</figcaption>';
                        }
                        $html .= '</figure>';
                        $html .= '</article>';
                    }
                }
            }
            $html .= '</div>';
            //==Pagination Start
             if ( $cs_gal_pagination == "Show Pagination" and $count_post > $cs_gal_media_per_page and $cs_gal_media_per_page > 0 ) {
                $qrystr = '';
                if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
                $html .=  cs_pagination($count_post, $cs_gal_media_per_page,$qrystr,'Show Pagination');
             }
            //==Pagination End
        } else if ($cs_gal_layout == 'gallery-wordpress') {
            $html .= '<div class="gallerylist js-isotope row galthumbnail lightbox clearfix '. $cs_gallery_class . ' ' . $cs_gallery_animation .'" style=" animation-duration: '.$cs_custom_animation_duration.'s;" id="containertw">'; 
            if ( $cs_meta_gallery_options <> "" ) {
                for ( $i = $limit_start; $i < $limit_end; $i++ ) {
                $path                 = $cs_xmlObject->gallery[$i]->path;
                $title                 = $cs_xmlObject->gallery[$i]->title;
                $social_network     = $cs_xmlObject->gallery[$i]->social_network;
                $use_image_as         = $cs_xmlObject->gallery[$i]->use_image_as;
                $video_code         = $cs_xmlObject->gallery[$i]->video_code;
                $link_url             = $cs_xmlObject->gallery[$i]->link_url;
                $image_url_full     = cs_attachment_image_src((int)$path, 0, 0);
                $id                    = trim( $path );
                $image_title         = get_the_title($id);
                    
                    if (isset($image_url_full)  && $image_url_full !="" ) {     
                        $html .= '<article class="item col-md-1">';
                        $html .= '<figure>';
                        $html .= '<a data-rel="prettyPhoto[gallery-wordpress]>" data-title="'.esc_html($image_title).'"  href="'.esc_url( $image_url_full ).'">'. "<img src='".esc_url( $image_url_full )."' data-alt='".$image_title."' alt='".$image_title."' />" .'</a>';

                        if (isset($image_title) && $image_title != "") {
                            $html .= '<figcaption>';
                            $html .= '<a href="javascript:;">'.esc_html($image_title).'</a>';
                            $html .= '</figcaption>';
                        }
                        $html .= '</figure>';
                        $html .= '</article>';
                    }
                }
            }
            $html .= '</div>';
            
            //==Pagination Start
             if ( $cs_gal_pagination == "Show Pagination" and $count_post > $cs_gal_media_per_page and $cs_gal_media_per_page > 0 ) {
                $qrystr = '';
                if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
                $html .=  cs_pagination($count_post, $cs_gal_media_per_page,$qrystr,'Show Pagination');
             }
            //==Pagination End
            
        } else if ($cs_gal_layout == 'gallery-masonry') { 
            cs_isotope_enqueue();
            $html .= '<script>
                        jQuery(document).ready(function($){
                            cs_masonary_js();
                        });    
                      </script>';
            $html .= '<div class="gallerylist js-isotope row lightbox clearfix '. $cs_gallery_class . ' ' . $cs_gallery_animation .'" style=" animation-duration: '.$cs_custom_animation_duration.'s;" id="containeron">';
            
            if ( $cs_meta_gallery_options <> "" ) {

                for ( $i = $limit_start; $i < $limit_end; $i++ ) {
                    
                $path                 = $cs_xmlObject->gallery[$i]->path;
                $title                 = $cs_xmlObject->gallery[$i]->title;
                $social_network     = $cs_xmlObject->gallery[$i]->social_network;
                $use_image_as         = $cs_xmlObject->gallery[$i]->use_image_as;
                $video_code         = $cs_xmlObject->gallery[$i]->video_code;
                $link_url             = $cs_xmlObject->gallery[$i]->link_url;
                $image_url_full     = cs_attachment_image_src((int)$path, 0, 0);
                $id                    = trim( $path );
                $image_title         = get_the_title($id);
                
                    if (isset($image_url_full)  && $image_url_full !="" ) { 
                        $html .= '<article class="item col-md-3 has_border">';
                        $html .= '<figure>';
                        $html .= '<a data-rel="prettyPhoto[gallery-masonry]>" target="" data-title="'.esc_html($image_title).'"  href="'.esc_url( $image_url_full ).'">'. "<img src='".$image_url_full."' data-alt='".$image_title."' alt='".$image_title."' />" .'</a>';
                        
                        if (isset($image_title) && $image_title != "") {
                            $html .= '<figcaption>';
                            $html .= '<a href="javascript:;">'.esc_html($image_title).'</a>';
                            $html .= '</figcaption>';
                        }
                        
                        $html .= '</figure>';
                        $html .= '</article>';
                    }
                }
            }
            $html .= '</div>';
            
            //==Pagination Start
             if ( $cs_gal_pagination == "Show Pagination" and $count_post > $cs_gal_media_per_page and $cs_gal_media_per_page > 0 ) {
                $qrystr = '';
                if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
                $html .=  cs_pagination($count_post, $cs_gal_media_per_page,$qrystr,'Show Pagination');
             }
            //==Pagination End    
        }
        $html .= '</div>';
        }
        return $html;
    }
    if (function_exists('cs_short_code')) cs_short_code('cs_gallery', 'cs_gallery_shortcode');
}

if (!function_exists('cs_album_item_shortcode')) {
    function cs_album_item_shortcode($atts, $content = "") {
        $defaults = array('cs_album_track_title'=>'', 'cs_album_track_mp3_url'=>'');
        extract( shortcode_atts( $defaults, $atts ) );
        
        $html = '';
        if (isset($cs_album_track_mp3_url) && !empty($cs_album_track_mp3_url)) {
            
            $html .= '<source src="'.esc_url($cs_album_track_mp3_url).'" title="'.esc_html($cs_album_track_title).'">'; 
        }
        
        return $html;
    }
    if (function_exists('cs_short_code')) cs_short_code('album_item', 'cs_album_item_shortcode');
}