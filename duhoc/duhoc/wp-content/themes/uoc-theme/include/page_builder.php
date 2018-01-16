<?php
global $post,$cs_node, $cs_count_node, $cs_xmlObject,$cs_theme_option;

$cs_ad_me_bo = 'add_'.'meta_'.'boxes';

add_action( $cs_ad_me_bo, 'cs_page_bulider_add' );

function cs_page_bulider_add() {
    add_meta_box( 'id_page_builder', __('CS Page Builder','uoc'), 'cs_page_bulider', 'page', 'normal', 'high' );  
}

function cs_page_bulider( $post ) {
    global $post,$cs_xmlObject, $cs_node, $cs_count_node, $post, $column_container, $coloum_width;
    wp_reset_query();
    $postID = $post->ID;
    $count_widget = 0;
    $page_title = '';
    $page_content = '';
    $page_sub_title = '';
    $builder_active = 0;
    $cs_page_bulider = get_post_meta($post->ID, "cs_page_builder", true);
    if ( $cs_page_bulider <> "" ){
        $cs_xmlObject = new stdClass();
        $cs_xmlObject = new SimpleXMLElement($cs_page_bulider);
        $builder_active = $cs_xmlObject->builder_active;
    }
?>
<input type="hidden" name="builder_active" value="<?php echo cs_allow_special_char($builder_active) ?>" />
  <div class="clear"></div>
  <div id="add_page_builder_item">
      <div id="cs_shortcode_area"></div>  
<?php
        if ( $cs_page_bulider <> "" ) {
            if ( isset($cs_xmlObject->page_title) ) $page_title = $cs_xmlObject->page_title;
            if ( isset($cs_xmlObject->page_content) ) $page_content = $cs_xmlObject->page_content;
            if ( isset($cs_xmlObject->page_sub_title) ) $page_sub_title = $cs_xmlObject->page_sub_title;
                foreach ( $cs_xmlObject->column_container as $column_container ){

				    cs_column_pb(1);
                }
        }
?>
   
  </div>
   <div class="clear"></div>
       <div class="add-widget"> <span class="addwidget"> <a href="javascript:ajaxSubmit('cs_column_pb','1','column_full')"><i class="icon-plus-circle"></i> <?php _e('Add Page Sections','uoc'); ?></a> </span> 
          <div id="loading" class="builderload"></div>
          <div class="clear"></div>
         	 <input type="hidden" name="page_builder_form" value="1" />
          <div class="clear"></div>
       </div>
<div class="clear"></div>
<script>
    jQuery(function() {
        // jQuery( "#add_page_builder_item" ).sortable({
        //     cancel : 'div div.poped-up'
        // });
        //jQuery( "#add_page_builder_item" ).disableSelection();
    });
</script> 
<script type="text/javascript">
	var count_widget = <?php echo cs_allow_special_char($count_widget) ; ?>;
	jQuery(function() {
	   jQuery( ".draginner" ) .sortable({
			connectWith: '.draginner',
			handle:'.column-in',
			start: function( event, ui ) {jQuery(ui.item).css({"width":"25%"});},
			cancel:'.draginner .poped-up,#confirmOverlay',
			revert:false,
			receive: function( event, ui ) {callme();},
			placeholder: "ui-state-highlight",
			forcePlaceholderSize:true
	   });
		jQuery( "#add_page_builder_item" ).sortable({
			handle:'.column-in',
			connectWith: ".columnmain",
			cancel:'.column_container,.draginner,#confirmOverlay',
			revert:false,
			placeholder: "ui-state-highlight",
			forcePlaceholderSize:true
		 });
	   // jQuery( "#add_page_builder_item" ).disableSelection();
	  });
	function ajaxSubmit(action,total_column, column_class){
		counter++;
		count_widget++;
		jQuery('.builderload').html("<img src='<?php echo esc_url(get_template_directory_uri());?>/include/assets/images/ajax_loading.gif' />");
		var newCustomerForm = "action=" + action + '&counter=' + counter + '&total_column=' + total_column + '&column_class=' + column_class + '&postID=<?php echo esc_js($postID);?>';
		jQuery.ajax({
			type:"POST",
			url: "<?php echo admin_url('admin-ajax.php')?>",
			data: newCustomerForm,
			success:function(data){
				jQuery('.builderload').html("");
				jQuery("#add_page_builder_item").append(data);
				jQuery('div.cs-drag-slider').each(function() {
					var _this = jQuery(this);
						_this.slider({
							range:'min',
							step: _this.data('slider-step'),
							min: _this.data('slider-min'),
							max: _this.data('slider-max'),
							value: _this.data('slider-value'),
							slide: function (event, ui) {
								jQuery(this).parents('li.to-field').find('.cs-range-input').val(ui.value)
							}
						});
					});
				jQuery('.bg_color').wpColorPicker(); 
				 jQuery( ".draginner" ) .sortable({
						connectWith: '.draginner',
						handle:'.column-in',
						cancel:'.draginner .poped-up,#confirmOverlay',
						revert:false,
						start: function( event, ui ) {jQuery(ui.item).css({"width":"25%"})},
						receive: function( event, ui ) {callme();},
						placeholder: "ui-state-highlight",
						forcePlaceholderSize:true
				   });
				 // if (count_widget > 0) jQuery("#no_widget").hide();
				//alert(count_widget);
			}
		});
		//return false;
	}
	
	function ajaxSubmitwidget(action,id){
		SuccessLoader ();
		counter++;
		var newCustomerForm = "action=" + action + '&counter=' + counter;
		var edit_url = action + counter;
		//jQuery('.composer-'+id).hide();
		jQuery.ajax({
			type:"POST",
			url: "<?php echo admin_url('admin-ajax.php')?>",
			data: newCustomerForm,
			success:function(data){
			jQuery("#counter_"+id).append(data);
			jQuery("#"+action+counter).append('<input type="hidden" name="cs_widget_element_num[]" value="form" />');
			jQuery('.bg_color').wpColorPicker(); 
			  jQuery( ".draginner" ) .sortable({
				connectWith: '.draginner',
				handle:'.column-in',
				cancel:'.draginner .poped-up,#confirmOverlay',
				revert:false,
				// start: function( event, ui ) {jQuery(ui.item).css({"width":"25%"})},
				receive: function( event, ui ) {callme();},
				placeholder: "ui-state-highlight",
				forcePlaceholderSize:true
		   });
			removeoverlay("composer-"+id,"append");
			jQuery('div.cs-drag-slider').each(function() {
					var _this = jQuery(this);
						_this.slider({
							range:'min',
							step: _this.data('slider-step'),
							min: _this.data('slider-min'),
							max: _this.data('slider-max'),
							value: _this.data('slider-value'),
							slide: function (event, ui) {
								jQuery(this).parents('li.to-field').find('.cs-range-input').val(ui.value)
							}
						});
					});
			callme(); 
			}
		});
	}
	function ajaxSubmitwidget_element(action,id,name){
		 SuccessLoader ();
		counter++;
		var newCustomerForm = "action=" + action + '&element_name=' + name + '&counter=' + counter;
		var edit_url = action + counter;
		//jQuery('.composer-'+id).hide();
		jQuery.ajax({
			type:"POST",
			url: "<?php echo admin_url('admin-ajax.php')?>",
			data: newCustomerForm,
			success:function(data){
			jQuery("#counter_"+id).append(data);
			//results-shortocde-id-form
			jQuery("#counter_"+id+" #results-shortocde-id-form").append('<input type="hidden" name="cs_widget_element_num[]" value="form" />');
			jQuery('.bg_color').wpColorPicker(); 
			  jQuery( ".draginner" ) .sortable({
				connectWith: '.draginner',
				handle:'.column-in',
				cancel:'.draginner .poped-up,#confirmOverlay',
				revert:false,
				// start: function( event, ui ) {jQuery(ui.item).css({"width":"25%"})},
				receive: function( event, ui ) {callme();},
				placeholder: "ui-state-highlight",
				forcePlaceholderSize:true
		   });
			removeoverlay("composer-"+id,"append");
			jQuery('div.cs-drag-slider').each(function() {
					var _this = jQuery(this);
						_this.slider({
							range:'min',
							step: _this.data('slider-step'),
							min: _this.data('slider-min'),
							max: _this.data('slider-max'),
							value: _this.data('slider-value'),
							slide: function (event, ui) {
								jQuery(this).parents('li.to-field').find('.cs-range-input').val(ui.value)
							}
						});
					});
			callme(); 
			}
		});
	}
	function ajaxSubmittt(action){
		 counter++;
		count_widget++;
		var newCustomerForm = "action=" + action + '&counter=' + counter;
		jQuery.ajax({
			type:"POST",
			url: "<?php echo admin_url()?>/admin-ajax.php",
			data: newCustomerForm,
			success:function(data){
				jQuery("#add_page_builder_item").append(data);
				if (count_widget > 0) jQuery("#add_page_builder_item").addClass('hasclass');
				//alert(count_widget);
			}
		});
		//return false;
	}
</script>
<?php
}

