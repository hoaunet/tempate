<?php
/*
 *
 *@File : Call to action
 *@retrun
 *
 */	

if ( ! function_exists( 'cs_pb_call_to_action' ) ) {
    function cs_pb_call_to_action($die = 0){
        global $cs_node, $count_node, $post;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $PREFIX = CS_SC_CALLTOACTION;
        $cs_counter = $_POST['counter'];
        $parseObject     = new ShortcodeParse();
        if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes ($shortcode_element_id);
            $output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
        }
        $defaults = array(
		  'column_size'=>'1/1',
		  'cs_call_to_action_section_title'=>'',
		  'cs_content_type'=>'',
		  'cs_call_action_title'=>'',
		  'cs_call_to_action_text'=>'',
		   'cs_call_to_action_view'=>'',
		   'cs_call_to_action_left_img'=>'',
		  'cs_contents_color'=>'',
		  'cs_call_action_icon'=>'',
		  'cs_call_view' =>'',
		  'cs_icon_color'=>'#FFF',
		  'cs_call_to_action_icon_background_color'=>'',
		  'cs_call_to_action_button_text'=>'',
		  'cs_call_to_action_button_link'=>'#',
		  'cs_call_to_action_bg_img'=>'',
		  'animate_style'=>'slide',
		  'class'=>'cs-article-box',
		  'cs_call_to_action_class'=>'',
		  'cs_call_to_action_icon_button_color' =>'',
		  'cs_call_to_action_button_bg_color'=>'',
		 );
        if(isset($output['0']['atts']))
            $atts = $output['0']['atts'];
        else 
            $atts = array();
        if(isset($output['0']['content']))
            $atts_content = $output['0']['content'];
        else 
            $atts_content = "";
        $call_to_action_element_size = '100';
        foreach($defaults as $key=>$values){
            if(isset($atts[$key]))
                $$key = $atts[$key];
            else 
                $$key = $values;
         }
        $name = 'cs_pb_call_to_action';
        $coloumn_class = 'column_'.$call_to_action_element_size;
    
    if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
        $shortcode_element = 'shortcode_element_class';
        $shortcode_view = 'cs-pbwp-shortcode';
        $filter_element = 'ajax-drag';
        $coloumn_class = '';
    }    
	  
     $rand_counter = cs_generate_random_string(10);
    ?>
