var contheight;
// hide page section
jQuery('.uploadMedia').live('click', function () {
    var $ = jQuery;
    var id = $(this).attr("name");
    var custom_uploader = wp.media({
        title: 'Select File',
        button: {
            text: 'Add File'
        },
        multiple: false
    }).on('select', function () {
        var attachment = custom_uploader.state().get('selection').first().toJSON();
        jQuery('#' + id).val(attachment.url);
        jQuery('#' + id + '_img').attr('src', attachment.url);
        jQuery('#' + id + '_box').show();
    }).open();

});


jQuery(".uploadfileurl").live('click', function () {
    var $ = jQuery;
    var id = $(this).attr("name");
    var custom_uploader = wp.media({
        title: 'Select File',
        button: {
            text: 'Add File'
        },
        multiple: false
    })
            .on('select', function () {
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                jQuery('#' + id).val(attachment.url);
            }).open();

});




/*-------
 *  Mail Function
 --------------------------------------------------------------------------- */



/*-------
 *  menu toggle Function
 --------------------------------------------------------------------------- */




function resetTabs() {
    jQuery("#tabbed-content > div").addClass('hidden-tab'); //Hide all content
    jQuery("#cs-options-tab a").attr("id", ""); //Reset id's      
}

jQuery(document).ready(function () {
    var myUrl = window.location.href; //get URL
    var myUrlTab = myUrl.substring(myUrl.indexOf("#")); // For localhost/tabs.html#tab2, myUrlTab = #tab2     
    var myUrlTabName = myUrlTab.substring(0, 4); // For the above example, myUrlTabName = #tab
    jQuery("#tabbed-content > div").addClass('hidden-tab'); // Initially hide all content #####EDITED#####
    jQuery("#cs-options-tab li:first a").attr("id", "current"); // Activate first tab
    jQuery("#tabbed-content > div:first").hide().removeClass('hidden-tab').fadeIn(); // Show first tab content   #####EDITED#####
    jQuery("#cs-options-tab > li:first").addClass('active');

    jQuery("#cs-options-tab a").on("click", function (e) {
        e.preventDefault();
        if (jQuery(this).attr("id") == "current") { //detection for current tab
            return
        } else {
            resetTabs();
            console.log(this);
            jQuery("#cs-options-tab > li").removeClass('active')
            jQuery(this).attr("id", "current"); // Activate this
            jQuery(this).parents('li').addClass('active');
            jQuery(jQuery(this).attr('name')).hide().removeClass('hidden-tab').fadeIn(); // Show content for current tab
        }
    });

    for (i = 1; i <= jQuery("#cs-options-tab li").length; i++) {
        if (myUrlTab == myUrlTabName + i) {
            resetTabs();
            jQuery("a[name='" + myUrlTab + "']").attr("id", "current"); // Activate url tab
            jQuery(myUrlTab).hide().removeClass('hidden-tab').fadeIn(); // Show url tab content        
        }
    }
});

function del_media(id) {

    var $ = jQuery;
    jQuery('#' + id + '_box').hide();
    jQuery('#' + id).val('');
}

function toggle_with_value(id) {
    if (id == 0) {
        jQuery("#wrapper_repeat_event").hide();
    } else {
        jQuery("#wrapper_repeat_event").show();
    }
}

function gll_search_map() {
    var vals;
    vals = jQuery('#cs_location_address').val();
    vals = vals + ", " + jQuery('#cs_loc_city').val();
    vals = vals + ", " + jQuery('#cs_loc_region').val();
    vals = vals + ", " + jQuery('#cs_loc_country').val();
    jQuery('.gllpSearchField').val(vals);
}

function remove_image(id) {
    var $ = jQuery;
    $('#' + id).val('');
    $('#' + id + '_img_div').hide();
    //$('#'+id+'_div').attr('src', '');
}

function slideout() {
    setTimeout(function () {
        jQuery(".form-msg").slideUp("slow", function () {});
    }, 5000);
}

function cs_div_remove(id) {
    jQuery("#" + id).remove();
}

function cs_toggle(id) {
    jQuery("#" + id).slideToggle("slow");
}

function cs_toggle_height(value, id) {
    var $ = jQuery;
    if (value == "Post Slider") {
        jQuery("#post_slider" + id).show();
        jQuery("#choose_slider" + id).hide();
        jQuery("#layer_slider" + id).hide();
        jQuery("#show_post" + id).show();
    } else if (value == "Flex Slider") {
        jQuery("#choose_slider" + id).show();
        jQuery("#layer_slider" + id).hide();
        jQuery("#post_slider" + id).hide();
        jQuery("#show_post" + id).hide();
    } else if (value == "Custom Slider") {
        jQuery("#layer_slider" + id).show();
        jQuery("#choose_slider" + id).hide();
        jQuery("#post_slider" + id).hide();
        jQuery("#show_post" + id).hide();
    } else {
        jQuery("#" + id).removeClass("no-display");
        jQuery("#post_slider" + id).show();
        jQuery("#choose_slider" + id).hide();
        jQuery("#layer_slider" + id).hide();
        jQuery("#show_post" + id).hide();
    }
}

