<?php
global $post, $cs_blog_cat, $cs_blog_description, $cs_blog_excerpt, $cs_notification, $wp_query,$px_blog_cat;
extract($wp_query->query_vars);
$width = '818';
$height = '460';
$title_limit = 1000;
prettyphoto_files();

?> 
<div class=" cs-blog cs-blog-masnery mas-isotope">

<?php
cs_filter_enqueue();
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
            $custom_image_url = get_user_meta(get_the_author_meta('ID'), 'user_avatar_display', true);
            $cs_post_like_counter = get_post_meta(get_the_id(), "cs_post_like_counter", true);
            if (!isset($cs_post_like_counter) or empty($cs_post_like_counter))
                $cs_post_like_counter = 0;
               $tags = get_tags();
            ?>
                      <div class="col-md-3">
                        <article>
                        <div class="blog-info-sec">
                        
                          	<span class="categories">
                         		<?php cs_get_categories($px_blog_cat); ?> 
                         	</span>
                            
                              <h4><a href="<?php esc_url(the_permalink()); ?>"><?php the_title(); ?></a></h4>
                              <ul class="post-options">
                              <li><time datetime="2011-01-12"><?php echo date_i18n('F j, Y', strtotime(get_the_date())); ?></time></li>
                              <li><a href="<?php esc_url(the_permalink()); ?>">
                                 <?php $coments = get_comments_number(__('0', 'uoc'), __('1', 'uoc'), __('%', 'uoc'));
                                    	   printf('%s', $coments);
                            	           _e('Comments', 'uoc'); 
                                 ?>
                              
                               </a></li>
                              </ul>
                        </div>
                          <div class="cs-media">
                          <figure>
                          <a href="<?php esc_url(the_permalink()); ?>"><img src="<?php echo esc_url($thumbnail);?>" alt="image"></a>
                            <figcaption>
                                <div class="cs-hover">
                                 
                                   <ul class="gallery clearfix">
                                   <li>
                                 		 <a href="<?php echo esc_url($thumbnail);?>" class="cs-search" data-rel="prettyPhoto" title="">
                                        	<i class="icon-zoomin3"></i>
                                         </a>
                                          <a href="<?php esc_url(the_permalink()); ?>" class="cs-link"><i class="icon-chain"></i></a>
                                 </li> </ul>
                                 
                                </div>
                              </figcaption>
                          </figure>
                          </div>
                        </article>
                        </div>
                <?php
        endwhile;
    } else {
        $cs_notification->error('No blog post found.');
    }
    ?>
</div>
<script type="text/javascript">
      jQuery(document).ready(function($) {
      var container = jQuery(".mas-isotope").imagesLoaded(function() {
        container.isotope()
      });
      jQuery(window).resize(function() {
        setTimeout(function() {
          jQuery(".mas-isotope").isotope()
        }, 600)
      });

     });
</script>





