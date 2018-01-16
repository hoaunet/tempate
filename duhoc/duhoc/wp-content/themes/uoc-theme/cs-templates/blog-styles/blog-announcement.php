<?php
global $post, $cs_blog_cat, $cs_blog_description, $cs_blog_excerpt, $cs_notification, $wp_query,$px_blog_cat;
extract($wp_query->query_vars);

 $title_limit = 1000;
 
?> 

<script type="text/javascript">

	jQuery(window).load(function() {
		if(jQuery('.news-ticker').length != ''){
		jQuery('.news-ticker').flexslider({
		    slideshowSpeed: 2000,
		    animationDuration: 1100,
		    animation: 'fade',
		    directionNav: true,
		    controlNav: false,
		    pausePlay: false,
		    pauseText: 'Pause',
		    playText: 'Play',
		    prevText: "<i class='icon-arrow-left10'></i>",
     		nextText: "<i class='icon-arrow-right10'></i>",
		});
		}
	});

</script>
  <div class="col-md-12">
      <div class="news-ticker">
        <span class="ticker-title"><?php _e('Updates','uoc');?></span>
        <ul class="slides">
    <?php
	 cs_enqueue_flexslider_script();
    $query = new WP_Query($args);
    $post_count = $query->post_count;
    if ($query->have_posts()) {
        $postCounter = 0;
        while ($query->have_posts()) : $query->the_post();
         ?>
            <li>
            <p><?php the_title(); ?></p> <time datetime="2008-02-14 20:00"><?php echo date_i18n(get_option('date_format'), strtotime(get_the_date())); ?> </time>
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





                        
