<?php
/*
 *
 *@Shortcode Name : Table
 *@retrun
 *
 */

if (!function_exists('cs_table_shortcode_func')) {
    function cs_table_shortcode_func($atts, $content = "") {
        global $table_style;
        $defaults = array('table_style'=>'modern','cs_table_section_title'=>'','column_size'=>'1/1','cs_table_class'=>'');
        extract( shortcode_atts( $defaults, $atts ) );
        
        $column_class  = cs_custom_column_class($column_size);
        
        

        $section_title = '';
        
        if(isset($cs_table_section_title) && trim($cs_table_section_title) <> ''){
            $section_title = '<div class="cs-section-title"><h4>'.esc_html($cs_table_section_title).'</h4></div>';
        }
        return '<div class="cs-pricing-table table-responsive '. sanitize_html_class($column_class).' '. sanitize_html_class($cs_table_class).'">'.$section_title.do_shortcode($content).'</div>';
    }
	echo '';
    if (function_exists('cs_short_code')) cs_short_code(CS_SC_TABLES, 'cs_table_shortcode_func');
}

/*
 *
 *@Shortcode Name : Table
 *@retrun
 *
 */
if (!function_exists('cs_table_shortcode')) {
    function cs_table_shortcode($atts, $content = "") {
        global $table_style;
        $defaults = array('column_size'=>'1/1','cs_table_section_title'=>'','cs_table_content'=>'','cs_table_class'=>'');
        extract( shortcode_atts( $defaults, $atts ) );
        $content = str_replace('<br />','',$content);
        $table_data = '';
        $class = '';
        if($table_style == 'classic'){
            $cs_class = 'tablev2';
        }else if( $table_style == 'modren' ) {
            $cs_class = 'tablev1';
        }

        return $table_data . '<table class="cs-price-table '.sanitize_html_class($class).'">'.do_shortcode($content).'</table>';
    }
    if (function_exists('cs_short_code')) cs_short_code(CS_SC_TABLE, 'cs_table_shortcode');
}

/*
 *
 *@Shortcode Name : Table Body
 *@retrun
 *
 */
if (!function_exists('cs_table_body_shortcode')) {
    function cs_table_body_shortcode($atts, $content = "") {
        $defaults = array();
        extract( shortcode_atts( $defaults, $atts ) );
        return '<tbody>'.do_shortcode($content).
		
		
		'</tbody>';
    }
    if (function_exists('cs_short_code')) cs_short_code(CS_SC_TABLEBODY, 'cs_table_body_shortcode');
}

/*
 *
 *@Shortcode Name : Table Head
 *@retrun
 *
 */
if (!function_exists('cs_table_head_shortcode')) {
    function cs_table_head_shortcode($atts, $content = "") {
        $defaults = array();
        extract( shortcode_atts( $defaults, $atts ) );
        return '<thead>'.do_shortcode($content).'</thead>';
    }
    if (function_exists('cs_short_code')) cs_short_code(CS_SC_TABLEHEAD, 'cs_table_head_shortcode');
}

/*
 *
 *@Shortcode Name : Table Row
 *@retrun
 *
 */
if (!function_exists('cs_table_row_shortcode')) {
    function cs_table_row_shortcode($atts, $content = "") {
        $defaults = array();
        extract( shortcode_atts( $defaults, $atts ) );
        return '<tr>'.do_shortcode($content).'</tr>';
    
    }
    if (function_exists('cs_short_code')) cs_short_code(CS_SC_TABLEROW, 'cs_table_row_shortcode');
}

/*
 *
 *@Shortcode Name : Table Heading
 *@retrun
 *
 */
if (!function_exists('cs_table_heading_shortcode')) {
    function cs_table_heading_shortcode($atts, $content = "") {
        $defaults = array();
        extract( shortcode_atts( $defaults, $atts ) );
        $html     = '';
        $html    .= '<th>';
        $html    .= do_shortcode($content);
        $html    .= '</th>';
        
        return $html;
    }
    if (function_exists('cs_short_code')) cs_short_code(CS_SC_TABLEHEADING, 'cs_table_heading_shortcode');
}

/*
 *
 *@Shortcode Name : Table Data
 *@retrun
 *
 */
if (!function_exists('cs_table_data_shortcode')) {
    function cs_table_data_shortcode($atts, $content = "") {
        $defaults = array();
        extract( shortcode_atts( $defaults, $atts ) );
        return '<td>'.do_shortcode($content).'</td>';
    }
    if (function_exists('cs_short_code')) cs_short_code(CS_SC_TABLECOLUMN, 'cs_table_data_shortcode');
}

?>