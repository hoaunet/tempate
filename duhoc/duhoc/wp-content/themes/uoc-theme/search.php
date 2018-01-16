<?php
/**
 * The template for displaying Search Result
 */
get_header();
global $cs_theme_option, $wp_query, $cs_portfolio_excerpt, $cs_blog_cat;
$default_excerpt_length = isset($cs_theme_options['cs_excerpt_length']) ? $cs_theme_options['cs_excerpt_length'] : '255';
$cs_blog_excerpt_theme_option = isset($cs_theme_options['cs_excerpt_length']) ? $cs_theme_options['cs_excerpt_length'] : '255';
$cs_layout = isset($cs_theme_options['cs_default_page_layout']) ? $cs_theme_options['cs_default_page_layout'] : '';
if (isset($cs_layout) && ($cs_layout == "sidebar_left" || $cs_layout == "sidebar_right")) {
    $cs_page_layout = "page-content";
} else {
    $cs_page_layout = "page-content-fullwidth";
}
$cs_sidebar = isset($cs_theme_options['cs_default_layout_sidebar']) ? $cs_theme_options['cs_default_layout_sidebar'] : '';
$cs_tags_name = 'post_tag';
$cs_categories_name = 'category';
$width = '85';
$height = '85';
$title_limit = 100000;

if (!isset($GET['page_id']))
    $GET['page_id_all'] = 1;
?>
<section class="page-section">
    <div class="container">
        <div class="row">
            <?php if ($cs_layout == 'sidebar_left') { ?>
                <aside class="page-sidebar">
                    <?php 
					if ( is_active_sidebar( cs_get_sidebar_id( $cs_sidebar ) ) ) {
						if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar)) : endif; 
					}
					?>
                </aside>
            <?php } ?>
                       <div class="<?php echo esc_attr($cs_page_layout); ?>">
                                     <div class="page-no-search">
                                             
                                          <?php
                                             if (have_posts()) : ?>
                                               
                                                
											<div class="relevant-search">
                                                <div class="headings-area">
                                                	<h2><?php printf(__('Showing result for %s', 'uoc'), get_search_query()); ?></h2>
                                                </div>
                                                <div class="cs-search-results">
                                               	
                                                <ul>
												
											 <?php
													while (have_posts()) : the_post();
													$postid = get_the_ID();
													$cs_post_type = get_post_type($postid);
													if (isset($cs_post_type) and $cs_post_type == 'portfolios') {
													$cs_port_list_gallery = get_post_meta($post->ID, 'cs_port_list_gallery', true);
													if ($cs_port_list_gallery <> '') {
													$cs_port_list_gallery = explode(',', $cs_port_list_gallery);
													
													if (is_array($cs_port_list_gallery) && sizeof($cs_port_list_gallery) > 0) {
													$img_url = cs_attachment_image_src($cs_port_list_gallery[0], $width, $height);
													$thumbnail = cs_attachment_image_src($cs_port_list_gallery[0], $width, $height);
													}
													}
													} else {
													
													$thumbnail = cs_get_post_img_src($post->ID, $width, $height);
													}
													
													$cs_port_list_gallery = get_post_meta($post->ID, 'cs_port_list_gallery', true);
													if (isset($cs_post_type) and $cs_post_type == 'portfolios') {
													$cs_port_list_gallery = explode(',', $cs_port_list_gallery);
													
													if (is_array($cs_port_list_gallery) && sizeof($cs_port_list_gallery) > 0) {
													$thumbnail = cs_attachment_image_src($cs_port_list_gallery[0], $width, $height);
													}
													} else {
													$thumbnail = cs_get_post_img_src($post->ID, $width, $height);
													}
													if (is_sticky()) {
													echo '<span>' . __('Featured:', 'uoc') . '</span>';
													}
                                                ?>
                                                
                                                    <li>
                                                    
                                                        <?php if ($thumbnail != "") { ?>
                                                            <figure>
                                                            <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo cs_get_post_img_title($post->ID); ?>">
                                                            </figure>
                                                        <?php }?>
                                                        
                                                        <div class="text">
                      <time datetime="2008-02-14"><?php echo date_i18n(get_option('date_format'), strtotime(get_the_date())); ?></time> 
                                                        <h6><?php the_title(); ?></h6>
                                                        <p><?php echo cs_get_the_excerpt($cs_blog_excerpt_theme_option, 'true', ''); ?></p>
                                                        
                                                        <a href="<?php esc_url(the_permalink()); ?>">
                                                        <?php esc_url(the_permalink()); ?>
                                                        </a>
                                                        </div>
                                                    </li>
                                                <?php
                                                endwhile;
                                                ?>
                                                
                                                </ul>
                                                </div>
                                                </div>
                                                     
											   <?php
                                                else:
                                                    cs_fnc_no_result_found();
                                                endif;
                                                ?>														
                                          
                                
                                       </div>
							 <?php
                            $qrystr = '';
                            if ($wp_query->found_posts > get_option('posts_per_page')) {
                                if (isset($_GET['s']))
                                    $qrystr = "&amp;s=" . $_GET['s'];
                                if (isset($_GET['page_id']))
                                    $qrystr .= "&amp;page_id=" . $_GET['page_id'];
                                echo cs_pagination($wp_query->found_posts, get_option('posts_per_page'), $qrystr);
                            }
                            ?>
                    </div>
                    
					
            
            
            
            
            
            
                <?php if ($cs_layout == 'sidebar_right') { ?>
                <aside class="page-sidebar">
					<?php 
                    if ( is_active_sidebar( cs_get_sidebar_id( $cs_sidebar ) ) ) {
                        if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar)) : endif;
                    }
                    ?>
                </aside>
                <?php
            }
            ?>          		  		
        </div>
    </div>	
</section>

<?php
get_footer();
?>
<!-- Columns End -->