function cs_toggle_list(value, id) {
    var $ = jQuery;

    if (value == "custom_icon") {
        jQuery("#" + id).addClass("no-display");
        jQuery("#cs_list_icon").show();
    } else {
        jQuery("#" + id).removeClass("no-display");
        jQuery("#cs_list_icon").hide();
    }
}

function cs_counter_image(value, id) {
    var $ = jQuery;

    if (value == "icon") {
        jQuery(".selected_image_type" + id).hide();
        jQuery(".selected_icon_type" + id).show();
    } else {
        jQuery(".selected_image_type" + id).show();
        jQuery(".selected_icon_type" + id).hide();
    }

}

function cs_counter_view_type(value, id) {
    var $ = jQuery;

    if (value == "icon-border") {
        jQuery("#selected_view_icon_type" + id).hide();
        jQuery("#selected_view_border_type" + id).show();
        jQuery("#selected_view_icon_image_type" + id).hide();
        jQuery("#selected_view_icon_icon_type" + id).show();
    } else {
        jQuery("#selected_view_icon_type" + id).show();
        jQuery("#selected_view_border_type" + id).hide();
        jQuery("#selected_view_icon_image_type" + id).show();
    }

}


function cs_service_toggle_image(value, id, object) {
    var $ = jQuery;
    var selectedValue = $('#cs_service_type-' + id).val();
    if (value == "image") {
        jQuery("#modern-size-" + id).hide();
        jQuery("#selected_image_type" + id).show();
        jQuery("#selected_icon_type" + id).hide();

    } else if (value == "icon") {
        if (selectedValue == 'modern') {
            jQuery("#modern-size-" + id).show();
        } else {
            jQuery("#modern-size-" + id).hide();
        }

        jQuery("#selected_image_type" + id).hide();
        jQuery("#selected_icon_type" + id).show();
    }

}

function cs_service_toggle_view(value, id, object) {
    var $ = jQuery;
    if (value == "modern") {
        jQuery("#cs-service-bg-color-" + id).show();
        jQuery("#modern-size-" + id).show();
        jQuery("#service-position-classic-" + id).hide();
        jQuery("#service-position-modern-" + id).show();
        jQuery("#cs-modern-bg-color-" + id + " #bg-service").html('Button bg Color');

    } else if (value == "classic") {
        jQuery("#modern-size-" + id).hide();
        jQuery("#cs-service-bg-color-" + id).hide();
        jQuery("#service-position-modern-" + id).hide();
        jQuery("#service-position-classic-" + id).show();
        jQuery("#cs-modern-bg-color-" + id + " #bg-service").html('Text Color');
    }

}

function cs_icon_toggle_view(value, id, object) {
    var $ = jQuery;
    if (value == "bg_style") {
        jQuery("#selected_icon_view_" + id + " #label-icon").html('Icon Background Color');

    } else if (value == "border_style") {
        jQuery("#selected_icon_view_" + id + " #label-icon").html('Border Color');
    }

}
/* -- Counter Image Show Hide End --*/

/* -- Pricetable Title Show Hide Start --*/

function cs_pricetable_style_vlaue(value, id) {
    var $ = jQuery;
    if (value == "classic") {
        jQuery("#pricetbale-title" + id).hide();
    } else {
        jQuery("#pricetbale-title" + id).show();
    }
}

function show_sidebar(id, random_id) {
    var $ = jQuery;
    jQuery('input[class="radio_cs_sidebar"]').click(function () {
        jQuery(this).parent().parent().find(".check-list").removeClass("check-list");
        jQuery(this).siblings("label").children("#check-list").addClass("check-list");
    });
    var randomeID = "#" + random_id;
    if ((id == 'left') || (id == 'right')) {
        $(randomeID + "_sidebar_right," + randomeID + "_sidebar_left").hide();
        $(randomeID + "_sidebar_" + id).show();
    } else if ((id == 'both') || (id == 'none')) {
        $(randomeID + "_sidebar_right," + randomeID + "_sidebar_left").hide();
    }
}

function show_sidebar_page(id) {
    var $ = jQuery;
    jQuery('input[name="cs_page_layout"]').live('click', function () {
        jQuery(this).parent().parent().find(".check-list").removeClass("check-list");
        jQuery(this).siblings("label").children("#check-list").addClass("check-list");
    });
    if ((id == 'left') || (id == 'right')) {
        $("#wrapper_sidebar_left,#wrapper_sidebar_right").hide();
        $("#wrapper_sidebar_" + id).show();
    } else if (id == 'both') {
        $("#wrapper_sidebar_right,#wrapper_sidebar_left").show();
    } else if (id == 'none') {
        $("#wrapper_sidebar_right,#wrapper_sidebar_left").hide();
    }
}


function cs_toggle_gal(id, counter) {
    if (id == 0) {
        jQuery("#link_url" + counter).hide();
        jQuery("#video_code" + counter).hide();
    } else if (id == 1) {
        jQuery("#link_url" + counter).hide();
        jQuery("#video_code" + counter).show();
    } else if (id == 2) {
        jQuery("#link_url" + counter).show();
        jQuery("#video_code" + counter).hide();
    }
}

var counter = 0;
function delete_this(id) {
    var count_widget;
    jQuery('#' + id).remove();
    jQuery('#' + id + '_del').remove();
    count_widget--;
    if (count_widget < 1)
        jQuery("#add_page_builder_item").addClass("hasclass");
}

