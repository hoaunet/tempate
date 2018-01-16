<?php
/*
 *
 *@Shortcode Name : Counters
 *@retrun
 *
 */

if ( ! function_exists( 'cs_pb_counter' ) ) {
    function cs_pb_counter($die = 0){
        global $cs_node, $cs_count_node, $post;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $PREFIX = CS_SC_COUNTERS;
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
                'column_size' => '1/1',
                'counter_style' => '',
                'counter_icon_type' => '',
                'cs_counter_logo' => '',
                'counter_icon'=>'',
                'counter_icon_align'=>'',
                'counter_icon_size'=>'',
                'counter_icon_color' => '#21cdec',
                'counter_numbers' => '',
                'counter_number_color' => '#333333',
                'counter_title' => '',
                'counter_link_title' => '',
                'counter_link_url' => '',
                'counter_text_color' => '#818181',
                'counter_border' => '',
				'counter_border_color' => '#ffffff',
                'counter_class' => '',
               
             );
            
        if(isset($output['0']['atts']))
            $atts = $output['0']['atts'];
        else 
            $atts = array();
        
        if(isset($output['0']['content']))
            $atts_content = $output['0']['content'];
        else 
            $atts_content = "";
            
        $counter_element_size = '25';
        foreach($defaults as $key=>$values){
            if(isset($atts[$key]))
                $$key = $atts[$key];
            else 
                $$key =$values;
         }
        $name = 'cs_pb_counter';
        $coloumn_class = 'column_'.$counter_element_size;
    
    if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
        $shortcode_element = 'shortcode_element_class';
        $shortcode_view = 'cs-pbwp-shortcode';
        $filter_element = 'ajax-drag';
        $coloumn_class = '';
    }    
    $counter_count = $cs_counter;
    $random_id = rand(34, 3434233);
    ?>
