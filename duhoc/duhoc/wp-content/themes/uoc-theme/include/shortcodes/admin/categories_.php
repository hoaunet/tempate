<?php
/*
 *
 *@Shortcode Name : Divider
 *@retrun
 *
 */
 if ( ! function_exists( 'cs_pb_categories' ) ) {
    function cs_pb_categories($die = 0){
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
            $PREFIX = CS_SC_CATEGORIES;
            $parseObject     = new ShortcodeParse();
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes ($shortcode_element_id);
            $output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
        }        
        $defaults = array(   
				'column_size' => '1/1',
				'cs_category_title'=>'',
				'cs_category_description'=>'',
				'cs_total_display' =>'',
			  );
            if(isset($output['0']['atts']))
                $atts = $output['0']['atts'];
            else 
                $atts = array();
            if(isset($output['0']['content']))
                $atts_content = $output['0']['content'];
            else 
                $atts_content = '';
            $categories_element_size = '25';
            foreach($defaults as $key=>$values){
                if(isset($atts[$key]))
                    $$key = $atts[$key];
                else 
                    $$key =$values;
             }
            $name = 'cs_pb_categories';
            $coloumn_class = 'column_'.$categories_element_size;
        
        if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }        
    ?>
<div id="<?php echo esc_attr($name.$cs_counter)?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="blog" data="<?php echo cs_element_size_data_array_index($categories_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$categories_element_size, '', 'ellipsis-h',$type='');?>
  <div class="cs-wrapp-class-<?php echo intval($cs_counter)?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo esc_attr($name.$cs_counter)?>" data-shortcode-template="[<?php echo esc_attr( CS_SC_CATEGORIES );?> {{attributes}}]" style="display: none;">
    <div class="cs-heading-area">
      <h5><?php _e('Edit Categories Option','uoc');?></h5>
      <a href="javascript:removeoverlay('<?php echo esc_js($name.$cs_counter)?>','<?php echo esc_js($filter_element);?>')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
    <div class="cs-pbwp-content">
      <div class="cs-wrapp-clone cs-shortcode-wrapp">
        
        
        	<ul class="form-elements">
					  <li class="to-label">
						<label><?php _e('Title','uoc');?></label>
					  </li>
					  <li class="to-field">
						<input type="text" name="cs_category_title[]" class="txtfield" value="<?php echo cs_allow_special_char($cs_category_title);?>" />
					  </li>
				</ul>
        
            
            <ul class="form-elements">
					  <li class="to-label">
						<label><?php _e('Description','uoc');?></label>
					  </li>
					  <li class="to-field">
						<textarea name="cs_category_description[]" rows="8" cols="40" data-content-text="cs-shortcode-textarea">
							<?php echo esc_textarea($cs_category_description);?>
						</textarea>
						<p><?php _e('Enter description here','uoc');?></p>
					  </li>
				</ul>
        	 <ul class="form-elements">
					  <li class="to-label">
						<label><?php _e('Total Category To Display','uoc');?></label>
					  </li>
					  <li class="to-field">
						<input type="text" name="cs_total_display[]" class="txtfield" value="<?php echo cs_allow_special_char($cs_total_display);?>" />
					  </li>
				</ul>
        
       
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
          <input type="hidden" name="cs_orderby[]" value="categories" />
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
    add_action('wp_ajax_cs_pb_categories', 'cs_pb_categories');
}