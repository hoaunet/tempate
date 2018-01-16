<?php
if (!function_exists('cs_blog_shortcode')) {
    function cs_blog_shortcode( $atts ) {
        global $post,$wpdb,$cs_theme_options,$cs_counter_node,$column_attributes,$cs_blog_cat,$cs_blog_description,$cs_blog_excerpt,$post_thumb_view,$cs_blog_num_tab;
         $defaults = array('cs_blog_section_title'=>'','cs_blog_sub_section_title'=>'','cs_blog_view'=>'','cs_blog_cat'=>'','cs_blog_orderby'=>'DESC','orderby'=>'ID','cs_blog_description'=>'yes','cs_blog_excerpt'=>'255','cs_blog_num_post'=>'10','blog_pagination'=>'','cs_blog_class' => '','cs_blog_num_tab'=>'4');
       
	  extract( shortcode_atts( $defaults, $atts ) );
        
		$cs_dataObject		= get_post_meta($post->ID,'cs_full_data');
		
	   // Check Section or page layout
        $cs_sidebarLayout  = '';
        $section_cs_layout = '';
        $pageSidebar 	   = false;        
        $box_col_class 	   = 'col-md-3';        
        
		if(isset($cs_dataObject['cs_page_layout'])) $cs_sidebarLayout = $cs_dataObject['cs_page_layout'];
        
		if(isset($column_attributes->cs_layout)){
            $section_cs_layout = $column_attributes->cs_layout;
			if ( $section_cs_layout == 'left' || $section_cs_layout == 'right' ) {
				$pageSidebar = true;
			}
        }
        
        if ( $cs_sidebarLayout == 'left' || $cs_sidebarLayout == 'right') {
            $pageSidebar = true;
        }        
        
		if($pageSidebar == true) {
            $box_col_class = 'col-md-4';
        }
        
		// Check Section or page layout ends
        
        if ((isset($cs_dataObject['cs_page_layout']) && $cs_dataObject['cs_page_layout'] <> '' and $cs_dataObject['cs_page_layout'] <> "none") || $pageSidebar == true){           
                $cs_blog_grid_layout = 'col-md-4';
        }else{
                $cs_blog_grid_layout = 'col-md-3';    
        }        
        
		$CustomId    = '';
        
		if ( isset( $cs_blog_class ) && $cs_blog_class ) {
            $CustomId    = 'id="'.$cs_blog_class.'"';
        }        
        
		$owlcount = rand(40, 9999999);
        $cs_counter_node++;
        ob_start();        
        
		//==Filters
        $filter_category = '';
        $filter_tag = '';
        $author_filter = '';
           
        if ( isset($_GET['filter_category']) && $_GET['filter_category'] <> '' && $_GET['filter_category'] <> '0' ) { 
            $filter_category = $_GET['filter_category'];
        }
        //==Filters End
        
        //==Sorting        
        if(isset($_GET['sort']) and $_GET['sort']=='asc'){
            $cs_blog_orderby    = 'ASC';
        } else{
            $cs_blog_orderby    = $cs_blog_orderby;
        }        
        if(isset($_GET['sort']) and $_GET['sort']=='alphabetical'){
            $orderby                = 'title';
            $cs_blog_orderby        = 'ASC';
        } else{
            $orderby    = 'meta_value';
        }        
        
		//==Sorting End         
        if (empty($_GET['page_id_all'])) $_GET['page_id_all'] = 1;
        $cs_blog_num_post    = $cs_blog_num_post ? $cs_blog_num_post : '-1';        
        $args = array('posts_per_page' => "-1", 'post_type' => 'post', 'order' => $cs_blog_orderby, 'orderby' => $orderby, 'post_status' => 'publish', 'ignore_sticky_posts' => 1);
        
        if(isset($cs_blog_cat) && $cs_blog_cat <> '' &&  $cs_blog_cat <> '0'){
            $blog_category_array = array('category_name' => "$cs_blog_cat");
            $args = array_merge($args, $blog_category_array);
        }        
        if(isset($filter_category) && $filter_category <> '' && $filter_category <> '0'){
                
                if ( isset($_GET['filter-tag']) ) {$filter_tag = $_GET['filter-tag'];}
                if($filter_tag <> ''){
                    $blog_category_array = array('category_name' => "$filter_category",'tag' => "$filter_tag");
                }else{
                    $blog_category_array = array('category_name' => "$filter_category");
                }
                $args = array_merge($args, $blog_category_array);
            }            
        
		if ( isset($_GET['filter-tag']) && $_GET['filter-tag'] <> '' && $_GET['filter-tag'] <> '0' ) {
            $filter_tag = $_GET['filter-tag'];
            if($filter_tag <> ''){
                $course_category_array = array('category_name' => "$filter_category",'tag' => "$filter_tag");
                $args = array_merge($args, $course_category_array);
            }
        }
        
		if ( isset($_GET['by_author']) && $_GET['by_author'] <> '' && $_GET['by_author'] <> '0' ) {
            $author_filter = $_GET['by_author'];
            if($author_filter <> ''){
                $authorArray = array('author' => "$author_filter");
                $args = array_merge($args, $authorArray);
            }
        }
        
		$query = new WP_Query( $args );
        $count_post = $query->post_count;        
        $cs_blog_num_post    = $cs_blog_num_post ? $cs_blog_num_post : '-1';
        $args = array('posts_per_page' => "$cs_blog_num_post", 'post_type' => 'post', 'paged' => $_GET['page_id_all'], 'order' => $cs_blog_orderby, 'orderby' => $orderby, 'post_status' => 'publish', 'ignore_sticky_posts' => 1);
        
        if(isset($cs_blog_cat) && $cs_blog_cat <> '' &&  $cs_blog_cat <> '0'){
            $blog_category_array = array('category_name' => "$cs_blog_cat");
            $args = array_merge($args, $blog_category_array);
        }        
        if(isset($filter_category) && $filter_category <> '' && $filter_category <> '0'){                
			if ( isset($_GET['filter-tag']) ) {$filter_tag = $_GET['filter-tag'];}
			if($filter_tag <> ''){
				$blog_category_array = array('category_name' => "$filter_category",'tag' => "$filter_tag");
			}else{
				$blog_category_array = array('category_name' => "$filter_category");
			}
			
			$args = array_merge($args, $blog_category_array);
		}
            
        if ( isset($_GET['filter-tag']) && $_GET['filter-tag'] <> '' && $_GET['filter-tag'] <> '0' ) {
            $filter_tag = $_GET['filter-tag'];
            if($filter_tag <> ''){
                $course_category_array = array('category_name' => "$filter_category",'tag' => "$filter_tag");
                $args = array_merge($args, $course_category_array);
            }
        }
        if ( isset($_GET['by_author']) && $_GET['by_author'] <> '' && $_GET['by_author'] <> '0' ) {
            $author_filter = $_GET['by_author'];
            if($author_filter <> ''){
                $authorArray = array('author' => "$author_filter");
                $args = array_merge($args, $authorArray);
            }
        }        
        if ( $cs_blog_cat !='' && $cs_blog_cat !='0'){ 
            $row_cat = $wpdb->get_row($wpdb->prepare("SELECT * from $wpdb->terms WHERE slug = %s", $cs_blog_cat ));
        }        
        $outerDivStart    = '';
        $outerDivEnd    = '';
        $section_title  = '';
                           
                      
        if(isset($cs_blog_section_title) && trim($cs_blog_section_title) <> '' or isset($cs_blog_sub_section_title) and $cs_blog_sub_section_title <>''){
			
 
			
			
			$section_title = ' 
								<div class="cs-section-title col-md-12">
									<h2>'.$cs_blog_section_title.'</h2>
		                      	 
							  </div>';
			
			
        }        
        $randomId = cs_generate_random_string('10');        
			if ( $cs_blog_view == 'blog-mesnory' ) {
				$outerDivStart    = '<div class="cs-blog blog-grid blog-masnery mas-isotope-'.$randomId.'">';
				$outerDivEnd    = '</div>';
				cs_isotope_enqueue();
				echo '<script>
						 jQuery(document).ready(function($) {
							var container = jQuery(".mas-isotope-'.$randomId.'").imagesLoaded(function() {
								container.isotope()
							});
							jQuery(window).resize(function() {
								setTimeout(function() {
									jQuery(".mas-isotope-'.$randomId.'").isotope()
								}, 600)
							});
						 });    
					  </script>';          
			}
		
        echo cs_allow_special_char($outerDivStart);
        echo cs_allow_special_char($section_title);	
        
		set_query_var( 'args', $args );
		
		//echo "cs_blog_view=".$cs_blog_view;
 		
		
		if ( $cs_blog_view == 'blog-medium' ) {
			 
			get_template_part('cs-templates/blog-styles/blog','medium');
        } else if ( $cs_blog_view == 'blog-grid-plain' ) { 
			get_template_part('cs-templates/blog-styles/blog','mesnory');
        } else if ( $cs_blog_view == 'blog-lrg' ) {
			get_template_part('cs-templates/blog-styles/blog','large');
        }  else if ( $cs_blog_view == 'blog-tab' ) {
			get_template_part('cs-templates/blog-styles/blog','tab');
        } else if ( $cs_blog_view == 'announcement' ) {
			get_template_part('cs-templates/blog-styles/blog','announcement');
        } else {
			get_template_part('cs-templates/blog-styles/blog','list');
        }
		
      
       echo cs_allow_special_char($outerDivEnd);      
      //==Pagination Start
         if ( $blog_pagination == "Show Pagination" && $count_post > $cs_blog_num_post && $cs_blog_num_post > 0 && $cs_blog_view != 'blog-crousel' && $cs_blog_view != 'blog-tab' ) {
            $qrystr = '';
             if ( isset($_GET['page_id']) ) $qrystr .= "&amp;page_id=".$_GET['page_id'];   
			 if ( $cs_blog_view == 'blog-medium' || $cs_blog_view == 'blog-lrg' ) {
				 echo '<div class="col-md-12">';
			 }
             echo cs_pagination($count_post, $cs_blog_num_post,$qrystr,'Show Pagination');
			 if ( $cs_blog_view == 'blog-medium' || $cs_blog_view == 'blog-lrg' ) {
				 echo '</div>';
			 }
         }
      //==Pagination End    
           
        wp_reset_postdata();    
            
        $post_data = ob_get_clean();
        return $post_data;
     }
	if (function_exists('cs_short_code')) cs_short_code( 'cs_blog', 'cs_blog_shortcode' );
}

