<?php
/**
 * @Spacer html form for page builder
 */
if (!function_exists('cs_search_shortcode')) {

    function cs_search_shortcode($atts, $content = "") {
        global $cs_border, $post, $cs_theme_options;

        $defaults = array('cs_search_section_title' => '', 'cs_search_des' => '');
        extract(shortcode_atts($defaults, $atts));

        $cs_search_section_title = $cs_search_section_title ? $cs_search_section_title : '';
        $cs_search_des = $cs_search_des ? $cs_search_des : '';
        $args_cate = array(
            'show_count' => 0,
            'hide_empty' => 1,
            'child_of' => 0,
            'exclude' => '',
            'echo' => 1,
            'selected' => 0,
            'hierarchical' => 0,
            'taxonomy' => 'course-category',
            'value_field' => 'term_id',
        );
        $cs_custom_css = isset($cs_theme_options['cs_custom_css']) ? $cs_theme_options['cs_custom_css'] : '';
        $search = get_the_title($cs_custom_css);
        if (isset($_GET['uoc_title']) and $_GET['uoc_title'] != '' ||
                isset($_GET['cat']) and $_GET['cat'] != '' || isset($_GET['cs_campus']) and $_GET['cs_campus']) {
            $cs_custom_css = isset($cs_theme_options['cs_custom_css']) ? $cs_theme_options['cs_custom_css'] : '';

            if (isset($_GET['uoc_title']) and $_GET['uoc_title'] != ' ') {
                $cs_courses = $_GET['uoc_title'];
            } else if (isset($_GET['uoc_title']) and $_GET['uoc_title'] != '') {
                $cs_courses = '';
            }

            if (isset($_GET['cat']) and $_GET['cat'] != '') {
                $cs_course_cate = $_GET['cat'];
            } else if (isset($_GET['cat']) and $_GET['cat'] == '') {

                $cs_course_cate = $_GET['cat'];
            }

            if (isset($_GET['cs_campus']) and $_GET['cs_campus']) {
                $cs_campus = $_GET['cs_campus'];
            } else {
                $cs_campus = '';
            }

            $args = array(
                'post_type' => 'course',
                'post_status' => 'publish',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'course-category',
                        'terms' => $cs_course_cate,
                        'field' => 'term_id',
                    )
                ),
                'meta_query' => array(
                    array(
                        'key' => 'cs_course_campus_id',
                        'value' => $cs_campus,
                        'compare' => '=',
                    ),
                ),
            );
			
            ?>
            <div class="cs-courses listing-view default-courses col-md-12">
            <h3><?php echo esc_html($search) ?></h3>
            <?php
		 
            $cs_course_duration = isset($cs_course_duration) ? $cs_course_duration : '';
            $cs_course_price = isset($cs_course_price) ? $cs_course_price : '';
            $cs_course_code = isset($cs_course_code) ? $cs_course_code : '';
            $cs_degree_levels = isset($cs_degree_levels) ? $cs_degree_levels : '';
            $cs_degree_level_bg_color = isset($cs_degree_level_bg_color) ? $cs_degree_level_bg_color : '';
            $cs_user_instructors = isset($cs_user_instructors) ? $cs_user_instructors : '';
            $cs_buy_url = isset($cs_buy_url) ? $cs_buy_url : '';
            $cs_course_from_date = isset($cs_course_from_date) ? $cs_course_from_date : '';
            $query = new WP_Query($args);
            $post_count = $query->post_count;
     
           if (isset($post_count) and $post_count != 0) {


                while ($query->have_posts()) : $query->the_post();
                    $width = 260;
                    $height = 195;
                    $thumbnail = cs_get_post_img_src($post->ID, $width, $height);

                    if ($thumbnail == '') {
                        $thumbnail = get_template_directory_uri() . '/assets/images/no-image.png';
                    }

                    $cs_postObject = get_post_meta(get_the_id(), "cs_full_data", true);
                    /**************New Filed************** */
                    $cs_course_duration = get_post_meta($post->ID, "cs_course_duration_period", true); // course duration
                    $cs_course_price = get_post_meta($post->ID, "cs_course_price", true); // course price
                    $cs_course_code = get_post_meta($post->ID, "cs_course_code", true); // course code
                    $cs_degree_levels = get_post_meta($post->ID, "cs_degree_levels", true); // degree level
                    $cs_degree_level_bg_color = get_post_meta($post->ID, "cs_degree_level_bg_color", true); // degree level bg
                    $cs_user_instructors = get_post_meta($post->ID, "cs_user_instructors", true); // instructor id
                    $cs_buy_url = get_post_meta($post->ID, "cs_buy_url", true);  // buy url
                    $cs_course_from_date = date_i18n('F j, Y', strtotime(get_post_meta($post->ID, "cs_course_from_date", true))); // start date
                   $the_title = substr(get_the_title(), 0, 40); // the title
                    //$the_content = substr(the_content(),0,45); // the conetnt
                    // get user information
                    $user = get_user_by('id', $cs_user_instructors);
                    $user_instructor_name = $user->first_name . ' ' . $user->last_name;
                    // get terms against specific pist
                    $term_list = wp_get_post_terms($post->ID, 'course-category', array("fields" => "names"));
                    $terms = '';
                    for ($i = 0; $i < sizeof($term_list); $i++) {
                        $terms .= '<li>' . $term_list[$i] . '</li>';
                    }
                    ?>

                        <article>
                            <figure>
                                <a href="<?php esc_url(the_permalink()); ?>"><img src="<?php echo esc_url($thumbnail); ?>"></a>
                                <figcaption>
                                    <span class="course-num"><?php echo cs_allow_special_char($cs_course_code) ?></span>
                                </figcaption>
                            </figure>
                            <div class="cs-text">
                                <ul class="course-tags">
                    <?php echo cs_allow_special_char($terms) ?>
                                    <li class="red" style="background:<?php echo cs_allow_special_char($cs_degree_level_bg_color) ?>!important;"><?php echo cs_allow_special_char($cs_degree_levels) ?></li>
                                </ul>
                                <h2><a href="<?php esc_url(the_permalink()); ?>">
                    <?php echo cs_allow_special_char($the_title) ?></a> 
                    <?php if ($cs_course_price <> "") { ?>
                                        <span class="price"><?php echo cs_allow_special_char($cs_course_price) ?></span>
                                    <?php } ?>
                                </h2>

                                        <?php echo wp_trim_words(get_the_content(), 40); ?>
                                <ul class="course-info">

                                    <?php if ($cs_user_instructors <> "") { ?>

                                        <li>
                                            <figure>
                                    <?php echo get_avatar($cs_user_instructors, '96'); ?>
                                            </figure>

                                            <div class="details">
                                                <span class="title"><?php _e('Instructor', 'uoc') ?></span>
                                                <i class="icon-user9"></i>
                                                <span class="value"><?php echo cs_allow_special_char($user_instructor_name) ?></span>
                                            </div>
                                        </li>
                    <?php } ?>

                    <?php if ($cs_course_duration <> "") { ?>
                                        <li>
                                            <div class="details">
                                                <span class="title"><?php _e('Duration', 'uoc') ?></span>
                                                <i class="icon-folder5"></i>
                                                <span class="value"><?php echo cs_allow_special_char($cs_course_duration) ?></span>
                                            </div>
                                        </li>
                    <?php } ?>

                    <?php if ($cs_course_from_date <> "") { ?>
                                        <li>
                                            <div class="details">
                                                <span class="title"><?php _e('Starts From', 'uoc') ?></span>
                                                <i class="icon-folder5"></i>
                                                <span class="value"><?php echo cs_allow_special_char($cs_course_from_date) ?></span> 
                                            </div>
                                        </li>
                    <?php } ?> 
                                    <li class="courses-btn">
                                        <a href="<?php esc_url(the_permalink()); ?>"><i class="icon-plus8"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </article> 

                    <?php
                endwhile;
          } else {

               cs_fnc_advance_result_found();
				 
            }
				 echo '</div>';
        } else{
            ?>
                <div class="col-md-12">
                    <div class="cs-section-title"> <h2><?php echo esc_html($cs_search_section_title) ?></h2> </div>
                    <div class="search-course">

                        <h6><?php echo cs_allow_special_char($cs_search_des) ?></h6>
                        <form action="<?php echo esc_url( home_url('/') ) . $search; ?>" method="get">
                            <ul>
                                <li> <i class="icon-book8"></i>


                                    <input type="text" value="" placeholder="<?php _e('Search by keyword', 'uoc'); ?>" name="uoc_title" > </li>
                                <li>
                                    <i class="icon-graduation"></i>
                                    <label class="select-style">
            <?php wp_dropdown_categories($args_cate); ?>
                                    </label>

                                </li>
                                <li>
                                    <i class="icon-world"></i>
                                    <label class="select-style">
                                        <select name="cs_campus">
                                            <option><?php _e('Select Capmus', 'uoc'); ?></option>
            <?php
            $campus = array('posts_per_page' => "-1", 'post_type' => 'campus', 'post_status' => 'publish');
            $query = new WP_Query($campus);
            while ($query->have_posts()) : $query->the_post();
                ?>
                                                <option value="<?php echo get_the_id(); ?>"><?php the_title(); ?></option>
            <?php endwhile; ?>
                                        </select>
                                    </label>
                                </li>
                                <li class="search-submit">
                                    <i class="icon-search3"></i>
                                    <input type="submit" value="<?php _e('Search', 'uoc'); ?>">
                                    <a href="#"><i class="icon-arrow-right8"></i> <?php _e('List A to Z Courses', 'uoc'); ?></a>
                                </li>
                            </ul>
                        </form>

                    </div>
                </div>

            <?php
        }
    }

    if (function_exists('cs_short_code')) cs_short_code(CS_SC_SEARCH, 'cs_search_shortcode');
}		


 