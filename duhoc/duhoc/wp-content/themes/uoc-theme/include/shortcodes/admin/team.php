<?php
/*
 *
 *@Shortcode Name : Teams
 *@retrun
 *
 */
 if ( ! function_exists( 'cs_pb_teams' ) ) {
	function cs_pb_teams($die = 0){
		global $cs_node, $post;
		$shortcode_element = '';
		$filter_element = 'filterdrag';
		$shortcode_view = '';
		$output = array();
		$counter = $_POST['counter'];
		if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
			$POSTID = '';
			$shortcode_element_id = '';
			$cs_counter = $_POST['counter'];
		} else {
			$POSTID = $_POST['POSTID'];
			$cs_counter = $_POST['counter'];
			$PREFIX = CS_SC_TEAM;
			$shortcode_element_id = $_POST['shortcode_element_id'];
			$shortcode_str = stripslashes ($shortcode_element_id);
			$parseObject 	= new ShortcodeParse();
			$output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
		}
		$defaults = array( 'cs_team_section_title' => '','cs_team_name' => '','cs_team_designation' => '','cs_team_title' => '','cs_team_profile_image' => '','cs_team_fb_url' => '','cs_team_twitter_url' => '','cs_team_googleplus_url' => '','cs_team_skype_url' => '','cs_team_email' => '','teams_class' => '','teams_animation' => '');

		if(isset($output['0']['atts']))
			$atts = $output['0']['atts'];
		else 
			$atts = array();
		
		if(isset($output['0']['content']))
			$cs_team_description = $output['0']['content'];
		else 
			$cs_team_description = "";
			
		$teams_element_size = '25';
		foreach($defaults as $key=>$values){
			if(isset($atts[$key]))
				$$key = $atts[$key];
			else 
				$$key =$values;
		 }
		$name = 'cs_pb_teams';
		$coloumn_class = 'column_'.$teams_element_size;
	if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
		$shortcode_element = 'shortcode_element_class';
		$shortcode_view = 'cs-pbwp-shortcode';
		$filter_element = 'ajax-drag';
		$coloumn_class = '';
	}
	$rand_counter = rand(888, 9999999);
	?>

