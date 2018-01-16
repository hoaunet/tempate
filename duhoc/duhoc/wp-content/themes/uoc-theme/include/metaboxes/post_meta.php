<?php
/**
 * @Add Meta Box For Post
 * @return
 *
 */

$cs_ad_me_bo = 'add_'.'meta_'.'boxes';

add_action( $cs_ad_me_bo, 'cs_meta_post_add' );
function cs_meta_post_add(){  
	add_meta_box( 'cs_meta_post', __('Post Options','uoc'), 'cs_meta_post', 'post', 'normal', 'high' );  
}

function cs_meta_post( $post ) {
	global $cs_theme_options;
	$cs_theme_options		= get_option('cs_theme_options');
	$cs_builtin_seo_fields 	= isset($cs_theme_options['cs_builtin_seo_fields']) ? $cs_theme_options['cs_builtin_seo_fields'] : '';
?>
<div class="page-wrap page-opts left" style="overflow:hidden; position:relative; height: 1432px;">
    <div class="option-sec" style="margin-bottom:0;">
        <div class="opt-conts">
            <div class="elementhidden">
                <nav class="admin-navigtion">
                    <ul id="cs-options-tab">
                        <li><a name="#tab-general-settings" href="javascript:;"><i class="icon-toggle-right"></i><?php echo __('General Settings','uoc');?></a></li>
                        <li><a name="#tab-seo-advance-settings" href="javascript:;"><i class="icon-dribbble"></i><?php echo __('Seo Options','uoc');?> </a></li>
                        <li><a name="#tab-post-options" href="javascript:;"><i class="icon-list-alt"></i><?php echo __('Post Settings','uoc');?>  </a></li>
                    </ul>
                </nav>
                <div id="tabbed-content">
                    <div id="tab-general-settings">
                        <?php cs_general_settings_element(); ?>
                        <?php cs_sidebar_layout_options(); ?>
                    </div>
                    <div id="tab-seo-advance-settings">
                        <?php cs_seo_settitngs_element();?>
                    </div>
                    <div id="tab-post-options">
                        <?php 
                            if ( function_exists( 'cs_post_options' ) ) { 
                                cs_post_options();
                            }
                        ?>
                    </div>
                </div>
             </div>
        </div>
    </div>
</div>
<div class="clear"></div>
<?php
}

/**
 * @Slider options
 * @return html
 *
 */ 
