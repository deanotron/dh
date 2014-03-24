	<div class="title-page utl-color-b utl-color-p"> 
		<?php if(get_option('UTL_title_logo_image') != ''):?>
			<div class="centered title-page-logo"><img src="<?php echo get_option('UTL_title_logo_image'); ?>"></div>
		<?php else: ?>
	        <div class="centered"><h1><?php bloginfo( 'name' ); ?></h1></div>
	    <?php endif; ?>
        <div class="title-page-cover"></div>
    </div>	
	<footer class="body-footer">
	  <nav class="menu-left"><?php echo get_option('UTL_footer_left'); ?></nav>
  	  <nav class="menu-right"><?php echo get_option('UTL_footer_right'); ?></nav>
	</footer>
	<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/app-grid.dev.js?ver=3.6.1"></script>
	<!-- <?php wp_footer(); ?> -->

	<?php echo get_option('UTL_analytics_embed'); ?>
</body>
</html>