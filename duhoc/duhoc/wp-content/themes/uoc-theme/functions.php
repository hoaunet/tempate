<?php
add_action('after_setup_theme', 'cs_theme_setup');

function cs_theme_setup() {
    global $wpdb;
    // This theme styles the visual editor with editor-style.css to match the theme style.
    add_editor_style();
    // Make theme available for translation
    // Translations can be filed in the /languages/ directory
    load_theme_textdomain('uoc', get_template_directory() . '/languages');
    if (!isset($content_width)) {
        $content_width = 1170;
    }
    $args = array(
        'default-color' => '',
        'flex-width' => true,
        'flex-height' => true,
        'default-image' => '',
    );
    add_theme_support('custom-background', $args);
    add_theme_support('custom-header', $args);
    // This theme uses post thumbnails
    add_theme_support('post-thumbnails');
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');
    add_theme_support("title-tag");
    /* Add custom actions. */
    global $pagenow;
    if (!session_id()) {
		session_start();
    }
    if (!get_option('cs_font_list') || !get_option('cs_font_attribute')) {
        cs_get_google_init_arrays();
    }
    if (is_admin() && isset($_GET['activated']) && $pagenow == 'themes.php') {

        if (!get_option('cs_theme_options')) {
            add_action('init', 'cs_activation_data');
        }
      
        if (!get_option('cs_theme_options')) {
            wp_redirect(admin_url('themes.php?page=tgmpa-install-plugins'));
        }
    }
	
    add_action('admin_enqueue_scripts', 'cs_admin_scripts_enqueue');
    //wp_enqueue_scripts
    add_action('wp_enqueue_scripts', 'cs_front_scripts_enqueue');
    /* Add custom filters. */
    add_filter('widget_text', 'do_shortcode');
    add_filter('the_password_form', 'cs_password_form');
    add_filter('pre_get_posts', 'cs_change_query_vars');
    define('ICL_DONT_LOAD_LANGUAGE_SELECTOR_CSS', true);
}

// Theme Editor Styles
function cs_theme_add_editor_styles() {
    add_editor_style( get_stylesheet_directory_uri() . '/assets/css/custom-editor-style.css' );
}
add_action( 'admin_init', 'cs_theme_add_editor_styles' );

// Default Gallery
add_action('admin_footer-post.php', 'cs_remove_gallery_setting_div');
if (!function_exists('cs_remove_gallery_setting_div')) {

    function cs_remove_gallery_setting_div() {
        echo '
		<style type="text/css">
			.media-sidebar .gallery-settings{
				display:none;
			}
		</style>';
    }

}

add_filter('post_gallery', 'cs_custom_gallery', 10, 2);

function cs_custom_gallery($output, $attr) {
    global $post;

    if (isset($attr['orderby'])) {
        $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
        if (!$attr['orderby'])
            unset($attr['orderby']);
    }

    extract(shortcode_atts(array(
        'order' => 'ASC',
        'orderby' => 'menu_order ID',
        'id' => $post->ID,
        'itemtag' => 'dl',
        'icontag' => 'dt',
        'captiontag' => 'dd',
        'include' => '',
        'exclude' => ''
    ), $attr));

    $id = intval($id);
    if ('RAND' == $order)
        $orderby = 'none';

    if (!empty($include)) {
        $include = preg_replace('/[^0-9,]+/', '', $include);
        $_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));

        $attachments = array();
        foreach ($_attachments as $key => $val) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    }

    if (empty($attachments))
        return '';

    // Here's your actual output, you may customize it to your need

    $output = "<div class=\"cs-gallery default-gallery\">\n";

    // Now you loop through each attachment
    foreach ($attachments as $id => $attachment) {
        $img_full = wp_get_attachment_image_src($id, 'full');
        $img = wp_get_attachment_image_src($id, 'cs_media_3');

        $output .= "<article class=\"col-md-3\">\n";
        $output .= "<figure>\n";
        $output .= "<img src=\"{$img[0]}\" alt=\"\" />\n";
        $output .= "<figcaption><a data-rel=\"prettyPhoto[0]\" href=\"{$img_full[0]}\"><i class=\"icon-plus7\"></i></a></figcaption>\n";
        $output .= "</figure>\n";
        $output .= "</article>\n";
    }

    $output .= "</div>\n";

    return $output;
}

function cs_remove_dimensions_avatars($avatar) {
    $avatar = preg_replace("/(width|height)=\'\d*\'\s/", "", $avatar);
    return $avatar;
}

add_filter('get_avatar', 'cs_remove_dimensions_avatars', 10);

function cs_ensure_ajaxurl() {
    if (is_admin())
        return;
    ?>
    <script type="text/javascript"> //<![CDATA[ var admin_url = <?php echo admin_url('admin-ajax.php') ?>; //]]> </script>
    <?php
}

// tgm class for (internal and WordPress repository) plugin activation start
require_once get_template_directory() . '/include/theme-components/cs-activation-plugins/tgm_plugin_activation.php';
add_action('tgmpa_register', 'cs_register_required_plugins');

function cs_register_required_plugins() {
    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(
        // This is an example of how to include a plugin from the WordPress Plugin Repository
            
	array(
			'name'     				=> 'Revolution Slider',
			'slug'     				=> 'revslider',
			'source'   				=> 'http://chimpgroup.com/wp-demo/download-plugin/revslider.zip', 
			'required' 				=> false, 
			'version' 				=> '',
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
			'external_url' 			=> '',
		),
		
	array(
            'name' => __('CS Framework', 'uoc'),
            'slug' => 'cs-framework',
            'source' => get_template_directory_uri() . '/include/theme-components/cs-activation-plugins/cs-framework.zip',
            'required' => true,
            'version' => '',
            'force_activation' => false,
            'force_deactivation' => false,
            'external_url' => '',
        ),
 
	array(
            'name' => 'Loco translate',
            'slug' => 'loco-translate',
            'required' => false,
        ),
        array(
            'name' => 'Envato Wordpress Toolkit',
            'slug' => 'envato-wordpress-toolkit',
            'source' => 'https://github.com/envato/envato-wordpress-toolkit/archive/master.zip',
            'external_url' => '',
            'required' => false,
        )
    );
    // Change this to your theme text domain, used for internationalising strings
    $theme_text_domain = 'uoc';
    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
		'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
        
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'uoc' ),
			'menu_title'                      => __( 'Install Plugins', 'uoc' ),
			'installing'                      => __( 'Installing Plugin: %s', 'uoc' ), // %s = plugin name.
			'oops'                            => __( 'Something went wrong with the plugin API.', 'uoc' ),
			'notice_can_install_required'     => _n_noop(
				'This theme requires the following plugin: %1$s.',
				'This theme requires the following plugins: %1$s.',
				'uoc'
			), // %1$s = plugin name(s).
			'notice_can_install_recommended'  => _n_noop(
				'This theme recommends the following plugin: %1$s.',
				'This theme recommends the following plugins: %1$s.',
				'uoc'
			), // %1$s = plugin name(s).
			'notice_cannot_install'           => _n_noop(
				'Sorry, but you do not have the correct permissions to install the %1$s plugin.',
				'Sorry, but you do not have the correct permissions to install the %1$s plugins.',
				'uoc'
			), // %1$s = plugin name(s).
			'notice_ask_to_update'            => _n_noop(
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				'uoc'
			), // %1$s = plugin name(s).
			'notice_ask_to_update_maybe'      => _n_noop(
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				'uoc'
			), // %1$s = plugin name(s).
			'notice_cannot_update'            => _n_noop(
				'Sorry, but you do not have the correct permissions to update the %1$s plugin.',
				'Sorry, but you do not have the correct permissions to update the %1$s plugins.',
				'uoc'
			), // %1$s = plugin name(s).
			'notice_can_activate_required'    => _n_noop(
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				'uoc'
			), // %1$s = plugin name(s).
			'notice_can_activate_recommended' => _n_noop(
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'uoc'
			), // %1$s = plugin name(s).
			'notice_cannot_activate'          => _n_noop(
				'Sorry, but you do not have the correct permissions to activate the %1$s plugin.',
				'Sorry, but you do not have the correct permissions to activate the %1$s plugins.',
				'uoc'
			), // %1$s = plugin name(s).
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'uoc'
			),
			'update_link' 			  => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				'uoc'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				'uoc'
			),
			'return'                          => __( 'Return to Required Plugins Installer', 'uoc' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'uoc' ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', 'uoc' ),
			'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'uoc' ),  // %1$s = plugin name(s).
			'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'uoc' ),  // %1$s = plugin name(s).
			'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'uoc' ), // %s = dashboard link.
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'uoc' ),

			'nag_type'                        => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
		),
		
	);
    tgmpa($plugins, $config);
}

// tgm class for (internal and WordPress repository) plugin activation end
// Gallery Large View
add_image_size('cs_media_1', 1062, 596, true);
add_image_size('cs_media_2', 1060, 460, true);

add_image_size('cs_media_3', 800, 190, true);
// Blog Large, Blog Detail
add_image_size('cs_media_4', 770, 433, true);
//event size, Course Detail, Event
add_image_size('cs_media_5', 340, 255, true);
// Related Blog, Courses,Event Detail:
add_image_size('cs_media_6', 250, 188, true);
// Gallery 4 column View, Gallery Thumbnails
add_image_size('cs_media_7', 243, 137, true);
// Thumb size On Portfolio Detail
// add_image_size('cs_media_6', 120, 90, true);
// Thumb size On gallery large
// gallery detail view for crosuoal thumbs
add_image_size('cs_media_8', 171, 96, true);
add_image_size('cs_media_9', 150, 150, true);
// Next post link class
if (!function_exists('cs_posts_link_next_class')) {

    function cs_posts_link_next_class($format) {
        $format = str_replace('href=', 'class="pix-nextpost" href=', $format);
        return $format;
    }

    add_filter('next_post_link', 'cs_posts_link_next_class');
}

// prev post link class
if (!function_exists('cs_posts_link_prev_class')) {

    function cs_posts_link_prev_class($format) {
        $format = str_replace('href=', 'class="pix-prevpost" href=', $format);
        return $format;
    }

    add_filter('previous_post_link', 'cs_posts_link_prev_class');
}


// stripslashes / htmlspecialchars for theme option save start
if (!function_exists('cs_stripslashes_htmlspecialchars')) {

    function cs_stripslashes_htmlspecialchars($value) {
        $value = is_array($value) ? array_map('cs_stripslashes_htmlspecialchars', $value) : stripslashes(htmlspecialchars($value));
        return $value;
    }

}

/*
 * Hex Color 
 */

function cs_hex2rgb($hex) {
    $hex = str_replace("#", "", $hex);

    if (strlen($hex) == 3) {
        $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
        $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
        $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
    } else {
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
    }
    $rgb = array($r, $g, $b);
    return $rgb;
}

/*
 * End Color 
 */

//Countries Array
if (!function_exists('cs_get_countries')) {

    function cs_get_countries() {
        $get_countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan",
            "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "British Virgin Islands",
            "Brunei", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China",
            "Colombia", "Comoros", "Costa Rica", "Croatia", "Cuba", "Cyprus", "Czech Republic", "Democratic People's Republic of Korea", "Democratic Republic of the Congo", "Denmark", "Djibouti",
            "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "England", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Fiji", "Finland", "France", "French Polynesia",
            "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea Bissau", "Guyana", "Haiti", "Honduras", "Hong Kong",
            "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Kosovo", "Kuwait", "Kyrgyzstan",
            "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macao", "Macedonia", "Madagascar", "Malawi", "Malaysia",
            "Maldives", "Mali", "Malta", "Marshall Islands", "Mauritania", "Mauritius", "Mauritius", "Mexico", "Micronesia", "Moldova", "Monaco", "Mongolia", "Montenegro", "Morocco", "Mozambique",
            "Myanmar(Burma)", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Northern Ireland",
            "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Palestine", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Poland", "Portugal", "Puerto Rico",
            "Qatar", "Republic of the Congo", "Romania", "Russia", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa",
            "San Marino", "Saudi Arabia", "Scotland", "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa",
            "South Korea", "Spain", "Sri Lanka", "Sudan", "Suriname", "Swaziland", "Sweden", "Switzerland", "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Timor-Leste", "Togo", "Tonga",
            "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Tuvalu", "US Virgin Islands", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "Uruguay",
            "Uzbekistan", "Vanuatu", "Vatican", "Venezuela", "Vietnam", "Wales", "Yemen", "Zambia", "Zimbabwe");
        return $get_countries;
    }

}



if (!function_exists('cs_get_degree_levels')) {

    function cs_get_degree_levels() {
       
	   $get_degree_levels = array("Advance","Intermidiate","beginners","Pro");
        return $get_degree_levels;
    }

}

// installing tables on theme activating start
global $pagenow;

