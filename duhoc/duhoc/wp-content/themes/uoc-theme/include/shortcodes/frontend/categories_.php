<?php

/*
 *
 * @Shortcode Name : Divider
 * @retrun
 *
 */
if (!function_exists('cs_categories_shortcode')) {

    function cs_categories_shortcode($atts) {
        $defaults = array(
			'column_size' => '1/1',
			'cs_category_title'=>'',
			'cs_category_description'=>'',
			'cs_total_display'=>'4',
		);
        extract(shortcode_atts($defaults, $atts));
		
		$column_class = cs_custom_column_class($column_size);
        $html = '';
		$category_title='';
		$category_description='';
        if(isset($cs_category_title) && $cs_category_title <> ""){
			$category_title = $cs_category_title;
		}
		$category_description='';
        if(isset($cs_category_description) && $cs_category_description <> ""){
			$category_description = $cs_category_description;
		}
       
 		$categories = get_categories( array('taxonomy' => 'category', 'hide_empty' => 0) ); 
        $html .= '<div class="'.$column_class.'">';
		$html .= '<div class="cs-section-title"> <h2>'.esc_html($category_title).'</h2> </div>';
		$html .= '<p>'.$category_description.'</p>';
			$html .= ' <div class="cs_categories cat-multicolor">';
				$html .= '  <ul>';
				    $i=0;
					$j = 1;
					// for random color setting
					$array_color = array(); 
					$array_color[0]= '51087f';
					$array_color[1]= '876a90';
					$array_color[2]= '78aaf0';
					$array_color[3]= 'fcc109';
					$array_color[4]= 'e01729';
					$array_color[5]= '9cc72b';
					$array_color[6]= '999999';
					
					foreach ( $categories as $category ) { 
					   
					    $color = $array_color[$i];
						$cs_category_post_count = $category->category_count;
						$category_url  = get_category_link( $category->cat_ID );
						$html .= '<li><a style=" color: #'.$color.'; " href="'.esc_url( $category_url ).'">'.esc_attr($category->cat_name).'</a> ('.$cs_category_post_count.')</li>';
						if($i==6){$i=0;}
					$i++;
						if($j == $cs_total_display){ 
						  break;
						}
				 $j++;
				}
                $html .= '</ul>';
			$html .= ' </div>';
			
		$html .= '</div>';
	  
	  
        return do_shortcode($html);
    }

    if (function_exists('cs_short_code')) cs_short_code(CS_SC_CATEGORIES, 'cs_categories_shortcode');
}