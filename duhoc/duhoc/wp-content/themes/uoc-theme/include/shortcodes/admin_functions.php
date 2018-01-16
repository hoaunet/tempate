<?php
//=====================================================================
// Adding mce custom button for short codes start
//=====================================================================
class ShortcodesEditorSelector {
    var $buttonName = 'shortcode';
    function addSelector() {
        add_filter('mce_external_plugins', array($this, 'registerTmcePlugin'));
        add_filter('mce_buttons', array($this, 'registerButton'));
    }
    function registerButton($buttons) {
        array_push($buttons, "separator", $this->buttonName);
        return $buttons;
    }
    function registerTmcePlugin($plugin_array) {
        return $plugin_array;
    }
}

function cs_allow_special_char($input = ''){
    $output  = $input;
    return $output;
}

if (!isset($shortcodesES)) {
   $shortcodesES = new ShortcodesEditorSelector();
    add_action('admin_head', array($shortcodesES, 'addSelector'));
}
//=====================================================================
//Bootstrap Coloumn Class
//=====================================================================
if ( ! function_exists( 'cs_custom_column_class' ) ) {
    function cs_custom_column_class($column_size){
        $coloumn_class = 'col-md-12';
        if(isset($column_size) && $column_size <> ''){
            list($top, $bottom) = explode('/', $column_size);
                $width = $top / $bottom * 100;
                $width =(int)$width;
                $coloumn_class = '';
                if(round($width) == '25' || round($width) < 25){
                    $coloumn_class = 'col-md-3';            
                } elseif(round($width) == '33' || (round($width) < 33 && round($width) > 25)){
                    $coloumn_class = 'col-md-4';    
                } elseif(round($width) == '50' || (round($width) < 50 && round($width) > 33)){
                    $coloumn_class = 'col-md-6';    
                } elseif(round($width) == '67' || (round($width) < 67 && round($width) > 50)){
                    $coloumn_class = 'col-md-8';    
                } elseif(round($width) == '75' || (round($width) < 75 && round($width) > 67)){
                    $coloumn_class = 'col-md-9';    
                } else {
                    $coloumn_class = 'col-md-12';
                }
        }
        return sanitize_html_class($coloumn_class);
    }
}
//=====================================================================
// Ads Banner Shortcode
//=====================================================================
if (!function_exists('cs_banner_ads_shortcode')) {
    function cs_banner_ads_shortcode( $atts ) {
        
        global $cs_theme_options;        
        $defaults = array('id' => '0');
        extract( shortcode_atts( $defaults, $atts ) );        
        $html = '';        
        if( isset($cs_theme_options['banner_field_code_no']) && is_array($cs_theme_options['banner_field_code_no']) ) {            
            $i=0;
            foreach($cs_theme_options['banner_field_code_no'] as $banner) :
                if($cs_theme_options['banner_field_code_no'][$i] == $id){
                    break;
                }
                $i++;
            endforeach;            
            $cs_banner_title = isset($cs_theme_options['banner_field_title'][$i]) ? $cs_theme_options['banner_field_title'][$i] : '';
            $cs_banner_style = isset($cs_theme_options['banner_field_style'][$i]) ? $cs_theme_options['banner_field_style'][$i] : '';
            $cs_banner_type = isset($cs_theme_options['banner_field_type'][$i]) ? $cs_theme_options['banner_field_type'][$i] : '';
            $cs_banner_image = isset($cs_theme_options['banner_field_image'][$i]) ? $cs_theme_options['banner_field_image'][$i] : '';
            $cs_banner_url = isset($cs_theme_options['banner_field_url'][$i]) ? $cs_theme_options['banner_field_url'][$i] : '';
            $cs_banner_url_target = isset($cs_theme_options['banner_field_url_target'][$i]) ? $cs_theme_options['banner_field_url_target'][$i] : '';
            $cs_banner_adsense_code = isset($cs_theme_options['banner_adsense_code'][$i]) ? $cs_theme_options['banner_adsense_code'][$i] : '';
            $cs_banner_code_no = isset($cs_theme_options['banner_field_code_no'][$i]) ? $cs_theme_options['banner_field_code_no'][$i] : '';
            $html .= '<div class="cs_banner_section">';
            if($cs_banner_type == 'image'){
                if ( !isset($_COOKIE["cs_banner_clicks_".$cs_banner_code_no]) ) {
                    $html .= '<a onclick="cs_banner_click_count_plus(\''.admin_url('admin-ajax.php').'\', \''.$cs_banner_code_no.'\')" id="cs_banner_clicks'.$cs_banner_code_no.'"
					 href="'.esc_url( $cs_banner_url ).'" target="_blank"><img src="'.esc_url($cs_banner_image).'" alt="'.$cs_banner_title.'" /></a>';
                }
                else{
                    $html .= '<a href="'.esc_url( $cs_banner_url ).'" target="'.$cs_banner_url_target.'"><img src="'.esc_url($cs_banner_image).'" alt="'.$cs_banner_title.'" /></a>';
                }
            }
            else{
                $html .= htmlspecialchars_decode(stripslashes($cs_banner_adsense_code));
            }
            $html .= '</div>';
            
        }
        
        return $html;
    }
    if (function_exists('cs_short_code')) cs_short_code( 'cs_ads', 'cs_banner_ads_shortcode' );
}


//=====================================================================
// Listing pages shortcode
//=====================================================================
if (!function_exists('cs_tags_render')) {
    function cs_tags_render($atts, $content = ""){
        global $post,$cs_xmlObject;
        $defaults = array('icon' => '', 'label' => '', 'seperator'=>'' );
        ob_start();
        if(isset($cs_xmlObject->cs_post_tags_show) && $cs_xmlObject->cs_post_tags_show == 'on'){
            if(isset($seperator) && $seperator <> ''){
                $seperator = $seperator;
            }
            $args=array(
                  'name' => (string)get_post_type($post->ID),
                  'post_type' => 'dcpt',
                  'post_status' => 'publish',
                  'showposts' => 1,
                );
                $get_posts = get_posts($args);
                if($get_posts){
                    $dcpt_id = (int)$get_posts[0]->ID;
                    $cs_tags_name = get_post_meta($dcpt_id, 'cs_tags_name', true);
                    $before_cat = '';
                    if($icon){
                        $before_cat .= $icon;
                    }
                    if($label){
                        $before_cat .= ' '.$label;
                    }
                    $tags_listtt = get_the_term_list ( $post->ID, strtolower($cs_tags_name), $before_cat, $seperator, '' );
                    if ( $tags_listtt ){
                        printf( __( '%1$s', 'uoc'),$tags_listtt );
                    }
                }
        }    
        $tags_data = ob_get_clean();
        return $tags_data;
    }
    if (function_exists('cs_short_code')) cs_short_code('cs_tag', 'cs_tags_render');
}
//=====================================================================
// get shortcode content
//=====================================================================
if (!function_exists('cs_content_render')) {
    function cs_content_render($atts, $content = ""){
        global $post;
        ob_start();
         the_content();
         wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'uoc' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
        $content_data = ob_get_clean();
        return $content_data;
    }
    if (function_exists('cs_short_code')) cs_short_code('cs_content', 'cs_content_render');
}
//=====================================================================
// get post attachement
//=====================================================================
if (!function_exists('cs_post_attachment_render')) {
    function cs_post_attachment_render($atts, $content = ""){
        global $post,$cs_xmlObject;
        ob_start();
        $post_attachment = '';
        $args = array(
           'post_type' => 'attachment',
           'numberposts' => -1,
           'post_status' => null,
           'post_parent' => $post->ID
          );
          $attachments = get_posts( $args );
            if ( $attachments ) {
         ?>
                <div class="cs-media-attachment mediaelements-post">
                <?php 
                foreach ( $attachments as $attachment ) {
                    $attachment_title = apply_filters( 'the_title', $attachment->post_title );
                    $type = get_post_mime_type( $attachment->ID );
                    if($type=='image/jpeg'){
                      ?>
                    <a <?php if ( $attachment_title <> '' ) { echo 'data-title="'.$attachment_title.'"'; }?> href="<?php echo esc_url($attachment->guid); ?>" data-rel="<?php echo "prettyPhoto[gallery1]"?>" class="me-imgbox">
					<?php echo wp_get_attachment_image( $attachment->ID, array(240,180),true ) ?></a>
                    <?php
                    
                    } elseif($type=='audio/mpeg') {
                        ?>
                        <!-- Button to trigger modal --> 
                        <a href="#audioattachment<?php echo intval($attachment->ID);?>" role="button" data-toggle="modal" class="iconbox"><i class="icon-microphone"></i></a> 
                        <!-- Modal -->
                        <div class="modal fade" id="audioattachment<?php echo intval($attachment->ID);?>" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              </div>
                              <div class="modal-body">
                                <audio style="width:100%;" src="<?php echo esc_url($attachment->guid); ?>" type="audio/mp3" controls></audio>
                              </div>
                            </div>
                            <!-- /.modal-content --> 
                          </div>
                        </div>
                        <?php
                    } elseif($type=='video/mp4') {
                     ?>
                    <a href="#videoattachment<?php echo intval($attachment->ID);?>" role="button" data-toggle="modal" class="iconbox"><i class="icon-video-camera"></i></a>
                    <div class="modal fade" id="videoattachment<?php echo intval($attachment->ID);?>" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          </div>
                          <div class="modal-body">
                            <video width="100%" height="360" poster="">
                              <source src="<?php echo esc_url($attachment->guid); ?>" type="video/mp4" title="mp4">
                            </video>
                          </div>
                        </div>
                        <!-- /.modal-content --> 
                      </div>
                    </div>
                    <?php
                    }
                }
                ?>
                </div>
                <?php  }
        $post_attachment_data = ob_get_clean();
        return $post_attachment_data;
    }
    if (function_exists('cs_short_code')) cs_short_code('cs_post_attachment', 'cs_post_attachment_render');
}
//=====================================================================
// Author's related posts
//=====================================================================
if (!function_exists('cs_get_related_athor_posts')) {
    function cs_get_related_athor_posts($num_of_post) {
        global $authordata, $post;
        $post_type = get_post_type($post->ID);
        $authors_posts = get_posts( array( 'author' => $authordata->ID, 'post_type' => $post_type, 'post__not_in' => array( $post->ID ), 'posts_per_page' => $num_of_post ) );
        $output = '<ul>';
        foreach ( $authors_posts as $authors_post ) {
            $output .= '<li><a href="' .esc_url(get_permalink( $authors_post->ID )). '">' . apply_filters( 'the_title', $authors_post->post_title, $authors_post->ID ) . '</a></li>';
        }
        $output .= '</ul>';
        return $output;
    }
}
//=====================================================================
// Author's posts
//=====================================================================
if (!function_exists('cs_post_author_render')) {
    function cs_post_author_render($atts, $content = ""){
        global $post,$cs_xmlObject,$authordata;
        $defaults = array('thumbnail' => 'on','thumbnail_size' => '70','biographical' => 'off','social' => 'off','num_of_post' => '4' );
        extract( shortcode_atts( $defaults, $atts ) );
        ob_start();
        if (isset($cs_xmlObject->cs_post_author_info_show) && $cs_xmlObject->cs_post_author_info_show == 'on') {
         ?>
            <!-- About Author -->
            <div class="cs-content-wrap">
                <header class="cs-heading-title">
                  <h2 class=" cs-section-title"><?php _e('About','uoc');?> <?php _e('Author','uoc');?></h2>
                </header>
                <div class="about-author">
                    <?php if(isset($thumbnail) && $thumbnail == 'on'){?>
                     <figure><a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" class="float-left"><?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('PixFill_author_bio_avatar_size', $thumbnail_size)); ?></a></figure>
                     <?php }?>
                     <div class="text">
                        <h4><a class="colrhover" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php echo get_the_author(); ?></a></h4>
                        <span></span>
                        <?php if(isset($thumbnail) && $thumbnail == 'on'){?>
                            <p><?php the_author_meta('description'); ?></p>
                        <?php }?>
                        <?php if(isset($social) && $social == 'on'){?>
                            <ul class="socialmedia group">
                                 <?php if(get_the_author_meta('facebook') <> ''){?>
                                <li><a href="http://facebook.com/<?php the_author_meta('facebook'); ?>"><i class="icon-facebook2"></i></a></li>
                                <?php } ?>
                                <?php if(get_the_author_meta('twitter') <> ''){?>
                                <li><a href="http://twitter.com/<?php the_author_meta('twitter'); ?>"><i class="icon-twitter6"></i></a></li>
                                <?php } ?>
                                <li class="share"><a href="<?php esc_url( home_url('/') ) ?>"><?php _e('View All Posts', 'uoc'); ?></a></li>
                           </ul>
                        <?php }?>
                    </div>
                </div>
            </div>    
           <!-- About Author End -->
        <?php     
        }
        $coments_data = ob_get_clean();
        return $coments_data;
    }
    if (function_exists('cs_short_code')) cs_short_code('cs_author_description', 'cs_post_author_render');
    if (function_exists('cs_short_code')) cs_short_code('cs_author_detail', 'cs_post_author_render');
}
//=====================================================================
// Links Render
//=====================================================================
if (!function_exists('cs_edit_link_render')) {
    function cs_edit_link_render($atts, $content = ""){
        global $post;
        ob_start();
        edit_post_link( __( 'Edit','uoc'), '<li>', '</li>' ); 
        $edit_post_data = ob_get_clean();
        return $edit_post_data;
    }
    if (function_exists('cs_short_code')) cs_short_code('cs_edit', 'cs_edit_link_render');
}
//=====================================================================
// next prev posts links
//=====================================================================
if (!function_exists('cs_next_previous_post_render')) {
    function cs_next_previous_post_render($atts, $content = ""){
        global $post, $cs_xmlObject;
        $defaults = array('post_type' => 'post' );
        extract( shortcode_atts( $defaults, $atts ) );
        ob_start();
        if(isset($cs_xmlObject->post_pagination_show) &&  $cs_xmlObject->post_pagination_show == 'on'){cs_next_prev_custom_links();}
        $cs_next_previous_data = ob_get_clean();
        return $cs_next_previous_data;
    }
    if (function_exists('cs_short_code')) cs_short_code('cs_next_previous', 'cs_next_previous_post_render');
}
//=====================================================================
// post share button
//=====================================================================
if (!function_exists('cs_share_render')) {
    function cs_share_render($atts, $content = ""){
        global $post, $cs_xmlObject;
        $defaults = array('title'=>'Share', 'icon' => 'icon-share-square-o', 'class'=>'btnshare' );
        extract( shortcode_atts( $defaults, $atts ) );
        ob_start();
        if ($cs_xmlObject->cs_post_social_sharing == "on"){
            cs_addthis_script_init_method();
            echo '<a class="addthis_button_compact '.$class.'" href="#"><i class="fa '.$icon.'"></i>'.$title.'</a>';
        }

        $share_data = ob_get_clean();
        return $share_data;
    }
    if (function_exists('cs_short_code')) cs_short_code('cs_share', 'cs_share_render');
}