if ( isset($_POST['page_builder_form']) and $_POST['page_builder_form'] == 1 ) {
        add_action( 'save_post', 'save_page_builder' );
        function save_page_builder( $post_id ) {
            if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;


			    if ( isset($_POST['builder_active']) ) {
                    $sxe = new SimpleXMLElement("<pagebuilder></pagebuilder>");
                    if ( empty($_POST["builder_active"]) ) $_POST["builder_active"] = "";
                    if ( empty($_POST["page_content"]) ) $_POST["page_content"] = "";
                    $sxe->addChild('builder_active', $_POST['builder_active']);
                    $sxe->addChild('page_content', $_POST['page_content']);
                    //$sxe = '';
                                //if ( isset($_POST['cs_orderby']) ) {
									$cs_counter									= 0;
                                    $page_element_id							= 0;
                                    $cs_counter_gal								= 0;
                                    $cs_counter_port							= 0;
                                    $counter_team								= 0;
                                    $cs_counter_slider							= 0;
                                    $cs_counter_blog_slider						= 0;
                                    $cs_counter_blog							= 0;
                                    $cs_counter_sermon							= 0;
                                    $cs_counter_latest_sermon					= 0;
                                    $cs_counter_directory						= 0;
                                    $cs_counter_news							= 0;
                                    $cs_counter_contact							= 0;
                                    $cs_counter_contactus						= 0;
                                    $cs_counter_testimonial						= 0;
                                    $cs_counter_column							= 0;
                                    $cs_counter_mb								= 0;
                                    $cs_counter_image							= 0;
                                    $cs_counter_map								= 0;
                                    $cs_counter_services_node					= 0;
                                    $cs_counter_services						= 0;
                                    $cs_counter_tabs_node						= 0;
                                    $cs_counter_accordion_node					= 0;
                                    $cs_counter_highlight						= 0;
                                    $cs_counter_register						= 0;
                                    $cs_counter_testimonials_node				= 0;
                                    $cs_shortcode_counter_testimonial			= 0;
                                    $cs_global_counter_testimonials				= 0;
                                    $cs_counter_testimonials					= 0;
                                    $cs_counter_list							= 0;
                                    $cs_counter_lists_node						= 0;
                                    $cs_counter_team							= 0;
                                    $cs_counter_team_node						= 0;
                                    $counter_quote								= 0;
                                    $counter_video								= 0;
                                    $counter_quote								= 0;
                                    $counter_services							= 0;
                                    $counter_services_node						= 0;
                                    $cs_global_counter_services					= 0;
                                    $cs_shortcode_counter_services				= 0;
                                    $counter_tabs								= 0;
                                    $counter_tabs_node							= 0;
                                    $cs_shortcode_counter_tabs					= 0;
                                    $cs_global_counter_tabs						= 0;
                                    $counter_accordion							= 0;
                                    $counter_accordion_node						= 0;
                                    $cs_global_counter_accordion				= 0;
                                    $cs_shortcode_counter_accordion				= 0;
                                    $counter_faq								= 0;
                                    $counter_faq_node							= 0;
                                    $cs_global_counter_faq						= 0;
                                    $cs_shortcode_counter_faq					= 0;
                                    $cs_counter_toggle							= 0;
                                    $cs_global_counter_toggle					= 0;
                                    $cs_shortcode_counter_toggle				= 0;
                                    $cs_counter_parallax						= 0;
                                    $widget_no									= 0;
                                    $column_container_no						= 0;
                                    $cs_counter_dcpt							= 0;
                                    $cs_counter_pricetables						= 0;
                                    $cs_counter_pricetables_node				= 0;
                                    $cs_global_counter_pricetables				= 0;
                                    $cs_shortcode_counter_pricetables			= 0;
                                    $cs_counter_client							= 0;
                                    $cs_counter_image							= 0;
                                    $cs_counter_dropcap							= 0;
                                    $cs_counter_divider							= 0;
                                    $cs_counter_tooltip							= 0;
                                    $cs_counter_piecharts						= 0;
                                    $cs_global_counter_piecharts				= 0;
                                    $cs_shortcode_counter_piecharts				= 0;
                                    $cs_counter_progressbars					= 0;
                                    $cs_counter_progressbars_node				= 0;
                                    $cs_global_counter_progressbars				= 0;
                                    $cs_shortcode_counter_progressbars			= 0;
                                    $cs_counter_table							= 0;
                                    $cs_global_counter_table					= 0;
                                    $cs_shortcode_counter_table					= 0;
                                    $cs_counter_message							= 0;
                                    $cs_counter_heading							= 0;
                                    $cs_counter_button							= 0;
                                    $cs_counter_call_to_action					= 0;
                                    $cs_global_counter_call_to_action			= 0;
                                    $cs_shortcode_counter_call_to_action		= 0;
                                    $cs_counter_fancyheading					= 0;
                                    $cs_counter_promobox						= 0;
                                    $cs_counter_iconbox							= 0;
                                    $cs_counter_audio							= 0;
                                    $cs_counter_audio_node						= 0;
                                    $cs_counter_infobox							= 0;
                                    $cs_counter_infobox_node					= 0;
                                    $counter_coutner							= 0;
                                    $cs_global_counter_counter					= 0;
                                    $cs_shortcode_counter_counter				= 0;
                                    $counter_counter_item_node					= 0;
                                    $cs_counter_icons							= 0;
                                    $cs_counter_map								= 0;
                                    $cs_parallax_slider							= 0;
                                    $cs_parallax_video_url						= 0;
                                    $cs_parallax_video_mute						= 0;
                                    $cs_counter_offerslider						= 0;
                                    $cs_counter_clients							= 0;
                                    $cs_counter_clients_node					= 0;
                                    $cs_counter_contentslider					= 0;
                                    $cs_counter_page_element					= 0;
                                    $cs_counter_members							= 0;
                                    $cs_counter_spacer							= 0;
                                    $cs_counter_teams							= 0;
                                    $cs_counter_tweets							= 0;
                                    $cs_counter_richeditor						= 0;
                                    $cs_counter_apple							= 0;
                                    $cs_global_counter_message					= 0;
                                    $cs_shortcode_counter_message				= 0;
                                    $cs_global_counter_button					= 0;
                                    $cs_shortcode_counter_button				= 0;
                                    $cs_global_counter_column					= 0;
                                    $cs_shortcode_counter_column				= 0;
                                    $cs_global_counter_contactus				= 0;
                                    $cs_shortcode_counter_contactus				= 0;
                                    $cs_global_counter_tooltip					= 0;
                                    $cs_shortcode_counter_tooltip				= 0;
                                    $cs_global_counter_tweets					= 0;
                                    $cs_shortcode_counter_tweets				= 0;
                                    $cs_global_counter_heading					= 0;
                                    $cs_shortcode_counter_heading				= 0;
                                    $cs_global_counter_divider					= 0;
                                    $cs_shortcode_counter_divider				= 0;
                                    $cs_global_counter_quote					= 0;
                                    $cs_shortcode_counter_quote					= 0;
                                    $cs_global_counter_highlight				= 0;
                                    $cs_shortcode_counter_highlight				= 0;
                                    $cs_global_counter_register					= 0;
                                    $cs_shortcode_counter_register				= 0;
                                    $cs_global_counter_dropcap					= 0;
                                    $cs_shortcode_counter_dropcap				= 0;
                                    $cs_global_counter_list						= 0;
                                    $cs_shortcode_counter_list					= 0;
                                    $cs_global_counter_richeditor				= 0;
                                    $cs_shortcode_counter_richeditor			= 0;
                                    $cs_global_counter_blog_slider				= 0;
                                    $cs_shortcode_counter_blog_slider			= 0;
                                    $cs_global_counter_blog						= 0;
                                    $cs_global_counter_sermon					= 0;
                                    $cs_global_counter_latest_sermon			= 0;
                                    $cs_shortcode_counter_blog					= 0;
                                    $cs_shortcode_counter_sermon				= 0;
                                    $cs_shortcode_counter_latest_sermon			= 0;
                                    $cs_global_counter_teams					= 0;
                                    $cs_shortcode_counter_teams					= 0;
                                    $cs_global_counter_clients					= 0;
                                    $cs_shortcode_counter_clients				= 0;
                                    $cs_global_counter_page_element				= 0;
                                    $cs_shortcode_counter_page_element			= 0;
                                    $cs_global_counter_image					= 0;
                                    $cs_shortcode_counter_image					= 0;
                                    $cs_global_counter_promobox					= 0;
                                    $cs_shortcode_counter_promobox				= 0;
                                   
                                  
                                    $cs_global_counter_video					= 0;
                                    $cs_shortcode_counter_video					= 0;
                                    $cs_global_counter_audio					= 0;
                                    $cs_shortcode_counter_audio					= 0;
                                    $cs_counter_offerslider_node				= 0;
                                    $cs_global_counter_offerslider				= 0;
                                    $cs_shortcode_counter_offerslider			= 0;
                                    $cs_global_counter_spacer					= 0;
                                    $cs_shortcode_counter_spacer				= 0;
                                    $cs_global_counter_map						= 0;
                                    $cs_shortcode_counter_map					= 0;
                                    $cs_global_counter_icons					= 0;
                                    $cs_shortcode_counter_icons					= 0;
                                    $cs_global_counter_contentslider			= 0;
                                    $cs_shortcode_counter_contentslider			= 0;
                                    $cs_global_counter_members					= 0;
                                    $cs_shortcode_counter_members				= 0;
                                    $cs_global_counter_page_element				= 0;
                                    $cs_shortcode_counter_page_element			= 0;
                                    $cs_global_counter_infobox					= 0;
                                    $cs_shortcode_counter_infobox				= 0;
                                    $cs_shortcode_counter_slider				= 0;
                                    $cs_global_counter_slider					= 0;                                    
                                    $counter_badges								= 0;
                                    $cs_global_counter_badges					= 0;
                                    $cs_shortcode_counter_badges				= 0;                                    
                                    $cs_counter_events							= 0;
                                    $cs_global_counter_events					= 0;
                                    $cs_shortcode_counter_events				= 0; 
									
									$cs_global_counter_course = 0;
									$cs_shortcode_counter_course = 0;
									$cs_counter_course = 0;
									
									
									
									$cs_counter_rooms							= 0;
                                    $cs_global_counter_rooms					= 0;
                                    $cs_shortcode_counter_rooms				    = 0;                                    
                                    $cs_global_counter_directory				= 0;
                                    $cs_shortcode_counter_directory				= 0;
                                    $cs_counter_directory						= 0;                                    
                                    $cs_global_counter_directory_search			= 0;
                                    $cs_shortcode_counter_directory_search		= 0;
                                    $cs_counter_directory_search				= 0;                                    
                                    $cs_global_counter_directory_map			= 0;
                                    $cs_shortcode_counter_directory_map			= 0;
                                    $cs_counter_directory_map					= 0;                                    
                                    $cs_global_counter_latest_directory			= 0;
                                    $cs_shortcode_counter_latest_directory		= 0;
                                    $cs_counter_latest_directory				= 0;
                                    $cs_global_counter_directory_pkg			= 0;
									$cs_shortcode_counter_directory_pkg			= 0;
									$cs_counter_directory_pkg					= 0;
                                    $directory_categories						= 0;
                                    $cs_global_counter_directory_categories		= 0;
                                    $cs_shortcode_counter_directory_categories	= 0;
                                    $cs_counter_directory_categories			= 0;                                    
                                    $cs_global_counter_project					= 0;
                                    $cs_shortcode_counter_project				= 0;
                                    $cs_counter_project							= 0;
									
									$cs_global_counter_mailchimp				= 0;
									$cs_counter_mailchimp						= 0;
									$cs_shortcode_counter_mailchimp				= 0;
									
									$cs_global_counter_team_post				= 0;
									$cs_shortcode_counter_team_post				= 0;
									$cs_counter_team_post						= 0;
									
									$cs_global_counter_portfolio				= 0;
									$cs_shortcode_counter_portfolio				= 0;
									$cs_counter_portfolio						= 0;
								
									$cs_shortcode_counter_multiple_services		= 0;
									$cs_global_counter_multiple_services		= 0;
									$cs_counter_multiple_services				= 0;
									$cs_counter_multiple_services_node			= 0;
						
									$cs_shortcode_counter_facilities			= 0;
									$cs_global_counter_facilities				= 0;
									$cs_counter_facilities						= 0;
									$cs_counter_facilities_node					= 0;
									$cs_counter_gallery=0;
									$cs_global_counter_gallery=0;
									$cs_shortcode_counter_gallery=0;
									$cs_counter_quick_quote						= 0;
									$cs_shortcode_counter_quick_quote			= 0;
									$cs_global_counter_quick_quote				= 0;
									$cs_global_counter_openinghours = 0;
									$cs_shortcode_counter_openinghours = 0;
									$cs_counter_openinghours = 0;
									$cs_counter_openinghours_node = 0;
									
									$cs_counter_categories = 0;
									$cs_shortcode_counter_categories = 0;
									$cs_global_counter_categories = 0;
									
									$cs_global_counter_sitemap                  = 0;
									$cs_counter_sitemap                        	= 0;
									$cs_counter_sitemap                         = 0;
									
								 
									
									 $cs_global_counter_search				= 0;
                                    $cs_shortcode_counter_search			= 0;
									  $cs_counter_search						= 0;
									
									
									
									$cs_counter_job_specialisms = 0;
									$cs_shortcode_counter_job_specialisms = 0;
									$cs_global_counter_job_specialisms = 0;
							
                                    
                                	if(isset($_POST['total_column'])){    
                                        foreach ( $_POST['total_column'] as $count_column ) {
										
										// Sections Element Attributes start
                                        $column_container = $sxe->addChild('column_container');
                                        if ( empty($_POST['column_class'][$column_container_no]) ) $_POST['column_class'][$column_container_no] = "";
                                        $column_container->addAttribute('class', $_POST['column_class'][$column_container_no] );
                                        $column_rand_id = $_POST['column_rand_id'][$column_container_no];
                                        
                                        //cs_section_background_option
                                        if ( empty($_POST['cs_section_background_option'][$column_container_no]) ) $_POST['cs_section_background_option'][$column_container_no] = "";
                                        if ( empty($_POST['cs_section_bg_image'][$column_container_no]) ) $_POST['cs_section_bg_image'][$column_container_no] = "";
                                        if ( empty($_POST['cs_section_bg_image_position'][$column_container_no]) ) $_POST['cs_section_bg_image_position'][$column_container_no] = "";
										if ( empty($_POST['cs_section_bg_image_repeat'][$column_container_no]) ) $_POST['cs_section_bg_image_repeat'][$column_container_no] = "";
                                        if ( empty($_POST['cs_section_flex_slider'][$column_container_no]) ) $_POST['cs_section_flex_slider'][$column_container_no] = "";
                                        if ( empty($_POST['cs_section_video_url'][$column_container_no]) ) $_POST['cs_section_video_url'][$column_container_no] = "";
                                        if ( empty($_POST['cs_section_video_mute'][$column_container_no]) ) $_POST['cs_section_video_mute'][$column_container_no] = "";
                                        if ( empty($_POST['cs_section_video_autoplay'][$column_container_no]) ) $_POST['cs_section_video_autoplay'][$column_container_no] = "";
                                        if ( empty($_POST['cs_section_bg_color'][$column_container_no]) ) $_POST['cs_section_bg_color'][$column_container_no] = "";
                                        if ( empty($_POST['cs_section_padding_top'][$column_container_no]) ) $_POST['cs_section_padding_top'][$column_container_no] = "";
                                        if ( empty($_POST['cs_section_padding_bottom'][$column_container_no]) ) $_POST['cs_section_padding_bottom'][$column_container_no] = "";
                                        if ( empty($_POST['cs_section_parallax'][$column_container_no]) ) $_POST['cs_section_parallax'][$column_container_no] = "";
                                        if ( empty($_POST['cs_section_css_id'][$column_container_no]) ) $_POST['cs_section_css_id'][$column_container_no] = "";
                                        if ( empty($_POST['cs_section_view'][$column_rand_id]['0']) ) $_POST['cs_section_view'][$column_rand_id] = "";
                                        if ( empty($_POST['cs_layout'][$column_rand_id]['0']) ) $_POST['cs_layout'][$column_rand_id]['0'] = "";
                                        $column_container->addAttribute('cs_section_background_option', $_POST['cs_section_background_option'][$column_container_no] );
                                        $column_container->addAttribute('cs_section_bg_image', $_POST['cs_section_bg_image'][$column_container_no] );
                                        $column_container->addAttribute('cs_section_bg_image_position', $_POST['cs_section_bg_image_position'][$column_container_no] );
										$column_container->addAttribute('cs_section_bg_image_repeat', $_POST['cs_section_bg_image_repeat'][$column_container_no] );
                                        $column_container->addAttribute('cs_section_flex_slider', $_POST['cs_section_flex_slider'][$column_container_no] );
                                        $column_container->addAttribute('cs_section_custom_slider', $_POST['cs_section_custom_slider'][$column_container_no] );
                                        $column_container->addAttribute('cs_section_video_url', $_POST['cs_section_video_url'][$column_container_no] );
                                        $column_container->addAttribute('cs_section_video_mute', $_POST['cs_section_video_mute'][$column_container_no] );
                                        $column_container->addAttribute('cs_section_video_autoplay', $_POST['cs_section_video_autoplay'][$column_container_no] );
                                        $column_container->addAttribute('cs_section_bg_color', $_POST['cs_section_bg_color'][$column_container_no] );
                                        $column_container->addAttribute('cs_section_padding_top', $_POST['cs_section_padding_top'][$column_container_no] );
                                        $column_container->addAttribute('cs_section_padding_bottom', $_POST['cs_section_padding_bottom'][$column_container_no] );
                                        $column_container->addAttribute('cs_section_border_bottom', $_POST['cs_section_border_bottom'][$column_container_no] );
                                        $column_container->addAttribute('cs_section_border_top', $_POST['cs_section_border_top'][$column_container_no] );
                                        $column_container->addAttribute('cs_section_border_color', $_POST['cs_section_border_color'][$column_container_no] );
                                        $column_container->addAttribute('cs_section_margin_top', $_POST['cs_section_margin_top'][$column_container_no] );
                                        $column_container->addAttribute('cs_section_margin_bottom', $_POST['cs_section_margin_bottom'][$column_container_no] );
                                        $column_container->addAttribute('cs_section_parallax', $_POST['cs_section_parallax'][$column_container_no] );
                                        $column_container->addAttribute('cs_section_css_id', $_POST['cs_section_css_id'][$column_container_no] );
                                        $column_container->addAttribute('cs_section_view', $_POST['cs_section_view'][$column_container_no] );
                                        $column_container->addAttribute('cs_layout', $_POST['cs_layout'][$column_rand_id]['0'] );
                                        $column_container->addAttribute('cs_sidebar_left', $_POST['cs_sidebar_left'][$column_container_no] );
                                        $column_container->addAttribute('cs_sidebar_right', $_POST['cs_sidebar_right'][$column_container_no] );
                                        // Sections Element Attributes end
                                        for ( $i = 0; $i < $count_column; $i++ ) {
                                            $column = $column_container->addChild('column');
                                            $a = $_POST['total_widget'][$widget_no];
                                            for ( $j = 1; $j <= $a; $j++ ){    
                                            $page_element_id++;
                                           if ($_POST['cs_orderby'][$cs_counter] == "flex_column") {
                                $shortcode = '';
                                $flex_column = $column->addChild('flex_column');
                                $flex_column->addChild('page_element_size', htmlspecialchars($_POST['flex_column_element_size'][$cs_global_counter_column]));
                                $flex_column->addChild('flex_column_element_size', htmlspecialchars($_POST['flex_column_element_size'][$cs_global_counter_column]));
                                if (isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode') {


                                    $shortcode_str = stripslashes(htmlspecialchars(( $_POST['shortcode']['flex_column'][$cs_shortcode_counter_column]), ENT_QUOTES));
                                    $cs_shortcode_counter_column++;
                                    $flex_column->addChild('cs_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES));
                                } else {
                                    $shortcode .= '[' . CS_SC_COLUMN . ' ';
                                    if (isset($_POST['flex_column_section_title'][$cs_counter_column]) && $_POST['flex_column_section_title'][$cs_counter_column] != '') {
                                        $shortcode .= 'flex_column_section_title="' . stripslashes(htmlspecialchars(($_POST['flex_column_section_title'][$cs_counter_column]), ENT_QUOTES)) . '" ';
                                    }

                                    if (isset($_POST['content_title_color'][$cs_counter_column]) && $_POST['content_title_color'][$cs_counter_column] != '') {
                                        $shortcode .= 'content_title_color="' . stripslashes(htmlspecialchars(($_POST['content_title_color'][$cs_counter_column]), ENT_QUOTES)) . '" ';
                                    }

                                    if (isset($_POST['column_bg_color'][$cs_counter_column]) && $_POST['column_bg_color'][$cs_counter_column] != '') {
                                        $shortcode .= 'column_bg_color="' . stripslashes(htmlspecialchars(($_POST['column_bg_color'][$cs_counter_column]), ENT_QUOTES)) . '" ';
                                    }


                                    if (isset($_POST['cs_image_url'][$cs_counter_column]) && $_POST['cs_image_url'][$cs_counter_column] != '') {
                                        $shortcode .= 'cs_image_url="' . htmlspecialchars($_POST['cs_image_url'][$cs_counter_column], ENT_QUOTES) . '" ';
                                    }



                                    if (isset($_POST['cs_column_class'][$cs_counter_column]) && $_POST['cs_column_class'][$cs_counter_column] != '') {
                                        $shortcode .= 'cs_column_class="' . htmlspecialchars($_POST['cs_column_class'][$cs_counter_column], ENT_QUOTES) . '" ';
                                    }
                                    if (isset($_POST['cs_column_animation'][$cs_counter_column]) && $_POST['cs_column_animation'][$cs_counter_column] != '') {
                                        $shortcode .= 'cs_column_animation="' . htmlspecialchars($_POST['cs_column_animation'][$cs_counter_column]) . '" ';
                                    }
                                    $shortcode .=']';
                                    if (isset($_POST['flex_column_text'][$cs_counter_column]) && $_POST['flex_column_text'][$cs_counter_column] != '') {
                                        $shortcode .= esc_textarea(cs_custom_shortcode_encode($_POST['flex_column_text'][$cs_counter_column])) . ' ';
                                    }

                                    $shortcode .= '[/' . CS_SC_COLUMN . ']';
                                    //var_dump($shortcode); die;
                                    $flex_column->addChild('cs_shortcode', $shortcode);
                                    $cs_counter_column++;
                                }
                                $cs_global_counter_column++;
                            }
							// Save Form page element 
							else if ( $_POST['cs_orderby'][$cs_counter] == "contactus" ) {
										$shortcode = '';
										$contact_us = $column->addChild('contactus');
										$contact_us->addChild('page_element_size', htmlspecialchars($_POST['contactus_element_size'][$cs_global_counter_contactus]) );
										$contact_us->addChild('contactus_element_size', htmlspecialchars($_POST['contactus_element_size'][$cs_global_counter_contactus]) );
										if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
											$shortcode_str = stripslashes ($_POST['shortcode']['contactus'][$cs_shortcode_counter_contactus]);
											$cs_shortcode_counter_contactus++;
											$contact_us->addChild('cs_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES) );
										} else {
											
											$shortcode .= '['.CS_SC_CONTACTUS.' ';
											if(isset($_POST['cs_contactus_section_title'][$cs_counter_contactus]) && $_POST['cs_contactus_section_title'][$cs_counter_contactus] != ''){
												$shortcode .=     'cs_contactus_section_title="'.htmlspecialchars($_POST['cs_contactus_section_title'][$cs_counter_contactus], ENT_QUOTES).'" ';
											}
											if(isset($_POST['cs_contactus_label'][$cs_counter_contactus]) && $_POST['cs_contactus_label'][$cs_counter_contactus] != ''){
												$shortcode .=     'cs_contactus_label="'.htmlspecialchars($_POST['cs_contactus_label'][$cs_counter_contactus], ENT_QUOTES).'" ';
											}
											if(isset($_POST['cs_contactus_view'][$cs_counter_contactus]) && $_POST['cs_contactus_view'][$cs_counter_contactus] != ''){
												$shortcode .=     'cs_contactus_view="'.htmlspecialchars($_POST['cs_contactus_view'][$cs_counter_contactus], ENT_QUOTES).'" ';
											}
											if(isset($_POST['cs_contactus_send'][$cs_counter_contactus]) && $_POST['cs_contactus_send'][$cs_counter_contactus] != ''){
												$shortcode .=     'cs_contactus_send="'.htmlspecialchars($_POST['cs_contactus_send'][$cs_counter_contactus], ENT_QUOTES).'" ';
											}
											if(isset($_POST['cs_success'][$cs_counter_contactus]) && $_POST['cs_success'][$cs_counter_contactus] != ''){
												$shortcode .=     'cs_success="'.htmlspecialchars($_POST['cs_success'][$cs_counter_contactus], ENT_QUOTES).'" ';
											}
											if(isset($_POST['cs_error'][$cs_counter_contactus]) && $_POST['cs_error'][$cs_counter_contactus] != ''){
												$shortcode .=     'cs_error="'.htmlspecialchars($_POST['cs_error'][$cs_counter_contactus], ENT_QUOTES).'" ';
											}
											if(isset($_POST['cs_form_id'][$cs_counter_contactus]) && $_POST['cs_form_id'][$cs_counter_contactus] != ''){
												$shortcode .=     'cs_form_id="'.htmlspecialchars($_POST['cs_form_id'][$cs_counter_contactus], ENT_QUOTES).'" ';
											}
											if(isset($_POST['cs_contact_class'][$cs_counter_contactus]) && $_POST['cs_contact_class'][$cs_counter_contactus] != ''){
												$shortcode .=     'cs_contact_class="'.htmlspecialchars($_POST['cs_contact_class'][$cs_counter_contactus], ENT_QUOTES).'" ';
											}
											if(isset($_POST['cs_contact_animation'][$cs_counter_contactus]) && $_POST['cs_contact_animation'][$cs_counter_contactus] != ''){
												$shortcode .=     'cs_contact_animation="'.htmlspecialchars($_POST['cs_contact_animation'][$cs_counter_contactus], ENT_QUOTES).'" ';
											}
											$shortcode .=     ']';
											
											$contact_us->addChild('cs_shortcode', $shortcode );
											$cs_counter_contactus++;
										}
									$cs_global_counter_contactus++;
							}
							
							else if ( $_POST['cs_orderby'][$cs_counter] == "quick_quote" ) {
									$shortcode = '';
									$contact_us = $column->addChild('quick_quote');
									$contact_us->addChild('page_element_size', htmlspecialchars($_POST['quick_quote_element_size'][$cs_global_counter_quick_quote]) );
									$contact_us->addChild('quick_quote_element_size', htmlspecialchars($_POST['quick_quote_element_size'][$cs_global_counter_quick_quote]) );
									if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
										$shortcode_str = stripslashes ($_POST['shortcode']['quick_quote'][$cs_shortcode_counter_quick_quote]);
										$cs_shortcode_counter_quick_quote++;
										$contact_us->addChild('cs_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES) );
									} else {
										
										$shortcode .= '['.CS_SC_QUICK_QUOTE.' ';
										if(isset($_POST['cs_quick_quote_section_title'][$cs_counter_quick_quote]) && $_POST['cs_quick_quote_section_title'][$cs_counter_quick_quote] != ''){
											$shortcode .=     'cs_quick_quote_section_title="'.htmlspecialchars($_POST['cs_quick_quote_section_title'][$cs_counter_quick_quote], ENT_QUOTES).'" ';
										}
										if(isset($_POST['cs_quick_quote_view'][$cs_counter_quick_quote]) && $_POST['cs_quick_quote_view'][$cs_counter_quick_quote] != ''){
											$shortcode .=     'cs_quick_quote_view="'.htmlspecialchars($_POST['cs_quick_quote_view'][$cs_counter_quick_quote], ENT_QUOTES).'" ';
										}
										if(isset($_POST['cs_quick_quote_send'][$cs_counter_quick_quote]) && $_POST['cs_quick_quote_send'][$cs_counter_quick_quote] != ''){
											$shortcode .=     'cs_quick_quote_send="'.htmlspecialchars($_POST['cs_quick_quote_send'][$cs_counter_quick_quote], ENT_QUOTES).'" ';
										}
										if(isset($_POST['cs_success'][$cs_counter_quick_quote]) && $_POST['cs_success'][$cs_counter_quick_quote] != ''){
											$shortcode .=     'cs_success="'.htmlspecialchars($_POST['cs_success'][$cs_counter_quick_quote], ENT_QUOTES).'" ';
										}
										if(isset($_POST['cs_error'][$cs_counter_quick_quote]) && $_POST['cs_error'][$cs_counter_quick_quote] != ''){
											$shortcode .=     'cs_error="'.htmlspecialchars($_POST['cs_error'][$cs_counter_quick_quote], ENT_QUOTES).'" ';
										}
										$shortcode .=     ']';
											if (isset($_POST['cs_quick_quote_text'][$cs_counter_quick_quote]) && $_POST['cs_quick_quote_text'][$cs_counter_quick_quote] != '') {
											$shortcode .= esc_textarea($_POST['cs_quick_quote_text'][$cs_counter_quick_quote]) . ' ';
										}
	
										$shortcode .= '[/' . CS_SC_QUICK_QUOTE . ']';
										$contact_us->addChild('cs_shortcode', $shortcode );
										$cs_counter_quick_quote++;
									}
								$cs_global_counter_quick_quote++;
							}
                                 
							/*Call to action*/
							   else if ( $_POST['cs_orderby'][$cs_counter] == "call_to_action" ) {
								   
								 		$shortcode         = '';
										$call_to_action = $column->addChild('call_to_action');
										$call_to_action->addChild('page_element_size', htmlspecialchars($_POST['call_to_action_element_size'][$cs_global_counter_call_to_action]) );
										$call_to_action->addChild('call_to_action_element_size', htmlspecialchars($_POST['call_to_action_element_size'][$cs_global_counter_call_to_action]) );
										if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
											$shortcode_str = htmlspecialchars( stripslashes ($_POST['shortcode']['call_to_action'][$cs_shortcode_counter_call_to_action]));
											$cs_shortcode_counter_call_to_action++;
											$call_to_action->addChild('cs_shortcode', htmlspecialchars($shortcode_str) );
										} else {
											 
											$shortcode .= '['.CS_SC_CALLTOACTION.' ';
											
											if(isset($_POST['cs_call_to_action_section_title'][$cs_counter_call_to_action]) && $_POST['cs_call_to_action_section_title'][$cs_counter_call_to_action] != ''){
												$shortcode .= ' cs_call_to_action_section_title="'.htmlspecialchars($_POST['cs_call_to_action_section_title'][$cs_counter_call_to_action], ENT_QUOTES).'" ';
											}
											
				if(isset($_POST['cs_call_to_action_text'][$cs_counter_call_to_action]) && $_POST['cs_call_to_action_text'][$cs_counter_call_to_action] != ''){$shortcode .= ' cs_call_to_action_text="'.htmlspecialchars($_POST['cs_call_to_action_text'][$cs_counter_call_to_action], ENT_QUOTES).'" ';
											}
			if(isset($_POST['cs_call_view'][$cs_counter_call_to_action]) && $_POST['cs_call_view'][$cs_counter_call_to_action] != ''){$shortcode .= ' cs_call_view="'.htmlspecialchars($_POST['cs_call_view'][$cs_counter_call_to_action], ENT_QUOTES).'" ';}
			
			
			                         if(isset($_POST['cs_call_to_action_view'][$cs_counter_call_to_action]) && $_POST['cs_call_to_action_view'][$cs_counter_call_to_action] != ''){$shortcode .= ' cs_call_to_action_view="'.htmlspecialchars($_POST['cs_call_to_action_view'][$cs_counter_call_to_action], ENT_QUOTES).'" ';}
			
			
											
											
											if(isset($_POST['cs_content_type'][$cs_counter_call_to_action]) && trim($_POST['cs_content_type'][$cs_counter_call_to_action]) <> ''){
												$shortcode .=     'cs_content_type="'.htmlspecialchars($_POST['cs_content_type'][$cs_counter_call_to_action]).'" ';
											}
											if(isset($_POST['cs_call_action_title'][$cs_counter_call_to_action]) && trim($_POST['cs_call_action_title'][$cs_counter_call_to_action]) <> ''){
												$shortcode .=     'cs_call_action_title="'.htmlspecialchars($_POST['cs_call_action_title'][$cs_counter_call_to_action], ENT_QUOTES).'" ';
											}
											
											if(isset($_POST['cs_contents_color'][$cs_counter_call_to_action]) && trim($_POST['cs_contents_color'][$cs_counter_call_to_action]) <> ''){
												$shortcode .= 'cs_contents_color="'.htmlspecialchars($_POST['cs_contents_color'][$cs_counter_call_to_action]).'" ';
											}
											
											if(isset($_POST['cs_title_color'][$cs_counter_call_to_action]) && trim($_POST['cs_title_color'][$cs_counter_call_to_action]) <> ''){
												$shortcode .='cs_title_color="'.htmlspecialchars($_POST['cs_title_color'][$cs_counter_call_to_action]).'" ';
											}
											if(isset($_POST['cs_contents_color'][$cs_counter_call_to_action]) && trim($_POST['cs_contents_color'][$cs_counter_call_to_action]) <> ''){
												$shortcode .= 'cs_contents_color="'.htmlspecialchars($_POST['cs_contents_color'][$cs_counter_call_to_action]).'" ';
											}
											if(isset($_POST['cs_call_action_icon'][$cs_counter_call_to_action]) && trim($_POST['cs_call_action_icon'][$cs_counter_call_to_action]) <> ''){
												$shortcode .='cs_call_action_icon="'.htmlspecialchars($_POST['cs_call_action_icon'][$cs_counter_call_to_action]).'" ';
											}
											if(isset($_POST['cs_icon_color'][$cs_counter_call_to_action]) && trim($_POST['cs_icon_color'][$cs_counter_call_to_action]) <> ''){
												$shortcode .='cs_icon_color="'.htmlspecialchars($_POST['cs_icon_color'][$cs_counter_call_to_action]).'" ';
											}
											if(isset($_POST['cs_call_to_action_icon_background_color'][$cs_counter_call_to_action]) && trim($_POST['cs_call_to_action_icon_background_color'][$cs_counter_call_to_action]) <> ''){
												$shortcode .='cs_call_to_action_icon_background_color="'.htmlspecialchars($_POST['cs_call_to_action_icon_background_color'][$cs_counter_call_to_action]).'" ';
											}
											if(isset($_POST['cs_show_button'][$cs_counter_call_to_action]) && trim($_POST['cs_show_button'][$cs_counter_call_to_action]) <> ''){
												$shortcode .=     'cs_show_button="'.htmlspecialchars($_POST['cs_show_button'][$cs_counter_call_to_action]).'" ';
											}
											if(isset($_POST['cs_call_to_action_button_text'][$cs_counter_call_to_action]) && trim($_POST['cs_call_to_action_button_text'][$cs_counter_call_to_action]) <> ''){
												$shortcode .='cs_call_to_action_button_text="'.htmlspecialchars($_POST['cs_call_to_action_button_text'][$cs_counter_call_to_action], ENT_QUOTES).'" ';
											}
											if(isset($_POST['cs_call_short_text'][$cs_counter_call_to_action]) && trim($_POST['cs_call_short_text'][$cs_counter_call_to_action]) <> ''){
												$shortcode .='cs_call_short_text="'.htmlspecialchars($_POST['cs_call_short_text'][$cs_counter_call_to_action], ENT_QUOTES).'" ';
											}
											
											if(isset($_POST['cs_call_to_action_button_link'][$cs_counter_call_to_action]) && trim($_POST['cs_call_to_action_button_link'][$cs_counter_call_to_action]) <> ''){
												$shortcode .='cs_call_to_action_button_link="'.htmlspecialchars($_POST['cs_call_to_action_button_link'][$cs_counter_call_to_action]).'" ';
											}
											
							if(isset($_POST['cs_call_to_action_icon_button_color'][$cs_counter_call_to_action]) && trim($_POST['cs_call_to_action_icon_button_color'][$cs_counter_call_to_action]) <> ''){
								$shortcode .='cs_call_to_action_icon_button_color="'.htmlspecialchars($_POST['cs_call_to_action_icon_button_color'][$cs_counter_call_to_action]).'" ';
							}
							
							if(isset($_POST['cs_call_to_action_button_bg_color'][$cs_counter_call_to_action]) && trim($_POST['cs_call_to_action_button_bg_color'][$cs_counter_call_to_action]) <> ''){
								$shortcode .='cs_call_to_action_button_bg_color="'.htmlspecialchars($_POST['cs_call_to_action_button_bg_color'][$cs_counter_call_to_action]).'" ';
							}
							
							
											
											if(isset($_POST['cs_call_to_action_bg_img'][$cs_counter_call_to_action]) && trim($_POST['cs_call_to_action_bg_img'][$cs_counter_call_to_action]) <> ''){
												$shortcode .= 'cs_call_to_action_bg_img="'.htmlspecialchars($_POST['cs_call_to_action_bg_img'][$cs_counter_call_to_action]).'" ';
											}
											
											
											if(isset($_POST['cs_call_to_action_left_img'][$cs_counter_call_to_action]) && trim($_POST['cs_call_to_action_left_img'][$cs_counter_call_to_action]) <> ''){
												$shortcode .= 'cs_call_to_action_left_img="'.htmlspecialchars($_POST['cs_call_to_action_left_img'][$cs_counter_call_to_action]).'" ';
											}
											
											
											
											
											if(isset($_POST['cs_call_to_action_class'][$cs_counter_call_to_action]) && $_POST['cs_call_to_action_class'][$cs_counter_call_to_action] != ''){
												$shortcode .= 'cs_call_to_action_class="'.htmlspecialchars($_POST['cs_call_to_action_class'][$cs_counter_call_to_action], ENT_QUOTES).'" ';
											}
									 		if(isset($_POST['cs_call_to_action_animation'][$cs_counter_call_to_action]) && $_POST['cs_call_to_action_animation'][$cs_counter_call_to_action] != ''){
												$shortcode .='cs_call_to_action_animation="'.htmlspecialchars($_POST['cs_call_to_action_animation'][$cs_counter_call_to_action]).'" ';
											}
											$shortcode .=']';
											
											$shortcode .=     '[/'.CS_SC_CALLTOACTION.']';
																							
											$call_to_action->addChild('cs_shortcode', $shortcode );
											$cs_counter_call_to_action++;
										}
										$cs_global_counter_call_to_action++;
									}
									
								else if ($_POST['cs_orderby'][$cs_counter] == "video") {
                                $shortcode = '';
                                $video = $column->addChild('video');
                                $video->addChild('page_element_size', htmlspecialchars($_POST['video_element_size'][$cs_global_counter_video]));
                                if (isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode') {
                                    $shortcode_str = stripslashes($_POST['shortcode']['video'][$cs_shortcode_counter_video]);
                                    $cs_shortcode_counter_video++;
                                    $video->addChild('cs_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES));
                                } else {
                                    $shortcode .= '[' . CS_SC_VIDEO . ' ';
                                    if (isset($_POST['cs_video_section_title'][$counter_video]) && $_POST['cs_video_section_title'][$counter_video] != '') {
                                        $shortcode .='cs_video_section_title="' . htmlspecialchars($_POST['cs_video_section_title'][$counter_video], ENT_QUOTES) . '" ';
                                    }if (isset($_POST['video_url'][$counter_video]) && $_POST['video_url'][$counter_video] != '') {
                                        $shortcode .='video_url="' . htmlspecialchars($_POST['video_url'][$counter_video], ENT_QUOTES) . '" ';
                                    }if (isset($_POST['video_width'][$counter_video]) && $_POST['video_width'][$counter_video] != '') {
                                        $shortcode .='video_width="' . htmlspecialchars($_POST['video_width'][$counter_video]) . '" ';
                                    }if (isset($_POST['video_height'][$counter_video]) && $_POST['video_height'][$counter_video] != '') {
                                        $shortcode .='video_height="' . htmlspecialchars($_POST['video_height'][$counter_video]) . '" ';
                                    }if (isset($_POST['cs_video_custom_class'][$counter_video]) && $_POST['cs_video_custom_class'][$counter_video] != '') {
                                        $shortcode .='cs_video_custom_class="' . htmlspecialchars($_POST['cs_video_custom_class'][$counter_video], ENT_QUOTES) . '" ';
                                    }
                                    $shortcode .= ']';
                                    $video->addChild('cs_shortcode', $shortcode);
                                    $counter_video++;
                                }
                                $cs_global_counter_video++;
                            }
									
									  // Save heading page element 
                                        else if ( $_POST['cs_orderby'][$cs_counter] == "heading" ) {
                                                $shortcode = '';
                                                $heading = $column->addChild('heading');
                                                $heading->addChild('page_element_size', htmlspecialchars($_POST['heading_element_size'][$cs_global_counter_heading]) );
                                                $heading->addChild('heading_element_size', htmlspecialchars($_POST['heading_element_size'][$cs_global_counter_heading]) );
                                                if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
                                                    $shortcode_str = stripslashes($_POST['shortcode']['heading'][$cs_shortcode_counter_heading]);
                                                    $cs_shortcode_counter_heading++;
                                                    $heading->addChild('cs_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES) );
                                                } else {
                                                   
													$shortcode .= '['.CS_SC_HEADING.' ';
                                                    if(isset($_POST['heading_title'][$cs_counter_heading]) && $_POST['heading_title'][$cs_counter_heading] != ''){
                                                        $shortcode .=     'heading_title="'.htmlspecialchars($_POST['heading_title'][$cs_counter_heading], ENT_QUOTES).'" ';
                                                    }
													
													if(isset($_POST['sub_heading_title'][$cs_counter_heading]) && $_POST['sub_heading_title'][$cs_counter_heading] != ''){
                                                        $shortcode .=     'sub_heading_title="'.htmlspecialchars($_POST['sub_heading_title'][$cs_counter_heading], ENT_QUOTES).'" ';
                                                    }
													
                                                    if(isset($_POST['heading_style'][$cs_counter_heading]) && $_POST['heading_style'][$cs_counter_heading] != ''){
                                                        $shortcode .=     'heading_style="'.htmlspecialchars($_POST['heading_style'][$cs_counter_heading]).'" ';
                                                    }
                                                    if(isset($_POST['heading_size'][$cs_counter_heading]) && $_POST['heading_size'][$cs_counter_heading] != ''){
                                                        $shortcode .=     'heading_size="'.htmlspecialchars($_POST['heading_size'][$cs_counter_heading], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['heading_align'][$cs_counter_heading]) && $_POST['heading_align'][$cs_counter_heading] != ''){
                                                        $shortcode .=     'heading_align="'.htmlspecialchars($_POST['heading_align'][$cs_counter_heading], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['heading_font_style'][$cs_counter_heading]) && $_POST['heading_font_style'][$cs_counter_heading] != ''){
                                                        $shortcode .=     'heading_font_style="'.htmlspecialchars($_POST['heading_font_style'][$cs_counter_heading], ENT_QUOTES).'" ';
                                                    }
													
                                                    if(isset($_POST['bottom_border'][$cs_counter_heading]) && $_POST['bottom_border'][$cs_counter_heading] != ''){
                                                        $shortcode .=     'bottom_border="'.htmlspecialchars($_POST['bottom_border'][$cs_counter_heading]).'" ';
                                                    }
													
													 if(isset($_POST['heading_divider'][$cs_counter_heading]) && $_POST['heading_divider'][$cs_counter_heading] != ''){
                                                        $shortcode .=     'heading_divider="'.htmlspecialchars($_POST['heading_divider'][$cs_counter_heading]).'" ';
                                                    }
													
                                                    if(isset($_POST['heading_color'][$cs_counter_heading]) && $_POST['heading_color'][$cs_counter_heading] != ''){
                                                        $shortcode .=     'heading_color="'.htmlspecialchars($_POST['heading_color'][$cs_counter_heading], ENT_QUOTES).'" ';
                                                    }
												 
                                                    if(isset($_POST['color_title'][$cs_counter_heading]) && $_POST['color_title'][$cs_counter_heading] != ''){
                                                        $shortcode .=     'color_title="'.htmlspecialchars($_POST['color_title'][$cs_counter_heading], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['heading_content_color'][$cs_counter_heading]) && $_POST['heading_content_color'][$cs_counter_heading] != ''){
                                                        $shortcode .=     'heading_content_color="'.htmlspecialchars($_POST['heading_content_color'][$cs_counter_heading], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['heading_animation'][$cs_counter_heading]) && $_POST['heading_animation'][$cs_counter_heading] != ''){
                                                        $shortcode .=     'heading_animation="'.htmlspecialchars($_POST['heading_animation'][$cs_counter_heading]).'" ';
                                                    }
                                                    $shortcode .=     ']';
                                                    if(isset($_POST['heading_content'][$cs_counter_heading]) && $_POST['heading_content'][$cs_counter_heading] != ''){
                                                        $shortcode .=     htmlspecialchars($_POST['heading_content'][$cs_counter_heading], ENT_QUOTES);
                                                    }
                                                  	 $shortcode .=     '[/'.CS_SC_HEADING.']';
                                                     $heading->addChild('cs_shortcode', $shortcode );
                                                     $cs_counter_heading++;
                                                }
                                            $cs_global_counter_heading++;
                                        }
                                        // Save divider page element 
                                        else if ( $_POST['cs_orderby'][$cs_counter] == "divider" ) {
                                                $shortcode = '';
                                                $divider   = $column->addChild('divider');
                                                $divider->addChild('page_element_size', htmlspecialchars($_POST['divider_element_size'][$cs_global_counter_divider]) );
                                                $divider->addChild('divider_element_size', htmlspecialchars($_POST['divider_element_size'][$cs_global_counter_divider]) );
                                                if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
                                                    $shortcode_str = stripslashes ($_POST['shortcode']['divider'][$cs_shortcode_counter_divider]);
                                                    $cs_shortcode_counter_divider++;
                                                    $divider->addChild('cs_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES) );
                                                } else {
                                                    
													$shortcode .= '['.CS_SC_DIVIDER.' ';
                                                        if(isset($_POST['divider_style'][$cs_counter_divider]) && $_POST['divider_style'][$cs_counter_divider] != ''){
                                                            $shortcode .=     'divider_style="'.htmlspecialchars($_POST['divider_style'][$cs_counter_divider]).'" ';
                                                        }
                                                        if(isset($_POST['divider_backtotop'][$cs_counter_divider]) && $_POST['divider_backtotop'][$cs_counter_divider] != ''){
                                                            $shortcode .=     'divider_backtotop="'.htmlspecialchars($_POST['divider_backtotop'][$cs_counter_divider]).'" ';
                                                        }
                                                        if(isset($_POST['divider_margin_top'][$cs_counter_divider]) && $_POST['divider_margin_top'][$cs_counter_divider] != ''){
                                                            $shortcode .=     'divider_margin_top="'.htmlspecialchars($_POST['divider_margin_top'][$cs_counter_divider]).'" ';
                                                        }
                                                        if(isset($_POST['divider_margin_bottom'][$cs_counter_divider]) && $_POST['divider_margin_bottom'][$cs_counter_divider] != ''){
                                                            $shortcode .=     'divider_margin_bottom="'.htmlspecialchars($_POST['divider_margin_bottom'][$cs_counter_divider]).'" ';
                                                        }
                                                        if(isset($_POST['divider_height'][$cs_counter_divider]) && $_POST['divider_height'][$cs_counter_divider] != ''){
                                                            $shortcode .=     'divider_height="'.htmlspecialchars($_POST['divider_height'][$cs_counter_divider]).'" ';
                                                        }
                                                        if(isset($_POST['cs_divider_class'][$cs_counter_divider]) && $_POST['cs_divider_class'][$cs_counter_divider] != ''){
                                                            $shortcode .=     'cs_divider_class="'.htmlspecialchars($_POST['cs_divider_class'][$cs_counter_divider], ENT_QUOTES).'" ';
                                                        }
                                                        if(isset($_POST['cs_divider_animation'][$cs_counter_divider]) && $_POST['cs_divider_animation'][$cs_counter_divider] != ''){
                                                            $shortcode .=     'cs_divider_animation="'.htmlspecialchars($_POST['cs_divider_animation'][$cs_counter_divider]).'" ';
                                                        }
                                                        $shortcode .=     ']';
                                                    $divider->addChild('cs_shortcode', $shortcode );
                                                    $cs_counter_divider++;
                                                }
                                                $cs_global_counter_divider++;
                                        }// Save divider page element 
										else if ( $_POST['cs_orderby'][$cs_counter] == "categories" ) {
                                                $shortcode = '';
                                                $divider   = $column->addChild('categories');
                                                $divider->addChild('page_element_size', htmlspecialchars($_POST['categories_element_size'][$cs_global_counter_categories]) );
                                                $divider->addChild('categories_element_size', htmlspecialchars($_POST['categories_element_size'][$cs_global_counter_categories]) );
                                                if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
                                                    $shortcode_str = stripslashes ($_POST['shortcode']['categories'][$cs_shortcode_counter_categories]);
                                                    $cs_shortcode_counter_categories++;
                                                    $divider->addChild('cs_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES) );
                                                } else {
                                                     
													$shortcode .= '['.CS_SC_CATEGORIES.' ';
                                                        if(isset($_POST['cs_category_title'][$cs_counter_categories]) && $_POST['cs_category_title'][$cs_counter_categories] != ''){
                                                            $shortcode .= 'cs_category_title="'.htmlspecialchars($_POST['cs_category_title'][$cs_counter_categories]).'" ';
                                                        }
                                                        if(isset($_POST['cs_category_description'][$cs_counter_categories]) && $_POST['cs_category_description'][$cs_counter_categories] != ''){
                                                            $shortcode .='cs_category_description="'.htmlspecialchars($_POST['cs_category_description'][$cs_counter_categories]).'" ';
                                                        }
														if(isset($_POST['cs_total_display'][$cs_counter_categories]) && $_POST['cs_total_display'][$cs_counter_categories] != ''){
															$shortcode .=   'cs_total_display="'.htmlspecialchars($_POST['cs_total_display'][$cs_counter_categories]).'" ';
														}
														$shortcode .=     ']';
                                                    $divider->addChild('cs_shortcode', $shortcode );
                                                    $cs_counter_categories++;
                                                }
                                                $cs_global_counter_categories++;
                                        	}// Save Categories page element
										
                                        else if ( $_POST['cs_orderby'][$cs_counter] == "spacer" ) {
                                            $shortcode = '';
                                            $spacer         = $column->addChild('spacer');
                                             $spacer->addChild('page_element_size', '100');
                                            if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
                                                $shortcode_str = stripslashes ($_POST['shortcode']['spacer'][$cs_shortcode_counter_spacer]);
                                                $cs_shortcode_counter_spacer++;
                                                $spacer->addChild('cs_shortcode', htmlspecialchars($shortcode_str) );
                                            } else {
                                                 
												  $shortcode .= '['.CS_SC_SPACER.' ';
                                                if(isset($_POST['cs_spacer_height'][$cs_counter_spacer]) && $_POST['cs_spacer_height'][$cs_counter_spacer] != ''){
                                                    $shortcode .=     'cs_spacer_height="'.htmlspecialchars($_POST['cs_spacer_height'][$cs_counter_spacer]).'" ';
                                                }
                                                $shortcode .=     ']';
                                                $spacer->addChild('cs_shortcode', $shortcode );
                                                $cs_counter_spacer++;
                                            }
                                            $cs_global_counter_spacer++;
                                        }
										
										else if ( $_POST['cs_orderby'][$cs_counter] == "sitemap" ) {
                                            $shortcode = '';
                                            $sitemap         = $column->addChild('sitemap');
                                             $sitemap->addChild('page_element_size', '100');
                                            if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
                                                $shortcode_str = stripslashes ($_POST['shortcode']['sitemap'][$cs_shortcode_counter_spacer]);
                                                $cs_shortcode_counter_sitemap++;
                                                $sitemap->addChild('cs_shortcode', htmlspecialchars($shortcode_str) );
                                            } else {
                                                 
												  $shortcode .= '['.CS_SC_SITEMAP.' ';
                                                if(isset($_POST['cs_sitemap_section_title'][$cs_counter_sitemap]) && $_POST['cs_sitemap_section_title'][$cs_counter_sitemap] != ''){
                                                    $shortcode .=     'cs_sitemap_section_title="'.htmlspecialchars($_POST['cs_sitemap_section_title'][$cs_counter_sitemap]).'" ';
                                                }
                                                $shortcode .=     ']';
                                                $sitemap->addChild('cs_shortcode', $shortcode );
                                                $cs_counter_sitemap++;
                                            }
                                            $cs_global_counter_sitemap++;
                                        }
									 	else if ( $_POST['cs_orderby'][$cs_counter] == "search" ) {
										$shortcode = '';
										$search = $column->addChild('search');
										$search->addChild('page_element_size', htmlspecialchars($_POST['search_element_size'][$cs_global_counter_search]) );
										$search->addChild('search_element_size', htmlspecialchars($_POST['search_element_size'][$cs_global_counter_search]) );
										if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
											$shortcode_str = stripslashes ($_POST['shortcode']['search'][$cs_shortcode_counter_search]);
											$cs_shortcode_counter_search++;
											$search->addChild('cs_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES) );
										} else {
											
											$shortcode .= '['.CS_SC_SEARCH.' ';
											if(isset($_POST['cs_search_section_title'][$cs_counter_search]) && $_POST['cs_search_section_title'][$cs_counter_search] != ''){
												$shortcode .=     'cs_search_section_title="'.htmlspecialchars($_POST['cs_search_section_title'][$cs_counter_search], ENT_QUOTES).'" ';
											}
											 
										 
											if(isset($_POST['cs_search_des'][$cs_counter_search]) && $_POST['cs_search_des'][$cs_counter_search] != ''){
												$shortcode .=     'cs_search_des="'.htmlspecialchars($_POST['cs_search_des'][$cs_counter_search], ENT_QUOTES).'" ';
											}
					 					 
											$shortcode .=     ']';
											
											$search->addChild('cs_shortcode', $shortcode );
											$cs_counter_search++;
										}
									$cs_global_counter_search++;
							}
							
										 
										
									 
                                        // Save quote page element 
                                        else if ( $_POST['cs_orderby'][$cs_counter] == "quote" ) {
                                                    $shortcode = '';
                                                    $quote = $column->addChild('quote');
                                                    $quote->addChild('page_element_size', htmlspecialchars($_POST['quote_element_size'][$cs_global_counter_quote]) );
                                                    $quote->addChild('quote_element_size', htmlspecialchars($_POST['quote_element_size'][$cs_global_counter_quote]) );
                                                  
												    if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
													    $shortcode_str = stripslashes ($_POST['shortcode']['quote'][$cs_shortcode_counter_quote]);
                                                        $cs_shortcode_counter_quote++;
                                                        $quote->addChild('cs_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES) );
                                                    } else {
                                                         
														$shortcode .= '['.CS_SC_QUOTE.' ';
                                                        if(isset($_POST['quote_cite'][$counter_quote]) && $_POST['quote_cite'][$counter_quote] != ''){
                                                            $shortcode .=     'quote_cite="'.htmlspecialchars($_POST['quote_cite'][$counter_quote], ENT_QUOTES).'" ';
                                                        }
                                                        if(isset($_POST['quote_cite_url'][$counter_quote]) && $_POST['quote_cite_url'][$counter_quote] != ''){
                                                            $shortcode .=     'quote_cite_url="'.htmlspecialchars($_POST['quote_cite_url'][$counter_quote], ENT_QUOTES).'" ';
                                                        }
                                                        if(isset($_POST['quote_text_color'][$counter_quote]) && $_POST['quote_text_color'][$counter_quote] != ''){
                                                            $shortcode .=     'quote_text_color="'.htmlspecialchars($_POST['quote_text_color'][$counter_quote]).'" ';
                                                        }
                                                        if(isset($_POST['quote_align'][$counter_quote]) && $_POST['quote_align'][$counter_quote] != ''){
                                                            $shortcode .=     'quote_align="'.htmlspecialchars($_POST['quote_align'][$counter_quote]).'" ';
                                                        }
                                                        if(isset($_POST['cs_quote_section_title'][$counter_quote]) && $_POST['cs_quote_section_title'][$counter_quote] != ''){
                                                            $shortcode .=     'cs_quote_section_title="'.htmlspecialchars($_POST['cs_quote_section_title'][$counter_quote], ENT_QUOTES).'" ';
                                                        }
                                                        if(isset($_POST['cs_quote_class'][$counter_quote]) && $_POST['cs_quote_class'][$counter_quote] != ''){
                                                            $shortcode .=     'cs_quote_class="'.htmlspecialchars($_POST['cs_quote_class'][$counter_quote], ENT_QUOTES).'" ';
                                                        }
                                                        if(isset($_POST['cs_quote_animation'][$counter_quote]) && $_POST['cs_quote_animation'][$counter_quote] != ''){
                                                            $shortcode .=     'cs_quote_animation="'.htmlspecialchars($_POST['cs_quote_animation'][$counter_quote]).'" ';
                                                        }
                                                        $shortcode .=     ']';
                                                        if(isset($_POST['quote_content'][$counter_quote])){
                                                            $shortcode .=     htmlspecialchars($_POST['quote_content'][$counter_quote], ENT_QUOTES);
                                                        }
                                                   
														 $shortcode .=     '[/'.CS_SC_QUOTE.']';
                                                        $quote->addChild('cs_shortcode', $shortcode );
                                                        $counter_quote++;
                                                    }
                                                $cs_global_counter_quote++;
                                        }
           
                        
                                        // Save testimonials page element 
                                        else if ( $_POST['cs_orderby'][$cs_counter] == "testimonials" ) {
                                            $shortcode = $shortcode_item = '';
                                            $testimonials = $column->addChild('testimonials');
                                            $testimonials->addChild('page_element_size', htmlspecialchars($_POST['testimonials_element_size'][$cs_global_counter_testimonials]) );
                                            $testimonials->addChild('testimonials_element_size', htmlspecialchars($_POST['testimonials_element_size'][$cs_global_counter_testimonials]) );
                                            if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
                                                $shortcode_str = stripslashes ($_POST['shortcode']['testimonials'][$cs_shortcode_counter_testimonial]);
                                                $cs_shortcode_counter_testimonial++;
                                                $testimonials->addChild('cs_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES) );
                                            } else {
                                                if(isset($_POST['testimonials_num'][$cs_counter_testimonials]) && $_POST['testimonials_num'][$cs_counter_testimonials]>0){
                                                    for ( $i = 1; $i <= $_POST['testimonials_num'][$cs_counter_testimonials]; $i++ ){
                                                        $shortcode_item .= '[testimonial_item ';
                                                        
                                                        if(isset($_POST['testimonial_company'][$cs_counter_testimonials_node]) && $_POST['testimonial_company'][$cs_counter_testimonials_node] != ''){
                                                            $shortcode_item .= 'testimonial_company="'.htmlspecialchars($_POST['testimonial_company'][$cs_counter_testimonials_node], ENT_QUOTES).'" ';
                                                        }
                                                        if(isset($_POST['testimonial_img'][$cs_counter_testimonials_node]) && $_POST['testimonial_img'][$cs_counter_testimonials_node] != ''){
                                                            $shortcode_item .= 'testimonial_img="'.htmlspecialchars($_POST['testimonial_img'][$cs_counter_testimonials_node], ENT_QUOTES).'" ';
                                                        }
														
														
														
													 if(isset($_POST['testimonial_author'][$cs_counter_testimonials_node]) && $_POST['testimonial_author'][$cs_counter_testimonials_node] != ''){
                                                            $shortcode_item .= 'testimonial_author="'.htmlspecialchars($_POST['testimonial_author'][$cs_counter_testimonials_node], ENT_QUOTES).'" ';
                                                        }	
														
														
										
										if(isset($_POST['testimonial_author_company'][$cs_counter_testimonials_node]) && $_POST['testimonial_author_company'][$cs_counter_testimonials_node] != ''){
											$shortcode_item .= 'testimonial_author_company="'.htmlspecialchars($_POST['testimonial_author_company'][$cs_counter_testimonials_node], ENT_QUOTES).'" ';
										}
                                                        $shortcode_item .=     ']';
                                                        if(isset($_POST['testimonial_text'][$cs_counter_testimonials_node]) && $_POST['testimonial_text'][$cs_counter_testimonials_node] != ''){
                                                            $shortcode_item .= htmlspecialchars($_POST['testimonial_text'][$cs_counter_testimonials_node], ENT_QUOTES);
                                                        }
                                                        $shortcode_item .= '[/testimonial_item]'; 
                                                        $cs_counter_testimonials_node++;
                                                    }
                                                }
                                                $section_title = '';
                                                if(isset($_POST['cs_testimonial_section_title'][$cs_counter_testimonials]) && $_POST['cs_testimonial_section_title'][$cs_counter_testimonials] != ''){
                                                    $section_title ='cs_testimonial_section_title="'.htmlspecialchars($_POST['cs_testimonial_section_title'][$cs_counter_testimonials], ENT_QUOTES).'" ';
                                                }
                                                $shortcode = '[cs_testimonials testimonial_style="'.htmlspecialchars($_POST['testimonial_style'][$cs_counter_testimonials], ENT_QUOTES).'" 
                                                 testimonial_text_color="'.htmlspecialchars($_POST['testimonial_text_color'][$cs_counter_testimonials]).'"
                                                 cs_testimonial_text_align="'.htmlspecialchars($_POST['cs_testimonial_text_align'][$cs_counter_testimonials]).'"
                                                 cs_testimonial_class="'.htmlspecialchars($_POST['cs_testimonial_class'][$cs_counter_testimonials], ENT_QUOTES).'"
                                                 cs_testimonial_animation="'.htmlspecialchars($_POST['cs_testimonial_animation'][$cs_counter_testimonials]).'"
												 testimonial_view_style="'.htmlspecialchars($_POST['testimonial_view_style'][$cs_counter_testimonials]).'"
												 testimonial_bg_color="'.htmlspecialchars($_POST['testimonial_bg_color'][$cs_counter_testimonials]).'"
												 
                                                 '.$section_title.' ]'.$shortcode_item.'[/cs_testimonials]';
                                                $testimonials->addChild('cs_shortcode', $shortcode );
                                                $cs_counter_testimonials++;
                                            }
                                            $cs_global_counter_testimonials++;
                                        }
                                        // Save List page element 
                                        else if ( $_POST['cs_orderby'][$cs_counter] == "list" ) {
                                            $shortcode = $shortcode_item = '';
                                            $lists = $column->addChild('list');
                                            $lists->addChild('page_element_size', htmlspecialchars($_POST['list_element_size'][$cs_global_counter_list]) );
                                            $lists->addChild('list_element_size', htmlspecialchars($_POST['list_element_size'][$cs_global_counter_list]) );
                                            if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
                                                $shortcode_str = stripslashes ($_POST['shortcode']['list'][$cs_shortcode_counter_list]);
                                                $cs_shortcode_counter_list++;
                                                $lists->addChild('cs_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES) );
                                            } else {
                                                if(isset($_POST['list_num'][$cs_counter_list]) && $_POST['list_num'][$cs_counter_list]>0){
                                                    for ( $i = 1; $i <= $_POST['list_num'][$cs_counter_list]; $i++ ){
                                                             
													$shortcode_item .= '['.CS_SC_LISTITEM.' ';
                                                        if(isset($_POST['cs_list_icon'][$cs_counter_lists_node])){
                                                            $shortcode_item .='cs_list_icon="'.htmlspecialchars($_POST['cs_list_icon'][$cs_counter_lists_node], ENT_QUOTES).'" ';
                                                        }
                                                        $shortcode_item .=  ']';
                                                        if(isset($_POST['cs_list_item'][$cs_counter_lists_node])){
                                                            $shortcode_item .=     htmlspecialchars($_POST['cs_list_item'][$cs_counter_lists_node], ENT_QUOTES);
                                                        }
 														$shortcode_item .=     '[/'.CS_SC_LISTITEM.']';
                                                        $cs_counter_lists_node++;
                                                    }
                                                }
                                                $shortcode = '['.CS_SC_LIST.' ';
                                                
                                                $shortcode .= 'column_size="1/1" ';
                                                if(isset($_POST['cs_list_type'][$cs_counter_list]) && $_POST['cs_list_type'][$cs_counter_list] != ''){
                                                    $shortcode .= 'cs_list_type="'.htmlspecialchars($_POST['cs_list_type'][$cs_counter_list]).'" ';
                                                }
                                                if(isset($_POST['cs_border'][$cs_counter_list]) && $_POST['cs_border'][$cs_counter_list] != ''){
                                                    $shortcode .= 'cs_border="'.htmlspecialchars($_POST['cs_border'][$cs_counter_list]).'" ';
                                                }
                                                if(isset($_POST['cs_list_section_title'][$cs_counter_list]) && $_POST['cs_list_section_title'][$cs_counter_list] != ''){
                                                    $shortcode .= 'cs_list_section_title="'.htmlspecialchars($_POST['cs_list_section_title'][$cs_counter_list], ENT_QUOTES).'" ';
                                                }
                                                if(isset($_POST['cs_list_class'][$cs_counter_list]) && $_POST['cs_list_class'][$cs_counter_list] != ''){
                                                    $shortcode .= 'cs_list_class="'.htmlspecialchars($_POST['cs_list_class'][$cs_counter_list], ENT_QUOTES).'" ';
                                                }
                                                if(isset($_POST['cs_list_animation'][$cs_counter_list]) && $_POST['cs_list_animation'][$cs_counter_list] != ''){
                                                    $shortcode .= 'cs_list_animation="'.htmlspecialchars($_POST['cs_list_animation'][$cs_counter_list]).'" ';
                                                }
                                                $shortcode .=  ']'.$shortcode_item.'[/'.CS_SC_LIST.']';
                                                $lists->addChild('cs_shortcode', $shortcode );
                                                $cs_counter_list++;
                                            }
                                            $cs_global_counter_list++;
                                        }
                       
					              /***********************************************************************************************/
								    else if ( $_POST['cs_orderby'][$cs_counter] == "openinghours" ) { 
										    $shortcode = $shortcode_item = '';
                                            $lists = $column->addChild('openinghours');
                                            $lists->addChild('page_element_size', htmlspecialchars($_POST['openinghours_element_size'][$cs_global_counter_openinghours]) );
                                            $lists->addChild('openinghours_element_size', htmlspecialchars($_POST['openinghours_element_size'][$cs_global_counter_openinghours]) );
                                            if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
                                                $shortcode_str = stripslashes ($_POST['shortcode']['openinghours'][$cs_shortcode_counter_openinghours]);
                                                $cs_shortcode_counter_openinghours++;
                                                $lists->addChild('cs_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES) );
                                            } else {
                                                if(isset($_POST['list_num_openinghours'][$cs_counter_openinghours]) && $_POST['list_num_openinghours'][$cs_counter_openinghours]>0){
                                                    for ( $i = 1; $i <= $_POST['list_num_openinghours'][$cs_counter_openinghours]; $i++ ){
                                                             
													   $shortcode_item .= '['.CS_SC_OPENINGHOURS_LISTITEM.' ';
                                                        if(isset($_POST['cs_list_item'][$cs_counter_openinghours_node])){
                                                            $shortcode_item .='cs_list_item="'.htmlspecialchars($_POST['cs_list_item'][$cs_counter_openinghours_node], ENT_QUOTES).'" ';
                                                        }
														
														
                                                        $shortcode_item .=  ']';
                                                        if(isset($_POST['cs_schadule_text'][$cs_counter_openinghours_node])){
                                                            $shortcode_item .=     htmlspecialchars($_POST['cs_schadule_text'][$cs_counter_openinghours_node], ENT_QUOTES);
                                                        }
 														$shortcode_item .=     '[/'.CS_SC_OPENINGHOURS_LISTITEM.']';
                                                        $cs_counter_openinghours_node++;
													 }
                                                }
                                                $shortcode = '['.CS_SC_OPENINGHOURS.' ';
                                                
                                                $shortcode .= 'column_size="1/1" ';
                                                /*if(isset($_POST['cs_list_type'][$cs_counter_openinghours]) && $_POST['cs_list_type'][$cs_counter_openinghours] != ''){
                                                    $shortcode .= 'cs_list_type="'.htmlspecialchars($_POST['cs_list_type'][$cs_counter_openinghours]).'" ';
                                                }*/
                                                if(isset($_POST['cs_border'][$cs_counter_openinghours]) && $_POST['cs_border'][$cs_counter_openinghours] != ''){
                                                    $shortcode .= 'cs_border="'.htmlspecialchars($_POST['cs_border'][$cs_counter_openinghours]).'" ';
                                                }
                                                if(isset($_POST['cs_list_section_title'][$cs_counter_openinghours]) && $_POST['cs_list_section_title'][$cs_counter_openinghours] != ''){
                                                    $shortcode .= 'cs_list_section_title="'.htmlspecialchars($_POST['cs_list_section_title'][$cs_counter_openinghours], ENT_QUOTES).'" ';
                                                }
                                                if(isset($_POST['cs_list_class'][$cs_counter_openinghours]) && $_POST['cs_list_class'][$cs_counter_openinghours] != ''){
                                                    $shortcode .= 'cs_list_class="'.htmlspecialchars($_POST['cs_list_class'][$cs_counter_openinghours], ENT_QUOTES).'" ';
                                                }
                                                if(isset($_POST['cs_list_animation'][$cs_counter_openinghours]) && $_POST['cs_list_animation'][$cs_counter_openinghours] != ''){
                                                    $shortcode .= 'cs_list_animation="'.htmlspecialchars($_POST['cs_list_animation'][$cs_counter_openinghours]).'" ';
                                                }
                                                $shortcode .=  ']'.$shortcode_item.'[/'.CS_SC_OPENINGHOURS.']';
                                                $lists->addChild('cs_shortcode', $shortcode );
                                                $cs_counter_openinghours++;
											
                                            }
                                            $cs_global_counter_openinghours++;
										
                                        }
									
									
								  /************************************************************************************************/
					   
					   
					   
                                        // Typography end

                                        // Common Elements Start

											// Services
                                            else if ( $_POST['cs_orderby'][$cs_counter] == "services" ) {
                                                    $shortcode = $shortcode_item = '';
                                                    $services  = $column->addChild('services');
                                                    $services->addChild('page_element_size', $_POST['services_element_size'][$cs_global_counter_services]);
                                                    $services->addChild('services_element_size',$_POST['services_element_size'][$cs_global_counter_services]);
                                                    
                                                    if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
                                                        $shortcode_str = stripslashes ($_POST['shortcode']['services'][$cs_shortcode_counter_services]);
                                                        $cs_shortcode_counter_services++;
                                                        $services->addChild('cs_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES) );
                                                    } else {
                                                        $shortcode_item .= '['.CS_SC_SERVICES.' ';
                                                        if(isset($_POST['cs_service_type'][$cs_counter_services]) && $_POST['cs_service_type'][$cs_counter_services] != ''){
                                                            $shortcode_item .=     'cs_service_type="'.htmlspecialchars($_POST['cs_service_type'][$cs_counter_services], ENT_QUOTES).'" ';
                                                        }
														if(isset($_POST['cs_service_border_right'][$cs_counter_services]) && $_POST['cs_service_border_right'][$cs_counter_services] != ''){
                                                            $shortcode_item .=     'cs_service_border_right="'.htmlspecialchars($_POST['cs_service_border_right'][$cs_counter_services], ENT_QUOTES).'" ';
                                                        }
                                                        if(isset($_POST['cs_service_icon_type'][$cs_counter_services]) && $_POST['cs_service_icon_type'][$cs_counter_services] != ''){
                                                            $shortcode_item .=     'cs_service_icon_type="'.htmlspecialchars($_POST['cs_service_icon_type'][$cs_counter_services]).'" ';
                                                        }
														
														if(isset($_POST['cs_view_style'][$cs_counter_services]) && $_POST['cs_view_style'][$cs_counter_services] != ''){
                                                            $shortcode_item .=     'cs_view_style="'.htmlspecialchars($_POST['cs_view_style'][$cs_counter_services]).'" ';
                                                        }
														
														
                                                        if(isset($_POST['cs_service_icon'][$cs_counter_services]) && $_POST['cs_service_icon'][$cs_counter_services] != ''){
                                                            $shortcode_item .=     'cs_service_icon="'.htmlspecialchars($_POST['cs_service_icon'][$cs_counter_services]).'" ';
                                                        }
                                                        if(isset($_POST['cs_service_icon_color'][$cs_counter_services]) && $_POST['cs_service_icon_color'][$cs_counter_services] != ''){
                                                            $shortcode_item .=     'cs_service_icon_color="'.htmlspecialchars($_POST['cs_service_icon_color'][$cs_counter_services]).'" ';
                                                        }
                                                        if(isset($_POST['cs_service_bg_image'][$cs_counter_services]) && $_POST['cs_service_bg_image'][$cs_counter_services] != ''){
                                                            $shortcode_item .=     'cs_service_bg_image="'.htmlspecialchars($_POST['cs_service_bg_image'][$cs_counter_services]).'" ';
                                                        }
                                                        if(isset($_POST['cs_service_bg_color'][$cs_counter_services]) && $_POST['cs_service_bg_color'][$cs_counter_services] != ''){
                                                            $shortcode_item .=     'cs_service_bg_color="'.htmlspecialchars($_POST['cs_service_bg_color'][$cs_counter_services]).'" ';
                                                        }
                                                        if(isset($_POST['service_icon_size'][$cs_counter_services]) && $_POST['service_icon_size'][$cs_counter_services] != ''){
                                                            $shortcode_item .=     'service_icon_size="'.htmlspecialchars($_POST['service_icon_size'][$cs_counter_services]).'" ';
                                                        }
                                                        if(isset($_POST['cs_service_postion_modern'][$cs_counter_services]) && $_POST['cs_service_postion_modern'][$cs_counter_services] != ''){
                                                            $shortcode_item .=     'cs_service_postion_modern="'.htmlspecialchars($_POST['cs_service_postion_modern'][$cs_counter_services]).'" ';
                                                        }
                                                        if(isset($_POST['cs_service_postion_classic'][$cs_counter_services]) && $_POST['cs_service_postion_classic'][$cs_counter_services] != ''){
                                                            $shortcode_item .=     'cs_service_postion_classic="'.htmlspecialchars($_POST['cs_service_postion_classic'][$cs_counter_services]).'" ';
                                                        }
                                                        if(isset($_POST['cs_service_title'][$cs_counter_services]) && $_POST['cs_service_title'][$cs_counter_services] != ''){
                                                            $shortcode_item .=     'cs_service_title="'.htmlspecialchars($_POST['cs_service_title'][$cs_counter_services], ENT_QUOTES).'" ';
                                                        }
														if(isset($_POST['cs_link_url'][$cs_counter_services]) && $_POST['cs_link_url'][$cs_counter_services] != ''){
                                                            $shortcode_item .=     'cs_link_url="'.htmlspecialchars($_POST['cs_link_url'][$cs_counter_services], ENT_QUOTES).'" ';
                                                        }
														
														if(isset($_POST['cs_service_title_color'][$cs_counter_services]) && $_POST['cs_service_title_color'][$cs_counter_services] != ''){
                                                            $shortcode_item .=     'cs_service_title_color="'.htmlspecialchars($_POST['cs_service_title_color'][$cs_counter_services], ENT_QUOTES).'" ';
                                                        }
														if(isset($_POST['cs_service_content_color'][$cs_counter_services]) && $_POST['cs_service_content_color'][$cs_counter_services] != ''){
                                                            $shortcode_item .=     'cs_service_content_color="'.htmlspecialchars($_POST['cs_service_content_color'][$cs_counter_services], ENT_QUOTES).'" ';
                                                        }
														if(isset($_POST['cs_service_btn_text_color'][$cs_counter_services]) && $_POST['cs_service_btn_text_color'][$cs_counter_services] != ''){
                                                            $shortcode_item .=     'cs_service_btn_text_color="'.htmlspecialchars($_POST['cs_service_btn_text_color'][$cs_counter_services], ENT_QUOTES).'" ';
                                                        }
                                                        if(isset($_POST['cs_service_link_text'][$cs_counter_services]) && $_POST['cs_service_link_text'][$cs_counter_services] != ''){
                                                            $shortcode_item .=     'cs_service_link_text="'.htmlspecialchars($_POST['cs_service_link_text'][$cs_counter_services]).'" ';
                                                        }
                                                        if(isset($_POST['cs_service_link_color'][$cs_counter_services]) && $_POST['cs_service_link_color'][$cs_counter_services] != ''){
                                                            $shortcode_item .=     'cs_service_link_color="'.htmlspecialchars($_POST['cs_service_link_color'][$cs_counter_services], ENT_QUOTES).'" ';
                                                        }
                                                        if(isset($_POST['cs_service_url'][$cs_counter_services]) && $_POST['cs_service_url'][$cs_counter_services] != ''){
                                                            $shortcode_item .=     'cs_service_url="'.htmlspecialchars($_POST['cs_service_url'][$cs_counter_services]).'" ';
                                                        }
                                                        if(isset($_POST['cs_service_class'][$cs_counter_services]) && $_POST['cs_service_class'][$cs_counter_services] != ''){
                                                            $shortcode_item .=     'cs_service_class="'.htmlspecialchars($_POST['cs_service_class'][$cs_counter_services]).'" ';
                                                        }
                                                        if(isset($_POST['cs_service_animation'][$cs_counter_services]) && $_POST['cs_service_animation'][$cs_counter_services] != ''){
                                                            $shortcode_item .=     'cs_service_animation="'.htmlspecialchars($_POST['cs_service_animation'][$cs_counter_services]).'" ';
                                                        }                                                        
                                                        $shortcode_item .=     ']';
                                                        if(isset($_POST['cs_service_content'][$cs_counter_services]) && $_POST['cs_service_content'][$cs_counter_services] != ''){
                                                            $shortcode_item .=     htmlspecialchars($_POST['cs_service_content'][$cs_counter_services], ENT_QUOTES);
                                                        }
                                                        $shortcode_item .=     '[/'.CS_SC_SERVICES.']';
                                                        $services->addChild('cs_shortcode', $shortcode_item );
                                                   $cs_counter_services++;
                                                }
                                                $cs_global_counter_services++;
                                            }
                                            // Accrodian
                                
                                            // Faq
                                            else if ( $_POST['cs_orderby'][$cs_counter] == "faq" ) {
                                                $shortcode = $shortcode_item = '';
                                                $faqs = $column->addChild('faq');
                                                $faqs->addChild('page_element_size', htmlspecialchars($_POST['faq_element_size'][$cs_global_counter_faq]) );
                                                $faqs->addChild('faq_element_size', htmlspecialchars($_POST['faq_element_size'][$cs_global_counter_faq]) );
                                                if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
                                                    $shortcode_str = stripslashes ($_POST['shortcode']['faq'][$cs_shortcode_counter_faq]);
                                                    $cs_shortcode_counter_faq++;
                                                    $faqs->addChild('cs_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES) );

                                                } else {
                                                    if(isset($_POST['faq_num'][$counter_faq]) && $_POST['faq_num'][$counter_faq]>0){            
                                                        for ( $i = 1; $i <= $_POST['faq_num'][$counter_faq]; $i++ ){
                                                                $shortcode_item .= '['.CS_SC_FAQITEM.' ';
                                                                if(isset($_POST['faq_title'][$counter_faq_node]) && $_POST['faq_title'][$counter_faq_node] != ''){
                                                                    $shortcode_item .= 'faq_title="'.htmlspecialchars($_POST['faq_title'][$counter_faq_node], ENT_QUOTES).'" ';
                                                                }
                                                                if(isset($_POST['faq_active'][$counter_faq_node]) && $_POST['faq_active'][$counter_faq_node] != ''){
                                                                    $shortcode_item .= 'faq_active="'.htmlspecialchars($_POST['faq_active'][$counter_faq_node]).'" ';
                                                                }
                                                                if(isset($_POST['cs_faq_icon'][$counter_faq_node]) && $_POST['cs_faq_icon'][$counter_faq_node] != ''){
                                                                    $shortcode_item .= 'cs_faq_icon="'.htmlspecialchars($_POST['cs_faq_icon'][$counter_faq_node], ENT_QUOTES).'" ';
                                                                }
                                                            
                                                                $shortcode_item .= ']';
                                                                if(isset($_POST['faq_text'][$counter_faq_node]) && $_POST['faq_text'][$counter_faq_node] != ''){
                                                                    $shortcode_item .=  htmlspecialchars($_POST['faq_text'][$counter_faq_node], ENT_QUOTES);
                                                                }
                                                                $shortcode_item .= '[/'.CS_SC_FAQITEM.']'; 
                                                                     
                                                                $counter_faq_node++;
                                                            }
                                                    }
                                                    
                                                    $section_title = '';
                                                    if(isset($_POST['cs_faq_section_title'][$counter_faq]) && $_POST['cs_faq_section_title'][$counter_faq] != ''){
                                                        $section_title = 'cs_faq_section_title="'.htmlspecialchars($_POST['cs_faq_section_title'][$counter_faq], ENT_QUOTES).'" ';
                                                    }
                                  
													$shortcode = '['.CS_SC_FAQ.' '.$section_title;
                                                    
                                                    if(isset($_POST['cs_faq_view'][$counter_faq]) && $_POST['cs_faq_view'][$counter_faq] != ''){
                                                        $shortcode .= 'cs_faq_view="'.htmlspecialchars($_POST['cs_faq_view'][$counter_faq], ENT_QUOTES).'" ';
                                                    } 
                                                    if(isset($_POST['faq_class'][$counter_faq]) && $_POST['faq_class'][$counter_faq] != ''){
                                                        $shortcode .= ' faq_class="'.htmlspecialchars($_POST['faq_class'][$counter_faq], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['faq_animation'][$counter_faq]) && $_POST['faq_animation'][$counter_faq] != ''){
                                                        $shortcode .= ' faq_animation="'.htmlspecialchars($_POST['faq_animation'][$counter_faq]).'" ';
                                                    }
                                                    $shortcode .= ']'.$shortcode_item.'[/'.CS_SC_FAQ.']';
                                                    
                                                    $faqs->addChild('cs_shortcode', $shortcode );
                                                    $counter_faq++;
                                                }
                                                $cs_global_counter_faq++;
                                            }
                                            // Tabs
                                            else if ( $_POST['cs_orderby'][$cs_counter] == "tabs" ) {
                                                $shortcode = $shortcode_item = '';
                                                $tabs = $column->addChild('tabs');
                                                $tabs->addChild('page_element_size', htmlspecialchars($_POST['tabs_element_size'][$cs_global_counter_tabs]) );
                                                $tabs->addChild('tabs_element_size', htmlspecialchars($_POST['tabs_element_size'][$cs_global_counter_tabs]) );
                                                if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
                                                    $shortcode_str = stripslashes ($_POST['shortcode']['tabs'][$cs_shortcode_counter_tabs]);
                                                    $cs_shortcode_counter_tabs++;
                                                    $tabs->addChild('cs_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES) );
                                                }else {
                                                        if(isset($_POST['tabs_num'][$counter_tabs]) && $_POST['tabs_num'][$counter_tabs]>0){
                                                            for ( $i = 1; $i <= $_POST['tabs_num'][$counter_tabs]; $i++ ){
                                                            $shortcode_item .= '['.CS_SC_TABSITEM.' ';
                                                            if(isset($_POST['tab_title'][$counter_tabs_node]) && $_POST['tab_title'][$counter_tabs_node] != ''){
                                                                $shortcode_item .= 'tab_title="'.htmlspecialchars($_POST['tab_title'][$counter_tabs_node], ENT_QUOTES).'" ';
                                                            }
                                                            if(isset($_POST['tab_active'][$counter_tabs_node]) && $_POST['tab_active'][$counter_tabs_node] != ''){
                                                                $shortcode_item .= 'tab_active="'.htmlspecialchars($_POST['tab_active'][$counter_tabs_node]).'" ';
                                                            }
                                                            
                                                        
                                                            $shortcode_item .= ']';
                                                            if(isset($_POST['tab_text'][$counter_tabs_node]) && $_POST['tab_text'][$counter_tabs_node] != ''){
                                                                $shortcode_item .=htmlspecialchars($_POST['tab_text'][$counter_tabs_node], ENT_QUOTES);
                                                            }
                                                            $shortcode_item .= '[/'.CS_SC_TABSITEM.']'; 
                                                            $counter_tabs_node++;
                                                        }
                                                     }
                                                    $section_title = '';
                                                    if(isset($_POST['cs_tabs_section_title'][$counter_tabs]) && $_POST['cs_tabs_section_title'][$counter_tabs] != ''){
                                                        $section_title = 'cs_tabs_section_title="'.htmlspecialchars($_POST['cs_tabs_section_title'][$counter_tabs], ENT_QUOTES).'" ';
                                                    }
                                                    $shortcode = '['.CS_SC_TABS.' '.$section_title.'  cs_tab_style="'.htmlspecialchars($_POST['cs_tab_style'][$counter_tabs]).'" cs_tabs_class="'.htmlspecialchars($_POST['cs_tabs_class'][$counter_tabs], ENT_QUOTES).'"   cs_tabs_animation="'.htmlspecialchars($_POST['cs_tabs_animation'][$counter_tabs]).'"]'.$shortcode_item.'[/'.CS_SC_TABS.']';
                                                    $tabs->addChild('cs_shortcode', $shortcode );
                                                $counter_tabs++;
                                                }
                                            $cs_global_counter_tabs++;
                                            }
                                  
                                   
											// Mailchimp
                                            else if ( $_POST['cs_orderby'][$cs_counter] == "mailchimp" ) {
                                                $shortcode = '';
                                                $mailchimp = $column->addChild('mailchimp');
                                                $mailchimp->addChild('page_element_size', htmlspecialchars($_POST['mailchimp_element_size'][$cs_global_counter_mailchimp]) );
                                                $mailchimp->addChild('mailchimp_element_size', htmlspecialchars($_POST['mailchimp_element_size'][$cs_global_counter_mailchimp]) );
                                                
                                                if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
                                                    $shortcode_str = stripslashes ($_POST['shortcode']['mailchimp'][$cs_shortcode_counter_mailchimp]);
                                                    $cs_shortcode_counter_mailchimp++;
                                                    $mailchimp->addChild('cs_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES) );
                                                } else {
                                                    $shortcode .= '['.CS_SC_MAILCHIMP.' ';
                                                    if(isset($_POST['cs_mailchimp_title'][$cs_counter_mailchimp]) && $_POST['cs_mailchimp_title'][$cs_counter_mailchimp] != ''){
                                                        $shortcode .= 'cs_mailchimp_title="'.htmlspecialchars($_POST['cs_mailchimp_title'][$cs_counter_mailchimp]).'" ';
                                                    }
                                                    if(isset($_POST['cs_mailchimp_subtitle'][$cs_counter_mailchimp]) && trim($_POST['cs_mailchimp_subtitle'][$cs_counter_mailchimp]) <> ''){
                                                        $shortcode .= 'cs_mailchimp_subtitle="'.htmlspecialchars($_POST['cs_mailchimp_subtitle'][$cs_counter_mailchimp], ENT_QUOTES).'" ';
                                                    }
													if(isset($_POST['cs_mailchimp_bg_color'][$cs_counter_mailchimp]) && trim($_POST['cs_mailchimp_bg_color'][$cs_counter_mailchimp]) <> ''){
                                                        $shortcode .= 'cs_mailchimp_bg_color="'.htmlspecialchars($_POST['cs_mailchimp_bg_color'][$cs_counter_mailchimp], ENT_QUOTES).'" ';
                                                    }
													if(isset($_POST['cs_mailchimp_txt_color'][$cs_counter_mailchimp]) && trim($_POST['cs_mailchimp_txt_color'][$cs_counter_mailchimp]) <> ''){
                                                        $shortcode .= 'cs_mailchimp_txt_color="'.htmlspecialchars($_POST['cs_mailchimp_txt_color'][$cs_counter_mailchimp], ENT_QUOTES).'" ';
                                                    }
                                                    $shortcode .=  ']';
                                                    if(isset($_POST['cs_mailchimp_text'][$cs_counter_mailchimp]) && $_POST['cs_mailchimp_text'][$cs_counter_mailchimp] != ''){
                                                        $shortcode .= htmlspecialchars($_POST['cs_mailchimp_text'][$cs_counter_mailchimp], ENT_QUOTES);
                                                    }
                                                    $shortcode .= '[/'.CS_SC_MAILCHIMP.']';
                                                    $mailchimp->addChild('cs_shortcode', $shortcode );
                                                    $cs_counter_mailchimp++;
                                                }
                                                $cs_global_counter_mailchimp++;
                                            }
                                            // Counters
                                            else if ( $_POST['cs_orderby'][$cs_counter] == "counter" ) {
                                                $shortcode_item = '';
                                                $counter = $column->addChild('counter');
                                                $counter->addChild('counter_element_size', htmlspecialchars($_POST['counter_element_size'][$cs_global_counter_counter]) );
                                                $counter->addChild('page_element_size', htmlspecialchars($_POST['counter_element_size'][$cs_global_counter_counter]) );
                                                
                                                if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
                                                    $shortcode_str = stripslashes ($_POST['shortcode']['counter'][$cs_shortcode_counter_counter]);
                                                    $cs_shortcode_counter_counter++;
                                                    $counter->addChild('cs_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES) );
                                                } else {
                                                    $shortcode_item .= '['.CS_SC_COUNTERS.' ';
                                                    if(isset($_POST['counter_style'][$counter_coutner]) && $_POST['counter_style'][$counter_coutner] != ''){
                                                        $shortcode_item .=  'counter_style="'.htmlspecialchars($_POST['counter_style'][$counter_coutner]).'" ';
                                                    }
                                                    if(isset($_POST['counter_title'][$counter_coutner]) && $_POST['counter_title'][$counter_coutner] != ''){
                                                        $shortcode_item .= 'counter_title="'.htmlspecialchars($_POST['counter_title'][$counter_coutner], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['counter_icon_type'][$counter_coutner]) && $_POST['counter_icon_type'][$counter_coutner] != ''){
                                                        $shortcode_item .= 'counter_icon_type="'.htmlspecialchars($_POST['counter_icon_type'][$counter_coutner]).'" ';
                                                    }
                                                    if(isset($_POST['counter_icon'][$counter_coutner]) && $_POST['counter_icon'][$counter_coutner] != ''){
                                                        $shortcode_item .=  'counter_icon="'.htmlspecialchars($_POST['counter_icon'][$counter_coutner], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['counter_icon_align'][$counter_coutner]) && $_POST['counter_icon_align'][$counter_coutner] != ''){
                                                        $shortcode_item .= 'counter_icon_align="'.htmlspecialchars($_POST['counter_icon_align'][$counter_coutner], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['counter_icon_size'][$counter_coutner]) && $_POST['counter_icon_size'][$counter_coutner] != ''){
                                                        $shortcode_item .= 'counter_icon_size="'.htmlspecialchars($_POST['counter_icon_size'][$counter_coutner], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['cs_counter_logo'][$counter_coutner]) && $_POST['cs_counter_logo'][$counter_coutner] != ''){
                                                        $shortcode_item .= 'cs_counter_logo="'.htmlspecialchars($_POST['cs_counter_logo'][$counter_coutner], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['counter_icon_color'][$counter_coutner]) && $_POST['counter_icon_color'][$counter_coutner] != ''){
                                                        $shortcode_item .= 'counter_icon_color="'.htmlspecialchars($_POST['counter_icon_color'][$counter_coutner], ENT_QUOTES).'" ';
                                                    }
                                                    
                                                    if(isset($_POST['counter_numbers'][$counter_coutner]) && $_POST['counter_numbers'][$counter_coutner] != ''){
                                                        $shortcode_item .= 'counter_numbers="'.htmlspecialchars($_POST['counter_numbers'][$counter_coutner]).'" ';
                                                    }
                                                    if(isset($_POST['counter_number_color'][$counter_coutner]) && $_POST['counter_number_color'][$counter_coutner] != ''){
                                                        $shortcode_item .= 'counter_number_color="'.htmlspecialchars($_POST['counter_number_color'][$counter_coutner]).'" ';
                                                    }
                                                    if(isset($_POST['counter_text_color'][$counter_coutner]) && $_POST['counter_text_color'][$counter_coutner] != ''){
                                                        $shortcode_item .= 'counter_text_color="'.htmlspecialchars($_POST['counter_text_color'][$counter_coutner]).'" ';
                                                    }
													 
													 if(isset($_POST['counter_border_color'][$counter_coutner]) && $_POST['counter_border_color'][$counter_coutner] != ''){
                                                        $shortcode_item .= 'counter_border_color="'.htmlspecialchars($_POST['counter_border_color'][$counter_coutner]).'" ';
                                                    }
													
                                                    if(isset($_POST['counter_border'][$counter_coutner]) && $_POST['counter_border'][$counter_coutner] != ''){
                                                        $shortcode_item .= 'counter_border="'.htmlspecialchars($_POST['counter_border'][$counter_coutner]).'" ';
                                                    }
                                                    if(isset($_POST['counter_class'][$counter_coutner]) && $_POST['counter_class'][$counter_coutner] != ''){
                                                        $shortcode_item .= 'counter_class="'.htmlspecialchars($_POST['counter_class'][$counter_coutner], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['counter_animation'][$counter_coutner]) && $_POST['counter_animation'][$counter_coutner] != ''){
                                                        $shortcode_item .= 'counter_animation="'.htmlspecialchars($_POST['counter_animation'][$counter_coutner]).'" ';
                                                    }
                                                    $shortcode_item .= ']';
                                                    $shortcode_item .= '[/'.CS_SC_COUNTERS.']'; 
                                                    $counter->addChild('cs_shortcode', $shortcode_item );
                                                $counter_coutner++;
                                              }
                                              $cs_global_counter_counter++;
                                            }
                                            // Pricetable
                                            else if ( $_POST['cs_orderby'][$cs_counter] == "pricetable" ) {
                                                $shortcode = $price_item = $shortcode_item = '';
                                                $pricetable_item = $column->addChild('pricetable');
                                                $pricetable_item->addChild('page_element_size', htmlspecialchars($_POST['pricetable_element_size'][$cs_global_counter_pricetables]) );
                                                $pricetable_item->addChild('pricetable_element_size', htmlspecialchars($_POST['pricetable_element_size'][$cs_global_counter_pricetables]) );
                                                if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
                                                    $shortcode_str = stripslashes ($_POST['shortcode']['pricetable'][$cs_shortcode_counter_pricetables]);
                                                    $cs_shortcode_counter_pricetables++;
                                                    $pricetable_item->addChild('cs_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES) );
                                                } else {
                                                    if(isset($_POST['price_num'][$cs_counter_pricetables]) && $_POST['price_num'][$cs_counter_pricetables]>0){
                                                        for ( $i = 1; $i <= $_POST['price_num'][$cs_counter_pricetables]; $i++ ){
                                                            $price_item .= '['.CS_SC_PRICETABLEITEM.' ';
                                                            if(isset($_POST['pricing_feature'][$cs_counter_pricetables_node]) && trim($_POST['pricing_feature'][$cs_counter_pricetables_node]) != ''){
                                                                $price_item .= 'pricing_feature="'.htmlspecialchars($_POST['pricing_feature'][$cs_counter_pricetables_node], ENT_QUOTES).'" ';
                                                            }
                                                            $price_item .= ']';
                                                            $price_item .=     '[/'.CS_SC_PRICETABLEITEM.']'; 
                                                            $cs_counter_pricetables_node++;
                                                        }
                                                    }
                                                    $section_title = '';
                                                    if(isset($_POST['cs_pricetable_section_title'][$cs_counter_pricetables]) && $_POST['cs_pricetable_section_title'][$cs_counter_pricetables] != ''){
                                                        $section_title ='cs_pricetable_section_title="'.htmlspecialchars($_POST['cs_pricetable_section_title'][$cs_counter_pricetables], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['pricetable_style'][$cs_counter_pricetables]) && $_POST['pricetable_style'][$cs_counter_pricetables] != ''){
                                                        $shortcode_item .= 'pricetable_style="'.htmlspecialchars($_POST['pricetable_style'][$cs_counter_pricetables], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['pricetable_title'][$cs_counter_pricetables]) && $_POST['pricetable_title'][$cs_counter_pricetables] != ''){
                                                        $shortcode_item .= 'pricetable_title="'.htmlspecialchars($_POST['pricetable_title'][$cs_counter_pricetables], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['pricetable_title_bgcolor'][$cs_counter_pricetables]) && $_POST['pricetable_title_bgcolor'][$cs_counter_pricetables] != ''){
                                                        $shortcode_item .= 'pricetable_title_bgcolor="'.htmlspecialchars($_POST['pricetable_title_bgcolor'][$cs_counter_pricetables], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['pricetable_price'][$cs_counter_pricetables]) && $_POST['pricetable_price'][$cs_counter_pricetables] != ''){
                                                        $shortcode_item .= 'pricetable_price="'.htmlspecialchars($_POST['pricetable_price'][$cs_counter_pricetables], ENT_QUOTES).'" ';
                                                    }
													if(isset($_POST['currency_symbols'][$cs_counter_pricetables]) && $_POST['currency_symbols'][$cs_counter_pricetables] != ''){
                                                        $shortcode_item .= 'currency_symbols="'.htmlspecialchars($_POST['currency_symbols'][$cs_counter_pricetables], ENT_QUOTES).'" ';
                                                    }
                                                     
                                                    
                                                    if(isset($_POST['pricetable_period'][$cs_counter_pricetables]) && $_POST['pricetable_period'][$cs_counter_pricetables] != ''){
                                                        $shortcode_item .= 'pricetable_period="'.htmlspecialchars($_POST['pricetable_period'][$cs_counter_pricetables], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['pricetable_bgcolor'][$cs_counter_pricetables]) && $_POST['pricetable_bgcolor'][$cs_counter_pricetables] != ''){
                                                        $shortcode_item .= 'pricetable_bgcolor="'.htmlspecialchars($_POST['pricetable_bgcolor'][$cs_counter_pricetables], ENT_QUOTES).'" ';
                                                    }
                                                    
                                                    if(isset($_POST['btn_text'][$cs_counter_pricetables]) && $_POST['btn_text'][$cs_counter_pricetables] != ''){
                                                        $shortcode_item .= 'btn_text="'.htmlspecialchars($_POST['btn_text'][$cs_counter_pricetables], ENT_QUOTES).'" ';
                                                    }
													if(isset($_POST['btn_link'][$cs_counter_pricetables]) && $_POST['btn_link'][$cs_counter_pricetables] != ''){
                                                        $shortcode_item .= 'btn_link="'.htmlspecialchars($_POST['btn_link'][$cs_counter_pricetables], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['btn_bg_color'][$cs_counter_pricetables]) && $_POST['btn_bg_color'][$cs_counter_pricetables] != ''){
                                                        $shortcode_item .= 'btn_bg_color="'.htmlspecialchars($_POST['btn_bg_color'][$cs_counter_pricetables]).'" ';
                                                    }
                                                    if(isset($_POST['pricetable_featured'][$cs_counter_pricetables]) && $_POST['pricetable_featured'][$cs_counter_pricetables] != ''){
                                                        $shortcode_item .= 'pricetable_featured="'.htmlspecialchars($_POST['pricetable_featured'][$cs_counter_pricetables], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['pricetable_class'][$cs_counter_pricetables]) && $_POST['pricetable_class'][$cs_counter_pricetables] != ''){
                                                        $shortcode_item .= 'pricetable_class="'.htmlspecialchars($_POST['pricetable_class'][$cs_counter_pricetables], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['pricetable_animation'][$cs_counter_pricetables]) && $_POST['pricetable_animation'][$cs_counter_pricetables] != ''){
                                                        $shortcode_item .= 'pricetable_animation="'.htmlspecialchars($_POST['pricetable_animation'][$cs_counter_pricetables]).'" ';
                                                    }
                                                    $shortcode = '['.CS_SC_PRICETABLE.' '.$section_title.' '.$shortcode_item.']';
                                                    $shortcode .=     $price_item . '[/'.CS_SC_PRICETABLE.']';
                                                    $pricetable_item->addChild('cs_shortcode', $shortcode );
                                                    $cs_counter_pricetables++;
                                                }
                                              $cs_global_counter_pricetables++;
                                            }
                            
                                            // Progressbar
                                            else if ( $_POST['cs_orderby'][$cs_counter] == "progressbars" ) {
                                                $shortcode = $shortcode_item = '';
                                                $progressbars = $column->addChild('progressbars');
                                                $progressbars->addChild('progressbars_element_size', $_POST['progressbars_element_size'][$cs_global_counter_progressbars] );
                                                $progressbars->addChild('page_element_size', $_POST['progressbars_element_size'][$cs_global_counter_progressbars] );
                                                
                                                if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
                                                    $shortcode_str = stripslashes ($_POST['shortcode']['progressbars'][$cs_shortcode_counter_progressbars]);
                                                    $cs_shortcode_counter_progressbars++;
                                                    $progressbars->addChild('cs_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES) );
                                                } else {
                                                    if(isset($_POST['progressbars_num'][$cs_counter_progressbars]) && $_POST['progressbars_num'][$cs_counter_progressbars]>0){
                                                        for ( $i = 1; $i <= $_POST['progressbars_num'][$cs_counter_progressbars]; $i++ ){
                                                            $shortcode_item .= '['.CS_SC_PROGRESSBARITEM.' ';
                                                            if(isset($_POST['progressbars_title'][$cs_counter_progressbars_node]) && $_POST['progressbars_title'][$cs_counter_progressbars_node] != ''){
                                                                $shortcode_item .= 'progressbars_title="'.htmlspecialchars($_POST['progressbars_title'][$cs_counter_progressbars_node], ENT_QUOTES).'" ';
                                                            }
                                                            if(isset($_POST['progressbars_percentage'][$cs_counter_progressbars_node]) && $_POST['progressbars_percentage'][$cs_counter_progressbars_node] != ''){
                                                                $shortcode_item .= 'progressbars_percentage="'.htmlspecialchars($_POST['progressbars_percentage'][$cs_counter_progressbars_node], ENT_QUOTES).'" ';
                                                            }
                                                            if(isset($_POST['progressbars_color'][$cs_counter_progressbars_node]) && $_POST['progressbars_color'][$cs_counter_progressbars_node] != ''){
                                                                $shortcode_item .= 'progressbars_color="'.htmlspecialchars($_POST['progressbars_color'][$cs_counter_progressbars_node], ENT_QUOTES).'" ';
                                                            }
                                                            $shortcode_item .=']'; 
                                                             
                                                            $cs_counter_progressbars_node++;
                                                        }
                                                    }
                                                    
													$shortcode .= '['.CS_SC_PROGRESSBAR.' ';
                                                    
                                                    if(isset($_POST['cs_progressbars_style'][$cs_counter_progressbars]) && trim($_POST['cs_progressbars_style'][$cs_counter_progressbars]) <> ''){
                                                        $shortcode .= 'cs_progressbars_style="'.htmlspecialchars($_POST['cs_progressbars_style'][$cs_counter_progressbars]).'" ';
                                                    }
                                                    if(isset($_POST['progressbars_class'][$cs_counter_progressbars]) && $_POST['progressbars_class'][$cs_counter_progressbars] != ''){
                                                        $shortcode .= 'progressbars_class="'.htmlspecialchars($_POST['progressbars_class'][$cs_counter_progressbars], ENT_QUOTES).'" ';
                                                    }
													if(isset($_POST['section_title'][$cs_counter_progressbars]) && $_POST['section_title'][$cs_counter_progressbars] != ''){
                                                        $shortcode .= 'section_title="'.htmlspecialchars($_POST['section_title'][$cs_counter_progressbars], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['progressbars_animation'][$cs_counter_progressbars]) && $_POST['progressbars_animation'][$cs_counter_progressbars] != ''){
                                                        $shortcode .= 'progressbars_animation="'.htmlspecialchars($_POST['progressbars_animation'][$cs_counter_progressbars]).'" ';
                                                    }
                                                    
                                                    $shortcode .= ']'.$shortcode_item.'[/'.CS_SC_PROGRESSBAR.']';
                                                    
                                                    $progressbars->addChild('cs_shortcode', $shortcode );
                                                
                                                $cs_counter_progressbars++;
                                            }
                                            $cs_global_counter_progressbars++;
                                        }
                                            // Table
                                            else if ( $_POST['cs_orderby'][$cs_counter] == "table" ) {
                                                $shortcode = '';
                                                $table        = $column->addChild('table');
                                                $table->addChild('table_element_size', $_POST['table_element_size'][$cs_global_counter_table] );
                                                $table->addChild('page_element_size', $_POST['table_element_size'][$cs_global_counter_table] );
                                                if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
                                                     $shortcode_str = stripslashes ($_POST['shortcode']['table'][$cs_shortcode_counter_table]);
                                                    $cs_shortcode_counter_table++;
                                                    $table->addChild('cs_shortcode', htmlspecialchars($shortcode_str) );
                                                } else {
                                                    $shortcode .= '['.CS_SC_TABLES.' ';
                                                    if(isset($_POST['cs_table_section_title'][$cs_counter_table]) && $_POST['cs_table_section_title'][$cs_counter_table] != ''){
                                                        $shortcode .= ' cs_table_section_title="'.htmlspecialchars($_POST['cs_table_section_title'][$cs_counter_table], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['table_style'][$cs_counter_table]) && trim($_POST['table_style'][$cs_counter_table]) <> ''){
                                                        $shortcode .= 'table_style="'.htmlspecialchars($_POST['table_style'][$cs_counter_table], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['cs_table_class'][$cs_counter_table]) && $_POST['cs_table_class'][$cs_counter_table] != ''){
                                                        $shortcode .= 'cs_table_class="'.htmlspecialchars($_POST['cs_table_class'][$cs_counter_table], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['cs_table_animation'][$cs_counter_table]) && $_POST['cs_table_animation'][$cs_counter_table] != ''){
                                                        $shortcode .= 'cs_table_animation="'.htmlspecialchars($_POST['cs_table_animation'][$cs_counter_table]).'" ';
                                                    }
                                                    $shortcode .= ']';
                                                    if(isset($_POST['cs_table_content'][$cs_counter_table]) && $_POST['cs_table_content'][$cs_counter_table] != ''){
                                                        $shortcode .= htmlspecialchars($_POST['cs_table_content'][$cs_counter_table], ENT_QUOTES);
                                                    }
                                                    $shortcode .='[/'.CS_SC_TABLES.']';
                                                    $table->addChild('cs_shortcode', $shortcode );                                                            
                                                    $cs_counter_table++;
                                                }
                                                $cs_global_counter_table++;
                                            }
                                            // Button
                                            else if ( $_POST['cs_orderby'][$cs_counter] == "button" ) {
                                                $shortcode  = '';
                                                $button = $column->addChild('button');
                                                $button->addChild('page_element_size', htmlspecialchars($_POST['button_element_size'][$cs_global_counter_button]) );
                                                $button->addChild('button_element_size', htmlspecialchars($_POST['button_element_size'][$cs_global_counter_button]) );
                                                if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
                                                    $shortcode_str = stripslashes ($_POST['shortcode']['button'][$cs_shortcode_counter_button]);
                                                    $button->addChild('cs_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES) );
                                                    $cs_shortcode_counter_button++;
                                                } else {
                                                    $shortcode .= '['.CS_SC_BUTTON.' ';
                                                    if(isset($_POST['button_size'][$cs_counter_button]) && trim($_POST['button_size'][$cs_counter_button]) <> ''){
                                                        $shortcode .= 'button_size="'.htmlspecialchars($_POST['button_size'][$cs_counter_button]).'" ';
                                                    }
                                                    if(isset($_POST['button_title'][$cs_counter_button]) && trim($_POST['button_title'][$cs_counter_button]) <> ''){
                                                        $shortcode .= 'button_title="'.htmlspecialchars($_POST['button_title'][$cs_counter_button], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['button_link'][$cs_counter_button]) && trim($_POST['button_link'][$cs_counter_button]) <> ''){
                                                        $shortcode .= 'button_link="'.htmlspecialchars($_POST['button_link'][$cs_counter_button], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['button_bg_color'][$cs_counter_button]) && trim($_POST['button_bg_color'][$cs_counter_button]) <> ''){
                                                        $shortcode .= 'button_bg_color="'.htmlspecialchars($_POST['button_bg_color'][$cs_counter_button], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['button_color'][$cs_counter_button]) && trim($_POST['button_color'][$cs_counter_button]) <> ''){
                                                        $shortcode .='button_color="'.htmlspecialchars($_POST['button_color'][$cs_counter_button], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['border_button_color'][$cs_counter_button]) && trim($_POST['border_button_color'][$cs_counter_button]) <> ''){
                                                        $shortcode .= 'border_button_color="'.htmlspecialchars($_POST['border_button_color'][$cs_counter_button]).'" ';
                                                    }
                                                    if(isset($_POST['button_icon'][$cs_counter_button]) && trim($_POST['button_icon'][$cs_counter_button]) <> ''){
                                                        $shortcode .= 'button_icon="'.htmlspecialchars($_POST['button_icon'][$cs_counter_button], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['button_icon_position'][$cs_counter_button]) && trim($_POST['button_icon_position'][$cs_counter_button]) <> ''){
                                                        $shortcode .= 'button_icon_position="'.htmlspecialchars($_POST['button_icon_position'][$cs_counter_button]).'" ';
                                                    }
                                                    if(isset($_POST['button_type'][$cs_counter_button]) && trim($_POST['button_type'][$cs_counter_button]) <> ''){
                                                        $shortcode .= 'button_type="'.htmlspecialchars($_POST['button_type'][$cs_counter_button]).'" ';
                                                    }
                                                    if(isset($_POST['button_target'][$cs_counter_button]) && trim($_POST['button_target'][$cs_counter_button]) <> ''){
                                                        $shortcode .= 'button_target="'.htmlspecialchars($_POST['button_target'][$cs_counter_button]).'" ';
                                                    }
                                                    if(isset($_POST['button_border'][$cs_counter_button]) && trim($_POST['button_border'][$cs_counter_button]) <> ''){
                                                        $shortcode .='button_border="'.htmlspecialchars($_POST['button_border'][$cs_counter_button]).'" ';
                                                    }
                                                    if(isset($_POST['cs_button_class'][$cs_counter_button]) && $_POST['cs_button_class'][$cs_counter_button] != ''){
                                                        $shortcode .='cs_button_class="'.htmlspecialchars($_POST['cs_button_class'][$cs_counter_button], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['cs_button_animation'][$cs_counter_button]) && $_POST['cs_button_animation'][$cs_counter_button] != ''){
                                                        $shortcode .='cs_button_animation="'.htmlspecialchars($_POST['cs_button_animation'][$cs_counter_button]).'" ';
                                                    }
                                                    $shortcode .= ']';
                                                    $button->addChild('cs_shortcode', $shortcode );
                                                    $cs_counter_button++;
                                                }
                                                $cs_global_counter_button++;
                                            }
                           
                                        
                                        // Common Elements end
                                        
                            // Media Elements Shortcode
                                        else if ( $_POST['cs_orderby'][$cs_counter] == "slider" ) {
                                                $shortcode  = '';
                                                $slider     = $column->addChild('slider');
                                                $slider->addChild('page_element_size', $_POST['slider_element_size'][$cs_global_counter_slider] );
                                                $slider->addChild('slider_element_size', $_POST['slider_element_size'][$cs_global_counter_slider] );

                                                if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
                                                    $shortcode_str = stripslashes ($_POST['shortcode']['slider'][$cs_shortcode_counter_slider]);
                                                    $cs_shortcode_counter_slider++;
                                                    $slider->addChild('cs_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES) );
                                                } else {
                                               
													$shortcode .= '['.CS_SC_SLIDER.' ';
                                                    if(isset($_POST['cs_slider_header_title'][$cs_counter_slider]) && trim($_POST['cs_slider_header_title'][$cs_counter_slider]) <> ''){
                                                        $shortcode .=     'cs_slider_header_title="'.htmlspecialchars($_POST['cs_slider_header_title'][$cs_counter_slider], ENT_QUOTES).'" ';
                                                    }
                                                     if(isset($_POST['cs_slider'][$cs_counter_slider]) && trim($_POST['cs_slider'][$cs_counter_slider]) <> ''){
                                                        $shortcode .=     'cs_slider="'.htmlspecialchars($_POST['cs_slider'][$cs_counter_slider]).'" ';
                                                    }
                                                    if(isset($_POST['cs_slider_id'][$cs_counter_slider]) && trim($_POST['cs_slider_id'][$cs_counter_slider]) <> ''){
                                                        $shortcode .=     'cs_slider_id="'.htmlspecialchars($_POST['cs_slider_id'][$cs_counter_slider]).'" ';
                                                    }
                                                     
                                                    $shortcode .=     ']';
                                                    $slider->addChild('cs_shortcode', $shortcode );
                                                    $cs_counter_slider++;
                                                }
                                                $cs_global_counter_slider++;
                                            } 
                                        else if ( $_POST['cs_orderby'][$cs_counter] == "promobox" ) {
                                                $shortcode  = '';
                                                $promobox = $column->addChild('promobox');
                                                 $promobox->addChild('page_element_size', htmlspecialchars($_POST['promobox_element_size'][$cs_global_counter_promobox]) );
                                                if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
                                                    $shortcode_str = stripslashes ($_POST['shortcode']['promobox'][$cs_shortcode_counter_promobox]);
                                                    $cs_shortcode_counter_promobox++;
                                                    $promobox->addChild('cs_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES) );
                                                } else {
												$shortcode .= '['.CS_SC_PROMOBOX.' ';
                                                   
                                                    if(isset($_POST['cs_promobox_section_title'][$cs_counter_promobox]) && trim($_POST['cs_promobox_section_title'][$cs_counter_promobox]) <> ''){
                                                        $shortcode .= 'cs_promobox_section_title="'.htmlspecialchars($_POST['cs_promobox_section_title'][$cs_counter_promobox], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['cs_promo_image_url'][$cs_counter_promobox]) && trim($_POST['cs_promo_image_url'][$cs_counter_promobox]) <> ''){
                                                        $shortcode .='cs_promo_image_url="'.htmlspecialchars($_POST['cs_promo_image_url'][$cs_counter_promobox], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['cs_promobox_title'][$cs_counter_promobox]) && trim($_POST['cs_promobox_title'][$cs_counter_promobox]) <> ''){
                                                        $shortcode .= 'cs_promobox_title="'.htmlspecialchars($_POST['cs_promobox_title'][$cs_counter_promobox], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['cs_promobox_contents'][$cs_counter_promobox]) && trim($_POST['cs_promobox_contents'][$cs_counter_promobox]) <> ''){
                                                        $shortcode .= 'cs_promobox_contents="'.htmlspecialchars($_POST['cs_promobox_contents'][$cs_counter_promobox], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['cs_link'][$cs_counter_promobox]) && trim($_POST['cs_link'][$cs_counter_promobox]) <> ''){
                                                        $shortcode .= 'cs_link="'.htmlspecialchars($_POST['cs_link'][$cs_counter_promobox], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['cs_promobox_title_color'][$cs_counter_promobox]) && trim($_POST['cs_promobox_title_color'][$cs_counter_promobox]) <> ''){
                                                        $shortcode .='cs_promobox_title_color="'.htmlspecialchars($_POST['cs_promobox_title_color'][$cs_counter_promobox], ENT_QUOTES).'" ';
														
                                                    }
													 if(isset($_POST['cs_promobox_background_color'][$cs_counter_promobox]) && trim($_POST['cs_promobox_background_color'][$cs_counter_promobox]) <> ''){
                                                        $shortcode .='cs_promobox_background_color="'.htmlspecialchars($_POST['cs_promobox_background_color'][$cs_counter_promobox], ENT_QUOTES).'" ';
														
                                                    }
                                                    if(isset($_POST['cs_promobox_content_color'][$cs_counter_promobox]) && trim($_POST['cs_promobox_content_color'][$cs_counter_promobox]) <> ''){
                                                        $shortcode .= 'cs_promobox_content_color="'.htmlspecialchars($_POST['cs_promobox_content_color'][$cs_counter_promobox], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['cs_promobox_btn_bg_color'][$cs_counter_promobox]) && trim($_POST['cs_promobox_btn_bg_color'][$cs_counter_promobox]) <> ''){
                                                        $shortcode .= 'cs_promobox_btn_bg_color="'.htmlspecialchars($_POST['cs_promobox_btn_bg_color'][$cs_counter_promobox], ENT_QUOTES).'" ';
                                                    }
													if(isset($_POST['cs_promobox_btn_text_color'][$cs_counter_promobox]) && trim($_POST['cs_promobox_btn_text_color'][$cs_counter_promobox]) <> ''){
                                                        $shortcode .= 'cs_promobox_btn_text_color="'.htmlspecialchars($_POST['cs_promobox_btn_text_color'][$cs_counter_promobox], ENT_QUOTES).'" ';
                                                    }
													
												    if(isset($_POST['cs_link_title'][$cs_counter_promobox]) && trim($_POST['cs_link_title'][$cs_counter_promobox]) <> ''){
                                                        $shortcode .= 'cs_link_title="'.htmlspecialchars($_POST['cs_link_title'][$cs_counter_promobox], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['bg_repeat'][$cs_counter_promobox]) && trim($_POST['bg_repeat'][$cs_counter_promobox]) <> ''){
                                                        $shortcode .='bg_repeat="'.htmlspecialchars($_POST['bg_repeat'][$cs_counter_promobox], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['text_align'][$cs_counter_promobox]) && trim($_POST['text_align'][$cs_counter_promobox]) <> ''){
                                                        $shortcode .='text_align="'.htmlspecialchars($_POST['text_align'][$cs_counter_promobox], ENT_QUOTES).'" ';
                                                    }
													 if(isset($_POST['promobox_view'][$cs_counter_promobox]) && trim($_POST['promobox_view'][$cs_counter_promobox]) <> ''){
                                                        $shortcode .='promobox_view="'.htmlspecialchars($_POST['promobox_view'][$cs_counter_promobox], ENT_QUOTES).'" ';
                                                    }
													if(isset($_POST['cs_promobox_class'][$cs_counter_promobox]) && $_POST['cs_promobox_class'][$cs_counter_promobox] != ''){
                                                        $shortcode .= 'cs_promobox_class="'.htmlspecialchars($_POST['cs_promobox_class'][$cs_counter_promobox], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['cs_promobox_animation'][$cs_counter_promobox]) && $_POST['cs_promobox_animation'][$cs_counter_promobox] != ''){
                                                        $shortcode .='cs_promobox_animation="'.htmlspecialchars($_POST['cs_promobox_animation'][$cs_counter_promobox]).'" ';
                                                    }
                                                    $shortcode .=']';
                                                    if(isset($_POST['cs_promobox_contents'][$cs_counter_promobox]) && $_POST['cs_promobox_contents'][$cs_counter_promobox] != ''){
                                                        $shortcode .= htmlspecialchars($_POST['cs_promobox_contents'][$cs_counter_promobox], ENT_QUOTES);
                                                    }
													 $shortcode .=     '[/'.CS_SC_PROMOBOX.']';
                                                                
                                                    $promobox->addChild('cs_shortcode', $shortcode );
                                                    $cs_counter_promobox++;
                                                }
                                            $cs_global_counter_promobox++;
                                        }
                                        else if ( $_POST['cs_orderby'][$cs_counter] == "teams" ) {
													$shortcode = '';
													$team = $column->addChild('teams');
													$team->addChild('page_element_size', htmlspecialchars($_POST['teams_element_size'][$cs_global_counter_teams]) );
													$team->addChild('teams_element_size', htmlspecialchars($_POST['teams_element_size'][$cs_global_counter_teams]) );
													if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
														$shortcode_str = stripslashes ($_POST['shortcode']['teams'][$cs_shortcode_counter_teams]);
														$cs_shortcode_counter_teams++;
														$team->addChild('cs_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES) );
													} else {
														$shortcode = '['.CS_SC_TEAM.' ';
														if(isset($_POST['cs_team_section_title'][$cs_counter_teams])  && $_POST['cs_team_section_title'][$cs_counter_teams] != ''){
															$shortcode .= 	'cs_team_section_title="'.htmlspecialchars($_POST['cs_team_section_title'][$cs_counter_teams], ENT_QUOTES).'" ';
														}		
														
														if(isset($_POST['cs_team_name'][$cs_counter_teams])  && $_POST['cs_team_name'][$cs_counter_teams] != ''){
															$shortcode .= 	'cs_team_name="'.htmlspecialchars($_POST['cs_team_name'][$cs_counter_teams], ENT_QUOTES).'" ';
														}
														if(isset($_POST['cs_team_designation'][$cs_counter_teams])  && $_POST['cs_team_designation'][$cs_counter_teams] != ''){
															$shortcode .= 	'cs_team_designation="'.htmlspecialchars($_POST['cs_team_designation'][$cs_counter_teams]).'" ';
														}
														if(isset($_POST['cs_team_description'][$cs_counter_teams])  && $_POST['cs_team_description'][$cs_counter_teams] != ''){
															$shortcode .= 	'cs_team_description="'.htmlspecialchars($_POST['cs_team_description'][$cs_counter_teams], ENT_QUOTES).'" ';
														}
														if(isset($_POST['cs_team_profile_image'][$cs_counter_teams])  && $_POST['cs_team_profile_image'][$cs_counter_teams] != ''){
															$shortcode .= 	'cs_team_profile_image="'.htmlspecialchars($_POST['cs_team_profile_image'][$cs_counter_teams]).'" ';
														}
														if(isset($_POST['cs_team_fb_url'][$cs_counter_clients])  && $_POST['cs_team_fb_url'][$cs_counter_teams] != ''){
															$shortcode .= 	'cs_team_fb_url="'.htmlspecialchars($_POST['cs_team_fb_url'][$cs_counter_teams]).'" ';
														}
														if(isset($_POST['cs_team_twitter_url'][$cs_counter_clients])  && $_POST['cs_team_twitter_url'][$cs_counter_teams] != ''){
															$shortcode .= 	'cs_team_twitter_url="'.htmlspecialchars($_POST['cs_team_twitter_url'][$cs_counter_teams]).'" ';
														}
														if(isset($_POST['cs_team_googleplus_url'][$cs_counter_teams])  && $_POST['cs_team_googleplus_url'][$cs_counter_teams] != ''){
															$shortcode .= 	'cs_team_googleplus_url="'.htmlspecialchars($_POST['cs_team_googleplus_url'][$cs_counter_teams]).'" ';
														}
														if(isset($_POST['cs_team_skype_url'][$cs_counter_clients])  && $_POST['cs_team_skype_url'][$cs_counter_teams] != ''){
															$shortcode .= 	'cs_team_skype_url="'.htmlspecialchars($_POST['cs_team_skype_url'][$cs_counter_teams]).'" ';
														}
														if(isset($_POST['cs_team_email'][$cs_counter_clients])  && $_POST['cs_team_email'][$cs_counter_teams] != ''){
															$shortcode .= 	'cs_team_email="'.htmlspecialchars($_POST['cs_team_email'][$cs_counter_teams]).'" ';
														}
														
														$shortcode .= 	']';
														if(isset($_POST['cs_team_description'][$cs_counter_teams])  && $_POST['cs_team_description'][$cs_counter_teams] != ''){
															$shortcode .= 	htmlspecialchars($_POST['cs_team_description'][$cs_counter_teams], ENT_QUOTES);
														}
														$shortcode .= 	'[/'.CS_SC_TEAM.']';
														$team->addChild('cs_shortcode', $shortcode );
														$cs_counter_teams++;
													}
												$cs_global_counter_teams++;	
										}
										
										else if ( $_POST['cs_orderby'][$cs_counter] == "team_post" ) {
											 
                                            $shortcode = '';
                                            $team = $column->addChild('team_post');
                                            $team->addChild('page_element_size', htmlspecialchars($_POST['team_post_element_size'][$cs_global_counter_team_post]) );
                                            $team->addChild('team_post_element_size', htmlspecialchars($_POST['team_post_element_size'][$cs_global_counter_team_post]) );
                                            if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
                                                $shortcode_str = stripslashes ($_POST['shortcode']['team_post'][$cs_shortcode_counter_team_post]);
                                                $cs_shortcode_counter_team_post++;
                                                $team->addChild('cs_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES) );
                                            } else {
                                                $shortcode = '[cs_team_post ';
                                                if(isset($_POST['cs_team_post_section_title'][$cs_counter_team_post])  && $_POST['cs_team_post_section_title'][$cs_counter_team_post] != ''){
                                                    $shortcode .= 	'cs_team_post_section_title="'.htmlspecialchars($_POST['cs_team_post_section_title'][$cs_counter_team_post], ENT_QUOTES).'" ';
                                                }
												
												if(isset($_POST['cs_team_post_orderby'][$cs_counter_team_post])  && $_POST['cs_team_post_orderby'][$cs_counter_team_post] != ''){
                                                    $shortcode .= 	'cs_team_post_orderby="'.htmlspecialchars($_POST['cs_team_post_orderby'][$cs_counter_team_post], ENT_QUOTES).'" ';
                                                }
												if(isset($_POST['cs_team_post_description'][$cs_counter_team_post])  && $_POST['cs_team_post_description'][$cs_counter_team_post] != ''){
                                                    $shortcode .= 	'cs_team_post_description="'.htmlspecialchars($_POST['cs_team_post_description'][$cs_counter_team_post], ENT_QUOTES).'" ';
                                                }
												if(isset($_POST['cs_team_post_excerpt'][$cs_counter_team_post])  && $_POST['cs_team_post_excerpt'][$cs_counter_team_post] != ''){
                                                    $shortcode .= 	'cs_team_post_excerpt="'.htmlspecialchars($_POST['cs_team_post_excerpt'][$cs_counter_team_post], ENT_QUOTES).'" ';
                                                }
												if(isset($_POST['cs_team_post_num_post'][$cs_counter_team_post])  && $_POST['cs_team_post_num_post'][$cs_counter_team_post] != ''){
                                                    $shortcode .= 	'cs_team_post_num_post="'.htmlspecialchars($_POST['cs_team_post_num_post'][$cs_counter_team_post], ENT_QUOTES).'" ';
                                                }
												
												if(isset($_POST['cs_team_style'][$cs_counter_team_post])  && $_POST['cs_team_style'][$cs_counter_team_post] != ''){
                                                    $shortcode .= 	'cs_team_style="'.htmlspecialchars($_POST['cs_team_style'][$cs_counter_team_post], ENT_QUOTES).'" ';
                                                }
								 				if(isset($_POST['team_post_pagination'][$cs_counter_team_post])  && $_POST['team_post_pagination'][$cs_counter_team_post] != ''){
                                                    $shortcode .= 	'team_post_pagination="'.htmlspecialchars($_POST['team_post_pagination'][$cs_counter_team_post], ENT_QUOTES).'" ';
                                                }
                                                
                                                $shortcode .= 	']';
                                                
                                                $shortcode .= 	'[/cs_team_post]';
                                                $team->addChild('cs_shortcode', $shortcode );
                                                $cs_counter_team_post++;
                                            }
                                        	$cs_global_counter_team_post++;	
										}
										
										else if ( $_POST['cs_orderby'][$cs_counter] == "portfolio" ) {
                                            $shortcode = '';
                                            $team = $column->addChild('portfolio');
                                            $team->addChild('page_element_size', htmlspecialchars($_POST['portfolio_element_size'][$cs_global_counter_portfolio]) );
                                            $team->addChild('portfolio_element_size', htmlspecialchars($_POST['portfolio_element_size'][$cs_global_counter_portfolio]) );
                                            if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
                                                $shortcode_str = stripslashes ($_POST['shortcode']['portfolio'][$cs_shortcode_counter_portfolio]);
                                                $cs_shortcode_counter_portfolio++;
                                                $team->addChild('cs_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES) );
                                            } else {
                                                $shortcode = '[cs_portfolio ';
                                                if(isset($_POST['cs_portfolio_section_title'][$cs_counter_portfolio])  && $_POST['cs_portfolio_section_title'][$cs_counter_portfolio] != ''){
                                                    $shortcode .= 	'cs_portfolio_section_title="'.htmlspecialchars($_POST['cs_portfolio_section_title'][$cs_counter_portfolio], ENT_QUOTES).'" ';
                                                }
												if(isset($_POST['cs_portfolio_orderby'][$cs_counter_portfolio])  && $_POST['cs_portfolio_orderby'][$cs_counter_portfolio] != ''){
                                                    $shortcode .= 	'cs_portfolio_orderby="'.htmlspecialchars($_POST['cs_portfolio_orderby'][$cs_counter_portfolio], ENT_QUOTES).'" ';
                                                }
												if(isset($_POST['cs_portfolio_cat'][$cs_counter_portfolio])  && $_POST['cs_portfolio_cat'][$cs_counter_portfolio] != ''){
                                                    $shortcode .= 	'cs_portfolio_cat="'.htmlspecialchars($_POST['cs_portfolio_cat'][$cs_counter_portfolio], ENT_QUOTES).'" ';
                                                }
												if(isset($_POST['cs_portfolio_view'][$cs_counter_portfolio])  && $_POST['cs_portfolio_view'][$cs_counter_portfolio] != ''){
                                                    $shortcode .= 	'cs_portfolio_view="'.htmlspecialchars($_POST['cs_portfolio_view'][$cs_counter_portfolio], ENT_QUOTES).'" ';
                                                }
												if(isset($_POST['cs_port_filter'][$cs_counter_portfolio])  && $_POST['cs_port_filter'][$cs_counter_portfolio] != ''){
                                                    $shortcode .= 	'cs_port_filter="'.htmlspecialchars($_POST['cs_port_filter'][$cs_counter_portfolio], ENT_QUOTES).'" ';
                                                }
												if(isset($_POST['cs_portfolio_description'][$cs_counter_portfolio])  && $_POST['cs_portfolio_description'][$cs_counter_portfolio] != ''){
                                                    $shortcode .= 	'cs_portfolio_description="'.htmlspecialchars($_POST['cs_portfolio_description'][$cs_counter_portfolio], ENT_QUOTES).'" ';
                                                }
												if(isset($_POST['cs_portfolio_excerpt'][$cs_counter_portfolio])  && $_POST['cs_portfolio_excerpt'][$cs_counter_portfolio] != ''){
                                                    $shortcode .= 	'cs_portfolio_excerpt="'.htmlspecialchars($_POST['cs_portfolio_excerpt'][$cs_counter_portfolio], ENT_QUOTES).'" ';
                                                }
												if(isset($_POST['cs_portfolio_num_post'][$cs_counter_portfolio])  && $_POST['cs_portfolio_num_post'][$cs_counter_portfolio] != ''){
                                                    $shortcode .= 	'cs_portfolio_num_post="'.htmlspecialchars($_POST['cs_portfolio_num_post'][$cs_counter_portfolio], ENT_QUOTES).'" ';
                                                }
												if(isset($_POST['portfolio_pagination'][$cs_counter_portfolio])  && $_POST['portfolio_pagination'][$cs_counter_portfolio] != ''){
                                                    $shortcode .= 	'portfolio_pagination="'.htmlspecialchars($_POST['portfolio_pagination'][$cs_counter_portfolio], ENT_QUOTES).'" ';
                                                }
                                                
                                                $shortcode .= 	']';
                                                
                                                $shortcode .= 	'[/cs_portfolio]';
                                                $team->addChild('cs_shortcode', $shortcode );
                                                $cs_counter_portfolio++;
                                            }
                                        	$cs_global_counter_portfolio++;	
										}
                                        else if ( $_POST['cs_orderby'][$cs_counter] == "members" ) {
                                                $shortcode  = '';
                                                $members     = $column->addChild('members');
                                                $members->addChild('page_element_size', htmlspecialchars($_POST['members_element_size'][$cs_global_counter_members]) );
                                                $members->addChild('members_element_size', htmlspecialchars($_POST['members_element_size'][$cs_global_counter_members]) );
                                                if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
                                                    $shortcode_str = stripslashes ($_POST['shortcode']['members'][$cs_shortcode_counter_members]);
                                                    $cs_shortcode_counter_members++;
                                                    $output = array();
                                                    $PREFIX = 'cs_members';
                                                    $parseObject = new ShortcodeParse();
                                                    $output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
                                                    $defaults = array('var_pb_members_title' => '','var_contact_fields'=>'','var_pb_members_description'=>'','var_pb_members_roles'=>'','var_pb_members_filterable'=>'','var_pb_members_azfilterable'=>'','var_pb_members_pagination'=>'','var_pb_members_all_tab'=>'', 'var_pb_members_per_page'=>get_option("posts_per_page"),'var_pb_member_view'=>'','cs_members_class' => '','cs_members_animation' => '');
                                                    if(isset($output['0']['atts']))
                                                        $atts = $output['0']['atts'];
                                                    else 
                                                        $atts = array();
                                                    foreach($defaults as $key=>$values){
                                                        if(isset($atts[$key]))
                                                            $$key = $atts[$key];
                                                        else 
                                                            $$key =$values;
                                                     }
                                                    $members->addChild('var_pb_members_title', htmlspecialchars($var_pb_members_title, ENT_QUOTES) );
                                                    $members->addChild('var_pb_member_view', htmlspecialchars($var_pb_member_view) );
                                                    $members->addChild('var_pb_members_roles', htmlspecialchars($var_pb_members_roles));
                                                    $members->addChild('var_pb_members_filterable', htmlspecialchars($var_pb_members_filterable) );
                                                    $members->addChild('var_pb_members_azfilterable', htmlspecialchars($var_pb_members_azfilterable) );
                                                    $members->addChild('var_pb_members_azfilterable', htmlspecialchars($var_pb_members_azfilterable) );
                                                    $members->addChild('var_pb_members_all_tab', htmlspecialchars($var_pb_members_all_tab) );
                                                    $members->addChild('var_contact_fields', htmlspecialchars($var_contact_fields) );
                                                    $members->addChild('var_pb_members_description', htmlspecialchars($var_pb_members_description) );
                                                    $members->addChild('var_pb_members_pagination', htmlspecialchars($var_pb_members_pagination) );
                                                    $members->addChild('var_pb_members_per_page', intval($var_pb_members_per_page) );
                                                    $members->addChild('cs_members_class', htmlspecialchars($cs_members_class, ENT_QUOTES) );
                                                    $members->addChild('cs_members_animation', htmlspecialchars($cs_members_animation) );
                                                    $members->addChild('cs_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES) );
                                                } else {
                                                    if (isset($_POST['cs_members_counter'][$cs_counter_members])){
                                                         $cs_members_counter = htmlspecialchars($_POST['cs_members_counter'][$cs_counter_members]);
                                                     }
                                                    $members->addChild('var_pb_members_title', htmlspecialchars($_POST['var_pb_members_title'][$cs_counter_members], ENT_QUOTES) );
                                                    $members->addChild('var_pb_member_view', htmlspecialchars($_POST['var_pb_member_view'][$cs_counter_members]) );
                                                    
                                                    if (empty($_POST['var_pb_members_roles'][$cs_members_counter])){
                                                         $var_pb_members_roles = "";
                                                     } else {
                                                        $var_pb_members_roles = implode(",", $_POST['var_pb_members_roles'][$cs_members_counter]);
                                                    }
                                                    
                                                    $members->addChild('var_pb_members_roles', htmlspecialchars($var_pb_members_roles));
                                                    $members->addChild('var_pb_members_filterable', htmlspecialchars($_POST['var_pb_members_filterable'][$cs_counter_members] ));
                                                    $members->addChild('var_pb_members_azfilterable', htmlspecialchars($_POST['var_pb_members_azfilterable'][$cs_counter_members] ));
                                                    $members->addChild('var_pb_members_all_tab', htmlspecialchars($_POST['var_pb_members_all_tab'][$cs_counter_members]) );
                                                    
                                                    $members->addChild('var_pb_members_description', htmlspecialchars($_POST['var_pb_members_description'][$cs_counter_members]) );
                                                    $members->addChild('var_pb_members_pagination', htmlspecialchars($_POST['var_pb_members_pagination'][$cs_counter_members]) );
                                                    $members->addChild('var_pb_members_per_page', intval($_POST['var_pb_members_per_page'][$cs_counter_members] ));
                                                    $members->addChild('cs_members_class', htmlspecialchars($_POST['cs_members_class'][$cs_counter_members], ENT_QUOTES) );
                                                    $members->addChild('cs_members_animation', htmlspecialchars($_POST['cs_members_animation'][$cs_counter_members]) );
                                                    $shortcode .= '[cs_members ';
                                                    if(isset($_POST['var_pb_members_title'][$cs_counter_members]) && trim($_POST['var_pb_members_title'][$cs_counter_members]) <> ''){
                                                        $shortcode .= 'var_pb_members_title="'.htmlspecialchars($_POST['var_pb_members_title'][$cs_counter_members], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['var_pb_member_view'][$cs_counter_members]) && trim($_POST['var_pb_member_view'][$cs_counter_members]) <> ''){
                                                        $shortcode .= 'var_pb_member_view="'.htmlspecialchars($_POST['var_pb_member_view'][$cs_counter_members]).'" ';
                                                    }
                                                    if(isset($var_pb_members_roles) && trim($var_pb_members_roles) <> ''){
                                                        $shortcode .= 'var_pb_members_roles="'.htmlspecialchars($var_pb_members_roles).'" ';
                                                    }
                                                    if(isset($_POST['var_pb_members_filterable'][$cs_counter_members]) && trim($_POST['var_pb_members_filterable'][$cs_counter_members]) <> ''){
                                                        $shortcode .= 'var_pb_members_filterable="'.htmlspecialchars($_POST['var_pb_members_filterable'][$cs_counter_members]).'" ';
                                                    }
                                                    if(isset($_POST['var_pb_members_azfilterable'][$cs_counter_members]) && trim($_POST['var_pb_members_filterable'][$cs_counter_members]) <> ''){
                                                        $shortcode .= 'var_pb_members_azfilterable="'.htmlspecialchars($_POST['var_pb_members_azfilterable'][$cs_counter_members]).'" ';
                                                    }
                                                    if(isset($_POST['var_pb_members_all_tab'][$cs_counter_members]) && trim($_POST['var_pb_members_all_tab'][$cs_counter_members]) <> ''){
                                                        $shortcode .= 'var_pb_members_all_tab="'.htmlspecialchars($_POST['var_pb_members_all_tab'][$cs_counter_members]).'" ';
                                                    }
                                                    
                                                    if(isset($_POST['var_contact_fields'][$cs_counter_members]) && trim($_POST['var_contact_fields'][$cs_counter_members]) <> ''){
                                                        $shortcode .= 'var_contact_fields="'.htmlspecialchars($_POST['var_contact_fields'][$cs_counter_members]).'" ';
                                                    }
                                                    if(isset($_POST['var_pb_members_register_text'][$cs_counter_members]) && trim($_POST['var_pb_members_register_text'][$cs_counter_members]) <> ''){
                                                        $shortcode .= 'var_pb_members_register_text="'.htmlspecialchars($_POST['var_pb_members_register_text'][$cs_counter_members]).'" ';
                                                    }
                                                    if(isset($_POST['var_pb_members_register_url'][$cs_counter_members]) && trim($_POST['var_pb_members_register_url'][$cs_counter_members]) <> ''){
                                                        $shortcode .= 'var_pb_members_register_url="'.htmlspecialchars($_POST['var_pb_members_register_url'][$cs_counter_members]).'" ';
                                                    }
                                                    if(isset($_POST['var_pb_members_register_color'][$cs_counter_members]) && trim($_POST['var_pb_members_register_color'][$cs_counter_members]) <> ''){
                                                        $shortcode .= 'var_pb_members_register_color="'.htmlspecialchars($_POST['var_pb_members_register_color'][$cs_counter_members]).'" ';
                                                    }
                                                    if(isset($_POST['var_pb_members_description'][$cs_counter_members]) && trim($_POST['var_pb_members_description'][$cs_counter_members]) <> ''){
                                                        $shortcode .= 'var_pb_members_description="'.htmlspecialchars($_POST['var_pb_members_description'][$cs_counter_members]).'" ';
                                                    }
                                                    
                                                    if(isset($_POST['var_pb_members_pagination'][$cs_counter_members]) && trim($_POST['var_pb_members_pagination'][$cs_counter_members]) <> ''){
                                                        $shortcode .= 'var_pb_members_pagination="'.htmlspecialchars($_POST['var_pb_members_pagination'][$cs_counter_members]).'" ';
                                                    }
                                                    if(isset($_POST['var_pb_members_per_page'][$cs_counter_members]) && trim($_POST['var_pb_members_per_page'][$cs_counter_members]) <> ''){
                                                        $shortcode .= 'var_pb_members_per_page="'.htmlspecialchars($_POST['var_pb_members_per_page'][$cs_counter_members]).'" ';
                                                    }
                                                    if(isset($_POST['cs_members_class'][$cs_counter_members]) && $_POST['cs_members_class'][$cs_counter_members] != ''){
                                                        $shortcode .= 'cs_members_class="'.htmlspecialchars($_POST['cs_members_class'][$cs_counter_members], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['cs_members_animation'][$cs_counter_members]) && $_POST['cs_members_animation'][$cs_counter_members] != ''){
                                                        $shortcode .= 'cs_members_animation="'.htmlspecialchars($_POST['cs_members_animation'][$cs_counter_members]).'" ';
                                                    }
                                                    $shortcode .=  ']';
                                                    $members->addChild('cs_shortcode', $shortcode );
                                                    $cs_counter_members++;
                                                }
                                                $cs_global_counter_members++;
                                            }
                                      
                                            else if ( $_POST['cs_orderby'][$cs_counter] == "audio" ) {
                                                $shortcode = $shortcode_item = '';
                                                $section_title = '';
                                                $audio = $column->addChild('audio');
                                                 $audio->addChild('page_element_size', htmlspecialchars($_POST['audio_element_size'][$cs_global_counter_audio]) );
                                                if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
                                                    $shortcode_str = stripslashes ($_POST['shortcode']['audio'][$cs_shortcode_counter_audio]);
                                                    $cs_shortcode_counter_audio++;
                                                    $audio->addChild('cs_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES) );
                                                } else {
                                                    if(isset($_POST['album_num'][$cs_counter_audio]) && $_POST['album_num'][$cs_counter_audio]>0){
                                                        for ( $i = 1; $i <= $_POST['album_num'][$cs_counter_audio]; $i++ ){
                                                            
                                                            $shortcode_item .= '[album_item ';
                                                            if(isset($_POST['cs_album_track_title'][$cs_counter_audio_node]) && $_POST['cs_album_track_title'][$cs_counter_audio_node] != ''){
                                                                $shortcode_item .='cs_album_track_title="'.htmlspecialchars($_POST['cs_album_track_title'][$cs_counter_audio_node]).'" ';
                                                            }if(isset($_POST['cs_album_speaker'][$cs_counter_audio_node]) && $_POST['cs_album_speaker'][$cs_counter_audio_node] != ''){
                                                                $shortcode_item .='cs_album_speaker="'.htmlspecialchars($_POST['cs_album_speaker'][$cs_counter_audio_node]).'" ';
                                                            }
                                                            if(isset($_POST['cs_album_track_mp3_url'][$cs_counter_audio_node]) && $_POST['cs_album_track_mp3_url'][$cs_counter_audio_node] != ''){
                                                                $shortcode_item .='cs_album_track_mp3_url="'.htmlspecialchars($_POST['cs_album_track_mp3_url'][$cs_counter_audio_node]).'" ';
                                                            }
                                                            if(isset($_POST['cs_album_track_buy_mp3'][$cs_counter_audio_node]) && $_POST['cs_album_track_buy_mp3'][$cs_counter_audio_node] != ''){
                                                                $shortcode_item .= 'cs_album_track_buy_mp3="'.htmlspecialchars($_POST['cs_album_track_buy_mp3'][$cs_counter_audio_node]).'" ';
                                                            }
                                                            $shortcode_item .= ']';
                                                            $cs_counter_audio_node++;
                                                        }
                                                    }
                                                    if(isset($_POST['cs_audio_section_title'][$cs_counter_audio]) && $_POST['cs_audio_section_title'][$cs_counter_audio] != ''){
                                                        $section_title = 'cs_audio_section_title="'.htmlspecialchars($_POST['cs_audio_section_title'][$cs_counter_audio], ENT_QUOTES).'" ';
                                                    }
                                                    $shortcode = '[cs_album 
                                                      '.$section_title.' 
                                                     cs_audio_section_title="'.htmlspecialchars($_POST['cs_audio_section_title'][$cs_counter_audio], ENT_QUOTES).'"   cs_audio_class="'.htmlspecialchars($_POST['cs_audio_class'][$cs_counter_audio], ENT_QUOTES).'"   cs_audio_animation="'.htmlspecialchars($_POST['cs_audio_animation'][$cs_counter_audio]).'"  ]'.$shortcode_item.'[/cs_album]';
                                                    $audio->addChild('cs_shortcode', $shortcode );
                                                    $cs_counter_audio++;
                                                }
                                                $cs_global_counter_audio++;
                                            }
                                        else if ( $_POST['cs_orderby'][$cs_counter] == "map" ) {
                                                    $shortcode  =  '';
                                                     $map = $column->addChild('map');
                                                     $map->addChild('page_element_size', htmlspecialchars( $_POST['map_element_size'][$cs_global_counter_map] ));
                                                if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
                                                    $shortcode_str = stripslashes ($_POST['shortcode']['map'][$cs_shortcode_counter_map]);
                                                    $cs_shortcode_counter_map++;
                                                    $map->addChild('cs_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES) );
                                                } else {
                                                
													 $shortcode .= '['.CS_SC_MAP.' ';
                                                    if(isset($_POST['cs_map_section_title'][$cs_counter_map]) && $_POST['cs_map_section_title'][$cs_counter_map] != ''){
                                                        $shortcode .='cs_map_section_title="'.htmlspecialchars($_POST['cs_map_section_title'][$cs_counter_map]).'" ';
                                                    }
                                                    if(isset($_POST['map_title'][$cs_counter_map]) && $_POST['map_title'][$cs_counter_map] != ''){
                                                        $shortcode .= 'map_title="'.htmlspecialchars($_POST['map_title'][$cs_counter_map], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['map_height'][$cs_counter_map]) && $_POST['map_height'][$cs_counter_map] != ''){
                                                        $shortcode .='map_height="'.htmlspecialchars($_POST['map_height'][$cs_counter_map], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['map_lat'][$cs_counter_map]) && $_POST['map_lat'][$cs_counter_map] != ''){
                                                        $shortcode .= 'map_lat="'.htmlspecialchars($_POST['map_lat'][$cs_counter_map], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['map_lon'][$cs_counter_map]) && $_POST['map_lon'][$cs_counter_map] != ''){
                                                        $shortcode .= 'map_lon="'.htmlspecialchars($_POST['map_lon'][$cs_counter_map], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['map_zoom'][$cs_counter_map]) && $_POST['map_zoom'][$cs_counter_map] != ''){
                                                        $shortcode .='map_zoom="'.htmlspecialchars($_POST['map_zoom'][$cs_counter_map], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['map_type'][$cs_counter_map]) && $_POST['map_type'][$cs_counter_map] != ''){
                                                        $shortcode .='map_type="'.htmlspecialchars($_POST['map_type'][$cs_counter_map]).'" ';
                                                    }
                                                    if(isset($_POST['map_info'][$cs_counter_map]) && $_POST['map_info'][$cs_counter_map] != ''){
                                                        $shortcode .='map_info="'.htmlspecialchars($_POST['map_info'][$cs_counter_map], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['map_info_width'][$cs_counter_map]) && $_POST['map_info_width'][$cs_counter_map] != ''){
                                                        $shortcode .='map_info_width="'.htmlspecialchars($_POST['map_info_width'][$cs_counter_map]).'" ';
                                                    }
                                                    if(isset($_POST['map_info_height'][$cs_counter_map]) && $_POST['map_info_height'][$cs_counter_map] != ''){
                                                        $shortcode .='map_info_height="'.htmlspecialchars($_POST['map_info_height'][$cs_counter_map]).'" ';
                                                    }
                                                    if(isset($_POST['map_marker_icon'][$cs_counter_map]) && $_POST['map_marker_icon'][$cs_counter_map] != ''){
                                                        $shortcode .='map_marker_icon="'.htmlspecialchars($_POST['map_marker_icon'][$cs_counter_map]).'" ';
                                                    }
                                                    if(isset($_POST['map_show_marker'][$cs_counter_map]) && $_POST['map_show_marker'][$cs_counter_map] != ''){
                                                        $shortcode .='map_show_marker="'.htmlspecialchars($_POST['map_show_marker'][$cs_counter_map]).'" ';
                                                    }
                                                    if(isset($_POST['map_controls'][$cs_counter_map]) && $_POST['map_controls'][$cs_counter_map] != ''){
                                                        $shortcode .='map_controls="'.htmlspecialchars($_POST['map_controls'][$cs_counter_map]).'" ';
                                                    }
                                                    if(isset($_POST['map_draggable'][$cs_counter_map]) && $_POST['map_draggable'][$cs_counter_map] != ''){
                                                        $shortcode .='map_draggable="'.htmlspecialchars($_POST['map_draggable'][$cs_counter_map]).'" ';
                                                    }
                                                    if(isset($_POST['map_scrollwheel'][$cs_counter_map]) && $_POST['map_scrollwheel'][$cs_counter_map] != ''){
                                                        $shortcode .='map_scrollwheel="'.htmlspecialchars($_POST['map_scrollwheel'][$cs_counter_map]).'" ';
                                                    }
                                                    if(isset($_POST['map_view'][$cs_counter_map]) && $_POST['map_view'][$cs_counter_map] != ''){
                                                        $shortcode .='map_view="'.htmlspecialchars($_POST['map_view'][$cs_counter_map]).'" ';
                                                    }
                                                    if(isset($_POST['map_border'][$cs_counter_map]) && $_POST['map_border'][$cs_counter_map] != ''){
                                                        $shortcode .='map_border="'.htmlspecialchars($_POST['map_border'][$cs_counter_map]).'" ';
                                                    }
                                                    if(isset($_POST['map_border_color'][$cs_counter_map]) && $_POST['map_border_color'][$cs_counter_map] != ''){
                                                        $shortcode .='map_border_color="'.htmlspecialchars($_POST['map_border_color'][$cs_counter_map]).'" ';
                                                    }
                                                    if(isset($_POST['cs_map_style'][$cs_counter_map]) && $_POST['cs_map_style'][$cs_counter_map] != ''){
                                                        $shortcode .='cs_map_style="'.htmlspecialchars($_POST['cs_map_style'][$cs_counter_map]).'" ';
                                                    }
                                                    if(isset($_POST['map_conactus_content'][$cs_counter_map]) && $_POST['map_conactus_content'][$cs_counter_map] != ''){
                                                        $shortcode .='map_conactus_content="'.htmlspecialchars($_POST['map_conactus_content'][$cs_counter_map], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['map_border'][$cs_counter_map]) && $_POST['map_border'][$cs_counter_map] != ''){
                                                        $shortcode .='map_border="'.htmlspecialchars($_POST['map_border'][$cs_counter_map]).'" ';
                                                    }
                                                    if(isset($_POST['cs_map_class'][$cs_counter_map]) && $_POST['cs_map_class'][$cs_counter_map] != ''){
                                                        $shortcode .='cs_map_class="'.htmlspecialchars($_POST['cs_map_class'][$cs_counter_map], ENT_QUOTES).'" ';
                                                    }
                                                    if(isset($_POST['cs_map_animation'][$cs_counter_map]) && $_POST['cs_map_animation'][$cs_counter_map] != ''){
                                                        $shortcode .='cs_map_animation="'.htmlspecialchars($_POST['cs_map_animation'][$cs_counter_map]).'" ';
                                                    }
                                                    $shortcode .= ']';
                                                    $map->addChild('cs_shortcode', $shortcode );
                                                $cs_counter_map++;
                                                }
                                                $cs_global_counter_map++;
                                        }
                                        else if ( $_POST['cs_orderby'][$cs_counter] == "infobox" ) {
                                                    $shortcode = $shortcode_item = '';
                                                    $infobox   = $column->addChild('infobox');
                                                    $infobox->addChild('page_element_size', htmlspecialchars($_POST['infobox_element_size'][$cs_counter_infobox]) );
                                                    $infobox->addChild('infobox_element_size', htmlspecialchars($_POST['infobox_element_size'][$cs_counter_infobox]) );
                                                    if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
                                                        $shortcode_str = stripslashes ($_POST['shortcode']['infobox'][$cs_shortcode_counter_infobox]);
                                                        $cs_shortcode_counter_infobox++;
                                                        $infobox->addChild('cs_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES) );
                                                    } else {
                                                        if(isset($_POST['info_list_num'][$cs_counter_infobox]) && $_POST['info_list_num'][$cs_counter_infobox]>0){    
                                                            for ( $i = 1; $i <= $_POST['info_list_num'][$cs_counter_infobox]; $i++ ){
                                                                $shortcode_item .= '['.CS_SC_INFOBOXITEM.' ';
                                                                if(isset($_POST['cs_infobox_list_icon'][$cs_counter_infobox_node]) && $_POST['cs_infobox_list_icon'][$cs_counter_infobox_node] != ''){
                                                                    $shortcode_item .='cs_infobox_list_icon="'.htmlspecialchars($_POST['cs_infobox_list_icon'][$cs_counter_infobox_node]).'" ';
                                                                }
                                                                if(isset($_POST['cs_infobox_list_color'][$cs_counter_infobox_node]) && $_POST['cs_infobox_list_color'][$cs_counter_infobox_node] != ''){
                                                                    $shortcode_item .='cs_infobox_list_color="'.htmlspecialchars($_POST['cs_infobox_list_color'][$cs_counter_infobox_node]).'" ';
                                                                }
                                                                if(isset($_POST['cs_infobox_list_title'][$cs_counter_infobox_node]) && $_POST['cs_infobox_list_title'][$cs_counter_infobox_node] != ''){
                                                                    $shortcode_item .= 'cs_infobox_list_title="'.htmlspecialchars($_POST['cs_infobox_list_title'][$cs_counter_infobox_node], ENT_QUOTES).'" ';
                                                                }
                                                                $shortcode_item .= ']';
                                                                if(isset($_POST['cs_infobox_list_description'][$cs_counter_infobox_node]) && $_POST['cs_infobox_list_description'][$cs_counter_infobox_node] != ''){
                                                                    $shortcode_item .= htmlspecialchars($_POST['cs_infobox_list_description'][$cs_counter_infobox_node], ENT_QUOTES);
                                                                }
                                                                $shortcode_item .='[/'.CS_SC_INFOBOXITEM.']';
                                                                $cs_counter_infobox_node++;
                                                            }
                                                        }
                                                        $shortcode .= '['.CS_SC_INFOBOX.' ';
                                                        if(isset($_POST['cs_infobox_section_title'][$cs_counter_infobox]) && trim($_POST['cs_infobox_section_title'][$cs_counter_infobox]) <> ''){
                                                            $shortcode .= 'cs_infobox_section_title="'.htmlspecialchars($_POST['cs_infobox_section_title'][$cs_counter_infobox], ENT_QUOTES).'" ';
                                                        }
														
												 if(isset($_POST['cs_infobox_view_style'][$cs_counter_infobox]) && trim($_POST['cs_infobox_view_style'][$cs_counter_infobox]) <> ''){
													$shortcode .= 'cs_infobox_view_style="'.htmlspecialchars($_POST['cs_infobox_view_style'][$cs_counter_infobox], ENT_QUOTES).'" ';
												}
														
													 if(isset($_POST['cs_infobox_title'][$cs_counter_infobox]) && trim($_POST['cs_infobox_title'][$cs_counter_infobox]) <> ''){
                                                            $shortcode .= 'cs_infobox_title="'.htmlspecialchars($_POST['cs_infobox_title'][$cs_counter_infobox], ENT_QUOTES).'" ';
                                                        }
                                                        if(isset($_POST['cs_infobox_bg_color'][$cs_counter_infobox]) && trim($_POST['cs_infobox_bg_color'][$cs_counter_infobox]) <> ''){
                                                            $shortcode .= 'cs_infobox_bg_color="'.htmlspecialchars($_POST['cs_infobox_bg_color'][$cs_counter_infobox]).'" ';
                                                        }
                                                        
                                                        if(isset($_POST['cs_infobox_list_text_color'][$cs_counter_infobox]) && trim($_POST['cs_infobox_list_text_color'][$cs_counter_infobox]) <> ''){
                                                            $shortcode .= 'cs_infobox_list_text_color="'.htmlspecialchars($_POST['cs_infobox_list_text_color'][$cs_counter_infobox]).'" ';
                                                        }
                                                        if(isset($_POST['cs_infobox_class'][$cs_counter_infobox]) && trim($_POST['cs_infobox_class'][$cs_counter_infobox]) <> ''){
                                                            $shortcode .= 'cs_infobox_class="'.htmlspecialchars($_POST['cs_infobox_class'][$cs_counter_infobox], ENT_QUOTES).'" ';
                                                        }
                                                        if(isset($_POST['cs_infobox_animation'][$cs_counter_infobox]) && trim($_POST['cs_infobox_animation'][$cs_counter_infobox]) <> ''){
                                                            $shortcode .= 'cs_infobox_animation="'.htmlspecialchars($_POST['cs_infobox_animation'][$cs_counter_infobox]).'" ';
                                                        }
                                                        $shortcode .= ']'.$shortcode_item.'[/'.CS_SC_INFOBOX.']';
                                                        $infobox->addChild('cs_shortcode', $shortcode );
                                                        $cs_counter_infobox++;
                                                    }
                                                    $cs_global_counter_infobox++;
                                                    
                                        } 
                            
                                        else if ( $_POST['cs_orderby'][$cs_counter] == "image" ) {
                                                $shortcode  = '';
                                                
                                                $image = $column->addChild('image');
                                        $image->addChild('page_element_size', htmlspecialchars($_POST['image_element_size'][$cs_global_counter_image]) );
                                if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
                                     $shortcode_str = stripslashes ($_POST['shortcode']['image'][$cs_shortcode_counter_image]);
                                   $cs_shortcode_counter_image++;
                                      $image->addChild('cs_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES) );
                                     } else {
                                   
						 $shortcode .= '['.CS_SC_IMAGE.' ';
                             if(isset($_POST['cs_image_section_title'][$cs_counter_image]) && $_POST['cs_image_section_title'][$cs_counter_image] != ''){
                          $shortcode .='cs_image_section_title="'.htmlspecialchars($_POST['cs_image_section_title'][$cs_counter_image], ENT_QUOTES).'" ';
                                 }
                     if(isset($_POST['cs_image_url'][$cs_counter_image]) && $_POST['cs_image_url'][$cs_counter_image] != ''){
                      $shortcode .='cs_image_url="'.htmlspecialchars($_POST['cs_image_url'][$cs_counter_image], ENT_QUOTES).'" ';  }
                     if(isset($_POST['image_style'][$cs_counter_image]) && $_POST['image_style'][$cs_counter_image] != ''){
                       $shortcode .='image_style="'.htmlspecialchars($_POST['image_style'][$cs_counter_image]).'" '; }
                     if(isset($_POST['cs_image_title'][$cs_counter_image]) && $_POST['cs_image_title'][$cs_counter_image] != ''){
                     $shortcode .='cs_image_title="'.htmlspecialchars($_POST['cs_image_title'][$cs_counter_image], ENT_QUOTES).'" ';
                       }if(isset($_POST['cs_custom_class'][$cs_counter_image]) && $_POST['cs_custom_class'][$cs_counter_image] != ''){
                       $shortcode .= 'cs_custom_class="'.htmlspecialchars($_POST['cs_custom_class'][$cs_counter_image], ENT_QUOTES).'" ';
                       }if(isset($_POST['cs_custom_animation'][$cs_counter_image]) && $_POST['cs_custom_animation'][$cs_counter_image] != ''){
                       $shortcode .='cs_custom_animation="'.htmlspecialchars($_POST['cs_custom_animation'][$cs_counter_image]).'" ';
                         }
                         $shortcode .= ']';     
                         if(isset($_POST['cs_image_caption'][$cs_counter_image]) && $_POST['cs_image_caption'][$cs_counter_image] != ''){
                          $shortcode .=htmlspecialchars($_POST['cs_image_caption'][$cs_counter_image], ENT_QUOTES);
                          }       
						  $shortcode .=     '[/'.CS_SC_IMAGE.']';          
                                            
                           $image->addChild('cs_shortcode', $shortcode );
                             $cs_counter_image++;
                          }
                           $cs_global_counter_image++;
                           }
                                        // Loops Short Code Start
                                        // Blog
										
										else if ( $_POST['cs_orderby'][$cs_counter] == "blog" ) {
                                                    $shortcode = '';
                                                    $blog = $column->addChild('blog');
                                                    $blog->addChild('page_element_size', htmlspecialchars($_POST['blog_element_size'][$cs_global_counter_blog]) );
                                                    $blog->addChild('blog_element_size', htmlspecialchars($_POST['blog_element_size'][$cs_global_counter_blog]) );
                                                    if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
                                                        $shortcode_str = stripslashes ($_POST['shortcode']['blog'][$cs_shortcode_counter_blog]);
                                                        $cs_shortcode_counter_blog++;
                                                        $blog->addChild('cs_shortcode', htmlspecialchars($shortcode_str) );
                                                    } else {
                                                        $shortcode = '[cs_blog ';
                                                        if(isset($_POST['cs_blog_section_title'][$cs_counter_blog]) && $_POST['cs_blog_section_title'][$cs_counter_blog] != ''){
                                                            $shortcode .='cs_blog_section_title="'.htmlspecialchars($_POST['cs_blog_section_title'][$cs_counter_blog], ENT_QUOTES).'" ';
                                                        }
														
														 if(isset($_POST['cs_blog_sub_section_title'][$cs_counter_blog]) && $_POST['cs_blog_sub_section_title'][$cs_counter_blog] != ''){
                                                            $shortcode .='cs_blog_sub_section_title="'.htmlspecialchars($_POST['cs_blog_sub_section_title'][$cs_counter_blog], ENT_QUOTES).'" ';
                                                        }
														
                                                        if(isset($_POST['cs_blog_description'][$cs_counter_blog]) && $_POST['cs_blog_description'][$cs_counter_blog] != ''){
                                                            $shortcode .='cs_blog_description="'.htmlspecialchars($_POST['cs_blog_description'][$cs_counter_blog], ENT_QUOTES).'" ';
                                                        }if(isset($_POST['cs_blog_cat'][$cs_counter_blog]) && $_POST['cs_blog_cat'][$cs_counter_blog] != ''){
                                                            $shortcode .='cs_blog_cat="'.htmlspecialchars($_POST['cs_blog_cat'][$cs_counter_blog]).'" ';
                                                        }if(isset($_POST['cs_blog_view'][$cs_counter_blog]) && $_POST['cs_blog_view'][$cs_counter_blog] != ''){
                                                            $shortcode .='cs_blog_view="'.htmlspecialchars($_POST['cs_blog_view'][$cs_counter_blog]).'" ';
                                                        }if(isset($_POST['cs_blog_excerpt'][$cs_counter_blog]) && $_POST['cs_blog_excerpt'][$cs_counter_blog] != ''){
                                                            $shortcode .='cs_blog_excerpt="'.htmlspecialchars($_POST['cs_blog_excerpt'][$cs_counter_blog], ENT_QUOTES).'" ';
                                                        }if(isset($_POST['cs_blog_num_post'][$cs_counter_blog]) && $_POST['cs_blog_num_post'][$cs_counter_blog] != ''){
                                                            $shortcode .='cs_blog_num_post="'.htmlspecialchars($_POST['cs_blog_num_post'][$cs_counter_blog]).'" ';
                                                        }if(isset($_POST['cs_blog_num_tab'][$cs_counter_blog]) && $_POST['cs_blog_num_tab'][$cs_counter_blog] != ''){
                                                            $shortcode .='cs_blog_num_tab="'.htmlspecialchars($_POST['cs_blog_num_tab'][$cs_counter_blog]).'" ';
														}if(isset($_POST['cs_blog_orderby'][$cs_counter_blog]) && $_POST['cs_blog_orderby'][$cs_counter_blog] != ''){
                                                            $shortcode .='cs_blog_orderby="'.htmlspecialchars($_POST['cs_blog_orderby'][$cs_counter_blog]).'" ';
                                                        }if(isset($_POST['blog_pagination'][$cs_counter_blog]) && $_POST['blog_pagination'][$cs_counter_blog] != ''){
                                                            $shortcode .='blog_pagination="'.htmlspecialchars($_POST['blog_pagination'][$cs_counter_blog]).'" ';
                                                        }if(isset($_POST['cs_blog_class'][$cs_counter_blog]) && $_POST['cs_blog_class'][$cs_counter_blog] != ''){
                                                            $shortcode .='cs_blog_class="'.htmlspecialchars($_POST['cs_blog_class'][$cs_counter_blog], ENT_QUOTES).'" ';
                                                        }if(isset($_POST['cs_blog_animation'][$cs_counter_blog]) && $_POST['cs_blog_animation'][$cs_counter_blog] != ''){
                                                            $shortcode .='cs_blog_animation="'.htmlspecialchars($_POST['cs_blog_animation'][$cs_counter_blog]).'" ';
                                                        }
                                                        $shortcode .= ']';
                                                        $blog->addChild('cs_shortcode', $shortcode );
                                                        $cs_counter_blog++;
                                                    }
                                                $cs_global_counter_blog++;
                                        }
										
										
										/************************Gallery****************************/
										     else if ( $_POST['cs_orderby'][$cs_counter] == "gallery" ) {
                                                    $shortcode = '';
                                                    $gallery = $column->addChild('gallery');
                                                    $gallery->addChild('page_element_size', htmlspecialchars($_POST['gallery_element_size'][$cs_global_counter_gallery]) );
                                                    $gallery->addChild('gallery_element_size', htmlspecialchars($_POST['gallery_element_size'][$cs_global_counter_gallery]) );
                                                    if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
                                                        $shortcode_str = stripslashes ($_POST['shortcode']['gallery'][$cs_shortcode_counter_gallery]);
                                                        $cs_shortcode_counter_gallery++;
                                                        $gallery->addChild('cs_shortcode', htmlspecialchars($shortcode_str) );
                                                    } else {
                                                        $shortcode = '[cs_gallery ';
														
														if(isset($_POST['cs_gal_header_title'][$cs_counter_gallery]) && $_POST['cs_gal_header_title'][$cs_counter_gallery] != ''){
														$shortcode .='cs_gal_header_title="'.htmlspecialchars($_POST['cs_gal_header_title'][$cs_counter_gallery], ENT_QUOTES).'" ';
														}
														
														if(isset($_POST['cs_gal_layout'][$cs_counter_gallery]) && $_POST['cs_gal_layout'][$cs_counter_gallery] != ''){
														$shortcode .='cs_gal_layout="'.htmlspecialchars($_POST['cs_gal_layout'][$cs_counter_gallery], ENT_QUOTES).'" ';
														}
														
														if(isset($_POST['cs_gal_album'][$cs_counter_gallery]) && $_POST['cs_gal_album'][$cs_counter_gallery] != ''){
														$shortcode .='cs_gal_album="'.htmlspecialchars($_POST['cs_gal_album'][$cs_counter_gallery], ENT_QUOTES).'" ';
														}
														if(isset($_POST['cs_gal_desc'][$cs_counter_gallery]) && $_POST['cs_gal_desc'][$cs_counter_gallery] != ''){
														$shortcode .='cs_gal_desc="'.htmlspecialchars($_POST['cs_gal_desc'][$cs_counter_gallery]).'" ';
														}
														
														if(isset($_POST['cs_gal_pagination'][$cs_counter_gallery]) && $_POST['cs_gal_pagination'][$cs_counter_gallery] != ''){
														$shortcode .='cs_gal_pagination="'.htmlspecialchars($_POST['cs_gal_pagination'][$cs_counter_gallery]).'" ';
														
														}if(isset($_POST['cs_gal_media_per_page'][$cs_counter_gallery]) && $_POST['cs_gal_media_per_page'][$cs_counter_gallery] != ''){
														$shortcode .='cs_gal_media_per_page="'.htmlspecialchars($_POST['cs_gal_media_per_page'][$cs_counter_gallery], ENT_QUOTES).'" ';
														}
														$shortcode .= ']';
                                                        $gallery->addChild('cs_shortcode', $shortcode );
                                                        $cs_counter_gallery++;
                                                    }
                                                $cs_global_counter_gallery++;
                                        }
										/****************************Gallery********************************/
										
										
								/****************************Categories********************************/			
							else if ($_POST['cs_orderby'][$cs_counter] == "job_specialisms") {
                                $shortcode = '';
                                $job_specialisms = $column->addChild('job_specialisms');
                                $job_specialisms->addChild('job_specialisms_element_size', $_POST['job_specialisms_element_size'][$cs_global_counter_job_specialisms]);
                                $job_specialisms->addChild('page_element_size', $_POST['job_specialisms_element_size'][$cs_global_counter_job_specialisms]);
                                if (isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode') {
                                    $shortcode_str = stripslashes($_POST['shortcode']['job_specialisms'][$cs_shortcode_counter_job_specialisms]);
                                    $cs_shortcode_counter_job_specialisms++;
                                    $job_specialisms->addChild('cs_shortcode', htmlspecialchars($shortcode_str));
                                } else {
                                    $shortcode .= '[cs_job_specialisms ';
                                    if (isset($_POST['job_specialisms_title'][$cs_counter_job_specialisms]) && $_POST['job_specialisms_title'][$cs_counter_job_specialisms] != '') {
                                        $shortcode .= ' job_specialisms_title="' . htmlspecialchars($_POST['job_specialisms_title'][$cs_counter_job_specialisms], ENT_QUOTES) . '" ';
                                    }
									
									if (isset($_POST['cs_category_description'][$cs_counter_job_specialisms]) && $_POST['cs_category_description'][$cs_counter_job_specialisms] != '') {
                                        $shortcode .= ' cs_category_description="' . htmlspecialchars($_POST['cs_category_description'][$cs_counter_job_specialisms], ENT_QUOTES) . '" ';
                                    }
									

                                    if (isset($_POST['cs_spec_id'][$cs_counter_job_specialisms]) && $_POST['cs_spec_id'][$cs_counter_job_specialisms] != '') {
                                        $cs_spec_id = $_POST['cs_spec_id'][$cs_counter_job_specialisms];
                                        if (isset($_POST['spec_cats'][$cs_spec_id]) && $_POST['spec_cats'][$cs_spec_id] != '') {

                                            if (is_array($_POST['spec_cats'][$cs_spec_id])) {

                                                $shortcode .= ' spec_cats="' . implode(',', $_POST['spec_cats'][$cs_spec_id]) . '" ';
                                            }
                                        }
                                    }

                                    $shortcode .= ']';
                                    $shortcode .= '[/cs_job_specialisms]';

                                    $job_specialisms->addChild('cs_shortcode', $shortcode);
                                    $cs_counter_job_specialisms++;
                                }
                                $cs_global_counter_job_specialisms++;
                            }
									  // Directory
                                        else if ( $_POST['cs_orderby'][$cs_counter] == "directory" ) {
                                            $shortcode = '';
                                                    $directory = $column->addChild('directory');
                                                    $directory->addChild('page_element_size', htmlspecialchars($_POST['directory_element_size'][$cs_global_counter_directory]) );
                                                    $directory->addChild('directory_element_size', htmlspecialchars($_POST['directory_element_size'][$cs_global_counter_directory]) );
                                                    if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
                                                        $shortcode_str = stripslashes ($_POST['shortcode']['directory'][$cs_shortcode_counter_directory]);
                                                        $cs_shortcode_counter_directory++;
                                                        $directory->addChild('cs_shortcode', htmlspecialchars($shortcode_str) );
                                                    } else {
                                                        
                                                        if (empty($_POST['cs_switch_views'][$cs_counter_directory])){
                                                             $cs_switch_view = "";
                                                        } else {
                                                            $cs_switch_view = implode(",", $_POST['cs_switch_views']);
                                                        }
                                                        $shortcode = '[cs_directory ';
                                                        if(isset($_POST['directory_title'][$cs_counter_directory]) && $_POST['directory_title'][$cs_counter_directory] != ''){
                                                            $shortcode .='directory_title="'.htmlspecialchars($_POST['directory_title'][$cs_counter_directory], ENT_QUOTES).'" ';
                                                        }
                                                        if(isset($_POST['directory_cat'][$cs_counter_directory]) && $_POST['directory_cat'][$cs_counter_directory] != ''){
                                                            $shortcode .='directory_cat="'.htmlspecialchars($_POST['directory_cat'][$cs_counter_directory]).'" ';
                                                        }
                                                        if(isset($_POST['cs_directory_fields_count'][$cs_counter_directory]) && $_POST['cs_directory_fields_count'][$cs_counter_directory] != ''){
                                                            $shortcode .='cs_directory_fields_count="'.htmlspecialchars($_POST['cs_directory_fields_count'][$cs_counter_directory]).'" ';
                                                        }                                                        
                                                        if(isset($_POST['cs_directory_header'][$cs_counter_directory]) && $_POST['cs_directory_header'][$cs_counter_directory] != ''){
                                                            $shortcode .= 'cs_directory_header="'.htmlspecialchars($_POST['cs_directory_header'][$cs_counter_directory]).'" ';
                                                        }
														if(isset($_POST['cs_directory_map_style'][$cs_counter_directory]) && $_POST['cs_directory_map_style'][$cs_counter_directory] != ''){
                                                            $shortcode .= 'cs_directory_map_style="'.htmlspecialchars($_POST['cs_directory_map_style'][$cs_counter_directory]).'" ';
                                                        }if(isset($_POST['cs_directory_rev_slider'][$cs_counter_directory]) && $_POST['cs_directory_rev_slider'][$cs_counter_directory] != ''){
                                                            $shortcode .= 'cs_directory_rev_slider="'.htmlspecialchars($_POST['cs_directory_rev_slider'][$cs_counter_directory]).'" ';
                                                        }if(isset($_POST['cs_directory_banner'][$cs_counter_directory]) && $_POST['cs_directory_banner'][$cs_counter_directory] != ''){
                                                            $shortcode .= 'cs_directory_banner="'.htmlspecialchars($_POST['cs_directory_banner'][$cs_counter_directory]).'" ';
                                                        }if(isset($_POST['cs_directory_adsense'][$cs_counter_directory]) && $_POST['cs_directory_adsense'][$cs_counter_directory] != ''){
                                                            $shortcode .='cs_directory_adsense="'.htmlspecialchars(stripslashes($_POST['cs_directory_adsense'][$cs_counter_directory]), ENT_QUOTES).'" ';
                                                        }if(isset($_POST['cs_subheader_bg_color'][$cs_counter_directory]) && $_POST['cs_subheader_bg_color'][$cs_counter_directory] != ''){
                                                            $shortcode .= 'cs_subheader_bg_color="'.htmlspecialchars($_POST['cs_subheader_bg_color'][$cs_counter_directory]).'" ';
                                                        }if(isset($_POST['cs_subheader_padding_top'][$cs_counter_directory]) && $_POST['cs_subheader_padding_top'][$cs_counter_directory] != ''){
                                                            $shortcode .= 'cs_subheader_padding_top="'.htmlspecialchars($_POST['cs_subheader_padding_top'][$cs_counter_directory]).'" ';
                                                        }if(isset($_POST['cs_subheader_padding_bottom'][$cs_counter_directory]) && $_POST['cs_subheader_padding_bottom'][$cs_counter_directory] != ''){
                                                            $shortcode .= 'cs_subheader_padding_bottom="'.htmlspecialchars($_POST['cs_subheader_padding_bottom'][$cs_counter_directory]).'" ';
                                                        }if(isset($_POST['directory_view'][$cs_counter_directory]) && $_POST['directory_view'][$cs_counter_directory] != ''){
                                                            $shortcode .= 'directory_view="'.htmlspecialchars($_POST['directory_view'][$cs_counter_directory]).'" ';
                                                        }if(isset($_POST['directory_type'][$cs_counter_directory]) && $_POST['directory_type'][$cs_counter_directory] != ''){
                                                            $shortcode .='directory_type="'.htmlspecialchars($_POST['directory_type'][$cs_counter_directory]).'" ';
                                                        }if(isset($_POST['cs_directory_filter'][$cs_counter_directory]) && $_POST['cs_directory_filter'][$cs_counter_directory] != ''){
                                                            $shortcode .='cs_directory_filter="'.htmlspecialchars($_POST['cs_directory_filter'][$cs_counter_directory]).'" ';
                                                        }if(isset($_POST['cs_featured_on_top'][$cs_counter_directory]) && $_POST['cs_featured_on_top'][$cs_counter_directory] != ''){
                                                            $shortcode .='cs_featured_on_top="'.htmlspecialchars($_POST['cs_featured_on_top'][$cs_counter_directory]).'" ';
                                                        }if(isset($_POST['cs_listing_sorting'][$cs_counter_directory]) && $_POST['cs_listing_sorting'][$cs_counter_directory] != ''){
                                                            $shortcode .='cs_listing_sorting="'.htmlspecialchars($_POST['cs_listing_sorting'][$cs_counter_directory]).'" ';
                                                        }if(isset($_POST['directory_pagination'][$cs_counter_directory]) && $_POST['directory_pagination'][$cs_counter_directory] != ''){
                                                            $shortcode .='directory_pagination="'.htmlspecialchars($_POST['directory_pagination'][$cs_counter_directory]).'" ';
                                                        }if(isset($_POST['directory_per_page'][$cs_counter_directory]) && $_POST['directory_per_page'][$cs_counter_directory] != ''){
                                                            $shortcode .='directory_per_page="'.htmlspecialchars($_POST['directory_per_page'][$cs_counter_directory]).'" ';
                                                        }if(isset($_POST['cs_directory_filterable'][$cs_counter_directory]) && $_POST['cs_directory_filterable'][$cs_counter_directory] != ''){
                                                            $shortcode .='cs_directory_filterable="'.htmlspecialchars($_POST['cs_directory_filterable'][$cs_counter_directory]).'" ';
                                                        }if(isset($_POST['cs_directory_sortable'][$cs_counter_directory]) && $_POST['cs_directory_sortable'][$cs_counter_directory] != ''){
                                                            $shortcode .='cs_directory_sortable="'.htmlspecialchars($_POST['cs_directory_sortable'][$cs_counter_directory]).'" ';
                                                        }if(isset($_POST['cs_switch_views'][$cs_counter_directory]) && $_POST['cs_switch_views'][$cs_counter_directory] != ''){
                                                            $shortcode .= 'cs_switch_views="'.htmlspecialchars($cs_switch_view).'" ';
                                                        }
                                                        $shortcode .= ']';
                                                        $directory->addChild('cs_shortcode', $shortcode );
                                                        $cs_counter_directory++;
                                                    }
                                                $cs_global_counter_directory++;
                                        
                                        }
                                        // Directory Search
                                    
                                        
                                        // Directory Map
                                        else if ( $_POST['cs_orderby'][$cs_counter] == "directory_map" ) {
                                            $shortcode = '';
                                                    $directory_map = $column->addChild('directory_map');
                                                    $directory_map->addChild('page_element_size', htmlspecialchars($_POST['directory_map_element_size'][$cs_global_counter_directory_map]) );
                                                    $directory_map->addChild('directory_map_element_size', htmlspecialchars($_POST['directory_map_element_size'][$cs_global_counter_directory_map]) );
                                                    if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
                                                        $shortcode_str = stripslashes ($_POST['shortcode']['directory_map'][$cs_shortcode_counter_directory_map]);
                                                        $cs_shortcode_counter_directory_map++;
                                                        $directory_map->addChild('cs_shortcode', htmlspecialchars($shortcode_str) );
                                                    } else {
                                                        $shortcode = '[cs_directory_map ';
                                                        if(isset($_POST['directory_map_title'][$cs_counter_directory_map]) && $_POST['directory_map_title'][$cs_counter_directory_map] != ''){
                                                            $shortcode .='directory_map_title="'.htmlspecialchars($_POST['directory_map_title'][$cs_counter_directory_map], ENT_QUOTES).'" ';
                                                        }
                                                        
                                                        if(isset($_POST['cs_directory_map_style'][$cs_counter_directory_map]) && $_POST['cs_directory_map_style'][$cs_counter_directory_map] != ''){
                                                            $shortcode .='cs_directory_map_style="'.htmlspecialchars($_POST['cs_directory_map_style'][$cs_counter_directory_map], ENT_QUOTES).'" ';
                                                        }
                                                        
                                                        if(isset($_POST['cs_directory_map_views'][$cs_counter_directory_map]) && $_POST['cs_directory_map_views'][$cs_counter_directory_map] != ''){
                                                            $shortcode .='cs_directory_map_views="'.htmlspecialchars($_POST['cs_directory_map_views'][$cs_counter_directory_map], ENT_QUOTES).'" ';
                                                        }
                                                        
                                                        if(isset($_POST['cs_directory_map_filter'][$cs_counter_directory_map]) && $_POST['cs_directory_map_filter'][$cs_counter_directory_map] != ''){
                                                            $shortcode .='cs_directory_map_filter="'.htmlspecialchars($_POST['cs_directory_map_filter'][$cs_counter_directory_map], ENT_QUOTES).'" ';
                                                        }
                                                        
                                                        if(isset($_POST['cs_directory_map'][$cs_counter_directory_map]) && $_POST['cs_directory_map'][$cs_counter_directory_map] != ''){
                                                            $shortcode .='cs_directory_map="'.htmlspecialchars($_POST['cs_directory_map'][$cs_counter_directory_map], ENT_QUOTES).'" ';
                                                        }
                                                        
                                                        if(isset($_POST['directory_map_results_per_page'][$cs_counter_directory_map]) && $_POST['directory_map_results_per_page'][$cs_counter_directory_map] != ''){
                                                            $shortcode .='directory_map_results_per_page="'.htmlspecialchars($_POST['directory_map_results_per_page'][$cs_counter_directory_map], ENT_QUOTES).'" ';
                                                        }
                                                        
                                                        if(isset($_POST['cs_directory_map_class'][$cs_counter_directory_map]) && $_POST['cs_directory_map_class'][$cs_counter_directory_map] != ''){
                                                            $shortcode .='cs_directory_map_class="'.htmlspecialchars($_POST['cs_directory_map_class'][$cs_counter_directory_map], ENT_QUOTES).'" ';
                                                        }if(isset($_POST['cs_directory_map_animation'][$cs_counter_directory_map]) && $_POST['cs_directory_map_animation'][$cs_counter_directory_map] != ''){
                                                            $shortcode .='cs_directory_map_animation="'.htmlspecialchars($_POST['cs_directory_map_animation'][$cs_counter_directory_map]).'" ';
                                                        }
                                                        $shortcode .= ']';
                                                        $directory_map->addChild('cs_shortcode', $shortcode );
                                                        $cs_counter_directory_map++;
                                                    }
                                                $cs_global_counter_directory_map++;
                                        }
                                        // Save directory categories page element 
                                        else if ( $_POST['cs_orderby'][$cs_counter] == "directory_categories" ) {
                                            $shortcode = '';
                                            $directory_categories = $column->addChild('directory_categories');
                                            $directory_categories->addChild('page_element_size', htmlspecialchars($_POST['directory_categories_element_size'][$cs_global_counter_directory_categories]) );
                                            $directory_categories->addChild('directory_categories_element_size', htmlspecialchars($_POST['directory_categories_element_size'][$cs_global_counter_directory_categories]) );
                                            if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
                                                $shortcode_str = stripslashes ($_POST['shortcode']['directory_categories'][$cs_shortcode_counter_directory_categories]);
                                                $cs_shortcode_counter_directory_categories++;
                                                $directory_categories->addChild('cs_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES) );
                                            } else {
                                                $shortcode = '[cs_directory_categories ';
                                                if(isset($_POST['cs_directory_categories_title'][$cs_counter_directory_categories]) && $_POST['cs_directory_categories_title'][$cs_counter_directory_categories] != ''){
                                                    $shortcode .= 'cs_directory_categories_title="'.htmlspecialchars($_POST['cs_directory_categories_title'][$cs_counter_directory_categories]).'" ';
                                                }
                                                if(isset($_POST['cs_directory_categories_view'][$cs_counter_directory_categories]) && $_POST['cs_directory_categories_view'][$cs_counter_directory_categories] != ''){
                                                    $shortcode .='cs_directory_categories_view="'.htmlspecialchars($_POST['cs_directory_categories_view'][$cs_counter_directory_categories]).'" ';
                                                }
                                                if(isset($_POST['cs_directory_categories_page'][$cs_counter_directory_categories]) && $_POST['cs_directory_categories_page'][$cs_counter_directory_categories] != ''){
                                                    $shortcode .='cs_directory_categories_page="'.htmlspecialchars($_POST['cs_directory_categories_page'][$cs_counter_directory_categories]).'" ';
                                                }
                                                if(isset($_POST['cs_directory_categories_bg_color'][$cs_counter_directory_categories]) && $_POST['cs_directory_categories_bg_color'][$cs_counter_directory_categories] != ''){
                                                    $shortcode .='cs_directory_categories_bg_color="'.htmlspecialchars($_POST['cs_directory_categories_bg_color'][$cs_counter_directory_categories]).'" ';
                                                }
                                                if(isset($_POST['cs_directory_categories_txt_color'][$cs_counter_directory_categories]) && $_POST['cs_directory_categories_txt_color'][$cs_counter_directory_categories] != ''){
                                                    $shortcode .= 'cs_directory_categories_txt_color="'.htmlspecialchars($_POST['cs_directory_categories_txt_color'][$cs_counter_directory_categories]).'" ';
                                                }
                                                if (isset($_POST['cs_directory_categories_counter'][$cs_counter_directory_categories])){
                                                     $cs_directory_categories_counter = htmlspecialchars($_POST['cs_directory_categories_counter'][$cs_counter_directory_categories]);
                                                }
                                                if (empty($_POST['cs_directory_categories_cats'][$cs_directory_categories_counter])){
                                                     $cs_directory_categories_cats = "";
                                                } else {
                                                    $cs_directory_categories_cats = implode(",", $_POST['cs_directory_categories_cats'][$cs_directory_categories_counter]);
                                                }
                                                if(isset($cs_directory_categories_cats) && trim($cs_directory_categories_cats) <> ''){
                                                    $shortcode .='cs_directory_categories_cats="'.htmlspecialchars($cs_directory_categories_cats).'" ';
                                                }
												if(isset($_POST['cs_directory_categories_order'][$cs_counter_directory_categories]) && $_POST['cs_directory_categories_order'][$cs_counter_directory_categories] != ''){
                                                    $shortcode .='cs_directory_categories_order="'.htmlspecialchars($_POST['cs_directory_categories_order'][$cs_counter_directory_categories]).'" ';
                                                }
                                                if(isset($_POST['cs_directory_categories_number'][$cs_counter_directory_categories]) && $_POST['cs_directory_categories_number'][$cs_counter_directory_categories] != ''){
                                                    $shortcode .='cs_directory_categories_number="'.htmlspecialchars($_POST['cs_directory_categories_number'][$cs_counter_directory_categories]).'" ';
                                                }
                                                if(isset($_POST['cs_custom_class'][$cs_counter_directory_categories]) && $_POST['cs_custom_class'][$cs_counter_directory_categories] != ''){
                                                    $shortcode .='cs_custom_class="'.htmlspecialchars($_POST['cs_custom_class'][$cs_counter_directory_categories], ENT_QUOTES).'" ';
                                                }
                                                if(isset($_POST['cs_custom_animation'][$cs_counter_directory_categories]) && $_POST['cs_custom_animation'][$cs_counter_directory_categories] != ''){
                                                    $shortcode .='cs_custom_animation="'.htmlspecialchars($_POST['cs_custom_animation'][$cs_counter_directory_categories]).'" ';
                                                }
                                                $shortcode .='[/cs_directory_categories]';
                                                $directory_categories->addChild('cs_shortcode', $shortcode );
                                                $cs_counter_directory_categories++;
                                            }    
                                            $cs_global_counter_directory_categories++;
                                        }
                                        
                                        // Clients
                                        else if ( $_POST['cs_orderby'][$cs_counter] == "clients" ) {
                                                    $shortcode = $shortcode_item = '';
                                                    $clients = $column->addChild('clients');
                                                    $clients->addChild('page_element_size', htmlspecialchars($_POST['clients_element_size'][$cs_global_counter_clients]) );
                                                    $clients->addChild('clients_element_size', htmlspecialchars($_POST['clients_element_size'][$cs_shortcode_counter_clients]) );
                                                    if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
                                                        $shortcode_str = stripslashes ($_POST['shortcode']['clients'][$cs_shortcode_counter_clients]);
                                                        $cs_shortcode_counter_clients++;
                                                        $clients->addChild('cs_shortcode', htmlspecialchars($shortcode_str) );
                                                    } else {
                                                        if(isset($_POST['clients_num'][$cs_counter_clients]) && $_POST['clients_num'][$cs_counter_clients]>0){
                                                            for ( $i = 1; $i <= $_POST['clients_num'][$cs_counter_clients]; $i++ ){
                                                                $clients_item = $clients->addChild('clients_item');                                                    
                                                                $shortcode_item .= '['.CS_SC_CLIENTSITEM.' ';
                                                                if(isset($_POST['cs_bg_color'][$cs_counter_clients_node])  && $_POST['cs_bg_color'][$cs_counter_clients_node] != ''){
                                                                    $shortcode_item .='cs_bg_color="'.htmlspecialchars($_POST['cs_bg_color'][$cs_counter_clients_node]).'" ';
                                                                }    
                                                                if(isset($_POST['cs_website_url'][$cs_counter_clients_node])  && $_POST['cs_website_url'][$cs_counter_clients_node] != ''){
                                                                    $shortcode_item .='cs_website_url="'.htmlspecialchars($_POST['cs_website_url'][$cs_counter_clients_node]).'" ';
                                                                }
                                                                if(isset($_POST['cs_client_title'][$cs_counter_clients_node])  && $_POST['cs_client_title'][$cs_counter_clients_node] != ''){
                                                                    $shortcode_item .='cs_client_title="'.htmlspecialchars($_POST['cs_client_title'][$cs_counter_clients_node], ENT_QUOTES).'" ';
                                                                }
                                                                if(isset($_POST['cs_client_logo'][$cs_counter_clients_node])  && $_POST['cs_client_logo'][$cs_counter_clients_node] != ''){
                                                                    $shortcode_item .='cs_client_logo="'.htmlspecialchars($_POST['cs_client_logo'][$cs_counter_clients_node]).'" ';
                                                                }    
                                                                $shortcode_item .= ']';
                                                                $cs_counter_clients_node++;
                                                            }
                                                        }
                                                    $section_title = '';
                                                    if(isset($_POST['cs_client_section_title'][$cs_counter_clients])  && $_POST['cs_client_section_title'][$cs_counter_clients] != ''){
                                                        $section_title ='cs_client_section_title="'.htmlspecialchars($_POST['cs_client_section_title'][$cs_counter_clients], ENT_QUOTES).'" ';
                                                    }
                                                    $shortcode = '['.CS_SC_CLIENTS.' ';
                                                    if(isset($_POST['cs_clients_view'][$cs_counter_clients])  && $_POST['cs_clients_view'][$cs_counter_clients] != ''){
                                                        $shortcode .='cs_clients_view="'.htmlspecialchars($_POST['cs_clients_view'][$cs_counter_clients]).'" ';
                                                    }
                                                    if(isset($_POST['cs_client_section_title'][$cs_counter_clients])  && $_POST['cs_client_section_title'][$cs_counter_clients] != ''){
                                                        $shortcode .='cs_client_section_title="'.htmlspecialchars($_POST['cs_client_section_title'][$cs_counter_clients]).'" ';
                                                    }
                                                    if(isset($_POST['cs_client_border'][$cs_counter_clients])  && $_POST['cs_client_border'][$cs_counter_clients] != ''){
                                                        $shortcode .='cs_client_border="'.htmlspecialchars($_POST['cs_client_border'][$cs_counter_clients]).'" ';
                                                    }
                                                    if(isset($_POST['cs_client_gray'][$cs_counter_clients])  && $_POST['cs_client_gray'][$cs_counter_clients] != ''){
                                                        $shortcode .='cs_client_gray="'.htmlspecialchars($_POST['cs_client_gray'][$cs_counter_clients]).'" ';
                                                    }        
                                                    if(isset($_POST['cs_client_class'][$cs_counter_clients])  && $_POST['cs_client_class'][$cs_counter_clients] != ''){
                                                        $shortcode .='cs_client_class="'.htmlspecialchars($_POST['cs_client_class'][$cs_counter_clients], ENT_QUOTES).'" ';
                                                    }        
                                                    if(isset($_POST['cs_client_animation'][$cs_counter_clients])  && $_POST['cs_client_animation'][$cs_counter_clients] != ''){
                                                        $shortcode .='cs_client_animation="'.htmlspecialchars($_POST['cs_client_animation'][$cs_counter_clients]).'" ';
                                                    }
                                                    $shortcode .= ']'.$shortcode_item.'[/'.CS_SC_CLIENTS.']';        
                                                    $clients->addChild('cs_shortcode', $shortcode );
                                                    $cs_counter_clients++;
                                                }
                                            $cs_global_counter_clients++;        
                                        }
										// Multiple services
                                        else if ( $_POST['cs_orderby'][$cs_counter] == "multiple_services" ) {
                                                    $shortcode = $shortcode_item = '';
                                                    $multiple_services = $column->addChild('multiple_services');
                                                    $multiple_services->addChild('page_element_size', htmlspecialchars($_POST['multiple_services_element_size'][$cs_global_counter_multiple_services]) );
                                                    $multiple_services->addChild('multiple_services_element_size', htmlspecialchars($_POST['multiple_services_element_size'][$cs_shortcode_counter_multiple_services]) );
                                                    if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
                                                        $shortcode_str = stripslashes ($_POST['shortcode']['multiple_services'][$cs_shortcode_counter_multiple_services]);
                                                        $cs_shortcode_counter_multiple_services++;
                                                        $multiple_services->addChild('cs_shortcode', htmlspecialchars($shortcode_str) );
                                                    } else {
                                                        if(isset($_POST['multiple_services_num'][$cs_counter_multiple_services]) && $_POST['multiple_services_num'][$cs_counter_multiple_services]>0){
                                                            for ( $i = 1; $i <= $_POST['multiple_services_num'][$cs_counter_multiple_services]; $i++ ){
                                                                $multiple_services_item = $multiple_services->addChild('multiple_services_item');                                                    
                                                                $shortcode_item .= '['.CS_SC_MULTPLESERVICESITEM.' ';
                                                                if(isset($_POST['cs_title_color'][$cs_counter_multiple_services_node])  && $_POST['cs_title_color'][$cs_counter_multiple_services_node] != ''){
                                                                    $shortcode_item .='cs_title_color="'.htmlspecialchars($_POST['cs_title_color'][$cs_counter_multiple_services_node]).'" ';
                                                                } 
																if(isset($_POST['cs_text_color'][$cs_counter_multiple_services_node])  && $_POST['cs_text_color'][$cs_counter_multiple_services_node] != ''){
                                                                    $shortcode_item .='cs_text_color="'.htmlspecialchars($_POST['cs_text_color'][$cs_counter_multiple_services_node]).'" ';
                                                                } 
																if(isset($_POST['cs_bg_color'][$cs_counter_multiple_services_node])  && $_POST['cs_bg_color'][$cs_counter_multiple_services_node] != ''){
                                                                    $shortcode_item .='cs_bg_color="'.htmlspecialchars($_POST['cs_bg_color'][$cs_counter_multiple_services_node]).'" ';
                                                                }    
                                                                if(isset($_POST['cs_website_url'][$cs_counter_multiple_services_node])  && $_POST['cs_website_url'][$cs_counter_multiple_services_node] != ''){
                                                                    $shortcode_item .='cs_website_url="'.htmlspecialchars($_POST['cs_website_url'][$cs_counter_multiple_services_node]).'" ';
                                                                }
                                                                if(isset($_POST['cs_multiple_service_title'][$cs_counter_multiple_services_node])  && $_POST['cs_multiple_service_title'][$cs_counter_multiple_services_node] != ''){
                                                                    $shortcode_item .='cs_multiple_service_title="'.htmlspecialchars($_POST['cs_multiple_service_title'][$cs_counter_multiple_services_node], ENT_QUOTES).'" ';
                                                                }
                                                                if(isset($_POST['cs_multiple_service_logo'][$cs_counter_multiple_services_node])  && $_POST['cs_multiple_service_logo'][$cs_counter_multiple_services_node] != ''){
                                                                    $shortcode_item .='cs_multiple_service_logo="'.htmlspecialchars($_POST['cs_multiple_service_logo'][$cs_counter_multiple_services_node]).'" ';
                                                                }
																 
																
                                                                $shortcode_item .= ']';
																if(isset($_POST['cs_multiple_service_text'][$cs_counter_multiple_services_node]) && $_POST['cs_multiple_service_text'][$cs_counter_multiple_services_node] != ''){
                                                                    $shortcode_item .= htmlspecialchars($_POST['cs_multiple_service_text'][$cs_counter_multiple_services_node], ENT_QUOTES);
                                                                }
                                                                $shortcode_item .=     '[/'.CS_SC_MULTPLESERVICESITEM.']'; 
                                                                $cs_counter_multiple_services_node++;
                                                            }
                                                        }
                                                    $section_title = '';
                                                    
													
													
                                                    $shortcode = '['.CS_SC_MULTPLESERVICES.' ';
                                                    $shortcode .= 'column_size="1/1" ';
							
                                             
												    if(isset($_POST['cs_multiple_services_view'][$cs_counter_multiple_services])  && $_POST['cs_multiple_services_view'][$cs_counter_multiple_services] != ''){
                                                        $shortcode .='cs_multiple_services_view="'.htmlspecialchars($_POST['cs_multiple_services_view'][$cs_counter_multiple_services]).'"  ';
                                                    }
													
													if(isset($_POST['cs_multiple_service_section_title'][$cs_counter_multiple_services])  && $_POST['cs_multiple_service_section_title'][$cs_counter_multiple_services] != ''){
                                                        $shortcode .='cs_multiple_service_section_title="'.htmlspecialchars($_POST['cs_multiple_service_section_title'][$cs_counter_multiple_services]).'" ';
                                                    }
													
													if(isset($_POST['multiple_services_element_size'][$cs_counter_multiple_services])  && $_POST['multiple_services_element_size'][$cs_counter_multiple_services] != ''){
                                                        $shortcode .='multiple_services_element_size="'.htmlspecialchars($_POST['multiple_services_element_size'][$cs_counter_multiple_services]).'" ';
                                                    }
     $shortcode .= ']'.$shortcode_item.'[/'.CS_SC_MULTPLESERVICES.']';        
                                                    $multiple_services->addChild('cs_shortcode', $shortcode );
                                                    $cs_counter_multiple_services++;
                                                }
                                            $cs_global_counter_multiple_services++;        
                                        }
										else if ( $_POST['cs_orderby'][$cs_counter] == "facilities" ) {
                                                    $shortcode = $shortcode_item = '';
                                                    $facilities = $column->addChild('facilities');
                                                    $facilities->addChild('page_element_size', htmlspecialchars($_POST['facilities_element_size'][$cs_global_counter_facilities]) );
                                                    $facilities->addChild('facilities_element_size', htmlspecialchars($_POST['facilities_element_size'][$cs_shortcode_counter_facilities]) );
                                                    if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
                                                        $shortcode_str = stripslashes ($_POST['shortcode']['facilities'][$cs_shortcode_counter_facilities]);
                                                        $cs_shortcode_counter_facilities++;
                                                        $facilities->addChild('cs_shortcode', htmlspecialchars($shortcode_str) );
                                                    } else {
                                                        if(isset($_POST['facilities_num'][$cs_counter_facilities]) && $_POST['facilities_num'][$cs_counter_facilities]>0){
                                                            for ( $i = 1; $i <= $_POST['facilities_num'][$cs_counter_facilities]; $i++ ){
                                                                $facilities_item = $facilities->addChild('facilities_item');                                                    
                                                                $shortcode_item .= '['.CS_SC_FACILITIESITEM.' ';
                                                                if(isset($_POST['title'][$cs_counter_facilities_node])  && $_POST['title'][$cs_counter_facilities_node] != ''){
                                                                    $shortcode_item .='title="'.htmlspecialchars($_POST['title'][$cs_counter_facilities_node], ENT_QUOTES).'" ';
                                                                }
																if(isset($_POST['title_color'][$cs_counter_facilities_node])  && $_POST['title_color'][$cs_counter_facilities_node] != ''){
                                                                    $shortcode_item .='title_color="'.htmlspecialchars($_POST['title_color'][$cs_counter_facilities_node]).'" ';
                                                                } 
																if(isset($_POST['text_color'][$cs_counter_facilities_node])  && $_POST['text_color'][$cs_counter_facilities_node] != ''){
                                                                    $shortcode_item .='text_color="'.htmlspecialchars($_POST['text_color'][$cs_counter_facilities_node]).'" ';
                                                                } 
																
                                                                
                                                                if(isset($_POST['image'][$cs_counter_facilities_node])  && $_POST['image'][$cs_counter_facilities_node] != ''){
                                                                    $shortcode_item .='image="'.htmlspecialchars($_POST['image'][$cs_counter_facilities_node]).'" ';
                                                                }
																
																if(isset($_POST['facilities_text'][$cs_counter_facilities_node])  && $_POST['facilities_text'][$cs_counter_facilities_node] != ''){
                                                                    $shortcode_item .='facilities_text="'.htmlspecialchars($_POST['facilities_text'][$cs_counter_facilities_node]).'" ';
                                                                }
																
                                                                $shortcode_item .= ']';
																if(isset($_POST['cs_multiple_service_text'][$cs_counter_facilities_node]) && $_POST['cs_multiple_service_text'][$cs_counter_facilities_node] != ''){
                                                                    $shortcode_item .= htmlspecialchars($_POST['cs_multiple_service_text'][$cs_counter_facilities_node], ENT_QUOTES);
                                                                }
                                                                $shortcode_item .=     '[/'.CS_SC_FACILITIESITEM.']'; 
                                                                $cs_counter_facilities_node++;
                                                            }
                                                        }
                                                    $section_title = '';
                                                    
													
													
                                                    $shortcode = '['.CS_SC_FACILITIES.' ';
                                                    $shortcode .= 'column_size="1/1" ';
							
                                             
													if(isset($_POST['cs_section_title'][$cs_counter_facilities])  && $_POST['cs_section_title'][$cs_counter_facilities] != ''){
                                                        $shortcode .='cs_section_title="'.htmlspecialchars($_POST['cs_section_title'][$cs_counter_facilities]).'" ';
                                                    }
													
													if(isset($_POST['facilities_element_size'][$cs_counter_facilities])  && $_POST['facilities_element_size'][$cs_counter_facilities] != ''){
                                                        $shortcode .='facilities_element_size="'.htmlspecialchars($_POST['facilities_element_size'][$cs_counter_facilities]).'" ';
                                                    }
     $shortcode .= ']'.$shortcode_item.'[/'.CS_SC_FACILITIES.']';        
                                                    $facilities->addChild('cs_shortcode', $shortcode );
                                                    $cs_counter_facilities++;
                                                }
                                            $cs_global_counter_facilities++;        
                                        }
										else if ( $_POST['cs_orderby'][$cs_counter] == "events" ) {
													$shortcode = '';
													$event = $column->addChild('events');
													$event->addChild('page_element_size', htmlspecialchars($_POST['events_element_size'][$cs_global_counter_events]) );
													$event->addChild('events_element_size', htmlspecialchars($_POST['events_element_size'][$cs_global_counter_events]) );
													if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
														$shortcode_str = stripslashes($_POST['shortcode']['events'][$cs_shortcode_counter_events]);
														$cs_shortcode_counter_events++;
														$event->addChild('cs_shortcode', htmlspecialchars($shortcode_str) );
													} else {
														$shortcode = '[cs_events ';
														if(isset($_POST['section_title'][$cs_counter_events]) && $_POST['section_title'][$cs_counter_events] != ''){
															$shortcode .= 	'section_title="'.htmlspecialchars($_POST['section_title'][$cs_counter_events], ENT_QUOTES).'" ';
														}
														if(isset($_POST['category'][$cs_counter_events]) && $_POST['category'][$cs_counter_events] != ''){
															$shortcode .= 	'category="'.htmlspecialchars($_POST['category'][$cs_counter_events]).'" ';
														}
														
														if(isset($_POST['view'][$cs_counter_events]) && $_POST['view'][$cs_counter_events] != ''){
															$shortcode .= 	'view="'.htmlspecialchars($_POST['view'][$cs_counter_events]).'" ';
														}
														
														if(isset($_POST['event_excerpt'][$cs_counter_events]) && $_POST['event_excerpt'][$cs_counter_events] != ''){
															$shortcode .= 	'event_excerpt="'.htmlspecialchars($_POST['event_excerpt'][$cs_counter_events], ENT_QUOTES).'" ';
														}
														
														if(isset($_POST['pagination'][$cs_counter_events]) && $_POST['pagination'][$cs_counter_events] != ''){
															$shortcode .= 	'pagination="'.htmlspecialchars($_POST['pagination'][$cs_counter_events]).'" ';
														}
														
														if(isset($_POST['event_type'][$cs_counter_events]) && $_POST['event_type'][$cs_counter_events] != ''){
															$shortcode .= 	'event_type="'.htmlspecialchars($_POST['event_type'][$cs_counter_events]).'" ';
														}
														
														if(isset($_POST['post_order'][$cs_counter_events]) && $_POST['post_order'][$cs_counter_events] != ''){
															$shortcode .= 	'post_order="'.htmlspecialchars($_POST['post_order'][$cs_counter_events]).'" ';
														}
														if(isset($_POST['events_time'][$cs_counter_events]) && $_POST['events_time'][$cs_counter_events] != ''){
															$shortcode .= 	'events_time="'.htmlspecialchars($_POST['events_time'][$cs_counter_events]).'" ';
														}
														
														if(isset($_POST['display_pagination'][$cs_counter_events]) && $_POST['display_pagination'][$cs_counter_events] != ''){
															$shortcode .= 	'display_pagination="'.htmlspecialchars($_POST['display_pagination'][$cs_counter_events]).'" ';
														}
														
														if(isset($_POST['classes'][$cs_counter_events]) && $_POST['classes'][$cs_counter_events] != ''){
															$shortcode .= 	'classes="'.htmlspecialchars($_POST['classes'][$cs_counter_events], ENT_QUOTES).'" ';
														}
														if(isset($_POST['filterable'][$cs_counter_events]) && $_POST['filterable'][$cs_counter_events] != ''){
															$shortcode .= 	'filterable="'.htmlspecialchars($_POST['filterable'][$cs_counter_events], ENT_QUOTES).'" ';
														}
														$shortcode .= 	']';
														
														$event->addChild('cs_shortcode', $shortcode );
														$cs_counter_events++;
													}
												$cs_global_counter_events++;
										}
									/*****************course*************************/	
										else if ( $_POST['cs_orderby'][$cs_counter] == "course" ) {
													$shortcode = '';
													$course = $column->addChild('course');
													$course->addChild('page_element_size', htmlspecialchars($_POST['course_element_size'][$cs_global_counter_course]) );
													$course->addChild('course_element_size', htmlspecialchars($_POST['course_element_size'][$cs_global_counter_course]) );
													if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
														$shortcode_str = stripslashes($_POST['shortcode']['course'][$cs_shortcode_counter_course]);
														$cs_shortcode_counter_course++;
														$course->addChild('cs_shortcode', htmlspecialchars($shortcode_str) );
													} else { 
														$shortcode = '[cs_course ';
														if(isset($_POST['section_title'][$cs_counter_course]) && $_POST['section_title'][$cs_counter_course] != ''){
															$shortcode .= 	'section_title="'.htmlspecialchars($_POST['section_title'][$cs_counter_course], ENT_QUOTES).'" ';
														}
														if(isset($_POST['category'][$cs_counter_course]) && $_POST['category'][$cs_counter_course] != ''){
															$shortcode .= 	'category="'.htmlspecialchars($_POST['category'][$cs_counter_course]).'" ';
														}
														
														if(isset($_POST['view'][$cs_counter_course]) && $_POST['view'][$cs_counter_course] != ''){
															$shortcode .= 	'view="'.htmlspecialchars($_POST['view'][$cs_counter_course]).'" ';
														}
														
														if(isset($_POST['course_excerpt'][$cs_counter_course]) && $_POST['course_excerpt'][$cs_counter_course] != ''){
															$shortcode .= 	'course_excerpt="'.htmlspecialchars($_POST['course_excerpt'][$cs_counter_course], ENT_QUOTES).'" ';
														}
														
														if(isset($_POST['pagination'][$cs_counter_course]) && $_POST['pagination'][$cs_counter_course] != ''){
															$shortcode .= 	'pagination="'.htmlspecialchars($_POST['pagination'][$cs_counter_course]).'" ';
														}
														
														if(isset($_POST['post_order'][$cs_counter_course]) && $_POST['post_order'][$cs_counter_course] != ''){
															$shortcode .= 	'post_order="'.htmlspecialchars($_POST['post_order'][$cs_counter_course]).'" ';
														}
														if(isset($_POST['display_pagination'][$cs_counter_course]) && $_POST['display_pagination'][$cs_counter_course] != ''){
															$shortcode .= 	'display_pagination="'.htmlspecialchars($_POST['display_pagination'][$cs_counter_course]).'" ';
														}
														if(isset($_POST['classes'][$cs_counter_course]) && $_POST['classes'][$cs_counter_course] != ''){
															$shortcode .= 	'classes="'.htmlspecialchars($_POST['classes'][$cs_counter_course], ENT_QUOTES).'" ';
														}
														if(isset($_POST['filterable'][$cs_counter_course]) && $_POST['filterable'][$cs_counter_course] != ''){
															$shortcode .= 	'filterable="'.htmlspecialchars($_POST['filterable'][$cs_counter_course], ENT_QUOTES).'" ';
														}
														$shortcode .= 	']';
														
														$course->addChild('cs_shortcode', $shortcode );
														$cs_counter_course++;
													}
												$cs_global_counter_course++;
										}
										/*****************course*************************/
										
										else if ( $_POST['cs_orderby'][$cs_counter] == "rooms" ) {
													$shortcode = '';
													$room = $column->addChild('rooms');
													$room->addChild('page_element_size', htmlspecialchars($_POST['rooms_element_size'][$cs_global_counter_rooms]) );
													$room->addChild('rooms_element_size', htmlspecialchars($_POST['rooms_element_size'][$cs_global_counter_rooms]) );
													if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
														$shortcode_str = stripslashes ($_POST['shortcode']['rooms'][$cs_shortcode_counter_rooms]);
														$cs_shortcode_counter_rooms++;
														$room->addChild('cs_shortcode', htmlspecialchars($shortcode_str) );
													} else {
														$shortcode = '[cs_rooms ';
														if(isset($_POST['section_title'][$cs_counter_rooms]) && $_POST['section_title'][$cs_counter_rooms] != ''){
															$shortcode .= 	'section_title="'.htmlspecialchars($_POST['section_title'][$cs_counter_rooms], ENT_QUOTES).'" ';
														}
														if(isset($_POST['room_type'][$cs_counter_rooms]) && $_POST['room_type'][$cs_counter_rooms] != ''){
															$shortcode .= 	'room_type="'.htmlspecialchars($_POST['room_type'][$cs_counter_rooms]).'" ';
														}if(isset($_POST['view'][$cs_counter_rooms]) && $_POST['view'][$cs_counter_rooms] != ''){
															$shortcode .= 	'view="'.htmlspecialchars($_POST['view'][$cs_counter_rooms]).'" ';
														}if(isset($_POST['excerpt'][$cs_counter_rooms]) && $_POST['excerpt'][$cs_counter_rooms] != ''){
															$shortcode .= 	'excerpt="'.htmlspecialchars($_POST['excerpt'][$cs_counter_rooms], ENT_QUOTES).'" ';
														}if(isset($_POST['pagination'][$cs_counter_rooms]) && $_POST['pagination'][$cs_counter_rooms] != ''){
															$shortcode .= 	'pagination="'.htmlspecialchars($_POST['pagination'][$cs_counter_rooms]).'" ';
														}if(isset($_POST['rooms_pagination'][$cs_counter_rooms]) && $_POST['rooms_pagination'][$cs_counter_rooms] != ''){
															$shortcode .= 	'rooms_pagination="'.htmlspecialchars($_POST['rooms_pagination'][$cs_counter_rooms]).'" ';
														}if(isset($_POST['order'][$cs_counter_rooms]) && $_POST['order'][$cs_counter_rooms] != ''){
															$shortcode .= 	'order="'.htmlspecialchars($_POST['order'][$cs_counter_rooms]).'" ';
														}if(isset($_POST['filterable'][$cs_counter_rooms]) && $_POST['filterable'][$cs_counter_rooms] != ''){
															$shortcode .= 	'filterable="'.htmlspecialchars($_POST['filterable'][$cs_counter_rooms], ENT_QUOTES).'" ';
														}
														$shortcode .= 	']';
														$room->addChild('cs_shortcode', $shortcode );
														$cs_counter_rooms++;
													}
												$cs_global_counter_rooms++;
										}
                                        // Save Twitter page element 
                                        else if ( $_POST['cs_orderby'][$cs_counter] == "tweets" ) {
											$shortcode = '';
											$tweet = $column->addChild('tweets');
											$tweet->addChild('page_element_size', htmlspecialchars($_POST['tweets_element_size'][$cs_global_counter_tweets]));
											$tweet->addChild('tweets_element_size', htmlspecialchars($_POST['tweets_element_size'][$cs_global_counter_tweets]));
											if(isset($_POST['cs_widget_element_num'][$cs_counter]) && $_POST['cs_widget_element_num'][$cs_counter] == 'shortcode'){
												$shortcode_str = stripslashes ($_POST['shortcode']['tweets'][$cs_shortcode_counter_tweets]);
												$cs_shortcode_counter_tooltip++;
												$tweet->addChild('cs_shortcode', htmlspecialchars($shortcode_str, ENT_QUOTES) );
											} else {
												$shortcode = '['.CS_SC_TWEETS.' ';
												
												if(isset($_POST['cs_tweets_user_name'][$cs_counter_tweets]) && $_POST['cs_tweets_user_name'][$cs_counter_tweets] != ''){
													$shortcode .='cs_tweets_user_name="'.htmlspecialchars($_POST['cs_tweets_user_name'][$cs_counter_tweets]).'" ';
												}
												if(isset($_POST['cs_tweets_color'][$cs_counter_tweets]) && $_POST['cs_tweets_color'][$cs_counter_tweets] != ''){
													$shortcode .='cs_tweets_color="'.htmlspecialchars($_POST['cs_tweets_color'][$cs_counter_tweets]).'" ';
												}
												if(isset($_POST['cs_tweets_bg_color'][$cs_counter_tweets]) && $_POST['cs_tweets_bg_color'][$cs_counter_tweets] != ''){
													$shortcode .='cs_tweets_bg_color="'.htmlspecialchars($_POST['cs_tweets_bg_color'][$cs_counter_tweets]).'" ';
												}
												
												if(isset($_POST['cs_no_of_tweets'][$cs_counter_tweets]) && $_POST['cs_no_of_tweets'][$cs_counter_tweets] != ''){
													$shortcode .='cs_no_of_tweets="'.htmlspecialchars($_POST['cs_no_of_tweets'][$cs_counter_tweets]).'" ';
												}
												if(isset($_POST['cs_tweets_class'][$cs_counter_tweets]) && $_POST['cs_tweets_class'][$cs_counter_tweets] != ''){
													$shortcode .='cs_tweets_class="'.htmlspecialchars($_POST['cs_tweets_class'][$cs_counter_tweets], ENT_QUOTES).'" ';
												}
												if(isset($_POST['cs_tweets_animation'][$cs_counter_tweets]) && $_POST['cs_tweets_animation'][$cs_counter_tweets] != ''){
													$shortcode .='cs_tweets_animation="'.htmlspecialchars($_POST['cs_tweets_animation'][$cs_counter_tweets]).'" ';
												}
												$shortcode .=']';
												$tweet->addChild('cs_shortcode', $shortcode );
												$cs_counter_tweets++;
											}
											$cs_global_counter_tweets++;
                                        }
                                     //===Loops Short Code End
									$cs_counter++;
                                }
                                $widget_no++;
                            }
                            $column_container_no++;
                        }
					}
				
				update_post_meta( $post_id, 'cs_page_builder', $sxe->asXML() );
				
            }
        }
    }
?>