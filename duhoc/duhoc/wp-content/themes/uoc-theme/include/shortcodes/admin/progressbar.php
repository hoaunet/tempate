<?php
/*
 *
 *@Shortcode Name : Progressbar
 *@retrun
 *
 */

if ( ! function_exists( 'cs_pb_progressbars' ) ) {
    function cs_pb_progressbars($die = 0){
        global $cs_node, $cs_count_node, $post;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $cs_counter = $_POST['counter'];
        $PREFIX = CS_SC_PROGRESSBAR.'|'.CS_SC_PROGRESSBARITEM;
        $parseObject     = new ShortcodeParse();
        $progressbars_num = 0;
        if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes ($shortcode_element_id);
            $output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
        }
        
        $defaults = array('column_size'=>'1/1','section_title'=>'','cs_progressbars_style'=>'skills-sec','progressbars_class'=>'');
        
        if(isset($output['0']['atts']))
            $atts = $output['0']['atts'];
        else 
            $atts = array();
        
        if(isset($output['0']['content']))
            $atts_content = $output['0']['content'];
        else 
            $atts_content = array();
        
        if(is_array($atts_content))
            $progressbars_num = count($atts_content);
            
        $progressbars_element_size = '25';
        foreach($defaults as $key=>$values){
            if(isset($atts[$key]))
                $$key = $atts[$key];
            else 
                $$key =$values;
         }
        $name = 'cs_pb_progressbars';
        $coloumn_class = 'column_'.$progressbars_element_size;
        
        if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
    ?>
<div id="<?php echo esc_attr($name.$cs_counter);?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="gallery" data="<?php echo cs_element_size_data_array_index($progressbars_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$progressbars_element_size,'','list-alt');?>
  <div class="cs-wrapp-class-<?php echo esc_attr($cs_counter)?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo esc_attr($name.$cs_counter);?>" style="display: none;">
    <div class="cs-heading-area">
      <h5><?php _e('Edit Progress bars Options','uoc');?></h5>
      <a href="javascript:removeoverlay('<?php echo esc_js($name.$cs_counter);?>','<?php echo esc_js($filter_element);?>')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
      <div class="cs-clone-append cs-pbwp-content" >
      <div class="cs-wrapp-tab-box">
        <div id="shortcode-item-<?php echo esc_attr($cs_counter);?>" data-shortcode-template="{{child_shortcode}} [/<?php echo esc_attr( CS_SC_PROGRESSBAR ) ;?>]" data-shortcode-child-template="[<?php echo esc_attr( CS_SC_PROGRESSBARITEM ) ;?> {{attributes}}] {{content}} [/<?php echo esc_attr( CS_SC_PROGRESSBARITEM ) ;?>]">
          <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true cs-pbwp-content" data-template="[<?php echo esc_attr( CS_SC_PROGRESSBAR ) ;?> {{attributes}}]">
            <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){cs_shortcode_element_size();}?>
            <ul class="form-elements" style="display:none">
              <li class="to-label">
                <label><?php _e('Progress Bars Style','uoc');?></label>
              </li>
              <li class="to-field select-style">
                <select class="cs_progressbars_style" name="cs_progressbars_style[]">
                 <option value="plain-progressbar" <?php if($cs_progressbars_style=='plain-progressbar'){echo 'selected="selected"';}?>><?php _e('Plain Progress bar','uoc');?></option>
                  <option value="round-strip-progressbar" <?php if($cs_progressbars_style=='round-strip-progressbar'){echo 'selected="selected"';}?>><?php _e('Strip Progress bar','uoc');?></option>
                  <option value="strip-progressbar" <?php if($cs_progressbars_style=='strip-progressbar'){echo 'selected="selected"';}?>><?php _e('Pattern Progress bar','uoc');?></option>
                 
                </select>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label><?php _e('Section Title','uoc');?></label>
              </li>
              <li class="to-field">
                <input type="text" name="section_title[]" class="txtfield"  value="<?php echo esc_attr($section_title)?>" />
                
              </li>
            </ul>
            
            <ul class="form-elements">
              <li class="to-label">
                <label><?php _e('Custom Id','uoc');?></label>
              </li>
              <li class="to-field">
                <input type="text" name="progressbars_class[]" class="txtfield"  value="<?php echo esc_attr($progressbars_class)?>" />
                <div class='left-info'><p><?php _e('Use this option if you want to use specified id for this element','uoc');?></p></div>
              </li>
            </ul>
            
          </div>
       <?php
        if ( isset($progressbars_num) && $progressbars_num <> '' && isset($atts_content) && is_array($atts_content)){
            foreach ( $atts_content as $progressbars ){
                $rand_id = $cs_counter.''.cs_generate_random_string(3);
                $defaults = array('progressbars_title'=>'','progressbars_color'=>'#4d8b0c','progressbars_percentage'=>'50');
                foreach($defaults as $key=>$values){
                    if(isset($progressbars['atts'][$key]))
                        $$key = $progressbars['atts'][$key];
                    else 
                        $$key =$values;
                 }
          echo '<div class="cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content" id="cs_infobox_'.$rand_id.'">'; ?>
            <header>
              <h4><i class='icon-arrows'></i><?php _e('Progress Bar','uoc');?></h4>
              <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php _e('Remove','uoc');?></a></header>
            <ul class="form-elements">
              <li class="to-label">
                <label><?php _e('Progress Bars Title','uoc');?></label>
              </li>
              <li class="to-field">
                <input type="text" name="progressbars_title[]" class="txtfield" value="<?php echo cs_allow_special_char($progressbars_title)?>" />
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label><?php _e('Skill (in percentage)','uoc');?></label>
              </li>
              <li class="to-field">
                <div class="cs-drag-slider" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="<?php echo esc_attr($progressbars_percentage)?>"></div>
                <input  class="cs-range-input"  name="progressbars_percentage[]" type="text" value="<?php echo esc_attr($progressbars_percentage)?>"   />
                <div class='left-info'><p><?php _e('Set the Skill (In %)','uoc');?></p></div>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label><?php _e('Progress Bars Color','uoc');?></label>
              </li>

              <li class="to-field">
                <input type="text" name="progressbars_color[]" class="bg_color" value="<?php echo balanceTags($progressbars_color) ?>" />
              </li>
            </ul>
          </div>
          <?php
            }
        }
        ?>
        </div>
        <div class="hidden-object">
          <input type="hidden" name="progressbars_num[]" value="<?php echo esc_attr($progressbars_num)?>" class="fieldCounter"/>
        </div>
        <div class="wrapptabbox" style="padding:0">
          <div class="opt-conts">
            <ul class="form-elements noborder">
              <li class="to-field"> <a href="#" class="add_servicesss cs-main-btn" onclick="cs_shortcode_element_ajax_call('progressbars', 'shortcode-item-<?php echo esc_js($cs_counter);?>', '<?php echo esc_js(admin_url('admin-ajax.php'));?>')"><i class="icon-plus-circle"></i><?php _e('Add Progress bar','uoc');?></a> </li>
               <div id="loading" class="shortcodeload"></div>
            </ul>
            <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
            <ul class="form-elements insert-bg">
              <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js(str_replace('cs_pb_','',$name));?>','shortcode-item-<?php echo esc_js($cs_counter);?>','<?php echo esc_js($filter_element);?>')" ><?php _e('Insert','uoc');?></a> </li>
            </ul>
            <div id="results-shortocde"></div>
            <?php } else {?>
            <ul class="form-elements noborder">
              <li class="to-label"></li>
              <li class="to-field">
                <input type="hidden" name="cs_orderby[]" value="progressbars" />
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
    add_action('wp_ajax_cs_pb_progressbars', 'cs_pb_progressbars');
}

?>