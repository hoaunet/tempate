<?php
/*
 *
 *@Shortcode Name : Price Table
 *@retrun
 *
 */

if (!function_exists('cs_pricetable_shortcode')) {
    function cs_pricetable_shortcode($atts, $content = "") {
        global $pricetable_style;
		
        $defaults = array(
		'column_size'=>'1/1',
		'pricetable_style'=>'simple',
		'pricetable_title'=>'',
		'pricetable_title_bgcolor'=>'',
		'pricetable_price'=>'',
		'currency_symbols'=>'$',
		'pricetable_period'=>'',
		'pricetable_bgcolor'=>'',
		'btn_text'=>'Buy Now',
		'btn_link'=>'',
		'btn_bg_color'=>'',
		'pricetable_featured'=>'',
		'pricetable_class'=>''
		
		);
        extract( shortcode_atts( $defaults, $atts ) );
        $column_class  = cs_custom_column_class($column_size);
        $CustomId    = '';
		$currency_symbols = isset($currency_symbols) ? $currency_symbols : '';
		$pricetable_price = isset($pricetable_price) ? $pricetable_price : '';
		$pricetable_title = isset($pricetable_title) ? $pricetable_title : '';
		$pricetable_period = isset($pricetable_period) ? $pricetable_period : '';
		$pricetable_bgcolor = isset($pricetable_bgcolor) ? $pricetable_bgcolor : '';
		$btn_link = isset($btn_link) ? $btn_link : '';
		$pricetable_title_bgcolor = isset($pricetable_title_bgcolor) ? $pricetable_title_bgcolor : '';
		$btn_bg_color = isset($btn_bg_color) ? $btn_bg_color : '';
		
		$btn_text = isset($btn_text) ? $btn_text : '';
		$html='';
		$html .= '<div class="pricing-area text-center">';
        $html .= '<div class="row">';
		$html .= '<div class="'.$column_class.' plan price-one">';
        $html .= '<ul>';
		$html .= '<li class="heading-one" style="background:'.$pricetable_bgcolor.' !important;">';
		$html .= '<h1 style="color:'.$pricetable_title_bgcolor.' !important">'.esc_html($pricetable_title).'</h1>';
		$html .= '<div class="pricing-box-spliter"></div>';
		$html .= '<div class="price-big">';
		$html .= '<div>'.$currency_symbols.'</div>';
		$html .= '<div>'.$pricetable_price.'</div>';
		$html .= '<div>'.$pricetable_period.'</div>';
		$html .= '</div>';
		$html .= '<div class="price-button">';
		$html .='<button onclick="location.href=\''.esc_url($btn_link).'\'" class="upgrate"  style="background:'.$btn_bg_color.'">'.$btn_text.'  </button>';
	 
		$html .= '</div>';
	 	$html .= '</li>';
		$html .= do_shortcode($content);
		$html .= '</ul>';
		$html .= '</div>';
		$html .= '</div>';
	    $html .= '</div>';
	 return '<div '.$CustomId.' class="'.$column_class.'">'.$html.'</div>';
    }
    if (function_exists('cs_short_code')) cs_short_code(CS_SC_PRICETABLE, 'cs_pricetable_shortcode');
}

/*
 *
 *@Price Table Item
 *@retrun
 *
 */
if (!function_exists('cs_pricing_item')) {
    function cs_pricing_item($atts, $content = "") {
        global $pricetable_style;
        $defaults = array('pricing_feature' => '');
        extract( shortcode_atts( $defaults, $atts ) );
        $html = '';
        $priceCheck = '';
        if ( $pricetable_style =='classic' || $pricetable_style =='clean' ) {
            $priceCheck    = '';
        }
        
        if ( isset( $pricing_feature ) && $pricing_feature !='' ){
			 
         $html .= '<li><b>'.$pricing_feature.'</b></li>';
        }
        
        return $html;
    }
    if (function_exists('cs_short_code')) cs_short_code(CS_SC_PRICETABLEITEM, 'cs_pricing_item');
}