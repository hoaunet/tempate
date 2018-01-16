<?php
/*
 *
 *@Shortcode Name : Table
 *@retrun
 *
 */

if ( ! function_exists( 'cs_pb_table' ) ) {
    function cs_pb_table($die = 0){
        global $cs_node, $cs_count_node, $post;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $PREFIX = CS_SC_TABLES;
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
        
        $defaults = array('column_size'=>'1/2','cs_table_section_title'=>'','table_style'=>'','cs_table_content'=>'','cs_table_class'=>'');
        if(isset($output['0']['atts']))
            $atts = $output['0']['atts'];
        else 
            $atts = array();
        
        $atts_content = '[table]
                            [thead]
                              [tr]
                                [th]Column 1[/th]
                                [th]Column 2[/th]
                                [th]Column 3[/th]
                                [th]Column 4[/th]
                              [/tr]
                            [/thead]
                            [tbody]
                              [tr]
                                [td]Item 1[/td]
                                [td]Item 2[/td]
                                [td]Item 3[/td]
                                [td]Item 4[/td]
                              [/tr]
                              [tr]
                                [td]Item 11[/td]
                                [td]Item 22[/td]
                                [td]Item 33[/td]
                                [td]Item 44[/td]
                              [/tr]
                            [/tbody]
						[/table]
                     ';
        
        if ( $defaultAttributes ) {
            $atts_content    = $atts_content;
        } else {
            if(isset($output['0']['content']))
                $atts_content = $output['0']['content'];
            else 
                $atts_content = "";
        }
            
        $table_element_size = '25';
        foreach($defaults as $key=>$values){
            if(isset($atts[$key]))
                $$key = $atts[$key];
            else 
                $$key =$values;
         }
        $name = 'cs_pb_table';
        $cs_count_node++;
        $coloumn_class = 'column_'.$table_element_size;
        
        if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
    ?>
<div id="<?php echo esc_attr($name.$cs_counter);?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="table" data="<?php echo cs_element_size_data_array_index($table_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$table_element_size,'','th');?>
  <div class="cs-wrapp-class-<?php echo esc_attr($cs_counter)?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo esc_attr($name.$cs_counter)?>"  data-shortcode-template="[<?php echo esc_attr( CS_SC_TABLES ) ;?> {{attributes}}] {{content}} [/<?php echo esc_attr( CS_SC_TABLES ) ;?>]"  style="display: none;">
    <div class="cs-heading-area">
      <h5><?php _e('Edit Table Options','uoc');?></h5>
      <a href="javascript:removeoverlay('<?php echo esc_attr($name.$cs_counter)?>','<?php echo esc_attr($filter_element);?>')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
    <div class="cs-pbwp-content">
      <div class="cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content">
        <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){cs_shortcode_element_size();}?>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Section Title','uoc');?></label>
          </li>
          <li class="to-field">
            <input  name="cs_table_section_title[]" type="text"  value="<?php echo cs_allow_special_char($cs_table_section_title);?>"   />
            <div class='left-info'>
              <div class='left-info'><p><?php _e('This is used for the one page navigation, to identify the section below. Give a title','uoc');?>  </p></div>
            </div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Table Style','uoc');?></label>
          </li>
          <li class="to-field">
              <div class="select-style">
                <select class="table_style" name="table_style[]">
                  <option value="modern" <?php if($table_style == 'modern'){echo 'selected="selected"'; }?>><?php _e('Modern Style','uoc');?></option>
                 <!-- <option value="classic" <?php  //if($table_style == 'classic'){echo 'selected="selected"'; }?>><?php //_e('Classic','uoc');?></option>-->
                </select>
            </div>
            
              <div class='left-info'><p><?php _e('Select a table style','uoc');?></p></div>
          </li>
        </ul>
        <ul class="form-elements">
          <li class="to-label">
            <label><?php _e('Table Content','uoc');?></label>
          </li>
          <li class="to-field"> 
              <textarea name="cs_table_content[]" data-content-text="cs-shortcode-textarea"><?php echo esc_textarea($atts_content);?></textarea>
             	<div class='left-info'><p><?php _e('Enter the content','uoc');?></p></div>
          </li>
        </ul>
       
        <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
        <ul class="form-elements insert-bg noborder" style="padding-top: 15px; margin: -15px 0px 0px 0px;">
          <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js(str_replace('cs_pb_','',$name));?>','<?php echo esc_js($name.$cs_counter)?>','<?php echo esc_js($filter_element);?>')" ><?php _e('Insert','uoc');?></a> </li>
        </ul>
        <div id="results-shortocde"></div>
        <?php } else {?>
        <ul class="form-elements noborder">
          <li class="to-label"></li>
          <li class="to-field">
            <input type="hidden" name="cs_orderby[]" value="table" />
            <input type="button" value="<?php _e('Save','uoc');?>" style="margin-right:10px;" onclick="javascript:_removerlay(jQuery(this))" />
          </li>
        </ul>
        <?php }?>
      </div>
    </div>
  </div>
</div>
<?php
        if ( $die <> 1 ) die();
    
    }
    add_action('wp_ajax_cs_pb_table', 'cs_pb_table');
}
?>