var Data = [{
        "Class": "column_100", "title": "100", "element": ["gallery", "tweets", "job_specialisms", "search", "slider", "blog", "team", "column", "accordions", "client", "contact", "divider", "message_box", 'image', "image_frame", "map", "video", "quote", "dropcap", "pricetable", "tabs", "accordion", "prayer", "table", "call_to_action", "flex_column", "clients", "spacer", "heading", "testimonials", "infobox", "promobox", "offerslider", "audio", "icons", "contactus", "tooltip", "services", "highlight", "list", "mesage", "faq", "counter", "members", "multiple_services", "mailchimp", "events", "team_post", "portfolio", "quick_quote"]},
    {"Class": "column_75", "title": "75", "element": ["gallery", "tweets", "job_specialisms", "search", "slider", "blog", "team", "column", "accordions", "team", "client", "contact", "column", "divider", "message_box", "image_frame", 'image', "map", "video", "quote", "dropcap", "pricetable", "tabs", "accordion", "advance_search", "prayer", "table", "flex_column", "clients", "spacer", "heading", "testimonials", "infobox", "promobox", "offerslider", "audio", "icons", "contactus", "tooltip", "highlight", "list", "mesage", "faq", "services", "counter", "members", "directory_map", "multiple_services", "mailchimp", "events", "team_post", "portfolio", "quick_quote"]},
    {"Class": "column_67", "title": "67", "element": ["gallery", "tweets", "search", "slider", "job_specialisms", "blog", "team", "column", "accordions", "team", "client", "contact", "divider", "message_box", 'image', "image_frame", "map", "video", "quote", "dropcap", "pricetable", "tabs", "accordion", "advance_search", "prayer", "pointtable", "table", "flex_column", "clients", "spacer", "heading", "testimonials", "testimonials", "infobox", "promobox", "offerslider", "audio", "icons", "contactus", "tooltip", "highlight", "services", "list", "mesage", "faq", "counter", "members", "multiple_services", "mailchimp", "events", "team_post", "portfolio", "quick_quote"]},
    {"Class": "column_50", "title": "50", "element": ["gallery", "tweets", "search", "job_specialisms", "slider", "blog", "team", "column", "services", "accordions", "team", "client", "contact", "column", "divider", "message_box", "image_frame", 'image', "map", "video", "quote", "dropcap", "pricetable", "services", "tabs", "accordion", "advance_search", "prayer", "table", "flex_column", "clients", "spacer", "heading", "testimonials", "infobox", "promobox", "offerslider", "audio", "icons", "contactus", "tooltip", "highlight", "list", "mesage", "faq", "counter", "members", "multiple_services", "mailchimp", "events", "team_post", "portfolio", "quick_quote"]},
    {"Class": "column_33", "title": "33", "element": ["slider", "tweets", "search", "blog", "job_specialisms", "events", "team", "column", "accordions", "message_box", 'image', "fixtures", "map", "video", "quote", "dropcap", "pricetable", "services", "tabs", "accordion", "prayer", "pointtable", "flex_column", "spacer", "heading", "testimonials", "infobox", "promobox", "audio", "icons", "contactus", "tooltip", "highlight", "list", "mesage", "faq", "counter", "multiple_services", "mailchimp", "events", "team_post", "portfolio", "quick_quote"]},
    {"Class": "column_25", "title": "25", "element": ["column", "tweets", "search", "job_specialisms", "divider", "message_box", "image_frame", "map", "video", "quote", "dropcap", "pricetable", "services", "pastor", 'services', 'counter', "flex_column", "spacer", "heading", "testimonials", "infobox", "promobox", "audio", "icons", "contactus", "tooltip", "highlight", "list", "mesage", "faq", "counter", "multiple_services", "mailchimp", "events", "team_post", "portfolio", "quick_quote"]}, ];

var DataElement = [{
        "ClassName": "col_width_full",
        "element": ["gallery", "slider", "blog", "events", "contact", "parallax"]
    }];


var _commonshortcode = (function (id) {
    var mainConitem = jQuery("#" + id)
    var totalItemCon = mainConitem.find(".cs-wrapp-clone").size();
    mainConitem.find(".fieldCounter").val(totalItemCon);
    mainConitem.sortable({
        cancel: '.cs-clone-append .form-elements,.cs-disable-true',
        placeholder: "ui-state-highlight"
    });

});
var counter_ingredient = 0;
var html_popup = "<div id='confirmOverlay' style='display:block'> \
								<div id='confirmBox'><div id='confirmText'>Are you sure to do this?</div> \
								<div id='confirmButtons'><div class='button confirm-yes'>Delete</div>\
								<div class='button confirm-no'>Cancel</div><br class='clear'></div></div></div>"
// deleting the accordion start
jQuery("a.deleteit_node").live('click', function () {
    var mainConitem = jQuery(this).parents(".cs-wrapp-tab-box");
    jQuery(this).parent().append(html_popup);
    jQuery(this).parents(".cs-wrapp-clone").addClass("warning");
    jQuery(".confirm-yes").click(function () {
        var totalItemCon = mainConitem.find(".cs-wrapp-clone").size();
        var totalItems = jQuery(".cs-wrapp-tab-box .fieldCounter").val();
        mainConitem.find(".fieldCounter").val(totalItems - 1);
        jQuery(this).parents(".cs-wrapp-clone").fadeOut(400, function () {
            jQuery(this).remove();
        });

        jQuery("#confirmOverlay").remove();
    });

    jQuery(".confirm-no").click(function () {
        jQuery(".cs-wrapp-clone").removeClass("warning");
        jQuery("#confirmOverlay").remove();
    });
    return false;
});

