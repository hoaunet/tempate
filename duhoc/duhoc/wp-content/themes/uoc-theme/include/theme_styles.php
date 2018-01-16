<?php
header("Content-type: text/css; charset: UTF-8");
header("Cache-Control: must-revalidate");

$absolute_path = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
$wp_load = $absolute_path[0] . 'wp-load.php';

require_once $wp_load ;

global $post;

if( get_option('cs_theme_options') ) {
	$cs_theme_options = get_option('cs_theme_options');
} else {
	$cs_theme_options = theme_default_options();
}

$cs_theme_color = $cs_theme_options['cs_theme_color'];
$cs_second_theme_color = isset($cs_theme_options['cs_second_theme_color']) ? $cs_theme_options['cs_second_theme_color'] : '';
$sub_header_border_color = isset($cs_theme_options['cs_sub_header_border_color']) ? $cs_theme_options['cs_sub_header_border_color'] : '';
$main_header_border_color = isset($cs_theme_options['cs_header_border_color']) ? $cs_theme_options['cs_header_border_color'] : '';        
$page_header_style = '';
$page_header_border_colr = '';
$page_subheader_border_color = '';

if(is_page() || is_single()){
	$cs_post_type = get_post_type($post->ID);
	switch($cs_post_type){
		case 'product':
			$post_type_meta = 'product';
			break;
		default:
			$post_type_meta = 'cs_full_data';
	}          
	$cs_page_bulider = get_post_meta($post->ID, "$post_type_meta", true);  
	if(isset($cs_page_bulider) and $cs_page_bulider <> ''){
		$page_header_style = isset($cs_page_bulider['cs_header_banner_style']) ? $cs_page_bulider['cs_header_banner_style'] : '';
		$page_header_border_colr = isset($cs_page_bulider['cs_page_main_header_border_color']) ? $cs_page_bulider['cs_page_main_header_border_color'] : '';
		$page_subheader_border_color = isset($cs_page_bulider['cs_page_subheader_border_color']) ? $cs_page_bulider['cs_page_subheader_border_color'] : '';
	}
}
?>
/*!
* Theme Color */
.cscolor,.cs-hovercolor:hover,/* Widget */.widget ul li a:hover, .widget_cetegorie ul li:hover a:before, .widget_list ul li:hover a:before, .widget_list ul li:hover a, .widget-online-poll .inner-sec ul li:hover a, .widget ul li a:hover:before,
.widget_nav_menu ul li:hover a, .widget_pages ul li a:hover, .cs-course-table .content .active .title-bar>ul>li:first-child,
.cs-course-detail .cs-features i, .cs-document-list li .icon i, .cs-tabs .tab-content ul li i, .cs-tabs .tab-nav .active a, .widget_tabs .tab-nav li.active a,
/*Event*/.event-timeline article:before,
/*Pages*/ .page-not-found h1, .cs-search-results .text a, /*Contect Us*/.cs-contact-info ul li i, .cs-opening ul li .timehoure .time-start i, .under-wrapp .cons-text-wrapp h1 span,
.is-countdown .main-digit-wrapp .cs-digit, .cs-tabs.box .nav-tabs li.active a, .panel-group.cs-default.simple .panel-heading a, .cs-list .cs-linked-list li.active a,
/*Event*/.event-timeline article:before, 
/* pagination */.pagination li a:hover,/* Cs Blog */ .cs-blog article:hover h2 a, .cs-thumb-post ul li a:hover, .cs-blog-masnery article:hover h4 a, .cs-blog article .blog-info-sec .categories a:hover, .cs-tags ul li a:hover,
.cs-course-table .content .active .title-bar>ul>li:first-child,
.cs-list .cs-default .panel-title a,
/* Widget */.widget_cetegorie ul li:hover a,.widget_cetegorie ul li:hover a:before,.cs-newslist article:hover h4 a,
.cs-gallery-nav li a:hover,.cs-gallery-nav li.active a,.cat-multicolor ul li:hover a:before,.cs-campunews ul li:hover .cs-campus-info h6 a, .news-ticker .flex-direction-nav li a:hover i
, .cs-custom-nav .owl-nav .owl-prev:hover i, .cs-custom-nav .owl-nav .owl-next:hover i, .cs-gallery ul li h6 a:hover, .cs-filterable .cs-views li:hover i,
.cs-team-slider .flex-direction-nav li a:hover, .testimonial-slider .flex-direction-nav li a:hover, .cs-detail-area .address-box .price-box a:hover, .grid-filter li a:hover, .events-listing .text h2 a:hover  , .cs-courses.listing-view article:hover h2 a , .active  article:hover .cs-text h2 , .element-size-33 .cs-services:hover .text h4, .widget_timing .timing-details li time:before, .loader, .cs-filterable .cs-views li.active i{
 color:<?php echo cs_allow_special_char( $cs_theme_color );
?> !important;
}
/*!
* Theme Background Color */
.csbg-color,.csbg-hovercolor:hover,/* Header */.top-nav ul li a:hover,.main-nav,/* NewsLatter */.newsletter-from input[type="submit"],
/* MainBanner */.flexslider .flex-pauseplay:hover,.flexslider .flex-direction-nav a:hover,/* Ticker */.ticker-title, .cs-courses.listing-view article figure .course-num:after,
.cs-course-table .head, .cs-tabs .tab-nav li.active:after, .widget_tag_cloud .cs-tags ul li a:hover,
/*Event*/.date-time,
/*Pages*/ .page-no-search .cs-search-area input[type="submit"], .cs-plain-form input[type="submit"], .cs-tabs.box .nav-tabs li.active a:before, .cs-list .cs-linked-list li.active i,
.cs-list .panel-heading a:before, .main-filter .question-btn, .cs-answer-list .back-top-btn,
/*Event*/.date-time,/* pagination */ .pagination li a:before, .cs-attachment ul li a:hover figure, .thumblist .comment-reply:hover,
/* Widget */.widget-online-poll .inner-sec ul li:hover a:before, .widget-calender table .day.active a, .responsive-calendar .day a:hover,
/* Ticker */.ticker-title, .cs-courses.listing-view article figure .course-num:after,
.cs-course-table .head, .cs-tabs .tab-nav li.active:after, .widget_tag_cloud .tagcloud a:hover, .cs-blog article figure figcaption .cs-hover a:hover,
/* Header */.top-nav ul li a:hover,.main-nav,/* NewsLatter */.newsletter-from input[type="submit"],
/* MainBanner */.flexslider .flex-pauseplay:hover,.flexslider .flex-direction-nav a:hover,/* Ticker */.ticker-title,
.search-course ul li input[type="submit"], .cs-main-filterable .cs-filter-nav li a.active, .cs-post-pagination .cs-prev-next li:hover, #backtop:hover, .cs-courses.listing-view .course-info .courses-btn a:hover, .cs-document-list li:hover ,  .event-editor .socialmedia .add-calender , .share-btn  , .text-background-left .text-button-plain:hover , .text-background-right .text-button-plain:hover , .pricing-page .price-button .upgrate:hover , .fullbackground-gray  .get-enrole-button  .get-enrole:hover,
.widget.widget_search form label input[type="submit"], .loader::before, .loader::after, .comment-respond input[type="submit"]{
    background-color:<?php echo cs_allow_special_char($cs_theme_color); ?> !important;
}

