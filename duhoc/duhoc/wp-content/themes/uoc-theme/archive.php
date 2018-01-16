<?php
get_header();
global $cs_theme_options, $post, $cs_blog_cat, $cs_blog_description, $cs_blog_excerpt, $cs_notification, $wp_query,$cs_blog_cat,$cs_category_name;

$width = '350';
$height = '350';
$width = isset($width) ? $width : '255';
$height = isset($height) ? $height : '210';
$cs_layout = '';
if (isset($cs_theme_options['cs_excerpt_length']) && $cs_theme_options['cs_excerpt_length'] <> '') {
    $default_excerpt_length = $cs_theme_options['cs_excerpt_length'];
} else {
    $default_excerpt_length = '255';
}
$cs_layout = isset($cs_theme_options['cs_default_page_layout']) ? $cs_theme_options['cs_default_page_layout'] : '';
if (isset($cs_layout) && ($cs_layout == "sidebar_left" || $cs_layout == "sidebar_right")) {
    $cs_page_layout = "page-content";
} else {
    $cs_page_layout = "page-content-fullwidth";
}
$cs_sidebar = isset($cs_theme_options['cs_default_layout_sidebar']) ? $cs_theme_options['cs_default_layout_sidebar'] : '';
$cs_tags_name = 'post_tag';
$cs_categories_name = 'category';

