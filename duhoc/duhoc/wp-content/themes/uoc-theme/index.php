<?php
/**
 * The template for Home page 
 */

get_header();
global $cs_node, $cs_theme_options,$cs_blog_cat, $cs_blog_excerpt, $cs_blog_description, $cs_counter_node,$px_blog_cat;
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
$cs_sidebar = $cs_theme_options['cs_default_layout_sidebar'];
$cs_tags_name = 'post_tag';
$cs_categories_name = 'category';
$width = '280';
$height = '210';
 
$width = isset($width) ? $width : '255';
$height = isset($height) ? $height : '210';

?>   

<section class="page-section" style="padding:0;">
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
				<?php }?>
            <!--Left Sidebar End-->
            <!-- Page Detail Start -->
            <div class="<?php echo esc_attr($cs_page_layout); ?>">
                <div class="cs-blog cs-blog-medium col-md-12">
                   
                    <div class="col-md-12">
                        <?php
                        if (have_posts()) :
                            if (empty($_GET['page_id_all']))
                                $_GET['page_id_all'] = 1;
                            if (!isset($_GET["s"])) {
                                $_GET["s"] = '';
                            }
                            while (have_posts()) : the_post();
                                $thumbnail = cs_get_post_img_src($post->ID, $width, $height);
                                $cs_postObject = get_post_meta($post->ID, "cs_full_data", true);
                                
                                $cs_gallery = get_post_meta($post->ID, 'cs_post_list_gallery', true);
                                $cs_gallery = explode(',', $cs_gallery);
                                $cs_thumb_view = get_post_meta($post->ID, 'cs_thumb_view', true);
                                $cs_post_view = isset($cs_thumb_view) ? $cs_thumb_view : '';
                                $current_user = wp_get_current_user();
                                $custom_image_url = get_user_meta(get_the_author_meta('ID'), 'user_avatar_display', true);
                                $cs_post_like_counter = get_post_meta(get_the_id(), "cs_post_like_counter", true);
                                $cs_blog_excerpt_theme_option = isset($cs_theme_options['cs_excerpt_length']) ? $cs_theme_options['cs_excerpt_length'] : '255';
                                
                                $tags = get_tags();
								?>  
                
                                  
                                <article id="post-<?php the_ID() ?>" <?php post_class() ?>>
                                <div class="cs-media">
                                <?php if ($thumbnail <> '') { ?>
                                      <figure><a href="<?php esc_url(the_permalink()); ?>"><img src="<?php echo esc_url($thumbnail) ?>"></a>
                                        <figcaption>
                                            <div class="cs-hover">
                                                <a href="#" class="cs-search"><i class="icon-zoomin3"></i></a>
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
                                    
                                        <p> <?php echo cs_get_the_excerpt($cs_blog_excerpt_theme_option, 'true', ''); ?></p>
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
                                                   <?php cs_get_categories($px_blog_cat); ?> 
                
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    
                                </div>
                            </article>
                           <?php
                            endwhile;
                            wp_reset_postdata();
                        else:
                            if (function_exists('cs_fnc_no_result_found')) {
                                cs_fnc_no_result_found();
                            }
                        endif;
                        $qrystr = '';
                        if (isset($_GET['page_id']))
                            $qrystr .= "&page_id=" . $_GET['page_id'];
                        if ($wp_query->found_posts > get_option('posts_per_page')) {
                            if (function_exists('cs_pagination')) {
                                echo cs_pagination(wp_count_posts()->publish, get_option('posts_per_page'), $qrystr);
                            }
                        }
                        ?>
                    </div>
                    
                </div>
            </div>
            
            
            
            
			<?php if (isset($cs_layout) and $cs_layout == 'sidebar_right') { ?>
                <div class="page-sidebar"><?php if ( is_active_sidebar( cs_get_sidebar_id( $cs_sidebar ) ) ) { if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar)) : ?><?php endif; } ?></div>
			<?php } else{
					echo '<div class="page-sidebar">';
						if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-1') ) : endif;
					  echo '</div>';
 				} ?>
        </div>     
    </div>
</section>
<?php get_footer(); ?>