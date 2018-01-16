<?php

/*
 *
 * @Shortcode Name : Job Specialisms
 * @retrun
 *
 */
if (!function_exists('cs_job_specialisms_shortcode')) {

    function cs_job_specialisms_shortcode($atts) {

        global $post, $current_user;

        $defaults = array(
			'column_size' => '1/1',
            'job_specialisms_title' => '',
            'spec_cats' => '',
			'cs_category_description'=>'',
        );

  		extract(shortcode_atts($defaults, $atts));
		$column_class = cs_custom_column_class($column_size);

        $html = '';

        $cs_plugin_options = get_option('cs_plugin_options');

        if (class_exists('cs_employer_functions')) {
            $cs_emp_funs = new cs_employer_functions();
        }
 
        $spec_cats = explode(',', $spec_cats);

        $html = '';
		$title ='';
        if ($job_specialisms_title != '') {
            $title = '<div class="cs-section-title"> <h2>'.esc_html($job_specialisms_title).'</h2> </div>';
        }

        $html .= '<div class="'.$column_class.'">';
		$html .= $title;
		$html .= '<p>'.$cs_category_description.'</p>';
			$html .= ' <div class="cs_categories cat-multicolor">';
				$html .= '  <ul>';

	 if (is_array($spec_cats) && sizeof($spec_cats) > 0) {
	
				foreach ($spec_cats as $cs_cat) {
	
					 $cs_term = get_term_by('slug', $cs_cat, 'course-category');
					 
					if (is_object($cs_term)) {
						   $term_id = $cs_term->term_id;
							$cat_meta = get_option( "spec_ext_$term_id" );
						$html .= '<li><a  href="' . esc_url(get_term_link($cs_term->slug, 'course-category')) . '" style="color:'.$cat_meta['color'].'">'.esc_attr($cs_term->name).'</a> ('.$cs_term->count.')</li>';
					}
				}
			}

			$html .= '</ul>';
			$html .= ' </div>';
		$html .= '</div>';

        return do_shortcode($html);
    }

    if (function_exists('cs_short_code')) cs_short_code('cs_job_specialisms', 'cs_job_specialisms_shortcode');
}
