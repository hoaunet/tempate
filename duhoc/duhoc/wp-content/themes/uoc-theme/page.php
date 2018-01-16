<?php
/**
 * The template for displaying all pages
 */
    get_header();
    global $cs_node,$cs_sidebarLayout,$cs_xmlObject,$cs_node_id,$column_attributes,$cs_paged_id;
    $cs_page_sidebar_right = '';
    $cs_page_sidebar_left = '';
	
	$cs_postObject				= get_post_meta($post->ID,'cs_full_data',true);
	$cs_page_layout				= get_post_meta($post->ID,'cs_page_layout',true);
	$cs_page_sidebar_right		= get_post_meta($post->ID,'cs_page_sidebar_right',true);
	$cs_page_sidebar_left		= get_post_meta($post->ID,'cs_page_sidebar_left',true);
	
	if ( !isset($_SESSION["cs_page_back"]) ||  isset($_SESSION["cs_page_back"])){
        $_SESSION["cs_page_back"] = get_the_ID();
		$cs_paged_id	= get_the_ID();
    }
    
	$cs_page_bulider = get_post_meta($post->ID, "cs_page_builder", true);
    
	$section_container_width ='';
    $page_element_size = 'page-content-fullwidth';
    if(!isset($cs_page_layout) || $cs_page_layout == "none"){
        $page_element_size = 'page-content-fullwidth';
    } else {
        $page_element_size = 'page-content';     
    }
    
	$cs_xmlObject = new stdClass();
    if( isset( $cs_page_bulider ) && $cs_page_bulider<>'' ){
        $cs_xmlObject = new SimpleXMLElement($cs_page_bulider);
    }
	
	if(isset($cs_page_layout))
        $cs_sidebarLayout = $cs_page_layout;    
    $pageSidebar = false;
    if ( $cs_sidebarLayout == 'left' || $cs_sidebarLayout == 'right') {
        $pageSidebar = true;
    }
 
	if (isset($cs_xmlObject) && count($cs_xmlObject) > 1) {
		
		while (have_posts()) : the_post();
        if(isset($cs_page_layout)){
            $cs_page_sidebar_right = $cs_page_sidebar_right;
            $cs_page_sidebar_left  = $cs_page_sidebar_left;
        }
        
		$cs_counter_node = $column_no = 0;
          $fullwith_style = '';
          $section_container_style_elements =' ';
          if (isset($cs_page_layout) && $cs_sidebarLayout <> '' and $cs_sidebarLayout <> "none"){
              $fullwith_style = 'style="width:100%;"';
                $section_container_style_elements =' width: 100%;';
                echo '<div class="container">';
                	echo '<div class="row">';
						if (isset($cs_page_layout) && $cs_sidebarLayout <> '' and $cs_sidebarLayout <> "none" and $cs_sidebarLayout == 'left') : ?>
							<aside class="page-sidebar">
								<?php 
								if ( is_active_sidebar( cs_get_sidebar_id( $cs_page_sidebar_left ) ) ) {
									if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_page_sidebar_left) ) : endif; 
								}
								?>
							</aside>
						<?php endif; 
               	 echo '<div class="'.sanitize_html_class($page_element_size).'">';
            }
    if (post_password_required()) {
            echo '<header class="heading"><h6 class="transform">' . get_the_title() . '</h6></header>';
            echo cs_password_form();
    } else {
           $width = 840;
           $height = 328;
           $image_url = cs_get_post_img_src($post->ID, $width, $height);
		   
			if(get_the_content() <> '' || $image_url <> '')    {
                if ( function_exists( 'cs_prettyphoto_enqueue' ) ) { cs_prettyphoto_enqueue(); }
                echo '<div class="page-section">
                        <!-- Container Start -->
                            <div  class="container">
                                <div class="row">
                                    <div class="col-md-12 lightbox">';                                    
                                    if (isset($image_url) && $image_url !=''){
										?>
										<a  href="<?php echo esc_url($image_url) ?>" data-rel="prettyPhoto" data-title="">
											<figure>
												<div class="page-featured-image">
													<img class="img-thumbnail" title="" alt="" data-src="" style="width: 100%; " src="<?php echo esc_url($image_url);?>">
												</div>
											</figure>
										</a>
										<?php 
                                    }
                                    the_content();
                                    echo '</div>
							</div>
						</div>
                    </div>';
            }
    }
		//====================
	    // @Show All Sections
        // ===================
         if(isset($cs_xmlObject->column_container))
         
		 $cs_elem_id = 0;
		 foreach ($cs_xmlObject->column_container as $column_container) {
                $cs_section_bg_image = $cs_section_bg_image_position = $cs_section_bg_image_repeat = $cs_section_bg_color = $cs_section_padding_top = $cs_section_padding_bottom = $cs_section_custom_style = $cs_section_css_id = $cs_layout = $cs_sidebar_left = $cs_sidebar_right = $css_bg_image = '';
                $section_style_elements = '';
                $section_container_style_elements = '';
                $section_video_element = '';
                $cs_section_bg_color = '';
                $cs_section_view = 'container';
                if ( isset( $column_container ) ){
                    $column_attributes= $column_container->attributes();
                     $column_class = $column_attributes->class;
                     $parallax_class = '';
                     $parallax_data_type = '';
                     $cs_section_parallax =  $column_attributes->cs_section_parallax;
                     if(isset($cs_section_parallax) && (string)$cs_section_parallax == 'yes'){
                         echo '<script>jQuery(document).ready(function($){cs_parallax_func()});</script>';
                         $parallax_class = ($cs_section_parallax =='yes') ? 'parallex-bg': '';
                         $parallax_data_type = ' data-type="background"';
                     }
                    $cs_section_margin_top =  $column_attributes->cs_section_margin_top;
                    $cs_section_margin_bottom = $column_attributes->cs_section_margin_bottom;
                    $cs_section_padding_top =  $column_attributes->cs_section_padding_top;
                    $cs_section_padding_bottom = $column_attributes->cs_section_padding_bottom;
                    $cs_section_view =  $column_attributes->cs_section_view;
                    $cs_section_border_color = $column_attributes->cs_section_border_color;
                    if(isset($cs_section_border_color) && $cs_section_border_color !=''){
                        $section_style_elements .= '';
                    }                    
                    if(isset($cs_section_margin_top) && $cs_section_margin_top !=''){
                        $section_style_elements .= 'margin-top: '.$cs_section_margin_top.'px;';
                    }
                    if(isset($cs_section_padding_top) && $cs_section_padding_top !=''){
                        $section_style_elements .= 'padding-top: '.$cs_section_padding_top.'px;';
                    }
                    if(isset($cs_section_padding_bottom) && $cs_section_padding_bottom !=''){
                        $section_style_elements .= 'padding-bottom: '.$cs_section_padding_bottom.'px;';
                    }
                    if(isset($cs_section_margin_bottom) && $cs_section_margin_bottom !=''){
                        $section_style_elements .= 'margin-bottom: '.$cs_section_margin_bottom.'px;';
                    }
                    $cs_section_border_top = $column_attributes->cs_section_border_top;
                    $cs_section_border_bottom = $column_attributes->cs_section_border_bottom;
                    if(isset($cs_section_border_top) && $cs_section_border_top !=''){
                        $section_style_elements .= 'border-top: '.$cs_section_border_top.'px '.$cs_section_border_color.' solid;';
                    }
                    if(isset($cs_section_border_bottom) && $cs_section_border_bottom !=''){
                        $section_style_elements .= 'border-bottom: '.$cs_section_border_bottom.'px '.$cs_section_border_color.' solid;';
                    }
                     $cs_section_background_option =  $column_attributes->cs_section_background_option;
                     $cs_section_bg_image_position = $column_attributes->cs_section_bg_image_position;
					 $cs_section_bg_image_repeat = $column_attributes->cs_section_bg_image_repeat;
                     if(isset($column_attributes->cs_section_bg_color))
                         $cs_section_bg_color = $column_attributes->cs_section_bg_color;
                     if(isset($cs_section_background_option) && $cs_section_background_option =='section-custom-background-image'){
                         $cs_section_bg_image = $column_attributes->cs_section_bg_image;
                         $cs_section_bg_image_position = $column_attributes->cs_section_bg_image_position;
						 $cs_section_bg_image_repeat = $column_attributes->cs_section_bg_image_repeat;
                         $cs_section_bg_imageg = '';
                         if(isset($cs_section_bg_image) && $cs_section_bg_image !=''){
                            if(isset($cs_section_parallax) && (string)$cs_section_parallax == 'yes'){
                                $cs_section_bg_imageg = 'url('.$cs_section_bg_image.') '.$cs_section_bg_image_position.' '.$cs_section_bg_image_repeat.' fixed';
                            } else {
                                $cs_section_bg_imageg = 'url('.$cs_section_bg_image.') '.$cs_section_bg_image_position.' '.$cs_section_bg_image_repeat;
                            }
                        }
                        $section_style_elements .= 'background: '.$cs_section_bg_imageg.' '.$cs_section_bg_color.';';
                     } else if(isset($cs_section_background_option) && $cs_section_background_option =='section_background_video'){
                            $cs_section_video_url = $column_attributes->cs_section_video_url;
                            $cs_section_video_mute = $column_attributes->cs_section_video_mute;
                            $cs_section_video_autoplay = $column_attributes->cs_section_video_autoplay;
                            $mute_flag = $mute_control = '';
                            $mute_flag = 'true';                                
                            if($cs_section_video_mute == 'yes'){
                                $mute_flag = 'false';    
                                $mute_control = 'controls muted ';    
                            }
                            $cs_video_autoplay = 'autoplay';
                            if($cs_section_video_autoplay == 'yes'){
                                $cs_video_autoplay = 'autoplay';
                            } else {
                                $cs_video_autoplay = '';
                            }
                            $section_video_class = 'video-parallex';
                            $url = parse_url($cs_section_video_url);
                            if($url['host'] == $_SERVER["SERVER_NAME"]){
                                $file_type = wp_check_filetype( $cs_section_video_url);
                                if(isset($file_type['type']) && $file_type['type'] <> ''){
                                    $file_type = $file_type['type'];
                                } else {
                                    $file_type = 'video/mp4';
                                }
                                $rand_player_id = rand(6,555);                                
                                $section_video_element = '<div class="page-section-video" style="width: 100%; height:100%; opacity: 1;">
                                    <video id="player'.$rand_player_id.'" width="100%" height="100%" '.$cs_video_autoplay.' loop="true" preload="none" volume="false" controls="controls" class="nectar-video-bg" style="visibility: visible; width: 1927px; height: 1083px;"  '.$mute_control.' >
                                        <source src="'.esc_url($cs_section_video_url).'" type="'.$file_type.'">
                                    </video>
                                </div>';
                            } else {
                                $section_video_element = wp_oembed_get($cs_section_video_url,array('height' =>'1083'));                        
                            }
                     } else {
                         if(isset($cs_section_bg_color) && $cs_section_bg_color !=''){
                              $section_style_elements .= 'background: '.$cs_section_bg_color.';';
                         }
                     }
                    $cs_section_padding_top = $column_attributes->cs_section_padding_top;
                    $cs_section_padding_bottom = $column_attributes->cs_section_padding_bottom;
                    if(isset($cs_section_padding_top) && $cs_section_padding_top !=''){
                        $section_container_style_elements .= 'padding-top: '.$cs_section_padding_top.'px; ';
                    }
                    if(isset($cs_section_padding_bottom) && $cs_section_padding_bottom !=''){
                        $section_container_style_elements .= 'padding-bottom: '.$cs_section_padding_bottom.'px; ';
                    }
                     $cs_section_custom_style = $column_attributes->cs_section_custom_style;
                     $cs_section_css_id = $column_attributes->cs_section_css_id;
                     if(isset($cs_section_css_id) && trim($cs_section_css_id) !=''){
                         $cs_section_css_id = 'id="'.$cs_section_css_id.'"';
                     }
                     $page_element_size = 'section-fullwidth';
                     $cs_layout = $column_attributes->cs_layout;
                     if(!isset($cs_layout) || $cs_layout == '' ||  $cs_layout == 'none'){
                        $cs_layout = "none"; 
                        $page_element_size = 'section-fullwidth';
                     } else {
                        $page_element_size = 'section-content';     
                    }
                     $cs_sidebar_left = $column_attributes->cs_sidebar_left;
                     $cs_sidebar_right = $column_attributes->cs_sidebar_right;
                }
                if(isset($cs_section_bg_image) && $cs_section_bg_image <> '' && $cs_section_background_option == 'section-custom-background-image'){
                    $css_bg_image = 'url('.$cs_section_bg_image.')';
                }
                $section_style_element = '';
                if($section_style_elements){
                    $section_style_element = 'style="'.$section_style_elements.'"';    
                }
                if($section_container_style_elements){
                    $section_container_style_elements = 'style="'.$section_container_style_elements.'"';    
                }
            ?>
                <!-- Page Section -->
                <div <?php echo cs_allow_special_char($cs_section_css_id);?> class="page-section <?php echo sanitize_html_class($parallax_class); ?>" <?php echo cs_allow_special_char($parallax_data_type);?>  <?php echo cs_allow_special_char($section_style_element);?> >
                <?php 
                    echo cs_allow_special_char($section_video_element);
                    if(isset($cs_section_background_option) && $cs_section_background_option =='section-custom-slider'){
                        $cs_section_custom_slider = $column_attributes->cs_section_custom_slider;
                        if($cs_section_custom_slider != ''){
                            echo do_shortcode($cs_section_custom_slider);
                        }
                    } 
                    if($cs_section_view == '' || $cs_section_view == NULL){
                        $cs_section_view = 'container';
                    }
                    ?>
                    <!-- Container Start -->
                     <div  class="<?php echo sanitize_html_class($cs_section_view); ?>">
                        <div class="row">
                                <?php
                                if (isset($cs_layout) && $cs_layout == "left" && $cs_sidebar_left <> '') {
                                    echo '<aside class="section-sidebar">';
										if ( is_active_sidebar( cs_get_sidebar_id( $cs_sidebar_left ) ) ) {
                                        	if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_left)) : endif;
										}
                                    echo '</aside>';
                                }
                                $cs_node_id = 0;
								
								echo '<div class="'.sanitize_html_class($page_element_size).'">';
                                foreach ($column_container->children() as $column) {
                                    $column_no++;
                                    $cs_node_id++;
                                     foreach ($column->children() as $cs_node) {  
									 	 $cs_elem_id++;                                      
                 						 if ( $cs_node->getName() == "members" ) {
                                            $page_element_size = '100';                                            
                                            if(isset($cs_node->page_element_size))  $page_element_size = $cs_node->page_element_size;
												if (cs_pb_element_sizes($page_element_size) == 'element-size-50'){
													global $member_column;
													$member_column = 'col-md-12';
												}
                                            echo '<div class="'.cs_pb_element_sizes($page_element_size).'">';
													$shortcode = trim((string)$cs_node->cs_shortcode);
													$shortcode = html_entity_decode($shortcode);
													echo do_shortcode($shortcode);
                                            echo '</div>';
                                        } else {
                                            $page_element_size = '100';
											global $cs_elem_id;
                                            if(isset($cs_node->page_element_size))  $page_element_size = $cs_node->page_element_size;
											 if(isset($_GET['uoc_title']) and $_GET['uoc_title'] !='' || 
  isset($_GET['cat']) and $_GET['cat'] != '' || isset($_GET['cs_campus']) and $_GET['cs_campus'] ){ 
                                echo '<div class="element-size-100">';
                                                $shortcode = trim((string)$cs_node->cs_shortcode);
                                                $shortcode = html_entity_decode($shortcode);
                                                echo do_shortcode($shortcode);
                                            echo '</div>';
  } else { 
                                            echo '<div class="'.cs_pb_element_sizes($page_element_size).'">';
                                                $shortcode = trim((string)$cs_node->cs_shortcode);
                                                $shortcode = html_entity_decode($shortcode);
                                                echo do_shortcode($shortcode);
                                            echo '</div>';
  }
                                        }
                                    }
                                }
                            echo '</div>';
                            if (isset($cs_layout) && $cs_layout == "right" && $cs_sidebar_right <> '') {
                                  echo '<aside class="section-sidebar">';
                                      if ( is_active_sidebar( cs_get_sidebar_id( $cs_sidebar_right ) ) ) {
									  	if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_right)) : endif;
									  }
                                  echo '</aside>';
                             }
                            ?>
                          </div>
                    </div>
                </div>
                <?php
                $column_no = 0;
            }
             if (isset($cs_page_layout) && $cs_sidebarLayout <> '' and $cs_sidebarLayout <> "none"){                
                echo '</div>';
            }
            if (isset($cs_page_layout) && $cs_sidebarLayout <> '' and $cs_sidebarLayout <> "none" and $cs_sidebarLayout == 'right') : ?>
                <aside class="page-sidebar">
                    <?php 
					if ( is_active_sidebar( cs_get_sidebar_id( $cs_page_sidebar_right ) ) ) {
						if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_page_sidebar_right) ) : endif; 
					}
					?>
                </aside>
            <?php endif; 
            if ( isset($cs_page_layout) && $cs_sidebarLayout<> '' and $cs_sidebarLayout <> "none"){    
                    echo '</div>';
                echo '</div>';
            }
			endwhile;
        } else {
        ?>
        <div class="container">        
            <!-- Row Start -->
            <div class="row">
                <div class="col-md-12">
                    <?php
                    while (have_posts()) : the_post();
                        echo '<div class="rich-text-editor">';
                            the_content();
							if ( comments_open() ) : 
								comments_template('', true); 
							endif;
                        echo '</div>';
                    endwhile;
                    ?>
               </div>
            </div>
        </div>
<?php
    }
get_footer(); ?>