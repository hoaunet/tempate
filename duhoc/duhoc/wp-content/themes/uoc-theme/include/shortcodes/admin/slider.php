<?php
/** 
 * @Offer Slider html form for page builder start
 */
if ( ! function_exists( 'cs_pb_offerslider' ) ) {
    function cs_pb_offerslider($die = 0){
        global $cs_node, $post;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $cs_counter = $_POST['counter'];
         if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes ($shortcode_element_id);
         
			 $PREFIX = CS_SC_OFFERSLIDER.'|'.CS_SC_OFFERITEM;
            $parseObject     = new ShortcodeParse();
            $output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
        }
        $defaults = array(
		'column_size'=>'1/1',
		'cs_offerslider_section_title' => '',
		'cs_offerslider_class' => '',
		'cs_offerslider_animation' => ''
		);
        if(isset($output['0']['atts']))
            $atts = $output['0']['atts'];
        else 
            $atts = array();
            
        if(isset($output['0']['content']))
            $atts_content = $output['0']['content'];
        else 
            $atts_content = array();
            
        if(is_array($atts_content))
                $offerslider_num = count($atts_content);
                    
        $offerslider_element_size = '50';
        foreach($defaults as $key=>$values){
            if(isset($atts[$key]))
                $$key = $atts[$key];
            else 
                $$key =$values;
         }
        
        $name = 'cs_pb_offerslider';
        $coloumn_class = 'column_'.$offerslider_element_size;
        
        if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
    ?>
<div id="<?php echo esc_attr($name.$cs_counter);?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="offerslider" data="<?php echo cs_element_size_data_array_index($offerslider_element_size)?>" >
            <?php cs_element_setting($name,$cs_counter,$offerslider_element_size, '', 'trophy',$type='');?>
            <div class="cs-wrapp-class-<?php echo esc_attr($cs_counter)?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo esc_attr($name.$cs_counter);?>" style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php _e('Edit Offer Slider Options','uoc');?></h5>
                    <a href="javascript:removeoverlay('<?php echo esc_js($name.$cs_counter);?>','<?php echo esc_js($filter_element);?>')" class="cs-btnclose"><i class="icon-times"></i></a>
                </div>
                    <div class="cs-clone-append cs-pbwp-content">
                    <div class="cs-wrapp-tab-box">
                            <div id="shortcode-item-<?php echo esc_attr($cs_counter);?>" data-shortcode-template="{{child_shortcode}} [/<?php echo esc_attr( CS_SC_OFFERSLIDER );?>]" data-shortcode-child-template="[<?php echo esc_attr( CS_SC_OFFERITEM );?> {{attributes}}] {{content}} [/<?php echo esc_attr( CS_SC_OFFERITEM );?>]">
                                <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true" data-template="[<?php echo esc_attr( CS_SC_OFFERSLIDER );?> {{attributes}}]">
                                <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
                                    ?>
                                    <ul class="form-elements">
                                        <li class="to-label"><label><?php _e('Size','uoc');?></label></li>
                                        <li class="to-field select-style">
                                            <select class="column_size" id="column_size" name="column_size[]">
                                                <option value="1/1" <?php if($column_size == '1/1'){echo 'selected="selected"';}?>><?php _e('Full width','uoc');?></option>
                                                <option value="1/2" <?php if($column_size == '1/2'){echo 'selected="selected"';}?>><?php _e('One half','uoc');?></option>
                                                <option value="2/3" <?php if($column_size == '2/3'){echo 'selected="selected"';}?>><?php _e('Two third','uoc');?></option>
                                                <option value="3/4" <?php if($column_size == '3/4'){echo 'selected="selected"';}?>><?php _e('Three fourth','uoc');?></option>
                                            </select>
                                            <p><?php _e('Select column width. This width will be calculated depend page width','uoc');?></p>
                                        </li>                  
                                    </ul>
                                    <?php
                                    }
                                    ?>
                               <ul class="form-elements">
                                  <li class="to-label">
                                    <label><?php _e('Section Title','uoc');?></label>
                                  </li>
                                  <li class="to-field">
                                    <input  name="cs_offerslider_section_title[]" type="text"  value="<?php echo cs_allow_special_char($cs_offerslider_section_title);?>"   />
                                    <p><?php _e('This is used for the one page navigation, to identify the section below. Give a title','uoc');?>  </p>
                                  </li>
                                </ul>
                               <?php  
                                   if ( function_exists( 'cs_shortcode_custom_dynamic_classes' ) ) {
                                    cs_shortcode_custom_dynamic_classes($cs_offerslider_class,$cs_offerslider_animation,'',CS_SC_OFFERSLIDER);
                                }
                                ?>
                            </div>
                            <?php
                            if ( isset($offerslider_num) && $offerslider_num <> '' && isset($atts_content) && is_array($atts_content)){
                            
                                foreach ( $atts_content as $offerslider){
                                    
                                    $rand_string = $cs_counter.''.cs_generate_random_string(3);
                                    $offerslider_text = $offerslider['content'];
                                    $defaults = array( 'cs_slider_image' => '','cs_slider_title' => '','cs_slider_contents' => '','cs_readmore_link' => '','cs_offerslider_link_title' => '');
                                    
                                    foreach($defaults as $key=>$values){
                                        if(isset($offerslider['atts'][$key]))
                                            $$key = $offerslider['atts'][$key];
                                        else 
                                            $$key =$values;
                                     }
                                    ?>
                                    <div class='cs-wrapp-clone cs-shortcode-wrapp'  id="cs_infobox_<?php echo esc_attr($rand_string);;?>">
                                        <header><h4><i class='icon-arrows'></i><?php _e('Testimonial','uoc');?></h4> <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php _e('Remove','uoc');?></a></header>
                                        <ul class="form-elements">
                                          <li class="to-label">
                                            <label><?php _e('Image','uoc');?></label>
                                          </li>
                                          <li class="to-field">
                                            <input id="cs_slider_image<?php echo esc_attr($rand_string)?>" name="cs_slider_image[]" type="hidden" class="" value="<?php echo esc_url($cs_slider_image);?>"/>
                                            <input name="cs_slider_image<?php echo esc_attr($rand_string)?>"  type="button" class="uploadMedia left" value="<?php _e('Browse','uoc');?>"/>
                                          </li>
                                        </ul>
                                        <div class="page-wrap" style="overflow:hidden; display:<?php echo esc_url($cs_slider_image) && trim($cs_slider_image) !='' ? 'inline' : 'none';?>" id="cs_slider_image<?php echo esc_attr($cs_counter);?>_box" >
                                          <div class="gal-active">
                                            <div class="dragareamain" style="padding-bottom:0px;">
                                              <ul id="gal-sortable">
                                                <li class="ui-state-default" id="">
                                                  <div class="thumb-secs"> <img src="<?php echo esc_url($cs_slider_image);?>"  id="cs_slider_image<?php echo esc_attr($rand_string);?>_img" width="100" height="150"  />
                                                    <div class="gal-edit-opts"> <a   href="javascript:del_media('cs_slider_image<?php echo esc_attr($rand_string);?>')" class="delete"></a> </div>
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
                                            <input type="text" name="cs_slider_title[]" class="txtfield" value="<?php echo cs_allow_special_char($cs_slider_title);?>" />
                                          </li>
                                        </ul>
                                        <ul class="form-elements">
                                          <li class="to-label">
                                            <label><?php _e('Contents','uoc');?></label>
                                          </li>
                                          <li class="to-field">
                                            <textarea name="cs_slider_contents[]" data-content-text="cs-shortcode-textarea"><?php echo esc_textarea($offerslider_text);?></textarea>
                                            <p><?php _e('Enter your content','uoc');?></p>
                                          </li>
                                        </ul>
                                        <ul class="form-elements">
                                          <li class="to-label">
                                            <label><?php _e('Read More Link','uoc');?></label>
                                          </li>
                                          <li class="to-field">
                                            <input type="text" name="cs_readmore_link[]" class="txtfield" value="<?php echo esc_attr($cs_readmore_link)?>" />
                                          </li>
                                        </ul>
                                        <ul class="form-elements">
                                          <li class="to-label">
                                            <label><?php _e('Link Title','uoc');?></label>
                                          </li>
                                          <li class="to-field">
                                            <input type="text" name="cs_offerslider_link_title[]" class="txtfield" value="<?php echo cs_allow_special_char($cs_offerslider_link_title);?>" />
                                            <p><?php _e('give the link title here','uoc');?></p>
                                          </li>
                                        </ul>
                                        
                                </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                           <div class="hidden-object"><input type="hidden" name="offerslider_num[]" value="<?php echo (int)$offerslider_num?>" class="fieldCounter"/></div>
                        <div class="wrapptabbox" style="padding:0">
                            <div class="opt-conts">
                                <ul class="form-elements noborder">
                                    <li class="to-field">
                                    <a href="#" class="add_servicesss cs-main-btn" onclick="cs_shortcode_element_ajax_call('offerslider', 'shortcode-item-<?php echo esc_attr($cs_counter);?>', '<?php echo admin_url('admin-ajax.php');?>')"><i class="icon-plus-circle"></i><?php _e('Add Offer','uoc');?></a>
                                     <div id="loading" class="shortcodeload"></div>
                                    </li>
                                </ul>
                                <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
                                        <ul class="form-elements insert-bg">
                                            <li class="to-field">
                                                <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js(str_replace('cs_pb_','',$name));?>','shortcode-item-<?php echo esc_js($cs_counter);?>','<?php echo esc_js($filter_element);?>')" ><?php _e('Insert','uoc');?></a>
                                            </li>
                                        </ul>
                                        <div id="results-shortocde"></div>
                                    <?php } else {?>
                                    <ul class="form-elements noborder">
                                        <li class="to-label"></li>
                                        <li class="to-field">
                                            <input type="hidden" name="cs_orderby[]" value="offerslider" />
                                            <input type="button" value="<?php _e('Save','uoc');?>" style="margin-right:10px;" onclick="javascript:_removerlay(jQuery(this))" />
                                        </li>
                                    </ul>
                                   <?php }?>
                            </div>
                        </div>
                     </div>            
                </div>
           </div>
        </div>

<?php
        if ( $die <> 1 ) die();
    }
    add_action('wp_ajax_cs_pb_offerslider', 'cs_pb_offerslider');
}
