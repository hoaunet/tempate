<?php
/*
 *
 * @Shortcode Name : Contact us
 * @retrun
 *
 */
if (!function_exists('cs_contactus_shortcode')) {

    function cs_contactus_shortcode($atts, $content = "") {
		global $post;
        $defaults = array(
            'column_size' => '1/1',
            'cs_contactus_section_title' => '',
            'cs_contactus_label' => '',
            'cs_contactus_view' => '',
            'cs_contactus_send' => '',
            'cs_success' => '',
            'cs_error' => '',
            'cs_contact_class' => ''
        );
        extract(shortcode_atts($defaults, $atts));
        $column_class = cs_custom_column_class($column_size);
        $cs_email_counter = rand(3242343, 324324990);
        $html = '';
        $class = '';
        $section_title = '';
        if ($cs_contactus_section_title && trim($cs_contactus_section_title) != '') {
            $section_title = '<div class="cs-section-title">
							   <h4>' . esc_html($cs_contactus_section_title) . '</h4>
							  </div>';
        }

        if (trim($cs_success) && trim($cs_success) != '') {
            $success = $cs_success;
        } else {
            $success =__('Email has been sent Successfully','uoc');
        }

        if (trim($cs_error) && trim($cs_error) != '') {
            $error = $cs_error;
        } else {
            $error =__('An error Occured, please try again later','uoc');
        }

        if (trim($cs_contactus_view) == 'plain') {
            $view_class = 'cs-plan';
        } else {
            $view_class = '';
        }
        ?>
        <script type="text/javascript">
            function cs_contact_frm_submit(form_id) {
                var cs_mail_id = '<?php echo esc_js($cs_email_counter); ?>';
                if (form_id == cs_mail_id) {
                    var $ = jQuery;
                    $("#loading_div<?php echo esc_js($cs_email_counter); ?>").html('<img src="<?php echo esc_js(esc_url(get_template_directory_uri())); ?>/assets/images/ajax-loader.gif" alt="<?php echo cs_get_post_img_title($post->ID); ?>" />');
                    $("#loading_div<?php echo esc_js($cs_email_counter); ?>").show();
                    $("#message<?php echo esc_js($cs_email_counter); ?>").html('');
                    var datastring = $('#frm<?php echo esc_js($cs_email_counter); ?>').serialize() + "&cs_contact_email=<?php echo esc_js($cs_contactus_send); ?>&cs_contact_succ_msg=<?php echo esc_js($success); ?>&cs_contact_error_msg=<?php echo esc_js($error); ?>&action=cs_contact_form_submit";
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo esc_js(esc_url(admin_url('admin-ajax.php'))); ?>',
                        data: datastring,
                        dataType: "json",
                        success: function (response) {

                            if (response.type == 'error') {
                                $("#loading_div<?php echo esc_js($cs_email_counter); ?>").html('');
                                $("#loading_div<?php echo esc_js($cs_email_counter); ?>").hide();
                                $("#message<?php echo esc_js($cs_email_counter); ?>").addClass('error_mess');
                                $("#message<?php echo esc_js($cs_email_counter); ?>").show();
                                $("#message<?php echo esc_js($cs_email_counter) ?>").html(response.message);
                            }
                            else if (response.type == 'success') {
                                $("#frm<?php echo esc_js($cs_email_counter); ?>").slideUp();
                                $("#loading_div<?php echo esc_js($cs_email_counter); ?>").html('');
                                $("#loading_div<?php echo esc_js($cs_email_counter); ?>").hide();
                                $("#message<?php echo esc_js($cs_email_counter); ?>").addClass('succ_mess');
                                $("#message<?php echo esc_js($cs_email_counter) ?>").show();
                                $("#message<?php echo esc_js($cs_email_counter); ?>").html(response.message);
                            }

                        }
                    }
                    );
                }
            }
        </script>

        <?php
        
			$html .='<div class="cs-plain-form cs_form_styling col-md-12">
												<div class="form-style">
													<h4>' . __('Quick Inquiry', 'uoc') . '</h4>';
							$html .= '<form  name="frm' . absint($cs_email_counter) . '" id="frm' . absint($cs_email_counter) . '" action="javascript:cs_contact_frm_submit(' . absint($cs_email_counter) . ')"  class="comment-form">';
												$html .= '<label>
															<i class="icon-book8"></i>
															<input type="text" name="contact_name" placeholder="Enter Name" required >
															
														</label>
														<label>
															<i class="icon-mortar-board"></i>
																<input type="text" name="contact_email" placeholder="' . __('Email Address', 'uoc') . '"   required>
														</label>
														<label>
															<i class="icon-globe4"></i>
															<input type="text" name="subject" placeholder="' . __('Subject', 'uoc') . '"  required> 
														</label>
														<label class="textaera-sec">
															<textarea placeholder="' . __('Enter Message', 'uoc') . '"  id="comment_mes" name="contact_msg"  rows="4" cols="39"></textarea>  														</label>
														<label class="form-submit">
														  <input type="submit" name="submit" value="Submit">
														</label>
													</form>';
											$html .= '<div id="loading_div' . $cs_email_counter . '"></div>';
											$html .= '<div id="message' . $cs_email_counter . '"  style="display:none;"></div>';		
									$html .= '</div>
											</div>';
				$cs_contact_class_id = '';
					if ($cs_contact_class <> '') {
						$cs_contact_class_id = ' id="' . $cs_contact_class . '"';
					}
				
				return '<div class="' . $column_class . '"' . $cs_contact_class_id . '>' . $section_title . $html . '</div>';
	 }

    if (function_exists('cs_short_code')) cs_short_code(CS_SC_CONTACTUS, 'cs_contactus_shortcode');
}