/*!
* Theme Border Color */
.csborder-color,.csborder-hovercolor:hover,.bottom-footer , .event-editor .socialmedia .add-calender , .share-btn , .text-background-right .text-button-plain:hover , .text-background-left  .text-button-plain:hover , .pricing-page .price-button .upgrate:hover , .fullbackground-gray  .get-enrole-button  .get-enrole:hover{
    border-color:<?php echo cs_allow_special_char($cs_theme_color); ?> !important;
}
.events-minimal:hover,.widget.event-calendar .eventsCalendar-list-wrap,.cs-tabs.vertical .nav-tabs .active a:before {
    border-left-color:<?php echo cs_allow_special_char($cs_theme_color);
?> !important;
}

.cs-blog-grid .owl-controls .owl-prev:hover,
.cs-blog-grid .owl-controls .owl-next:hover{
    border-top-color:<?php echo cs_allow_special_char($cs_theme_color);
?> !important;
}

<?php
if((is_page() || is_single()) and ($page_header_style == 'breadcrumb_header' and $page_subheader_border_color <> '')){
    ?>
    .breadcrumb-sec {
        border-top: 1px solid <?php echo cs_allow_special_char($page_subheader_border_color); ?>;
        border-bottom: 1px solid <?php echo cs_allow_special_char($page_subheader_border_color); ?>;
    }
    <?php
}
else{
    if($sub_header_border_color <> ''){
    ?>
        .breadcrumb-sec {
            border-top: 1px solid <?php echo cs_allow_special_char($sub_header_border_color); ?>;
            border-bottom: 1px solid <?php echo cs_allow_special_char($sub_header_border_color); ?>;
        }
    <?php
    }
}