//=====================================================================
// Post comments
//=====================================================================
if (!function_exists('cs_comments_render')) {
    function cs_comments_render($atts, $content = ""){
        global $post;
        ob_start();
        comments_template('', true);
        $coments_data = ob_get_clean();
        return $coments_data;
    }
    if (function_exists('cs_short_code')) cs_short_code('cs_comments', 'cs_comments_render');
}
//=====================================================================
// Post author
//=====================================================================
if (!function_exists('cs_author_render')) {
    function cs_author_render($atts, $content = ""){
        global $post;
        ob_start();
        printf(__('%s','uoc'), '<a href="'.get_author_posts_url(get_the_author_meta('ID')).'" >'.get_the_author().'</a>' );
        $author_data = ob_get_clean();
        return $author_data;
    }
    if (function_exists('cs_short_code')) cs_short_code('cs_author', 'cs_author_render');
}
//=====================================================================
// Post date
//=====================================================================
if (!function_exists('cs_postdate_render')) {
    function cs_postdate_render($atts, $content = ""){
        global $post;
        $defaults = array('date_format' => '' );
        extract( shortcode_atts( $defaults, $atts ) );
        if(isset($date_format) || $date_format <> ''){
            $date_format = $date_format;
        } else {
            $date_format = get_option( 'date_format' );
        }
        ob_start();
        ?>
        <time datetime="<?php echo date_i18n('Y-m-d',strtotime(get_the_date()));?>"><?php echo date_i18n(get_option( 'date_format' ),strtotime(get_the_date()));?></time>
        <?php
        $postdate_data = ob_get_clean();
        return $postdate_data;
    }
    if (function_exists('cs_short_code')) cs_short_code('cs_postdate', 'cs_postdate_render');
}
//=====================================================================
// Post Excerpt
//=====================================================================
if (!function_exists('cs_excerpt_render')) {
    function cs_excerpt_render($atts, $content = ""){
        global $post,$cs_node;
        $defaults = array('read_more' => 'true', 'read_more_text' => 'Read More' );
        ob_start();
        $cs_node->cs_dcpt_excerpt=(int)$cs_node->cs_dcpt_excerpt;
         if(isset($cs_node->cs_dcpt_excerpt) && $cs_node->cs_dcpt_excerpt > 0){?>
            <p><?php  echo cs_get_the_excerpt($cs_node->cs_dcpt_excerpt,$read_more, $read_more_text);?></p>
         <?php }
        $postexcerpt_data = ob_get_clean();
        return $postexcerpt_data;
    }
    if (function_exists('cs_short_code')) cs_short_code('cs_excerpt', 'cs_excerpt_render');
}
//=====================================================================
// Post Title
//=====================================================================
if (!function_exists('cs_title_render')) {
    function cs_title_render($atts, $content = ""){
        global $post;
        $defaults = array( 'link' => 'yes', 'chars' => '' );
        extract( shortcode_atts( $defaults, $atts ) );
        ob_start();
        if($link == 'yes'){
            echo '<a href="'.esc_url(get_permalink()).'">';
        }
        if(!empty($chars) && strlen(get_the_title())>$chars){
            echo substr(get_the_title(),0,$chars);
            echo '...';
        } else {
            the_title();
        }
        if($link == 'yes'){
            echo '</a>';
        }
        $posttitle_data = ob_get_clean();
        return $posttitle_data;
    }
    if (function_exists('cs_short_code')) cs_short_code('cs_title', 'cs_title_render');
}
 
 
//=====================================================================
// featured post title
//=====================================================================
if ( ! function_exists( 'cs_featured_render' ) ) {
    function cs_featured_render($atts, $content = ""){
        $defaults = array( 'title' => 'Featured');
        extract( shortcode_atts( $defaults, $atts ) );
        ob_start();
        if ( is_sticky() ){
            echo '<span class="cs-featured">'.$title.'</span>';
        }
        $postfeatured_data = ob_get_clean();
        return $postfeatured_data;
    }
    if (function_exists('cs_short_code')) cs_short_code('cs_featured', 'cs_featured_render');
}
//=====================================================================
// Rating
//=====================================================================
if ( ! function_exists( 'cs_rating_render' ) ) {
    function cs_rating_render($atts, $content = ""){
        $defaults = array( 'rating_percentage' => '');
        extract( shortcode_atts( $defaults, $atts ) );
        ob_start();
        $rating_percent = 0;
        $rating_percent = $rating_percentage*20;
        echo '<div class="cs-rating"><span style="width:'.$rating_percentage.'%" class="rating-box"></span></div>';        
        $postfeatured_data = ob_get_clean();
        return $postfeatured_data;
    }
    if (function_exists('cs_short_code')) cs_short_code('cs_rating', 'cs_rating_render');
}
//=====================================================================
// attachments
//=====================================================================
if ( ! function_exists( 'cs_mediaattachments_render' ) ) {
    function cs_mediaattachments_render($atts, $content = ""){
        global $post,$cs_node;
        $defaults = array( 'icon' => '');
        extract( shortcode_atts( $defaults, $atts ) );
        $post_xml = get_post_meta($post->ID, "dynamic_cusotm_post", true);
        global $cs_xmlObject;
        if ( $post_xml <> "" ) {
            $cs_xmlObject = new SimpleXMLElement($post_xml);
        }
        $media_attachment = '';
        if($icon){
            $media_attachment .= '<i class="fa '.$icon.'"></i>';
        }
        if(count($cs_xmlObject->gallery)>0){
            $media_attachment .= count($cs_xmlObject->gallery);
        }
        return $media_attachment;
    }
    if (function_exists('cs_short_code')) cs_short_code('cs_mediaattachments', 'cs_mediaattachments_render');
}
//=====================================================================
// Model
//=====================================================================
if ( ! function_exists( 'cs_model_render' ) ) {
    function cs_model_render($atts, $content = ""){
        global $post,$cs_node;
        $defaults = array( 'title' => '', 'model' => '', 'icon' => 'icon-check');
        extract( shortcode_atts( $defaults, $atts ) );
        $post_xml = get_post_meta($post->ID, "dynamic_cusotm_post", true);
        global $cs_xmlObject;
        if ( $post_xml <> "" ) {
            $cs_xmlObject = new SimpleXMLElement($post_xml);
        }
        $cs_model = '';
        if($icon){
            $cs_model .= '<i class="fa '.$icon.'"></i>';
        }
        if($title){
            $cs_model .= $title;
        }
        if(isset($cs_xmlObject->dynamic_post_sale_model) && $cs_xmlObject->dynamic_post_sale_model <> ''){
            $cs_model .= $cs_xmlObject->dynamic_post_sale_model;
        }
        return $cs_model;
    }
    if (function_exists('cs_short_code')) cs_short_code('cs_model', 'cs_model_render');
}
//=====================================================================
// post sale milage
//=====================================================================
if ( ! function_exists( 'cs_milage_render' ) ) {
    function cs_milage_render(){
        global $post,$cs_node;
        $defaults = array( 'title' => '', 'milage' => '', 'icon' => 'icon-check');
        extract( shortcode_atts( $defaults, $atts ) );
        $post_xml = get_post_meta($post->ID, "dynamic_cusotm_post", true);
        global $cs_xmlObject;
        if ( $post_xml <> "" ) {
            $cs_xmlObject = new SimpleXMLElement($post_xml);
        }
        $cs_milage = '';
        if($icon){
            $cs_milage .= '<i class="fa '.$icon.'"></i>';
        }
        if($title){
            $cs_milage .= $title;
        }
        if(isset($cs_xmlObject->dynamic_post_sale_milage) && $cs_xmlObject->dynamic_post_sale_milage <> ''){
            $cs_milage .= $cs_xmlObject->dynamic_post_sale_milage;
        }
        return $cs_milage;
    }
    if (function_exists('cs_short_code')) cs_short_code('cs_milage', 'cs_milage_render');
}
//=====================================================================
// post price
//=====================================================================
if ( ! function_exists( 'cs_price_render' ) ) {
    function cs_price_render($atts, $content = ""){
        global $post,$cs_node;
        $defaults = array( 'title' => '', 'old_price' => '', 'new_price' => '', 'icon' => '');
        extract( shortcode_atts( $defaults, $atts ) );
        $post_xml = get_post_meta($post->ID, "dynamic_cusotm_post", true);
        global $cs_xmlObject;
        if ( $post_xml <> "" ) {
            $cs_xmlObject = new SimpleXMLElement($post_xml);
        }
        $cs_price = '<span>';
        if($title){
            $cs_price .= $title;
        }
        if($icon){
            $cs_price .= '<i class="icon-'.$icon.'"></i>';
        }
        if($title){
            $cs_price .= $title;
        }
        if(isset($cs_xmlObject->dynamic_post_sale_oldprice) && $cs_xmlObject->dynamic_post_sale_oldprice <> ''){
            $cs_price .= '<span>'.$cs_xmlObject->dynamic_post_sale_oldprice.'</span>';
        }
        if(isset($cs_xmlObject->dynamic_post_sale_newprice) && $cs_xmlObject->dynamic_post_sale_newprice <> ''){
            $cs_price .= '<big>'.$cs_xmlObject->dynamic_post_sale_newprice.'</big>';
        }
        $cs_price .= '</span>';
        return '<div class="cs-carprice">'.$cs_price.'</div>';
    }
    if (function_exists('cs_short_code')) cs_short_code('cs_price', 'cs_price_render');
}
//=====================================================================
// custom email
//=====================================================================
if ( ! function_exists( 'cs_custom_email_render' ) ) {
    function cs_custom_email_render($atts, $content = ""){
        global $post,$cs_node;
        $defaults = array( 'name' => '', 'title' => '', 'icon'=>'');
        extract( shortcode_atts( $defaults, $atts ) );
        $post_xml = get_post_meta($post->ID, "dynamic_cusotm_post", true);
        global $cs_xmlObject;
        if ( $post_xml <> "" ) {
            $cs_xmlObject = new SimpleXMLElement($post_xml);
        }
        $cs_custom_email = '';
        if($title){
            $cs_custom_email .= $title;
        }
        if($icon){
            $cs_custom_email .= '<i class="icon-'.$icon.'"></i>';
        }
        if(isset($name)){
            $cs_custom_email .= $cs_xmlObject->$name;
        }
        return $cs_custom_email;
    }
    if (function_exists('cs_short_code')) cs_short_code('cs_email', 'cs_custom_email_render');
}
//=====================================================================
// custom text
//=====================================================================
if ( ! function_exists( 'cs_custom_text_render' ) ) {
    function cs_custom_text_render($atts, $content = ""){
        global $post,$cs_node;
        $defaults = array( 'name' => '', 'title' => '',  'icon'=>'');
        extract( shortcode_atts( $defaults, $atts ) );
        $post_xml = get_post_meta($post->ID, "dynamic_cusotm_post", true);
        global $cs_xmlObject;
        if ( $post_xml <> "" ) {
            $cs_xmlObject = new SimpleXMLElement($post_xml);
        }
        $cs_custom_text = '';
        if($icon){
            $cs_custom_text .= '<i class="fa '.$icon.'"></i>';
        }
        if($title){
            $cs_custom_text .= $title;
        }
        if(isset($name)){
            $cs_custom_text .= $cs_xmlObject->$name;
        }
        return $cs_custom_text;
    }
    if (function_exists('cs_short_code')) cs_short_code('cs_text', 'cs_custom_text_render');
}
//=====================================================================
// custom textarea 
//=====================================================================
if ( ! function_exists( 'cs_custom_textarea_render' ) ) {
    function cs_custom_textarea_render($atts, $content = ""){
        global $post,$cs_node;
        $defaults = array( 'name' => '', 'title' => '',  'icon'=>'');
        extract( shortcode_atts( $defaults, $atts ) );
        $post_xml = get_post_meta($post->ID, "dynamic_cusotm_post", true);
        global $cs_xmlObject;
        if ( $post_xml <> "" ) {
            $cs_xmlObject = new SimpleXMLElement($post_xml);
        }
        $cs_custom_text = '';
        if($icon){
            $cs_custom_text .= '<i class="fa '.$icon.'"></i>';
        }
        if(isset($title) && $title <> ''){
            $cs_custom_text .= $title;
        }
        if(isset($name)){
            $cs_custom_text .= $cs_xmlObject->$name;
        }
        return $cs_custom_text;
    }
    if (function_exists('cs_short_code')) cs_short_code('cs_textarea', 'cs_custom_text_render');
}
//=====================================================================
// custom radio
//=====================================================================
if ( ! function_exists( 'cs_custom_radio_render' ) ) {
    function cs_custom_radio_render($atts, $content = ""){
        global $post,$cs_node;
        $defaults = array( 'name' => '', 'title' => '', 'icon'=>'');
        extract( shortcode_atts( $defaults, $atts ) );
        $post_xml = get_post_meta($post->ID, "dynamic_cusotm_post", true);
        global $cs_xmlObject;
        if ( $post_xml <> "" ) {
            $cs_xmlObject = new SimpleXMLElement($post_xml);
        }
        $cs_custom_radio = '';
        if($icon){
            $cs_custom_radio .= '<i class="fa '.$icon.'"></i>';
        }
        if($title){
            $cs_custom_radio .= $title;
        }
        if(isset($name)){
            $cs_custom_radio .= $cs_xmlObject->$name;
        }
        return $cs_custom_radio;
    }
    if (function_exists('cs_short_code')) cs_short_code('cs_radio', 'cs_custom_radio_render');
}
//=====================================================================
// post date
//=====================================================================
if ( ! function_exists( 'cs_date_render' ) ) {
    function cs_date_render($atts, $content = ""){
        global $post,$cs_node;
        $defaults = array( 'name' => '', 'title' => '',  'icon'=>'');
        extract( shortcode_atts( $defaults, $atts ) );
        $post_xml = get_post_meta($post->ID, "dynamic_cusotm_post", true);
        global $cs_xmlObject;
        if ( $post_xml <> "" ) {
            $cs_xmlObject = new SimpleXMLElement($post_xml);
        }
        $cs_custom_date = '';
        if($icon){
            $cs_custom_date .= '<i class="fa '.$icon.'"></i>';
        }
        if($title){
            $cs_custom_date .= $title;
        }
        if(isset($name)){
            $cs_custom_date .= $cs_xmlObject->$name;
        }
        return $cs_custom_date;
    }
    if (function_exists('cs_short_code')) cs_short_code('cs_date', 'cs_date_render');
}
//=====================================================================
// multi select option
//=====================================================================
if ( ! function_exists( 'cs_multiselect_render' ) ) {
    function cs_multiselect_render($atts, $content = ""){
        global $post,$cs_node;
        $defaults = array( 'name' => '', 'title' => '', 'icon'=>'');
        extract( shortcode_atts( $defaults, $atts ) );
        $post_xml = get_post_meta($post->ID, "dynamic_cusotm_post", true);
        global $cs_xmlObject;
        if ( $post_xml <> "" ) {
            $cs_xmlObject = new SimpleXMLElement($post_xml);
        }
        $cs_multiselect = '';
        if($icon){
            $cs_multiselect .= '<i class="fa '.$icon.'"></i>';
        }
        if($title){
            $cs_multiselect .= $title;
        }
        if(isset($name)){
            $name = trim($name);
            $cs_multiselect .= $cs_xmlObject->$name;
        }
        return $cs_multiselect;
    }
    if (function_exists('cs_short_code')) cs_short_code('cs_multiselect', 'cs_multiselect_render');
}
//=====================================================================
// post url
//=====================================================================
if ( ! function_exists( 'cs_url_render' ) ) {

    function cs_url_render($atts, $content = ""){
        
        global $post,$cs_node;
        $defaults = array( 'name' => '', 'title' => '', 'icon'=>'');
        extract( shortcode_atts( $defaults, $atts ) );
        
        $post_xml = get_post_meta($post->ID, "dynamic_cusotm_post", true);
        global $cs_xmlObject;
        if ( $post_xml <> "" ) {
            $cs_xmlObject = new SimpleXMLElement($post_xml);
        }
        $cs_url_render = '';
        if($icon){
            $cs_url_render .= '<i class="fa '.$icon.'"></i>';
        }
        if($title){
            $cs_url_render .= $title;
        }
        
        if(isset($name)){
            $name = trim($name);
            $cs_url_render .= $cs_xmlObject->$name;
        }
        return $cs_url_render;
    }
    if (function_exists('cs_short_code')) cs_short_code('cs_url', 'cs_url_render');
}
//=====================================================================
// count media attachments
//=====================================================================
if ( ! function_exists( 'cs_mediaattachment_count_render' ) ) {

    function cs_mediaattachment_count_render($atts, $content = ""){
        
        global $post,$cs_node;
        $defaults = array( 'title' => '', 'icon'=>'icon-camera');
        extract( shortcode_atts( $defaults, $atts ) );
        
        $post_xml = get_post_meta($post->ID, "dynamic_cusotm_post", true);
        global $cs_xmlObject;
        if ( $post_xml <> "" ) {
            $cs_xmlObject = new SimpleXMLElement($post_xml);
        }
        $cs_mediaattachment_count .= '<i class="fa '.$icon.'"></i> <span class="viewcount cs-bg-color">'.count($cs_xmlObject->gallery).'</span>';
        return $cs_mediaattachment_count;
    }
    if (function_exists('cs_short_code')) cs_short_code('cs_mediaattachment_count', 'cs_mediaattachment_count_render');
}
if ( ! function_exists( 'cs_map_location_link_render' ) ) {

    function cs_map_location_link_render($atts, $content = ""){
        
        global $post;
        $defaults = array( 'icon' => 'icon-map-marker', 'link'=>'#map');
        extract( shortcode_atts( $defaults, $atts ) );
        
        $cs_map_location .= '<a href="'.esc_url(get_permalink()).$link.'"><i class="fa '.$icon.'"></i></a>';
        return $cs_map_location;
    }
    if (function_exists('cs_short_code')) cs_short_code('cs_map_location', 'cs_map_location_link_render');
}
//=====================================================================
// get location address
//=====================================================================
if ( ! function_exists( 'cs_location_address_render' ) ) {

    function cs_location_address_render($atts, $content = ""){
        global $post;
        $defaults = array( 'icon' => 'icon-map-marker', 'link'=>'#map');
        extract( shortcode_atts( $defaults, $atts ) );
        $post_xml = get_post_meta($post->ID, "dynamic_cusotm_post", true);
        global $cs_xmlObject;
        if ( $post_xml <> "" ) {
            $cs_xmlObject = new SimpleXMLElement($post_xml);
        }
        $cs_location_address = '';
        if(isset($cs_xmlObject->dynamic_post_location_address_icon)){
            $cs_location_address .= '<i class="fa '.$cs_xmlObject->dynamic_post_location_address_icon.'"></i>';
        }
        if(isset($cs_xmlObject->dynamic_post_location_address)){
            $cs_location_address .= $cs_xmlObject->dynamic_post_location_address;
        }
        return $cs_location_address;

    }
    if (function_exists('cs_short_code')) cs_short_code('cs_location_address', 'cs_location_address_render');
}
//=====================================================================
// post hidden
//=====================================================================
if ( ! function_exists( 'cs_hidden_render' ) ) {

    function cs_hidden_render($atts, $content = ""){
        
        global $post,$cs_node;
        $defaults = array( 'name' => '', 'title' => '', 'icon'=>'');
        extract( shortcode_atts( $defaults, $atts ) );
        $post_xml = get_post_meta($post->ID, "dynamic_cusotm_post", true);
        global $cs_xmlObject;
        if ( $post_xml <> "" ) {
            $cs_xmlObject = new SimpleXMLElement($post_xml);
        }
        $cs_hidden = '';
        if($icon){
            $cs_hidden .= '<i class="fa '.$icon.'"></i>';
        }
        if($title){
            $cs_hidden .= $title;
        }
        
        if(isset($name)){
            $name = trim($name);
            $cs_hidden .= $cs_xmlObject->$name;
        }
        return $cs_hidden;
    }
    if (function_exists('cs_short_code')) cs_short_code('cs_hidden', 'cs_hidden_render');
}
//=====================================================================
// post dropdown option
//=====================================================================
if ( ! function_exists( 'cs_post_dropdown_render' ) ) {

    function cs_post_dropdown_render($atts, $content = ""){
        
        global $post,$cs_node;
        $defaults = array( 'name' => '', 'title' => '', 'icon'=>'');
        extract( shortcode_atts( $defaults, $atts ) );
        $post_xml = get_post_meta($post->ID, "dynamic_cusotm_post", true);
        global $cs_xmlObject;
        if ( $post_xml <> "" ) {
            $cs_xmlObject = new SimpleXMLElement($post_xml);
        }
        $cs_post_dropdown = '';
        if($icon){
            $cs_post_dropdown .= '<i class="fa '.$icon.'"></i>';
        }
        if($title){
            $cs_post_dropdown .= $title;
        }
        if(isset($name)){
            $name = trim($name);
            $cs_post_dropdown .= $cs_xmlObject->$name;
        }
        return $cs_post_dropdown;
    }
    if (function_exists('cs_short_code')) cs_short_code('cs_dropdown', 'cs_post_dropdown_render');
}
//=====================================================================
// buy tickers
//=====================================================================
if ( ! function_exists( 'cs_buytickets_render' ) ) {

    function cs_buytickets_render($atts, $content = ""){
        global $post;
        $defaults = array( 'icon' => 'icon-map-marker', 'title'=>'', 'link'=>'#map');
        extract( shortcode_atts( $defaults, $atts ) );
        $post_xml = get_post_meta($post->ID, "dynamic_cusotm_post", true);
        global $cs_xmlObject;
        if ( $post_xml <> "" ) {
            $cs_xmlObject = new SimpleXMLElement($post_xml);
        }
        $cs_location_address = '';
        if(isset($cs_xmlObject->dynamic_post_location_address_icon)){
            $cs_location_address .= '<i class="fa '.$cs_xmlObject->dynamic_post_location_address_icon.'"></i>';
        }
        if(isset($cs_xmlObject->dynamic_post_location_address)){
            $cs_location_address .= $cs_xmlObject->dynamic_post_location_address;
        }
        return $cs_location_address;

    }
    if (function_exists('cs_short_code')) cs_short_code('cs_buytickets', 'cs_buytickets_render');
}
//=====================================================================
// user wishlist
//=====================================================================
if ( ! function_exists( 'cs_wishlist_render' ) ) {
    function cs_wishlist_render($atts, $content = ""){
        global $post;
        $defaults = array( 'icon' => 'icon-plus', 'title'=>'Save');
        extract( shortcode_atts( $defaults, $atts ) );
        ob_start();
        $post_data = ob_get_clean();
        return $post_data;

    }
    if (function_exists('cs_short_code')) cs_short_code('cs_wishlist', 'cs_wishlist_render');
}
//=====================================================================
// wishlist listing
//=====================================================================
if ( ! function_exists( 'cs_wishlist_listing_render' ) ) {
    function cs_wishlist_listing_render($atts, $content = ""){
        global $post;
        $defaults = array( 'icon' => 'icon-plus', 'title'=>'Save');
        extract( shortcode_atts( $defaults, $atts ) );
        ob_start();
        $post_data = ob_get_clean();
        return $post_data;
    }
    if (function_exists('cs_short_code')) cs_short_code('cs_wishlisting', 'cs_wishlist_listing_render');
}
//=====================================================================
// like counter
//=====================================================================
if ( ! function_exists( 'cs_likecounter_render' ) ) {
    function cs_likecounter_render($atts, $content = ""){
        global $post;
        $defaults = array( 'icon' => 'icon-plus', 'title'=>'Save');
        extract( shortcode_atts( $defaults, $atts ) );
        ob_start();
        $post_data = ob_get_clean();
        return $post_data;
    }
    if (function_exists('cs_short_code')) cs_short_code('cs_likecounter', 'cs_likecounter_render');
}
//=====================================================================
// User Rating 
//=====================================================================
if ( ! function_exists( 'cs_user_rating_render' ) ) {
    function cs_user_rating_render($atts, $content = ""){
        global $post;
        $defaults = array( 'icon' => 'icon-plus', 'title'=>'Save');
        extract( shortcode_atts( $defaults, $atts ) );
        ob_start();
        $post_data = ob_get_clean();
        return $post_data;
    }
    if (function_exists('cs_short_code')) cs_short_code('cs_user_rating', 'cs_user_rating_render');
}

