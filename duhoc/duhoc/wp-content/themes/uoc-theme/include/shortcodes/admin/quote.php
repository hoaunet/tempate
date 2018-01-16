<?php
//=====================================================================
// quote html form for page builder start
//=====================================================================
if ( ! function_exists( 'cs_pb_quote' ) ) {
    function cs_pb_quote($die = 0){
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
            $PREFIX = CS_SC_QUOTE;
            $parseObject     = new ShortcodeParse();
            $output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
        }
        $defaults = array(
                'quote_style' => 'default',
                'cs_quote_section_title' => '',
                'quote_cite'   => '',
                'quote_cite_url'   => '#',
                'quote_text_color'   => '',
                'quote_align'   => 'center',
                'cs_quote_class'   => ''
                
            );
            if(isset($output['0']['atts']))
                $atts = $output['0']['atts'];
            else 
                $atts = array();
            if(isset($output['0']['content']))
                $quote_content = $output['0']['content'];
            else 
                $quote_content = '';
            $quote_element_size = '25';
            foreach($defaults as $key=>$values){
                if(isset($atts[$key]))
                    $$key = $atts[$key];
                else 
                    $$key =$values;
             }
            $name = 'cs_pb_quote';
            $coloumn_class = 'column_'.$quote_element_size;
        if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
    ?>
<div id="<?php echo cs_allow_special_char($name.$cs_counter)?>_del" class="column  parentdelete <?php echo cs_allow_special_char($coloumn_class);?> <?php echo cs_allow_special_char($shortcode_view);?>" item="column" data="<?php echo cs_element_size_data_array_index($quote_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$quote_element_size, '', 'quote-right',$type='');?>
  <div class="cs-wrapp-class-<?php echo intval($cs_counter)?> <?php echo cs_allow_special_char($shortcode_element);?>" id="<?php echo cs_allow_special_char($name.$cs_counter)?>"  data-shortcode-template="[<?php echo esc_attr( CS_SC_QUOTE ) ;?> {{attributes}}]{{content}}[/<?php echo esc_attr( CS_SC_QUOTE ) ;?>]" style="display: none;">
    <div class="cs-heading-area">
      <h5><?php _e('Edit Quote Options','uoc');?></h5>
      <a href="javascript:removeoverlay('<?php echo esc_js($name.$cs_counter)?>','<?php echo esc_js($filter_element);?>')"
	   class="cs-btnclose"><i class="icon-times"></i></a>
	  </div>
    <div class="cs-pbwp-content">
      <div class="cs-wrapp-clone cs-shortcode-wrapp">
        <div class="cs-pbwp-content cs-wrapp-tab-box">
          <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){cs_shortcode_element_size();}?>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php _e('Section Title','uoc');?></label>
            </li>
            <li class="to-field">
              <input  name="cs_quote_section_title[]" type="text"  value="<?php echo cs_allow_special_char($cs_quote_section_title)?>"   />
              <p><?php _e('This is used for the one page navigation, to identify the section below. Give a title','uoc');?>  </p>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php _e('Author','uoc');?></label>
            </li>
            <li class="to-field">
              <input type="text" name="quote_cite[]" class="txtfield" value="<?php echo esc_attr($quote_cite)?>" />
              <p><?php _e('give the name of the author','uoc');?></p>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php _e('Author Url','uoc');?></label>
            </li>
            <li class="to-field">
              <input type="text" name="quote_cite_url[]" class="txtfield" value="<?php echo esc_url($quote_cite_url);?>" />
              <p><?php _e('Give the Author External / Internal Url','uoc');?></p>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php _e('Text Color','uoc');?></label>
            </li>
            <li class="to-field">
              <input type="text" name="quote_text_color[]" class="bg_color" value="<?php echo esc_attr($quote_text_color)?>" />
              <div class="left-box">
                <p><?php _e('Provide a hex colour code here (with #) if you want to override the default','uoc');?></p>
              </div>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php _e('Align','uoc');?></label>
            </li>
            <li class="to-field select-style">
              <select name="quote_align[]" class="dropdown" >
                <option <?php if($quote_align=="left")echo "selected";?> ><?php _e('left','uoc');?></option>
                <option <?php if($quote_align=="right")echo "selected";?> ><?php _e('right','uoc');?></option>
                <option <?php if($quote_align=="center")echo "selected";?> ><?php _e('center','uoc');?></option>
              </select>
              <p><?php _e('Align the content position','uoc');?></p>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label><?php _e('Quote Content','uoc');?></label>
            </li>
            <li class="to-field">
              <textarea name="quote_content[]" data-content-text="cs-shortcode-textarea"><?php echo esc_textarea($quote_content);?></textarea>
              <p><?php _e('Enter your content','uoc');?></p>
            </li>
          </ul>
          
        </div>
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
          <input type="hidden" name="cs_orderby[]" value="quote" />
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
    add_action('wp_ajax_cs_pb_quote', 'cs_pb_quote');
}