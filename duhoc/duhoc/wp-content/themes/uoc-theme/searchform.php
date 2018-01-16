<?php
/**
 * The template for displaying Search Form
 */
global $cs_theme_options
?>

<div class="cs-search-area">
    <form method="get" action="<?php echo esc_url(esc_url( home_url('/') )); ?>" >
       	 <input type="text"  name="s"  value="<?php _e('Enter your search', 'uoc'); ?>" class="form-control" >
        <label>
       	 	<input type="submit" value="<?php _e('Search','uoc');?>" class="btnsubmit cs-bg-color">
        </label>
    </form>

</div>