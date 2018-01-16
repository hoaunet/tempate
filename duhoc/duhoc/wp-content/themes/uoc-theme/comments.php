<?php
/**
 * The template for displaying Comment form
 */ 
    global $cs_theme_options;
    if ( comments_open() ) {
        if ( post_password_required() ) return;
    }   
    if ( have_comments() ) : 
	?>
       <div id="cs-comments">	
        <div class="cs-section-title"><h4><?php echo comments_number( '0 Comments', '1 Comment', '% Comments' ); ?></h4></div>
       
        <ul>
            <?php wp_list_comments( array( 'callback' => 'cs_comment' ) );    ?>
        </ul>
        
       
        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
            <div class="navigation">
                <div class="nav-previous"><span class="meta-nav">&larr;</span><?php previous_comments_link( __( 'Older Comments', 'uoc') ); ?></div>
                <div class="nav-next"><span class="meta-nav">&rarr;</span><?php next_comments_link( __( 'Newer Comments', 'uoc') ); ?></div>
            </div> <!-- .navigation -->
        <?php endif; // check for comment navigation ?>        
        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
            <div class="navigation">
                <div class="nav-previous"><span class="meta-nav">&larr;</span><?php previous_comments_link( __( 'Older Comments', 'uoc') ); ?></div>
                <div class="nav-next"><span class="meta-nav">&rarr;</span><?php next_comments_link( __( 'Newer Comments', 'uoc') ); ?></div>
            </div><!-- .navigation -->
        <?php endif; ?>
    </div>
       
 <?php endif; // end have_comments() ?>
 
    <div id="respond-comment" class="cs-plain-form cs_form_styling">
            <div class="form-style">
              <h4><?php echo  __( 'Leave us a Comment', 'uoc' );?></h4>
    
    
        <?php 
		$cs_msg_class = '';
		$textAreaLableClass = 'class="textaera-sec"';
		if( is_user_logged_in() ) {$cs_msg_class = ' cs-message'; $textAreaLableClass='';}
		
        global $post_id;
        $you_may_use = __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', 'uoc');
        $must_login ='<a href="%s">logged in</a>'.__( 'You must be  to post a comment.', 'uoc');
        $logged_in_as ='<a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">'.__('Log out', 'uoc').'</a>'.__('Logged in as', 'uoc');
        $required_fields_mark = ' ' .__('Required fields are marked %s', 'uoc');
        $required_text = sprintf($required_fields_mark , '<span class="required">*</span>' );
        $defaults = array( 'fields' => apply_filters( 'comment_form_default_fields', 
            array(
                'notes' => '',                
                'author' => '
				<label><i class="icon-book8"></i>
                <input id="author"  name="author" class="nameinput"  placeholder="Enter Name" required type="text" value=""' .
                esc_attr( $commenter['comment_author'] ) . ' tabindex="1">' .
                '</label>',
				
				'email'  => '' .
                '<label><i class="icon-mortar-board"></i>
				<input id="email" name="email" class="emailinput" type="text" placeholder="Email Address"  required value=""' . 
                esc_attr(  $commenter['comment_author_email'] ) . ' tabindex="2">' .
                '</label>', 
				 	           
                'url'    => '' .
                '<label><i class="icon-globe4"></i>
				<input id="url" name="url" type="text" class="websiteinput"  value=""  tabindex="3" placeholder="Subject"  required>' .
                '</label>' ) ),
				
				'comment_field' => '
                    <label '.$textAreaLableClass.'>
					<textarea id="comment_mes" name="comment"  class="commenttextarea" ></textarea>' .
                '</label>', 
				
				
				               
                'must_log_in' => '<span>' .  sprintf( $must_login,    wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</span>',
                'logged_in_as' => '<span>' . sprintf( $logged_in_as, admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ).'</span>',
				
				
                'comment_notes_before' => '',
                'comment_notes_after' =>  '',
                'class_form' => 'comment-form contact-form',
                'id_form' => 'form-style',
                'class_submit' => 'submit-btn cs-bgcolor',
                'id_submit' => 'cs-bg-color',
                'title_reply' =>'',
                'title_reply_to' =>'<h2 class="cs-section-title">'.__( 'Leave us a comment', 'uoc' ).'</h2>',
                'cancel_reply_link' => __( 'Cancel reply', 'uoc' ),
                'label_submit' => __( 'Submit', 'uoc' ),); 
                comment_form($defaults, $post_id); 
            ?>
   </div>
</div>
     <script type="text/javascript">
jQuery(document).on( 'click', 'a.comment-reply-link', function( event ) {
    jQuery('#respond-comment').hide();
});

jQuery(document).on( 'click', 'a#cancel-comment-reply-link', function( event ) {
    jQuery('#respond-comment').show();
});
    </script>
 