//=====================================================================
// Shortcode Array Start
//=====================================================================
if ( ! function_exists( 'cs_shortcode_names' ) ) {
    function cs_shortcode_names(){
    global $post;
    $dcpt_elements_array = array();
        $shortcode_array = array(
             
                 'blog'=>array(
                        'title'=>__('Blog','uoc'),
                        'name'=>'blog',
                        'icon'=>'icon-newspaper',
                        'categories'=>'loops',
                 ),
                 'button'=>array(
                        'title'=>__('Button','uoc'),
                        'name'=>'button',
                        'icon'=>'icon-hand-o-up',
                        'categories'=>'commonelements',
                 ),
                  
                 'clients'=>array(
                        'title'=>__('Clients','uoc'),
                        'name'=>'clients',
                        'icon'=>'icon-user3',
                        'categories'=>'loops',
                 ),
                 'contactus'=>array(
                    'title'=>__('Contact Us','uoc'),
                    'name'=>'contactus',
                    'icon'=>'icon-building-o',
                    'categories'=>'contentblocks',
                 ),
                 'counter'=>array(
                        'title'=>__('Counter','uoc'),
                        'name'=>'counter',
                        'icon'=>'icon-clock-o',
                        'categories'=>'commonelements',
                 ),
				 
				  'call_to_action'=>array(
                        'title'=>__('Call to Action','uoc'),
                        'name'=>'call_to_action',
                        'icon'=>'icon-hand-o-up',
                        'categories'=>'commonelements',
                 ),
				  'divider'=>array(
                        'title'=>__('Divider','uoc'),
                        'name'=>'divider',
                        'icon'=>'icon-ellipsis-h',
                        'categories'=>'typography misc',
                 ),
				 
				 /*'categories'=>array(
                        'title'=>__('Categories','uoc'),
                        'name'=>'categories',
                        'icon'=>'icon-h-square',
                        'categories'=>'typography misc',
                 ),*/
				 'flex_column'=>array(
                        'title'=>__('Column','uoc'),
                        'name'=>'flex_column',
                        'icon'=>'icon-columns',
                        'categories'=>'typography misc',
                 ),
				  
                 'heading'=>array(
                        'title'=>__('Heading','uoc'),
                        'name'=>'heading',
                        'icon'=>'icon-h-square',
                        'categories'=>'typography misc',
                 ),
				 'openinghours'=>array(
                        'title'=>__('Opening Hours','uoc'),
                        'name'=>'openinghours',
                        'icon'=>'icon-h-square',
                        'categories'=>'typography misc',
                 ),
                 'infobox'=>array(
                        'title'=>__('Info box','uoc'),
                        'name'=>'infobox',
                        'icon'=>'icon-info-circle',
                        'categories'=>' contentblocks',
                 ),
                 'image'=>array(
                        'title'=>__('Image Frame','uoc'),
                        'name'=>'image',
                        'icon'=>'icon-photo2',
                        'categories'=>'mediaelement',
                 ),
                 'list'=>array(
                        'title'=>__('List','uoc'),
                        'name'=>'list',
                        'icon'=>'icon-list-ol',
                        'categories'=>'typography misc    ',
                 ),
                 'map'=>array(
                        'title'=>__('Map','uoc'),
                        'name'=>'map',
                        'icon'=>'icon-list-ol',
                        'categories'=>'contentblocks',
                 ),
                 
				 'multiple_services'=>array(
                        'title'=>__('Multiple Services','uoc'),
                        'name'=>'multiple_services',
                        'icon'=>'icon-database2',
                        'categories'=>'loops misc',
                 ),
                 'progressbars'=>array(
                        'title'=>__('Progress Bars','uoc'),
                        'name'=>'progressbars',
                        'icon'=>'icon-list-alt',
                        'categories'=>' commonelements',
                 ),
				 
				 'pricetable'=>array(
                        'title'=>__('Price Table','uoc'),
                        'name'=>'pricetable',
                        'icon'=>'icon-table',
                        'categories'=>'commonelements',
                 ),
				  'promobox'=>array(
                        'title'=>__('Promo box','uoc'),
                        'name'=>'promobox',
                        'icon'=>'icon-bullhorn',
                        'categories'=>' mediaelement',
                 ),
                 'quote'=>array(
                        'title'=>__('Quote','uoc'),
                        'name'=>'quote',
                        'icon'=>'icon-quote-right',
                        'categories'=>'typography misc',
                 ),
				 
				'job_specialisms' => array(
						'title' => __('Categories', 'uoc'),
						'name' => 'job_specialisms',
						'icon' => 'icon-table',
						'categories' => 'loops misc',
				),
				 'quick_quote'=>array(
                        'title'=>__('Quick Quote','uoc'),
                        'name'=>'quick_quote',
                        'icon'=>'icon-quote-right',
                        'categories'=>'typography misc',
                 ), 
				 'video'=>array(
                        'title'=>__('Video','uoc'),
                        'name'=>'video',
                        'icon'=>'icon-quote-right',
                        'categories'=>'typography misc',
                 ), 
                 'slider'=>array(
                        'title'=>__('Slider','uoc'),
                        'name'=>'slider',
                        'icon'=>'icon-image2',
                        'categories'=>'loops',
                 ),
                  'services'=>array(
                        'title'=>__('Services','uoc'),
                        'name'=>'services',
                        'icon'=>'icon-check-square-o',
                        'categories'=>' commonelements',
                 ),

                  'tabs'=>array(
                        'title'=>__('Tabs','uoc'),
                        'name'=>'tabs',
                        'icon'=>'icon-list-alt',
                        'categories'=>'commonelements',
                 ),
                 
                  'testimonials'=>array(
                        'title'=>__('Testimonials','uoc'),
                        'name'=>'testimonials',
                        'icon'=>'icon-comments-o',
                        'categories'=>'typography misc',
                 ),
                 'table'=>array(
                        'title'=>__('Table','uoc'),
                        'name'=>'table',
                        'icon'=>'icon-th',
                        'categories'=>'commonelements',
                 ),
                 'tweets'=>array(
                        'title'=>__('Tweets','uoc'),
                        'name'=>'tweets',
                        'icon'=>'icon-twitter2',
                        'categories'=>'loops',
                 ),
                 
                 'spacer'=>array(
                        'title'=>__('Spacer','uoc'),
                        'name'=>'spacer',
                        'icon'=>'icon-arrows-v',
                        'categories'=>'commonelements',
                 ), 
				 'sitemap'=>array(
                        'title'=>__('Site Map','uoc'),
                        'name'=>'sitemap',
                        'icon'=>'icon-arrows-v',
                        'categories'=>'commonelements',
                 ), 
			 
				  'search'=>array(
                        'title'=>__('Search','uoc'),
                        'name'=>'search',
                        'icon'=>'icon-arrows-v',
                        'categories'=>'commonelements',
                 ), 
				 
	 
				 'faq'=>array(
                        'title'=>__('FAQ','uoc'),
                        'name'=>'faq',
                        'icon'=>'icon-question-circle',
                        'categories'=>'typography',
                 ),
				                   
        );
        
		
			
			if( class_exists('cs_framework') ) {
				$cs_frame_plugin = array(	'events'=>array(
					'title'=>__('Events','uoc'),
					'name'=>'events',
					'icon'=>'icon-question-circle',
					'categories'=>'loops misc',
					),
				);
				$shortcode_array	= array_merge($shortcode_array,$cs_frame_plugin);					
			}
		
		
		
		
		 if( class_exists('cs_framework') ) {
			 $plugin_shortcodes = array(	
			 							
			 								'team_post'=>array(
													'title'=>__('Team','uoc'),
													'name'=>'team_post',
													'icon'=>'icon-user',
													'categories'=>'loops',
											 ),
											 'gallery'=>array(
													'title'=>__('Galleries','uoc'),
													'name'=>'gallery',
													'icon'=>'icon-arrows-v',
													'categories'=>'commonelements',
											 ),
											 'course'=>array(
													'title'=>__('Course','uoc'),
													'name'=>'course',
													'icon'=>'icon-arrows-v',
													'categories'=>'commonelements',
											 ),
								  );
								  
								$shortcode_array	= array_merge($shortcode_array,$plugin_shortcodes);					
				}
        ksort($shortcode_array);
        return $shortcode_array;
    }
}
 
   
 		// create new role when plugin is activate 
		   //if( class_exists('cs_framework') ) {
		   
				/*$result = add_role('instructor',__( 'Instructor' ),
					array(
					'read'         => true,  // true allows this capability
					'edit_posts'   => true,
					'delete_posts' => false, // Use false to explicitly deny
					)
				);*/
		//}