//page Section items delete start
jQuery(".btndeleteitsection").live("click", function () {
    jQuery(this).parents(".parentdeletesection").addClass("warning");
    jQuery(this).parent().append(html_popup);

    jQuery(".confirm-yes").click(function () {
        jQuery(this).parents(".parentdeletesection").fadeOut(400, function () {
            jQuery(this).remove();
        });
        jQuery("#confirmOverlay").remove();
        count_widget--;
        if (count_widget == 0)
            jQuery("#add_page_builder_item").removeClass("hasclass");
    });
    jQuery(".confirm-no").click(function () {
        jQuery(this).parents(".parentdeletesection").removeClass("warning");
        jQuery("#confirmOverlay").remove();
    });
    return false;
});


//page Builder items delete start
jQuery(".btndeleteit").live("click", function () {

    jQuery(this).parents(".parentdelete").addClass("warning");
    jQuery(this).parent().append(html_popup);

    jQuery(".confirm-yes").click(function () {
        jQuery(this).parents(".parentdelete").fadeOut(400, function () {
            jQuery(this).remove();
        });

        jQuery(this).parents(".parentdelete").each(function () {
            var lengthitem = jQuery(this).parents(".dragarea").find(".parentdelete").size() - 1;
            jQuery(this).parents(".dragarea").find("input.textfld").val(lengthitem);
        });

        jQuery("#confirmOverlay").remove();
        var count_widget = '';
        if (count_widget == 0)
            jQuery("#add_page_builder_item").removeClass("hasclass");

    });
    jQuery(".confirm-no").click(function () {
        jQuery(this).parents(".parentdelete").removeClass("warning");
        jQuery("#confirmOverlay").remove();
    });

    return false;
});
//page Builder items delete end

// adding social network start

function social_icon_del(id) {
    jQuery("#del_" + id).remove();
    jQuery("#" + id).remove();
}


jQuery(document).ready(function () {
    // Map Fix
    jQuery('a[href="#tab-location-settings-cs-events"]').click(function (e) {
        var map = jQuery("#cs-map-location-id")[0];
        setTimeout(function () {
            google.maps.event.trigger(map, 'resize');
        }, 400)
    });
    // End here
    jQuery('#wrapper_boxed_layoutoptions1').click(function () {
        var theme_option_layout = jQuery('#wrapper_boxed_layoutoptions1 input[name=layout_option]:checked').val();
        if (theme_option_layout == 'wrapper_boxed') {
            jQuery("#layout-background-theme-options").show();
        } else {
            jQuery("#layout-background-theme-options").hide();
        }
    });
    jQuery('#wrapper_boxed_layoutoptions2').click(function () {
        var theme_option_layout = jQuery('#wrapper_boxed_layoutoptions2 input[name=layout_option]:checked').val();
        if (theme_option_layout == 'wrapper_boxed') {
            jQuery("#layout-background-theme-options").show();
        } else {
            jQuery("#layout-background-theme-options").hide();

        }

    });
});

/*------------------------------------------------------
 * Sidebar Layout
 *-----------------------------------------------------*/
function cs_slider_element_toggle(id) {

    if (id == 'default_header') {
        jQuery("#wrapper_default_header").hide();
        jQuery("#wrapper_breadcrumb_header").hide();
        jQuery("#wrapper_custom_slider").hide();
        jQuery("#wrapper_map").hide();
        jQuery("#wrapper_no-header").hide();
        jQuery("#wrapper_gallery").hide();
    } else if (id == 'custom_slider') {
        jQuery("#wrapper_custom_slider").show();
        jQuery("#wrapper_default_header").hide();
        jQuery("#wrapper_breadcrumb_header").hide();
        jQuery("#wrapper_map").hide();
        jQuery("#wrapper_no-header").hide();
        jQuery("#wrapper_gallery").hide();
    } else if (id == 'no-header') {
        jQuery("#wrapper_no-header").show();
        jQuery("#wrapper_default_header").hide();
        jQuery("#wrapper_breadcrumb_header").hide();
        jQuery("#wrapper_custom_slider").hide();
        jQuery("#wrapper_map").hide();
        jQuery("#wrapper_gallery").hide();
    } else if (id == 'breadcrumb_header') {
        jQuery("#wrapper_breadcrumb_header").show();
        jQuery("#wrapper_default_header").show();
        jQuery("#wrapper_custom_slider").hide();
        jQuery("#wrapper_map").hide();
        jQuery("#wrapper_no-header").hide();
        jQuery("#wrapper_gallery").hide();
    } else if (id == 'map') {
        jQuery("#wrapper_map").show();
        jQuery("#wrapper_default_header").hide();
        jQuery("#wrapper_breadcrumb_header").hide();
        jQuery("#wrapper_custom_slider").hide();
        jQuery("#wrapper_gallery").hide();
        jQuery("#wrapper_no-header").hide();
    } else if (id == 'gallery') {
        jQuery("#wrapper_gallery").show();
        jQuery("#wrapper_map").hide();
        jQuery("#wrapper_default_header").hide();
        jQuery("#wrapper_breadcrumb_header").hide();
        jQuery("#wrapper_custom_slider").hide();
        jQuery("#wrapper_no-header").hide();
    } else {
        jQuery("#wrapper_default_header").hide();
        jQuery("#wrapper_breadcrumb_header").hide();
        jQuery("#wrapper_custom_slider").hide();
        jQuery("#wrapper_gallery").hide();
        jQuery("#wrapper_map").hide();
        jQuery("#wrapper_no-header").hide();
    }

}

