<?php
/*
 *
 * @Shortcode Name : Quick Quote
 * @retrun
 *
 */
if (!function_exists('cs_quick_quote_shortcode')) {

    function cs_quick_quote_shortcode($atts, $content = "") {
        $defaults = array(
            'cs_quick_quote_section_title' => '',
            'cs_quick_quote_view' => '',
            'cs_quick_quote_send' => '',
            'cs_success' => '',
            'cs_error' => '',
        );
        extract(shortcode_atts($defaults, $atts));
        $cs_email_counter = rand(132423143, 324324990);
        $cs_html = '';
        $section_title = '';
		
        if ($cs_quick_quote_section_title && trim($cs_quick_quote_section_title) != '') {
            $cs_html .= '
			<div class="cs-section-title col-md-12">
				<h4>' . esc_html($cs_quick_quote_section_title) . '</h4>
			</div>';
        }
		
		
		

        if (trim($cs_success) && trim($cs_success) != '') {
            $success = $cs_success;
        } else {
            $success = __('Email has been sent Successfully','uoc');
        }

        if (trim($cs_error) && trim($cs_error) != '') {
            $error = $cs_error;
        } else {
            $error = __('An error Occured, please try again later','uoc');
        }
		
		$first_elem_class = 'element-size-67';
		$secnd_elem_class = 'element-size-100';

		if ( $cs_quick_quote_view == 'classic' ) {
			$first_elem_class = 'element-size-50';
			$secnd_elem_class = 'element-size-50';
		}
		cs_fr_datepickr();
		?>
        <script type="text/javascript">
			function frm_submit<?php echo esc_js($cs_email_counter);?>(){
				
				var $ = jQuery;
				$("#loading_div<?php echo esc_js($cs_email_counter);?>").html('<i class="icon-refresh icon-spin"></i>');
				$("#loading_div<?php echo esc_js($cs_email_counter);?>").show();
				$("#message<?php echo esc_js($cs_email_counter);?>").html('');
				var datastring =$('#frm<?php echo esc_js($cs_email_counter);?>').serialize() +"&cs_quote_email=<?php echo esc_js($cs_quick_quote_send);?>&cs_quote_succ_msg=<?php echo esc_js($success);?>&cs_quote_error_msg=<?php echo esc_js($error);?>&action=cs_quote_form_submit";

				$.ajax({
					type:'POST', 
					url: '<?php echo esc_js(esc_url(admin_url('admin-ajax.php')));?>',
					data: datastring, 
					dataType: "json",
					success: function(response) {
						
						if (response.type == 'error'){
							$("#loading_div<?php echo esc_js($cs_email_counter);?>").html('');
							$("#loading_div<?php echo esc_js($cs_email_counter);?>").hide();
							$("#message<?php echo esc_js($cs_email_counter);?>").addClass('error_mess');
							$("#message<?php echo esc_js($cs_email_counter);?>").show();
							$("#message<?php echo esc_js($cs_email_counter)?>").html(response.message);
						} else if (response.type == 'success'){
							$("#frm<?php echo esc_js($cs_email_counter);?>").slideUp();
							$("#loading_div<?php echo esc_js($cs_email_counter);?>").html('');
							$("#loading_div<?php echo esc_js($cs_email_counter);?>").hide();
							$("#message<?php echo esc_js($cs_email_counter);?>").addClass('succ_mess');
							$("#message<?php echo esc_js($cs_email_counter)?>").show();
							$("#message<?php echo esc_js($cs_email_counter);?>").html(response.message);
						}
						
					}
				});
			}
			
			jQuery(document).ready(function($) {
				jQuery('.cs-calendar-combo input').datepicker();
			});
			jQuery(document).ready(function($) {
				jQuery('.cs-calendar-combo input').datepicker();
			});
			
			jQuery(document).ready(function($) {
				jQuery('#datetimepicker2').datetimepicker({
					datepicker:false,
					format:'H:i'
				});
			});	
        </script>
        <?php

        $cs_html .= '
		<div class="cs-quote-form" id="quote_form'.absint($cs_email_counter).'">
			<form id="frm'.absint($cs_email_counter).'" name="frm'.absint($cs_email_counter).'" method="post" action="javascript:frm_submit'.absint($cs_email_counter).'(\''.admin_url("admin-ajax.php").'\');">
				<fieldset>
					<div class="'.sanitize_html_class($first_elem_class).'">
						<div class="col-md-12">
							<div class="fields-area">
								<div class="field-col col-md-12">
									<label>'.__('Name', 'uoc').'</label>
									<input name="quote_name" type="text" placeholder="'.__('Enter Your Name', 'uoc').'" required="required">
								</div>
							</div>
							<div class="fields-area">
								<div class="field-col col-md-6">
									<label>'.__('Email', 'uoc').'</label>
									<input name="quote_mail" placeholder="'.__('Enter email', 'uoc').'" type="email" required="required">
								</div>
								<div class="field-col col-md-6">
									<label>'.__('Mobile Number', 'uoc').' <span>('.__('Optional', 'uoc').')</span></label>
									<input name="quote_number" type="text" placeholder="'.__('Enter Mobile Number', 'uoc').'">
								</div>
							</div>
							<div class="fields-area">
								<div class="field-col col-md-6">
									<label>'.__('Service Type', 'uoc').'</label>
									<input name="quote_service" type="text" placeholder="'.__('Enter Service Type', 'uoc').'" required="required">
								</div>
								<div class="field-col col-md-6">
									<label>'.__('Number of Workers', 'uoc').' <span>('.__('Optional', 'uoc').')</span></label>
									<div class="select-holder">
										<select name="quote_workers">';
											for( $p_num = 1; $p_num <= 50; $p_num++ ) {
												$cs_html .= '<option>'.absint($p_num).'</option>';
											}
										$cs_html .= '
										</select>
									</div>
								</div>
							</div>
							<div class="fields-area">
								<div class="field-col col-md-6 date">
									<div class="date">
									<label>'.__('Date', 'uoc').'</label>
										<label class="cs-calendar-combo" id="Deadline">
										<input name="quote_date" type="text" value="DD/MM/YYYY">
										</label>
									</div>
								</div>
								<div class="field-col col-md-6">
									<label>'.__('Time', 'uoc').'</label>
									<div class="time">
										<input name="quote_time" placeholder="'.__('HH:ii','uoc').'" id="datetimepicker2" type="text" required="required">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="'.sanitize_html_class($secnd_elem_class).'">
						<div class="col-md-12">
							<div class="fields-area">
								<div class="field-col col-md-12">
									<label>'.__('Enter Address', 'uoc').'</label>
									<input name="quote_address" placeholder="'.__('Enter Address','uoc').'" type="text">
								</div>
							</div>
							<div class="fields-area">
								<div class="field-col col-md-12">
									<label>'.__('Message', 'uoc').' <span>('.__('Optional', 'uoc').')</span></label>
									<textarea name="quote_message" placeholder="'.__('Enter Message', 'uoc').'"></textarea>
								</div>
							</div>
							<div class="fields-area">
								<div class="field-col col-md-12">
								<input type="submit" class="cs-bgcolor" value="'.__('Get Quick Quote', 'uoc').'" id="submit_btn'.absint($cs_email_counter).'">
									<span class="note">'.do_shortcode(nl2br($content)).'</span>
								</div>
							</div>
						</div>
					</div>
				</fieldset>
			</form>
			<div id="loading_div'.absint($cs_email_counter).'"></div>
			<div id="message'.absint($cs_email_counter).'" style="display:none;"></div>
		</div>';
        
        return do_shortcode($cs_html);
    }

    if (function_exists('cs_short_code')) cs_short_code(CS_SC_QUICK_QUOTE, 'cs_quick_quote_shortcode');
}