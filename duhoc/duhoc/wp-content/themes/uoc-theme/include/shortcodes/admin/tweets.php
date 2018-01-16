<?php
/*
 *
 *@Shortcode Name : Tweets
 *@retrun
 *
 */
if ( ! function_exists( 'cs_pb_tweets' ) ) {
    function cs_pb_tweets($die = 0){
        global $cs_node, $post;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $counter = $_POST['counter'];
        $cs_counter = $_POST['counter'];
        if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes ($shortcode_element_id);
            $PREFIX = CS_SC_TWEETS;
            $parseObject     = new ShortcodeParse();
            $output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
        }
        $defaults = array('cs_tweets_section_title' => '','cs_tweets_user_name' => 'default','cs_no_of_tweets' => '','cs_tweets_color'=>'','cs_tweets_class' => '','cs_tweets_bg_color'=>'');
        if(isset($output['0']['atts']))
            $atts = $output['0']['atts'];
        else 
            $atts = array();
        $tweets_element_size = '25';
        foreach($defaults as $key=>$values){
            if(isset($atts[$key]))
                $$key = $atts[$key];
            else 
                $$key =$values;
         }
        $name = 'cs_pb_tweets';
        $coloumn_class = 'column_'.$tweets_element_size;
        if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
    ?>
<div id="<?php echo esc_attr($name.$cs_counter)?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="blog" data="<?php echo cs_element_size_data_array_index($tweets_element_size)?>" >
        <?php cs_element_setting($name,$cs_counter,$tweets_element_size,'','twitter');?>
            <div class="cs-wrapp-class-<?php echo esc_attr($cs_counter)?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo esc_attr($name.$cs_counter)?>" data-shortcode-template="[<?php echo esc_attr( CS_SC_TWEETS ) ;?> {{attributes}}]" style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php _e('Edit Twitter Options','uoc');?></h5>
                    <a href="javascript:removeoverlay('<?php echo esc_attr($name.$cs_counter)?>','<?php echo esc_attr($filter_element);?>')" class="cs-btnclose"><i class="icon-times"></i></a>
                </div>
                <div class="cs-pbwp-content">
                     <div class="cs-wrapp-clone cs-shortcode-wrapp">
                       <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){cs_shortcode_element_size();}?>                   
                            <ul class="form-elements">
                              <li class="to-label">
                                <label><?php _e('User Name','uoc');?></label>
                              </li>
                              <li class="to-field">
                                <input type="text" name="cs_tweets_user_name[]" value="<?php echo esc_attr($cs_tweets_user_name);?>" />
                              </li>
                            </ul>
                            <ul class="form-elements">
                                <li class="to-label"><label><?php _e('Text Color','uoc');?></label></li>
                                <li class="to-field">
                                    <input type="text" name="cs_tweets_color[]" class="bg_color"  value="<?php echo esc_attr($cs_tweets_color)?>" />
                                </li>
                            </ul>
                             <ul class="form-elements">
                                <li class="to-label"><label><?php _e('Background Color','uoc');?></label></li>
                                <li class="to-field">
                                    <input type="text" name="cs_tweets_bg_color[]" class="bg_color"  value="<?php echo esc_attr($cs_tweets_bg_color)?>" />
                                </li>
                            </ul>
                            <ul class="form-elements">
                              <li class="to-label">
                                <label><?php _e('No of Tweets','uoc');?></label>
                              </li>
                              <li class="to-field">
                                <input type="text" name="cs_no_of_tweets[]" value="<?php echo (int)$cs_no_of_tweets;?>" />
                              </li>
                            </ul>
                             
                      </div>
                      <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
                            <ul class="form-elements insert-bg">
                                <li class="to-field">
                                    <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js(str_replace('cs_pb_','',$name));?>','<?php echo esc_js($name.$cs_counter)?>','<?php echo esc_js($filter_element);?>')" ><?php _e('Insert','uoc');?></a>
                                </li>
                            </ul>
                            <div id="results-shortocde"></div>
                        <?php } else {?>
                            <ul class="form-elements noborder">
                                <li class="to-label"></li>
                                <li class="to-field">
                                    <input type="hidden" name="cs_orderby[]" value="tweets" />
                                    <input type="button" value="<?php _e('Save','uoc');?>" style="margin-right:10px;" onclick="javascript:_removerlay(jQuery(this))" />
                                </li>
                            </ul>
                        <?php }?>
                </div>
           </div>
        </div>
<?php
            if ( $die <> 1 ) die();
        }
        add_action('wp_ajax_cs_pb_tweets', 'cs_pb_tweets');
 }
?>