//=====================================================================
// Shortcode Buttons
//=====================================================================
add_action('media_buttons','cs_shortcode_popup',11);
// 
if ( ! function_exists( 'cs_shortcode_popup' ) ) {
    function cs_shortcode_popup($die = 0, $shortcode='shortcode'){
        $i = 1;
        $style='';
        if ( isset($_POST['action']) ) {
            $name = $_POST['action'];
            $cs_counter = $_POST['counter'];
            $randomno = cs_generate_random_string('5');
            $rand = rand(1,999);
            $style='';
        } else {
            $name = '';
            $cs_counter = '';
            $rand = rand(1,999);
            $randomno = cs_generate_random_string('5');
            if(isset($_REQUEST['action']))
                $name = $_REQUEST['action'];
            $style='style="display:none;"';
        }
        $cs_page_elements_name = array();
        $cs_page_elements_name = cs_shortcode_names();
         $cs_page_categories_name =  cs_elements_categories();
        
    ?> 
        <div class="cs-page-composer  <?php echo sanitize_html_class($shortcode);?> composer-<?php echo intval($rand) ?>" id="composer-<?php echo intval($rand) ?>" style="display:none">
            <div class="page-elements">
            <div class="cs-heading-area">
                 <h5>
                    <i class="icon-plus-circle"></i> <?php _e('Add Element','uoc');?>
                </h5>
                <span class='cs-btnclose' onclick='javascript:removeoverlay("composer-<?php echo esc_js($rand) ?>","append")'>
				<i class="icon-times"></i>
				</span>
            </div>
            <script>
                jQuery(document).ready(function($){
                    cs_page_composer_filterable('<?php echo esc_js($rand)?>');
                });
            </script>
         <div class="cs-filter-content shortcode">
            <p><input type="text" id="quicksearch<?php echo intval($rand) ?>" placeholder="<?php _e('Search','uoc');?>" /></p>
              <div class="cs-filtermenu-wrap">
                <h6><?php _e('Filter by','uoc');?></h6>
                <ul class="cs-filter-menu" id="filters<?php echo intval($rand) ?>">
                  <li data-filter="all" class="active"><?php _e('Show all','uoc');?></li>
                  <?php foreach($cs_page_categories_name as $key=>$value){
                          echo '<li data-filter="'.$key.'">'.$value.'</li>';
                    }?>
                </ul>
              </div>
                <div class="cs-filter-inner" id="page_element_container<?php echo intval($rand) ?>">
                    <?php foreach($cs_page_elements_name as $key=>$value){
                            echo '<div class="element-item '.$value['categories'].'">';
                              $icon = isset($value['icon']) ? $value['icon'] : 'accordion-icon'; ?>
                              <a href='javascript:cs_shortocde_selection("<?php echo esc_js($key);?>","<?php echo admin_url('admin-ajax.php');?>","composer-<?php echo intval($rand) ?>")'><?php cs_page_composer_elements($value['title'], $icon)?></a>
                          </div>
                    <?php }?>
                </div>
              </div>
            </div>
            <div class="cs-page-composer-shortcode"></div>
        </div>
       <?php 
        if(isset($shortcode) && $shortcode <> ''){
            ?>
            <a class="button" href="javascript:_createpop('composer-<?php echo esc_js($rand) ?>', 'filter')">
            <i class="icon-plus-circle"></i> <?php _e('CS: Insert shortcode','uoc');?></a>
            <?php
        }
    }
}
//=====================================================================
// Column Size Dropdown Function Start
//=====================================================================
if ( ! function_exists( 'cs_shortcode_element_size' ) ) {
    function cs_shortcode_element_size($column_size =''){
        ?>
            <ul class="form-elements">
                <li class="to-label"><label><?php _e('Size','uoc');?></label></li>
                <li class="to-field select-style">
                    <select class="column_size" id="column_size" name="column_size[]">
                        <option value="1/1" <?php if($column_size == '1/1'){echo 'selected="selected"';}?>><?php _e('Full width','uoc');?></option>
                        <option value="1/2" <?php if($column_size == '1/2'){echo 'selected="selected"';}?>><?php _e('One half','uoc');?></option>
                        <option value="1/3" <?php if($column_size == '1/3'){echo 'selected="selected"';}?>><?php _e('One third','uoc');?></option
                        ><option value="2/3" <?php if($column_size == '2/3'){echo 'selected="selected"';}?>><?php _e('Two third','uoc');?></option>
                        <option value="1/4" <?php if($column_size == '1/4'){echo 'selected="selected"';}?>><?php _e('One fourth','uoc');?></option>
                        <option value="3/4" <?php if($column_size == '3/4'){echo 'selected="selected"';}?>><?php _e('Three fourth','uoc');?></option>
                    </select>
                    <p><?php _e('Select column width. This width will be calculated depend page width','uoc');?></p>
                </li>                  
            </ul>
        <?php
    }
}
// Column Size Dropdown Function end

