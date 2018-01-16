<?php
global $post, $cs_blog_cat, $cs_blog_description, $cs_blog_excerpt, $cs_notification, $wp_query,$cs_blog_num_tab;
extract($wp_query->query_vars);

$width = '243';
$height = '137';
$title_limit = 1000;
?> 


 
			 <div role="tabpanel">
					<?php   
					$categories = get_categories( array('taxonomy' => 'category', 'hide_empty' => 0) ); ?>
                	 <ul class="nav nav-tabs cs-gallery-nav col-md-12" role="tablist">
					<?php 
				       $i=0;
						foreach ( $categories as $category ) {
						  $active='';
						  if($i == 0) $active= 'active';
						  $tab_id = 'id_'.$category->term_id;	
					?>
                    		<li role="presentation" class="<?php echo esc_attr($active)?>">
                            	<a href="#<?php echo esc_attr($tab_id)?>" aria-controls="<?php echo esc_attr($tab_id) ?>" role="tab" data-toggle="tab">
									<?php  echo esc_attr($category->cat_name); ?>
                                </a>
                            </li>
					
						<?php 
                            $i++;
						}
                    ?> 
                  </ul>
				</div>
 
 
          <div class="col-md-12">
            <div class="tab-content">
                    <?php 
                    $i=0;
                    foreach ( $categories as $category ) {
                        $active='';
                        if($i == 0) $active= 'active';
                        $tab_id = 'id_'.$category->term_id;	
                    
                    ?>
                        <div role="tabpanel" class="tab-pane <?php echo esc_attr($active)?>" id="<?php echo esc_attr($tab_id)?>">
                            <div class="cs-gallery">
                                <ul class="gallery">
                                <?php
                                $args = array('post_type'=>'post','posts_per_page' => $cs_blog_num_tab,  'tax_query' => array(
                                            array(
                                              'taxonomy' => 'category',
                                              'terms' => $category->term_id, 
                                             )
                                          ));
                                $query = new WP_Query($args);
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
                                            $post_tags_show = get_post_meta($post->ID, 'cs_post_tags_show', true);
                                            $custom_image_url = get_user_meta(get_the_author_meta('ID'), 'user_avatar_display', true);
                                            $cs_post_like_counter = get_post_meta(get_the_id(), "cs_post_like_counter", true); ?>
                                            
                                            <li class="col-md-4">
                                             <?php  
                                                if($thumbnail <> '') { ?>
                                                   <figure>
                                                        <a href="<?php echo esc_url($thumbnail);?>" data-rel="prettyPhoto[gallery2]" title="">
                                                            <img alt="" src="<?php echo esc_url($thumbnail);?>"></a>
                                                        <figcaption>
                                                            <a href="<?php echo esc_url($thumbnail);?>" data-rel="prettyPhoto[gallery2]" title="">
                                                                <i class="icon-plus8"></i>
                                                            </a>
                                                        </figcaption>
                                                    </figure>
                                                <?php } ?>  
                                                <h6><a href="<?php echo esc_url(the_permalink()); ?>"><?php the_title(); ?></a></h6>
                                            </li>
                                    <?php
                                        endwhile;
                                        } else {
                                            $cs_notification->error('No blog post found.');
                                    }
                                    ?>		
                                </ul>
                            </div>
                        </div>
                       <?php $i++;
                           }
                       ?>  
                        
                    
                </div>
             </div>
 