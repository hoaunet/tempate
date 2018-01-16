<?php
/*
 *
 *@Shortcode Name : Clients
 *@retrun
 *
 */

if ( ! function_exists( 'cs_pb_clients' ) ) {
    function cs_pb_clients($die = 0){
        global $cs_node, $post;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $cs_counter = $_POST['counter'];
        $clients_num = 0;
        if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes ($shortcode_element_id);
            $PREFIX = CS_SC_CLIENTS.'|'.CS_SC_CLIENTSITEM;
            $parseObject     = new ShortcodeParse();
            $output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
        }
        $defaults = array(
		'cs_clients_view' => 'Grid View',
		'cs_client_gray' => 'Yes',
		'cs_client_border' => 'Yes',
		'cs_client_section_title' => 'Our Partners',
		'cs_client_class' => ''
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
                $clients_num = count($atts_content);
        $clients_element_size = '100';
        foreach($defaults as $key=>$values){
            if(isset($atts[$key]))
                $$key = $atts[$key];
            else 
                $$key =$values;
         }
        $name = 'cs_pb_clients';
        $coloumn_class = 'column_'.$clients_element_size;
        if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        $randD_id = rand(34, 453453);
    ?>
<div id="<?php echo cs_allow_special_char($name.$cs_counter);?>_del" class="column  parentdelete <?php echo cs_allow_special_char($coloumn_class);?> <?php echo cs_allow_special_char($shortcode_view);?>" item="column" data="<?php echo cs_element_size_data_array_index($clients_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$clients_element_size,'','weixin');?>
  <div class="cs-wrapp-class-<?php echo cs_allow_special_char($cs_counter)?> <?php echo cs_allow_special_char($shortcode_element);?>" id="<?php echo cs_allow_special_char($name.$cs_counter);?>" style="display: none;">
    <div class="cs-heading-area">
      <h5><?php _e('Edit Clients Options','uoc');?></h5>
      <a href="javascript:removeoverlay('<?php echo cs_allow_special_char($name.$cs_counter)?>','<?php echo cs_allow_special_char($filter_element);?>')" class="cs-btnclose"><i class="icon-times"></i></a>
	  </div>
    <div class="cs-clone-append cs-pbwp-content" >
      <div class="cs-wrapp-tab-box">
        <div id="shortcode-item-<?php echo esc_attr($cs_counter);?>" data-shortcode-template="{{child_shortcode}} [/<?php echo esc_attr( CS_SC_CLIENTS ) ;?>]" data-shortcode-child-template="[<?php echo esc_attr( CS_SC_CLIENTSITEM ) ;?> {{attributes}}] {{content}} [/<?php echo esc_attr( CS_SC_CLIENTSITEM ) ;?>]">
          <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true" data-template="[<?php echo esc_attr( CS_SC_CLIENTS ) ;?> {{attributes}}]">
            <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){cs_shortcode_element_size();}?>
            <ul class="form-elements">
                <li class="to-label"><label><?php _e('Section Title','uoc');?></label></li>
                <li class="to-field">
                    <input  name="cs_client_section_title[]" type="text"  value="<?php echo cs_allow_special_char($cs_client_section_title);?>"   />
                </li>                  
             </ul>
   
            <ul class="form-elements">
              <li class="to-label">
                <label><?php _e('Gray Scale','uoc');?></label>
              </li>
              <li class="to-field select-style">
                <select class="cs_client_gray" id="cs_client_gray" name="cs_client_gray[]">
                  <option value="yes" <?php if($cs_client_gray == 'yes'){echo 'selected="selected"';}?>><?php _e('Yes','uoc');?></option>
                  <option value="no" <?php if($cs_client_gray == 'no'){echo 'selected="selected"';}?>><?php _e('No','uoc');?></option>
                </select>
              </li>
            </ul>
        
            <ul class="form-elements">
                <li class="to-label"><label><?php _e('Custom Id','uoc');?></label></li>
                <li class="to-field">
                    <input type="text" name="cs_client_class[]" class="txtfield"  value="<?php echo esc_attr($cs_client_class)?>" />
                </li>
             </ul>
            
          </div>
          <?php
                  if ( isset($clients_num) && $clients_num <> '' && isset($atts_content) && is_array($atts_content)){
                    $itemCounter  = 0 ;        
                    foreach ( $atts_content as $clients_items ){
                        $itemCounter++;
                        $rand_id = $cs_counter.''.cs_generate_random_string(3);
                        $defaults = array('cs_bg_color'=>'','cs_website_url'=>'','cs_client_title'=>'','cs_client_logo'=>'');
                        foreach($defaults as $key=>$values){
                            if(isset($clients_items['atts'][$key]))
                                $$key = $clients_items['atts'][$key];
                            else 
                                $$key =$values;
                         }
                ?>
                      <div class='cs-wrapp-clone cs-shortcode-wrapp'  id="cs_infobox_<?php echo cs_allow_special_char($rand_id);?>">
                        <header>
                          <h4><i class='icon-arrows'></i><?php _e('Clients','uoc');?></h4>
                          <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php _e('Remove','uoc');?></a></header>
                         <ul class="form-elements">
                          <li class="to-label">
                            <label><?php _e('Title','uoc');?></label>
                          </li>
                          <li class="to-field">
                            <input type="text" id="cs_client_title" class="" name="cs_client_title[]" value="<?php echo cs_allow_special_char($cs_client_title);?>" />
                          </li>
                        </ul>
                        <ul class="form-elements">
                          <li class="to-label">
                            <label><?php _e('Background Color','uoc');?></label>
                          </li>
                          <li class="to-field">
                            <input type="text" id="cs_bg_color" class="bg_color" name="cs_bg_color[]" value="<?php echo esc_attr($cs_bg_color);;?>" />
                          </li>
                        </ul>
                        <ul class="form-elements">
                          <li class="to-label">
.                            <label><?php _e('Website Url','uoc');?></label>
                          </li>
                          <li class="to-field">
                            <div class="input-sec">
                              <input type="text" id="cs_website_url" class="" name="cs_website_url[]" value="<?php echo esc_url($cs_website_url);?>" />
                            </div>
                            <div class="left-info">
                              <p>e.g. http://yourdomain.com/</p>
                            </div>
                          </li>
                        </ul>
                        <ul class="form-elements">
                          <li class="to-label">
                            <label><?php _e('Client Logo','uoc');?></label>
                          </li>
                          <li class="to-field">
                            <input id="cs_client_logo<?php echo cs_allow_special_char($itemCounter)?>" name="cs_client_logo[]" type="hidden" class="" value="<?php echo cs_allow_special_char($cs_client_logo);?>"/>
                            <input name="cs_client_logo<?php echo cs_allow_special_char($itemCounter)?>"  type="button" class="uploadMedia left" value="<?php _e('Browse','uoc');?>"/>
                          </li>
                        </ul>
                        <div class="page-wrap" style="overflow:hidden; display:<?php echo cs_allow_special_char($cs_client_logo) && trim($cs_client_logo) !='' ? 'inline' : 'none';?>" id="cs_client_logo<?php echo cs_allow_special_char($itemCounter)?>_box" >
                          <div class="gal-active">
                            <div class="dragareamain" style="padding-bottom:0px;">
                              <ul id="gal-sortable">
                                <li class="ui-state-default" id="">
                                  <div class="thumb-secs"> <img src="<?php echo esc_url($cs_client_logo);?>"  id="cs_client_logo<?php echo cs_allow_special_char($itemCounter)?>_img" width="100" height="150"  />
                                    <div class="gal-edit-opts"> <a   href="javascript:del_media('cs_client_logo<?php echo cs_allow_special_char($itemCounter)?>')" class="delete"></a> </div>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
          <?php }
             }
            ?>
        </div>
        <div class="hidden-object">
          <input type="hidden" name="clients_num[]" value="<?php echo (int)$clients_num;?>" class="fieldCounter"  />
        </div>
        <div class="wrapptabbox no-padding-lr">
          <div class="opt-conts">
            <ul class="form-elements noborder">
              <li class="to-field"> <a href="#" class="add_servicesss cs-main-btn" onclick="cs_shortcode_element_ajax_call('clients', 'shortcode-item-<?php echo cs_allow_special_char($cs_counter);?>', '<?php echo cs_allow_special_char(admin_url('admin-ajax.php'));?>')"><i class="icon-plus-circle"></i><?php _e('Add Client','uoc');?></a> </li>
               <div id="loading" class="shortcodeload"></div>
            </ul>
          </div>
          <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
          <ul class="form-elements insert-bg">
            <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo cs_allow_special_char(str_replace('cs_pb_','',$name));?>','shortcode-item-<?php echo cs_allow_special_char($cs_counter);?>','<?php echo cs_allow_special_char($filter_element);?>')" ><?php _e('Insert','uoc');?></a> </li>
          </ul>
          <div id="results-shortocde"></div>
          <?php } else {?>
          <ul class="form-elements noborder no-padding-lr">
            <li class="to-label"></li>
            <li class="to-field">
              <input type="hidden" name="cs_orderby[]" value="clients" />
              <input type="button" value="<?php _e('Save','uoc');?>" style="margin-right:10px;" onclick="javascript:_removerlay(jQuery(this))" />
            </li>
          </ul>
          <?php }?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
        if ( $die <> 1 ) die();
    }
    add_action('wp_ajax_cs_pb_clients', 'cs_pb_clients');
}
?>