//=====================================================================
// Animation Styles
//=====================================================================
function cs_animation_style(){
    return $animation_style = array(
                        'Entrances'=>array('slideDown'=>'slideDown','slideUp'=>'slideUp','slideLeft'=>'slideLeft','slideRight'=>'slideRight','slideExpandUp'=>'slideExpandUp','expandUp'=>'expandUp','expandOpen'=>'expandOpen','bigEntrance'=>'bigEntrance','hatch'=>'hatch'),
                        'Misc'=>array('floating'=>'floating','tossing'=>'tossing','pullUp'=>'pullUp','pullDown'=>'pullDown','stretchLeft'=>'stretchLeft','stretchRight'=>'stretchRight'),
                        'Attention Seekers'=>array('bounce'=>'bounce','flash'=>'flash','pulse'=>'pulse','rubberBand'=>'rubberBand','shake'=>'shake','swing'=>'swing','tada'=>'tada','wobble'=>'wobble'),
                        'Bouncing Entrances'=>array('bounceIn'=>'bounceIn','bounceInDown'=>'bounceInDown','bounceInLeft'=>'bounceInLeft','bounceInRight'=>'bounceInRight','bounceInUp'=>'bounceInUp'),
                         'Fading Entrances'=>array('fadeIn'=>'fadeIn','fadeInDown'=>'fadeInDown','fadeInDownBig'=>'fadeInDownBig','fadeInLeft'=>'fadeInLeft','fadeInLeftBig'=>'fadeInRight','fadeInRightBig'=>'fadeInRightBig','fadeInUp'=>'fadeInUp','fadeInUpBig'=>'fadeInUpBig'),
                        'Flippers'=>array('flip'=>'flip','flipInX'=>'flipInX','flipInY'=>'flipInY'),
                        'Lightspeed'=>array('lightSpeedIn'=>'lightSpeedIn'),
                         'Rotating Entrances'=>array('rotateIn'=>'rotateIn','rotateInDownLeft'=>'rotateInDownLeft','rotateInDownRight'=>'rotateInDownRight','rotateInUpLeft'=>'rotateInUpLeft','rotateInUpRight'=>'rotateInUpRight'),
                        'Specials'=>array('hinge'=>'hinge','rollIn'=>'rollIn'),
                        'Zoom Entrances'=>array('zoomIn'=>'zoomIn','zoomInDown'=>'zoomInDown','zoomInLeft'=>'zoomInLeft','zoomInRight'=>'zoomInRight','zoomInUp'=>'zoomInUp'),
                        );    
}
//=====================================================================
// Custom Class and Animations Function Start
//=====================================================================
if ( ! function_exists( 'cs_shortcode_custom_classes' ) ) {
    function cs_shortcode_custom_classes($cs_custom_class = '',$cs_custom_animation='',$cs_custom_animation_duration='1'){
        ?>
            <ul class="form-elements">
                <li class="to-label"><label><?php _e('Custom Id','uoc');?></label></li>
                <li class="to-field">
                    <input type="text" name="cs_custom_class[]" class="txtfield"  value="<?php echo sanitize_text_field($cs_custom_class); ?>" />
                    <p><?php _e('Use this option if you want to use specified Class for this element','uoc');?></p>
                </li>
            </ul>
            <?php $custom_animation_array = array('fade'=>'Fade','slide'=>'Slide','left-slide'=>'left Slide');?>
            <ul class="form-elements">
                <li class="to-label"><label><?php _e('Animation Class','uoc');?><?php echo sanitize_text_field($cs_custom_animation);?></label></li>
                <li class="to-field select-style">
                    <select class="dropdown" name="cs_custom_animation[]">
                        <option value=""><?php _e('Animation Class','uoc');?></option>
                        <?php 
                                $animation_array = cs_animation_style();
                                foreach($animation_array as $animation_key=>$animation_value){
                                    echo '<optgroup label="'.$animation_key.'">';    
                                    foreach($animation_value as $key=>$value){
                                        $active_class = '';
                                        if($cs_custom_animation == $key){$active_class = 'selected="selected"';}
                                        echo '<option value="'.$key.'" '.$active_class.'>'.$value.'</option>';
                                    }
                                }
                        ?>
                      </select>
                      <p><?php _e('Select Entrance animation type from the dropdown','uoc');?> </p>
                </li>
            </ul>
        <?php
    }
}
// Custom Class and Animations Function end
//=====================================================================
// Dynamic Custom Class and Animations Function Start
//=====================================================================
if ( ! function_exists( 'cs_shortcode_custom_dynamic_classes' ) ) {
    function cs_shortcode_custom_dynamic_classes($cs_custom_class = '',$cs_custom_animation='',$cs_custom_animation_duration='1',$prefix){
        ?>
            <ul class="form-elements">
                <li class="to-label"><label><?php _e('Custom Id','uoc');?></label></li>
                <li class="to-field">
                    <input type="text" name="<?php echo sanitize_text_field($prefix);?>_class[]" class="txtfield"  value="<?php echo sanitize_text_field($cs_custom_class)?>" />
                    <p><?php _e('Use this option if you want to use specified id for this element','uoc');?></p>
                </li>
            </ul>
            <?php $custom_animation_array = array('fade'=>'Fade','slide'=>'Slide','left-slide'=>'left Slide');?>
            <ul class="form-elements">
                <li class="to-label"><label><?php _e('Animation Class','uoc');?> <?php echo sanitize_text_field($cs_custom_animation);?></label></li>
                <li class="to-field select-style">
                    <select class="dropdown" name="<?php echo sanitize_text_field($prefix);?>_animation[]">
                        <option value=""><?php _e('Select Animation','uoc');?></option>
                        <?php 
                                $animation_array = cs_animation_style();
                                foreach($animation_array as $animation_key=>$animation_value){
                                    echo '<optgroup label="'.$animation_key.'">';    
                                    foreach($animation_value as $key=>$value){
                                        $active_class = '';
                                        if($cs_custom_animation == $key){$active_class = 'selected="selected"';}
                                        echo '<option value="'.$key.'" '.$active_class.'>'.$value.'</option>';
                                    }
                                }
                        
                        ?>
                      </select>
                      <p><?php _e('Select Entrance animation type from the dropdown','uoc');?></p>
                </li>
            </ul>  
        <?php
    }
}
// Dynamic Custom Class and Animations Function end
//=====================================================================
// Shortcode Add box Ajax Function
//=====================================================================
if ( ! function_exists( 'cs_shortcode_element_ajax_call' ) ) {
    function cs_shortcode_element_ajax_call(){?>
    <?php     
        if(isset($_POST['shortcode_element']) && $_POST['shortcode_element']){
            if($_POST['shortcode_element'] == 'services'){
                $rand_id = rand(18332324,94323777);
                ?>
                <div class='cs-wrapp-clone cs-shortcode-wrapp'  id="cs_infobox_<?php echo intval( $rand_id);?>">
                    <header>
						<h4>
							<i class='icon-arrows'></i><?php _e('Service','uoc');?>
						</h4>
						<a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php _e('Remove','uoc');?></a>
					</header>
                    
                    <?php if ( function_exists( 'cs_shortcode_element_size' ) ) {cs_shortcode_element_size();}?>
                    <ul class='form-elements'>
                        <li class='to-label'><label><?php _e('Service Title','uoc');?></label></li>
                        <li class='to-field'> <div class='input-sec'><input class='txtfield' type='text' name='service_title[]' /></div>
                        <div class='left-info'><p><?php _e('Title of the Service','uoc');?></p></div>
                        </li>
                    </ul>
                    <ul class='form-elements'>
                        <li class='to-label'><label><?php _e('Service View:','uoc');?></label></li>
                        <li class='to-field select-style'> <div class='input-sec'><select name='service_type[]' class='dropdown'>
                        <option value='size_large'><?php _e('Large Boxed','uoc');?></option>
                        <option value='size_large_normal'><?php _e('Large Normal','uoc');?></option>
                        <option value='size_circle'><?php _e('Circle','uoc');?></option>
                        <option  value="size_medium" ><?php _e('Medium','uoc');?></option>
                        <option value='size_small'><?php _e('Small','uoc');?></option>
                        </select></div>
                        <div class='left-info'><p><?php _e('Type of the Service','uoc');?></p></div>
                        </li>
                    </ul>
                     <ul class='form-elements' id="<?php echo intval( $rand_id);?>">
                            <li class='to-label'><label><?php _e('Font awsome Icon:','uoc');?></label></li>
                            <li class="to-field">
                                <?php cs_fontawsome_icons_box('',$rand_id,'cs_service_icon');?>
                            </li>
                    </ul>
                    <ul class="form-elements">
                        <li class="to-label"><label><?php _e('Icon Postion','uoc');?></label></li>
                        <li class="to-field select-style">
                            <select class="service_icon_postion" name="service_icon_postion[]">
                                <option value="left"><?php _e('left','uoc');?></option>
                                <option value="right"><?php _e('Right','uoc');?></option>
                                <option value="top"><?php _e('Top','uoc');?></option>
                                <option value="center"><?php _e('Center','uoc');?></option>
                            </select>
                        </li>                  
                    </ul>
                    <ul class="form-elements">
                        <li class="to-label"><label><?php _e('Icon Type','uoc');?></label></li>
                        <li class="to-field select-style">
                            <select class="service_icon_type" name="service_icon_type[]">
                                <option value="circle"><?php _e('Circle','uoc');?></option>
                                <option value="square"><?php _e('Square','uoc');?></option>
                            </select>
                        </li>                  
                    </ul>
                    <ul class="form-elements">
                          <li class="to-label">
                            <label><?php _e('Service background  Image','uoc');?></label>
                          </li>
                          <li class="to-field">
                            <input id="service_bg_image<?php echo intval( $rand_id);?>" name="service_bg_image[]" type="hidden" class="" value=""/>
                            <input name="service_bg_image<?php echo intval( $rand_id);?>"  type="button" class="uploadMedia left" value="<?php _e('Browse','uoc');?>"/>
                          </li>
                        </ul>
                        <div class="page-wrap" style="overflow:hidden; display:none;?>" id="service_bg_image<?php echo intval( $rand_id);?>_box" >
                          <div class="gal-active">
                            <div class="dragareamain" style="padding-bottom:0px;">
                              <ul id="gal-sortable">
                                <li class="ui-state-default" id="">
                                  <div class="thumb-secs"> 
                                  	<img src="<?php echo esc_url($service_bg_image);?>"  id="service_bg_image<?php echo intval( $rand_id);?>_img" width="100" height="150"  />
                                    <div class="gal-edit-opts"> <a   href="javascript:del_media('service_bg_image<?php echo intval( $rand_id);?>')" class="delete"></a> </div>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                    <ul class='form-elements'>
                        <li class='to-label'><label><?php _e('Service Link Url','uoc');?></label></li>
                        <li class='to-field'> <div class='input-sec'><input class='txtfield' type='text' name='service_link_url[]' /></div>
                        <div class='left-info'><p><?php _e('Service Link Url','uoc');?></p></div>
                        </li>
                    </ul>
                    <ul class="form-elements">
                        <li class="to-label"><label><?php _e('Border','uoc');?></label></li>
                        <li class="to-field select-style">
                            <select class="service_border" id="service_border" name="service_border[]">
                                <option value="yes"><?php _e('Yes','uoc');?></option>
                                <option value="no"><?php _e('No','uoc');?></option>
                            </select>
                        </li>                  
                    </ul>
                    <ul class='form-elements'>
                        <li class='to-label'><label><?php _e('Service Text:','uoc');?></label></li>
                        <li class='to-field'>
							<div class='input-sec'>
								<textarea class='txtfield' data-content-text="cs-shortcode-textarea" name='service_text[]'></textarea>
							</div>
                        </li>
                    </ul>
                    <ul class="form-elements">
                        <li class="to-label"><label><?php _e('Divider','uoc');?></label></li>
                        <li class="to-field select-style">
                            <select class="service_divider" name="service_divider[]">
                                <option value="yes"><?php _e('Yes','uoc');?></option>
                                <option value="no"><?php _e('No','uoc');?></option>
                            </select>
                        </li>                  
                    </ul>
                    <ul class="form-elements">
                        <li class="to-label"><label><?php _e('Icon Color','uoc');?></label></li>
                        <li class="to-field">
                            <input type="text" name="service_icon_color[]" class="bg_color"  value="" />
                        </li>
                    </ul>
                    <ul class="form-elements">
                        <li class="to-label"><label><?php _e('Icon Background Color','uoc');?></label></li>
                        <li class="to-field">
                            <input type="text" name="service_icon_bg_color[]" class="bg_color"  value="" />
                        </li>
                    </ul>
                       <ul class="form-elements">
                        <li class="to-label"><label><?php _e('Custom Id','uoc');?></label></li>
                        <li class="to-field">
                            <input type="text" name="service_class[]" class="txtfield"  value="" />
                        </li>
                     </ul>
                    <ul class="form-elements">
                        <li class="to-label"><label><?php _e('Animation Class','uoc');?> </label></li>
                        <li class="to-field select-style">
                            <select class="dropdown" name="service_animation[]">
                                <option value=""><?php _e('Select Animation','uoc');?></option>
                                <?php 
                                    $animation_array = cs_animation_style();
                                    foreach($animation_array as $animation_key=>$animation_value){
                                        echo '<optgroup label="'.$animation_key.'">';    
                                        foreach($animation_value as $key=>$value){
                                            echo '<option value="'.esc_attr($key).'" >'.$esc_attr(value).'</option>';
                                        }
                                    }
                                
                                 ?>
                              </select>
                        </li>
                    </ul>
                </div>
                <?php     
            } 
            else if($_POST['shortcode_element'] == 'accordions'){
                 $rand_id = rand(324235,993249);
                ?>
                    <div class='cs-wrapp-clone cs-shortcode-wrapp'  id="cs_infobox_<?php echo intval( $rand_id);?>">
                        <header>
							<h4><i class='icon-arrows'></i><?php _e('Accordion','uoc');?></h4>
							<a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php _e('Remove','uoc');?></a>
						</header>
                        <ul class='form-elements'>
                            <li class='to-label'><label><?php _e('Active','uoc');?></label></li>
                            <li class='to-field select-style'>
								 <select name='accordion_active[]'>
								 	<option value="no"><?php _e('No','uoc');?></option><option value="yes"><?php _e('Yes','uoc');?></option>
								</select>
                            <div class='left-info'>
                              <p><?php _e('You can set the section that is active here by select dropdown','uoc');?></p>
                            </div>
                            </li>
                        </ul>
                        <ul class='form-elements'>
                            <li class='to-label'><label><?php _e('Accordion Title','uoc');?></label></li>
                            <li class='to-field'>
								<div class='input-sec'>
									<input class='txtfield' type='text' name='accordion_title[]' />
								</div>
                            <div class='left-info'>
                              <p><?php _e('Enter accordion title','uoc');?></p>
                            </div>
                            </li>
                        </ul>
                        <ul class='form-elements' id="<?php echo intval($rand_id);?>">
                            <li class='to-label'><label><?php _e('Font awsome Icon','uoc');?></label></li>
                            <li class="to-field">
                                    <?php cs_fontawsome_icons_box('',$rand_id,'cs_accordian_icon');?>
                                    
                                    <div class='left-info'>
                                      <p><?php _e('Select the font awsome Icons you would like to add to your menu items','uoc');?></p>
                                    </div>
                            </li>
                        </ul>
                        <ul class='form-elements'>
                            <li class='to-label'><label><?php _e('Accordion Text','uoc');?></label></li>
                            <li class='to-field'>
								<div class='input-sec'>
									<textarea class='txtfield' data-content-text="cs-shortcode-textarea" name='accordion_text[]'></textarea>
								</div>
                            <div class='left-info'>
                              <p><?php _e('Enter your content','uoc');?></p>
                            </div>
                            </li>
                        </ul>
                    </div>
                <?php    
            
        
            }
            else if($_POST['shortcode_element'] == 'faq'){
                 $rand_id = rand(32433245,99234239);
                ?>
                    <div class='cs-wrapp-clone cs-shortcode-wrapp' id="cs_infobox_<?php echo intval( $rand_id);?>">
                        <header>
							<h4><i class='icon-arrows'></i><?php _e('FAQ','uoc');?></h4>
							<a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php _e('Remove','uoc');?></a>
						</header>
                        <ul class='form-elements'>
                            <li class='to-label'><label><?php _e('Active','uoc');?></label></li>
                            <li class='to-field select-style'>
								<select name='faq_active[]'>
									<option value="no"><?php _e('No','uoc');?></option><option value="yes"><?php _e('Yes','uoc');?></option>
								</select>
                            </li>
                        </ul>
                        <ul class='form-elements'>
                            <li class='to-label'><label><?php _e('Faq Title:','uoc');?></label></li>
                            <li class='to-field'>
								<div class='input-sec'>
									<input class='txtfield' type='text' name='faq_title[]' />
								</div>
                            </li>
                        </ul>
                        <!--<ul class='form-elements' id="<?php //echo intval( $rand_id);?>">
                            <li class='to-label'><label><?php //_e('Font awsome Icon','uoc');?></label></li>
                            <li class="to-field">
                                    <?php //cs_fontawsome_icons_box('',$rand_id,'cs_faq_icon');?>
                            </li>
                        </ul>-->
                        <ul class='form-elements'>
                            <li class='to-label'><label><?php _e('Faq Text','uoc');?></label></li>
                            <li class='to-field'>
								<div class='input-sec'>
									<textarea class='txtfield' data-content-text="cs-shortcode-textarea" name='faq_text[]'></textarea>
								</div>
                            </li>
                        </ul>
                    </div>
                <?php    
                
         }
            else if($_POST['shortcode_element'] == 'register'){
                 $rand_id = rand(5,999);
                ?>
                    <div class='cs-wrapp-clone cs-shortcode-wrapp'  id="cs_infobox_<?php echo intval( $rand_id);?>">
                        <header>
							<h4><i class='icon-arrows'></i><?php _e('Register','uoc');?></h4>
							<a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php _e('Remove','uoc');?></a>
						</header>
                        <ul class='form-elements'>
                            <li class='to-label'><label><?php _e('Register Title:','uoc');?></label></li>
                            <li class='to-field'>
								<div class='input-sec'>
									<input class='txtfield' type='text' name='register_title[]' />
								</div>
                            </li>
                        </ul>
                        
                        <ul class='form-elements'>
                            <li class='to-label'><label><?php _e('User Role:','uoc');?></label></li>
                            <li class='to-field'>
								<div class="select-style">
									<select name='register_role[]'>
										<option value="subscriber"><?php _e('Subscriber','uoc');?></option>
										<option value="staff"><?php _e('Staff','uoc');?></option>
										<option value="member"><?php _e('Member','uoc');?></option>
										<option value="instructor"><?php _e('Instructor','uoc');?></option>
                            			<option value="customer"><?php _e('Customer','uoc');?></option>
										<option value="contributor"><?php _e('Contributor','uoc');?></option>
										<option value="author"><?php _e('Author','uoc');?></option>
										<option value="editor"><?php _e('Editor','uoc');?></option>
										<option value="administrator"><?php _e('Administrator','uoc');?></option>
										</select>
								</div>
                            </li>
                        </ul>
                        <ul class='form-elements'>
                            <li class='to-label'><label><?php _e('Register Text','uoc');?></label></li>
                            <li class='to-field'>
							 <div class='input-sec'>
							 	<textarea class='txtfield' data-content-text="cs-shortcode-textarea" name='register_text[]'></textarea>
							</div>
                            </li>
                        </ul>
                        
                    </div>
                <?php
                    
        } 
            else if($_POST['shortcode_element'] == 'tabs'){
                $rand_id = rand(40, 9999999);
            ?>
                    <div class='cs-wrapp-clone cs-shortcode-wrapp add_tabs  cs-pbwp-content'  id="cs_infobox_<?php echo intval( $rand_id);?>">
                                <header>
									<h4><i class='icon-arrows'></i><?php _e('Tab','uoc');?></h4>
									<a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php _e('Remove','uoc');?></a>
								</header>
                                <ul class='form-elements'>
                                    <li class='to-label'><label><?php _e('Active','uoc');?></label></li>
                                    <li class='to-field'> 
                                        <div class="select-style">
											<select name='tab_active[]'>
												<option value="no"><?php _e('No','uoc');?></option>
												<option value="yes"><?php _e('Yes','uoc');?></option>
											</select>
										</div>
                                        <div class='left-info'>
                                          <p><?php _e('You can set the section that is active here by select dropdown','uoc');?></p>
                                        </div>
                                    </li>
                                </ul>
                                <ul class='form-elements'>
                                    <li class='to-label'><label><?php _e('Tab Title','uoc');?></label></li>
                                    <li class='to-field'>
										<div class='input-sec'>
										<input class='txtfield' type='text' name='tab_title[]' />
										</div>
                                    </li>
                                </ul>
                                <ul class='form-elements'>
                                    <li class='to-label'><label><?php _e('Tab Text','uoc');?></label></li>
                                    <li class='to-field'>
										<div class='input-sec'>
										<textarea class='txtfield' data-content-text="cs-shortcode-textarea" name='tab_text[]'></textarea>
										</div>
                                    <div class='left-info'>
                                      <p><?php _e('Enter tab body content here','uoc');?></p>
                                    </div>
                                    </li>
                                </ul>
                            </div>
                <?php    
            }
            else if($_POST['shortcode_element'] == 'testimonials'){
                 $rand_id = rand(324335,9234299);
                ?>
                    <div class='cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content'  id="cs_infobox_<?php echo intval( $rand_id);?>">
                        <header>
							<h4><i class='icon-arrows'></i><?php _e('Testimonial','uoc');?></h4>
							<a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php _e('Remove','uoc');?></a>
						</header>
                        <ul class='form-elements'>
                            <li class='to-label'><label><?php _e('Text','uoc');?></label></li>
                            <li class='to-field'>
								<div class='input-sec'>
									<textarea class='txtfield' data-content-text="cs-shortcode-textarea" name='testimonial_text[]'></textarea>
								</div>
                            </li>
                        </ul>
                        <ul class='form-elements'>
                            <li class='to-label'><label><?php _e('Author','uoc');?></label></li>
                            <li class='to-field'>
								<div class='input-sec'><input class='txtfield' type='text' name='testimonial_author[]' /></div>
							</li>
                        </ul>
                        
                        <ul class='form-elements'>
                            <li class='to-label'>
                            	<label><?php _e('Company','uoc');?></label>
                            </li>
                            <li class='to-field'>
                                <div class='input-sec'>
                                	<input class='txtfield' type='text' name='testimonial_author_company[]' value="" />
                                </div>
                            </li>
                        </ul>
                        
                        
                        
                      
                        <ul class="form-elements">
                          <li class="to-label">
                            <label><?php _e('Background Image','uoc');?></label>
                          </li>
                          <li class="to-field">
                            <input id="testimonial_img<?php echo intval( $rand_id);?>" name="testimonial_img[]" type="hidden" class="" value=""/>
                            <input name="testimonial_img<?php echo intval( $rand_id);?>"  type="button" class="uploadMedia left" value="<?php _e('Browse','uoc');?>"/>
                          </li>
                        </ul>
                        <div class="page-wrap" style="overflow:hidden; display:none" id="testimonial_img<?php echo intval( $rand_id);?>_box" >
                          <div class="gal-active">
                            <div class="dragareamain" style="padding-bottom:0px;">
                              <ul id="gal-sortable">
                                <li class="ui-state-default" id="">
                                  <div class="thumb-secs"> <img src=""  id="testimonial_img<?php echo intval( $rand_id);?>_img" width="100" height="150" alt="" />
                                    <div class="gal-edit-opts"> <a   href="javascript:del_media('testimonial_img<?php echo intval( $rand_id);?>')" class="delete"></a> </div>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                </div>
                <?php    
            } 
            else if($_POST['shortcode_element'] == 'counter'){
                $counter_count = rand(40, 9999999);
                ?>
                <div class='cs-wrapp-clone cs-shortcode-wrapp' id="cs_infobox_<?php echo intval($counter_count);?>">
                        <header><h4><i class='icon-arrows'></i><?php _e('Counter','uoc');?></h4> <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php _e('Remove','uoc');?></a></header>
                        <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Counter Title','uoc');?></label></li>
                            <li class="to-field"><input type="text"  name="counter_title[]"  class="txtfield"  /></li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Type','uoc');?></label></li>
                            <li class="to-field">
                                <div class="select-style">
                                    <select name="counter_style[]" class="dropdown" >
                                        <option value="one" ><?php _e('Counter Style One','uoc');?></option>
                                        <option value="two" ><?php _e('Counter Style Two','uoc');?></option>
                                        <option value="three" ><?php _e('Counter Style Three','uoc');?></option>
                                        <option value="four" ><?php _e('Counter Style Four','uoc');?></option>
                                     </select>
                                 </div>
                            </li>
                        </ul>
                        
                        <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Choose Icon','uoc');?></label></li>
                            <li class="to-field">
                                <div class="select-style">
                                    <select name="counter_icon_type[]" class="dropdown" onchange="cs_counter_image(this.value,'<?php echo esc_js($counter_count)?>','')">
                                        <option <?php if($counter_item->counter_icon_type=="icon")echo "selected";?> value="icon" ><?php _e('Icon','uoc');?></option>
                                        <option <?php if($counter_item->counter_icon_type=="image")echo "selected";?> value="image" ><?php _e('Image','uoc');?></option>
                                     </select>
                                 </div>
                            </li>
                        </ul>
                        
                        <div class="selected_icon_type" id="selected_icon_type<?php echo intval($counter_count)?>">
                             <ul class='form-elements' id="<?php echo intval($counter_count);?>">
                                <li class='to-label'><label><?php _e('Fontawsome Icon','uoc');?></label></li>
                                <li class="to-field">
                                     <?php cs_fontawsome_icons_box('',$counter_count,'counter_icon');?>
                                </li>
                         </ul>
                             <ul class="form-elements">
                                <li class="to-label"><label><?php _e('Icon Color','uoc');?></label></li>
                                <li><input type="text"  name="icon_color[]"  class="bg_color"  /></li>
                            </ul>
                        </div>
                        <div class="selected_image_type" id="selected_image_type<?php echo intval($counter_count)?>" style="display:none">
                               <ul class="form-elements">
                              <li class="to-label">
                                <label><?php _e('Image','uoc');?></label>
                              </li>
                              <li class="to-field">
                                <input id="cs_counter_logo<?php echo intval($counter_count)?>" name="cs_counter_logo[]" type="hidden" class="" value=""/>
                                <input name="cs_counter_logo<?php echo intval($counter_count)?>"  type="button" class="uploadMedia left" value="<?php _e('Browse','uoc');?>"/>
                              </li>
                            </ul>
                            <div class="page-wrap" style="overflow:hidden; display:<?php echo 'none';?>" id="cs_counter_logo<?php echo intval($counter_count)?>_box" >
                              <div class="gal-active">
                                <div class="dragareamain" style="padding-bottom:0px;">
                                  <ul id="gal-sortable">
                                    <li class="ui-state-default" id="">
                                      <div class="thumb-secs"> <img src="<?php echo esc_url($counter_count);?>"  id="cs_counter_logo<?php echo intval($counter_count)?>_img" width="100" height="150"  />
                                        <div class="gal-edit-opts"> <a   href="javascript:del_media('cs_counter_logo<?php echo esc_js($counter_count)?>')" class="delete"></a> </div>
                                      </div>
                                    </li>
                                  </ul>
                                </div>
                              </div>
                            </div>
                        </div>
                        
                        <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Background Color','uoc');?></label></li>
                            <li><input type="text"  name="counter_bg_color[]" class="bg_color" value="" /></li>
                        </ul>
                                        
                        <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Numbers','uoc');?></label></li>
                            <li class="to-field"><input type="text" name="counter_numbers[]" class="txtfield" value="" /></li>
                        </ul>
                          <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Count Text Color','uoc');?></label></li>
                            <li><input type="text" name="counter_text_color[]" class="bg_color" /></li>
                        </ul>
                        
                        <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Link Title','uoc');?></label></li>
                            <li class="to-field"><input type="text" name="counter_icon_linktitle[]" class="txtfield" /></li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Link','uoc');?></label></li>
                            <li class="to-field"><input type="text" name="counter_icon_linkurl[]" class="txtfield"/></li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Button Color','uoc');?></label></li>
                            <li><input type="text"  name="counter_link_bgcolor[]" class="bg_color"  /></li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Text','uoc');?></label></li>
                            <li class="to-field"><textarea type="text" name="counter_text[]" class="txtfield" data-content-text="cs-shortcode-textarea" /><?php echo cs_allow_special_char($counter_text)?></textarea></li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Custom Id','uoc');?></label></li>
                            <li class="to-field">
                                <input type="text" name="coutner_class[]" class="txtfield"  value="" />
                            </li>
                         </ul>
                       
                        <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Animation Class','uoc');?> </label></li>
                            <li class="to-field select-style">
                                <select class="dropdown" name="coutner_animation[]">
                                    <option value=""><?php _e('Select Animation','uoc');?></option>
                                    <?php 
                                    
                                        $animation_array = cs_animation_style();
                                        foreach($animation_array as $animation_key=>$animation_value){
                                            echo '<optgroup label="'.$animation_key.'">';    
                                            foreach($animation_value as $key=>$value){
                                                echo '<option value="'.$key.'" >'.$value.'</option>';
                                            }
                                        }
                                    
                                     ?>
                                  </select>
                            </li>
                        </ul>
                      
                    </div>
                <?php    } 
            else if ($_POST['shortcode_element'] == 'list'){
                            $rand_id = rand(42130, 9999999);
                        ?>
                    <div class='cs-wrapp-clone cs-shortcode-wrapp' id="cs_infobox_<?php echo intval($rand_id);?>">
                            <header>
								<h4><i class='icon-arrows'></i><?php _e('List Item','uoc');?></h4>
								<a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php _e('Remove','uoc');?></a>
							</header>
                            <ul class='form-elements'>
                                <li class='to-label'><label><?php _e('List Item','uoc');?></label></li>
                                <li class='to-field'>
									<div class='input-sec'>
										<input class='txtfield' type='text' name='cs_list_item[]' data-content-text="cs-shortcode-textarea" />
									</div>
                                </li>
                            </ul> 
                            <ul class='form-elements' id="<?php echo intval( $rand_id);?>">
                                <li class='to-label'><label><?php _e('Fontawsome Icon','uoc');?></label></li>
                                <li class="to-field">
                                <?php cs_fontawsome_icons_box('',$rand_id,'cs_list_icon');?>
                            </li>
                         </ul>
                         
                         
                          
                    </div>
                <?php    
            } 
		     else if ($_POST['shortcode_element'] == 'openinghours'){
                            $rand_id = rand(42130, 9999999);
                        ?>
                    <div class='cs-wrapp-clone cs-shortcode-wrapp' id="cs_infobox_<?php echo intval($rand_id);?>">
                            <header>
								<h4><i class='icon-arrows'></i><?php _e('List Item','uoc');?></h4>
								<a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php _e('Remove','uoc');?></a>
							</header>
                            <ul class='form-elements'>
                                <li class='to-label'><label><?php _e('List Item','uoc');?></label></li>
                                <li class='to-field'>
									<div class='input-sec'>
										<input class='txtfield' type='text' name='cs_list_item[]' data-content-text="cs-shortcode-textarea" />
									</div>
                                </li>
                            </ul> 
                            <!--<ul class='form-elements' id="<?php //echo intval( $rand_id);?>">
                                <li class='to-label'><label><?php// _e('Fontawsome Icon','uoc');?></label></li>
                                <li class="to-field">
                                <?php //cs_fontawsome_icons_box('',$rand_id,'cs_list_icon');?>
                            </li>
                         </ul>-->
                          <ul class='form-elements'>
                                <li class='to-label'><label><?php _e('List Schedule','uoc');?></label></li>
                                <li class='to-field'>
									<div class='input-sec'>
										<input class='txtfield' type='text' name='cs_schadule_text[]' data-content-text="cs-shortcode-textarea"  
                                        value=""/>
									</div>
                                </li>
                            </ul>
                         
                         
                          
                    </div>
                <?php    
            } 
			
            else if ($_POST['shortcode_element'] == 'infobox_items'){
                    $rand_id = rand(40, 9999999);
                ?>
                    <div class='cs-wrapp-clone cs-shortcode-wrapp' id="cs_infobox_<?php echo intval( $rand_id);?>">
                            <header><h4><i class='icon-arrows'></i><?php _e('Info box Item(s)','uoc');?></h4> 
                                <a href='#' class='deleteit_node'>
                                    <i class='icon-minus-circle'></i><?php _e('Remove','uoc');?>
                                </a>
                            </header>
                            
                             <ul class='form-elements' id="<?php echo intval( $rand_id);?>">
                                <li class='to-label'><label><?php _e('Fontawsome Icon','uoc');?></label></li>
                                <li class="to-field">
                                   <?php cs_fontawsome_icons_box('',$rand_id,'cs_infobox_list_icon');?>
                                    </li>
                         </ul>
                         <ul class='form-elements'>
                            <li class='to-label'><label><?php _e('Icon Color','uoc');?></label></li>
                            <li class='to-field'>
								<div class='input-sec'>
									<input class='bg_color' type='text' name='cs_infobox_list_color[]' />
								</div>
                            </li>
                        </ul> 
                        <ul class='form-elements'>
                            <li class='to-label'><label><?php _e('Title','uoc');?></label></li>
                            <li class='to-field'>
								<div class='input-sec'>
									<input class='txtfield' type='text' name='cs_infobox_list_title[]' />
								</div>
                            </li>
                        </ul>
                         <ul class='form-elements'>
                            <li class='to-label'><label><?php _e('Short Description','uoc');?></label></li>
                            <li class='to-field'>
								<div class='input-sec'>
									<textarea name='cs_infobox_list_description[]' rows="8" cols="20" data-content-text="cs-shortcode-textarea" /></textarea>
									</div>
                            </li>
                        </ul> 
                       <?php /*?> <ul class='form-elements'>
                            <li class='to-label'><label>Text Color:</label></li>
                            <li class='to-field'> <div class='input-sec'><input class='bg_color' type='text' name='cs_infobox_list_text_color[]' /></div>
                            </li>
                        </ul> <?php */?>
                    </div>
                <?php    
            } 
            else if ($_POST['shortcode_element'] == 'audio'){
                $rand_id = 'clinets_'.rand(40, 9999999);
                ?>
                    <div class='cs-wrapp-clone cs-shortcode-wrapp' id="cs_infobox_<?php echo intval( $rand_id);?>">
                        <header>
							<h4><i class='icon-arrows'></i><?php _e('Album Item(s)','uoc');?></h4>
							<a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php _e('Remove','uoc');?></a>
						</header>
                        <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Track Title','uoc');?></label></li>
                            <li class="to-field">
                                <input type="text" id="cs_album_track_title" name="cs_album_track_title[]" value="Track Title" />
                            </li>
                        </ul>
                        
                        <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Track MP3 Url','uoc');?></label></li>
                            <li class="to-field">
                                <input id="cs_album_track_mp3_url" name="cs_album_track_mp3_url[]" value="" type="text" class="small" />
                                <!--<input id="custom_media_upload" name="cs_album_track_mp3_url" type="button" class="uploadfile left" value="Browse"/>-->
                            </li>
                        </ul>
                        
                </div>
                <?php    
            }
            else if ($_POST['shortcode_element'] == 'clients'){
                $clients_count = 'clinets_'.rand(40, 9999999);
                ?>
                    <div class='cs-wrapp-clone cs-shortcode-wrapp' id="cs_infobox_<?php echo cs_allow_special_char($clients_count);?>">
                        <header>
							<h4><i class='icon-arrows'></i><?php _e('Client','uoc');?></h4>
							<a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php _e('Remove','uoc');?></a>
						</header>
                        <ul class="form-elements">
                          <li class="to-label">
                            <label><?php _e('Title','uoc');?></label>
                          </li>
                          <li class="to-field">
                            <input type="text" id="cs_client_title" class="" name="cs_client_title[]" value="" />
                          </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Background Color','uoc');?></label></li>
                            <li class="to-field">
                                <input type="text" id="cs_bg_color" class="bg_color" name="cs_bg_color[]" value="" />
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Website Url','uoc');?></label></li>
                            <li class="to-field">
                                <div class="input-sec"> <input type="text" id="cs_website_url" class="" name="cs_website_url[]" value="" /></div>
                                <div class="left-info"><p>e.g. http://yourdomain.com/</p></div>
                            </li>
                        </ul>
                        <ul class="form-elements">
                          <li class="to-label">
                            <label><?php _e('Client Logo','uoc');?></label>
                          </li>
                          <li class="to-field">
                            <input id="cs_client_logo<?php echo cs_allow_special_char($clients_count)?>" name="cs_client_logo[]" type="hidden" class="" value=""/>
                            <input name="cs_client_logo<?php echo cs_allow_special_char($clients_count)?>"  type="button" class="uploadMedia left" value="<?php _e('Browse','uoc');?>"/>
                          </li>
                        </ul>
                        <div class="page-wrap" style="overflow:hidden; display:<?php echo 'none';?>" id="cs_client_logo<?php echo cs_allow_special_char($clients_count)?>_box" >
                          <div class="gal-active">
                            <div class="dragareamain" style="padding-bottom:0px;">
                              <ul id="gal-sortable">
                                <li class="ui-state-default" id="">
                                  <div class="thumb-secs"> <img src="<?php echo esc_url($clients_count);?>"  id="cs_client_logo<?php echo cs_allow_special_char($clients_count);?>_img" width="100" height="150"  />
                                    <div class="gal-edit-opts"> <a   href="javascript:del_media('cs_client_logo<?php echo cs_allow_special_char($clients_count)?>')" class="delete"></a> </div>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                </div>
                <?php    
            }
			else if ($_POST['shortcode_element'] == 'multiple_services'){
                $multiple_services_count = 'multiple_services_'.rand(455345, 23454390);
                ?>
                    <div class='cs-wrapp-clone cs-shortcode-wrapp' id="cs_infobox_<?php echo cs_allow_special_char($multiple_services_count);?>">
                        <header>
							<h4><i class='icon-arrows'></i><?php _e('Multiple Service','uoc');?></h4>
							<a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php _e('Remove','uoc');?></a>
						</header>
                        <ul class="form-elements">
                          <li class="to-label">
                            <label><?php _e('Title','uoc');?></label>
                          </li>
                          <li class="to-field">
                            <input type="text" id="cs_multiple_service_title" class="" name="cs_multiple_service_title[]" value="" />
                          </li>
                        </ul>
                        <ul class="form-elements">
                          <li class="to-label">
                            <label><?php _e('Title Color','uoc');?></label>
                          </li>
                          <li class="to-field">
                            <input type="text" id="cs_title_color" class="bg_color" name="cs_title_color[]" value="" />
                          </li>
                        </ul>
                        <ul class="form-elements">
                          <li class="to-label">
                            <label><?php _e('Text Color','uoc');?></label>
                          </li>
                          <li class="to-field">
                            <input type="text" id="cs_text_color" class="bg_color" name="cs_text_color[]" value="" />
                          </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Background Color','uoc');?></label></li>
                            <li class="to-field">
                                <input type="text" id="cs_bg_color" class="bg_color" name="cs_bg_color[]" value="" />
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Website Url','uoc');?></label></li>
                            <li class="to-field">
                                <div class="input-sec"> <input type="text" id="cs_website_url" class="" name="cs_website_url[]" value="" /></div>
                                <div class="left-info"><p>e.g. http://yourdomain.com/</p></div>
                            </li>
                        </ul>
                        <ul class="form-elements">
                          <li class="to-label">
                            <label><?php _e('Multiple Service Logo','uoc');?></label>
                          </li>
                          <li class="to-field">
                            <input id="cs_multiple_service_logo<?php echo cs_allow_special_char($multiple_services_count)?>" name="cs_multiple_service_logo[]" type="hidden" class="" value=""/>
                            <input name="cs_multiple_service_logo<?php echo cs_allow_special_char($multiple_services_count)?>"  type="button" class="uploadMedia left" value="<?php _e('Browse','uoc');?>"/>
                          </li>
                        </ul>
                        <div class="page-wrap" style="overflow:hidden; display:<?php echo 'none';?>" id="cs_multiple_service_logo<?php echo cs_allow_special_char($multiple_services_count)?>_box" >
                          <div class="gal-active">
                            <div class="dragareamain" style="padding-bottom:0px;">
                              <ul id="gal-sortable">
                                <li class="ui-state-default" id="">
                                  <div class="thumb-secs"> <img src="<?php echo esc_url($multiple_services_count);?>"  id="cs_multiple_service_logo<?php echo cs_allow_special_char($multiple_services_count);?>_img" width="100" height="150"  />
                                    <div class="gal-edit-opts"> <a   href="javascript:del_media('cs_multiple_service_logo<?php echo cs_allow_special_char($multiple_services_count)?>')" class="delete"></a> </div>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <ul class='form-elements'>
                          <li class='to-label'>
                            <label><?php _e('Text','uoc');?></label>
                          </li>
                          <li class='to-field'>
                            <div class='input-sec'>
                              <textarea class='txtfield' data-content-text="cs-shortcode-textarea" name='cs_multiple_service_text[]'></textarea>
                              <div class='left-info'>
                                <p><?php _e('Enter your content','uoc');?></p>
                              </div>
                            </div>
                          </li>
                        </ul>
                        
                </div>
                <?php    
            }
			else if ($_POST['shortcode_element'] == 'facilities'){
                $facilities_count = 'facilities_'.rand(455345, 23454390);
                ?>
                    <div class='cs-wrapp-clone cs-shortcode-wrapp' id="cs_infobox_<?php echo cs_allow_special_char($facilities_count);?>">
                        <header>
							<h4><i class='icon-arrows'></i><?php _e('Facilities','uoc');?></h4>
							<a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php _e('Remove','uoc');?></a>
						</header>
                        <ul class="form-elements">
                          <li class="to-label">
                            <label><?php _e('Title','uoc');?></label>
                          </li>
                          <li class="to-field">
                            <input type="text" id="title" class="" name="title[]" value="" />
                          </li>
                        </ul>
                        <ul class="form-elements">
                          <li class="to-label">
                            <label><?php _e('Title Color','uoc');?></label>
                          </li>
                          <li class="to-field">
                            <input type="text" id="title_color" class="bg_color" name="title_color[]" value="" />
                          </li>
                        </ul>
                        <ul class="form-elements">
                          <li class="to-label">
                            <label><?php _e('Text Color','uoc');?></label>
                          </li>
                          <li class="to-field">
                            <input type="text" id="text_color" class="bg_color" name="text_color[]" value="" />
                          </li>
                        </ul>
                        <ul class="form-elements">
                          <li class="to-label">
                            <label><?php _e('Image','uoc');?></label>
                          </li>
                          <li class="to-field">
                            <input id="image<?php echo cs_allow_special_char($facilities_count)?>" name="image[]" type="hidden" class="" value=""/>
                            <input name="image<?php echo cs_allow_special_char($facilities_count)?>"  type="button" class="uploadMedia left" value="<?php _e('Browse','uoc');?>"/>
                          </li>
                        </ul>
                        <div class="page-wrap" style="overflow:hidden; display:<?php echo 'none';?>" id="image<?php echo cs_allow_special_char($facilities_count)?>_box" >
                          <div class="gal-active">
                            <div class="dragareamain" style="padding-bottom:0px;">
                              <ul id="gal-sortable">
                                <li class="ui-state-default" id="">
                                  <div class="thumb-secs"> <img src="<?php echo esc_url($facilities_count);?>"  id="image<?php echo cs_allow_special_char($facilities_count);?>_img" width="100" height="150"  />
                                    <div class="gal-edit-opts"> <a   href="javascript:del_media('image<?php echo cs_allow_special_char($facilities_count)?>')" class="delete"></a> </div>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <ul class='form-elements'>
                          <li class='to-label'>
                            <label><?php _e('Text','uoc');?></label>
                          </li>
                          <li class='to-field'>
                            <div class='input-sec'>
                              <textarea class='txtfield' data-content-text="cs-shortcode-textarea" name='facilities_text[]'></textarea>
                              <div class='left-info'>
                                <p><?php _e('Enter your content','uoc');?></p>
                              </div>
                            </div>
                          </li>
                        </ul>
                </div>
                <?php    
            } else if ($_POST['shortcode_element'] == 'progressbars'){
                $rand_id = rand(40, 9999999);
                ?>
                    <div class='cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content' id="cs_infobox_<?php echo intval( $rand_id);?>">
                        <header>
							<h4><i class='icon-arrows'></i><?php _e('Progress bars','uoc');?></h4>
							<a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php _e('Remove','uoc');?></a>
						</header>
                        <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Progress Bars Title','uoc');?></label></li>
                            <li class="to-field">
                                <input type="text" name="progressbars_title[]" class="txtfield" value="" />
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label><?php _e('Skill in percentage','uoc');?></label></li>
                            <li class="to-field">
                                <div class="cs-drag-slider" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value=""></div>
                                <input  class="cs-range-input"  name="progressbars_percentage[]" type="text" value=""   />
                                <p><?php _e('Set the Skill In %','uoc');?></p>
                            </li>
                        </ul>
                        <ul class="form-elements">
                          <li class="to-label">
                            <label><?php _e('Progress Bars Color','uoc');?></label>
                          </li>
            
                          <li class="to-field">
                            <input type="text" name="progressbars_color[]" class="bg_color" value="" />
                          </li>
                       </ul> 
                </div>
                <?php    
            }
            else if ($_POST['shortcode_element'] == 'offerslider'){
                $offer_count = 'offer_'.rand(40, 9999999);
                ?>
                    <div class='cs-wrapp-clone cs-shortcode-wrapp' id="cs_infobox_<?php echo intval($offer_count);?>">
                        <header>
							<h4><i class='icon-arrows'></i><?php _e('Offer Slider Item','uoc');?></h4>
							<a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php _e('Remove','uoc');?></a>
						</header>
                        <ul class="form-elements">
                          <li class="to-label">
                            <label><?php _e('Image','uoc');?></label>
                          </li>
                          <li class="to-field">
                            <input id="cs_slider_image<?php echo intval($offer_count)?>" name="cs_slider_image[]" type="hidden" class="" value=""/>
                            <input name="cs_slider_image<?php echo intval($offer_count)?>"  type="button" class="uploadMedia left" value="<?php _e('Browse','uoc');?>"/>
                          </li>
                        </ul>
                        <div class="page-wrap" style="overflow:hidden; display:<?php echo 'none';?>" id="cs_slider_image<?php echo intval($offer_count) ?>_box"  >
                          <div class="gal-active">
                            <div class="dragareamain" style="padding-bottom:0px;">
                              <ul id="gal-sortable">
                                <li class="ui-state-default" id="">
                                  <div class="thumb-secs">
								   <img src=""  id="cs_slider_image<?php echo intval($offer_count)?>_img" width="100" height="150" alt=""  />
                                    <div class="gal-edit-opts">
									 <a href="javascript:del_media('cs_slider_image<?php echo esc_js($offer_count) ?>')" class="delete"></a>
									 </div>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <ul class="form-elements">
                          <li class="to-label">
                            <label><?php _e('Title','uoc');?></label>
                          </li>
                          <li class="to-field">
                            <input type="text" name="cs_slider_title[]" class="txtfield" value="" />
                          </li>
                        </ul>
                        <ul class="form-elements">
                          <li class="to-label">
                            <label><?php _e('Contents','uoc');?></label>
                          </li>
                          <li class="to-field">
                            <textarea name="cs_slider_contents[]" data-content-text="cs-shortcode-textarea"></textarea>
                          </li>
                        </ul>
                        <ul class="form-elements">
                          <li class="to-label">
                            <label><?php _e('Link','uoc');?></label>
                          </li>
                          <li class="to-field">
                            <input type="text" name="cs_readmore_link[]" class="txtfield" value="" />
                          </li>
                        </ul>
                        <ul class="form-elements">
                          <li class="to-label">
                            <label><?php _e('Link Title','uoc');?></label>
                          </li>
                          <li class="to-field">
                            <input type="text" name="cs_offerslider_link_title[]" class="txtfield" value="" />
                          </li>
                        </ul>
                </div>
                <?php    
            }  
        }
        exit;
    }
    add_action('wp_ajax_cs_shortcode_element_ajax_call', 'cs_shortcode_element_ajax_call');
}

