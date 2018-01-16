<?php
/**
 * The template for displaying header
 */
global  $cs_options, $cs_theme_options, $cs_node, $cs_xmlObject, $cs_page_option, $post;
 	$cs_site_layout 	= '';
    $cs_theme_options = get_option('cs_theme_options');
    //$cs_theme_options = get_option('cs_theme_options');
	if(!get_option('cs_theme_options')){
            $cs_activation_data = theme_default_options();
            $cs_theme_options =  $cs_activation_data;
            $cs_theme_options['cs_default_layout_sidebar'] = 'sidebar-1';
			$cs_theme_options['cs_single_layout_sidebar'] = 'sidebar-1';
            $cs_theme_options['cs_footer_widget'] = 'off';
    }
    $cs_builtin_seo_fields =$cs_theme_options['cs_builtin_seo_fields'];
    if(isset($cs_theme_options['cs_layout'])){ $cs_site_layout =$cs_theme_options['cs_layout'];} else { $cs_site_layout == '';}
		$cs_post_id =isset($post->ID) ? $post->ID : '';
		if(isset($cs_post_id) and $cs_post_id <> ''){
			$cs_postObject		= get_post_meta($post->ID,'cs_full_data',true);
		}else{
			$cs_post_id = '';
		}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>><head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
		<?php
 		$cs_builtin_seo_fields = $cs_theme_options['cs_builtin_seo_fields'];
 		if(isset($cs_builtin_seo_fields) && $cs_builtin_seo_fields == 'on'){
			$cs_seo_title 		= isset($cs_postObject['cs_seo_title']) ? $cs_postObject['cs_seo_title'] : '';
			$cs_seo_description = isset($cs_postObject['cs_seo_description']) ? $cs_postObject['cs_seo_description'] : $cs_theme_options['cs_meta_description'];
			$cs_seo_keywords	= isset($cs_postObject['cs_seo_keywords']) ? $cs_postObject['cs_seo_keywords'] : $cs_theme_options['cs_meta_keywords'];
		    $cs_uoc_style	= isset($cs_postObject['cs_uoc_style']) ? $cs_postObject['cs_uoc_style'] : '';
			?>
            <meta name="title" content="<?php echo esc_attr($cs_seo_title);?>">
            <meta name="keywords" content="<?php echo esc_attr($cs_seo_keywords);?>">
          	<meta name="description" content="<?php echo esc_textarea($cs_seo_description);?>">
            <?php } ?>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php esc_url(bloginfo( 'pingback_url' )); ?>">    
    <?php 
        if(isset($cs_theme_options['cs_custom_style']) and $cs_theme_options['cs_custom_style']<>''){
		$cs_content = $cs_theme_options['cs_custom_style'];
		$content = str_replace(array('&gt;'), '>', $cs_content);
            echo '<style type="text/css">
                '.$content. '
				
            </style>';
        }
        if(isset($cs_theme_options['cs_custom_js']) and $cs_theme_options['cs_custom_js']<>''){
       		 echo '<script type="text/javascript">
					 ' . $cs_theme_options['cs_custom_js'] . '
				  </script> ';
        }
        if ( function_exists( 'cs_header_settings' ) ) { cs_header_settings(); }           
		if(isset($cs_theme_options['cs_style_rtl']) and $cs_theme_options['cs_style_rtl']=='on'){
            cs_rtl();
			$cs_rtl_cls = 'rtl';
        }else{
			$cs_rtl_cls = '';
		}
		$cs_res_cls =(isset($cs_theme_options['cs_responsive']) && $cs_theme_options['cs_responsive'] == "on") ? 'cbp-spmenu-push' :'non-responsive';
		
        // Google Fonts Enqueue
		if ( function_exists( 'cs_load_fonts' ) ) { cs_load_fonts(); }
		
        if ( is_singular() && get_option( 'thread_comments' )  && get_comments_number()) {
            wp_enqueue_script( 'comment-reply' );
		}
		wp_head();
    ?>
    <style type="text/css">
    	<?php echo $cs_uoc_style;  ?>
    </style>
    </head>
    <body <?php body_class($cs_rtl_cls.' '.$cs_res_cls); if($cs_site_layout !='full_width'){ echo cs_bg_image(); }?>>
		<?php if ( function_exists( 'cs_under_construction' ) ) { cs_under_construction(); } ?>
        <!-- Wrapper -->
        <div class="wrapper wrapper_<?php cs_wrapper_class(); ?>">
			<?php 
            if ( function_exists( 'cs_get_headers' ) ) { cs_get_headers(); } ?>
            <!-- Main Content Section -->
            <main id="main-content">
                <!-- Main Section -->
                <div class="main-section">