if((is_page() || is_single()) and ($page_header_style == 'no-header' and $page_header_border_colr <> '')){
    ?>
    #main-header {
        border-bottom: 1px solid <?php echo cs_allow_special_char($page_header_border_colr); ?>;
    }
    <?php
}
else{
    if(isset($cs_theme_options['cs_default_header']) and $cs_theme_options['cs_default_header'] == 'No sub Header'){
        if($main_header_border_color <> ''){
        ?>
            #main-header {
                border-bottom: 1px solid <?php echo cs_allow_special_char($main_header_border_color); ?>;
            }
        <?php
        }
    }
}

/* 
 * @Set Header color Css
 *
 */

$cs_header_bgcolor = (isset($cs_theme_options['cs_header_bgcolor']) and $cs_theme_options['cs_header_bgcolor']<>'') ? $cs_theme_options['cs_header_bgcolor']: '';

$cs_nav_bgcolor = (isset($cs_theme_options['cs_nav_bgcolor']) and $cs_theme_options['cs_nav_bgcolor']<>'') ? $cs_theme_options['cs_nav_bgcolor']: '';

$cs_menu_color = (isset($cs_theme_options['cs_menu_color']) and $cs_theme_options['cs_menu_color']<>'') ? $cs_theme_options['cs_menu_color']:'';

$cs_menu_active_color = (isset($cs_theme_options['cs_menu_active_color']) and $cs_theme_options['cs_menu_active_color']<>'') ? $cs_theme_options['cs_menu_active_color']: '';

$cs_submenu_bgcolor = (isset($cs_theme_options['cs_submenu_bgcolor']) and $cs_theme_options['cs_submenu_bgcolor']<>'' ) ? $cs_theme_options['cs_submenu_bgcolor']: '';

$cs_submenu_color = (isset($cs_theme_options['cs_submenu_color']) and $cs_theme_options['cs_submenu_color']<>'') ? $cs_theme_options['cs_submenu_color']: '';

$cs_submenu_hover_color = (isset($cs_theme_options['cs_submenu_hover_color']) and $cs_theme_options['cs_submenu_hover_color']<>'') ? $cs_theme_options['cs_submenu_hover_color']: '';

$cs_topstrip_bgcolor = (isset($cs_theme_options['cs_topstrip_bgcolor']) and $cs_theme_options['cs_topstrip_bgcolor']<>'') ? $cs_theme_options['cs_topstrip_bgcolor']: '';

$cs_topstrip_text_color = (isset($cs_theme_options['cs_topstrip_text_color']) and $cs_theme_options['cs_topstrip_text_color']<>'') ? $cs_theme_options['cs_topstrip_text_color']: '';

$cs_topstrip_link_color = (isset($cs_theme_options['cs_topstrip_link_color']) and $cs_theme_options['cs_topstrip_link_color']<>'') ? $cs_theme_options['cs_topstrip_link_color']: '';

$cs_menu_activ_bg = (isset($cs_theme_options['cs_theme_color'])) ? $cs_theme_options['cs_theme_color']: '';

/* logo margins*/
$cs_logo_margint = (isset($cs_theme_options['cs_logo_margint']) and  $cs_theme_options['cs_logo_margint'] <> '') ? $cs_theme_options['cs_logo_margint']: '0';
$cs_logo_marginb = (isset($cs_theme_options['cs_logo_marginb']) and  $cs_theme_options['cs_logo_marginb'] <> '') ? $cs_theme_options['cs_logo_marginb']: '0';

$cs_logo_marginr = (isset($cs_theme_options['cs_logo_marginr']) and  $cs_theme_options['cs_logo_marginr'] <> '') ? $cs_theme_options['cs_logo_marginr']: '0';
$cs_logo_marginl = (isset($cs_theme_options['cs_logo_marginl']) and  $cs_theme_options['cs_logo_marginl'] <> '') ? $cs_theme_options['cs_logo_marginl']: '0';