// Admin scripts enqueue
function cs_admin_scripts_enqueue() {
    if (is_admin()) {
        $template_path = get_template_directory_uri() . '/include/assets/scripts/media_upload.js';
        wp_enqueue_media();
        wp_enqueue_script('my-upload', $template_path, array('jquery', 'media-upload', 'thickbox', 'jquery-ui-droppable', 'jquery-ui-datepicker', 'jquery-ui-slider', 'wp-color-picker'));
        wp_enqueue_script('datetimepicker1_js', get_template_directory_uri() . '/include/assets/scripts/jquery_datetimepicker.js', '', '', true);
        wp_enqueue_script('admin_theme-option-fucntion_js', get_template_directory_uri() . '/include/assets/scripts/theme_option_fucntion.js', '', '', true);
        wp_enqueue_style('custom_wp_admin_style', get_template_directory_uri() . '/include/assets/css/admin_style.css');
        wp_enqueue_script('custom_wp_admin_script', get_template_directory_uri() . '/include/assets/scripts/cs_functions.js');
        wp_enqueue_script('custom_page_builder_wp_admin_script', get_template_directory_uri() . '/include/assets/scripts/cs_page_builder_functions.js');
        wp_enqueue_script('bootstrap.min_script', get_template_directory_uri() . '/include/assets/scripts/bootstrap.min.js');
        wp_enqueue_style('wp-color-picker');
        // load icon moon
        wp_enqueue_script('fonticonpicker_js', get_template_directory_uri() . '/include/assets/icon/js/jquery.fonticonpicker.min.js');
        wp_enqueue_style('fonticonpicker_css', get_template_directory_uri() . '/include/assets/icon/css/jquery.fonticonpicker.min.css');
        wp_enqueue_style('iconmoon_css', get_template_directory_uri() . '/include/assets/icon/css/iconmoon.css');
        wp_enqueue_style('fonticonpicker_bootstrap_css', get_template_directory_uri() . '/include/assets/icon/theme/bootstrap-theme/jquery.fonticonpicker.bootstrap.css');
    }
}

# Classes
require_once get_template_directory() . '/include/shortcodes/classes/class_parse.php';
require_once get_template_directory() . '/include/metaboxes/classes/cs_meta_fields_render.php';
require_once get_template_directory() . '/include/helpers/notification-helper.php';

#Configuration
require_once get_template_directory() . '/include/shortcodes/config.php'; // Shortcodes name
#Shortcodes
require_once get_template_directory() . '/include/shortcodes/admin/search.php'; // search
require_once get_template_directory() . '/include/shortcodes/frontend/search.php'; // search

require_once get_template_directory() . '/include/shortcodes/admin/promobox.php'; // promobox
require_once get_template_directory() . '/include/shortcodes/frontend/promobox.php'; // promobox

require_once get_template_directory() . '/include/shortcodes/admin/call-to-action.php'; // Call to action
require_once get_template_directory() . '/include/shortcodes/frontend/call-to-action.php'; // Call to action
require_once get_template_directory() . '/include/shortcodes/admin/sitemap.php'; // Button PB Element
require_once get_template_directory() . '/include/shortcodes/frontend/sitemap.php'; // Shortcode Shortcodes
require_once get_template_directory() . '/include/shortcodes/admin/button.php'; // Button PB Element
require_once get_template_directory() . '/include/shortcodes/frontend/button.php'; // Shortcode Shortcodes
require_once get_template_directory() . '/include/shortcodes/admin/tabs.php'; // tabs PB Element
require_once get_template_directory() . '/include/shortcodes/frontend/tabs.php'; // tabs Shortcodes
require_once get_template_directory() . '/include/shortcodes/admin/price-table.php'; // price-table PB Element
require_once get_template_directory() . '/include/shortcodes/frontend/price-table.php'; // price-table Shortcodes
require_once get_template_directory() . '/include/shortcodes/admin/accordion.php'; // accordion PB Element
require_once get_template_directory() . '/include/shortcodes/frontend/accordion.php'; // accordion Shortcodes
require_once get_template_directory() . '/include/shortcodes/admin/faq.php'; // Faq PB Element
require_once get_template_directory() . '/include/shortcodes/frontend/faq.php'; // Faq Shortcodes
require_once get_template_directory() . '/include/shortcodes/admin/table.php'; // Table PB Element
require_once get_template_directory() . '/include/shortcodes/frontend/table.php'; // Table Shortcodes
require_once get_template_directory() . '/include/shortcodes/admin/progressbar.php'; // Table PB Element
require_once get_template_directory() . '/include/shortcodes/frontend/progressbar.php'; // Table Shortcodes
require_once get_template_directory() . '/include/shortcodes/admin/tweets.php'; // tweets PB Element
require_once get_template_directory() . '/include/shortcodes/frontend/tweets.php'; // tweets Shortcodes
require_once get_template_directory() . '/include/shortcodes/admin/divider.php'; // contactus PB Element
require_once get_template_directory() . '/include/shortcodes/frontend/divider.php'; // contactus Shortcodes

require_once get_template_directory() . '/include/shortcodes/admin/categories.php'; // contactus PB Element
require_once get_template_directory() . '/include/shortcodes/frontend/categories.php'; // contactus Shortcodes

require_once get_template_directory() . '/include/shortcodes/admin/contactus.php'; // contactus PB Element
require_once get_template_directory() . '/include/shortcodes/frontend/contactus.php'; // contactus Shortcodes
require_once get_template_directory() . '/include/shortcodes/admin/testimonial.php'; // testimonial PB Element
require_once get_template_directory() . '/include/shortcodes/frontend/testimonial.php'; // testimonial Shortcodes
require_once get_template_directory() . '/include/shortcodes/admin/heading.php'; // testimonial PB Element
require_once get_template_directory() . '/include/shortcodes/frontend/heading.php'; // testimonial Shortcodes
require_once get_template_directory() . '/include/shortcodes/admin/quote.php'; // contactus PB Element
require_once get_template_directory() . '/include/shortcodes/frontend/quote.php'; // contactus Shortcodes
require_once get_template_directory() . '/include/shortcodes/admin/counters.php'; // tweets PB Element
require_once get_template_directory() . '/include/shortcodes/frontend/counters.php'; // tweets Shortcodes
require_once get_template_directory() . '/include/shortcodes/admin/map.php'; // map PB Element 
require_once get_template_directory() . '/include/shortcodes/frontend/map.php'; // map Shortcodes
require_once get_template_directory() . '/include/shortcodes/admin/image-frame.php'; // map PB Element
require_once get_template_directory() . '/include/shortcodes/frontend/image-frame.php'; // map Shortcodes
require_once get_template_directory() . '/include/shortcodes/admin/revolution-slider.php'; // slider-shortcode PB Element
require_once get_template_directory() . '/include/shortcodes/frontend/revolution-slider.php'; // slider-shortcode Shortcodes
require_once get_template_directory() . '/include/shortcodes/admin/slider.php'; // slider PB Element
require_once get_template_directory() . '/include/shortcodes/frontend/slider.php'; // slider Shortcodes
require_once get_template_directory() . '/include/shortcodes/admin/clients.php'; // icons PB Element
require_once get_template_directory() . '/include/shortcodes/frontend/clients.php'; // icons Shortcodesicons
require_once get_template_directory() . '/include/shortcodes/admin/multi-services.php'; // icons PB Element
require_once get_template_directory() . '/include/shortcodes/frontend/multi-services.php'; // icons Shortcodesicons
require_once get_template_directory() . '/include/shortcodes/admin/services.php'; // services PB Element
require_once get_template_directory() . '/include/shortcodes/frontend/services.php'; // services Shortcodesicons
require_once get_template_directory() . '/include/shortcodes/admin/infobox.php'; // icons PB Element
require_once get_template_directory() . '/include/shortcodes/frontend/infobox.php'; // icons Shortcodesicons  
require_once get_template_directory() . '/include/shortcodes/admin/list.php'; // flex-column PB Element
require_once get_template_directory() . '/include/shortcodes/frontend/list.php'; // flex-column Shortcodesicons


require_once get_template_directory() . '/include/shortcodes/admin/opening_hours.php'; // flex-column PB Element
require_once get_template_directory() . '/include/shortcodes/frontend/opening_hours.php'; // flex-column Shortcodesicons
require_once get_template_directory() . '/include/shortcodes/admin/spacer.php'; // flex-column PB Element
require_once get_template_directory() . '/include/shortcodes/frontend/spacer.php'; // flex-column PB Element
require_once get_template_directory() . '/include/shortcodes/admin/flex-column.php'; // flex-column PB Element
require_once get_template_directory() . '/include/shortcodes/frontend/flex-column.php'; // flex-column Shortcodesicons
//require_once get_template_directory() . '/include/shortcodes/admin/team.php'; // Team PB Element
//require_once get_template_directory() . '/include/shortcodes/frontend/team.php'; // Team Shortcodesicons
require_once get_template_directory() . '/include/shortcodes/admin/video.php'; // flex-column PB Element
require_once get_template_directory() . '/include/shortcodes/frontend/video.php'; // flex-column Shortcodesicons

require_once get_template_directory() . '/include/shortcodes/admin/quick_quote.php'; // Quick Quote PB Element
require_once get_template_directory() . '/include/shortcodes/frontend/quick_quote.php'; // Quick Quote Shortcodesicons
# Files
require_once get_template_directory() . '/include/page_builder.php';
require_once get_template_directory() . '/include/metaboxes/general-settings.php';
require_once get_template_directory() . '/include/metaboxes/post_meta.php';
require_once get_template_directory() . '/include/metaboxes/page_meta.php';

#Blogs
require_once get_template_directory() . '/cs-templates/blog-styles/blog_element.php';
require_once get_template_directory() . '/cs-templates/blog-styles/blog_functions.php';


#Admin
require_once get_template_directory() . '/include/admin_functions.php';

// Result/Reports listing for Instructors
require_once get_template_directory() . '/include/theme-components/cs-widgets/widgets.php';

require_once get_template_directory() . '/include/theme-components/cs-header/header_functions.php';
require_once get_template_directory() . '/include/shortcodes/admin_functions.php';
require_once get_template_directory() . '/include/theme-components/cs-googlefont/fonts.php';
require_once get_template_directory() . '/include/theme-components/cs-googlefont/google_fonts.php';
require_once get_template_directory() . '/include/theme-components/cs-googlefont/fonts_array.php';
require_once get_template_directory() . '/include/theme-options/theme_options.php';
require_once get_template_directory() . '/include/theme-options/theme_options_fields.php';
require_once get_template_directory() . '/include/theme-options/theme_options_functions.php';
require_once get_template_directory() . '/include/theme-options/theme_options_arrays.php';

require_once ABSPATH . '/wp-admin/includes/file.php';

add_action('admin_menu', 'cs_theme_opt_menu');
function cs_theme_opt_menu() {
	add_theme_page('CS Theme Option', __('CS Theme Option','uoc'), 'read', 'cs_options_page', 'cs_options_page');
}

// Enqueue frontend style and scripts
if ( ! function_exists('cs_front_scripts_enqueue') ) {

    function cs_front_scripts_enqueue() {
        global $cs_theme_options;
        if ( ! is_admin() ) {
            wp_enqueue_script(array('jquery'));
            wp_enqueue_style('iconmoon_css', get_template_directory_uri() . '/include/assets/icon/css/iconmoon.css');
            wp_enqueue_style('bootstrap_css', get_template_directory_uri() . '/assets/css/bootstrap.min.css');
            wp_enqueue_style('style_css', get_stylesheet_directory_uri() . '/style.css');
			wp_enqueue_style('owl_carousel', get_template_directory_uri() . '/assets/css/owl.carousel.css');
			wp_enqueue_style('widget_css', get_template_directory_uri() . '/assets/css/widget.css');
			wp_enqueue_style('datepicker_css', get_template_directory_uri() . '/assets/css/jquery.datetimepicker.css');
			if (isset($cs_theme_options['cs_style_rtl']) and $cs_theme_options['cs_style_rtl'] == "on") {
                cs_rtl();
			}
			if (isset($cs_theme_options['cs_responsive']) && $cs_theme_options['cs_responsive'] == "on") {
                echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">';
                wp_enqueue_style('responsive_css', get_template_directory_uri() . '/assets/css/responsive.css');
			}
			wp_enqueue_style('bootstrap-theme_css', get_template_directory_uri() . '/assets/css/bootstrap-theme.css');
			wp_enqueue_style('prettyPhoto_css', get_template_directory_uri() . '/assets/css/prettyphoto.css');
			wp_enqueue_style('flexslider_css', get_template_directory_uri() . '/assets/css/flexslider.css');
			
			// Theme Styles
			wp_enqueue_style('theme_style_css', get_template_directory_uri() . '/include/theme_styles.php');
			
			wp_enqueue_script('bootstrap.min_script', get_template_directory_uri() . '/assets/scripts/bootstrap.min.js');
			wp_enqueue_script('counter_script', get_template_directory_uri() . '/assets/scripts/counter.js');
			wp_enqueue_script('prettyPhoto_js', get_template_directory_uri() . '/assets/scripts/jquery.prettyphoto.js', '', '', true);
			wp_enqueue_script('functions_js', get_template_directory_uri() . '/assets/scripts/functions.js', '', '', true);
			wp_enqueue_script('responsive-calendar_js', get_template_directory_uri() . '/assets/scripts/responsive-calendar.js', '', '', true);
			wp_enqueue_script('cs_functions_script', get_template_directory_uri() . '/include/assets/scripts/cs_functions.js', '', '', true);
			
		 
        }
    }

}