/*
 *
 *@Shortcode Name : Post Attachment
 *@retrun
 *
 */
function cs_post_attachments( $gallery_meta_form ){
	global $post;
	$galleryConter = rand(40, 9999999);
	
    ?>        
        <div class="to-social-network">
            <div class="gal-active" style="padding-left:0px !important">
                <div class="clear"></div>
                <div class="dragareamain">
                <div class="placehoder"><?php _e('Gallery is Empty. Please Select Media','uoc');?> <img src="<?php echo esc_url(get_template_directory_uri().'/include/assets/images/bg-arrowdown.png');?>" alt="" />
                </div>
                <ul id="gal-sortable" class="gal-sortable-<?php echo esc_attr($gallery_meta_form);?>">
                    <?php 
                        global $cs_node, $cs_counter,$post;
                        $cs_post_type	= $post->post_type;
                        if ( $gallery_meta_form == 'gallery_slider_meta_form'){
                            $type    = 'gallery_slider';
                        } else {
                            $type    = 'gallery';
                        }
						
                        $cs_counter_gal = 0;
                        $slider_data = get_post_meta($post->ID, 'cs_'.$type, true);
						
                        if(isset($slider_data) && count($slider_data)>0 && !empty($slider_data) ){
                            foreach ( $slider_data as $cs_node ){
                                $cs_counter_gal++;
                                $cs_counter = $post->ID.$cs_counter_gal;
                                if ($type == 'gallery_slider'){
									cs_slider_clone();
                                } else {
                                    cs_gallery_clone();
                                }
                            }
                        }
                    ?>
                </ul>
                </div>
            </div>
            <div class="to-social-list">
                <div class="soc-head">
                    <h5><?php _e('Select Media','uoc');?></h5>
                    <div class="right">
                        <?php if ( $gallery_meta_form == 'gallery_slider_meta_form'){ ?>
                             <input type="button" class="button reload" value="Reload" onclick="refresh_media_slider(<?php echo esc_attr($galleryConter);?>)" />
                        <?php } else { ?>
                            <input type="button" class="button reload" value="Reload" onclick="refresh_media(<?php echo esc_attr($galleryConter);?>)" />
                        <?php } ?>
                        <input id="cs_log" name="cs_logo" type="button" class="uploadfile button" value="Upload Media" />
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
                    <script type="text/javascript">
                        function show_next(page_id, total_pages){
                            //var dataString = 'action=media_pagination&id='+id+'&func='+func+'&page_id='+page_id+'&total_pages='+total_pages;
                            var dataString = 'action=media_pagination&page_id='+page_id+'&total_pages='+total_pages;
                            /*if (func == 'slider') {
                                var    pagination    = 'pagination_slider';
                            } else {
                                var    pagination    = 'pagination_clone';
                            }*/
                            jQuery("#pagination").html("<img src='<?php echo esc_js(esc_url(get_template_directory_uri().'/include/assets/images/ajax_loading.gif'))?>' />");
                            jQuery.ajax({
                                type:'POST', 
                                url: "<?php echo esc_js(esc_url(admin_url('admin-ajax.php')));?>",
                                data: dataString,
                                success: function(response) {
                                    jQuery("#pagination").html(response);
                                }
                            });
                        }
                        function slider_show_next(page_id, total_pages){
                            //var dataString = 'action=media_pagination&id='+id+'&func='+func+'&page_id='+page_id+'&total_pages='+total_pages;
                            var dataString = 'action=cs_slider_media_pagination&page_id='+page_id+'&total_pages='+total_pages;
                            /*if (func == 'slider') {
                                var    pagination    = 'pagination_slider';
                            } else {
                                var    pagination    = 'pagination_clone';
                            }*/
                            jQuery(".pagination_slider").html("<img src='<?php echo esc_js(esc_url(get_template_directory_uri()))?>/include/assets/images/ajax_loading.gif' />");
                            jQuery.ajax({
                                type:'POST', 
                                url: "<?php echo esc_js(esc_url(admin_url('admin-ajax.php')));?>",
                                data: dataString,
                                success: function(response) {
                                    jQuery(".pagination_slider").html(response);
                                }
                            });
                        }
                        function refresh_media(id){
                             var dataString = 'action=media_pagination&id='+id+'&func=slider';
                            jQuery(".pagination_clone").html("<img src='<?php echo esc_js(esc_url(get_template_directory_uri()))?>/include/assets/images/ajax_loading.gif' />");
                            jQuery.ajax({
                                type:'POST', 
                                url: "<?php echo esc_js(esc_url(admin_url('admin-ajax.php')));?>",
                                data: dataString,
                                success: function(response) {
                                    jQuery(".pagination_clone").html(response);
                                }
                            });
                        }
                        
                        function refresh_media_slider(id){
                            var dataString = 'action=cs_slider_media_pagination&id='+id+'&func=slider';
                            jQuery(".pagination_slider").html("<img src='<?php echo esc_js(esc_url(get_template_directory_uri()))?>/include/assets/images/ajax_loading.gif' />");
                            jQuery.ajax({
                                type:'POST', 
                                url: "<?php echo esc_js(esc_url(admin_url('admin-ajax.php')));?>",
                                data: dataString,
                                success: function(response) {
                                    jQuery(".pagination_slider").html(response);
                                }
                            });
                        }
                     </script>
                    <script>
                        jQuery(document).ready(function($) {
                            $(".gal-sortable-<?php echo esc_js($galleryConter);?>").sortable({
                                cancel:'li div.poped-up',
                            });
                            //$(this).append("#gal-sortable").clone() ;
                            });
                            var counter = 0;
                            var count_items = <?php echo esc_js($cs_counter_gal)?>;
                            if ( count_items > 0 ) {
                                jQuery(".dragareamain") .addClass("noborder");    
                            }

                            function clone(path,id){
                                counter = counter + 1;
                                var cls = 'gal-sortable-gallery_meta_form';
                                var dataString = 'path='+path+'&counter='+counter+'&action=gallery_clone';
                                jQuery("."+cls).append("<li id='loading'><img src='<?php echo esc_js(esc_url(get_template_directory_uri()))?>/include/assets/images/ajax_loading.gif' /></li>");
                                jQuery.ajax({
                                    type:'POST', 
                                    url: "<?php echo esc_js(esc_url(admin_url('admin-ajax.php')));?>",
                                    data: dataString,
                                    success: function(response) {
                                        jQuery("#loading").remove();
                                        jQuery("."+cls).append(response);
                                        count_items = jQuery("."+cls +' '+"li") .length;
                                            if ( count_items > 0 ) {
                                                jQuery(".dragareamain") .addClass("noborder");    
                                            }
                                    }
                                });
                            }
                            
                            function slider(path,id){
                                counter = counter + 1;
                                var cls = 'gal-sortable-gallery_slider_meta_form';
                                var dataString = 'path='+path+'&counter='+counter+'&action=slider_clone';
                                jQuery("."+cls).append("<li id='loading'><img src='<?php echo esc_js(esc_url(get_template_directory_uri()))?>/include/assets/images/ajax_loading.gif' /></li>");
                                jQuery.ajax({
                                    type:'POST', 
                                    url: "<?php echo esc_js(esc_url(admin_url('admin-ajax.php')));?>",
                                    data: dataString,
                                    success: function(response) {
                                        jQuery("#loading").remove();
                                        jQuery("."+cls).append(response);
                                        count_items = jQuery("."+cls +' '+"li") .length;
                                            if ( count_items > 0 ) {
                                                jQuery(".dragareamain") .addClass("noborder");    
                                            }
                                    }
                                });
                            }
							
							function del_this(div,id){
                                jQuery("#"+div+' '+"#"+id).remove();
                                count_items = jQuery("#gal-sortable li") .length;
								if ( count_items == 0 ) {
									jQuery(".dragareamain") .removeClass("noborder");    
								}
                            }
                    </script>
                     <?php if ( $gallery_meta_form == 'gallery_slider_meta_form'){ ?>
                         <div id="pagination" class="pagination_slider"><?php cs_slider_media_pagination($gallery_meta_form,'slider');?></div>
                     <?php } else { ?>
                         <div id="pagination" class="pagination_clone"><?php media_pagination($gallery_meta_form,'clone');?></div>
                     <?php    
                     }
					 ?>
                   
                 <input type="hidden" name="<?php echo esc_attr($gallery_meta_form);?>" value="1" />
                <div class="clear"></div>
            </div>
         </div>
    <?php    
}