/* font family */
$cs_content_font = (isset($cs_theme_options['cs_content_font'])) ? $cs_theme_options['cs_content_font']: '';
$cs_content_font_att = (isset($cs_theme_options['cs_content_font_att'])) ? $cs_theme_options['cs_content_font_att']: '';

$cs_mainmenu_font = (isset($cs_theme_options['cs_mainmenu_font'])) ? $cs_theme_options['cs_mainmenu_font']: '';
$cs_mainmenu_font_att = (isset($cs_theme_options['cs_mainmenu_font_att'])) ? $cs_theme_options['cs_mainmenu_font_att']: '';

$cs_heading_font = (isset($cs_theme_options['cs_heading_font'])) ? $cs_theme_options['cs_heading_font']: '';
$cs_heading_font_att = (isset($cs_theme_options['cs_heading_font_att'])) ? $cs_theme_options['cs_heading_font_att']: '';

$cs_widget_heading_font = (isset($cs_theme_options['cs_widget_heading_font'])) ? $cs_theme_options['cs_widget_heading_font']: '';
$cs_widget_heading_font_att = (isset($cs_theme_options['cs_widget_heading_font_att'])) ? $cs_theme_options['cs_widget_heading_font_att']: '';

// setting content fonts
$cs_content_fonts = preg_split('#(?<=\d)(?=[a-z])#i', $cs_content_font_att);

$cs_content_font_atts = cs_get_font_att_array($cs_content_fonts);

// setting main menu fonts
$cs_mainmenu_fonts = preg_split('#(?<=\d)(?=[a-z])#i', $cs_mainmenu_font_att);

$cs_mainmenu_font_atts = cs_get_font_att_array($cs_mainmenu_fonts);

// setting heading fonts
$cs_heading_fonts = preg_split('#(?<=\d)(?=[a-z])#i', $cs_heading_font_att);

$cs_heading_font_atts = cs_get_font_att_array($cs_heading_fonts);

// setting widget heading fonts
$cs_widget_heading_fonts = preg_split('#(?<=\d)(?=[a-z])#i', $cs_widget_heading_font_att);

$cs_widget_heading_font_atts = cs_get_font_att_array($cs_widget_heading_fonts);
 
/* font size */
$cs_content_size = (isset($cs_theme_options['cs_content_size'])) ? $cs_theme_options['cs_content_size']: '';
$cs_mainmenu_size = (isset($cs_theme_options['cs_mainmenu_size'])) ? $cs_theme_options['cs_mainmenu_size']: '';
$cs_heading_1_size = (isset($cs_theme_options['cs_heading_1_size'])) ? $cs_theme_options['cs_heading_1_size']: '';
$cs_heading_2_size = (isset($cs_theme_options['cs_heading_2_size'])) ? $cs_theme_options['cs_heading_2_size']: '';
$cs_heading_3_size = (isset($cs_theme_options['cs_heading_3_size'])) ? $cs_theme_options['cs_heading_3_size']: '';
$cs_heading_4_size = (isset($cs_theme_options['cs_heading_4_size'])) ? $cs_theme_options['cs_heading_4_size']: '';
$cs_heading_5_size = (isset($cs_theme_options['cs_heading_5_size'])) ? $cs_theme_options['cs_heading_5_size']: '';
$cs_heading_6_size = (isset($cs_theme_options['cs_heading_6_size'])) ? $cs_theme_options['cs_heading_6_size']: '';

/* font Color */
$cs_heading_h1_color = (isset($cs_theme_options['cs_heading_h1_color']) and $cs_theme_options['cs_heading_h1_color'] <> '') ? $cs_theme_options['cs_heading_h1_color']: '';
$cs_heading_h2_color = (isset($cs_theme_options['cs_heading_h2_color']) and $cs_theme_options['cs_heading_h2_color'] <> '') ? $cs_theme_options['cs_heading_h2_color']: '';
$cs_heading_h3_color = (isset($cs_theme_options['cs_heading_h3_color']) and $cs_theme_options['cs_heading_h3_color'] <> '') ? $cs_theme_options['cs_heading_h3_color']: '';
$cs_heading_h4_color = (isset($cs_theme_options['cs_heading_h4_color']) and $cs_theme_options['cs_heading_h4_color'] <> '') ? $cs_theme_options['cs_heading_h4_color']:'';
$cs_heading_h5_color = (isset($cs_theme_options['cs_heading_h5_color']) and $cs_theme_options['cs_heading_h5_color'] <> '') ? $cs_theme_options['cs_heading_h5_color']: '';
$cs_heading_h6_color = (isset($cs_theme_options['cs_heading_h6_color']) and $cs_theme_options['cs_heading_h6_color'] <> '') ? $cs_theme_options['cs_heading_h6_color']: '';
$cs_text_color = $cs_theme_options['cs_text_color'];         