//RTL stylesheet enqueue
if (!function_exists('cs_rtl')) {

    function cs_rtl() {
        wp_enqueue_style('rtl_css', get_template_directory_uri() . '/assets/css/rtl.css');
    }

}


if (!function_exists('prettyphoto_files')) {

    function prettyphoto_files() {
		wp_enqueue_style('prettyPhoto_css', get_template_directory_uri() . '/assets/css/prettyPhoto.css');
		wp_enqueue_script('prettyPhoto_js', get_template_directory_uri() . '/assets/scripts/jquery.prettyphoto.js', '', '', true);
    }
}

// scroll to fix
function cs_scrolltofix() {
  //  wp_enqueue_script('sticky_header_js', get_template_directory_uri() . '/assets/scripts/sticky_header.js', '', '', true);
}

// Isotope
if (!function_exists('cs_filter_enqueue')) {

    function cs_filter_enqueue() {
        wp_enqueue_script('isotope_js', get_template_directory_uri() . '/assets/scripts/isotope.min.js', '', '', true);
	    wp_enqueue_script('custom_js', get_template_directory_uri() . '/assets/scripts/custom.js', '', '', true);
    }

}
// Isotope
if (!function_exists('cs_isotope_enqueue')) {

    function cs_isotope_enqueue() {
        wp_enqueue_script('isotope_js', get_template_directory_uri() . '/assets/scripts/isotope.min.js', '', '', true);
    }

}
// Datepicker
if (!function_exists('cs_fr_datepickr')) {

    function cs_fr_datepickr() {
        wp_enqueue_script('bootstrap_datepicker_js', get_template_directory_uri() . '/assets/scripts/bootstrap-datepicker.js', '', '', true);
		wp_enqueue_script('datepicker_js', get_template_directory_uri() . '/assets/scripts/jquery.datetimepicker.js', '', '', true);
    }

}
// Prettyphoto
if (!function_exists('cs_prettyphoto_enqueue')) {

    function cs_prettyphoto_enqueue() {
       // wp_enqueue_script('prettyPhoto_js', get_template_directory_uri() . '/assets/scripts/jquery.prettyPhoto.js', '', '', true);
    }

}


// Flexslider Script
if (!function_exists('cs_enqueue_flexslider_script')) {

    function cs_enqueue_flexslider_script() {
        wp_enqueue_script('jquery.flexslider-min_js', get_template_directory_uri() . '/assets/scripts/jquery.flexslider-min.js', '', '', true);
		 
    }

}
// Count Numbers
if (!function_exists('cs_count_numbers_script')) {

    function cs_count_numbers_script() {
        wp_enqueue_script('waypoints_js', get_template_directory_uri() . '/assets/scripts/waypoints_min.js', '', '', true);
    }

}
// Skillbar
if (!function_exists('cs_skillbar_script')) {

    function cs_skillbar_script() {
        wp_enqueue_script('waypoints_js', get_template_directory_uri() . '/assets/scripts/waypoints_min.js', '', '', true);
        wp_enqueue_script('skills-progress_js', get_template_directory_uri() . '/assets/scripts/skills-progress.js', '', '', true);
	}

}


// Add this enqueue Script
if (!function_exists('cs_addthis_script_init_method')) {

    function cs_addthis_script_init_method() {
        wp_enqueue_script('cs_addthis', 'http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e4412d954dccc64', '', '', true);
    }

}

// carousel script for related posts
if (!function_exists('cs_owl_carousel')) {

    function cs_owl_carousel() {
        wp_enqueue_script('owl.carousel_js', get_template_directory_uri() . '/assets/scripts/owl.carousel.min.js', '', '', true);
    }

}

// Favicon and header code in head tag//
if (!function_exists('cs_header_settings')) {

    function cs_header_settings() {
        global $cs_theme_options;
		
		if ( ! function_exists( 'has_site_icon' ) || ! wp_site_icon() ) {

			$cs_favicon = $cs_theme_options['cs_custom_favicon'] ? $cs_theme_options['cs_custom_favicon'] : '#';
			?>
			<link rel="shortcut icon" href="<?php echo esc_url($cs_favicon); ?>">
			<?php
		}
    }

}
// Favicon and header code in head tag//
if (!function_exists('cs_footer_settings')) {

    function cs_footer_settings() {
        global $cs_theme_options;
        ?>
      
        <?php
        if (isset($cs_theme_options['analytics'])) {
            echo htmlspecialchars_decode($cs_theme_options['cs_custom_js']);
        }
    }

}

// password protect post/page
if (!function_exists('cs_password_form')) {

    function cs_password_form() {
        global $post, $cs_theme_option;
        $label = 'pwbox-' . ( empty($post->ID) ? rand() : $post->ID );
        $o = '<div class="password_protected">
                <div class="protected-icon"><a href="#"><i class="icon-unlock-alt icon-4x"></i></a></div>
                <h3>' . __("This post is password protected. To view it please enter your password below:", 'uoc') . '</h3>';
        $o .= '<form action="' . esc_url(site_url('wp-login.php?action=postpass', 'login_post')) . '" method="post"><label><input name="post_password" id="' . $label . '" type="password" size="20" /></label><input class="bgcolr" type="submit" name="Submit" value="' . __("Submit", 'uoc') . '" /></form>
            </div>';
        return $o;
    }

}

// change the default query variable start
if (!function_exists('cs_change_query_vars')) {

    function cs_change_query_vars($query) {
        if (is_search() || is_home()) {
            if (empty($_GET['page_id_all']))
                $_GET['page_id_all'] = 1;
            $query->query_vars['paged'] = $_GET['page_id_all'];
            return $query;
        }
    }

}
// Filter shortcode in text areas

if (!function_exists('cs_textarea_filter')) {

    function cs_textarea_filter($content = '') {
        return do_shortcode($content);
    }

}
//    Add Featured/sticky text/icon for sticky posts.

if (!function_exists('cs_featured')) {

    function cs_featured() {
        if (is_sticky()) {
            ?>
            <span class="featured-post"><?php _e('Featured', 'uoc'); ?></span>
            <?php
        }
    }

}
// display post page title
if (!function_exists('cs_post_page_title')) {

    function cs_post_page_title() {
        if (is_author()) {
            global $author;
            $userdata = get_userdata($author);
            if (isset($_GET['action']) && $_GET['action'] == 'detail') {
                echo cs_allow_special_char($userdata->display_name);
            } else {
                echo __('Author', 'uoc') . " " . __('Archives', 'uoc') . ": " . $userdata->display_name;
            }
        } elseif (is_tag() || is_tax('event-tag')) {
            echo __('Tags', 'uoc') . " " . __('Archives', 'uoc') . ": " . single_cat_title('', false);
        } elseif (is_search()) {
            printf(__('Search Results : %s', 'uoc'), '<span>' . get_search_query() . '</span>');
        } elseif (is_day()) {
            printf(__('Daily Archives: %s', 'uoc'), '<span>' . get_the_date() . '</span>');
        } elseif (is_month()) {
            printf(__('Monthly Archives: %s', 'uoc'), '<span>' . get_the_date(_x('F Y', 'monthly archives date format', 'uoc')) . '</span>');
        } elseif (is_year()) {
            printf(__('Yearly Archives: %s', 'uoc'), '<span>' . get_the_date(_x('Y', 'yearly archives date format', 'uoc')) . '</span>');
        } elseif (is_404()) {
            _e('Error 404', 'uoc');
        } elseif (is_home()) {
            _e('Home', 'uoc');
        } elseif (!is_page()) {
            _e('Archives', 'uoc');
        }
    }

}
// If no content, include the "No posts found" function
if (!function_exists('cs_fnc_no_result_found')) {

    function cs_fnc_no_result_found() {
        $is_search = '';
        global $cs_theme_options;
        ?>
      
        <div class="headings-area">
        <h6><?php _e('Suggestions:', 'uoc'); ?></h6>
        <h2><?php printf( __('No pages were found containing %s', 'uoc'), get_search_query() ); ?></h2>
        </div>
        <div class="suggestions">
        <ul>
        <li><?php _e('Make sure all words are spelled correctly', 'uoc'); ?></li>
        <li><?php _e('Wildcard searches (using the asterisk *) are not supported', 'uoc'); ?></li>
        <li><?php _e('Try more general keywords, especially if you are attempting a name', 'uoc'); ?></li>
        </ul>
        </div>
        <div class="cs-search-area">
        <?php
        if (is_search()) :
        
        get_search_form();
        
        endif;
        ?>
        </div>
         <?php
    }

}

if (!function_exists('cs_fnc_advance_result_found')) {

    function cs_fnc_advance_result_found() {
        $is_search = '';
		$cs_course_cate = $_GET['uoc_title'];
        global $cs_theme_options;
        ?>
      
        <div class="headings-area">
    	
        <h2> <?php 
		_e('No pages were found containing', 'uoc');
		echo esc_html($cs_course_cate);
		 ?></h2>
        </div>
        <div class="suggestions">
        <ul>
        <li><?php _e('Make sure all words are spelled correctly', 'uoc'); ?></li>
        <li><?php _e('Wildcard searches (using the asterisk *) are not supported', 'uoc'); ?></li>
        <li><?php _e('Try more general keywords, especially if you are attempting a name', 'uoc'); ?></li>
        </ul>
        </div>
        <div class="cs-search-area page-no-search">
        <?php
        get_search_form();
        
 
        ?>
        </div>
         <?php
    }

}

// Highlight Search Results
function cs_wps_highlight_results($text) {
    if (is_search()) {
        $sr = get_query_var('s');
        $keys = explode(" ", $sr);
        $text = preg_replace('/(' . implode('|', $keys) . ')/iu', '' . $sr . '', $text);
    }
    return $text;
}

add_filter('get_the_excerpt', 'cs_wps_highlight_results');

// Custom function for next previous posts
if (!function_exists('cs_next_prev_custom_links')) {

    function cs_next_prev_custom_links($post_type = 'events') {
        global $post, $wpdb, $cs_theme_options, $cs_xmlObject;
        $previd = $nextid = '';
        $post_type = get_post_type($post->ID);
        $count_posts = wp_count_posts("$post_type")->publish;
        $cs_postlist_args = array(
            'posts_per_page' => -1,
            'order' => 'ASC',
            'post_type' => "$post_type",
        );
        $cs_postlist = get_posts($cs_postlist_args);
        $ids = array();
        foreach ($cs_postlist as $cs_thepost) {
            $ids[] = $cs_thepost->ID;
        }
        $thisindex = array_search($post->ID, $ids);
        if (isset($ids[$thisindex - 1])) {
            $previd = $ids[$thisindex - 1];
        }
        if (isset($ids[$thisindex + 1])) {
            $nextid = $ids[$thisindex + 1];
        }
   /*************************************************************************/  ?>
				<div class="cs-post-pagination">
					<ul class="cs-prev-next">
                    
					<?PHP   if (isset($previd) && !empty($previd)) {?>
                   		 <li><a href="<?php echo esc_url(get_permalink($previd)); ?>"><i class=" icon-arrow-left10"></i></a></li>
                     <?PHP }?>
                        <?php  
						  $cs_prev_link = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : esc_url( home_url('/') );
						?>
                        
                         <li><a href="<?php echo esc_url($cs_prev_link) ?>"><i class=" icon-th"></i></a></li>
					
                    
					<?PHP  if (isset($nextid) && !empty($nextid) && $nextid >= 0) { ?>
                    	<li><a href="<?php echo esc_url(get_permalink($nextid)) ?>"><i class=" icon-arrow-right10"></i></a></li>
                    <?PHP }?>    
					</ul>
				</div>
      <?php	 
	}
  }

