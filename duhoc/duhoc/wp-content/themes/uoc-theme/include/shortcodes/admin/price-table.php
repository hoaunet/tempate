<?php
/*
 *
 *@Shortcode Name : Price Table
 *@retrun
 *
 */

if ( ! function_exists( 'cs_pb_pricetable' ) ) {
    function cs_pb_pricetable($die = 0){
        global $cs_node, $cs_count_node, $post;
        
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $cs_counter = $_POST['counter'];
        $PREFIX = CS_SC_PRICETABLE.'|'.CS_SC_PRICETABLEITEM;
        $parseObject     = new ShortcodeParse();
        $price_num = 0;
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
		'column_size'=>'1/1',
		'pricetable_style'=>'',
		'pricetable_title'=>'', 
		'pricetable_title_bgcolor'=>'',
		'pricetable_price'=>'',
		'currency_symbols'=>'$',
		'pricetable_img'=>'',
		'pricetable_period'=>'',
		'pricetable_bgcolor'=>'',
		'btn_text'=>'Buy Now',
		'btn_link'=>'',
		'btn_bg_color'=>'',
		'pricetable_featured'=>'',
		'pricetable_class'=>''
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
                $price_num = count($atts_content);
            $pricetable_element_size = '25';
            foreach($defaults as $key=>$values){
                if(isset($atts[$key]))
                    $$key = $atts[$key];
                else 
                    $$key =$values;
             }
            $name = 'cs_pb_pricetable';
            $coloumn_class = 'column_'.$pricetable_element_size;
        
        if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        
        $cs_counter = $cs_counter.rand(11,555);
        
    ?>
<div id="<?php echo esc_attr($name.$cs_counter)?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class);?> <?php echo esc_attr($shortcode_view);?>" item="pricetable" data="<?php echo cs_element_size_data_array_index($pricetable_element_size)?>" >
  <?php cs_element_setting($name,$cs_counter,$pricetable_element_size,'','th');?>
  <div class="cs-wrapp-class-<?php echo esc_attr($cs_counter)?> <?php echo esc_attr($shortcode_element);?>" id="<?php echo esc_attr($name.$cs_counter)?>" style="display: none;">
    <div class="cs-heading-area">
      <h5><?php _e('Edit Price Table Options','uoc');?></h5>
      <a href="javascript:removeoverlay('<?php echo esc_attr($name.$cs_counter)?>','<?php echo esc_attr($filter_element);?>')" class="cs-btnclose"><i class="icon-times"></i></a> </div>
       <div class="cs-clone-append cs-pbwp-content">
        <div class="cs-wrapp-tab-box">
         <div  id="cs-shortcode-wrapp_<?php echo esc_attr($name.$cs_counter)?>">
          <div id="shortcode-item-<?php echo esc_attr($cs_counter);?>" data-shortcode-template="{{child_shortcode}} [/<?php echo esc_attr( CS_SC_PRICETABLE );?>]" data-shortcode-child-template="[<?php echo esc_attr( CS_SC_PRICETABLEITEM );?> {{attributes}}] {{content}} [/<?php echo esc_attr( CS_SC_PRICETABLEITEM );?>]">
            <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true" data-template="[<?php echo esc_attr( CS_SC_PRICETABLE );?> {{attributes}}]">
                <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){cs_shortcode_element_size();}?>
                
                <!--<ul class="form-elements">
                  <li class="to-label">
                    <label><?php _e('Choose View','uoc');?></label>
                  </li>
                  <li class="to-field">
                    <div class="select-style">
                      <select name="pricetable_style[]" class="dropdown" onchange="cs_pricetable_style_vlaue(this.value, <?php //echo esc_js($cs_counter);?>)" >
                       <!-- <option <?php //if($pricetable_style=="classic")echo "selected";?> value="classic" ><?php // _e('Classic','uoc');?></option>
                        <option <?php ///if($pricetable_style=="simple")echo "selected";?> value="simple" ><?php //_e('Simple','uoc');?></option>
           
                      </select>
                      <div class='left-info'>
                        <div class='left-info'><p><?php //_e('Choose a pricetable view','uoc');?></p></div>
                      </div>
                    </div>
                  </li>
                </ul>-->
                
                
                <ul class="form-elements">
                  <li class="to-label">
                    <label><?php _e('Title','uoc');?></label>
                  </li>
                  <li class="to-field">
                    <input type="text" name="pricetable_title[]" class="txtfield" value="<?php echo cs_allow_special_char($pricetable_title);?>" />
                    <div class='left-info'>
                      <div class='left-info'><p> <?php _e('set title for the item','uoc');?></p></div>
                    </div>
                  </li>
                </ul>
                 
                
                <ul class="form-elements">
                  <li class="to-label">
                    <label><?php _e('Title Color','uoc');?></label>
                  </li>
                  <li class="to-field">
                    <input type="text"  name="pricetable_title_bgcolor[]" class="bg_color" value="<?php echo esc_attr($pricetable_title_bgcolor);?>" data-default-color=""  />
                  </li>
                </ul>
                <ul class="form-elements">
                  <li class="to-label">
                    <label><?php _e('Price','uoc');?></label>
                  </li>
                  <li class="to-field">
                    <input type="text" name="pricetable_price[]" class="" value="<?php echo esc_attr($pricetable_price);?>" />
                    <div class='left-info'>
                      <div class='left-info'><p><?php _e('item Price','uoc');?></p></div>
                    </div>
                  </li>
                </ul>
                
                <ul class="form-elements">
                  <li class="to-label">
                    <label><?php _e('Currency Symbols','uoc');?></label>
                  </li>
                  <li class="to-field">
                    <input type="text" name="currency_symbols[]" class="" value="<?php echo esc_attr($currency_symbols);?>" />
                    <div class='left-info'>
                      <div class='left-info'><p><?php _e('item currency symbols','uoc');?></p></div>
                    </div>
                  </li>
                </ul>
                 
                <div class="page-wrap" style="overflow:hidden; display:<?php echo esc_attr($pricetable_img) && trim($pricetable_img) !='' ? 'inline' : 'none';?>" id="pricetable_img<?php echo esc_attr($cs_counter)?>_box" >
                  <div class="gal-active">
                    <div class="dragareamain" style="padding-bottom:0px;">
                      <ul id="gal-sortable">
                        <li class="ui-state-default" id="">
                          <div class="thumb-secs"> <img src="<?php echo esc_url($pricetable_img);?>"  id="pricetable_img<?php echo esc_attr($cs_counter);?>_img" width="100" height="150"  />
                            <div class="gal-edit-opts"> <a   href="javascript:del_media('pricetable_img<?php echo esc_attr($cs_counter);?>')" class="delete"></a> </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <ul class="form-elements">
                  <li class="to-label">
                    <label><?php _e('Time Duration','uoc');?></label>
                  </li>
                  <li class="to-field">
                    <input type="text" name="pricetable_period[]" class="" value="<?php echo esc_attr($pricetable_period);?>" />
                    <div class='left-info'>
                      <div class='left-info'><p><?php _e('set a time duration','uoc');?></p></div>
                    </div>
                  </li>
                </ul>
                <ul class="form-elements">
                  <li class="to-label">
                    <label><?php _e('Header background Color','uoc');?></label>
                  </li>
                  <li class="to-field">
                    <input type="text"  name="pricetable_bgcolor[]" class="bg_color" value="<?php echo esc_attr($pricetable_bgcolor);?>" data-default-color=""  />
                    <div class='left-info'>
                      <div class='left-info'><p><?php _e('Provide a hex colour code here (with #) if you want to override the default','uoc');?> </p></div>
                    </div>
                  </li>
                </ul>
                <ul class="form-elements bcevent_title">
                  <li class="to-label">
                    <label><?php _e('Button Text','uoc');?></label>
                  </li>
                  <li class="to-field">
                    <div class="input-sec">
                      <input type="text" name="btn_text[]" class="txtfield" value="<?php echo cs_allow_special_char($btn_text);?>" />
                      <div id="pricetbale-title<?php echo esc_attr($cs_counter);?>" class="color-picker">
                        <input type="text" name="btn_bg_color[]" class="bg_color" value="<?php echo esc_attr($btn_bg_color);?>" />
                        <label><?php _e('Background Color','uoc');?></label>
                        <div class='left-info'><p>&nbsp;</p></div>
						<input type="text" name="btn_link[]" value="<?php echo cs_allow_special_char($btn_link);?>" />
                        <label><?php _e('Button Link','uoc');?></label>
                      </div>
                    </div>
                  </li>
                </ul>
                <ul class="form-elements">
                  <li class="to-label">
                    <label><?php _e('Featured','uoc');?></label>
                  </li>
                  <li class="to-field select-style">
                    <select name="pricetable_featured[]" class="dropdown" >
                      <option <?php if($pricetable_featured=="Yes")echo "selected";?> ><?php _e('Yes','uoc');?></option>
                      <option <?php if($pricetable_featured=="No")echo "selected";?> ><?php _e('No','uoc');?></option>
                    </select>
                  </li>
                </ul>
                <ul class="form-elements">
                  <li class="to-label">
                    <label><?php _e('Custom Id','uoc');?></label>
                  </li>
                  <li class="to-field">
                    <input type="text" name="pricetable_class[]" class="txtfield"  value="<?php echo esc_attr($pricetable_class);?>" />
                    <div class='left-info'>
                      <div class='left-info'><p><?php _e('Use this option if you want to use specified id for this element','uoc');?></p></div>
                    </div>
                  </li>
                </ul>
                
                <ul class="form-elements">
                  <li class="to-label">
                    <label><?php _e('Pricing Features','uoc');?></label>
                  </li>
                  <li class="to-field"> <a class="add_field_button" href="#"  onclick="javascript:cs_add_field('cs-shortcode-wrapp_<?php echo esc_js($name.$cs_counter);?>','cs_infobox')"><?php _e('Add New Feature input box','uoc');?> <i class="icon-plus-circle" style="color:red; font-size:18px"></i></a> 
                  
                    <div class='left-info'>
                      <div class='left-info'><p><?php _e('Set feature price of the product','uoc');?></p></div>
                    </div>
                    
                  </li>
                </ul>
              </div>
          <!--Items-->
          <div class="input_fields_wrap">
            <?php
            if ( isset($price_num) && $price_num <> '' && isset($atts_content) && is_array($atts_content)){
                $itemCounter    = 0;
                foreach ( $atts_content as $pricing ){
                    $rand_id = $cs_counter.''.cs_generate_random_string(3);
                    $itemCounter++;
                    $pricing_text = $pricing['content'];
                    $defaults = array('pricing_feature' => '');
                    foreach($defaults as $key=>$values){
                        if(isset($pricing['atts'][$key]))
                            $$key = $pricing['atts'][$key];
                        else 
                            $$key =$values;
                     }
                    ?>
                    <div class='cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content'  id="cs_infobox_<?php echo esc_attr($rand_id);?>">
                      <div class="cs-wrapp-clone cs-shortcode-wrapp">
                        <div id="<?php echo 'priceTable_'.esc_attr($rand_id);?>">
                          <ul class="form-elements bcevent_title">
                            <li class="to-label">
                              <label><?php _e('Pricing Feature','uoc');?><?php echo esc_attr($itemCounter);?></label>
                            </li>
                            <li class="to-field">
                              <div class="input-sec">
                                <input class="txtfield" type="text" value="<?php echo esc_attr($pricing_feature);?>" name="pricing_feature[]">
                              </div>
                              <div id="price_remove">
                                <a class="remove_field" onclick="javascript:cs_remove_field('cs_infobox_<?php echo esc_js($rand_id);?>','cs-shortcode-wrapp_<?php echo esc_js($name.$cs_counter);?>')"><i class="icon-minus-circle" style="color:#000; font-size:18px"></i></a></div>
                              </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                <?php
                        }
                    }
                 ?>
          </div>
          <!--Items--> 
         </div>
         <div class="hidden-object">
          <input type="hidden" name="price_num[]" value="<?php echo (int)$price_num?>" class="counter_num"  />
         </div>
            <div class="wrapptabbox">
          <div class="opt-conts">
            <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
            <ul class="form-elements insert-bg">
              <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js(str_replace('cs_pb_','',$name));?>','shortcode-item-<?php echo esc_js($cs_counter);?>','<?php echo esc_js($filter_element);?>')" ><?php _e('Insert','uoc');?></a> </li>
            </ul>
            <div id="results-shortocde"></div>
            <?php } else {?>
            <ul class="form-elements noborder">
              <li class="to-label"></li>
              <li class="to-field">
                <input type="hidden" name="cs_orderby[]" value="pricetable" />
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
</div>
<?php
        if ( $die <> 1 ) die();
    }
    add_action('wp_ajax_cs_pb_pricetable', 'cs_pb_pricetable');
}
?>