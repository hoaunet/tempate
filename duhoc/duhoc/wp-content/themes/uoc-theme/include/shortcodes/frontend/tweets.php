<?php

/*
 *
 * @Shortcode Name : Tweets
 * @retrun
 *
 */

if (!function_exists('cs_tweets_shortcode')) {

    function cs_tweets_shortcode($atts, $content = "") {
        $defaults = array('column_size' => '1/1', 'cs_tweets_section_title' => '', 'cs_tweets_user_name' => 'default', 'cs_tweets_color' => '', 'cs_no_of_tweets' => '', 'cs_tweets_class' => '','cs_tweets_bg_color'=>'');
        extract(shortcode_atts($defaults, $atts));
        $column_class = cs_custom_column_class($column_size);
        $CustomId = '';
        if (isset($cs_tweets_class) && $cs_tweets_class) {
            $CustomId = 'id="' . $cs_tweets_class . '"';
        }

        $rand_id = rand(5, 999999);
        $html = '';
        $section_title = '';
           cs_enqueue_flexslider_script(); ?>
          <script type="text/javascript">
        /*  jQuery(document).ready(function(){
          jQuery(".flexslider'.intval($rand_id).'").flexslider({
	      animation: "slide"
              }
          });
          });*/ 
		 jQuery(window).load(function() {
            var target_flexslider = jQuery(".extra_div<?php echo intval($rand_id); ?>").parents('.twitter_widget');
    	    jQuery(".extra_div<?php echo intval($rand_id); ?>").flexslider({
    	    animation: "slide",
            start: function(slider) {
                 target_flexslider.removeClass('cs-loading');
                 target_flexslider.find('.loader').remove();
              } 
    	  });
	   });	
          </script>   
 <?php
       
		$html .= '<div style="background:'.$cs_tweets_bg_color.'"><div class="'.$column_class.'">';
		$html .= '<div class="cs-twitter-section">';
		$html .= '<div class="twitter_widget">';
		$html .= '<div class="loader">Loading.</div>';
		$html .= '<div class="flexslider extra_div'.intval($rand_id).'    cs-twitter-slider">';
		$html .= '<ul class="slides">';
		$html .= cs_get_tweets($cs_tweets_user_name, $cs_no_of_tweets, $cs_tweets_color);
		$html .= '</ul>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</div>';
	 	$html .= '</div>';					   
		
		
       //return $html;
    }

    if (function_exists('cs_short_code')) cs_short_code(CS_SC_TWEETS, 'cs_tweets_shortcode');
}

/*
 *
 * @Get Tweets
 * @retrun
 *
 */
if (!function_exists('cs_get_tweets')) {

    function cs_get_tweets($username, $numoftweets, $cs_tweets_color = '') {
		
		global $cs_theme_options, $cs_twitter_arg;

           
			$cs_twitter_arg['consumerkey'] = isset($cs_theme_options['cs_consumer_key'])  ? $cs_theme_options['cs_consumer_key'] : '';
			$cs_twitter_arg['consumersecret'] = isset ($cs_theme_options['cs_consumer_secret']) ? $cs_theme_options['cs_consumer_secret'] : '';
			$cs_twitter_arg['accesstoken'] = isset($cs_theme_options['cs_access_token']) ? $cs_theme_options['cs_access_token'] : '';
			$cs_twitter_arg['accesstokensecret'] = isset($cs_theme_options['cs_access_token_secret']) ? $cs_theme_options['cs_access_token_secret'] : '';
            $cs_cache_limit_time = isset($cs_theme_options['cs_cache_limit_time']) ? $cs_theme_options['cs_cache_limit_time']: '';
            $cs_tweet_num_from_twitter = isset($cs_theme_options['cs_tweet_num_post']) ? $cs_theme_options['cs_tweet_num_post'] : '';
            $cs_twitter_datetime_formate = isset($cs_theme_options['cs_twitter_datetime_formate']) ? $cs_theme_options['cs_twitter_datetime_formate'] : '';
			
             require_once get_template_directory() . '/include/theme-components/cs-twitter/display-tweets.php';
             display_tweets_shortcode($username,$cs_twitter_datetime_formate , $cs_tweet_num_from_twitter, $numoftweets, $cs_cache_limit_time,$cs_tweets_color,$username );
    }

}
?>