<?php

/*
 *
 * @Shortcode Name : Divider
 * @retrun
 *
 */
if (!function_exists('cs_divider_shortcode')) {

    function cs_divider_shortcode($atts) {
        $defaults = array(
            'column_size' => '1/1',
            'divider_style' => 'crossy',
            'divider_height' => '1',
            'divider_backtotop' => '',
            'divider_margin_top' => '',
            'divider_margin_bottom' => '',
            'line' => 'Wide',
            'color' => '#000',
            'cs_divider_class' => ''
        );
        extract(shortcode_atts($defaults, $atts));
        $column_class = cs_custom_column_class($column_size);
        $html = '';
        $backtotop = '';
        $divider_style = isset($divider_style) ? $divider_style : '';
        //if ($divider_backtotop == 'yes') {

            $backtotop = ' ';
        //} if ($divider_style == 'plain') {

          //  $div_html = '<div class="cs-spreater ' . $column_class . '" style=" margin-top:' . $divider_margin_top . 'px; margin-bottom:' . $divider_margin_bottom . 'px;height:' . $divider_height . 'px;"><div class="cs-divider1"></div></div>';
        //} else {

            $div_html = '<div class="cs-spreater" style=" margin-top:' . $divider_margin_top . 'px; margin-bottom:' . $divider_margin_bottom . 'px;height:' . $divider_height . 'px;"><div class="top-border"> </div></div>';
       // }
 
        return do_shortcode($div_html);
    }

    if (function_exists('cs_short_code')) cs_short_code(CS_SC_DIVIDER, 'cs_divider_shortcode');
}