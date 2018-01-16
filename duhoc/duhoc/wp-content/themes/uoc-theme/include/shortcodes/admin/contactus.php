<?php
/*
 *
 *@Shortcode Name : Contact us
 *@retrun
 *
 */
if ( ! function_exists( 'cs_pb_contactus' ) ) {
    function cs_pb_contactus($die = 0){
        global $cs_node, $post;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $counter = $_POST['counter'];
        $cs_counter = $_POST['counter'];
        if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes ($shortcode_element_id);
            $PREFIX = CS_SC_CONTACTUS;
            $parseObject     = new ShortcodeParse();
            $output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
        }
        $defaults = array( 
		 'cs_contactus_section_title' => '',
		 'cs_contactus_label' => '', 
		 'cs_contactus_view' => '',
		 'cs_contactus_send' => '',
		 'cs_success' => '',
		 'cs_error' => '',
		 'cs_contact_class' => ''
		               );
        if(isset($output['0']['atts']))
            $atts = $output['0']['atts'];
        else 
            $atts = array();
        $contactus_element_size = '25';
        foreach($defaults as $key=>$values){
            if(isset($atts[$key]))
                $$key = $atts[$key];
            else 
                $$key =$values;
         }
        $name = 'cs_pb_contactus';
        $coloumn_class = 'column_'.$contactus_element_size;
        if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
?>
<div id="<?php echo esc_attr($name.$cs_counter)?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="contactus" data="<?php echo cs_element_size_data_array_index($contactus_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$contactus_element_size, '', 'building-o',$type='');?>
  <div class="cs-wrapp-class-<?php echo intval($cs_counter)?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo esc_attr($name.$cs_counter)?>" data-shortcode-template="[<?php echo esc_attr( CS_SC_CONTACTUS );?> {{attributes}}]" style="display: none;">
    <div class="cs-heading-area">
      <h5><?php _e('Edit Contact Form Options','uoc');?></h5>
      <a href="javascript:removeoverlay('<?php echo esc_js($name.$cs_counter)?>','<?php echo esc_js($filter_element);?>')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
    <div class="cs-pbwp-content">
      <div class="cs-wrapp-clone cs-shortcode-wrapp">
        <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){cs_shortcode_element_size();}?>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Section Title','uoc');?></label>
          </li>
          <li class="to-field">
            <input  name="cs_contactus_section_title[]" type="text"  value="<?php echo cs_allow_special_char($cs_contactus_section_title);?>"   />
            <p> <?php _e('This is used for the one page navigation, to identify the section below. Give a title','uoc');?></p>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('View','uoc');?></label>
          </li>
          <li class="to-field select-style">
            <select class="cs_contactus_view" id="cs_contactus_view" name="cs_contactus_view[]">
              <option <?php if($cs_contactus_view == "plain")echo "selected";?> value="plain"><?php _e('Plain','uoc');?></option>
             <!-- <option <?php //if($cs_contactus_view == "fancy")echo "selected";?> value="fancy"><?php //_e('Fancy','uoc');?></option>-->
            </select>
          </li>
        </ul>
        <!--<ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Label On/Off','uoc');?></label>
          </li>
          <li class="to-field select-style">
            <select class="cs_contactus_label" id="cs_contactus_label" name="cs_contactus_label[]">
              <option <?php if($cs_contactus_label == "on")echo "selected";?> value="on"><?php _e('On','uoc');?></option>
              <option <?php if($cs_contactus_label == "off")echo "selected";?> value="off"><?php _e('Off','uoc');?></option>
            </select>
          </li>
        </ul>-->
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Send To','uoc');?></label>
          </li>
          <li class="to-field">
            <input type="text" name="cs_contactus_send[]" class="txtfield" value="<?php echo esc_attr($cs_contactus_send);?>" />
            <p><?php _e('add a email which you want to receive email','uoc');?></p>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Success Message','uoc');?></label>
          </li>
          <li class="to-field">
            <input type="text" name="cs_success[]" class="txtfield" value="<?php echo esc_attr($cs_success);?>" />
            <p><?php _e('set a message if your email sent successfully','uoc');?> </p>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Error Message','uoc');?></label>
          </li>
          <li class="to-field">
            <input type="text" name="cs_error[]" class="txtfield" value="<?php echo esc_attr($cs_error);?>" />
            <p><?php _e('set a message for error message','uoc');?></p>
          </li>
        </ul>
        <!--<input type="hidden" name="cs_form_id[]" class="txtfield" value="<?php echo esc_attr($random_id);?>" />-->
        
      </div>
      <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
      <ul class="form-elements insert-bg">
        <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo str_replace('cs_pb_','',$name);?>','<?php echo esc_js($name.$cs_counter)?>','<?php echo esc_js($filter_element);?>')" ><?php _e('Insert','uoc');?></a> </li>
      </ul>
      <div id="results-shortocde"></div>
      <?php } else {?>
      <ul class="form-elements noborder">
        <li class="to-label"></li>
        <li class="to-field">
          <input type="hidden" name="cs_orderby[]" value="contactus" />
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
    add_action('wp_ajax_cs_pb_contactus', 'cs_pb_contactus');
}