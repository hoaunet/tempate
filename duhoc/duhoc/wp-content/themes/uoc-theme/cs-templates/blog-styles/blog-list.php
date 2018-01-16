<?php
global $post, $cs_blog_cat, $cs_blog_description, $cs_blog_excerpt, $cs_notification, $wp_query,$px_blog_cat;
extract($wp_query->query_vars);

$width = '150';
$height = '150';
$title_limit = 1000;

?> 
 <div class="cs-campunews custom-fig col-md-12">
 <ul>
 
  <?php
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
            $cs_post_like_counter = get_post_meta(get_the_id(), "cs_post_like_counter", true);
            if (!isset($cs_post_like_counter) or empty($cs_post_like_counter))
             $cs_post_like_counter = 0;
              $tags = get_tags();
            ?>
                        <li>
                        <?php if($thumbnail <> '') { 
						?>
                          <figure><a href="<?php esc_url(the_permalink()); ?>"><img src="<?php echo esc_url($thumbnail);?>" alt=""></a>
                          
                          <figcaption>
						 <a href="<?php echo esc_url($thumbnail);?>" data-rel="prettyPhoto[gallery2]" title=""><i class="icon-plus8"></i></a>
						</figcaption>
                          
                          
                          </figure>
                          <?php } ?>
                          <div class="cs-campus-info">
                            <div class="cs-newscategorie">  <?php cs_get_categories($px_blog_cat); ?> </div>
                            <h6><a href="<?php esc_url(the_permalink()); ?>"><?php the_title(); ?></a></h6>
                            <time datetime="2008-02-14 20:00"><?php echo date_i18n('F j,Y', strtotime(get_the_date())); ?> </time>
                            <a href="<?php esc_url(the_permalink()); ?>" class="cmp-comment">
                            
									<?php $coments = get_comments_number(__('0', 'uoc'), __('1', 'uoc'), __('%', 'uoc'));
                                    		printf('%s', $coments);
                                   			 _e('Comments', 'uoc'); 
                                    ?>
                             </a>
                          </div>
                        </li>
                        
                        <?php
        endwhile;
    } else {
        $cs_notification->error('No blog post found.');
    }
	 $category = get_the_category();
    ?>
    </ul>
 
    <a class="viewall-btn csbg-hovercolor" href="<?php echo esc_url(get_category_link($category[0]->cat_ID)); ?>">
    	<i class="icon-angle-double-right"></i> 
			<?php _e('View All Blogs','uoc'); ?>
    </a>
</div>
 







