<?php
/** 
 * @Spacer html form for page builder
 */
if (!function_exists('cs_spacer_shortcode')) {
	function cs_spacer_shortcode($atts, $content = "") {
		global $cs_border;
	 
		$defaults = array('cs_spacer_height'=>'25');
		extract( shortcode_atts( $defaults, $atts ) );
		
		$cs_spacer_height	= $cs_spacer_height? $cs_spacer_height : '15';
		if(isset($cs_spacer_height) and !empty($cs_spacer_height)){
		return '<div class="col-md-12" style="height:'.do_shortcode($cs_spacer_height).'px">
		</div>';
		}
	}
	if (function_exists('cs_short_code')) cs_short_code(CS_SC_SPACER, 'cs_spacer_shortcode');
}