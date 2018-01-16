<?php
/*
 *
 *@Shortcode Name : Image frame
 *@retrun
 *
 */
if ( ! function_exists( 'cs_pb_image' ) ) {
    function cs_pb_image($die = 0){
        global $cs_node,$cs_count_node, $post;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $PREFIX = CS_SC_IMAGE;
        $defaultAttributes    = false;
        $parseObject     = new ShortcodeParse();
        $cs_counter = $_POST['counter'];
        if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
            $POSTID = '';
            $shortcode_element_id = '';
            $defaultAttributes    = true;
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes ($shortcode_element_id);
            $output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
        }
             $defaults = array( 
			 'cs_image_section_title' => '',
			 'image_style' => '',
			 'cs_image_url' => '',
			 'cs_image_title' => '',
			 'cs_image_caption' => '',
			 'cs_image_custom_class'=>'',
			 );
            if(isset($output['0']['atts']))
                $atts = $output['0']['atts'];
            else 
                $atts = array();
            
            if(isset($output['0']['content']))
                $atts_content = $output['0']['content'];
            else 
                $atts_content = "";
            
            $image_element_size = '25';
            foreach($defaults as $key=>$values){
                if(isset($atts[$key]))
                    $$key = $atts[$key];
                else 
                    $$key =$values;
             }
            $name = 'cs_pb_image';
            $cs_count_node++;
            $coloumn_class = 'column_'.$image_element_size;
        if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        
        $rand_id = rand(34, 443534);
         
     ?>
<div id="<?php echo cs_allow_special_char($name.$cs_counter)?>_del" class="column  parentdelete <?php echo cs_allow_special_char($coloumn_class);?> <?php echo cs_allow_special_char($shortcode_view);?>" item="image" data="<?php echo cs_element_size_data_array_index($image_element_size); ?>" >
  <?php cs_element_setting($name,$cs_counter,$image_element_size,'','picture-o');?>
  <div class="cs-wrapp-class-<?php echo cs_allow_special_char($cs_counter)?> <?php echo cs_allow_special_char($shortcode_element);?>" id="<?php echo cs_allow_special_char($name.$cs_counter)?>" data-shortcode-template="[<?php echo esc_attr( CS_SC_IMAGE );?> CS_SC_IMAGE {{attributes}}]{{content}}[/<?php echo esc_attr( CS_SC_IMAGE );?>]" style="display: none;">
    <div class="cs-heading-area">
      <h5><?php _e('Edit Image Options','uoc');?></h5>
      <a href="javascript:removeoverlay('<?php echo cs_allow_special_char($name.$cs_counter)?>','<?php echo cs_allow_special_char($filter_element);?>')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
    <div class="cs-pbwp-content">
      <div class="cs-wrapp-clone cs-shortcode-wrapp">
        <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){cs_shortcode_element_size();}?>
        <ul class="form-elements">
            <li class="to-label"><label><?php _e('Section Title','uoc');?></label></li>
            <li class="to-field">
                <input name="cs_image_section_title[]" type="text"  value="<?php echo cs_allow_special_char($cs_image_section_title)?>"   />
                <p><?php _e('This is used for the one page navigation, to identify the section below. Give a title','uoc');?>  </p>
            </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Image Style','uoc');?></label>
          </li>
          <li class="to-field select-style">
            <select class="image_style" name="image_style[]">
              <option <?php if($image_style == 'modern'){echo 'selected="selected"';}?> value="modern"><?php _e('Modern','uoc');?></option>
               <option <?php if($image_style == 'classic'){echo 'selected="selected"';}?> value="classic"><?php _e('Classic','uoc');?></option>
              <option <?php if($image_style == 'simple'){echo 'selected="selected"';}?> value="simple"><?php _e('Simple','uoc');?></option>
            </select>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Image url','uoc');?></label>
          </li>
          <li class="to-field">
            <input id="cs_image_url<?php echo esc_attr($rand_id)?>" name="cs_image_url[]" type="hidden" class="" value="<?php echo esc_url($cs_image_url);?>"/>
            <input name="cs_image_url<?php echo esc_attr($rand_id)?>"  type="button" class="uploadMedia left" value="<?php _e('Browse','uoc');?>"/>
            <div class="left-info">
            <p><?php _e('Browse the image','uoc');?> </p>
            </div>
          </li>
        </ul>
        <ul class="form-elements">
            <li class="image-frame">
                <div class="page-wrap" style="overflow:hidden; display:<?php echo cs_allow_special_char($cs_image_url) && trim($cs_image_url) !='' ? 'inline' : 'none';?>" id="cs_image_url<?php echo cs_allow_special_char($rand_id)?>_box" >
                  <div class="gal-active">
                    <div class="dragareamain" style="padding-bottom:0px;">
                      <ul id="gal-sortable">
                        <li class="ui-state-default" id="">
                          <div class="thumb-secs"> <img src="<?php echo esc_url($cs_image_url);?>"  id="cs_image_url<?php echo cs_allow_special_char($rand_id);?>_img" width="100" height="150"  />
                            <div class="gal-edit-opts"> <a   href="javascript:del_media('cs_image_url<?php echo cs_allow_special_char($rand_id);?>')" class="delete"></a> </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
            </li>
        </ul>
        
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Title','uoc');?></label>
          </li>
          <li class="to-field">
            <input type="text" name="cs_image_title[]" class="txtfield" value="<?php echo cs_allow_special_char($cs_image_title)?>" />
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Caption','uoc');?></label>
          </li>
          <li class="to-field">
            <textarea name="cs_image_caption[]" rows="10" class="textarea" data-content-text="cs-shortcode-textarea"><?php echo esc_textarea($atts_content); ?></textarea>
            <p><?php _e('If you would like a caption to be shown below the image, add it here.','uoc');?></p>
          </li>
        </ul>
       
      </div>
      <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
      <ul class="form-elements insert-bg">
        <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo cs_allow_special_char(str_replace('cs_pb_','',$name));?>','<?php echo cs_allow_special_char($name.$cs_counter)?>','<?php echo cs_allow_special_char($filter_element);?>')" ><?php _e('Insert','uoc');?></a> </li>
      </ul>
      <div id="results-shortocde"></div>
      <?php } else {?>
      <ul class="form-elements noborder">
        <li class="to-label"></li>
        <li class="to-field">
          <input type="hidden" name="cs_orderby[]" value="image" />
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
    add_action('wp_ajax_cs_pb_image', 'cs_pb_image');
}