$cs_widget_heading_size = (isset($cs_theme_options['cs_widget_heading_size'])) ? $cs_theme_options['cs_widget_heading_size']: '';
$cs_section_heading_size = (isset($cs_theme_options['cs_section_heading_size'])) ? $cs_theme_options['cs_section_heading_size']: '';


if(
	( isset( $cs_theme_options['cs_custom_font_woff'] ) && $cs_theme_options['cs_custom_font_woff'] <> '' ) &&
	( isset( $cs_theme_options['cs_custom_font_ttf'] ) && $cs_theme_options['cs_custom_font_ttf'] <> '' ) &&
	( isset( $cs_theme_options['cs_custom_font_svg'] ) && $cs_theme_options['cs_custom_font_svg'] <> '' ) &&
	( isset( $cs_theme_options['cs_custom_font_eot'] ) && $cs_theme_options['cs_custom_font_eot'] <> '' )
):

$font_face_html = "
@font-face {
	font-family: 'cs_custom_font';
	src: url('".$cs_theme_options['cs_custom_font_eot']."');
	src:
		url('".$cs_theme_options['cs_custom_font_eot']."?#iefix') format('eot'),
		url('".$cs_theme_options['cs_custom_font_woff']."') format('woff'),
		url('".$cs_theme_options['cs_custom_font_ttf']."') format('truetype'),
		url('".$cs_theme_options['cs_custom_font_svg']."#cs_custom_font') format('svg');
	font-weight: 400;
	font-style: normal;
}";

$custom_font = true; else: $custom_font = false; endif;
	
if($custom_font == true){
	echo cs_allow_special_char($font_face_html);
}
?>
body,.main-section p {
	<?php 
	if($custom_font == true){
		echo 'font-family: cs_custom_font;';
		echo 'font-size: '.$cs_content_size.';';
	}
	else{
		echo cs_font_font_print($cs_content_font_atts, $cs_content_size, $cs_content_font);
	}
	?>
	 color:<?php echo cs_allow_special_char($cs_text_color);?>;
}
header .logo{
	margin:<?php echo cs_allow_special_char($cs_logo_margint);?>px  <?php echo cs_allow_special_char($cs_logo_marginr);?>px <?php echo cs_allow_special_char($cs_logo_marginb);?>px <?php echo cs_allow_special_char($cs_logo_marginl);?>px !important;
   }
.nav li a,.navigation ul li{
	<?php 
	if($custom_font == true){
		echo 'font-family: cs_custom_font;';
		echo 'font-size: '.$cs_mainmenu_size.';';
		echo 'line-height: 25px;';
	}
	else{
		 echo cs_font_font_print($cs_mainmenu_font_atts, $cs_mainmenu_size, $cs_mainmenu_font, true);
	}
	?>
}
 h1{
<?php 
if($custom_font == true){
	echo 'font-family: cs_custom_font;';
	echo 'font-size: '.$cs_heading_1_size.';';
}
else{
	echo cs_font_font_print($cs_heading_font_atts, $cs_heading_1_size, $cs_heading_font, true);
}
 
?>}
h2{
<?php 
if($custom_font == true){
	echo 'font-family: cs_custom_font;';
	echo 'font-size: '.$cs_heading_2_size.';';
}
else{
	echo cs_font_font_print($cs_heading_font_atts, $cs_heading_2_size, $cs_heading_font, true);
}

?>}
h3{
<?php 
if($custom_font == true){
	echo 'font-family: cs_custom_font;';
	echo 'font-size: '.$cs_heading_3_size.';';
}
else{
	echo cs_font_font_print($cs_heading_font_atts, $cs_heading_3_size, $cs_heading_font, true);
}

?>}
h4{
<?php 
if($custom_font == true){
	echo 'font-family: cs_custom_font;';
	echo 'font-size: '.$cs_heading_4_size.';';
}
else{
	echo cs_font_font_print($cs_heading_font_atts, $cs_heading_4_size, $cs_heading_font, true);
}

?>}
h5{
<?php 
if($custom_font == true){
	echo 'font-family: cs_custom_font;';
	echo 'font-size: '.$cs_heading_5_size.';';
}
else{
	echo cs_font_font_print($cs_heading_font_atts, $cs_heading_5_size, $cs_heading_font, true);
}

?>}
h6{
<?php 
if($custom_font == true){
	echo 'font-family: cs_custom_font;';
	echo 'font-size: '.$cs_heading_6_size.';';
}
else{
	echo cs_font_font_print($cs_heading_font_atts, $cs_heading_6_size, $cs_heading_font, true);
}

?>}

