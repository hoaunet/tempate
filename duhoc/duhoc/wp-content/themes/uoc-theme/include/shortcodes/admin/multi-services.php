<?php

if ( ! function_exists( 'cs_pb_multiple_services' ) ) {
    function cs_pb_multiple_services($die = 0){
        global $cs_node, $post;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $cs_counter = $_POST['counter'];
        $multiple_services_num = 0;
        if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes ($shortcode_element_id);
            $PREFIX = CS_SC_MULTPLESERVICES.'|'.CS_SC_MULTPLESERVICESITEM;
            $parseObject     = new ShortcodeParse();
            $output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
        }
        $defaults = array(
		'cs_multiple_service_section_title' => '',
		'cs_multiple_services_view' => ''
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
                $multiple_services_num = count($atts_content);
        $multiple_services_element_size = '25';
        foreach($defaults as $key=>$values){
            if(isset($atts[$key]))
                $$key = $atts[$key];
            else 
                $$key =$values;
         }

        $name = 'cs_pb_multiple_services';
        $coloumn_class = 'column_'.$multiple_services_element_size;
        if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        $randD_id = rand(34213234, 453324453);
    ?>
<div id="<?php echo cs_allow_special_char($name.$cs_counter);?>_del" class="column  parentdelete <?php echo cs_allow_special_char($coloumn_class);?> <?php echo cs_allow_special_char($shortcode_view);?>" item="multiple_services" data="<?php echo cs_element_size_data_array_index($multiple_services_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$multiple_services_element_size,'','weixin');?>
  <div class="cs-wrapp-class-<?php echo cs_allow_special_char($cs_counter)?> <?php echo cs_allow_special_char($shortcode_element);?>" id="<?php echo cs_allow_special_char($name.$cs_counter);?>" style="display: none;">
    <div class="cs-heading-area">
      <h5><?php _e('Edit Multiple services Options','uoc');?></h5>
      <a href="javascript:removeoverlay('<?php echo cs_allow_special_char($name.$cs_counter)?>','<?php echo cs_allow_special_char($filter_element);?>')" class="cs-btnclose"><i class="icon-times"></i></a>
	  </div>
    <div class="cs-clone-append cs-pbwp-content" >
      <div class="cs-wrapp-tab-box">
        <div id="shortcode-item-<?php echo esc_attr($cs_counter);?>" data-shortcode-template="{{child_shortcode}} [/<?php echo esc_attr( CS_SC_MULTPLESERVICES ) ;?>]" data-shortcode-child-template="[<?php echo esc_attr( CS_SC_MULTPLESERVICESITEM ) ;?> {{attributes}}] {{content}} [/<?php echo esc_attr( CS_SC_MULTPLESERVICESITEM ) ;?>]">
          <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true" data-template="[<?php echo esc_attr( CS_SC_MULTPLESERVICES ) ;?> {{attributes}}]">
            <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){cs_shortcode_element_size();}?>
            <ul class="form-elements">
                <li class="to-label"><label><?php _e('Section Title','uoc');?></label></li>
                <li class="to-field">
                    <input  name="cs_multiple_service_section_title[]" type="text"  value="<?php echo cs_allow_special_char($cs_multiple_service_section_title);?>"   />
                </li>                  
             </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label><?php _e('View','uoc');?></label>
              </li>
              <li class="to-field select-style">
                <select class="cs_size" id="cs_size" name="cs_multiple_services_view[]">
				 <option value="classic" <?php if($cs_multiple_services_view == 'classic'){echo 'selected="selected"';}?>><?php _e('Classic','uoc');?></option> 	
                 <option value="modren" <?php if($cs_multiple_services_view == 'modren'){echo 'selected="selected"';}?>><?php _e('Modern','uoc');?></option>
                 <option value="slider" <?php if($cs_multiple_services_view == 'slider'){echo 'selected="selected"';}?>><?php _e('Slider','uoc');?></option>
                </select>
              </li>
            </ul>
          </div>
          <?php
                  if ( isset($multiple_services_num) && $multiple_services_num <> '' && isset($atts_content) && is_array($atts_content)){
                    $itemCounter  = 0 ;        
                    foreach ( $atts_content as $multiple_services_items ){
                        $itemCounter++;
                        $rand_id = rand(3453499,94646890);
						$cs_multiple_service_text = $multiple_services_items['content'];
                        $defaults = array('cs_title_color'=>'','cs_text_color'=>'','cs_bg_color'=>'','cs_website_url'=>'','cs_multiple_service_title'=>'','cs_multiple_service_logo'=>'','cs_multiple_service_btn'=>'','cs_multiple_service_btn_link'=>'','cs_multiple_service_btn_bg_color'=>'','cs_multiple_service_btn_txt_color'=>'');
                        foreach($defaults as $key=>$values){
                            if(isset($multiple_services_items['atts'][$key]))
                                $$key = $multiple_services_items['atts'][$key];
                            else 
                                $$key =$values;
                         }
                ?>
                      <div class='cs-wrapp-clone cs-shortcode-wrapp'  id="cs_infobox_<?php echo cs_allow_special_char($rand_id);?>">
                        <header>
                          <h4><i class='icon-arrows'></i><?php _e('Multiple services','uoc');?></h4>
                          <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php _e('Remove','uoc');?></a>
                        </header>
                        <ul class="form-elements">
                          <li class="to-label">
                            <label><?php _e('Title','uoc');?></label>
                          </li>
                          <li class="to-field">
                            <input type="text" id="cs_multiple_service_title" class="" name="cs_multiple_service_title[]" value="<?php echo cs_allow_special_char($cs_multiple_service_title);?>" />
                          </li>
                        </ul>
                        <ul class="form-elements">
                          <li class="to-label">
                            <label><?php _e('Title Color', 'uoc');?></label>
                          </li>
                          <li class="to-field">
                            <input type="text" id="cs_title_color" class="bg_color" name="cs_title_color[]" value="<?php echo esc_attr($cs_title_color);?>" />
                          </li>
                        </ul>
                        <ul class="form-elements">
                          <li class="to-label">
                            <label><?php _e('Text Color', 'uoc');?></label>
                          </li>
                          <li class="to-field">
                            <input type="text" id="cs_text_color" class="bg_color" name="cs_text_color[]" value="<?php echo esc_attr($cs_text_color);?>" />
                          </li>
                        </ul>
                        <ul class="form-elements">
                          <li class="to-label">
                            <label><?php _e('Background Color','uoc');?></label>
                          </li>
                          <li class="to-field">
                            <input type="text" id="cs_bg_color" class="bg_color" name="cs_bg_color[]" value="<?php echo esc_attr($cs_bg_color);?>" />
                          </li>
                        </ul>
                        <ul class="form-elements">
                          <li class="to-label">
                            <label><?php _e('Website Url','uoc');?></label>
                          </li>
                          <li class="to-field">
                            <div class="input-sec">
                              <input type="text" id="cs_website_url" class="" name="cs_website_url[]" value="<?php echo esc_url($cs_website_url);?>" />
                            </div>
                            <div class="left-info">
                              <p>e.g. http://yourdomain.com/</p>
                            </div>
                          </li>
                        </ul>
                        <ul class="form-elements">
                          <li class="to-label">
                            <label><?php _e('Multiple service Logo','uoc');?></label>
                          </li>
                          <li class="to-field">
                            <input id="cs_multiple_service_logo<?php echo cs_allow_special_char($rand_id)?>" name="cs_multiple_service_logo[]" type="hidden" class="" value="<?php echo cs_allow_special_char($cs_multiple_service_logo);?>"/>
                            <input name="cs_multiple_service_logo<?php echo cs_allow_special_char($rand_id)?>"  type="button" class="uploadMedia left" value="<?php _e('Browse','uoc');?>"/>
                          </li>
                        </ul>
                        <div class="page-wrap" style="overflow:hidden; display:<?php echo cs_allow_special_char($cs_multiple_service_logo) && trim($cs_multiple_service_logo) !='' ? 'inline' : 'none';?>" id="cs_multiple_service_logo<?php echo cs_allow_special_char($rand_id)?>_box" >
                          <div class="gal-active">
                            <div class="dragareamain" style="padding-bottom:0px;">
                              <ul id="gal-sortable">
                                <li class="ui-state-default" id="">
                                  <div class="thumb-secs"> <img src="<?php echo esc_url($cs_multiple_service_logo);?>"  id="cs_multiple_service_logo<?php echo cs_allow_special_char($rand_id)?>_img" width="100" height="150"  />
                                    <div class="gal-edit-opts"> <a href="javascript:del_media('cs_multiple_service_logo<?php echo cs_allow_special_char($rand_id)?>')" class="delete"></a> </div>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <ul class='form-elements'>
                          <li class='to-label'>
                            <label><?php _e('Text:','uoc');?></label>
                          </li>
                          <li class='to-field'>
                            <div class='input-sec'>
                              <textarea class='txtfield' data-content-text="cs-shortcode-textarea" name='cs_multiple_service_text[]'><?php echo cs_allow_special_char($cs_multiple_service_text);?></textarea>
                              <div class='left-info'>
                                <p><?php _e('Enter your content','uoc');?></p>
                              </div>
                            </div>
                          </li>
                        </ul>
                        
          <?php }
             }
            ?>
        </div>
        <div class="hidden-object">
          <input type="hidden" name="multiple_services_num[]" value="<?php echo (int)$multiple_services_num;?>" class="fieldCounter"  />
        </div>
        <div class="wrapptabbox no-padding-lr">
          <div class="opt-conts">
            <ul class="form-elements noborder">
              <li class="to-field"> <a href="#" class="add_servicesss cs-main-btn" onclick="cs_shortcode_element_ajax_call('multiple_services', 'shortcode-item-<?php echo cs_allow_special_char($cs_counter);?>', '<?php echo cs_allow_special_char(admin_url('admin-ajax.php'));?>')"><i class="icon-plus-circle"></i><?php _e('Add Multiple service','uoc');?></a> </li>
               <div id="loading" class="shortcodeload"></div>
            </ul>
          </div>
          <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
          <ul class="form-elements insert-bg">
            <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo cs_allow_special_char(str_replace('cs_pb_','',$name));?>','shortcode-item-<?php echo cs_allow_special_char($cs_counter);?>','<?php echo cs_allow_special_char($filter_element);?>')" ><?php _e('Insert','uoc');?></a> </li>
          </ul>
          <div id="results-shortocde"></div>
          <?php } else {?>
          <ul class="form-elements noborder no-padding-lr">
            <li class="to-label"></li>
            <li class="to-field">
              <input type="hidden" name="cs_orderby[]" value="multiple_services" />
              <input type="button" value="<?php _e('Save','uoc');?>" style="margin-right:10px;" onclick="javascript:_removerlay(jQuery(this))" />
            </li>
          </ul>
          <?php }?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
        if ( $die <> 1 ) die();
    }
    add_action('wp_ajax_cs_pb_multiple_services', 'cs_pb_multiple_services');
}
?>