if ( ! function_exists( 'cs_post_options' ) ) {
	function cs_post_options() {
		global $post,$cs_metaboxes;
		
		# Show hide post thumnail
		$thumb_view = get_post_meta($post->ID, 'cs_thumb_view', true);
		$post_thumb_image = $post_thumb_slider = 'hide';
		
		if( isset( $thumb_view ) && $thumb_view == 'single' ){
			$post_thumb_image	= 'show';
		} else if( isset( $thumb_view ) && $thumb_view == 'slider' ){
			$post_thumb_slider	= 'show';
		}
		
		
		# Show hide post detail views
		$detail_view = get_post_meta($post->ID, 'cs_detail_view', true);	
		$detail_image = $detail_slider = $detail_audio = $detail_video = 'hide';
		
		if( isset( $detail_view ) && $detail_view == 'single' ){
			$detail_image	= 'show';
		} else if( isset( $detail_view ) && $detail_view == 'slider' ){
			$detail_slider	= 'show';
		}else if( isset( $detail_view ) && $detail_view == 'audio' ){
			$detail_audio	= 'show';
		}else if( isset( $detail_view ) && $detail_view == 'video' ){
			$detail_video	= 'show';
		}
		
		$cs_metaboxes->cs_form_select_render(
			array(  'name'			=>__('Detail View','uoc'),
					'id'			=> 'single_view',
					'classes'		=> '',
					'std'			=> 'view-1',
					'status'		=> '',
					'description'	=> '',
					'options'		=> array( 'view-1'=>__('View 1','uoc'), 'view-2'=>__('View 2','uoc')),
				)
		);
		
		$cs_metaboxes->cs_form_select_render(
				array(  'name'	=>__('Thumbnail View','uoc'),
						'id'	=> 'thumb_view',
						'classes' => '',
						'std'	=> 'single',
						'onclick'	   => 'cs_thumbnail_view',
						'status'	   => '',
						'description'  => '',
						'options' => array( 'none'=>__('None','uoc'),'single'=>__('Single Image','uoc'),'slider'=>__('Slider','uoc')),
					)
			);
		
		$cs_metaboxes->cs_wrapper_start_render(
				array(  'name'		=>__('Wrapper','uoc'),
						'id'		=> 'post_thumb_image',
						'status'	=> $post_thumb_image,
					)
			);
		
		$cs_metaboxes->cs_information_box(
				array(  'name'		=>__('Information Box','uoc'),
						'id'		=> 'information_box',
						'classes' => '',
						'description'	=>__('Use Featured Image as Thumbnail','uoc'), 
					)
			);
			
		$cs_metaboxes->cs_wrapper_end_render(
				array(  'name'	=>__('Wrapper','uoc'),
						'id'	=> 'post_thumb_image',
					)
			);
		
		$cs_metaboxes->cs_wrapper_start_render(
				array(  'name'		=>__('Wrapper','uoc'),
						'id'		=> 'thumb_slider',
						'status'	=> $post_thumb_slider,
					)
			);
		
		$cs_metaboxes->cs_gallery_render(
				array(  'name'		=>__('Add Gallery Images','uoc'),
						'id'		=> 'post_list_gallery',
						'classes' => '',
						'std'		=> 'gallery_meta_form',
					)
			);
			
		$cs_metaboxes->cs_wrapper_end_render(
				array(  'name'	=>__('Wrapper','uoc'),
						'id'	=> 'thumb_slider',
					)
			);
		
		$cs_metaboxes->cs_form_select_render(
				array(  'name'	=>__('Inside Post Thumbnail View','uoc'),
						'id'	=> 'detail_view',
						'classes' => '',
						'std'	=> 'single',
						'onclick'	   => 'cs_post_view',
						'status'	   => '',
						'description'  => '',
						'options' 	   => array( 'none'=>__('None','uoc'),'single'=>__('Single Image','uoc'),'slider'=>__('Slider','uoc'),'audio'=>__('Audio','uoc'),'video'=>__('Video','uoc')),
					)
			);
		
		# Image View
		$cs_metaboxes->cs_wrapper_start_render(
				array(  'name'		=>__('Wrapper','uoc'),
						'id'		=> 'post_detail',
						'status'	=> $detail_image,
					)
			);
		
		$cs_metaboxes->cs_information_box(
				array(  'name'		=>__('Information Box','uoc'),
						'id'		=> 'information_box',
						'classes' => '',
						'description'	=>__('Use Featured Image as Thumbnail','uoc'),
						
					)
			);
			
		$cs_metaboxes->cs_wrapper_end_render(
				array(  'name'	=>__('Wrapper','uoc'),
						'id'	=> 'post_detail',
					)
			);
		
		#Slider View
		$cs_metaboxes->cs_wrapper_start_render(
				array(  'name'		=>__('Wrapper','uoc'),
						'id'		=> 'post_detail_slider',
						'status'	=> $detail_slider,
					)
			);
		
		$cs_metaboxes->cs_gallery_render(
				array(  'name'		=>__('Add Gallery Images','uoc'),
						'id'		=> 'post_detail_gallery',
						'classes' => '',
						'std'		=> 'gallery_slider_meta_form',
					)
			);
			
		$cs_metaboxes->cs_wrapper_end_render(
				array(  'name'	=>__('Wrapper','uoc'),
						'id'	=> 'post_detail_slider',
					)
			);
		
		#Audio View
		$cs_metaboxes->cs_wrapper_start_render(
				array(  'name'		=>__('Wrapper','uoc'),
						'id'		=> 'audio_view',
						'status'	=> $detail_audio,
					)
			);
		
		$cs_metaboxes->cs_media_url(
				array(  'name'	=>__('Audio Url','uoc'),
						'id'	=> 'post_detail_audio',
						'classes' => '',
						'std'	=> '',
						'description'  =>__('Enter Specific Audio Url','uoc'),
						'hint'  => ''
					)
			);
			
		$cs_metaboxes->cs_wrapper_end_render(
				array(  'name'	=>__('Wrapper','uoc'),
						'id'	=> 'audio_view',
					)
			);
		
		#Video View
		$cs_metaboxes->cs_wrapper_start_render(
				array(  'name'		=>__('Wrapper','uoc'),
						'id'		=> 'video_view',
						'status'	=> $detail_video,
					)
			);
		
		$cs_metaboxes->cs_media_url(
				array(  'name'	=>__('Thumbnail Video Url','uoc'),
						'id'	=> 'post_detail_video',
						'classes' => '',
						'std'	=> '',
						'description'  =>__('Enter Specific Video Url (Youtube, Vimeo and Dailymotion) OR you can select it from your media library','uoc'),
						'hint'  => ''
					)
			);
			
		$cs_metaboxes->cs_wrapper_end_render(
				array(  'name'	=>__('Wrapper','uoc'),
						'id'	=> 'video_view',
					)
			);
	}
}
 
/**
 * @page/post General Settings Function
 * @return
 *
 */
if ( ! function_exists( 'cs_general_settings_element' ) ) {
	function cs_general_settings_element(){
		global $cs_xmlObject, $post,$cs_metaboxes;
		$cs_metaboxes->cs_form_checkbox_render(
			array(  'name'	=>__('Social Sharing','uoc'),
					'id'	=> 'post_social_sharing',
					'classes' => '',
					'std'	=> '',
					'description'  => '',
					'hint'  => '',
				)
		);
		
		$cs_metaboxes->cs_form_checkbox_render(
			array(  'name'	=>__('Tags','uoc'),
					'id'	=> 'post_tags_show',
					'classes' => '',
					'std'	=> '',
					'description'  => '',
					'hint'  => '',
				)
		);
		$cs_metaboxes->cs_form_checkbox_render(
			array(  'name'	=>__('Next Previous','uoc'),
					'id'	=> 'post_pagination_show',
					'classes' => '',
					'std'	=> '',
					'description'  => '',
					'hint'  => '',
				)
		);
		
		$cs_metaboxes->cs_form_checkbox_render(
			array(  'name'	=>__('Related Blog','uoc'),
					'id'	=> 'related_blog_post',
					'classes' => '',
					'std'	=> '',
					'description'  => '',
					'hint'  => '',
				)
		);
		
		
		
	}
}