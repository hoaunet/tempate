<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 */
get_header();

global $cs_theme_options;
$cs_sub_footer_social_icons = isset($cs_theme_options['cs_sub_footer_social_icons'])? $cs_theme_options['cs_sub_footer_social_icons'] : ''; ?>


		<section class="page-section">
			<div class="container">
				<div class="row">
					<div class="page-not-found">
					  <div class="icon-box">
                        <span>
							<i class="icon-warning2"></i> 
                        </span>
                      </div>
					  <h1><?php echo __('Error 404', 'uoc'); ?></h1>
					  <h2><?php echo __('OOPS! Page not Found', 'uoc'); ?></h2>
					  <div class="cs-content404">
						<div class="desc">
						  <p><?php echo __('The Page you are looking for could have been deleted or never have existed *', 'uoc'); ?>
                          </p> 
						</div>
					  </div>
					</div>
				</div>
			</div>
		</section>
        
<?php get_footer();?>