if (!function_exists('cs_get_categories')) {
	function cs_get_categories( $cs_blog_cat ) {             
		 global $post,$wpdb;                                 
		 if ( isset( $cs_blog_cat ) && $cs_blog_cat !='' && $cs_blog_cat !='0' ){ 
			$row_cat = $wpdb->get_row($wpdb->prepare("SELECT * from $wpdb->terms WHERE slug = %s", $cs_blog_cat ));
			echo '<a href="'.esc_url( home_url('/') ).'?cat='.$row_cat->term_id.'">'.$row_cat->name.'</a>';
		 } else {
			 /* Get All Categories */
			  $before_cat = "";
			  $categories_list = get_the_term_list ( get_the_id(), 'category', $before_cat , ', ', '' );
			  if ( $categories_list ){
				printf( '%1$s', $categories_list );
			  } 
			 // End if Categories 
		 }
	}
}

/*----------------------------------------------------------------
// @ Post Likes Counter
/----------------------------------------------------------------*/
if(!function_exists('cs_post_likes_count')){
	function cs_post_likes_count(){		
		$cs_like_counter = get_post_meta( $_POST['post_id'] , "cs_post_like_counter", true);
		if ( !isset($_COOKIE["cs_post_like_counter".$_POST['post_id']]) ){
			setcookie("cs_post_like_counter".$_POST['post_id'], 'true', time()+86400, '/');
			update_post_meta( $_POST['post_id'], 'cs_post_like_counter', $cs_like_counter+1 );
		}
		$cs_like_counter = get_post_meta($_POST['post_id'], "cs_post_like_counter", true);
		if ( !isset($cs_like_counter) or empty($cs_like_counter) ) $cs_like_counter = 0;
		 
		echo cs_allow_special_char($cs_like_counter);
		die(0);
	}	
	add_action('wp_ajax_cs_post_likes_count', 'cs_post_likes_count');
	add_action('wp_ajax_nopriv_cs_post_likes_count', 'cs_post_likes_count');
}
