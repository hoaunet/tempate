<?php

/*
 *
 * @Shortcode Name : Quote
 * @retrun
 *
 */
if (!function_exists('cs_quote_shortcode')) {

    function cs_quote_shortcode($atts, $content = null) {
        extract(shortcode_atts(array(
		'column_size' => '1/1', 
		'quote_style' => 'default', 
		'cs_quote_section_title' => '', 
		'quote_cite' => '', 
		'quote_cite_url' => '#', 
		'quote_text_color' => '',
        'quote_align' => 'center', 
		'cs_quote_class' => ''
		
		 ), $atts));
        $author_name = '';
        $html = '';
        $column_class = cs_custom_column_class($column_size);
       
        if (isset($quote_cite) && $quote_cite <> '') {
            $author_name .= '<div class="cs-auther-name"><span>';
            if (isset($quote_cite_url) && $quote_cite_url <> '') {
                $author_name .= '<a href="' . esc_url($quote_cite_url) . '">';
            }
            $author_name .= '- ' . $quote_cite;
            if (isset($quote_cite_url) && $quote_cite_url <> '') {
                $author_name .= '</a>';
            }
            $author_name .= '</span></div>';
        }
        if (isset($quote_align)) {
            if ($quote_align == 'left')
                $quote_align = 'text-left-align';
            if ($quote_align == 'right')
                $quote_align = 'text-right-align';
            if ($quote_align == 'center')
                $quote_align = 'text-center-align';
        }
        $section_title = '';
        if ($cs_quote_section_title && trim($cs_quote_section_title) != '') {
            $section_title = '<div class="cs-section-title"><h4 class="">' . esc_html($cs_quote_section_title) . '</h4></div>';
        }
        $cs_quote_class_id = '';
        if ($cs_quote_class <> '') {
            $cs_quote_class_id = ' id="' . $cs_quote_class . '"';
        }
		 $html .= '<blockquote class="cs-blockquote  ' . $cs_quote_class . '  ' . $quote_align . '" ' . $cs_quote_class_id . ' style="animation-duration: ; color:' . $quote_text_color . '">
                         <span>' . do_shortcode($content) . $author_name . '</span>
                        </blockquote>';
     
       	return '<div class="' . $column_class . '">' . $section_title . $html . '</div>';
		
		
		
		
    }

    if (function_exists('cs_short_code')) cs_short_code(CS_SC_QUOTE, 'cs_quote_shortcode');
}