function cs_hide_show_toggle(id, div, type) {

    if (type == 'theme_options') {
        if (id == 'default') {
            jQuery("#cs_sh_paddingtop_range").hide();
            jQuery("#cs_sh_paddingbottom_range").hide();
        } else if (id == 'custom') {
            jQuery("#cs_sh_paddingtop_range").show();
            jQuery("#cs_sh_paddingbottom_range").show();
        }

    } else {
        if (id == 'default') {
            jQuery("#" + div).hide();
        } else if (id == 'custom') {
            jQuery("#" + div).show();
        }
    }
}
// background options

function cs_section_background_settings_toggle(id, rand_no) {

    if (id == "no-image") {
        jQuery(".section-custom-background-image-" + rand_no).hide();
        jQuery(".section-slider-" + rand_no).hide();
        jQuery(".section-custom-slider-" + rand_no).hide();
        jQuery(".section-background-video-" + rand_no).hide();
    } else if (id == "section-custom-background-image") {
        jQuery(".section-slider-" + rand_no).hide();
        jQuery(".section-custom-slider-" + rand_no).hide();
        jQuery(".section-background-video-" + rand_no).hide();
        jQuery(".section-custom-background-image-" + rand_no).show();
    } else if (id == "section-slider") {
        jQuery(".section-custom-background-image-" + rand_no).hide();
        jQuery(".section-slider-" + rand_no).show();
        jQuery(".section-custom-slider-" + rand_no).hide();
        jQuery(".section-background-video-" + rand_no).hide();

    } else if (id == "section-custom-slider") {
        jQuery(".section-custom-background-image-" + rand_no).hide();
        jQuery(".section-slider-" + rand_no).hide();
        jQuery(".section-custom-slider-" + rand_no).show();
        jQuery(".section-background-video-" + rand_no).hide();

    } else if (id == "section_background_video") {
        jQuery(".section-custom-background-image-" + rand_no).hide();
        jQuery(".section-slider-" + rand_no).hide();
        jQuery(".section-custom-slider-" + rand_no).hide();
        jQuery(".section-background-video-" + rand_no).show();

    } else {
        jQuery(".section-custom-background-image-" + rand_no).hide();
        jQuery(".section-slider-" + rand_no).hide();
        jQuery(".section-custom-slider-" + rand_no).hide();
        jQuery(".section-background-video-" + rand_no).hide();
    }
}


//jQuery(document).ready(function($) {
//$('.bg_color').wpColorPicker();
/*jQuery("#date").datetimepicker({
 format: 'd.m.Y H:i'
 /	});*/
//});

function cs_thumbnail_view(id) {
    if (id == "none") {
        jQuery("#wrapper_thumb_slider").hide();
        jQuery("#wrapper_post_thumb_image").hide();

    } else if (id == "single") {
        jQuery("#wrapper_thumb_slider").hide();
        jQuery("#wrapper_post_thumb_image").show();
        jQuery("#wrapper_thumb_audio").hide();
    } else if (id == "slider") {
        jQuery("#wrapper_post_thumb_image").hide();
        jQuery("#wrapper_thumb_slider").show();
        jQuery("#wrapper_thumb_audio").hide();
    } else if (id == "audio") {
        jQuery("#wrapper_post_thumb_image").hide();
        jQuery("#wrapper_thumb_slider").hide();
        jQuery("#wrapper_thumb_audio").show();
    }


}

function cs_post_view(id) {
    if (id == "single") {
        jQuery("#wrapper_post_detail, #wrapper_post_detail_slider, #wrapper_audio_view, #wrapper_video_view").hide();
        jQuery("#wrapper_post_detail").show();
    } else if (id == "audio") {
        jQuery("#wrapper_post_detail, #wrapper_post_detail_slider, #wrapper_audio_view, #wrapper_video_view").hide();
        jQuery("#wrapper_audio_view").show();
    } else if (id == "video") {
        jQuery("#wrapper_post_detail, #wrapper_post_detail_slider, #wrapper_audio_view, #wrapper_video_view").hide();
        jQuery("#wrapper_video_view").show();
    } else if (id == "slider") {
        jQuery("#wrapper_post_detail, #wrapper_post_detail_slider, #wrapper_audio_view, #wrapper_video_view").hide();
        jQuery("#wrapper_post_detail_slider").show();
    } else {
        jQuery("#wrapper_post_detail, #wrapper_post_detail_slider, #wrapper_audio_view, #wrapper_video_view").hide();
    }
}


