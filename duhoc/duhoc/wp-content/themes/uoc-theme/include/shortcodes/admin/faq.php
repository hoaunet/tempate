<?php
/*
 *
 *@Shortcode Name : FAQ
 *@retrun
 *
 */

if ( ! function_exists( 'cs_pb_faq' ) ) {
    function cs_pb_faq($die = 0){
        global $cs_node, $count_node, $post;
        
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $cs_counter = $_POST['counter'];
        $PREFIX = CS_SC_FAQ.'|'.CS_SC_FAQITEM;
        $parseObject     = new ShortcodeParse();
        $accordion_num = 0;
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
		'class' => 'cs-faq',
		'faq_class' => '',
		'cs_faq_section_title'=>'',
		'cs_faq_view'=> 'simple'
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
            $faq_num = count($atts_content);
            
        $faq_element_size = '50';
        foreach($defaults as $key=>$values){
            if(isset($atts[$key]))
                $$key = $atts[$key];
            else 
                $$key =$values;
         }
        $name = 'cs_pb_faq';
        $coloumn_class = 'column_'.$faq_element_size;
        
        if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
    ?>
<div id="<?php echo esc_attr($name.$cs_counter)?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="faq" data="<?php echo cs_element_size_data_array_index($faq_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$faq_element_size,'','question-circle');?>
  <div class="cs-wrapp-class-<?php echo esc_attr($cs_counter)?> <?php echo cs_allow_special_char($shortcode_element);?>" id="<?php echo cs_allow_special_char($name.$cs_counter)?>" data-shortcode-template="[<?php echo esc_attr( CS_SC_FAQ ) ;?> {{attributes}}]" style="display: none;">
    <div class="cs-heading-area">
      <h5><?php _e('Edit Faq Options','uoc');?></h5>
      <a href="javascript:removeoverlay('<?php echo cs_allow_special_char($name.$cs_counter);?>','<?php echo cs_allow_special_char($filter_element);?>')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
      <div class="cs-clone-append cs-pbwp-content">
       <div class="cs-wrapp-tab-box">
        <div id="shortcode-item-<?php echo esc_attr($cs_counter);?>" data-shortcode-template="{{child_shortcode}}[/<?php echo esc_attr( CS_SC_FAQ ) ;?>]" data-shortcode-child-template="[<?php echo esc_attr( CS_SC_FAQITEM ) ;?> {{attributes}}] {{content}} [/<?php echo esc_attr( CS_SC_FAQITEM ) ;?>]">
          <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true cs-pbwp-content" data-template="[<?php echo esc_attr( CS_SC_FAQ ) ;?> {{attributes}}]">
            <ul class="form-elements">
              <li class="to-label">
                <label><?php _e('Section Title','uoc');?></label>
              </li>
              <li class="to-field">
                <input  name="cs_faq_section_title[]" type="text"  value="<?php echo cs_allow_special_char($cs_faq_section_title)?>"   />
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label><?php _e('Style','uoc');?></label>
              </li>
              <li class="to-field">
 
			<select name='cs_faq_view[]' class='dropdown'>
                <option value='simple' <?php if($cs_faq_view == 'simple'){echo 'selected';}?>><?php _e('Simple','uoc');?></option>
                <option value='modern' <?php if($cs_faq_view == 'modern'){echo 'selected';}?>><?php _e('Modern','uoc');?></option>
                <option value='list' <?php if($cs_faq_view == 'list'){echo 'selected';}?>><?php _e('List','uoc');?></option>
                </select>   </li>
            </ul>
            <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){cs_shortcode_element_size();}?>
            <ul class="form-elements">
              <li class="to-label">
                <label><?php _e('Custom Id','uoc');?></label>
              </li>
              <li class="to-field">
                <input type="text" name="faq_class[]" class="txtfield"  value="<?php echo cs_allow_special_char($faq_class);?>" />
              </li>
            </ul>
            
          </div>
          <?php
            if ( isset($faq_num) && $faq_num <> '' && isset($atts_content) && is_array($atts_content)){
                foreach ( $atts_content as $faq ){
                    $rand_id = rand(13543544, 91112430);
                    $faq_text = $faq['content'];
                    $defaults = array( 'faq_title' => 'Title','faq_active' => 'yes','cs_faq_icon' => '');
                    foreach($defaults as $key=>$values){
                        if(isset($faq['atts'][$key]))
                            $$key = $faq['atts'][$key];
                        else 
                            $$key =$values;
                     }
                    
                    if ( $faq_active == "yes" ) 
                    {
                        $faq_active = "selected"; 
                    } else { 
                        $faq_active = ""; 
                    }
                    ?>
          <div class='cs-wrapp-clone cs-shortcode-wrapp  cs-pbwp-content'  id="cs_infobox_<?php echo esc_attr($rand_id);?>">
            <header>
              <h4><i class='icon-arrows'></i><?php _e('FAQ','uoc');?></h4>
              <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php _e('Remove','uoc');?></a>
            </header>
            <ul class='form-elements'>
              <li class='to-label'>
                <label><?php _e('Active','uoc');?></label>
              </li>
              <li class='to-field select-style'>
                <select name='faq_active[]'>
                  <option value="no" ><?php _e('No','uoc');?></option>
                  <option value="yes" <?php echo esc_attr($faq_active);?>><?php _e('Yes','uoc');?></option>
                </select>
              </li>
            </ul>
            <ul class='form-elements'>
              <li class='to-label'>
                <label><?php _e('Faq Title','uoc');?></label>
              </li>
              <li class='to-field'>
                <div class='input-sec'>
                  <input class='txtfield' type='text' name='faq_title[]' value="<?php echo cs_allow_special_char($faq_title);?>" />
                </div>
              </li>
            </ul>
            <!--<ul class='form-elements' id="cs_infobox_<?php //echo esc_attr($rand_id);?>">
              <li class='to-label'>
                <label><?php //_e('Title Fontawsome Icon','uoc');?></label>
              </li>
              <li class="to-field">
                <?php //cs_fontawsome_icons_box($cs_faq_icon,$rand_id,'cs_faq_icon');?>
              </li>
            </ul>-->
            <ul class='form-elements'>
              <li class='to-label'>
                <label><?php _e('Faq Text','uoc');?></label>
              </li>
              <li class='to-field'>
                <div class='input-sec'>
                  <textarea class='txtfield' data-content-text="cs-shortcode-textarea" name='faq_text[]'><?php echo htmlspecialchars(esc_textarea($faq_text));?></textarea>
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
          <input type="hidden" name="faq_num[]" value="<?php echo (int)$faq_num?>" class="fieldCounter"  />
        </div>
        <div class="wrapptabbox">
          <div class="opt-conts">
            <ul class="form-elements">
              <li class="to-field"> <a href="#" class="add_servicesss cs-main-btn" onclick="cs_shortcode_element_ajax_call('faq', 'shortcode-item-<?php echo esc_js($cs_counter);?>', '<?php echo esc_js(admin_url('admin-ajax.php'));?>')"><i class="icon-plus-circle"></i><?php _e('Add Faq','uoc');?></a> </li>
               <div id="loading" class="shortcodeload"></div>
            </ul>
            <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
            <ul class="form-elements insert-bg noborder">
              <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js(str_replace('cs_pb_','',$name));?>','shortcode-item-<?php echo esc_js($cs_counter);?>','<?php echo esc_js($filter_element);?>')" ><?php _e('Insert','uoc');?></a> </li>
            </ul>
            <div id="results-shortocde"></div>
            <?php } else {?>
            <ul class="form-elements noborder">
              <li class="to-label"></li>
              <li class="to-field">
                <input type="hidden" name="cs_orderby[]" value="faq" />
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
    add_action('wp_ajax_cs_pb_faq', 'cs_pb_faq');
}
?>