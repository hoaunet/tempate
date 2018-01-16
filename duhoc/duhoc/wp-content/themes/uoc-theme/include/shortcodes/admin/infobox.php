<?php
/*
 *
 *@Shortcode Name : Infobox
 *@retrun
 *
 */

if ( ! function_exists( 'cs_pb_infobox' ) ) {
    function cs_pb_infobox($die = 0){
        global $cs_node, $post;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $cs_counter = $_POST['counter'];
        $info_list_num = 0;
        if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes ($shortcode_element_id);
            $PREFIX = CS_SC_INFOBOX.'|'.CS_SC_INFOBOXITEM;
            $parseObject     = new ShortcodeParse();
            $output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
        }
        $defaults = array(
		'column_size'=>'1/1', 
		'cs_infobox_section_title' => '', 
		'cs_infobox_view_style' => '',
		'cs_infobox_title' => '',
		'cs_infobox_bg_color' => '',
		'cs_infobox_list_text_color'=>'',
		'cs_infobox_class' => ''
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
                    $info_list_num = count($atts_content);
            $infobox_element_size = '25';
            foreach($defaults as $key=>$values){
                if(isset($atts[$key]))
                    $$key = $atts[$key];
                else 
                    $$key =$values;
             }
            $name = 'cs_pb_infobox';
            $coloumn_class = 'column_'.$infobox_element_size;
        if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
    ?>

<div id="<?php echo cs_allow_special_char($name.$cs_counter)?>_del" class="column  parentdelete <?php echo cs_allow_special_char($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="infobox" data="<?php echo cs_element_size_data_array_index($infobox_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$infobox_element_size,'','info-circle');?>
  <div class="cs-wrapp-class-<?php echo cs_allow_special_char($cs_counter)?> <?php echo cs_allow_special_char($shortcode_element);?>" id="<?php echo cs_allow_special_char($name.$cs_counter)?>" style="display: none;">
    <div class="cs-heading-area">
      <h5><?php _e('Edit Info box Options','uoc');?></h5>
      <a href="javascript:removeoverlay('<?php echo cs_allow_special_char($name.$cs_counter)?>','<?php echo cs_allow_special_char($filter_element);?>')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
     <div class="cs-clone-append cs-pbwp-content" >
       <div class="cs-wrapp-tab-box">
        <div id="shortcode-item-<?php echo esc_attr($cs_counter);?>" data-shortcode-template="{{child_shortcode}} [/<?php echo esc_attr( CS_SC_INFOBOX );?>]" data-shortcode-child-template="[<?php echo esc_attr( CS_SC_INFOBOXITEM );?> {{attributes}}] {{content}} [/<?php echo esc_attr( CS_SC_INFOBOXITEM );?>]">
          <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true" data-template="[<?php echo esc_attr( CS_SC_INFOBOX );?> {{attributes}}]">
            <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){cs_shortcode_element_size();}?>
            
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Info Style','uoc');?></label>
          </li>
          <li class="to-field">
              <div class="select-style"> 
                <select class="table_style" name="cs_infobox_view_style[]">
                  <option value="simple" <?php if($cs_infobox_view_style == 'simple'){echo 'selected="selected"'; }?>><?php _e('Simple Style','uoc');?></option>
                  <option value="border_view" <?php  if($cs_infobox_view_style == 'border_view'){echo 'selected="selected"'; }?>><?php _e('Border style','uoc');?></option>
                </select>
            </div>
            
              <div class='left-info'><p><?php _e('Select contact us  style','uoc');?></p></div>
          </li>
        </ul>
          
          <ul class="form-elements">
            <li class="to-label">
                <label><?php _e('Section Title','uoc');?></label>
              </li>
              <li class="to-field">
                <input  name="cs_infobox_section_title[]" type="text"  value="<?php echo cs_allow_special_char($cs_infobox_section_title);?>"   />
                <p><?php _e('This is used for the one page navigation, to identify the section below. Give a title','uoc');?>  </p>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label><?php _e('Title','uoc');?></label>
              </li>
              <li class="to-field">
                <input type="text" name="cs_infobox_title[]" class="txtfield" value="<?php echo cs_allow_special_char($cs_infobox_title);?>" />
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label><?php _e('Background Color','uoc');?></label>
              </li>
              <li class="to-field">
                <input type="text" name="cs_infobox_bg_color[]" class="bg_color" value="<?php echo esc_attr($cs_infobox_bg_color);?>" />
                <div class="left-box">
                    <p><?php _e('Provide a hex background colour code here (with #)','uoc');?></p>
                </div>
              </li>
            </ul>
            <ul class='form-elements'>
              <li class='to-label'>
                <label><?php _e('Text Color','uoc');?></label>
              </li>
              <li class='to-field'>
                <div class='input-sec'>
                  <input class='bg_color' type='text' name='cs_infobox_list_text_color[]' value="<?php echo esc_attr($cs_infobox_list_text_color); ?>" />
                  <div class="left-box">
                      <p><?php _e('Provide a hex colour code here (with #) if you want to override the default','uoc');?> </p>
                  </div>
                </div>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label><?php _e('Class','uoc');?></label>
              </li>
              <li class="to-field">
                <input type="text" name="cs_infobox_class[]" class="txtfield"  value="<?php echo esc_attr($cs_infobox_class)?>" />
                <p><?php _e('Use this option if you want to use specified id for this element','uoc');?></p>
              </li>
            </ul>
            
          </div>
          <?php
          if ( isset($info_list_num) && $info_list_num <> '' && isset($atts_content) && is_array($atts_content)){
                            
            foreach ( $atts_content as $infobox_item ){
                
                $rand_id = $cs_counter.''.cs_generate_random_string(3);
                $cs_infobox_list_description = $infobox_item['content'];
                $defaults = array('cs_infobox_list_icon'=>'','cs_infobox_list_color'=>'','cs_infobox_list_title'=>'');
                foreach($defaults as $key=>$values){
                    if(isset($infobox_item['atts'][$key]))
                        $$key = $infobox_item['atts'][$key];
                    else 
                        $$key =$values;
                 }
            ?>
          <div class='cs-wrapp-clone cs-shortcode-wrapp'  id="cs_infobox_<?php echo cs_allow_special_char($rand_id);?>">
            <header>
              <h4><i class='icon-arrows'></i><?php _e('Info box Item(s)','uoc');?></h4>
              <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php _e('Remove','uoc');?></a></header>
            <ul class='form-elements'>
              <li class='to-label'>
                <label><?php _e('Info Box Fontawsome Icon','uoc');?></label>
              </li>
             <li class="to-field">
                <?php cs_fontawsome_icons_box($cs_infobox_list_icon,$rand_id,'cs_infobox_list_icon');?>
              </li>
            </ul>
            <ul class='form-elements'>
              <li class='to-label'>
                <label><?php _e('Icon Color','uoc');?></label>
              </li>
              <li class='to-field'>
                <div class='input-sec'>
                  <input class='bg_color' type='text' name='cs_infobox_list_color[]' value="<?php echo cs_allow_special_char($cs_infobox_list_color); ?>" />
                </div>
              </li>
            </ul>
            <ul class='form-elements'>
              <li class='to-label'>
                <label><?php _e('Title','uoc');?></label>
              </li>
              <li class='to-field'>
                <div class='input-sec'>
                  <input class='txtfield' type='text' name='cs_infobox_list_title[]' value="<?php echo cs_allow_special_char($cs_infobox_list_title); ?>" />
                </div>
              </li>
            </ul>
            <ul class='form-elements'>
              <li class='to-label'>
                <label><?php _e('Short Description','uoc');?></label>
              </li>
              <li class='to-field'>
                <div class='input-sec'>
                  <textarea name='cs_infobox_list_description[]' rows="8" cols="20" data-content-text="cs-shortcode-textarea"><?php echo cs_allow_special_char($cs_infobox_list_description);?></textarea>
                </div>
              </li>
            </ul>
          </div>
          <?php
                }
            }
        ?>
        </div>
        <div class="hidden-object">
          <input type="hidden" name="info_list_num[]" value="<?php echo (int)$info_list_num;?>" class="fieldCounter"  />
        </div>
        <div class="wrapptabbox" style="padding:0">
          <div class="opt-conts">
            <ul class="form-elements noborder">
              <li class="to-field"> <a href="#" class="add_servicesss cs-main-btn" onclick="cs_shortcode_element_ajax_call('infobox_items', 'shortcode-item-<?php echo cs_allow_special_char($cs_counter);?>', '<?php echo cs_allow_special_char(admin_url('admin-ajax.php'));?>')"><i class="icon-plus-circle"></i><?php _e('Add Item','uoc');?></a> </li>
               <div id="loading" class="shortcodeload"></div>
            </ul>
            <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
            <ul class="form-elements insert-bg">
              <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js(str_replace('cs_pb_','',$name));?>','shortcode-item-<?php echo cs_allow_special_char($cs_counter);?>','<?php echo cs_allow_special_char($filter_element);?>')" ><?php _e('Insert','uoc');?></a> </li>
            </ul>
            <div id="results-shortocde"></div>
            <?php } else {?>
            <ul class="form-elements noborder">
              <li class="to-label"></li>
              <li class="to-field">
                <input type="hidden" name="cs_orderby[]" value="infobox" />
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
    add_action('wp_ajax_cs_pb_infobox', 'cs_pb_infobox');
}
?>