<div id="<?php echo esc_attr($name.$cs_counter);?>_del" class="column  parentdelete <?php echo cs_allow_special_char($coloumn_class);?> <?php echo cs_allow_special_char($shortcode_view);?>" item="counter" data="<?php echo cs_element_size_data_array_index($counter_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$counter_element_size,'','clock-o');?>
  <div class="cs-wrapp-class-<?php echo esc_attr($cs_counter);?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo cs_allow_special_char($name.$cs_counter);?>" data-shortcode-template="[<?php echo esc_attr( CS_SC_COUNTERS ) ;?> {{attributes}}]{{content}}[/<?php echo esc_attr( CS_SC_COUNTERS ) ;?>]" style="display: none;">
    <div class="cs-heading-area">
      <h5><?php _e('Edit Counter Options','uoc');?></h5>
      <a href="javascript:removeoverlay('<?php echo cs_allow_special_char($name.$cs_counter)?>','<?php echo cs_allow_special_char($filter_element);?>')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
    <div class="cs-pbwp-content">
      <div class="cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content">
        <ul class="form-elements" style="display:none">
           <li class="to-field">
            <div class="select-style">
              <select name="counter_style[]" class="dropdown" onchange="cs_counter_view_type(this.value,'<?php echo cs_allow_special_char($counter_count)?>')" >
                <option value="classic" <?php if($counter_style=="classic")echo "selected";?> ><?php _e('Classic View','uoc');?></option>
             
              </select>
            </div>
          </li>
        </ul>
        <div id="selected_view_icon_type<?php echo esc_attr($counter_count)?>" <?php if($counter_style <> "icon-border"){ echo 'style="display:block"'; } else { echo 'style="display:none"'; }?>>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Choose Icon/Image','uoc');?></label>
          </li>
          <li class="to-field">
            <div class="select-style">
              <select name="counter_icon_type[]" class="dropdown" onchange="cs_counter_image(this.value,'<?php echo cs_allow_special_char($counter_count)?>')">
                <option <?php if($counter_icon_type=="icon")echo "selected";?> value="icon" ><?php _e('Icon','uoc');?></option>
                <option <?php if($counter_icon_type=="image")echo "selected";?> value="image" ><?php _e('Image','uoc');?></option>
              </select>
              <div class='left-info'><p><?php _e('Choose an icon/image for the counter','uoc');?></p></div>
            </div>
          </li>
        </ul>
        <ul class="form-elements" style="display:none">
          <li class="to-field">
            <div class="select-style">
              <select name="counter_icon_align[]" class="dropdown" >
                <option value="left" ><?php _e('Left','uoc');?></option>
              </select>
            </div>
          </li>
        </ul>
        </div>
        <div class="selected_icon_type<?php echo esc_attr($counter_count)?>" id="selected_view_icon_icon_type<?php echo esc_attr($counter_count)?>" <?php if($counter_style == "icon-border" || $counter_icon_type == "icon"){ echo 'style="display:block"';} else { echo 'style="display:none"';}?>>
          <ul class='form-elements' id="cs_infobox_<?php echo esc_attr($name.$cs_counter);?>">
            <li class='to-label'>
              <label><?php _e('Fontawsome Icon','uoc');?></label>
            </li>
            <li class="to-field">
              <?php cs_fontawsome_icons_box($counter_icon,$name.$cs_counter,'counter_icon');?>
              <div class='left-info'><p><?php _e('select the fontawsome Icons you would like to add to your menu items','uoc');?> </p></div>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php _e('Icon Color','uoc');?></label>
            </li>
            <li class="to-field">
              <div class='input-sec'>
                <input type="text" name="counter_icon_color[]" class="bg_color"  value="<?php echo esc_attr($counter_icon_color)?>" />
                <div class='left-info'><p><?php _e('set a color for the counter icon','uoc');?></p></div>
              </div>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php _e('Icon Size','uoc');?></label>
            </li>
            <li class="to-field select-style">
              <select class="counter_icon_size" name="counter_icon_size[]">
                <option value="">None</option>
                <option value="icon-2x" <?php if($counter_icon_size == 'icon-2x'){echo 'selected="selected"';}?>><?php _e('Small','uoc');?></option>
                <option value="icon-3x" <?php if($counter_icon_size == 'icon-3x'){echo 'selected="selected"';}?>><?php _e('Medium','uoc');?></option>
                <option value="icon-4x" <?php if($counter_icon_size == 'icon-4x'){echo 'selected="selected"';}?>><?php _e('Large','uoc');?></option>
                <option value="icon-5x" <?php if($counter_icon_size == 'icon-5x'){echo 'selected="selected"';}?>><?php _e('Extra Large','uoc');?></option>
              </select>
              <div class='left-info'><p><?php _e('Select Icon Size','uoc');?></p></div>
            </li>
          </ul>
        </div>
        <div class="selected_image_type<?php echo esc_attr($counter_count)?> " id="selected_view_icon_image_type<?php echo esc_attr($counter_count)?>" <?php if($counter_style <> "icon-border" ||  $counter_icon_type == "image"){ echo 'style="display:block"';} else { echo 'style="display:none"';}?>>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php _e('Image','uoc');?></label>
            </li>
            <li class="to-field">
              <input id="cs_counter_logo<?php echo esc_attr($random_id);?>" name="cs_counter_logo[]" type="hidden" class="" value="<?php echo esc_url($cs_counter_logo);?>"/>
              <input name="cs_counter_logo<?php echo esc_attr($random_id);?>"  type="button" class="uploadMedia left" value="<?php _e('Browse','uoc');?>"/>
            </li>
          </ul>
          <div class="page-wrap" style="overflow:hidden;" id="cs_counter_logo<?php echo esc_attr($random_id);?>_box" >
            <div class="gal-active">
              <div class="dragareamain" style="padding-bottom:0px;">
                <ul id="gal-sortable">
                  <li class="ui-state-default" id="">
                    <div class="thumb-secs"> <img src="<?php echo esc_url($cs_counter_logo);?>"  id="cs_counter_logo<?php echo esc_attr($random_id);?>_img" width="100" height="150"  />
                      <div class="gal-edit-opts"> <a   href="javascript:del_media('cs_counter_logo<?php echo esc_js($random_id)?>')" class="delete"></a> </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <ul class="form-elements bcevent_title">
          <li class="to-label">
            <label><?php _e('Set number','uoc');?></label>
          </li>
          <li class="to-field">
            <div class="input-sec">
              <input type="text" name="counter_numbers[]" value="<?php if(isset($counter_numbers)){echo esc_attr($counter_numbers);}?>" />
              <div class="color-picker"><input type="text" name="counter_number_color[]" value="<?php if(isset($counter_number_color)){echo esc_attr($counter_number_color);}?>" class="bg_color" /></div>
              
            </div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Sub Title','uoc');?></label>
          </li>
          <li class="to-field">
            <input type="text"  name="counter_title[]" value="<?php echo cs_allow_special_char($counter_title);?>" class="txtfield"  />
            <div class='left-info'><p><?php _e('enter a sub title for the counter','uoc');?></p></div>
          </li>
        </MS
        ><ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Title Color','uoc');?></label>
          </li>
          <li class="to-field">
            <input type="text"  name="counter_text_color[]"  value="<?php echo esc_attr($counter_text_color);?>" class="bg_color"  />
            <div class='left-info'><p><?php _e('Provide a hex colour code here (with #) if you want to override the default','uoc');?> </p></div>
          </li>
        </ul>
        
          <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Padding','uoc');?></label>
          </li>
          <li class="to-field">
            <input type="text"  name="counter_border_color[]"  value="<?php echo esc_attr($counter_border_color);?>" class="txtfield"  />
            <div class='left-info'><p><?php _e('Provide top padding','uoc');?> </p></div>
          </li>
        </ul>
          
        <div class="selected_image_type" id="selected_view_border_type<?php echo esc_attr($counter_count)?>" <?php if($counter_style == "icon-border"){ echo 'style="display:block"';} else { echo 'style="display:none"';}?>>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Border Frame','uoc');?></label>
          </li>
          <li class="to-field">
            <div class="select-style">
              <select name="counter_border[]" class="dropdown">
                <option <?php if($counter_border=="on")echo "selected";?> value="on" ><?php _e('Yes','uoc');?></option>
                <option <?php if($counter_border=="off")echo "selected";?> value="off" ><?php _e('No','uoc');?></option>
              </select>
             <div class='left-info'> <p><?php _e('set yes/no border frame form the dropdown','uoc');?> </p></div>
            </div>
          </li>
        </ul>
        </div>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Custom Id','uoc');?></label>
          </li>
          <li class="to-field">
            <input type="text" name="counter_class[]" class="txtfield"   value="<?php echo esc_attr($counter_class);?>" />
            <div class='left-info'><p><?php _e('Use this option if you want to use specified id for this element','uoc');?></p></div>
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
          <input type="hidden" name="cs_orderby[]" value="counter" />
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
    add_action('wp_ajax_cs_pb_counter', 'cs_pb_counter');
}


?>