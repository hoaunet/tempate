
<?php
/**
 * The template for displaying Footer
 */
	global $cs_theme_options;
 	
 	$cs_sub_footer_social_icons = isset($cs_theme_options['cs_sub_footer_social_icons'])? $cs_theme_options['cs_sub_footer_social_icons'] : '';
	?>
	</div>
</main>
<div class="clear"></div>




<!-- Footer -->
<?php 
//
global $cs_theme_options, $post, $cs_uc_options;
        $cs_uc_options = get_option('cs_theme_options');
        if (isset($post)) {
            $post_name = $post->post_name;
        } else {
            $post_name = '';
        }

//if !(is_404()){
	
	$cs_footer_switch = isset($cs_theme_options['cs_footer_switch'])? $cs_theme_options['cs_footer_switch'] : '';
	$cs_footer_widget = isset($cs_theme_options['cs_footer_widget'])? $cs_theme_options['cs_footer_widget'] : '';
	$cs_footer_back_to_top = isset($cs_theme_options['cs_footer_back_to_top'])? $cs_theme_options['cs_footer_back_to_top'] : '';
	
	$cs_footer_logo_on_off = isset($cs_theme_options['cs_footer_logo_on_off'])? $cs_theme_options['cs_footer_logo_on_off'] : '';
	$cs_footer_subscriber_field = isset($cs_theme_options['cs_footer_subscriber_field'])? $cs_theme_options['cs_footer_subscriber_field'] : '';
	
    
	if((isset($cs_footer_switch) && $cs_footer_switch =='on')){   ?> 	
     <footer>
   <?php
    if (!is_404()){ 
	  if((isset($cs_footer_logo_on_off) and $cs_footer_logo_on_off =='on') or (isset($cs_footer_subscriber_field) and $cs_footer_subscriber_field == 'on')){ ?>  
        
       <div class="newsletter-section">
          <div class="container">
            <div class="row">  
             
				 <?php if(isset($cs_theme_options['cs_footer_logo_on_off']) && $cs_theme_options['cs_footer_logo_on_off'] == 'on'){?>
                          <div class="col-md-3">
                             <?php if ( function_exists( 'cs_footer_logo' ) ) { cs_footer_logo(); } ?>
                          </div>
                   <?php  }?>
                 
				 
				  <?php if(isset($cs_theme_options['cs_footer_subscriber_field']) && $cs_theme_options['cs_footer_subscriber_field'] == 'on'){?>
                           <?php  if ( function_exists( 'cs_footer_custom_mailchimp' ) ) { 
							         
                                      echo  cs_footer_custom_mailchimp();	
                            }?>
                   <?php  }?>
                
                
            </div>
          </div>
        </div>
        
        
        <?php } ?> 
        
         
		 
		 <?php
		   
		  	 	if(isset($cs_footer_widget) and $cs_footer_widget == 'on'){
			?>
			
				 <div id="footer-widget" >
				 <div class="container">
					<div class="row">
							
							<?php 
							
							
							$cs_footer_sidebar = (isset($cs_theme_options['cs_footer_widget_sidebar']) and ( $cs_theme_options['cs_footer_widget_sidebar'] <> "select sidebar" || $cs_theme_options['cs_footer_widget_sidebar'] <> "")) ? $cs_theme_options['cs_footer_widget_sidebar'] : 'footer-widget-1';
							
							if( $cs_footer_sidebar == '' || $cs_footer_sidebar == 'select sidebar' )
								 $cs_footer_sidebar = 'footer-widget-1';
								 
								if ( is_active_sidebar( cs_get_sidebar_id( $cs_footer_sidebar ) ) ) {
								if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_footer_sidebar) ) : endif;
							}	
							?>  
						  
							  
					 </div>
				 </div>
			</div>
							   
			 <?php }
	 		?>        
     
   <?php } ?>  
   
    <div class="bottom-footer" >
        <div class="container">
            <div class="row">
                <div class="col-md-6">
					<div class="copyright">
						<?php 
                        $cs_copy_right = isset($cs_theme_options['cs_copy_right'])? $cs_theme_options['cs_copy_right'] : '';
                        if(isset($cs_copy_right) and $cs_copy_right<>''){
                            $cs_allowed_tags = array(
                                'a' => array('href' => array(), 'class' => array()),
                                'b' => array(),
                                'i' => array('class' => array()),
                            );
                            echo '<p>' . wp_kses( htmlspecialchars_decode($cs_copy_right), $cs_allowed_tags ) . '</p>';
                        }   
                        ?>	
					</div>
              </div>
              <div class="col-md-6">
              <?php if( $cs_footer_back_to_top == 'on' ){ ?>
                		<span id="backtop"><i class="icon-arrow-up9"></i></span>
                 <?php }?>	   
                <div class="social-media"> 
                          
                    
							<?php if( $cs_sub_footer_social_icons == 'on' ){ ?>
                                    <h6> <?php echo __('Follow us','uoc');?></h6>
                                        <ul>
                                    	<?php if ( function_exists( 'cs_social_network' ) ) { cs_social_network('','yes'); } 
                                    echo  '</ul>';
							
							} ?>  
                    
                 
                </div>
                </div>
            </div>
        </div>
    </div>
    
    </footer> 
    
    
    
    <?php } ?>



<div class="clear"></div>
</div>
<!-- Wrapper End -->   
<?php wp_footer(); ?>
</body>
</html>