<div id="<?php echo esc_attr($name.$cs_counter)?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="call_to_action" data="<?php echo cs_element_size_data_array_index($call_to_action_element_size)?>">
  <?php cs_element_setting($name,$cs_counter,$call_to_action_element_size,'','info-circle');?>
  <div class="cs-wrapp-class-<?php echo esc_attr($cs_counter)?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo esc_attr($name.$cs_counter)?>" data-shortcode-template="[<?php echo esc_attr( CS_SC_CALLTOACTION );?> {{attributes}}]{{content}}[/<?php echo esc_attr( CS_SC_CALLTOACTION );?>]" style="display: none;">
    <div class="cs-heading-area">
      <h5><?php _e('Edit Call To Action Options','uoc');?></h5>
      <a href="javascript:removeoverlay('<?php echo esc_attr($name.$cs_counter);?>','<?php echo esc_attr($filter_element);?>')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
    <div class="cs-pbwp-content">
      <div class="cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content">
        <?php
         if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){cs_shortcode_element_size();}?>
         <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Section Title','uoc');?></label>
          </li>
          <li class="to-field">
            <input  name="cs_call_to_action_section_title[]" type="text"  value="<?php echo cs_allow_special_char($cs_call_to_action_section_title);?>" />
            <div class='left-info'><p> <?php _e('This is used for the one page navigation, to identify the section below. Give a title','uoc');?></p></div>
          </li>
        </ul>
       
       
          <ul class="form-elements">
              <li class="to-label">
                <label><?php _e('View Style','uoc');?></label>
              </li>
              <li class="to-field">
 
			<select name='cs_call_to_action_view[]' class='dropdown'>
				<option value='simple' <?php if($cs_call_to_action_view == 'simple'){echo 'selected';}?>><?php _e('Simple','uoc');?></option>
				<option value='modern' <?php if($cs_call_to_action_view == 'modern'){echo 'selected';}?>><?php _e('Modern','uoc');?></option>
                  </select>   </li>
            </ul>
                   <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Choose','uoc');?></label>
          </li>
          <li class="to-field">
            <div class="select-style">
              <select name="cs_call_view[]" class="dropdown" onchange="cs_service_toggle_image(this.value,'<?php echo esc_attr($rand_counter);?>', jQuery(this))">
                <option <?php if($cs_call_view=="icon")echo "selected";?> value="icon" ><?php _e('Icon','uoc');?></option>
                <option <?php if($cs_call_view=="image")echo "selected";?> value="image" ><?php _e('Image','uoc');?></option>
              </select>
              <div class='left-info'><p><?php _e('Choose a icon/image type form the dropdown','uoc');?></p></div>
            </div>
          </li>
        </ul>
        
        
        <div class="selected_icon_type" id="selected_icon_type<?php echo esc_attr($rand_counter)?>" <?php if($cs_call_view<>"image"){ echo 'style="display:block"';} else { echo 'style="display:none"';}?>>
          <ul class='form-elements' id="cs_infobox_<?php echo esc_attr($rand_counter);?>">
            <li class='to-label'>
              <label><?php _e('Choose Icon','uoc');?></label>
            </li>
            <li class="to-field">
              <?php cs_fontawsome_icons_box($cs_call_action_icon,$rand_counter,'cs_call_action_icon');?>
              <div class='left-info'><p><?php _e('Select the fontawsome Icons you would like to add to your menu items','uoc');?></p></div>
            </li>
          </ul>
         
          
        </div>
        
        
        
        
        
        
        
        
        <div class="selected_image_type" id="selected_image_type<?php echo esc_attr($rand_counter);?>" <?php if($cs_call_view=="image"){ echo 'style="display:block"';} else { echo 'style="display:none"';}?>>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php _e('Image','uoc');?></label>
            </li>
            <li class="to-field">
              <input id="cs_call_to_action_left_img<?php echo esc_attr($rand_counter);?>" name="cs_call_to_action_left_img[]" type="hidden" class="" value="<?php echo esc_url($cs_call_to_action_left_img);?>"/>
              <input name="cs_call_to_action_left_img<?php echo esc_attr($rand_counter);?>"  type="button" class="uploadMedia left" value="<?php _e('Browse','uoc');?>"/>
            </li>
          </ul>
          <div class="page-wrap" style="overflow:hidden; display:<?php echo esc_url($cs_call_to_action_left_img) && trim($cs_call_to_action_left_img) !='' ? 'inline' : 'none';?>" id="cs_call_to_action_left_img<?php echo esc_attr($rand_counter);?>_box" >
            <div class="gal-active">
              <div class="dragareamain" style="padding-bottom:0px;">
                <ul id="gal-sortable">
                  <li class="ui-state-default" id="">
                    <div class="thumb-secs"> <img src="<?php echo esc_url($cs_call_to_action_left_img);?>"  id="cs_call_to_action_left_img<?php echo esc_attr($rand_counter);?>_img" width="100" height="150"  />
                      <div class="gal-edit-opts"> <a   href="javascript:del_media('cs_call_to_action_left_img<?php echo esc_attr($rand_counter);?>')" class="delete"></a> </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
               
               
            
            
            <!------------------------------------------------------------------------------------------->
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Title','uoc');?></label>
          </li>
          <li class="to-field">
            <input type="text" size="12" maxlength="150" value="<?php echo cs_allow_special_char($cs_call_action_title);?>" class="" name="cs_call_action_title[]">
            <div class='left-info'><p> <?php _e('Put the title for action element','uoc');?></p></div>
          </li>
        </ul>
         <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Image','uoc');?></label>
          </li>
          <li class="to-field">
            <div class="page-wrap" style="overflow:hidden; display:<?php echo esc_attr($cs_call_to_action_bg_img) && trim($cs_call_to_action_bg_img) !='' ? 'inline' : 'none';?>" id="cs_call_to_action_bg_img<?php echo esc_attr($cs_counter)?>_box" >
              <div class="gal-active">
                <div class="dragareamain" style="padding-bottom:0px;">
                  <ul id="gal-sortable">
                    <li class="ui-state-default" id="">
                      <div class="thumb-secs"> <img src="<?php echo esc_url($cs_call_to_action_bg_img);?>"  id="cs_call_to_action_bg_img<?php echo esc_attr($cs_counter)?>_img" width="100" height="150"  />
                        <div class="gal-edit-opts"> <a href="javascript:del_media('cs_call_to_action_bg_img<?php echo esc_js($cs_counter)?>')" class="delete"></a> </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <input id="cs_call_to_action_bg_img<?php echo esc_attr($cs_counter)?>" name="cs_call_to_action_bg_img[]" type="hidden" class="" value="<?php echo esc_attr($cs_call_to_action_bg_img);?>"/>
            <input name="cs_call_to_action_bg_img<?php echo esc_attr($cs_counter)?>"  type="button" class="uploadMedia left" value="<?php _e('Browse','uoc'); ?>"/>
            <div class='left-info'><p><?php _e('Select the background image for action element','uoc');?></p></div>
          </li>
        </ul>
    
        <ul class="form-elements">
          <li class="to-label">
           <label><?php _e('Description','uoc');?></label>
          </li>
          <li class="to-field">
            <textarea data-content-text="cs-shortcode-textarea" name="cs_call_to_action_text[]"><?php echo cs_allow_special_char($cs_call_to_action_text);?></textarea>
            <p><?php _e('This is used for the one page navigation, to identify the section below. Give a title','uoc');?></p>
          </li>
        </ul>
        
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Text Color','uoc');?></label>
          </li>
          <li class="to-field">
            <input type="text" class="bg_color" name="cs_contents_color[]" value="<?php echo esc_attr($cs_contents_color);?>" />
            <div class='left-info'><p><?php _e('Provide a hex colour code here (with #) if you want to override the default','uoc');?> </p></div>
          </li>
        </ul>
         
         
            <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Background Color','uoc');?></label>
          </li>
          <li class="to-field">
            <input class="bg_color" value="<?php echo esc_attr($cs_call_to_action_icon_background_color);?>" name="cs_call_to_action_icon_background_color[]">
            <div class='left-info'><p><?php _e('Provide a hex colour code here (with #) if you want to override the default','uoc');?> </p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Button Text','uoc');?></label>
          </li>
          <li class="to-field">
            <input type="text" size="55" name="cs_call_to_action_button_text[]" value="<?php echo esc_attr($cs_call_to_action_button_text);?>" >
            <div class='left-info'><p><?php _e('Text on the button','uoc');?></p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Button Link','uoc');?></label>
          </li>
          <li class="to-field">
            <input type="text" name="cs_call_to_action_button_link[]" value="<?php echo esc_attr($cs_call_to_action_button_link);?>" />
            <div class='left-info'><p><?php _e('Button link','uoc');?></p></div>
          </li>
        </ul>
          <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Button Color','uoc');?></label>
          </li>
          <li class="to-field">
            <input class="bg_color" value="<?php echo esc_attr($cs_call_to_action_icon_button_color);?>" name="cs_call_to_action_icon_button_color[]">
            <div class='left-info'><p><?php _e('Provide a hex colour code here (with #) if you want to override the default','uoc');?> </p></div>
          </li>
        </ul>
        
        
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Button Background Color','uoc');?></label>
          </li>
          <li class="to-field">
            <input class="bg_color" value="<?php echo esc_attr($cs_call_to_action_button_bg_color);?>" name="cs_call_to_action_button_bg_color[]">
            <div class='left-info'><p><?php _e('Provide a hex colour code here (with #) if you want to override the default','uoc');?> </p></div>
          </li>
        </ul>
        
        
        
        
        
        
        
        
        
        
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Custom Id','uoc');?></label>
          </li>
          <li class="to-field">
            <input type="text" name="cs_call_to_action_class[]" class="txtfield"  value="<?php echo esc_attr($cs_call_to_action_class)?>" />
           <div class='left-info'> <p><?php _e('Use this option if you want to use specified id for this element','uoc');?></p></div>
          </li>
        </ul>
        
      </div>
      <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
      <ul class="form-elements insert-bg">
        <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js(str_replace('cs_pb_','',$name));?>','<?php echo esc_js($name.$cs_counter)?>','<?php echo esc_js($filter_element);?>')" ><?php _e('Insert','uoc');?></a> </li>
      </ul>
      <div id="results-shortocde"></div>
      <?php } else {?>
      <ul class="form-elements noborder">
        <li class="to-label"></li>
        <li class="to-field">
          <input type="hidden" name="cs_orderby[]" value="call_to_action" />
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
    add_action('wp_ajax_cs_pb_call_to_action', 'cs_pb_call_to_action');
}