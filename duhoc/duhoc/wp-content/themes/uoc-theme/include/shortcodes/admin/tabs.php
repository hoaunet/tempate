<?php
/*
 *
 *@Shortcode Name : Tabs
 *@retrun
 *
 */

if ( ! function_exists( 'cs_pb_tabs' ) ) {
    function cs_pb_tabs($die = 0){
        global $cs_node, $count_node, $post;
        
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $cs_counter = $_POST['counter'];
        $tabs_num = 0;
        if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes ($shortcode_element_id);
            $PREFIX = CS_SC_TABS.'|'.CS_SC_TABSITEM;
            $parseObject     = new ShortcodeParse();
            $output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
        }
        $defaults = array('cs_tab_style' => '','cs_tab_class' => '','cs_tabs_class' => '','column_size'=>'1/1','cs_tabs_section_title' => '');
        if(isset($output['0']['atts']))
            $atts = $output['0']['atts'];
        else 
            $atts = array();
        
        if(isset($output['0']['content']))
            $atts_content = $output['0']['content'];
        else 
            $atts_content = array();
        
        if(is_array($atts_content))
                $tabs_num = count($atts_content);
        
        $tabs_element_size = '25';
        
        foreach($defaults as $key=>$values){
            if(isset($atts[$key]))
                $$key = $atts[$key];
            else 
                $$key =$values;
         }
        
        $name = 'cs_pb_tabs';
        $coloumn_class = 'column_'.$tabs_element_size;
        if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }

    ?>
<div id="<?php echo cs_allow_special_char($name.$cs_counter)?>_del" class="column  parentdelete <?php echo cs_allow_special_char($coloumn_class);?> <?php echo cs_allow_special_char($shortcode_view);?>" item="gallery" data="<?php echo cs_element_size_data_array_index($tabs_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$tabs_element_size,'','list-alt');?>
  <div class="cs-wrapp-class-<?php echo cs_allow_special_char($cs_counter)?> <?php echo cs_allow_special_char($shortcode_element);?>" id="<?php echo cs_allow_special_char($name.$cs_counter)?>" style="display: none;">
    <div class="cs-heading-area">
      <h5><?php _e('Edit Tabs Options','uoc');?></h5>
      <a href="javascript:removeoverlay('<?php echo cs_allow_special_char($name.$cs_counter)?>','<?php echo cs_allow_special_char($filter_element);?>')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
      <div class="cs-clone-append cs-pbwp-content" >
      <div class="cs-wrapp-tab-box">
        <div id="shortcode-item-<?php echo cs_allow_special_char($cs_counter);?>" data-shortcode-template="{{child_shortcode}} [/<?php echo CS_SC_TABS;?>]" data-shortcode-child-template="[<?php echo CS_SC_TABSITEM;?> {{attributes}}] {{content}} [/<?php echo CS_SC_TABSITEM;?>]">
          <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true cs-pbwp-content" data-template="[<?php echo CS_SC_TABS;?> {{attributes}}]">
            <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){cs_shortcode_element_size();}?>
            <ul class="form-elements">
              <li class="to-label">
                <label><?php _e('Section Title','uoc');?></label>
              </li>
              <li class="to-field">
                <input name="cs_tabs_section_title[]" type="text"  value="<?php echo cs_allow_special_char($cs_tabs_section_title)?>"   />
                <div class='left-info'>
                  <p> <?php _e('This is used for the one page navigation, to identify the section below. Give a title','uoc');?> </p>
                </div>
              </li>
            </ul>
            
           
          </div>
          <?php
            if ( isset($tabs_num) && $tabs_num <> '' && isset($atts_content) && is_array($atts_content)){
            
                foreach ( $atts_content as $tabs ){
                    $rand_id = rand(13543544, 91112430);
                    $tabs_text = $tabs['content'];
                    $defaults = array(  
                        'cs_tab_icon' => '',
                        'tab_title' => '',
                        'cs_tab_icon' => '',
                        'tab_active' => 'no' 
                    );
                    foreach($defaults as $key=>$values){
                        if(isset($tabs['atts'][$key]))
                            $$key = $tabs['atts'][$key];
                        else 
                            $$key =$values;
                     }
                    ?>
          <div class='cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content'  id="cs_infobox_<?php echo cs_allow_special_char($rand_id);?>">
            <header>
              <h4><i class='icon-arrows'></i><?php _e('Tab','uoc');?></h4>
              <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php _e('Remove','uoc');?></a></header>
            
            
            <ul class='form-elements'>
              <li class='to-label'>
                <label><?php _e('Active','uoc');?></label>
              </li>
              <li class='to-field'>
                <div class="select-style">
                  <select name='tab_active[]'>
                    <option <?php if(isset($tab_active) and $tab_active == 'no') echo 'selected'; ?> value="no"><?php _e('No','uoc');?></option>
                    <option <?php if(isset($tab_active) and $tab_active == 'yes') echo 'selected'; ?> value="yes"><?php _e('Yes','uoc');?></option>
                  </select>
                  <div class='left-info'>
                    <p><?php _e('You can set the section that is active here by select dropdown','uoc');?></p>
                  </div>
                </div>
              </li>
            </ul>
            
            <ul class='form-elements'>
              <li class='to-label'>
                <label><?php _e('Tab Title','uoc');?></label>
              </li>
              <li class='to-field'>
                <div class='input-sec'>
                  <input class='txtfield' type='text' name='tab_title[]'  value="<?php echo cs_allow_special_char($tab_title);?>"/>
                </div>
              </li>
            </ul>
            <ul class='form-elements'>
              <li class='to-label'>
                <label><?php _e('Tab Text','uoc');?></label>
              </li>
              <li class='to-field'>
                <div class='input-sec'>
                  <textarea class='txtfield' data-content-text="cs-shortcode-textarea" name='tab_text[]'><?php echo cs_allow_special_char($tabs_text);?></textarea>
                </div>
                <div class='left-info'>
                  <p><?php _e('Enter tab body content here','uoc');?></p>
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
          <input type="hidden" name="tabs_num[]" value="<?php echo cs_allow_special_char($tabs_num)?>" class="fieldCounter"  />
        </div>
        <div class="wrapptabbox">
          <div class="opt-conts">
            <ul class="form-elements noborder">
              <li class="to-field"> <a href="#" class="add_servicesss cs-main-btn" onclick="cs_shortcode_element_ajax_call('tabs', 'shortcode-item-<?php echo cs_allow_special_char($cs_counter);?>', '<?php echo cs_allow_special_char(admin_url('admin-ajax.php'));?>')"><i class="icon-plus-circle"></i><?php _e('Add Tab','uoc');?></a> </li>
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
                <input type="hidden" name="cs_orderby[]" value="tabs" />
                <input type="button" value="<?php _e('Save','uoc');?>" style="margin-right:10px;"  onclick="javascript:_removerlay(jQuery(this))"  />
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
    add_action('wp_ajax_cs_pb_tabs', 'cs_pb_tabs');
}
?>