//
function cs_show_slider(value) {
    if (value == 'Revolution Slider') {
        jQuery('#tab-sub-header-options ul,#tab-sub-header-options #cs_background_img_box').hide();
        jQuery('#cs_default_header_header').show();
        jQuery('#cs_custom_slider_1').show();
    } else if (value == 'No sub Header') {
        jQuery('#tab-sub-header-options ul,#tab-sub-header-options #cs_background_img_box').not('#tab-sub-header-options ul#cs_header_border_color_color').hide();
        jQuery('#cs_default_header_header,#tab-sub-header-options ul#cs_header_border_color_color').show();
    } else {
        jQuery('#tab-sub-header-options ul,#tab-sub-header-options #cs_background_img_box').show();
        jQuery('#cs_custom_slider_1,#cs_header_border_color_color').hide();
    }


}

jQuery(document).ready(function ($) {
    $('textarea.header_code_indent').keydown(function (e) {
        if (e.keyCode == 9) {
            var start = $(this).get(0).selectionStart;
            $(this).val($(this).val().substring(0, start) + "    " + $(this).val().substring($(this).get(0).selectionEnd));
            $(this).get(0).selectionStart = $(this).get(0).selectionEnd = start + 4;
            return false;
        }
    });
});








function cs_add_field(id, type) {
    var wrapper = jQuery("#" + id + " .input_fields_wrap"); //Fields wrapper
    var items = jQuery("#" + id + " .input_fields_wrap > div").length + 1;

    var uniqueNum = type + '_' + Math.floor(Math.random() * 99999);

    var remove = 'javascript:cs_remove_field("' + uniqueNum + '","' + id + '")';

    jQuery("#" + id + "  .counter_num").val(items);

    jQuery(wrapper).append('<div class="cs-wrapp-clone cs-shortcode-wrapp  cs-pbwp-content" id="' + uniqueNum + '"><ul class="form-elements bcevent_title"><li class="to-label"><label>Pricing Feature ' + items + '</label></li><li class="to-field"><div class="input-sec"><textarea class="txtfield" type="text"  name="pricing_feature[]"></textarea></div><div id="price_remove"><a class="remove_field" onclick=' + remove + '><i class="icon-minus-circle" style="color:#000; font-size:18px"></i></div></a></li></ul></div>'); //add input box
}


function cs_remove_field(id, wrapper) {
    var totalItems = jQuery("#" + wrapper + "  .counter_num").val() - 1;
    jQuery("#" + wrapper + "  .counter_num").val(totalItems);
    jQuery("#" + wrapper + " #" + id + "").remove();
}

jQuery('#tab-location-settings-cs-events').bind('tabsshow', function (event, ui) {
    if (ui.panel.id == "map-tab") {
        resizeMap();
    }
});

function _createclone(object, id, section, post) {

    var _this = object.closest(".column");
    _this.clone().insertAfter(_this);
    //jQuery('.bg_color').wpColorPicker();
    callme();
    jQuery(".draginner").sortable({
        connectWith: '.draginner',
        handle: '.column-in',
        cancel: '.draginner .poped-up,#confirmOverlay',
        revert: false,
        start: function (event, ui) {
            jQuery(ui.item).css({"width": "25%"})
        },
        receive: function (event, ui) {
            callme();
            getsorting(ui)
        },
        placeholder: "ui-state-highlight",
        forcePlaceholderSize: true
    });
    return false;
}

function ajax_shortcode_widget_element(object, admin_url, POSTID, name) {
    var action = '';
    var wraper = object.closest(".column-in").next();
    var _structure = "<div id='cs-pbwp-outerlay'><div id='cs-widgets-list'></div></div>",
            $elem = jQuery('#cs-widgets-list');

    jQuery(wraper).wrap(_structure).delay(100).fadeIn(150);
    var shortcodevalue = object.closest(".column-in").next().find(".cs-textarea-val").val();
    if (shortcodevalue) {

        var elementnamevalue = object.closest(".column-in").next().find(".cs-dcpt-element").val();
        SuccessLoader();
        //_createpop(wraper, "filterdrag");
        counter++;
        var dcpt_element_data = '';
        if (elementnamevalue) {
            var dcpt_element_data = '&element_name=' + elementnamevalue;
        }
        var newCustomerForm = "action=cs_pb_" + name + '&counter=' + '17' + '&shortcode_element_id=' + encodeURIComponent(shortcodevalue) + '&POSTID=' + POSTID + dcpt_element_data;
        var edit_url = action + counter;
        //_createpop();
        jQuery.ajax({
            type: "POST",
            url: admin_url,
            data: newCustomerForm,
            success: function (data) {
                rsponse = jQuery(data);
                var response_html = rsponse.find(".cs-pbwp-content").html();
                object.closest(".column-in").next().find(".pagebuilder-data-load").html(response_html);
                object.closest(".column-in").next().find(".cs-wiget-element-type").val('form');
                jQuery('.loader').remove();
                jQuery('.bg_color').wpColorPicker();
                jQuery('div.cs-drag-slider').each(function () {
                    var _this = jQuery(this);
                    _this.slider({
                        range: 'min',
                        step: _this.data('slider-step'),
                        min: _this.data('slider-min'),
                        max: _this.data('slider-max'),
                        value: _this.data('slider-value'),
                        slide: function (event, ui) {
                            jQuery(this).parents('li.to-field').find('.cs-range-input').val(ui.value)
                        }
                    });
                });
                jQuery(".draginner").sortable({
                    connectWith: '.draginner',
                    handle: '.column-in',
                    cancel: '.draginner .poped-up,#confirmOverlay',
                    revert: false,
                    receive: function (event, ui) {
                        callme();
                        getsorting(ui)
                    },
                    placeholder: "ui-state-highlight",
                    forcePlaceholderSize: true

                });
            }
        });
    }
}