<div id="<?php echo esc_attr( $name.$cs_counter)?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="blog" data="<?php echo element_size_data_array_index($teams_element_size)?>">
      <?php cs_element_setting($name,$cs_counter,$teams_element_size,'','newspaper-o');?>
      <div class="cs-wrapp-class-<?php echo esc_attr($cs_counter)?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo esc_attr($name.$cs_counter);?>" data-shortcode-template="[<?php echo esc_attr( CS_SC_TEAM ) ;?> {{attributes}}]{{content}}[/<?php echo esc_attr( CS_SC_TEAM ) ;?>]"  style="display: none;">
        <div class="cs-heading-area">
          <h5><?php _e('Edit Team Options','uoc');?></h5>
          <a href="javascript:removeoverlay('<?php echo esc_attr($name.$cs_counter);?>','<?php echo esc_attr($filter_element);?>')" class="cs-btnclose"><i class="fa fa-times"></i></a> </div>
        <div class="cs-pbwp-content">
          <div class="cs-wrapp-clone cs-shortcode-wrapp">
                <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){cs_shortcode_element_size();}?>
                <ul class="form-elements">
                    <li class="to-label"><label><?php _e('Section Title','uoc');?></label></li>
                    <li class="to-field">
                        <input  name="cs_team_section_title[]" type="text"  value="<?php echo cs_allow_special_char($cs_team_section_title)?>"   />
                    </li>                  
                 </ul>
                <ul class="form-elements">
                  <li class="to-label">
                    <label><?php _e('Name','uoc');?></label>
                  </li>
                  <li class="to-field">
                    <input type="text" name="cs_team_name[]" value="<?php echo esc_attr($cs_team_name);?>" />
                  </li>
                </ul>
                <ul class="form-elements">
                  <li class="to-label">
                    <label><?php _e('Designation','uoc');?></label>
                  </li>
                  <li class="to-field">
                    <input type="text" name="cs_team_designation[]" value="<?php echo esc_attr($cs_team_designation);?>" />
                  </li>
                </ul>
              
                 <ul class="form-elements">
                  <li class="to-label">
                    <label><?php _e('short Description','uoc');?></label>
                  </li>
                  <li class="to-field">
                    <textarea name="cs_team_description[]" rows="8" cols="40" data-content-text="cs-shortcode-textarea"><?php echo esc_textarea($cs_team_description);?></textarea>
                  </li>
                </ul>
             
                <ul class="form-elements">
                  <li class="to-label">
                    <label><?php _e('Team Profile Image','uoc');?></label>
                  </li>
                  <li class="to-field">
                    <input id="cs_team_profile_image<?php echo esc_attr($rand_counter)?>" name="cs_team_profile_image[]" type="hidden" class="" value="<?php echo esc_url($cs_team_profile_image);?>"/>
                    <input name="cs_team_profile_image<?php echo esc_attr($rand_counter);?>"  type="button" class="uploadMedia left" value="<?php _e('Browse','uoc');?>"/>
                  </li>
                </ul>
                <div class="page-wrap" style="overflow:hidden; display:<?php echo esc_url($cs_team_profile_image) && trim($cs_team_profile_image) !='' ? 'inline' : 'none';?>" id="cs_team_profile_image<?php echo esc_attr($rand_counter)?>_box" >
                  <div class="gal-active">
                    <div class="dragareamain" style="padding-bottom:0px;">
                      <ul id="gal-sortable">
                        <li class="ui-state-default" id="">
                          <div class="thumb-secs"> <img src="<?php echo esc_url($cs_team_profile_image);?>"  id="cs_team_profile_image<?php echo esc_attr($rand_counter)?>_img" width="100" height="150"  />
                            <div class="gal-edit-opts"> <a href="javascript:del_media('cs_team_profile_image<?php echo esc_attr($rand_counter);?>')" class="delete"></a> </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <ul class="form-elements">
                  <li class="to-label">
                    <label><?php _e('Facebook','uoc');?></label>
                  </li>
                  <li class="to-field">
                    <input type="text" name="cs_team_fb_url[]" value="<?php echo esc_url($cs_team_fb_url);?>" />
                  </li>
                </ul>
                <ul class="form-elements">
                  <li class="to-label">
                    <label><?php _e('Twitter Url','uoc');?></label>
                  </li>
                  <li class="to-field">
                    <input type="text" name="cs_team_twitter_url[]" value="<?php echo esc_url($cs_team_twitter_url);?>" />
                  </li>
                </ul>
                <ul class="form-elements">
                  <li class="to-label">
                    <label><?php _e('Google plus','uoc');?></label>
                  </li>
                  <li class="to-field">
                    <input type="text" name="cs_team_googleplus_url[]" value="<?php echo esc_url($cs_team_googleplus_url);?>" />
                  </li>
                </ul>
                <ul class="form-elements">
                  <li class="to-label">
                    <label><?php _e('Skype','uoc');?></label>
                  </li>
                  <li class="to-field">
                    <input type="text" name="cs_team_skype_url[]" value="<?php echo esc_url($cs_team_skype_url);?>" />
                  </li>
                </ul>
                <ul class="form-elements">
                  <li class="to-label">
                    <label><?php _e('Email','uoc');?></label>
                  </li>
                  <li class="to-field">
                    <input type="text" name="cs_team_email[]" value="<?php echo sanitize_email($cs_team_email);?>" />
                  </li>
                </ul>
              </div>
            <div class="wrapptabbox no-padding-lr">
              <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
              <ul class="form-elements insert-bg">
                <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js(str_replace('cs_pb_','',$name));?>','<?php echo esc_js($name.$cs_counter)?>','<?php echo esc_js($filter_element);?>')" ><?php _e('Insert','uoc');?></a> </li>
              </ul>
              <div id="results-shortocde"></div>
              <?php } else {
				   ?>
              	<ul class="form-elements noborder">
                <li class="to-label"></li>
                <li class="to-field">
                  <input type="hidden" name="cs_orderby[]" value="teams" />
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
        add_action('wp_ajax_cs_pb_teams', 'cs_pb_teams');
    }
?>