/*****************************************************/

  if (!function_exists('cs_related_post')) {
    function cs_related_post( $cs_col = false, $cs_limit = '-1' ) {
		
		
		
		global $post;
		$title_limit = 3;
		$custom_taxterms = '';
		$width  = 250;
		$height = 188;
		$custom_taxterms = wp_get_object_terms( $post->ID, array('category'), array('fields' => 'ids') );
		$args = array(
					'post_type' => 'post',
					'post_status' => 'publish',
					'posts_per_page' => $cs_limit,
					'orderby' => 'DESC',
					'tax_query' => array(
					'relation' => 'OR',
						array(
						  'taxonomy' => 'category',
						  'field' => 'id',
						  'terms' => $custom_taxterms
						)
					),
					'post__not_in' => array ($post->ID),
				);
	
	    
   echo '<div class="cs-related-post row">';
	  echo '<h4 class="col-md-12">';
		_e('Related Blogs','uoc');
		echo '</h4>';
		echo '<div class="cs-blog cs-blog-masnery">';
		
		$custom_query = new WP_Query($args);
		while ($custom_query->have_posts()) : $custom_query->the_post();
		$cs_port_list_gallery = get_post_meta($post->ID, 'cs_port_list_gallery', true);
		if( $cs_port_list_gallery <> '' ) {
			$cs_port_list_gallery = explode(',', $cs_port_list_gallery);
		
			if( is_array($cs_port_list_gallery) && sizeof($cs_port_list_gallery) > 0 ) {
				$img_url = cs_attachment_image_src($cs_port_list_gallery[0], $width, $height);
				//$full_img_url = cs_attachment_image_src($cs_port_list_gallery[0], 0, 0);
			}
		}
			$thumbnail = cs_get_post_img_src($post->ID, $width, $height);
			$full_img_url = cs_get_post_img_src($post->ID, 300, 300);
		?>
	   
                   <div class="col-md-4">
                              <article>
                              <div class="blog-info-sec">
                                 <span class="categories">
                                	
                                      <?php
                                        $categories_list = get_the_term_list(get_the_id(), 'category', '', ', ', '');
											if ($categories_list) {
												echo cs_allow_special_char( $categories_list );
											}
                                        ?>
                                  </span>
                                    
                                    <h4><a href="<?php esc_url(the_permalink()); ?>">
									   
                                       <?php echo wp_trim_words(get_the_title($post->ID), $title_limit, '...'); ?>
                                    
                                     </a></h4>
                                    <ul class="post-options">
                                    <li><time datetime="2011-01-12"><?php echo date_i18n('M d, Y', strtotime(get_the_date())); ?></time></li>
                                    <li><a href="<?php esc_url(the_permalink()); ?>">
                                      <?php $coments = get_comments_number(__('0', 'uoc'), __('1', 'uoc'), __('%', 'uoc'));
                                    	   printf('%s', $coments);
										    _e('Comments', 'uoc'); 
                            		?>
                                    
                                    </a></li>
                                    </ul>
                                </div>
                                
                             <?php if ($thumbnail <> '') { ?>
                                    <div class="cs-media">
                                    
                                    <figure><a href="<?php esc_url(the_permalink()); ?>">
                                    	<img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo cs_get_post_img_title($post->ID); ?>"></a>
                                     <figcaption> 
                                     		<div class="cs-hover">
                                                <ul class="gallery clearfix"></ul>
                                                <ul class="gallery clearfix">
                                                    <li>
                                                        <a href="<?php echo esc_url($full_img_url); ?>" class="cs-search" rel="prettyPhoto"><i class="icon-zoomin3"></i></a>
                                                        <a href="<?php esc_url(the_permalink()); ?>" class="cs-link"><i class="icon-chain"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                      </figcaption>
                                    </figure>
                                    </div>
                               <?php }?>
                                
                              </article>
                        </div>
           
		<?php
		endwhile;
		wp_reset_postdata(); 
		
		 
	 echo "</div>
   </div> ";
 ?>
	
    
    
    	
		
		
<?php 	}
}





if (!function_exists('cs_portfolios_next_prev')) {

    function cs_portfolios_next_prev($post_type = 'portfolios') {
        global $post, $wpdb, $cs_theme_options;
        $previd = $nextid = '';
        $post_type = get_post_type($post->ID);
        $count_posts = wp_count_posts("$post_type")->publish;
        $cs_postlist_args = array(
            'posts_per_page' => -1,
            'order' => 'ASC',
            'post_type' => "$post_type",
        );
        $cs_postlist = get_posts($cs_postlist_args);
        $ids = array();
        foreach ($cs_postlist as $cs_thepost) {
            $ids[] = $cs_thepost->ID;
        }
        $thisindex = array_search($post->ID, $ids);
        if (isset($ids[$thisindex - 1])) {
            $previd = $ids[$thisindex - 1];
        }
        if (isset($ids[$thisindex + 1])) {
            $nextid = $ids[$thisindex + 1];
        }

        echo '<div class="cs-project-pagination"><ul>';
        if (isset($previd) && !empty($previd) && $previd >= 0) {
            ?>
            <li class="prev"><a href="<?php echo esc_url(get_permalink($previd)); ?>"><?php _e('Previous Project', 'uoc') ?></a></li>
            <?php
        }
        if ($previd > 0 || $nextid > 0) {
			
			$cs_prev_link = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : esc_url( home_url('/') );
            echo '<li class="back"><a href="' . esc_url($cs_prev_link) . '"><i class="icon-list8"></i> ' . __('Go Back', 'uoc') . '</a></li>';
        }
        if (isset($nextid) && !empty($nextid)) {
            ?>
            <li class="next"><a href="<?php echo esc_url(get_permalink($nextid)); ?>"><?php _e('Next Project', 'uoc') ?></a></li>
            <?php
        }
        echo '</ul></div>';
    }

}


// Get Google Fonts
function cs_get_google_fonts() {
    $cs_fonts = array("Abel", "Aclonica", "Acme", "Actor", "Advent Pro", "Aldrich", "Allerta", "Allerta Stencil", "Amaranth", "Andika", "Anonymous Pro", "Antic", "Anton", "Arimo", "Armata", "Asap", "Asul",
        "Basic", "Belleza", "Cabin", "Cabin Condensed", "Cagliostro", "Candal", "Cantarell", "Carme", "Chau Philomene One", "Chivo", "Coda Caption", "Comfortaa", "Convergence", "Cousine", "Cuprum", "Days One",
        "Didact Gothic", "Doppio One", "Dorsa", "Dosis", "Droid Sans", "Droid Sans Mono", "Duru Sans", "Economica", "Electrolize", "Exo", "Federo", "Francois One", "Fresca", "Galdeano", "Geo", "Gudea",
        "Hammersmith One", "Homenaje", "Imprima", "Inconsolata", "Inder", "Istok Web", "Jockey One", "Josefin Sans", "Jura", "Karla", "Krona One", "Lato", "Lekton", "Magra", "Mako", "Marmelad", "Marvel",
        "Maven Pro", "Metrophobic", "Michroma", "Molengo", "Montserrat", "Muli", "News Cycle", "Nobile", "Numans", "Nunito", "Open Sans", "Open Sans Condensed", "Orbitron", "Oswald", "Oxygen", "PT Mono",
        "PT Sans", "PT Sans Caption", "PT Sans Narrow", "Paytone One", "Philosopher", "Play", "Pontano Sans", "Port Lligat Sans", "Puritan", "Quantico", "Quattrocento Sans", "Questrial", "Quicksand", "Rationale",
        "Roboto", "Ropa Sans", "Rosario", "Ruda", "Ruluko", "Russo One", "Shanti", "Sigmar One", "Signika", "Signika Negative", "Six Caps", "Snippet", "Spinnaker", "Syncopate", "Telex", "Tenor Sans", "Ubuntu",
        "Ubuntu Condensed", "Ubuntu Mono", "Varela", "Varela Round", "Viga", "Voltaire", "Wire One", "Yanone Kaffeesatz", "Adamina", "Alegreya", "Alegreya SC", "Alice", "Alike", "Alike Angular", "Almendra",
        "Almendra SC", "Amethysta", "Andada", "Antic Didone", "Antic Slab", "Arapey", "Artifika", "Arvo", "Average", "Balthazar", "Belgrano", "Bentham", "Bevan", "Bitter", "Brawler", "Bree Serif", "Buenard",
        "Cambo", "Cantata One", "Cardo", "Caudex", "Copse", "Coustard", "Crete Round", "Crimson Text", "Cutive", "Della Respira", "Droid Serif", "EB Garamond", "Enriqueta", "Esteban", "Fanwood Text", "Fjord One",
        "Gentium Basic", "Gentium Book Basic", "Glegoo", "Goudy Bookletter 1911", "Habibi", "Holtwood One SC", "IM Fell DW Pica", "IM Fell DW Pica SC", "IM Fell Double Pica", "IM Fell Double Pica SC",
        "IM Fell English", "IM Fell English SC", "IM Fell French Canon", "IM Fell French Canon SC", "IM Fell Great Primer", "IM Fell Great Primer SC", "Inika", "Italiana", "Josefin Slab", "Judson", "Junge",
        "Kameron", "Kotta One", "Kreon", "Ledger", "Linden Hill", "Lora", "Lusitana", "Lustria", "Marko One", "Mate", "Mate SC", "Merriweather", "Montaga", "Neuton", "Noticia Text", "Old Standard TT", "Ovo",
        "PT Serif", "PT Serif Caption", "Petrona", "Playfair Display", "Podkova", "Poly", "Port Lligat Slab", "Prata", "Prociono", "Quattrocento", "Radley", "Rokkitt", "Rosarivo", "Simonetta", "Sorts Mill Goudy",
        "Stoke", "Tienne", "Tinos", "Trocchi", "Trykker", "Ultra", "Unna", "Vidaloka", "Volkhov", "Vollkorn", "Abril Fatface", "Aguafina Script", "Aladin", "Alex Brush", "Alfa Slab One", "Allan", "Allura",
        "Amatic SC", "Annie Use Your Telescope", "Arbutus", "Architects Daughter", "Arizonia", "Asset", "Astloch", "Atomic Age", "Aubrey", "Audiowide", "Averia Gruesa Libre", "Averia Libre", "Averia Sans Libre",
        "Averia Serif Libre", "Bad Script", "Bangers", "Baumans", "Berkshire Swash", "Bigshot One", "Bilbo", "Bilbo Swash Caps", "Black Ops One", "Bonbon", "Boogaloo", "Bowlby One", "Bowlby One SC",
        "Bubblegum Sans", "Buda", "Butcherman", "Butterfly Kids", "Cabin Sketch", "Caesar Dressing", "Calligraffitti", "Carter One", "Cedarville Cursive", "Ceviche One", "Changa One", "Chango", "Chelsea Market",
        "Cherry Cream Soda", "Chewy", "Chicle", "Coda", "Codystar", "Coming Soon", "Concert One", "Condiment", "Contrail One", "Cookie", "Corben", "Covered By Your Grace", "Crafty Girls", "Creepster", "Crushed",
        "Damion", "Dancing Script", "Dawning of a New Day", "Delius", "Delius Swash Caps", "Delius Unicase", "Devonshire", "Diplomata", "Diplomata SC", "Dr Sugiyama", "Dynalight", "Eater", "Emblema One",
        "Emilys Candy", "Engagement", "Erica One", "Euphoria Script", "Ewert", "Expletus Sans", "Fascinate", "Fascinate Inline", "Federant", "Felipa", "Flamenco", "Flavors", "Fondamento", "Fontdiner Swanky",
        "Forum", "Fredericka the Great", "Fredoka One", "Frijole", "Fugaz One", "Geostar", "Geostar Fill", "Germania One", "Give You Glory", "Glass Antiqua", "Gloria Hallelujah", "Goblin One", "Gochi Hand",
        "Gorditas", "Graduate", "Gravitas One", "Great Vibes", "Gruppo", "Handlee", "Happy Monkey", "Henny Penny", "Herr Von Muellerhoff", "Homemade Apple", "Iceberg", "Iceland", "Indie Flower", "Irish Grover",
        "Italianno", "Jim Nightshade", "Jolly Lodger", "Julee", "Just Another Hand", "Just Me Again Down Here", "Kaushan Script", "Kelly Slab", "Kenia", "Knewave", "Kranky", "Kristi", "La Belle Aurore",
        "Lancelot", "League Script", "Leckerli One", "Lemon", "Lilita One", "Limelight", "Lobster", "Lobster Two", "Londrina Outline", "Londrina Shadow", "Londrina Sketch", "Londrina Solid",
        "Love Ya Like A Sister", "Loved by the King", "Lovers Quarrel", "Luckiest Guy", "Macondo", "Macondo Swash Caps", "Maiden Orange", "Marck Script", "Meddon", "MedievalSharp", "Medula One", "Megrim",
        "Merienda One", "Metamorphous", "Miltonian", "Miltonian Tattoo", "Miniver", "Miss Fajardose", "Modern Antiqua", "Monofett", "Monoton", "Monsieur La Doulaise", "Montez", "Mountains of Christmas",
        "Mr Bedfort", "Mr Dafoe", "Mr De Haviland", "Mrs Saint Delafield", "Mrs Sheppards", "Mystery Quest", "Neucha", "Niconne", "Nixie One", "Norican", "Nosifer", "Nothing You Could Do", "Nova Cut",
        "Nova Flat", "Nova Mono", "Nova Oval", "Nova Round", "Nova Script", "Nova Slim", "Nova Square", "Oldenburg", "Oleo Script", "Original Surfer", "Over the Rainbow", "Overlock", "Overlock SC", "Pacifico",
        "Parisienne", "Passero One", "Passion One", "Patrick Hand", "Patua One", "Permanent Marker", "Piedra", "Pinyon Script", "Plaster", "Playball", "Poiret One", "Poller One", "Pompiere", "Press Start 2P",
        "Princess Sofia", "Prosto One", "Qwigley", "Raleway", "Rammetto One", "Rancho", "Redressed", "Reenie Beanie", "Revalia", "Ribeye", "Ribeye Marrow", "Righteous", "Rochester", "Rock Salt", "Rouge Script",
        "Ruge Boogie", "Ruslan Display", "Ruthie", "Sail", "Salsa", "Sancreek", "Sansita One", "Sarina", "Satisfy", "Schoolbell", "Seaweed Script", "Sevillana", "Shadows Into Light", "Shadows Into Light Two",
        "Share", "Shojumaru", "Short Stack", "Sirin Stencil", "Slackey", "Smokum", "Smythe", "Sniglet", "Sofia", "Sonsie One", "Special Elite", "Spicy Rice", "Spirax", "Squada One", "Stardos Stencil",
        "Stint Ultra Condensed", "Stint Ultra Expanded", "Sue Ellen Francisco", "Sunshiney", "Supermercado One", "Swanky and Moo Moo", "Tangerine", "The Girl Next Door", "Titan One", "Trade Winds", "Trochut",
        "Tulpen One", "Uncial Antiqua", "UnifrakturCook", "UnifrakturMaguntia", "Unkempt", "Unlock", "VT323", "Vast Shadow", "Vibur", "Voces", "Waiting for the Sunrise", "Wallpoet", "Walter Turncoat",
        "Wellfleet", "Yellowtail", "Yeseva One", "Yesteryear", "Zeyada");
    return $cs_fonts;
}

