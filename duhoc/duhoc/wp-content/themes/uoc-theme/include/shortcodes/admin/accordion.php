<?php
/*
 *
 *@Shortcode Name : Button
 *@retrun
 *
 */

if ( ! function_exists( 'cs_pb_accordion' ) ) {
    function cs_pb_accordion($die = 0){
        global $cs_node, $count_node, $post;
        
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $cs_counter = $_POST['counter'];
        $PREFIX = CS_SC_ACCORDION.'|'.CS_SC_ACCORDIONITEM;
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
		'column_size'=>'1/2', 
		'class' => 'cs-accrodian',
		'accordian_style' => '',
		'accordion_class' => '',
		'accordion_animation' => '',
		'cs_accordian_section_title'=>''
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
            $accordion_num = count($atts_content);
            
        $accordion_element_size = '50';
        foreach($defaults as $key=>$values){
            if(isset($atts[$key]))
                $$key = $atts[$key];
            else 
                $$key =$values;
         }
        $name = 'cs_pb_accordion';
        $coloumn_class = 'column_'.$accordion_element_size;
        
        if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
    ?>
<div id="<?php echo cs_allow_special_char($name.$cs_counter)?>_del" class="column  parentdelete <?php echo cs_allow_special_char($coloumn_class);?> <?php echo cs_allow_special_char($shortcode_view);?>" item="blog" data="<?php echo cs_element_size_data_array_index($accordion_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$accordion_element_size,'','list-ul');?>
  <div class="cs-wrapp-class-<?php echo cs_allow_special_char($cs_counter)?> <?php echo cs_allow_special_char($shortcode_element);?>" id="<?php echo cs_allow_special_char($name.$cs_counter)?>" data-shortcode-template="[<?php echo esc_attr( CS_SC_ACCORDION ) ;?> {{attributes}}]" style="display: none;">
    <div class="cs-heading-area">
      <h5>Edit Accordion Options</h5>
      <a href="javascript:removeoverlay('<?php echo cs_allow_special_char($name.$cs_counter)?>','<?php echo cs_allow_special_char($filter_element);?>')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
      <div class="cs-clone-append cs-pbwp-content">
       <div class="cs-wrapp-tab-box">
        <div id="shortcode-item-<?php echo cs_allow_special_char($cs_counter);?>" data-shortcode-template="{{child_shortcode}}[/<?php echo esc_attr( CS_SC_ACCORDION ) ;?>]" data-shortcode-child-template="[<?php echo esc_attr( CS_SC_ACCORDIONITEM ) ;?> {{attributes}}] {{content}} [/<?php echo esc_attr( CS_SC_ACCORDIONITEM ) ;?>]">
          <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true cs-pbwp-content" data-template="[<?php echo esc_attr( CS_SC_ACCORDION ) ;?> {{attributes}}]">
            <ul class="form-elements">
              <li class="to-label">
                <label>Section Title</label>
              </li>
              <li class="to-field">
                <div class='input-sec'><input  name="cs_accordian_section_title[]" type="text"  value="<?php echo cs_allow_special_char($cs_accordian_section_title)?>" /></div>
                <div class='left-info'>
                  <p> <?php _e('This is used for the one page navigation, to identify the section below. Give a title','uoc');?></p>
                </div>
              </li>
            </ul>
            <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){cs_shortcode_element_size();}?>
            <ul class='form-elements'>
              <li class='to-label'>
                <label>Style:</label>
              </li>
              <li class='to-field'>
                <div class='input-sec select-style'>
                  <select name='accordian_style[]' class='dropdown'>
                    <option value='default' <?php if($accordian_style == 'default'){echo 'selected';}?>>default</option>
                    <option value='box' <?php if($accordian_style == 'box'){echo 'selected';}?>>box</option>
                  </select>
                </div>
                <div class='left-info'>
                  <p>choose a style type for accordion element</p>
                </div>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>Custom ID</label>
              </li>
              <li class="to-field">
                <div class='input-sec'><input type="text" name="accordion_class[]" class="txtfield"  value="<?php echo cs_allow_special_char($accordion_class);?>" /></div>
                <div class='left-info'>
                  <p>Use this option if you want to use specified  id for this element</p>
                </div>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>Animation Class </label>
              </li>
              <li class="to-field select-style">
                  <div class='input-sec select-style'>
                <select class="dropdown" name="accordion_animation[]">
                  <option value="">Select Animation</option>
                  <?php 
                        $animation_array = cs_animation_style();
                        foreach($animation_array as $animation_key=>$animation_value){
                            echo '<optgroup label="'.$animation_key.'">';    
                            foreach($animation_value as $key=>$value){
                                $active_class = '';
                                if($accordion_animation == $key){$active_class = 'selected="selected"';}
                                echo '<option value="'.$key.'" '.$active_class.'>'.$value.'</option>';
                            }
                        }
                    
                     ?>
                </select>
                </div>
                <div class='left-info'>
                  <p>Select Entrance animation type from the dropdown </p>
                </div>
              </li>
            </ul>
          </div>
          <?php
            if ( isset($accordion_num) && $accordion_num <> '' && isset($atts_content) && is_array($atts_content)){
                foreach ( $atts_content as $accordion ){
                    $rand_id = $cs_counter.''.cs_generate_random_string(3);
                    $accordion_text = $accordion['content'];
                    $defaults = array( 'accordion_title' => 'Title','accordion_active' => 'yes','cs_accordian_icon' => '');
                    foreach($defaults as $key=>$values){
                        if(isset($accordion['atts'][$key]))
                            $$key = $accordion['atts'][$key];
                        else 
                            $$key =$values;
                     }
                    
                    if ( $accordion_active == "yes" ) 
                    {
                        $accordian_active = "selected"; 
                    } else { 
                        $accordian_active = ""; 
                    }
                    ?>
          <div class='cs-wrapp-clone cs-shortcode-wrapp  cs-pbwp-content'  id="cs_infobox_<?php echo cs_allow_special_char($rand_id);?>">
            <header>
              <h4><i class='icon-arrows'></i>Accordion</h4>
              <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i>Remove</a></header>
            <ul class='form-elements'>
              <li class='to-label'>
                <label>Active</label>
              </li>
              <li class='to-field select-style'>
                <div class='input-sec select-style'>
                <select name='accordion_active[]'>
                  <option value="no" >No</option>
                  <option value="yes" <?php echo esc_attr($accordian_active);?>>Yes</option>
                </select>
                </div>
                <div class='left-info'>
                  <p>You can set the section that is active here by select dropdown</p>
                </div>
              </li>
            </ul>
            <ul class='form-elements'>
              <li class='to-label'>
                <label>Accordion Title:</label>
              </li>
              <li class='to-field'>
                <div class='input-sec'>
                  <div class='input-sec'><input class='txtfield' type='text' name='accordion_title[]' value="<?php echo cs_allow_special_char($accordion_title);?>" /></div>
                  <div class='left-info'>
                    <p>Enter accordion title</p>
                  </div>
                </div>
              </li>
            </ul>
            <ul class='form-elements' id="cs_infobox_<?php echo esc_attr($rand_id);?>">
              <li class='to-label'>
                <label>Title Fontawsome Icon:</label>
              </li>
              <li class="to-field">
                <?php cs_fontawsome_icons_box($cs_accordian_icon,$rand_id,'cs_accordian_icon');?>
                <div class='left-info'>
                  <p> select the fontawsome Icons you would like to add to your menu items</p>
                </div>
              </li>
            </ul>
            <ul class='form-elements'>
              <li class='to-label'>
                <label>Accordion Text:</label>
              </li>
              <li class='to-field'>
                <div class='input-sec'>
                  <textarea class='txtfield' data-content-text="cs-shortcode-textarea" name='accordion_text[]'><?php echo cs_allow_special_char($accordion_text);?></textarea>
                  <div class='left-info'>
                    <p>Enter your content.</p>
                  </div>
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
          <input type="hidden" name="accordion_num[]" value="<?php echo cs_allow_special_char($accordion_num);?>" class="fieldCounter"  />
        </div>
        <div class="wrapptabbox">
          <div class="opt-conts">
            <ul class="form-elements noborder">
              <li class="to-field"> <a href="#" class="add_servicesss cs-main-btn" onclick="cs_shortcode_element_ajax_call('accordions', 'shortcode-item-<?php echo cs_allow_special_char($cs_counter);?>', '<?php echo cs_allow_special_char(admin_url('admin-ajax.php'));?>')"><i class="icon-plus-circle"></i>Add accordion</a> </li>
               <div id="loading" class="shortcodeload"></div>
            </ul>
            <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
            <ul class="form-elements insert-bg">
              <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js(str_replace('cs_pb_','',$name));?>','shortcode-item-<?php echo cs_allow_special_char($cs_counter);?>','<?php echo cs_allow_special_char($filter_element);?>')" >INSERT</a> </li>
            </ul>
            <div id="results-shortocde"></div>
            <?php } else {?>
            <ul class="form-elements noborder">
              <li class="to-label"></li>
              <li class="to-field">
                <input type="hidden" name="cs_orderby[]" value="accordion" />
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
    add_action('wp_ajax_cs_pb_accordion', 'cs_pb_accordion');
}
