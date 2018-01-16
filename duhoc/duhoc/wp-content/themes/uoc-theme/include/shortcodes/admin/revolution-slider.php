<?php
//=====================================================================
// Slider Shortcode Builder start
//=====================================================================
if ( ! function_exists( 'cs_pb_slider' ) ) {
    function cs_pb_slider($die = 0){
        global $cs_node, $post;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $counter = $_POST['counter'];
        $cs_counter = $_POST['counter'];
        $image_num = 0;
        if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes ($shortcode_element_id);
            $PREFIX = CS_SC_SLIDER;
            $parseObject = new ShortcodeParse();
            $output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
        }
            global $cs_node, $cs_counter_node;
            $defaults = array(
			'column_size' => '1/1',
			'cs_slider_header_title'=>'', 
			'cs_slider'=>'', 
			'cs_slider_id'=>''
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
                $slider_num = count($atts_content);
            
            $slider_element_size = '25';
            
            foreach($defaults as $key=>$values){
                if(isset($atts[$key]))
                    $$key = $atts[$key];
                else 
                    $$key =$values;
             }
            $name = 'cs_pb_slider';
            $coloumn_class = 'column_'.$slider_element_size;
        if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
    ?>
<div id="<?php echo esc_attr($name.$cs_counter)?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="slider" data="<?php echo cs_element_size_data_array_index($slider_element_size)?>">
  <?php cs_element_setting($name,$cs_counter,$slider_element_size,'','picture-o');?>
  <div class="cs-wrapp-class-<?php echo intval($cs_counter)?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo esc_attr($name.$cs_counter)?>" data-shortcode-template="[<?php echo esc_attr( CS_SC_SLIDER ) ;?> {{attributes}}]" style="display: none;">
    <div class="cs-heading-area">
      <h5><?php _e('Edit Slider Options','uoc');?></h5>
      <a href="javascript:removeoverlay('<?php echo esc_js($name.$cs_counter)?>','<?php echo esc_js($filter_element);?>')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
    <div class="cs-pbwp-content">
      <div class="cs-wrapp-clone cs-shortcode-wrapp">
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Slider Section Title','uoc');?></label>
          </li>
          <li class="to-field">
            <div class="input-sec">
              <input type="text" name="cs_slider_header_title[]" class="txtfield" value="<?php echo cs_allow_special_char(htmlspecialchars($cs_slider_header_title));?>" />
            </div>
            <div class="left-info">
              <p><?php _e('Please enter slider header title.','uoc');?></p>
            </div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Choose Slider','uoc');?></label>
          </li>
          <li class="to-field">
            <div class="input-sec">
              <div class="select-style">
                <select name="cs_slider_id[]" id="cs_slider_id<?php echo intval($cs_counter)?>" class="dropdown">
            
                    <?php
                       if(class_exists('RevSlider') && class_exists('cs_RevSlider')) {
                            $slider = new cs_RevSlider();
                            $arrSliders = $slider->getAllSliderAliases();
						 
                            foreach ( $arrSliders as $key => $entry ) {
                                ?>
                                <option <?php cs_selected($entry['title'],$entry['alias']) ?> value="<?php echo cs_allow_special_char($entry['alias']);?>"><?php echo cs_allow_special_char($entry['title']) ;?></option>
                                <?php
                            }
                        } 
                    ?>
                </select>
              </div>
            </div>
          </li>
        </ul>
        
      </div>
      <script>
            var cs_slider_type    = jQuery( "#cs_slider_type<?php echo esc_js($cs_counter);?>" ).val();
            cs_toggle_height(cs_slider_type,'<?php echo esc_js($cs_counter)?>');
        </script>
      <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
      <ul class="form-elements insert-bg">
        <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js(str_replace('cs_pb_','',$name));?>','<?php echo esc_js($name.$cs_counter)?>','<?php echo esc_js($filter_element);?>')" ><?php _e('Insert','uoc');?></a> </li>
      </ul>
      <div id="results-shortocde"></div>
      <?php } else {?>
      <ul class="form-elements noborder">
        <li class="to-label"></li>
        <li class="to-field">
          <input type="hidden" name="cs_orderby[]" value="slider" />
          <input type="button" value="<?php _e('Save','uoc');?>" style="margin-right:10px;" onclick="javascript:_removerlay(jQuery(this))"/>
        </li>
      </ul>
      <?php }?>
    </div>
  </div>
</div>
<?php
        if ( $die <> 1 ) die();
    }
    add_action('wp_ajax_cs_pb_slider', 'cs_pb_slider');
}