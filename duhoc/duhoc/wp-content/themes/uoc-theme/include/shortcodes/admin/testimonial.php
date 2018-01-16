<?php
/*
 *
 *@Shortcode Name : Testimonial
 *@retrun
 *
 */ 
if ( ! function_exists( 'cs_pb_testimonials' ) ) {
    function cs_pb_testimonials($die = 0){
        global $cs_node, $post;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $cs_counter = $_POST['counter'];
        $testimonials_num = 0;
        if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes ($shortcode_element_id);
            $PREFIX = CS_SC_TESTIMONIALS.'|'.CS_SC_TESTIMONIALSITEM;
            $parseObject     = new ShortcodeParse();
            $output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
        }
        $defaults = array('column_size'=>'1/1','testimonial_text_color'=>'','cs_testimonial_text_align'=>'','cs_testimonial_section_title'=>'','cs_testimonial_class'=>'','testimonial_view_style'=>'','testimonial_bg_color'=>'');
            if(isset($output['0']['atts']))
                $atts = $output['0']['atts'];
            else 
                $atts = array();
            if(isset($output['0']['content']))
                $atts_content = $output['0']['content'];
            else 
                $atts_content = array();
            if(is_array($atts_content))
                    $testimonials_num = count($atts_content);
            $testimonials_element_size = '67';
            foreach($defaults as $key=>$values){
                if(isset($atts[$key]))
                    $$key = $atts[$key];
                else 
                    $$key =$values;
             }
            $name = 'cs_pb_testimonials';
            $coloumn_class = 'column_'.$testimonials_element_size;
        if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
    ?>
<div id="<?php echo cs_allow_special_char($name.$cs_counter)?>_del" class="column  parentdelete <?php echo cs_allow_special_char($coloumn_class);?> <?php echo cs_allow_special_char($shortcode_view);?>" item="testimonials" data="<?php echo cs_element_size_data_array_index($testimonials_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$testimonials_element_size, '', 'comments-o',$type='');?>
  <div class="cs-wrapp-class-<?php echo cs_allow_special_char($cs_counter)?> <?php echo cs_allow_special_char($shortcode_element);?>" id="<?php echo cs_allow_special_char($name.$cs_counter)?>" style="display: none;">
    <div class="cs-heading-area">
      <h5><?php _e('Edit Testimonials Options','uoc');?></h5>
      <a href="javascript:removeoverlay('<?php echo cs_allow_special_char($name.$cs_counter)?>','<?php echo cs_allow_special_char($filter_element);       ?>')" class="cs-btnclose"><i class="icon-times"></i></a>
	 </div>
      <div class="cs-clone-append cs-pbwp-content">
		  <div class="cs-wrapp-tab-box">
				<div id="shortcode-item-<?php echo cs_allow_special_char($cs_counter);?>" data-shortcode-template="{{child_shortcode}} [/<?php echo esc_attr( CS_SC_TESTIMONIALS );?>]" data-shortcode-child-template="[<?php echo esc_attr( CS_SC_TESTIMONIALSITEM );?> {{attributes}}] {{content}} [/<?php echo esc_attr( CS_SC_TESTIMONIALSITEM );?>]">
				  <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true cs-pbwp-content" data-template="[<?php echo esc_attr( CS_SC_TESTIMONIALS );?> {{attributes}}]">
					<?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){cs_shortcode_element_size();}?>
						<ul class="form-elements">
						  <li class="to-label">
							<label><?php _e('Section Title','uoc');?></label>
						  </li>
						  <li class="to-field">
							<input  name="cs_testimonial_section_title[]" type="text"  value="<?php echo cs_allow_special_char($cs_testimonial_section_title)?>"   />
							<p><?php _e('This is used for the one page navigation, to identify the section below. Give a title','uoc');?> </p>
						  </li>
						</ul>
					 
                       
                        <ul class="form-elements">
                                    <li class="to-label"><label><?php _e('View Style','uoc');?></label></li>
                                    <li class="to-field select-style">
                                        <select class="column_size" id="testimonial_view_style" name="testimonial_view_style[]">
                                            <option value="simple" <?php if($testimonial_view_style == 'simple'){echo 'selected="selected"';}?>><?php _e('Simple','uoc');?></option>
                                            <option value="slider" <?php if($testimonial_view_style == 'slider'){echo 'selected="selected"';}?>><?php _e('Slider','uoc');?></option>
                                            
                                        </select>
                                        <p><?php _e('Select Testimonial Display Style','uoc');?></p>
                                    </li>                  
                                </ul>
                     
                     <ul class="form-elements">
						  <li class="to-label">
							<label><?php _e('Text Color','uoc');?></label>
						  </li>
						  <li class="to-field">
							<input  name="testimonial_text_color[]" type="text" class="bg_color"  value="<?php echo esc_attr($testimonial_text_color)?>"/>
						  </li>
						</ul>
                        
                        <ul class="form-elements">
						  <li class="to-label">
							<label><?php _e('Background Color','uoc');?></label>
						  </li>
						  <li class="to-field">
							<input  name="testimonial_bg_color[]" type="text" class="bg_color"  value="<?php echo esc_attr($testimonial_bg_color)?>"/>
						  </li>
						</ul>
					
				  </div>
				  <?php
					if ( isset($testimonials_num) && $testimonials_num <> '' && isset($atts_content) && is_array($atts_content)){
					
						foreach ( $atts_content as $testimonials ){
							
							$rand_string = $cs_counter.''.cs_generate_random_string(3);
							$testimonial_text = $testimonials['content'];
							$defaults = array('testimonial_author' =>'','testimonial_author_company'=>'','testimonial_img' => '','testimonial_company' => '');
							foreach($defaults as $key=>$values){
								if(isset($testimonials['atts'][$key]))
									$$key = $testimonials['atts'][$key];
								else 
									$$key =$values;
							 }
							?>
				  <div class='cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content'
				   id="cs_infobox_<?php echo cs_allow_special_char($rand_string);?>">
					<header>
					  <h4><i class='icon-arrows'></i><?php _e('Testimonial','uoc');?></h4>
					  <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php _e('Remove','uoc');?></a>
					</header>
					<ul class='form-elements'>
					  <li class='to-label'>
						<label><?php _e('Text','uoc');?></label>
					  </li>
					  <li class='to-field'>
						<div class='input-sec'>
						  <textarea class='txtfield' data-content-text="cs-shortcode-textarea" name='testimonial_text[]'><?php echo cs_allow_special_char($testimonial_text);?></textarea>
						</div>
					  </li>
					</ul>
					<ul class='form-elements'>
					  <li class='to-label'>
						<label><?php _e('Author','uoc');?></label>
					  </li>
					  <li class='to-field'>
						<div class='input-sec'>
						  <input class='txtfield' type='text' name='testimonial_author[]' value="<?php echo cs_allow_special_char($testimonial_author);?>" />
						</div>
					  </li>
					</ul>
                    
                    <ul class='form-elements'>
					  <li class='to-label'>
						<label><?php _e('Company','uoc');?></label>
					  </li>
					  <li class='to-field'>
						<div class='input-sec'>
						  <input class='txtfield' type='text' name='testimonial_author_company[]' value="<?php echo cs_allow_special_char($testimonial_author_company);?>" />
						</div>
					  </li>
					</ul>
                    <ul class="form-elements">
					  <li class="to-label">
						<label><?php _e('Image','uoc');?></label>
					  </li>
					  <li class="to-field">
						<input id="testimonial_img<?php echo cs_allow_special_char($rand_string)?>" name="testimonial_img[]" type="hidden" class="" value="<?php echo cs_allow_special_char($testimonial_img);?>"/>
						<input name="testimonial_img<?php echo cs_allow_special_char($rand_string)?>"  type="button" class="uploadMedia left" value="<?php _e('Browse','uoc');?>"/>
					  </li>
					</ul>
					<div class="page-wrap" style="overflow:hidden; display:<?php echo cs_allow_special_char($testimonial_img) && trim($testimonial_img) !='' ? 'inline' : 'none';?>" id="testimonial_img<?php echo cs_allow_special_char($rand_string)?>_box" >
					  <div class="gal-active">
						<div class="dragareamain" style="padding-bottom:0px;">
						  <ul id="gal-sortable">
							<li class="ui-state-default" id="">
							  <div class="thumb-secs"> <img src="<?php echo esc_url($testimonial_img);?>"  id="testimonial_img<?php echo cs_allow_special_char($rand_string)?>_img" width="100" height="150"  />
								<div class="gal-edit-opts"> <a   href="javascript:del_media('testimonial_img<?php echo cs_allow_special_char($rand_string)?>')" class="delete"></a> </div>
							  </div>
							</li>
						  </ul>
						</div>
					  </div>
					</div>
				  </div>
				  <?php
						}
					}
					?>
				</div>
				<div class="hidden-object">
				  <input type="hidden" name="testimonials_num[]" value="<?php echo cs_allow_special_char($testimonials_num)?>" class="fieldCounter"/>
				</div>
				<div class="wrapptabbox cs-pbwp-content" style="padding:0">
				  <div class="opt-conts">
					<ul class="form-elements">
					  <li class="to-field"> <a href="#" class="add_servicesss cs-main-btn" onclick="cs_shortcode_element_ajax_call('testimonials', 'shortcode-item-<?php echo cs_allow_special_char($cs_counter);?>', '<?php echo admin_url('admin-ajax.php');?>')"><i class="icon-plus-circle"></i><?php _e('Add testimonials','uoc');?></a> </li>
					  <div id="loading" class="shortcodeload"></div>
					</ul>
					<?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
					<ul class="form-elements insert-bg noborder">
					  <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo str_replace('cs_pb_','',$name);?>','shortcode-item-<?php echo cs_allow_special_char($cs_counter);?>','<?php echo cs_allow_special_char($filter_element);?>')" ><?php _e('Insert','uoc');?></a> </li>
					</ul>
					<div id="results-shortocde"></div>
					<?php } else {?>
					<ul class="form-elements noborder">
					  <li class="to-label"></li>
					  <li class="to-field">
						<input type="hidden" name="cs_orderby[]" value="testimonials" />
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
    add_action('wp_ajax_cs_pb_testimonials', 'cs_pb_testimonials');
}