// enqueue timepicker scripts

function cs_enqueue_timepicker_script() {
    //if(is_admin()){
    wp_enqueue_script('datetimepicker1_js', get_template_directory_uri() . '/include/assets/scripts/jquery_datetimepicker.js', '', '', true);
    wp_enqueue_style('datetimepicker1_css', get_template_directory_uri() . '/include/assets/css/jquery_datetimepicker.css');
    //}
}

add_action('admin_enqueue_scripts', 'cs_my_admin_scripts');

// enqueue admin scripts
function cs_my_admin_scripts() {
    if (isset($_GET['page']) && $_GET['page'] == 'my_plugin_page') {
        wp_enqueue_media();
        wp_register_script('my-admin-js', WP_PLUGIN_URL . '/my-plugin/my-admin.js', array('jquery'));
        wp_enqueue_script('my-admin-js');
    }
}

// register theme menu
function cs_register_my_menus() {
    register_nav_menus(
            array(
                'main-menu' => __('Main Menu', 'uoc'),
				'top-menu' => __('Top Menu', 'uoc'),
                'footer-menu' => __('Footer Menu', 'uoc')
            )
    );
}

add_action('init', 'cs_register_my_menus');

//  Set Post Veiws Start
//  Excerpt Default Length 
function cs_custom_excerpt_length($length) {
    return 200;
}

add_filter('excerpt_length', 'cs_custom_excerpt_length');
// Custom excerpt function 
if (!function_exists('cs_get_the_excerpt')) {

    function cs_get_the_excerpt($charlength = '255', $readmore = 'true', $readmore_text = 'Read More') {
        global $post, $cs_theme_option;

        $excerpt = trim(preg_replace('/<a[^>]*>(.*)<\/a>/iU', '', get_the_excerpt()));

        if (strlen($excerpt) > $charlength) {
            if ($charlength > 0) {
                $excerpt = substr($excerpt, 0, $charlength);
            } else {
                $excerpt = $excerpt;
            }
            if ($readmore == 'true') {
                $more = '.. ';
            } else {
                $more = '...';
            }
            return $excerpt . $more;
        } else {
            return $excerpt;
        }
    }

}


/* Excerpt Read More  */

function cs_excerpt_more($more = '...') {
    return '....';
}

add_filter('excerpt_more', 'cs_excerpt_more');

// Return Seleced
if (!function_exists('cs_selected')) {

    function cs_selected($current, $orignal) {
        if ($current == $orignal) {
            echo 'selected=selected';
        }
    }

}

// page builder element size
if (!function_exists('cs_pb_element_sizes')) {

    function cs_pb_element_sizes($size = '100') {
        $element_size = 'element-size-100';
        if (isset($size) && $size == '') {
            $element_size = 'element-size-100';
        } else {
            $element_size = 'element-size-' . $size;
        }
        return $element_size;
    }

}
if (!function_exists('cs_enable_more_buttons')) {

    function cs_enable_more_buttons($buttons) {

        $buttons[] = 'fontselect';
        $buttons[] = 'fontsizeselect';
        $buttons[] = 'styleselect';
        $buttons[] = 'backcolor';
        $buttons[] = 'newdocument';
        $buttons[] = 'cut';
        $buttons[] = 'copy';
        $buttons[] = 'charmap';
        $buttons[] = 'hr';
        $buttons[] = 'visualaid';
        return $buttons;
    }

    add_filter("mce_buttons_3", "cs_enable_more_buttons");
}
add_action('init', 'cs_deregister_heartbeat', 1);

function cs_deregister_heartbeat() {
    global $pagenow;
    if ('post.php' != $pagenow && 'post-new.php' != $pagenow)
        wp_deregister_script('heartbeat');
}

// Like Counter
if (!function_exists('cs_like_counter')) {

    function cs_like_counter($cs_likes_title = '') {
        $cs_like_counter = '';
        $cs_like_counter = get_post_meta(get_the_id(), "cs_like_counter", true);
        if (!isset($cs_like_counter) or empty($cs_like_counter))
            $cs_like_counter = 0;
        if (isset($_COOKIE["cs_like_counter" . get_the_id()])) {
            ?>
            <a> <i class="icon-heart liked-post"></i><span><?php echo cs_allow_special_char($cs_like_counter . ' ' . $cs_likes_title); ?></span></a> 
        <?php } else { ?>
            <a class="likethis<?php echo get_the_id() ?> cs-btnheart cs-btnpopover" id="like_this<?php echo get_the_id() ?>"  href="javascript:cs_like_counter('<?php echo get_template_directory_uri() ?>',<?php echo get_the_id() ?>,'<?php echo cs_allow_special_char($cs_likes_title); ?>','<?php echo admin_url('admin-ajax.php') ?>')" data-container="body" data-toggle="tooltip" data-placement="top" title="<?php _e('Like This', 'uoc'); ?>"><i class="icon-heart-o"></i><span><?php echo cs_allow_special_char($cs_like_counter . ' ' . $cs_likes_title); ?></span></a>

            <a class="likes likethis" id="you_liked<?php echo get_the_id() ?>" style="display:none;"><i class="icon-heart  liked-post"></i><span class="count-numbers like_counter<?php echo get_the_id() ?>"><?php echo cs_allow_special_char($cs_like_counter . ' ' . $cs_likes_title); ?></span> </a>

            <div id="loading_div<?php echo get_the_id() ?>" style="display:none;"><i class="icon-spinner icon-spin"></i></div>
        <?php
        }
    }

    //likes counter
    add_action('wp_ajax_nopriv_cs_likes_count', 'cs_likes_count');
    add_action('wp_ajax_cs_likes_count', 'cs_likes_count');
}
// Post like counter
if (!function_exists('cs_likes_count')) {

    function cs_likes_count() {
        $cs_like_counter = get_post_meta($_POST['post_id'], "cs_like_counter", true);
        if (!isset($_COOKIE["cs_like_counter" . $_POST['post_id']])) {
            setcookie("cs_like_counter" . $_POST['post_id'], 'true', time() + (10 * 365 * 24 * 60 * 60), '/');
            update_post_meta($_POST['post_id'], 'cs_like_counter', $cs_like_counter + 1);
        }
        $cs_like_counter = get_post_meta($_POST['post_id'], "cs_like_counter", true);
        if (!isset($cs_like_counter) or empty($cs_like_counter))
            $cs_like_counter = 0;
        echo cs_allow_special_char($cs_like_counter);
        die();
    }

}
//Mailchimp
add_action('wp_ajax_nopriv_cs_mailchimp', 'cs_mailchimp');
add_action('wp_ajax_cs_mailchimp', 'cs_mailchimp');

function cs_mailchimp() {
    global $cs_theme_options, $counter;
	
	if( class_exists( 'MailChimp' ) ) {
		$mailchimp_key = '';
		if (isset($cs_theme_options['cs_mailchimp_key'])) {
		   $mailchimp_key = $cs_theme_options['cs_mailchimp_key'];
		}
		
		$email = $_POST['mc_email'];
		if(isset($email) && $email <> "" ){
		
			if (isset($_POST) and ! empty($_POST['cs_list_id']) and $mailchimp_key != '') {
				if ($mailchimp_key <> '') {
					$MailChimp = new MailChimp($mailchimp_key);
				}
				
				$list_id = $_POST['cs_list_id'];
				$result = $MailChimp->call('lists/subscribe', array(
							'id' => $list_id,
							'email' => array('email' => $email),
							'merge_vars' => array(),
							'double_optin' => false,
							'update_existing' => false,
							'replace_interests' => false,
							'send_welcome' => true,
				));
				if ($result <> '') {
					if (isset($result['status']) and $result['status'] == 'error') {
						echo cs_allow_special_char($result['error']);
					} else {
						echo 'Subscribe successfully';
					}
				}
			} else {
				echo 'please set API key';
			}
			
		} else {
			echo 'Enter Email Address';  
		} 
	}
	
	die();
}

//Mailchimp
/**
 * Add TinyMCE to multiple Textareas (usually in backend).
 */
function cs_wp_editor($id = '') {
    ?>
    <script type="text/javascript">
        var fullId = "<?php echo cs_allow_special_char($id); ?>";
        //tinymce.execCommand('mceAddEditor', false, fullId);
        // use wordpress settings
        tinymce.init({
            selector: fullId,
            theme: "modern",
            skin: "lightgray",
            language: "en",
            selector:"#" + fullId,
                    resize: "vertical",
            menubar: false,
            wpautop: true,
            indent: false,
            quicktags: "em,strong,link",
            toolbar1: "bold,italic,strikethrough,bullist,numlist,blockquote,hr,alignleft,aligncenter,alignright,link,unlink",
            //toolbar2:"formatselect,underline,alignjustify,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help",
            tabfocus_elements: ":prev,:next",
            body_class: "id post-type-post post-status-publish post-format-standard",
        });
        //quicktags({id : fullId});
        settings = {
            id: fullId,
            // buttons: 'strong,em,link' 
        }
        quicktags(settings);
      
    </script><?php
}

add_action('wp_ajax_cs_select_editor', 'cs_wp_editor');
//Submit Form
add_action('wp_ajax_nopriv_cs_contact_form_submit', 'cs_contact_form_submit');
add_action('wp_ajax_cs_contact_form_submit', 'cs_contact_form_submit');

