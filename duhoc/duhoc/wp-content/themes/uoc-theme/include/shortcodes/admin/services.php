<?php
/*
 *
 *@Shortcode Name : Services
 *@retrun
 *
 */

if ( ! function_exists( 'cs_pb_services' ) ) {
    function cs_pb_services($die = 0){
        global $cs_node, $cs_count_node, $post;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $PREFIX = CS_SC_SERVICES;
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
		'column_size'=>'1/2', 
		'cs_service_type' => '',
		'cs_service_border_right' => '',
		'cs_service_icon_type' => '',
		'cs_link_url'=>'',
		'cs_service_icon' => '',
		'cs_service_icon_color' => '',
		'cs_service_bg_image' => '',
		'cs_service_bg_color' => '',
		'service_icon_size' => '',
		'cs_service_postion_modern' => '',
		'cs_service_postion_classic' => '',
		'cs_service_title'=>'',
		'cs_service_title_color'=>'',
		'cs_service_content_color'=>'',
		'cs_service_btn_text_color'=>'',
		'cs_service_content' => '',
		'cs_service_link_text' => '', 
		'cs_service_link_color'=>'',
		'cs_service_url' => '', 
		'cs_service_class'=>'',
		'cs_view_style' =>''
		);
            
        if(isset($output['0']['atts']))
            $atts = $output['0']['atts'];
        else 
            $atts = array();
        
        if(isset($output['0']['content']))
            $atts_content = $output['0']['content'];
        else 
            $atts_content = "";
		
        $services_element_size = '25';
        foreach($defaults as $key=>$values){
            if(isset($atts[$key]))
                $$key = $atts[$key];
            else 
                $$key =$values;
         }
        $name = 'cs_pb_services';
        $coloumn_class = 'column_'.$services_element_size;
    
    if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
        $shortcode_element = 'shortcode_element_class';
        $shortcode_view = 'cs-pbwp-shortcode';
        $filter_element = 'ajax-drag';
        $coloumn_class = '';
    }    
    $counter_count = $cs_counter;
    $rand_counter = cs_generate_random_string(10);
    ?>