function _removerlay(object) {
    jQuery("#cs-widgets-list .loader").remove();
    var _elem1 = "<div id='cs-pbwp-outerlay'></div>",
            _elem2 = "<div id='cs-widgets-list'></div>";
    $elem = object.closest('div[class*="cs-wrapp-class-"]');
    $elem.unwrap(_elem2);
    $elem.unwrap(_elem1);
    $elem.hide()
}

function _createpopshort(object) {
    var _structure = "<div id='cs-pbwp-outerlay'><div id='cs-widgets-list'></div></div>",
            $elem = jQuery('#cs-widgets-list');
    var a = object.closest(".column-in").next();
    jQuery(a).wrap(_structure).delay(100).fadeIn(150);
}

// Post xml import


// Header Options
function cs_header_option(val) {
    if (val == 'none') {
        jQuery('#wrapper_rev_slider,#wrapper_headerbg_image').hide();
    } else if (val == 'cs_rev_slider') {
        jQuery('#wrapper_rev_slider').fadeIn();
        jQuery('#wrapper_headerbg_image').hide();
    } else if (val == 'cs_bg_image_color') {
        jQuery('#wrapper_headerbg_image').fadeIn();
        jQuery('#wrapper_rev_slider').hide();
    }
}

/* ---------------------------------------------------------------------------
 * Toggle Function
 * --------------------------------------------------------------------------- */
jQuery(document).ready(function () {
    jQuery(".hidediv").hide();
    jQuery(".showdiv").click(function () {
        jQuery(this).parents("article").stop().find(".hidediv").toggle(300);
    });
});

function cs_banner_widget_toggle(view, id) {
    if (view == 'random') {
        jQuery("#cs_banner_style_field_" + id).show();
        jQuery("#cs_banner_code_field_" + id).hide();
        jQuery("#cs_banner_number_field_" + id).show();
    } else if (view == 'single') {
        jQuery("#cs_banner_style_field_" + id).hide();
        jQuery("#cs_banner_code_field_" + id).show();
        jQuery("#cs_banner_number_field_" + id).hide();
    }
}

/**
 *
 *@Gallery
 *
 */



jQuery(function ($) {
    // Product gallery file uploads
    var gallery_frame;

    jQuery('.add_gallery').on('click', 'input', function (event) {
        var $el = $(this);

        get_id = $el.parent('.add_gallery').data('id');
        rand_id = $el.parent('.add_gallery').data('rand_id');
        cs_theme_url = $("#cs_theme_url").val();
        $gallery_images = $('#gallery_container_' + rand_id + ' ul.gallery_images');
        attachment_ids = $('#' + get_id).val();
        //alert('#gallery_container_'+rand_id+' ul.gallery_images');
        event.preventDefault();

        // If the media frame already exists, reopen it.
        if (gallery_frame) {
            gallery_frame.open();
            return;
        }

        // Create the media frame.
        gallery_frame = wp.media.frames.room_gallery = wp.media({
            // Set the title of the modal.
            title: $el.data('choose'),
            button: {
                text: $el.data('update'),
            },
            states: [
                new wp.media.controller.Library({
                    title: $el.data('choose'),
                    filterable: 'all',
                    multiple: true,
                })
            ]
        });

        // When an image is selected, run a callback.
        gallery_frame.on('select', function () {

            var selection = gallery_frame.state().get('selection');

            selection.map(function (attachment) {

                attachment = attachment.toJSON();

                if (attachment.type == 'image') {
                    var gallery_url = attachment.url;
                } else if (attachment.type == 'audio') {
                    var gallery_url = cs_theme_url + '/include/assets/images/audio.png';
                } else if (attachment.type == 'video') {
                    var gallery_url = cs_theme_url + '/include/assets/images/video.png';
                } else {
                    var gallery_url = cs_theme_url + '/include/assets/images/attachment.png';
                }

                if (attachment.id) {
                    attachment_ids = attachment_ids ? attachment_ids + "," + attachment.id : attachment.id;
                    $('#gallery_container_' + rand_id + ' ul.gallery_images').append('\
						<li class="image" data-attachment_id="' + attachment.id + '">\
							<img src="' + gallery_url + '" />\
							<div class="actions">\
								<span><a href="javascript:;" class="delete" title="' + $el.data('delete') + '"><i class="icon-times"></i></a></span>\
							</div>\
						</li>');
                }

            });

            var gallery = []; // more efficient than new Array()
            jQuery('#gallery_sortable_' + rand_id + ' li').each(function () {
                var data_value = jQuery.trim(jQuery(this).data('attachment_id'));
                gallery.push(jQuery(this).data('attachment_id'));
            });

            jQuery("#" + get_id).val(gallery.toString());
        });

        // Finally, open the modal.
        gallery_frame.open();
    });

});

/**
 * @Sorting
 *
 */