.main-section h1, .main-section h1 a {color: <?php echo cs_allow_special_char($cs_heading_h1_color);?> !important;}
.main-section h2, .main-section h2 a{color: <?php echo cs_allow_special_char($cs_heading_h2_color);?> !important;}
.main-section h3, .main-section h3 a{color: <?php echo cs_allow_special_char($cs_heading_h3_color);?> !important;}
.main-section h4, .main-section h4 a{color: <?php echo cs_allow_special_char($cs_heading_h4_color);?> !important;}
.main-section h5, .main-section h5 a{color: <?php echo cs_allow_special_char($cs_heading_h5_color);?> !important;}
.main-section h6, .main-section h6 a{color: <?php echo cs_allow_special_char($cs_heading_h6_color);?> !important;}
.widget .widget-section-title h2{
	<?php
	if($custom_font == true){
		echo 'font-family: cs_custom_font;';
		echo 'font-size: '.$cs_widget_heading_size.';';
	}
	else{
		echo cs_font_font_print($cs_widget_heading_font_atts, $cs_widget_heading_size, $cs_widget_heading_font, true);
	}
	?>
}
  .cs-section-title h2{
	<?php
		 echo 'font-size:'.$cs_section_heading_size.'px !important;';
	  ?>
}
#lang_sel ul ul {background-color:<?php echo cs_allow_special_char($cs_topstrip_bgcolor);?> !important;}
#lang_sel ul ul:before { border-bottom-color: <?php echo cs_allow_special_char($cs_topstrip_bgcolor);?>; }


.top-nav ul li a {color: <?PHP echo cs_allow_special_char($cs_topstrip_text_color) ?> !important;}