?>
<!-- PageSection Start -->
<section class="page-section" style=" padding: 0; ">
    <!-- Container -->
    <div class="container">
        <!-- Row -->
        <div class="row">
            <!--Left Sidebar Starts-->
			<?php if ($cs_layout == 'sidebar_left') { ?>
                <div class="page-sidebar">
				<?php 
				if ( is_active_sidebar( cs_get_sidebar_id( $cs_sidebar ) ) ) {
                	if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar)) : endif; 
				}
                ?>
                </div>
			<?php } ?>
            <!--Left Sidebar End-->                
            <!-- Page Detail Start -->
            <div class="<?php echo esc_attr($cs_page_layout); ?>">
                <!-- Blog Post Start -->
            <?php
            if (is_author()) {
                global $author;
                $userdata = get_userdata($author);
            }
            if (category_description() || is_tag() || (is_author() && isset($userdata->description) && !empty($userdata->description))) {
                echo '<div class="widget evorgnizer">';
                if (is_author()) {
                    ?>
                        <figure>
                            <a> 
                        <?php echo get_avatar($userdata->user_email, apply_filters('Cs_author_bio_avatar_size', 70)); ?>
                            </a>
                        </figure>
                        <div class="left-sp">
                            <h5><a><?php echo esc_attr($userdata->display_name); ?></a></h5>
                            <p><?php echo balanceTags($userdata->description, true); ?></p>
                        </div>
						<?php
                        } elseif (is_category()) {
                            $category_description = category_description();
                            if (!empty($category_description)) {
                                ?>
                            <div class="left-sp">
                                <p><?php echo category_description(); ?></p>
                            </div>
                        <?php
                        }
                    } elseif (is_tag()) {
                        $tag_description = tag_description();
                        if (!empty($tag_description)) {
                            ?>
                            <div class="left-sp">
                                <p><?php echo apply_filters('tag_archive_meta', $tag_description); ?></p>
                            </div>
							<?php
                            }
                        }
                        echo '</div>';
                    }
                    if (empty($_GET['page_id_all']))
                        $_GET['page_id_all'] = 1;
                    if (!isset($_GET["s"])) {
                        $_GET["s"] = '';
                    }
                    $description = 'yes';
                    $taxonomy = 'category';
                    $taxonomy_tag = 'post_tag';
                    $args_cat = array();
                     if(is_author()){
                     global $author;
                     $userdata = get_userdata($author);
                 }
                 if(category_description() || is_tag() || (is_author() && isset($userdata->description) && !empty($userdata->description))){
                    echo '<div class="widget evorgnizer">';
                    if(is_author()){?>
                        <figure>
                            <a>
                            <?php 
							$cs_profile_img = '';
							if( class_exists('wp_directory') ){
								$cs_profile_img = cs_get_user_avatar(1 ,$author);
							}
                            if( class_exists('wp_directory') && $cs_profile_img <> '' ){
								$cs_profile_img = cs_get_user_avatar(1 ,$author);
                                echo '<img src="'.esc_url($cs_profile_img).'" alt="'.cs_get_post_img_title($post->ID).'" />';
                            }else{
                                echo get_avatar($userdata->user_email, apply_filters('Cs_author_bio_avatar_size', 70));
                            }
                            ?>
                            </a>
                        </figure>
                        <div class="left-sp">
                            <h5><a><?php echo esc_attr($userdata->display_name); ?></a></h5>
                            <p><?php echo balanceTags($userdata->description, true); ?></p>
                        </div>
						<?php } elseif ( is_category()) {
                            $category_description = category_description();
                            if ( ! empty( $category_description ) ) {
                            ?>
                                <div class="left-sp">
                                    <p><?php  echo category_description();?></p>
                                </div>
							<?php }?>
						<?php } elseif(is_tag()){  
                            $tag_description = tag_description();
                            if ( ! empty( $tag_description ) ) {
                            ?>
                            <div class="left-sp">
                                <p><?php echo apply_filters( 'tag_archive_meta', $tag_description );?></p>
                            </div>
                        <?php }
                    }
						echo '</div>';
					}
					$post_tag ='';
                    if (empty($_GET['page_id_all']))
                        $_GET['page_id_all'] = 1;
                    if (!isset($_GET["s"])) {
                        $_GET["s"] = '';
                    }
                    $description = 'yes';
					$taxonomy = 'category';
					$taxonomy_tag = 'post_tag';
					$args_cat = array();
					if(is_author()){
						$args_cat = array('author' => $wp_query->query_vars['author']);
				 
					} elseif(is_date()){
						if(is_month() || is_year() || is_day() || is_time()){
							$args_cat = array('m' => $wp_query->query_vars['m'],'year' => $wp_query->query_vars['year'],'day' => $wp_query->query_vars['day'],'hour' => $wp_query->query_vars['hour'], 'minute' => $wp_query->query_vars['minute'], 'second' => $wp_query->query_vars['second']);
						}
						$post_type = array( 'post' );
					} else if ((isset( $wp_query->query_vars['taxonomy']) && !empty( $wp_query->query_vars['taxonomy'] )) ) {
						$taxonomy = $wp_query->query_vars['taxonomy'];
						$taxonomy_category='';
						$taxonomy_category=$wp_query->query_vars[$taxonomy];
						if ( $wp_query->query_vars['taxonomy']=='portfolio-category') {
						  $args_cat = array( $taxonomy => "$taxonomy_category");
						  $post_type='portfolios';
 						}else {
							$taxonomy = 'category';
							$args_cat = array();
							$post_type='post';
						}
						
					}else if ((isset( $wp_query->query_vars['taxonomy']) && !empty( $wp_query->query_vars['taxonomy'] )) ) {
						$taxonomy = $wp_query->query_vars['taxonomy'];
						$taxonomy_category='';
						$taxonomy_category=$wp_query->query_vars[$taxonomy];
						if ( $wp_query->query_vars['taxonomy']=='course-category') {
						  $args_cat = array( $taxonomy => "$taxonomy_category");
						  $post_type='course';
						 
 						}elseif($wp_query->query_vars['taxonomy']=='event-category'){
							$args_cat = array( $taxonomy => "$taxonomy_category");
						  $post_type='events';
						}else {
							$taxonomy = 'category';
							$args_cat = array();
							$post_type='post';
						}
						
					} else if( is_category() ) {
						
						$taxonomy = 'category';
						$args_cat = array();
						$category_blog = $wp_query->query_vars['cat'];
						$post_type='post';
						$args_cat = array( 'cat' => "$category_blog");
					
					}else if( is_category() ) {
						
						$taxonomy = 'course-category';
						$args_cat = array();
						$category_blog = $wp_query->query_vars['cat'];
						$post_type='course';
						$args_cat = array( 'cat' => "$category_blog");
					
					} else if( is_category() ) {
						
						$taxonomy = 'event-category';
						$args_cat = array();
						$category_blog = $wp_query->query_vars['cat'];
						$post_type='events';
						$args_cat = array( 'cat' => "$category_blog");
					
					}  else if ( is_tag() ) {						
						$taxonomy = 'category';
						$args_cat = array();
						$tag_blog = $wp_query->query_vars['tag'];
						$post_type='post';
						$args_cat = array( 'tag' => "$post_tag");
					
					} elseif($post_type =="course"){
						
						 $post_type =  get_post_type( get_the_ID() );	
						 
					 } elseif ($post_type =="events"){
						
					 }elseif ($post_type =="post"){
						
						$taxonomy = 'category';
						$args_cat = array();
						$post_type='post';
					}	
					
					$post_type =  get_post_type( get_the_ID() );		
					$cs_category_name = 'course-category';
					
					if($post_type  == 'post'){
						
					 	$cs_category_name = 'category';	
					
					}
					if($post_type  == 'events'){
					 	$cs_category_name = 'event-category';	
					
					}
					
					
					if ( is_tag()  && $post_type == 'post') {
						
						$tag = get_queried_object();
						$tag_slug =$tag->slug ;
						$args_rm = array( 
						'tag' =>$tag_slug,
						'post_type'		 => 'post', 
						'paged'			 => $_GET['page_id_all'],
						'post_status'	 => 'publish', 
						'order'			 => 'ASC',
						
					);
						
					}else{
						$args_rm = array( 
						'post_type'		 => $post_type, 
						'paged'			 => $_GET['page_id_all'],
						'post_status'	 => 'publish', 
						'order'			 => 'ASC',
						'tax_query' => array(
							array(
								'taxonomy' => $cs_category_name,
								'field' => 'id',
								'terms' => get_queried_object()->term_id,
							)
						)
					);	
				}
				
			 	$args = array_merge( $args_cat,$args_rm );
				$query = new WP_Query( $args ); ?>
                <div class="section-fullwidth">
                    <div class="element-size-100">
                        <div class="cs-blog cs-blog-medium lightbox col-md-12">
                            <?php
                             
                            $post_count = $query->post_count;
                            if ($query->have_posts()) {
                                $postCounter = 0;
                                while ($query->have_posts()) : $query->the_post();
                                    $thumbnail = cs_get_post_img_src($post->ID, $width, $height);
                                    $cs_postObject = get_post_meta($post->ID, "cs_full_data", true);
                                    $cs_gallery = get_post_meta($post->ID, 'cs_post_list_gallery', true);
                                    $cs_gallery = explode(',', $cs_gallery);
                                    $cs_thumb_view = get_post_meta($post->ID, 'cs_thumb_view', true);
                                    $cs_post_view = isset($cs_thumb_view) ? $cs_thumb_view : '';
                                    $current_user = wp_get_current_user();
                                    $custom_image_url = get_user_meta(get_the_author_meta('ID'), 'user_avatar_display', true);
                                    $cs_post_like_counter = get_post_meta(get_the_id(), "cs_post_like_counter", true);
                                    if (!isset($cs_post_like_counter) or empty($cs_post_like_counter))
                                    $cs_post_like_counter = 0;
                                    $tags = get_tags();
                 $cs_blog_excerpt_theme_option = isset($cs_theme_options['cs_excerpt_length']) ? $cs_theme_options['cs_excerpt_length'] : '255';
                             ?>
                              <article>
                                   <?php 
								    
									if( $post_type == 'portfolios' ) {
										$cs_port_list_gallery = get_post_meta($post->ID, 'cs_port_list_gallery', true);
										if( $cs_port_list_gallery <> '' ) {
											$cs_port_list_gallery = explode(',', $cs_port_list_gallery);										
											if( is_array($cs_port_list_gallery) && sizeof($cs_port_list_gallery) > 0 ) {
												$img_url = cs_attachment_image_src($cs_port_list_gallery[0], $width, $height);
											}
										}
											if( $img_url <> '' ) {
											?>
												<div class="cs-media">
											  
													  <figure><a href="<?php esc_url(the_permalink()); ?>"><img src="<?php echo esc_url($img_url) ?>" 
													  alt="<?php echo cs_get_post_img_title($post->ID); ?>"></a>
														<figcaption>
															<div class="cs-hover">
																<a href="#" class="cs-search"><i class="icon-zoomin3"></i></a>
																<a href="<?php esc_url(the_permalink()); ?>" class="cs-link"><i class="icon-chain"></i></a>
															</div>
														</figcaption>
													</figure>
												</div>
                  <?php
					}
		} else { 
									
			$width = '340';
			$height = '255';
	  		$image_url = cs_get_post_img_src($post->ID, $width, $height);	
			$image_full_url = cs_get_post_img_src($post->ID, 0, 0);							?>
			<div class="cs-media">
                <?php if ($image_url <> '') { ?>
                      <figure><a href="<?php esc_url(the_permalink()); ?>"><img src="<?php echo esc_url($image_url)?>"></a>
                        <figcaption>
                            <div class="cs-hover">
                                <a href="<?php echo esc_url( $image_full_url ); ?>" class="cs-search" data-rel="prettyPhoto[2]"><i class="icon-zoomin3"></i></a>
                                <a href="<?php esc_url(the_permalink()); ?>" class="cs-link"><i class="icon-chain"></i></a>
                            </div>
                        </figcaption>
                    </figure>
                    <?php } ?>
                </div>
                
                                         <div class="blog-info-sec">
                    <h2><a href="<?php esc_url(the_permalink()); ?>"><?php the_title(); ?> </a></h2>
                    <ul class="post-options">
                        <li><time datetime="2011-01-12"><?php echo date_i18n('F j, Y', strtotime(get_the_date())); ?>,</time></li>
                        <li><a href="<?php esc_url(the_permalink()); ?>">
                             <?php $coments = get_comments_number(__('0', 'uoc'), __('1', 'uoc'), __('%', 'uoc'));
                                    	   printf('%s', $coments);
                            	             _e('Comments', 'uoc'); 
                                 ?>
                         </a></li>
                    </ul>
                    
		 			
				<p> <?php echo cs_get_the_excerpt($default_excerpt_length, 'true', ''); ?></p>
                   
                    <div class="cs-seprator">
                        <div class="devider"></div>
                    </div>
                    
                    <div class="blog-bottom-sec">
                        <div class="cs-thumb-post">
                            <figure><?php echo get_avatar(get_the_author_meta('ID'), 32); ?></figure>
                            <ul>
                                <li><span><?php echo __('Posted by', 'uoc'); ?></span>
                                    <i class="icon-user9"></i>
                                    <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php echo get_the_author(); ?></a>
                                </li>
                                <li><span><?php echo __('Posted in', 'uoc'); ?></span>
                                    <i class="icon-folder5"></i>
                                   <?php 
								        $categories = get_the_terms($post->ID, $cs_category_name );
										$cat_slug = '';
										foreach( $categories as $cat ) {
											 $cat_slug .= $cat->name.',';
										}
										echo rtrim($cat_slug,',');
									 ?> 

                                </li>
                            </ul>
                        </div>
                    </div>
                    
                </div>
                                        <?php } ?>                 
              </article>
                                     
                                    <?php
                                endwhile;
								
                            } else {
                                _e('No post found.', 'uoc');
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?php
                // pagination start
				$qrystr = '';
                if ($query->found_posts > get_option('posts_per_page')) {
                    if (isset($_GET['page_id']))
                        $qrystr .= "&page_id=" . $_GET['page_id'];
                    if (isset($_GET['author']))
                        $qrystr .= "&author=" . $_GET['author'];
                    if (isset($_GET['tag']))
                        $qrystr .= "&tag=" . $_GET['tag'];
                    if (isset($_GET['cat']))
                        $qrystr .= "&cat=" . $_GET['cat'];
                    if (isset($_GET['portfolio-category']))
                        $qrystr .= "&portfolio-category=" . $_GET['portfolio-category'];
                    if (isset($_GET['m']))
                        $qrystr .= "&m=" . $_GET['m'];
                    if (function_exists('cs_pagination')) {
                        echo cs_pagination($query->found_posts, get_option('posts_per_page'), $qrystr);
                    }
                }
                ?>
            </div>
            <!-- Page Detail End -->                
            <!-- Right Sidebar Start -->
			<?php 
			if ($cs_layout == 'sidebar_right') { 
				if ( is_active_sidebar( cs_get_sidebar_id( $cs_sidebar ) ) ) {
				?>
					<div class="page-sidebar"><?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar)) : endif; ?></div>
				<?php 
				}
			}
			?>
            <!-- Right Sidebar End -->
        </div>
    </div>
</section>
<?php get_footer(); ?> 