/*
 *
 *@Shortcode Name : Flex Slider
 *@retrun
 *
 */
if ( ! function_exists( 'cs_post_flex_slider' ) ) {

    function cs_post_flex_slider($width,$height,$postid,$view){
        global $post,$cs_node,$cs_theme_options,$cs_counter_node;
        $cs_post_counter = rand(40, 9999999);
        $cs_counter_node++;
        
		if ( $view == 'post-list' ){
            $viewMeta    = 'cs_post_list_gallery';  
        } else {
            $viewMeta    = $view;
        }
        
		$cs_meta_slider_options = get_post_meta("$postid", $viewMeta, true); 
        $totaImages 		= '';
       
        
		?>
        <!-- Flex Slider -->
        <div id="flexslider<?php echo esc_attr($cs_post_counter); ?>" class="flexslider">
            <div class="flex-viewport">
                <ul class="slides">
                    <?php 
                        $cs_counter = 1;
                        
                        if ( $view == 'post' ){
							$sliderData    = get_post_meta($post->ID,'cs_post_detail_gallery',true);
							$sliderData	   = explode(',',$sliderData);
                            $totaImages    = count($sliderData);
                        } else if ( $view == 'post-list' ){
                            $sliderData    = get_post_meta($post->ID,'cs_post_list_gallery',true);
							$sliderData	   = explode(',',$sliderData);
                            $totaImages    = count($sliderData);
                        } else {
                            $sliderData    = get_post_meta($post->ID,'cs_post_list_gallery',true);
							$sliderData	   = explode(',',$sliderData);
                            $totaImages    = count($sliderData);
                        }
						
                        foreach ( $sliderData as $as_node ){
                            $image_url = cs_attachment_image_src((int)$as_node,$width,$height); 
                            echo '<li>
                                    <figure>
                                        <img src="'.esc_url($image_url).'" alt="image">';
                                        if(isset( $as_node['title'] ) && $as_node['title'] != '' ){ ?>         
                                            <figcaption>
                                                <div class="container">
                                                    <?php if($as_node['title'] <> ''){?>
                                                        <h2 class="colr">
                                                            <?php 
                                                                if($as_node['link_url'] <> ''){ 
                                                                     echo '<a href="'.esc_url($as_node['link_url']).'" target="_self">' . esc_attr($as_node['title']) . '</a>';
                            
                                                                } else {
                            
                                                                    echo esc_attr($as_node['title']);
                                                                }
                                                            ?>
                                                        </h2>
                                                    <?php }
                                                    ?>
                                                </div>
                                           </figcaption>
                              <?php }?>

                            </figure>
                        </li>
                    <?php 
                    $cs_counter++;
                    }
                ?>
              </ul>
          </div>
        </div>
        <?php cs_enqueue_flexslider_script(); ?>

        <script type="text/javascript">
            jQuery(window).load(function(){
                var speed = '6000'; 
                var slidespeed ='500';
                jQuery('#flexslider<?php echo esc_js($cs_post_counter); ?>.flexslider').flexslider({
                    animation: "slide", // fade
                    slideshow: true,
                    slideshowSpeed:speed,
                    animationSpeed:slidespeed,
                    prevText:"<em class='icon-arrow-left9'></em>",
                    nextText:"<em class='icon-arrow-right9'></em>",
                    start: function(slider) {
                        jQuery('.flexslider').fadeIn();
                    }
                });
            });
        </script>
    <?php
    }
}