/* ---------------------------------------------------------------------------
 * Skill bar fucntion
 * --------------------------------------------------------------------------- */
jQuery(document).ready(function () {
    jQuery('.skillbar').each(function () {
        jQuery(this).waypoint(function (direction) {
            jQuery(this).find('.skillbar-bar').animate({
                width: jQuery(this).attr('data-percent')
            }, 2000);
        }, {
            offset: "100%",
            triggerOnce: true
        });
    });

});

/* ---------------------------------------------------------------------------
 * Skill bar fucntion
 * --------------------------------------------------------------------------- */



var counter_skill = 0;
function add_skill_list(admin_url, theme_url) {

    counter_skill++;
    var dataString = 'cs_skill_name=' + jQuery("#cs_skill_name").val() +
            '&cs_skill_perc=' + jQuery("#cs_skill_perc").val() +
            '&action=add_skill_to_list';
    jQuery(".feature-loader").html("<i class='icon-spinner8 icon-spin'></i>");
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        success: function (response) {
            jQuery("#total_skills").append(response);
            jQuery(".feature-loader").html("");
            removeoverlay('add_skill_title', 'append');
            jQuery("#cs_skill_name").val("Title");
            jQuery("#cs_skill_perc").val("");
        }
    });
    return false;
}



var counter_event_list = 0;
function add_proc_to_event_list(admin_url, theme_url, postid) {
    counter_event_list++;

    var dataString = 'cs_proc_name=' + jQuery("#cs_proc_name").val() +
            '&cs_proc_description=' + jQuery("#cs_proc_description").val() +
            '&action=add_port_proc_to_list';
    //alert(dataString);
    jQuery(".feature-loader").html("<i class='icon-spinner8 icon-spin'></i>");
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        success: function (response) {

            jQuery("#total_proc_list").append(response);
            jQuery(".feature-loader").html("");
            removeoverlay('add_proc_title', 'append');
            jQuery("#cs_proc_name").val("Title");
            jQuery("#cs_proc_description").val("");

        }
    });
    return false;
}



var counter_list = 0;
function add_proc_to_list(admin_url, theme_url, postid) {
    counter_list++;

    var dataString = 'cs_proc_name=' + jQuery("#cs_proc_name").val() +
            '&cs_proc_description=' + jQuery("#cs_proc_description").val() +
            '&cs_proc_icon=' + jQuery('input[name="cs_proc_icon[]"]').val() +
            '&action=add_port_proc_to_list';
    //alert(dataString);
    jQuery(".feature-loader").html("<i class='icon-spinner8 icon-spin'></i>");
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        success: function (response) {

            jQuery("#total_proc_list").append(response);
            jQuery(".feature-loader").html("");
            removeoverlay('add_proc_title', 'append');
            jQuery("#cs_proc_name").val("Title");
            jQuery("#cs_proc_description").val("");
            jQuery('input[name="cs_proc_icon[]"]').val("");

        }
    });
    return false;
}
var exp_counter_list = 0;
function  add_exp_list(admin_url, theme_url, postid) {
    exp_counter_list++;

    var dataString = 'cs_exp_name=' + jQuery("#cs_exp_name").val() +
            '&cs_exp_desc=' + jQuery("#cs_exp_desc").val() +
            '&action=add_exp_to_list';

    jQuery(".feature-loader").html("<i class='icon-spinner8 icon-spin'></i>");
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        success: function (response) {

            jQuery("#total_exp").append(response);
            jQuery(".feature-loader").html("");
            removeoverlay('add_exp_title', 'append');
            jQuery("#cs_exp_name").val("Title");
            jQuery("#cs_exp_desc").val("");


        }
    });
    return false;
}











var counter_testimonial = 0;
function add_testimonial_list(admin_url, theme_url) {

    counter_testimonial++;
    var dataString = 'cs_testimonial_name=' + jQuery("#cs_testimonial_name").val() +
            '&cs_testimonial_pos=' + jQuery("#cs_testimonial_pos").val() +
            '&cs_testimonial_img=' + jQuery("#cs_testimonial_img").val() +
            '&cs_testimonial_desc=' + jQuery("#cs_testimonial_desc").val() +
            '&action=add_testimonial_to_list';
    jQuery(".feature-loader").html("<i class='icon-spinner8 icon-spin'></i>");
    jQuery.ajax({
        type: "POST",
        url: admin_url,
        data: dataString,
        success: function (response) {
            jQuery("#total_testimonials").append(response);
            jQuery(".feature-loader").html("");
            removeoverlay('add_testimonial_title', 'append');
            jQuery("#cs_testimonial_name").val("Title");
            jQuery("#cs_testimonial_pos").val("");
            jQuery("#cs_testimonial_img").val("");
            jQuery("#cs_testimonial_img_img").attr('src', '');
            jQuery("#cs_testimonial_img_box").hide();
            jQuery("#cs_testimonial_desc").val("");
        }
    });
    return false;
}


function cs_gallery_sorting_list(id, random_id) {
    var gallery = []; // more efficient than new Array()
    jQuery('#gallery_sortable_' + random_id + ' li').each(function () {
        var data_value = jQuery.trim(jQuery(this).data('attachment_id'));
        gallery.push(jQuery(this).data('attachment_id'));
    });

    jQuery("#" + id).val(gallery.toString());
}