//Get attachment id
function cs_get_attachment_id_from_url($attachment_url = '') {
    global $wpdb;
    $attachment_id = false;
    // If there is no url, return.
    if ('' == $attachment_url)
        return;

    // Get the upload directory paths
    $upload_dir_paths = wp_upload_dir();

    if (false !== strpos($attachment_url, $upload_dir_paths['baseurl'])) {

        // If this is the URL of an auto-generated thumbnail, get the URL of the original image
        $attachment_url = preg_replace('/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url);

        // Remove the upload path base directory from the attachment URL
        $attachment_url = str_replace($upload_dir_paths['baseurl'] . '/', '', $attachment_url);

        $attachment_id = $wpdb->get_var($wpdb->prepare("SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url));
    }
    return $attachment_id;
}

// Custom File types allowed
add_filter('upload_mimes', 'cs_custom_upload_mimes');

function cs_custom_upload_mimes($existing_mimes = array()) {
    // add the file extension to the array
    $existing_mimes['woff'] = 'mime/type';
    $existing_mimes['ttf'] = 'mime/type';
    $existing_mimes['svg'] = 'mime/type';
    $existing_mimes['eot'] = 'mime/type';
    return $existing_mimes;
}

// Contact form submit ajax
function cs_contact_form_submit() {
    define('WP_USE_THEMES', false);
    $subject = '';
    $cs_contact_error_msg = '';
    $subject_name = 'Subject';
    foreach ($_REQUEST as $keys => $values) {
        $$keys = $values;
    }

    if (isset($phone) && $phone <> '') {
        $subject_name = 'Phone';
        $subject = $phone;
    }

    $bloginfo = get_bloginfo();
    $subjecteEmail = "(" . $bloginfo . ") Contact Form Received";
    $message = '
            <table width="100%" border="1">
              <tr>
                <td width="100"><strong>' . __('Name:', 'uoc') . '</strong></td>
                <td>' . $contact_name . '</td>
              </tr>
              <tr>
                <td><strong>' . __('Email:', 'uoc') . '</strong></td>
                <td>' . $contact_email . '</td>
              </tr>
              <tr>
                <td><strong>' . $subject_name . ':</strong></td>
                <td>' . $subject . '</td>
              </tr>
              <tr>
                <td><strong>' . __('Message:', 'uoc') . '</strong></td>
                <td>' . $contact_msg . '</td>
              </tr>
              <tr>
                <td><strong>' . __('IP Address:', 'uoc') . '</strong></td>
                <td>' . $_SERVER["REMOTE_ADDR"] . '</td>
              </tr>
            </table>';

    $headers = "From: " . $contact_name . "\r\n";
    $headers .= "Reply-To: " . $contact_email . "\r\n";
    $headers .= "Content-type: text/html; charset=utf-8" . "\r\n";
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $attachments = '';

    if ( mail($cs_contact_email, sanitize_email($subjecteEmail), $message, $headers, '')) {
        $json = array();
        $json['type'] = "success";
        $json['message'] = '<p>' . cs_textarea_filter($cs_contact_succ_msg) . '</p>';
    } else {
        $json['type'] = "error";
        $json['message'] = '<p>' . cs_textarea_filter($cs_contact_error_msg) . '</p>';
    };

    echo json_encode($json);
    die();
}

add_action('wp_ajax_nopriv_cs_quote_form_submit', 'cs_quote_form_submit');
add_action('wp_ajax_cs_quote_form_submit', 'cs_quote_form_submit');

function cs_quote_form_submit() {
    define('WP_USE_THEMES', false);

    $cs_quote_error_msg = '';
    foreach ($_REQUEST as $keys => $values) {
        $$keys = $values;
    }
	
    $bloginfo = get_bloginfo();
    $subjecteEmail = "(" . $bloginfo . ") Quote Form Received";
    $message = '
            <table width="100%" border="1">
              <tr>
                <td width="100"><strong>' . __('Name:', 'uoc') . '</strong></td>
                <td>' . $quote_name . '</td>
              </tr>
              <tr>
                <td><strong>' . __('Email:', 'uoc') . '</strong></td>
                <td>' . $quote_mail . '</td>
              </tr>
              <tr>
                <td><strong>' . __('Mobile Number:', 'uoc') . '</strong></td>
                <td>' . $quote_number . '</td>
              </tr>
              <tr>
                <td><strong>' . __('No of Workers:', 'uoc') . '</strong></td>
                <td>' . $quote_workers . '</td>
              </tr>
			  <tr>
                <td><strong>' . __('Date:', 'uoc') . '</strong></td>
                <td>' . $quote_date . '</td>
              </tr>
			  <tr>
                <td><strong>' . __('Time:', 'uoc') . '</strong></td>
                <td>' . $quote_time . '</td>
              </tr>
			  <tr>
                <td><strong>' . __('Address:', 'uoc') . '</strong></td>
                <td>' . $quote_address . '</td>
              </tr>
			  <tr>
                <td><strong>' . __('Message:', 'uoc') . '</strong></td>
                <td>' . $quote_message . '</td>
              </tr>
              <tr>
                <td><strong>' . __('IP Address:', 'uoc') . '</strong></td>
                <td>' . $_SERVER["REMOTE_ADDR"] . '</td>
              </tr>
            </table>';

    $headers = "From: " . $quote_name . "\r\n";
    $headers .= "Reply-To: " . $quote_mail . "\r\n";
    $headers .= "Content-type: text/html; charset=utf-8" . "\r\n";
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $attachments = '';

    if (wp_mail(sanitize_email($cs_quote_email), sanitize_email($subjecteEmail), $message, $headers, $attachments)) {
        $json = array();
        $json['type'] = "success";
        $json['message'] = '<p>' . cs_textarea_filter($cs_quote_succ_msg) . '</p>';
    } else {
        $json['type'] = "error";
        $json['message'] = '<p>' . cs_textarea_filter($cs_quote_error_msg) . '</p>';
    };

    echo json_encode($json);
    die();
}

 

/* set_error_handler("cs_admin_alert_errors", E_ERROR ^ E_CORE_ERROR ^ E_COMPILE_ERROR ^ E_USER_ERROR ^ E_RECOVERABLE_ERROR ^  E_WARNING ^  E_CORE_WARNING ^ E_COMPILE_WARNING ^ E_USER_WARNING ^ E_NOTICE ^  E_USER_NOTICE ^ E_DEPRECATED    ^  E_USER_DEPRECATED    ^  E_PARSE ); */
/*
 * RevSlider Extend Class 
 */
if (class_exists('RevSlider')) {

    class cs_RevSlider extends RevSlider {

        // Get sliders alias, Title, ID
        public function getAllSliderAliases() {
            $where = "";
            $response = $this->db->fetch(GlobalsRevSlider::$table_sliders, $where, "id");
            $arrAliases = array();
            $slider_array = array();
            foreach ($response as $arrSlider) {
                $arrAliases['id'] = $arrSlider["id"];
                $arrAliases['title'] = $arrSlider["title"];
                $arrAliases['alias'] = $arrSlider["alias"];
                $slider_array[] = $arrAliases;
            }
            return($slider_array);
        }

    }

}


if (!function_exists('cs_custom_widget_title')) {

    function cs_custom_widget_title($title) {
        $title = $title;
        return $title;
    }

}
add_filter('widget_title', 'cs_custom_widget_title');
// count Banner Clicks
if (!function_exists('cs_banner_click_count_plus')) {

    function cs_banner_click_count_plus() {
        $code_id = $_POST['code_id'];
        $cs_banner_click_count = get_option("cs_banner_clicks_" . $code_id);
        $cs_banner_click_count = $cs_banner_click_count <> '' ? $cs_banner_click_count : 0;
        if (!isset($_COOKIE["cs_banner_clicks_" . $code_id])) {
            setcookie("cs_banner_clicks_" . $code_id, 'true', time() + 86400, '/');
            update_option("cs_banner_clicks_" . $code_id, $cs_banner_click_count + 1);
        }
        die(0);
    }

    add_action('wp_ajax_cs_banner_click_count_plus', 'cs_banner_click_count_plus');
    add_action('wp_ajax_nopriv_cs_banner_click_count_plus', 'cs_banner_click_count_plus');
}

// custom pagination start
if (!function_exists('cs_pagination')) {

    function cs_pagination($total_records, $per_page, $qrystr = '', $show_pagination = 'Show Pagination') {
        if ($show_pagination <> 'Show Pagination') {
            return;
        } else if ($total_records < $per_page) {
            return;
        } else {

            $html = '';

            $dot_pre = '';

            $dot_more = '';

            $total_page = 0;
            if ($per_page <> 0)
                $total_page = ceil($total_records / $per_page);
            $page_id_all = 0;
            if (isset($_GET['page_id_all']) && $_GET['page_id_all'] != '') {
                $page_id_all = $_GET['page_id_all'];
            }

            $loop_start = $page_id_all - 2;

            $loop_end = $page_id_all + 2;

            if ($page_id_all < 3) {

                $loop_start = 1;

                if ($total_page < 5)
                    $loop_end = $total_page;
                else
                    $loop_end = 5;
            }

            else if ($page_id_all >= $total_page - 1) {

                if ($total_page < 5)
                    $loop_start = 1;
                else
                    $loop_start = $total_page - 4;

                $loop_end = $total_page;
            }
            $html .= "<div class='col-md-12'><nav class='pagination'><div class='spreater'></div><ul>";
            if ($page_id_all > 1) {
                $html .= "<li class='pgprev'><a href='?page_id_all=" . ($page_id_all - 1) . "$qrystr'  class='icon'><i class=' icon-caret-left'></i></a></li>";
            } else {
                $html .= "<li class='pgprev cs-inactive'><a class='icon'><i class='icon-caret-left'></i></a></li>";
            }

            if ($page_id_all > 3 and $total_page > 5)
                $html .= "<li><a href='?page_id_all=1$qrystr'>1</a></li>";

            if ($page_id_all > 4 and $total_page > 6)
                $html .= "<li> <a>. . .</a> </li>";

            if ($total_page > 1) {

                for ($i = $loop_start; $i <= $loop_end; $i++) {

                    if ($i <> $page_id_all)
                        $html .= "<li><a href='?page_id_all=$i$qrystr'>" . $i . "</a></li>";
                    else
                        $html .= "<li><a class='active'>" . $i . "</a></li>";
                }
            }

            if ($loop_end <> $total_page and $loop_end <> $total_page - 1)
                $html .= "<li> <a>. . .</a> </li>";

            if ($loop_end <> $total_page)
                $html .= "<li><a href='?page_id_all=$total_page$qrystr'>$total_page</a></li>";
            if ($per_page > 0 and $page_id_all < $total_records / $per_page) {

                $html .= "<li class='pgnext'><a class='icon' href='?page_id_all=" . ($page_id_all + 1) . "$qrystr' > <i class='icon-caret-right'></i></a></li>";
            } else {
                $html .= "<li class='pgnext cs-inactive'><a class='icon'><i class='icon-caret-right'></i></a></li>";
            }
            $html .= "</ul><div class='spreater'></div></nav></div>";
            return $html;
        }
    }

}          
// pagination end
// Social Share Function

if (!function_exists('cs_social_share_blog')) {

    function cs_social_share_blog($default_icon = 'false', $title = 'true', $post_social_sharing_text = '') {
        global $cs_theme_options;
        $html = '';
        $twitter = $cs_theme_options['cs_twitter_share'];
        $facebook = $cs_theme_options['cs_facebook_share'];
        $google_plus = $cs_theme_options['cs_google_plus_share'];
        $tumblr = $cs_theme_options['cs_tumblr_share'];
        $dribbble = $cs_theme_options['cs_dribbble_share'];
        $instagram = $cs_theme_options['cs_instagram_share'];
        $share = $cs_theme_options['cs_share_share'];
        $stumbleupon = $cs_theme_options['cs_stumbleupon_share'];
        $youtube = $cs_theme_options['cs_youtube_share'];
        cs_addthis_script_init_method();
        $html = '';
        $path = get_template_directory_uri() . "/include/assets/images/";
        if ($twitter == 'on' or $facebook == 'on' or $google_plus == 'on' or $pinterest == 'on' or $tumblr == 'on' or $dribbble == 'on' or $instagram == 'on' or $share == 'on' or $stumbleupon == 'on' or $youtube == 'on') {
            
			
			    $html .='<ul class="cs-sharepost">';
			 	$html .='<li>';
				if (isset($share) && $share == 'on') {
				$html .='<a class="cs-sharepost-btn cs-more"><i class=" icon-forward8"></i>Share post </a>';
				}
				$html .='<div class="social-media">';
				$html .='<ul>';
				if (isset($facebook) && $facebook == 'on') {
				//$html .='<li><a href="#"><i data-original="facebook" class="icon-facebook7"></i></a></li>';
					$html .='<li><a class="addthis_button_facebook"><i data-original="facebook" class="icon-facebook7"></i></a></li>';
				}
				if (isset($tumblr) && $tumblr == 'on') {
                    $html .='<li><a class="addthis_button_tumblr" data-original-title="Tumblr"><i class="icon-tumblr2"></i></a></li>';
                }
				if (isset($dribbble) && $dribbble == 'on') {
					
              $html .='<li><a class="addthis_button_dribbble" data-original-title="Dribbble"><i class="icon-dribbble2"></i></a></li>';
                }
				if (isset($twitter) && $twitter == 'on') {
				$html .='<li><a class="addthis_button_twitter"><i data-original="twitter" class="icon-twitter6"></i></a></li>';
				}if (isset($google_plus) && $google_plus == 'on') {
				$html .='<li><a class="addthis_button_google"><i data-original="googleplus" class="icon-googleplus7"></i></a></li>';
				}if (isset($instagram) && $instagram == 'on') {
				$html .='<li><a class="addthis_button_instagram"><i data-original="instagram" class="icon-instagram"></i></a></li>';
				}if (isset($youtube) && $youtube == 'on') {
				$html .='<li><a class="addthis_button_youtube"><i data-original="youtube-play" class="icon-youtube-play"></i></a></li>';
				}if (isset($share) && $share == 'on') {
				$html .='<li><a class="addthis_button_compact"><i data-original="plus3" class="icon-plus3"></i></a></li>';
				}
				$html .='</ul>';
				$html .='</div>';
				$html .='</li>';
		 
			$html .=' </ul>'
					;
		  }
		
        echo balanceTags($html, true);
    }
}

if (!function_exists('cs_social_share_event')) {

    function cs_social_share_event($default_icon = 'false', $title = 'true', $post_social_sharing_text = '') {
        global $cs_theme_options;
        $html = '';
        $twitter = $cs_theme_options['cs_twitter_share'];
        $facebook = $cs_theme_options['cs_facebook_share'];
        $google_plus = $cs_theme_options['cs_google_plus_share'];
        $tumblr = $cs_theme_options['cs_tumblr_share'];
        $dribbble = $cs_theme_options['cs_dribbble_share'];
        $instagram = $cs_theme_options['cs_instagram_share'];
        $share = $cs_theme_options['cs_share_share'];
        $stumbleupon = $cs_theme_options['cs_stumbleupon_share'];
        $youtube = $cs_theme_options['cs_youtube_share'];
        cs_addthis_script_init_method();
        $html = '';
        $path = get_template_directory_uri() . "/include/assets/images/";
        if ($twitter == 'on' or $facebook == 'on' or $google_plus == 'on' or $pinterest == 'on' or $tumblr == 'on' or $dribbble == 'on' or $instagram == 'on' or $share == 'on' or $stumbleupon == 'on' or $youtube == 'on') {
            
	 $post_social_sharing_text = 'Share Post';
			$html .='<a class="share-btn">
					<i data-original="plus3" class="icon-share-square-o"></i>' . $post_social_sharing_text . ' </a>';
		 
			$html .='<ul class="cs-sharepost">';
					
		 	if ($default_icon <> '1') {
				
             if (isset($facebook) && $facebook == 'on') {
                   
					$html .='<li><a  class="addthis_button_facebook"><i data-original="facebook" class="icon-facebook7"></i></a></li>';
					
                }
                if (isset($twitter) && $twitter == 'on') {
                   
					  $html .='<li><a class="addthis_button_twitter"><i data-original="twitter" class="icon-twitter6"></i></a></li>';
                }
                if (isset($google_plus) && $google_plus == 'on') {
                   
					$html .='<li><a class="addthis_button_google"><i data-original="googleplus" class="icon-googleplus7"></i></a></li>';
					
                }
                if (isset($tumblr) && $tumblr == 'on') {
                    $html .='<li><a class="addthis_button_tumblr" data-original-title="Tumblr"><i class="icon-tumblr2"></i></a></li>';
                }
                if (isset($dribbble) && $dribbble == 'on') {
                    $html .='<li><a class="addthis_button_dribbble" data-original-title="Dribbble"><i class="icon-dribbble2"></i></a></li>';
                }
                if (isset($instagram) && $instagram == 'on') {
                   
					$html .='<li><a class="addthis_button_instagram"><i data-original="instagram" class="icon-instagram"></i></a></li>';
					
                }
                
                if (isset($youtube) && $youtube == 'on') {
                  
					 $html .='<li><a href="#"><i data-original="youtube-play" class="icon-youtube-play"></i></a></li>';
					
                } 
				 if (isset($share) && $share == 'on') {
				$html .=' <li>
					<a class="cs-more addthis_button_compact">
					<i data-original="plus3" class="icon-share-square-o"></i></a>';
				$html .='</li>'; 
				 }
				
			}
			$html .=' </ul>'
					;
		  }

		
		
        echo balanceTags($html, true);
    }

}

 

// Social network

 if (!function_exists('cs_social_network')) {

    function cs_social_network($icon_type = '', $tooltip = '') {
        global $cs_theme_options;
        $tooltip_data = '';
        if ($icon_type == 'large') {
            $icon = 'icon-2x';
        } else {

            $icon = '';
        }
        if (isset($tooltip) && $tooltip <> '') {
            $tooltip_data = 'data-placement-tooltip="tooltip"';
        }
        if (isset($cs_theme_options['social_net_url']) and count($cs_theme_options['social_net_url']) > 0) {
            $i = 0;
            foreach ($cs_theme_options['social_net_url'] as $val) {

                if ($val != '') {
                    ?>          
                      <li>
                    	<a  
                         style="color:<?php echo cs_allow_special_char($cs_theme_options['social_font_awesome_color'][$i]); ?>;" 
                        class="<?php echo esc_attr($cs_theme_options['social_net_awesome'][$i]); ?> <?php echo esc_attr($icon); ?>"  data-original-title="<?php echo cs_allow_special_char($cs_theme_options['social_net_tooltip'][$i]); ?>" 
                        href="<?php echo esc_url($val); ?>" target="_blank">
                        </a>
                      </li>
                      <?php
                }
                $i++;
            }
        }
    }

}
// social network links
if (!function_exists('cs_social_network_widget')) {

    function cs_social_network_widget($icon_type = '', $tooltip = '') {
        global $cs_theme_option;
        global $cs_theme_option;
        $tooltip_data = '';
        if ($icon_type == 'large') {
            $icon = 'icon-2x';
        } else {

            $icon = '';
        }
        if (isset($tooltip) && $tooltip <> '') {
            $tooltip_data = 'data-placement-tooltip="tooltip"';
        }
        if (isset($cs_theme_option['social_net_url']) and count($cs_theme_option['social_net_url']) > 0) {
            $i = 0;
            foreach ($cs_theme_option['social_net_url'] as $val) {
                ?>
                <?php if ($val != '') { ?>
                    <a class="cs-colrhvr" title="" href="<?php echo esc_url($val); ?>" data-original-title="<?php echo esc_attr($cs_theme_option['social_net_tooltip'][$i]); ?>" data-placement="top" <?php echo balanceTags($tooltip_data, false); ?> target="_blank">
                    <?php if ($cs_theme_option['social_net_awesome'][$i] <> '' && isset($cs_theme_option['social_net_awesome'][$i])) { ?> 

                            <i class="fa <?php echo esc_attr($cs_theme_option['social_net_awesome'][$i]); ?>"></i>
                    <?php } else { ?><img src="<?php echo esc_url($cs_theme_option['social_net_icon_path'][$i]); ?>" alt="<?php echo esc_attr($cs_theme_option['social_net_tooltip'][$i]); ?>" /><?php } ?>
                    </a>
                <?php
                }

                $i++;
            }
        }
    }

}

// Post image attachment function
if (!function_exists('cs_attachment_image_src')) {

    function cs_attachment_image_src($attachment_id, $width, $height) {
        $image_url = wp_get_attachment_image_src((int)$attachment_id, array($width, $height), true);
        if ($image_url[1] == $width and $image_url[2] == $height)
            ;
        else
            $image_url = wp_get_attachment_image_src((int)$attachment_id, "full", true);
        $parts = explode('/uploads/', $image_url[0]);
        if (count($parts) > 1)
            return $image_url[0];
    }

}
// Post image attachment source function
if (!function_exists('cs_get_post_img_src')) {

    function cs_get_post_img_src($post_id, $width, $height) {
        global $post;
        if (has_post_thumbnail()) {
            $image_id = get_post_thumbnail_id($post_id);
            $image_url = wp_get_attachment_image_src($image_id, array($width, $height), true);
            if ($image_url[1] == $width and $image_url[2] == $height) {
                return $image_url[0];
            } else {
                $image_url = wp_get_attachment_image_src($image_id, "full", true);
                return $image_url[0];
            }
        }
    }

}


// Post image attachment source function
if (!function_exists('cs_get_post_img_title')) {
    function cs_get_post_img_title($post_id) {
        global $post;
        if (has_post_thumbnail()) {
            $image_id = get_post_thumbnail_id($post_id);
            $image_title = get_the_title( $image_id );
            if (isset($image_title) and $image_title  <>'') {
                return $image_title;
            } else {
                 return '';
            }
        }
    }

}

// Get Post image attachment
if (!function_exists('cs_get_post_img')) {

    function cs_get_post_img($post_id, $width, $height) {
        $image_id = get_post_thumbnail_id($post_id);
        $image_url = wp_get_attachment_image_src($image_id, array($width, $height), true);
        if ($image_url[1] == $width and $image_url[2] == $height) {
            return get_the_post_thumbnail($post_id, array($width, $height));
        } else {
            return get_the_post_thumbnail($post_id, "full");
        }
    }

}
// Get Main background
if (!function_exists('cs_bg_image')) {

    function cs_bg_image() {

        global $cs_theme_options;
        $cs_bg_image = '';
        if ($cs_theme_options['cs_custom_bgimage'] == "") {
            if (isset($cs_theme_options['cs_bg_image']) && $cs_theme_options['cs_bg_image'] <> '' and $cs_theme_options['cs_bg_image'] <> 'bg0' and $cs_theme_options['cs_bg_image'] <> 'pattern0') {
                $cs_bg_image = get_template_directory_uri() . "/include/assets/images/background/" . $cs_theme_options['cs_bg_image'] . ".png";
            }
        } elseif ($cs_theme_options['cs_custom_bgimage'] <> 'pattern0') {
            $cs_bg_image = $cs_theme_options['cs_custom_bgimage'];
        }
        if ($cs_bg_image <> "") {
            return ' style="background:url(' . $cs_bg_image . ') ' . $cs_theme_options['cs_bgimage_position'] . '"';
        } elseif (isset($cs_theme_options['cs_bg_color']) and $cs_theme_options['cs_bg_color'] <> '') {
            return ' style="background:' . $cs_theme_options['cs_bg_color'] . '"';
        }
    }

}
// Main wrapper class function
if (!function_exists('cs_wrapper_class')) {

    function cs_wrapper_class() {
        global $cs_theme_options;

        if (isset($_POST['cs_layout'])) {

            $_SESSION['lmssess_layout_option'] = $_POST['cs_layout'];
            echo cs_allow_special_char($_SESSION['lmssess_layout_option']);
        } elseif (isset($_SESSION['lmssess_layout_option']) and ! empty($_SESSION['lmssess_layout_option'])) {

            echo cs_allow_special_char($_SESSION['lmssess_layout_option']);
        } else {
            echo cs_allow_special_char($cs_theme_options['cs_layout']);
            $_SESSION['lmssess_layout_option'] = '';
        }
    }

}
// custom sidebar start
$cs_theme_sidebar = get_option('cs_theme_options');
if (isset($cs_theme_sidebar['sidebar']) and ! empty($cs_theme_sidebar['sidebar'])) {
	$cs_theme_options = get_option('cs_theme_options');
    foreach ($cs_theme_sidebar['sidebar'] as $sidebar) {
        $sidebar_id = strtolower(str_replace(' ', '_', $sidebar));
        //foreach ( $parts as $val ) {
		$cs_widget_start = '<div class="widget %2$s">';
		$cs_widget_end = '</div>';

		if( isset($cs_theme_options['cs_footer_widget_sidebar']) && $cs_theme_options['cs_footer_widget_sidebar'] == $sidebar ) {
			
			$cs_widget_start = '<aside class="widget col-md-3 %2$s">';
			$cs_widget_end = '</aside>';
		}
        register_sidebar(array(
            'name' => $sidebar,
            'id' => $sidebar_id,
            'description' => __('This widget will be displayed on right/left side of the page.', 'uoc'),
            'before_widget' => $cs_widget_start,
            'after_widget' => $cs_widget_end,
            'before_title' => '<div class="widget-section-title"><h6>',
            'after_title' => '</h6></div>'
        ));
    }
}
// custom sidebar end
//primary widget
register_sidebar(array(
    'name' => __('Primary Sidebar', 'uoc'),
    'id' => 'sidebar-1',
    'description' => __('Main sidebar that appears on the right.', 'uoc'),
    'before_widget' => '<article class="element-size-100 group widget %2$s">',
    'after_widget' => '</article>',
    'before_title' => '<div class="widget-section-title"><h6>',
    'after_title' => '</h6></div>'
));
/**
 * @footer widget Area
 *
 *
 */
register_sidebar(array(
    'name' => 'Footer Widget',
    'id' => 'footer-widget-1',
    'description' => __('This Widget Show the Content in Footer Area.', 'uoc'),
    'before_widget' => '<aside class="widget col-md-3 %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<div class="widget-section-title"><h4>',
    'after_title' => '</h4></div>'
));

if (!function_exists('cs_get_sidebar_id')) :

    function cs_get_sidebar_id( $sidebar ) {
		$sidebar_id = strtolower(str_replace(' ', '_', $sidebar));
		return $sidebar_id;
	}
endif;	


add_filter('comment_reply_link', 'replace_reply_link_class');
function replace_reply_link_class($class){
    $class = str_replace("class='comment-reply-link", "class='comment-reply-link comment-reply", $class);
    return $class;
}
		
if (!function_exists('cs_comment')) :

    /**
     * Template for comments and pingbacks.
     *
     * To override this walker in a child theme without modifying the comments template
     * simply create your own cs_comment(), and that function will be used instead.
     *
     * Used as a callback by wp_list_comments() for displaying the comments.
     *
     */
    function cs_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        $args['reply_text'] = '<i class="icon-mail-forward"></i>'.__('<span>Reply</span>', 'uoc');
        $args['before'] = '';
        switch ($comment->comment_type) :
            case '' :
                ?>
               <li id="li-comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
                  <div class="thumblist" id="comment-<?php comment_ID(); ?>">
                    <figure> <a href=""><?php echo get_avatar($comment, 40); ?></a> </figure>
                      <div class="cs-text-box">
                        <header><h6><?php comment_author(); ?></h6>
                         
                         <time datetime="2011-01-12"><?php echo get_comment_date() . ' ' . get_comment_time(); ?></time> 
                          <?php  comment_reply_link(array_merge($args, array('depth' => $depth))); ?>
                            
                        </header>
                        <?php comment_text(); ?>
                    </div>
                  </div>
 <?php
                break;
            case 'pingback' :
            case 'trackback' :
                ?>
                <li class="post pingback">
                    <p><?php comment_author_link(); ?><?php edit_comment_link(__('Edit', 'uoc'), ' '); ?></p>
                <?php
                break;
        endswitch;
    }

endif;

/* Under Construction Page */

if (!function_exists('cs_under_construction')) {

    function cs_under_construction() {
		    get_header();
        global $cs_theme_options, $post, $cs_uc_options;
        $cs_uc_options = get_option('cs_theme_options');
        if (isset($post)) {
            $post_name = $post->post_name;
        } else {
            $post_name = '';
        }
        $cs_maintenance_page_switch = isset($cs_uc_options['cs_maintenance_page_switch']) ? $cs_uc_options['cs_maintenance_page_switch'] : 'off';
        if (($cs_maintenance_page_switch == "on" and ! (is_user_logged_in())) or $post_name == "pf-under-construction") {
            ?>        
                <script>
                    $ = jQuery;
                    jQuery(function ($) {
                        $('#underconstrucion').css({'height': (($(window).height()) - 0) + 'px'});

                        $(window).resize(function () {
                            $('#underconstrucion').css({'height': (($(window).height()) - 0) + 'px'});
                        });
                    });
                </script>
                 <div class="wrapper wrapper_boxed">

    <!--// Main Header //-->
    <header id="main-header">
         
      </header>
      <!--// Main Header //-->
      
      <main id="main-content">
      <div class="main-section">
      <div class="container">
        <div class="row">
          <div class="page-section">
            <div class="container">
              <div class="row">
                <div class="under-holder">
                  <div class="col-md-12">
                    <div class="under-wrapp">
                      <div class="cons-icon-area">                                     
           			 <?php
							if (isset($cs_uc_options['cs_maintenance_logo_switch']) and $cs_uc_options['cs_maintenance_logo_switch'] == "on") {
								
								if (isset($cs_uc_options['cs_maintenance_custom_logo'])) {
									echo '<a href="' .esc_url( home_url('/')) . '"><img src="' . esc_url($cs_uc_options['cs_maintenance_custom_logo']) . '" alt="Under maintenance" /></a>';
								} else {
									cs_logo();
								}
							
							} else {
								echo '<a href="' . esc_url( home_url('/')) . '"><i class="icon-cog3"></i></a>';
							}
           			 ?>
 </div>

                                                <!-- Cons Text -->
                                               
                    <div class="cons-text-wrapp">
                    <?php
                    if ($cs_uc_options['cs_maintenance_text']) {
                    echo stripslashes(htmlspecialchars_decode($cs_uc_options['cs_maintenance_text']));
                    } 
                    ?>
                    </div>
                    <div class="cs-spreater">
                    <div class="cs-divider-style"></div>
                    </div>
                    <!-- Cons Text ENd -->
                    <!-- Countdown -->
                    <?php
                    $launch_date = trim($cs_uc_options['cs_launch_date']);
                    $launch_date = str_replace('/', '-', $launch_date);
                    $year = date("Y", strtotime($launch_date));
                    $month = date_i18n("m", strtotime($launch_date));
                    $month_event_c = date_i18n("M", strtotime($launch_date));
                    $day = date_i18n("d", strtotime($launch_date));
                    $time_left = date_i18n("H,i,s", strtotime($launch_date));
													?>
                  <script type="text/javascript" src="<?php echo esc_js(get_template_directory_uri() . '/assets/scripts/jquery.countdown.js'); ?>"></script>
				  <script>
                       jQuery(function () {
                           var austDay = new Date();
                           // austDay = new Date(austDay.getFullYear() + 1, 1 - 1, 26);
                           austDay = new Date(<?php echo esc_js($year); ?>,<?php echo esc_js($month); ?> - 1,<?php echo esc_js($day); ?>);
                           jQuery('#countdown_underconstruction').countdown({
                               until: austDay,
                               format: 'wdhms',
                               layout: '<div class="main-digit-wrapp has-bg1"><span class="digit-wrapp"><span class="cs-digit">{d10}</span><span class="cs-digit">{d1}</span></span><span class="countdown-period">days</span></div>' +
                                       '<div class="main-digit-wrapp has-bg2"><span class="digit-wrapp"><span class="cs-digit">{h10}</span><span class="cs-digit">{h1}</span></span><span class="countdown-period">hours</span></div>' +
                                       '<div class="main-digit-wrapp has-bg3"><span class="digit-wrapp"><span class="cs-digit">{m10}</span><span class="cs-digit">{m1}</span></span><span class="countdown-period">minutes</span></div>' +
                                       '<div class="main-digit-wrapp has-bg4"><span class="digit-wrapp"><span class="cs-digit">{s10}</span><span class="cs-digit">{s1}</span></span><span class="countdown-period">seconds</span></div>'
                           });
                       });
                                                </script>
                                       <div id="countdownwrapp">
                                                    <div id="countdown_underconstruction"></div>

                                                </div>
<?php  
if ($cs_uc_options['cs_maintenance_logo_switch']=='on') { ?>

<div class="cs-social-media">
<ul>
<?php cs_social_network();?>
</ul>
</div>

<?php } ?>  
                   
                  </div>
                </div>
              </div>
            </div>
            </div>
          </div>
        </div>
       
      </div>
    </div>
    </main>

      <!--// Footer //-->
      
      <!--// Footer //-->

    <div class="clear"></div>
    </div>


                    <?php
                    die();
                }
            }

        }
		
		
if ( ! function_exists( 'cs_footer_custom_mailchimp' ) ) {
	function cs_footer_custom_mailchimp(){
		global $cs_theme_options,$counter;  
		
		if( function_exists('cs_custom_mailchimp') ) {  
			echo cs_custom_mailchimp(); 
		}
		           
	}
}


// breadcrumb function
        if (!function_exists('cs_breadcrumbs')) {

            function cs_breadcrumbs() {
                global $wp_query, $cs_theme_options, $post;
                /* === OPTIONS === */
                $text['home'] = '<i class="icon-home"></i> ' . __('Home', 'uoc'); // text for the 'Home' link
                $text['category'] = '%s'; // text for a category page
                $text['search'] = '%s'; // text for a search results page
                $text['tag'] = '%s'; // text for a tag page
                $text['author'] = '%s'; // text for an author page
                $text['404'] = 'Error 404'; // text for the 404 page

                $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
                $showOnHome = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
                $delimiter = ''; // delimiter between crumbs
                $before = '<li class="active">'; // tag before the current crumb
                $after = '</li>'; // tag after the current crumb
                /* === END OF OPTIONS === */
                $current_page = __('Current Page', 'uoc');
                $homeLink = esc_url( home_url('/') ) . '/';
                $linkBefore = '<li>';
                $linkAfter = '</li>';
                $linkAttr = '';
                $link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;
                $linkhome = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;

                if (is_home() || is_front_page()) {

                    if ($showOnHome == "1")
                        echo '<div class="breadcrumbs page-title-align-center"><ul>' . $before . '<a href="' . esc_url( $homeLink ) . '">' . $text['home'] . '</a>' . $after . '</ul></div>';
                } else {
                    echo '<nav class="breadcrumbs"><ul>' . sprintf($linkhome, $homeLink, $text['home']) . $delimiter;
                    if (is_category()) {
                        $thisCat = get_category(get_query_var('cat'), false);
                        if ($thisCat->parent != 0) {
                            $cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
                            $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                            $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                            echo esc_attr($cats);
                        }
                        echo cs_allow_special_char($before) . sprintf($text['category'], single_cat_title('', false)) . cs_allow_special_char($after);
                    } elseif (is_search()) {

                        echo cs_allow_special_char($before) . sprintf($text['search'], get_search_query()) . $after;
                    } elseif (is_day()) {

                        echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
                        echo sprintf($link, get_month_link(get_the_time('Y'), get_the_time('m')), get_the_time('F')) . $delimiter;
                        echo cs_allow_special_char($before) . get_the_time('d') . $after;
                    } elseif (is_month()) {

                        echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
                        echo cs_allow_special_char($before) . get_the_time('F') . $after;
                    } elseif (is_year()) {

                        echo cs_allow_special_char($before) . get_the_time('Y') . $after;
                    } elseif (is_single() && !is_attachment()) {

                        if (function_exists("is_shop") && get_post_type() == 'product') {
                            $cs_shop_page_id = woocommerce_get_page_id('shop');
                            $current_page = get_the_title(get_the_id());
                            $cs_shop_page = "<li><a href='" . esc_url(get_permalink($cs_shop_page_id)) . "'>" . get_the_title($cs_shop_page_id) . "</a></li>";
                            echo cs_allow_special_char($cs_shop_page);
                            if ($showCurrent == 1)
                                echo cs_allow_special_char($before) . $current_page . $after;
                        }
                        else if (get_post_type() != 'post') {
                            $post_type = get_post_type_object(get_post_type());
                            $slug = $post_type->rewrite;
                            printf($link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
                            if ($showCurrent == 1)
                                echo cs_allow_special_char($delimiter) . $before . $current_page . $after;
                        } else {

                            $cat = get_the_category();
                            $cat = $cat[0];
                            $cats = get_category_parents($cat, TRUE, $delimiter);
                            if ($showCurrent == 0)
                                $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
                            $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
                            $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
                            echo cs_allow_special_char($cats);

                            if ($showCurrent == 1)
                                echo cs_allow_special_char($before) . $current_page . $after;
                        }
                    } elseif (!is_single() && !is_page() && get_post_type() <> '' && get_post_type() != 'post' && !is_404()) {

                        $post_type = get_post_type_object(get_post_type());
                        echo cs_allow_special_char($before) . $post_type->labels->singular_name . $after;
                    } elseif (isset($wp_query->query_vars['taxonomy']) && !empty($wp_query->query_vars['taxonomy'])) {

                        $taxonomy = $taxonomy_category = '';
                        $taxonomy = $wp_query->query_vars['taxonomy'];
                        echo cs_allow_special_char($before) . $wp_query->query_vars[$taxonomy] . $after;
                    } elseif (is_page() && !$post->post_parent) {

                        if ($showCurrent == 1)
                            echo cs_allow_special_char($before) . get_the_title() . $after;
                    } elseif (is_page() && $post->post_parent) {
						
                        $parent_id = $post->post_parent;
                        $breadcrumbs = array();
                        while ($parent_id) {
                            $page = get_page($parent_id);
                            $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
                            $parent_id = $page->post_parent;
                        }
                        $breadcrumbs = array_reverse($breadcrumbs);
                        for ($i = 0; $i < count($breadcrumbs); $i++) {
                            echo cs_allow_special_char($breadcrumbs[$i]);
                            if ($i != count($breadcrumbs) - 1)
								echo cs_allow_special_char($delimiter);
                        }
                        if ($showCurrent == 1)
                            echo cs_allow_special_char($delimiter . $before . get_the_title() . $after);
                    } elseif (is_tag()) {

                        echo cs_allow_special_char($before) . sprintf($text['tag'], single_tag_title('', false)) . $after;
                    } elseif (is_author()) {

                        global $author;
                        $userdata = get_userdata($author);
                        echo cs_allow_special_char($before) . sprintf($text['author'], $userdata->display_name) . $after;
                    } elseif (is_404()) {

                        echo cs_allow_special_char($before) . $text['404'] . $after;
                    }
                    echo '</ul></nav>';
                }
            }

        }
        /**
         * @Footer Logo 
         *
         *
         */
        if (!function_exists('cs_footer_logo')) {

            function cs_footer_logo() {
                global $cs_theme_options;
                $logo = $cs_theme_options['cs_footer_logo'];
                $tripadvisor_logo_link = $cs_theme_options['cs_tripadvisor_logo_link'];
                if ($logo <> '') {
                     echo '<a href="' . esc_url($tripadvisor_logo_link) . '" class="footer-logo">
              				<img src="' . esc_url($logo) . '" alt="' . get_bloginfo('name') . '">
              		 	  </a>';
				}
            }

        }

        if (!function_exists('cs_next_prev_post')) {

            function cs_next_prev_post() {
                global $post;
                posts_nav_link();
                // Don't print empty markup if there's nowhere to navigate.
                $previous = ( is_attachment() ) ? get_post($post->post_parent) : get_adjacent_post(false, '', true);
                $next = get_adjacent_post(false, '', false);
                if (!$next && !$previous)
                    return;
                ?>
            <aside class="cs-post-sharebtn">
            <?php
            previous_posts_link('%link', '<i class="icon-angle-left"></i>');
            next_posts_link('%link', '<i class="icon-angle-right"></i>');
            ?>
            </aside>
            <?php
        }

    }
	
	
// Location Search Google map
if ( ! function_exists( 'cs_enqueue_location_gmap_script' ) ) {
    function cs_enqueue_location_gmap_script(){
        wp_enqueue_script('jquery.googleapis_js', 'http://maps.googleapis.com/maps/api/js?sensor=false&libraries=places', '', '', true);
        wp_enqueue_script('jquery.gmaps-latlon-picker_js', get_template_directory_uri() . '/include/assets/scripts/jquery_gmaps_latlon_picker.js', '', '', true);
    }
}

function cs_include_file( $file_path = '' ) {
	
	if( $file_path != '' ) {
    	require_once $file_path;
	}
}