.top-nav p{color:<?php echo cs_allow_special_char($cs_topstrip_text_color);?> !important;}
 nav .top-nav a{color:#fff !important;}
.top-nav a:hover,.top-bar i:hover{color:<?php echo cs_allow_special_char($cs_topstrip_link_color);?> !important;}
.logo-section,.main-head{background:<?php echo cs_allow_special_char($cs_header_bgcolor);?> !important;}
/********/
 
#main-header .container { background:<?php echo cs_allow_special_char($cs_header_bgcolor);?> !important; }

/*.main-navbar,#main-header .btn-style1,.wrapper:before {background:<?php //echo cs_allow_special_char($cs_nav_bgcolor);?> !important;}*/
.main-navbar,#main-header .btn-style1{background:<?php echo cs_allow_special_char($cs_nav_bgcolor);?> !important;}

.navigation {background:<?php echo cs_allow_special_char($cs_nav_bgcolor);?> !important;}
.sub-dropdown { background-color:<?php echo cs_allow_special_char($cs_submenu_bgcolor);?> !important;}
.navigation > ul ul li > a {color:<?php echo cs_allow_special_char($cs_submenu_color);?> !important;}
.navigation > ul ul li:hover > a {color:<?php echo cs_allow_special_char($cs_submenu_hover_color);?>;color:<?php echo cs_allow_special_char($cs_submenu_hover_color);?> !important;}
.navigation > ul > li:hover > a {color:<?php echo cs_allow_special_char($cs_menu_active_color);?> !important;}
.sub-dropdown:before {border-bottom:8px solid <?php echo cs_allow_special_char($cs_menu_active_color);?> !important;}
.navigation > ul > li.parentIcon:hover > a:before { background-color:<?php echo cs_allow_special_char($cs_menu_active_color);?> !important; }
.cs-user,.cs-user-login { border-color:<?php echo cs_allow_special_char($cs_menu_active_color);?> !important; }
{
	box-shadow: 0 4px 0 <?php echo cs_allow_special_char($cs_topstrip_bgcolor); ?> inset !important;
}
.header_2 .nav > li:hover > a,.header_2 .nav > li.current-menu-ancestor > a {
   
}
	
<?php
/** 
 * @Set Footer colors
 *
 *
 */

$cs_footerbg_color = (isset($cs_theme_options['cs_footerbg_color']) and $cs_theme_options['cs_footerbg_color'] <> '') ? $cs_theme_options[            'cs_footerbg_color']: '';

$cs_footerbg_image = (isset($cs_theme_options['cs_footer_background_image']) and $cs_theme_options['cs_footer_background_image'] <> '') ?             $cs_theme_options['cs_footer_background_image']: '';
$footer_bg_color = cs_hex2rgb($cs_footerbg_color);

$cs_bg_footer_color = 'background-color:rgba('.$footer_bg_color[0].', '. $footer_bg_color[1].', '.$footer_bg_color[2].', 0.95) !important;'; 
$cs_title_color = (isset($cs_theme_options['cs_title_color']) and $cs_theme_options['cs_title_color'] <> '') ? $cs_theme_options[            'cs_title_color']: '';

$cs_footer_text_color = (isset($cs_theme_options['cs_footer_text_color']) and $cs_theme_options['cs_footer_text_color'] <> '') ?           $cs_theme_options['cs_footer_text_color']: '';
$cs_link_color = (isset($cs_theme_options['cs_link_color']) and $cs_theme_options['cs_link_color'] <> '') 
? $cs_theme_options['cs_link_color']: '';
$cs_sub_footerbg_color = (isset($cs_theme_options['cs_sub_footerbg_color']) and $cs_theme_options['cs_sub_footerbg_color'] <> '') ?                   $cs_theme_options['cs_sub_footerbg_color']: '';

$cs_copyright_text_color = (isset($cs_theme_options['cs_copyright_text_color']) and $cs_theme_options['cs_copyright_text_color'] <> '') ?                 $cs_theme_options['cs_copyright_text_color']: '';
$cs_copyright_bg_color = (isset($cs_theme_options['cs_copyright_bg_color'])) ? $cs_theme_options['cs_copyright_bg_color']: '';

	  
?>
 
footer #footer-widget{
     background:<?php echo cs_allow_special_char($cs_footerbg_color); ?> !important;
  
}

footer .bottom-footer{
 
 /* background:<?php //echo cs_allow_special_char($cs_copyright_bg_color); ?> !important;	*/
 background:<?PHP echo cs_allow_special_char($cs_copyright_bg_color) ?> !important;

}


footer#footer-sec, footer.group:before {
    background-color:<?php echo cs_allow_special_char($cs_footerbg_color); ?> !important;
}
#footer-sec {
    background:url(<?php echo esc_url($cs_footerbg_image); ?>) <?php echo cs_allow_special_char($cs_footerbg_color); ?> repeat scroll 0 0 / cover !important; 
 }
#footer-sec::before {
 <?php echo cs_allow_special_char($cs_bg_footer_color); ?>;
 }
.footer-content {
    background-color:<?php echo cs_allow_special_char($cs_footerbg_color); ?> !important;
}


footer .bottom-footer .copyright p {
    color:<?php echo cs_allow_special_char($cs_copyright_text_color); ?> !important;
}

footer #footer-widget a{
     color:<?php echo cs_allow_special_char($cs_link_color); ?> !important;
} 

#footer-sec .widget{
     background-color:<?php echo cs_allow_special_char($cs_bg_footer_color); ?> !important;
}


footer #footer-widget h2,footer #footer-widget h3,footer #footer-widget h4,footer #footer-widget h5,footer #footer-widget h6 {
   color:<?php echo cs_allow_special_char($cs_title_color); ?> !important;
}



footer #footer-widget p,footer #footer-widget strong,#footer-widget li{
     color:<?php echo cs_allow_special_char($cs_footer_text_color); ?> !important;
} 
