<?php

/**
 * @SEO Settings
 * @return
 *
 */
if ( ! function_exists( 'cs_seo_settitngs_element' ) ) {
	function cs_seo_settitngs_element(){
		global $cs_metaboxes;
		$cs_metaboxes->cs_form_text_render(
				array(  'name'	=>__('Seo Title','uoc'),
						'id'	=> 'seo_title',
						'classes' => '',
						'std'	=> '',
						'description'  => '',
						'hint'  => ''
					)
			);

		$cs_metaboxes->cs_form_textarea_render(
				array(  'name'	=>__('Seo Description','uoc'),
						'id'	=> 'seo_description',
						'classes' => '',
						'std'	=> '',
						'description'  => '',
						'hint'  => ''
					)
			);
			
		
		$cs_metaboxes->cs_form_text_render(
				array(  'name'	=>__('Seo Keywords','uoc'),
						'id'	=> 'seo_keywords',
						'classes' => '',
						'std'	=> '',
						'description'  => '',
						'hint'  => ''
					)
			);
		$cs_metaboxes->cs_form_textarea_render(
				array(  'name'	=>__(' Style','uoc'),
						'id'	=> 'uoc_style',
						'classes' => '',
						'std'	=> '',
						'description'  => '',
						'hint'  => ''
					)
			);
	}
}


/**
 * @Sidebar Layout
 * @return
 *
 */
if ( ! function_exists( 'cs_sidebar_layout_options' ) ) {
	function cs_sidebar_layout_options(){
		global $post , $cs_xmlObject,$cs_theme_options, $page_option,$cs_metaboxes;
		
		$cs_theme_sidebar   = get_option('cs_theme_options');
		$cs_sidebars_array	= array(''=>'Select Sidebar');
		if ( isset($cs_theme_sidebar['sidebar']) and count($cs_theme_sidebar['sidebar']) > 0 ) {
			foreach ( $cs_theme_sidebar['sidebar'] as $key => $sidebar ){
				$cs_sidebars_array[$sidebar]	= $sidebar;
			}

		}
		
		$cs_page_layout = get_post_meta($post->ID, 'cs_page_layout', true);
		
		$cs_left = $cs_right = 'hide';
		if( isset( $cs_page_layout ) && $cs_page_layout == 'left' ){
			$cs_left	= 'show';
		} else if( isset( $cs_page_layout ) && $cs_page_layout == 'right' ){
			$cs_right	= 'show';
		} 
		
		$cs_metaboxes->cs_form_layout_render(
			array(  'name'	=>__('Choose Sidebar','uoc'),
					'id'	=> 'page_layout',
					'std'	=> 'none',
					'classes' => '',
					'description'  => '',
					'onclick'	   => '',
					'status'	   => '',
					'meta'  	   => '',
				)
		);

		
		$cs_metaboxes->cs_wrapper_start_render(
			array(  'name'		=>__('Wrapper','uoc'),
					'id'		=> 'sidebar_left',
					'status'	=> $cs_left,
				)
		);
		
		$cs_metaboxes->cs_form_select_render(
			array(  'name'	=>__('Select Left Sidebar','uoc'),
					'id'	=> 'page_sidebar_left',
					'classes' => '',
					'std'	=> '',
					'description'  =>__('Add New Sidebar','uoc'), '<a href="'.admin_url().'themes.php?page=cs_options_page#tab-sidebar-show" target="_blank">'.__('Click Here','uoc').'</a>',
					'onclick'	   => '',
					'status'	   => '', // Hide OR Show
					'options' 	   => $cs_sidebars_array,
				)
		);
		
		$cs_metaboxes->cs_wrapper_end_render(
			array(  'name'		=>__('Wrapper','uoc'),
					'id'		=> 'sidebar_left',
				)
		);
		
		$cs_metaboxes->cs_wrapper_start_render(
			array(  'name'		=>__('Wrapper','uoc'),
					'id'		=> 'sidebar_right',
					'status'	=> $cs_right,
				)
		);
		
		$cs_metaboxes->cs_form_select_render(
			array(  'name'	=>__('Select Right Sidebar','uoc'),
					'id'	=> 'page_sidebar_right',
					'classes' => '',
					'std'	=> '',
					'description'  =>__('Add New Sidebar','uoc'), '<a href="'.admin_url().'themes.php?page=cs_options_page#tab-sidebar-show" target="_blank">'.__('Click Here','uoc').'</a>',
					
					
					'onclick'	   => '',
					'status'	   => '',
					'options' 	   => $cs_sidebars_array,
				)
		);
		
		$cs_metaboxes->cs_wrapper_end_render(
			array(  'name'		=>__('Wrapper','uoc'),
					'id'		=> 'sidebar_right',
				)
		);
		
		$cs_metaboxes->cs_form_hidden_render(
			array(  'id'	=>__('orderby','uoc'),
					'classes' => '',
					'std'	=> 'meta_layout',
					'type'    => 'array', // Type : array for arrays and for single leave it empty,
					'return'  => 'echo' // return type : echo OR return
				)
		);

	}
}