<div id="<?php echo esc_attr($name.$cs_counter)?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="services" data="<?php echo cs_element_size_data_array_index($services_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$services_element_size,'','check-square-o');?>
  <div class="cs-wrapp-class-<?php echo esc_attr($cs_counter)?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo esc_attr($name.$cs_counter)?>" data-shortcode-template="[<?php echo esc_attr( CS_SC_SERVICES ) ;?> {{attributes}}]{{content}}[/<?php echo esc_attr( CS_SC_SERVICES ) ;?>]" style="display: none;">
    <div class="cs-heading-area">
      <h5><?php _e('Edit Services Options','uoc');?></h5>
      <a href="javascript:removeoverlay('<?php echo esc_attr($name.$cs_counter);?>','<?php echo esc_attr($filter_element);?>')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
    <div class="cs-pbwp-content">
      <div class="cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content">
        <ul class='form-elements' style="display:none">
          <li class='to-label'>
            <label><?php _e('Choose View','uoc');?></label>
          </li>
          <li class='to-field select-style'>
            <div class='input-sec'>
              <select name='cs_service_type[]' class='dropdown' id="cs_service_type-<?php echo esc_attr($rand_counter)?>" onchange="cs_service_toggle_view(this.value,'<?php echo esc_attr($rand_counter);?>', jQuery(this))">
                <option value='modern' <?php if($cs_service_type == 'modern'){echo 'selected="selected"';}?>><?php _e('Modern','uoc');?></option>
                </select>
              <p class='left-info'><?php _e('Set a view from the dropdown','uoc');?></p>
            </div>
          </li>
        </ul>
        
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Choose','uoc');?></label>
          </li>
          <li class="to-field">
            <div class="select-style">
              <select name="cs_service_icon_type[]" class="dropdown" onchange="cs_service_toggle_image(this.value,'<?php echo esc_attr($rand_counter);?>', jQuery(this))">
                <option <?php if($cs_service_icon_type=="icon")echo "selected";?> value="icon" ><?php _e('Icon','uoc');?></option>
                <option <?php if($cs_service_icon_type=="image")echo "selected";?> value="image" ><?php _e('Image','uoc');?></option>
              </select>
              <div class='left-info'><p><?php _e('Choose a icon/image type form the dropdown','uoc');?></p></div>
            </div>
          </li>
        </ul>
        <div class="selected_icon_type" id="selected_icon_type<?php echo esc_attr($rand_counter)?>" <?php if($cs_service_icon_type<>"image"){ echo 'style="display:block"';} else { echo 'style="display:none"';}?>>
          <ul class='form-elements' id="cs_infobox_<?php echo esc_attr($rand_counter);?>">
            <li class='to-label'>
              <label><?php _e('Choose Icon','uoc');?></label>
            </li>
            <li class="to-field">
              <?php cs_fontawsome_icons_box($cs_service_icon,$rand_counter,'cs_service_icon');?>
              <div class='left-info'><p><?php _e('Select the fontawsome Icons you would like to add to your menu items','uoc');?></p></div>
            </li>
          </ul>
          
          <ul class="form-elements">
            <li class="to-label">
              <label><?php _e('Icon Color','uoc');?></label>
            </li>
            <li class="to-field">
              <div class='input-sec'>
                <input type="text" name="cs_service_icon_color[]" class="bg_color"  value="<?php echo esc_attr($cs_service_icon_color);?>" />
                <div class='left-info'><p><?php _e('Set custom colour for icon','uoc');?></p></div>
              </div>
            </li>
          </ul>
        </div>
        <div class="selected_image_type" id="selected_image_type<?php echo esc_attr($rand_counter);?>" <?php if($cs_service_icon_type=="image"){ echo 'style="display:block"';} else { echo 'style="display:none"';}?>>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php _e('Image','uoc');?></label>
            </li>
            <li class="to-field">
              <input id="service_bg_image<?php echo esc_attr($rand_counter);?>" name="cs_service_bg_image[]" type="hidden" class="" value="<?php echo esc_url($cs_service_bg_image);?>"/>
              <input name="service_bg_image<?php echo esc_attr($rand_counter);?>"  type="button" class="uploadMedia left" value="<?php _e('Browse','uoc');?>"/>
            </li>
          </ul>
          <div class="page-wrap" style="overflow:hidden; display:<?php echo esc_url($cs_service_bg_image) && trim($cs_service_bg_image) !='' ? 'inline' : 'none';?>" id="service_bg_image<?php echo esc_attr($rand_counter);?>_box" >
            <div class="gal-active">
              <div class="dragareamain" style="padding-bottom:0px;">
                <ul id="gal-sortable">
                  <li class="ui-state-default" id="">
                    <div class="thumb-secs"> <img src="<?php echo esc_url($cs_service_bg_image);?>"  id="service_bg_image<?php echo esc_attr($rand_counter);?>_img" width="100" height="150"  />
                      <div class="gal-edit-opts"> <a   href="javascript:del_media('service_bg_image<?php echo esc_attr($rand_counter);?>')" class="delete"></a> </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <ul class="form-elements"  id="modern-size-<?php echo esc_attr($rand_counter);?>" style=" <?php echo esc_attr($cs_service_type) == '' || $cs_service_type == 'modern'? 'display:block;' : 'display:none;' ;?>">
          <li class="to-label">
            <label><?php _e('Icon Size','uoc');?></label>
          </li>
          <li class="to-field select-style">
            <select class="service_icon_size" name="service_icon_size[]">
              <option value="icon-2x" <?php if($service_icon_size == 'icon-2x'){echo 'selected="selected"';}?>><?php _e('Small','uoc');?></option>
              <option value="icon-3x" <?php if($service_icon_size == 'icon-3x'){echo 'selected="selected"';}?>><?php _e('Medium','uoc');?></option>
              <option value="icon-4x" <?php if($service_icon_size == 'icon-4x'){echo 'selected="selected"';}?>><?php _e('Large','uoc');?></option>
              <option value="icon-5x" <?php if($service_icon_size == 'icon-5x'){echo 'selected="selected"';}?>><?php _e('Extra Large','uoc');?></option>
            </select>
            <div class='left-info'><p><?php _e('Select Icon Size','uoc');?></p></div>
          </li>
        </ul>
        
        
        <!--<ul class="form-elements" id="service-position-modern-<?php //echo esc_attr($rand_counter);?>" >
          <li class="to-label">
            <label><?php //_e('Align','uoc');?></label>
          </li>
          <li class="to-field select-style">
            <select class="service_postion" name="cs_view_style[]">
             
              <option value="simple" <?php //if($cs_service_postion_modern == 'simple'){echo 'selected="selected"';}?>><?php //_e('simple','uoc');?></option>
               <option value="gird" <?php //if($cs_service_postion_modern == 'gird'){echo 'selected="selected"';}?>><?php //_e('grid view','uoc');?></option>
            </select>
            <div class='left-info'><p><?php //_e('Select view Style','uoc');?></p></div>
          </li>
        </ul>
        -->
        
        
        
        
        
 
        <ul class="form-elements" id="service-position-modern-<?php echo esc_attr($rand_counter);?>" style=" <?php echo trim($cs_service_type) == '' || $cs_service_type == 'modern'? 'display:block;' : 'display:none;' ;?>">
          <li class="to-label">
            <label><?php _e('Align','uoc');?></label>
          </li>
          <li class="to-field select-style">
            <select class="service_postion" name="cs_service_postion_modern[]">
              <option value="left" <?php if($cs_service_postion_modern == 'left'){echo 'selected="selected"';}?>><?php _e('left','uoc');?></option>
              <option value="top" <?php if($cs_service_postion_modern == 'top'){echo 'selected="selected"';}?>><?php _e('Top','uoc');?></option>
              <option value="top_left" <?php if($cs_service_postion_modern == 'top_left'){echo 'selected="selected"';}?>><?php _e('Top Left','uoc');?></option>
            </select>
            <div class='left-info'><p><?php _e('Give the position','uoc');?></p></div>
          </li>
        </ul>
        <ul class="form-elements" id="service-position-classic-<?php echo esc_attr($rand_counter);?>" style=" <?php echo trim($cs_service_type) == '' || $cs_service_type == 'modern'? 'display:none;' : 'display:block;' ;?>">
          <li class="to-label">
            <label><?php _e('Align','uoc');?></label>
          </li>
          <li class="to-field select-style">
            <select class="service_postion" name="cs_service_postion_classic[]">
              <option value="left" <?php if($cs_service_postion_classic == 'left'){echo 'selected="selected"';}?>><?php _e('Left','uoc');?></option>
              <option value="right" <?php if($cs_service_postion_classic == 'right'){echo 'selected="selected"';}?>><?php _e('Right','uoc');?></option>
            </select>
            <div class='left-info'><p><?php _e('Give the position','uoc');?></p></div>
          </li>
        </ul>
        <ul class='form-elements'>
          <li class='to-label'>
            <label><?php _e('Title','uoc');?></label>
          </li>
          <li class='to-field'>
            <div class='input-sec'>
              <input class='txtfield' type='text' name='cs_service_title[]' value="<?php echo cs_allow_special_char($cs_service_title);?>" />
            </div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Title Color','uoc');?></label>
          </li>
          <li class="to-field">
            <div class="pic-color"><input type="text" name="cs_service_title_color[]" class="bg_color" value="<?php echo esc_attr($cs_service_title_color);?>" /></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Content','uoc');?></label>
          </li>
          <li class="to-field">
            <textarea name="cs_service_content[]" data-content-text="cs-shortcode-textarea"><?php echo esc_textarea($atts_content)?></textarea>
            <p><?php _e('Enter the content','uoc');?></p>
          </li>
        </ul>
        
        
        <ul class='form-elements'>
          <li class='to-label'>
            <label><?php _e('Link URL','uoc');?></label>
          </li>
          <li class='to-field'>
            <div class='input-sec'>
              <input class='txtfield' type='text' name='cs_link_url[]' value="<?php echo cs_allow_special_char($cs_link_url);?>" />
            </div>
          </li>
        </ul>
        
        
        
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Content Color','uoc');?></label>
          </li>
          <li class="to-field">
            <div class="pic-color"><input type="text" name="cs_service_content_color[]" class="bg_color" value="<?php echo esc_attr($cs_service_content_color);?>" /></div>
          </li>
        </ul>
         
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Custom Id','uoc');?></label>
          </li>
          <li class="to-field">
            <input type="text" name="cs_service_class[]" class="txtfield"  value="<?php echo esc_attr($cs_service_class)?>" />
            <div class='left-info'><p><?php _e('Use this option if you want to use specified id for this element','uoc');?></p></div>
          </li>
        </ul>
        
      </div>
 
      <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
      <ul class="form-elements insert-bg">
        <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js(str_replace('cs_pb_','',$name));?>','<?php echo esc_js($name.$cs_counter);?>','<?php echo esc_js($filter_element);?>')" ><?php _e('Insert','uoc');?></a> </li>
      </ul>
      <div id="results-shortocde"></div>
      <?php } else {?>
      <ul class="form-elements noborder">
        <li class="to-label"></li>
        <li class="to-field">
          <input type="hidden" name="cs_orderby[]" value="services" />
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
    add_action('wp_ajax_cs_pb_services', 'cs_pb_services');
}
?>