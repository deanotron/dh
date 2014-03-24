<!doctype html>
<!-- HTML5 Boilerplate -->
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html class="no-js lt-ie9 lt-ie8" lang="en"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html class="no-js lt-ie9" lang="en"><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="en" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"><!--<![endif]-->

	<head>
		<title><?php bloginfo( 'name' ); ?><?php wp_title( '|' ); ?></title>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
	  	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" id="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"  />
		
		<meta property="title" content="<?php echo get_the_title();?>"/>
		<meta property="og:title" content="<?php echo get_the_title();?>"/>
		<meta property="og:type" content="website"/>
		<?php if (!has_post_thumbnail( $post->ID)){ ?>
			<meta property="og:image" content="<?php echo get_stylesheet_directory_uri(); ?>/screenshot.png"/>
			<meta property="image" content="<?php echo get_stylesheet_directory_uri(); ?>/screenshot.png"/>
		<?php } else { 
				$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
			?>
			<meta property="og:image" content="<?php echo $thumb[0]; ?>"/>
			<meta property="image" content="<?php echo $thumb[0]; ?>"/>
		<?php } ?>
		<meta property="og:description" content="<?php echo get_bloginfo(); ?>"/>
		<meta property="description" content="<?php echo get_bloginfo(); ?>"/>

		

		<link rel="pingback" href="/xmlrpc.php" />
		<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/img/favicon.png"/>
		<link rel='stylesheet' id='screen-css'  href='<?php echo get_stylesheet_directory_uri(); ?>/css/structure.dev.css' type='text/css' media='screen' />
		<link rel="EditURI" type="application/rsd+xml" title="RSD" href="/xmlrpc.php?rsd" />
		<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="/wp-includes/wlwmanifest.xml" />
		<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/js/vendor/custom.modernizr.js'></script> 
		
		<link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Karla:400,700italic,400italic,700' rel='stylesheet' type='text/css'>

		<!--
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/img/favicon.ico"/>
		<?php wp_head(); ?>
		-->

		<!-- UTL CONFIG -->
		<style id="utl-colors" type="text/css"></style>
		<script>
		window.config = window.config || {};
		window.UTL = {
			"title": "<?php bloginfo( 'name' ); ?>",
		};

		window.config.UTL_stage_UD_title = "<?php echo get_option('UTL_stage_UD_title'); ?>";
		window.config.UTL_stage_UD_label = "<?php echo get_option('UTL_stage_UD_label'); ?>";
		window.config.UTL_stage_BD_title = "<?php echo get_option('UTL_stage_BD_title'); ?>";
		window.config.UTL_stage_BD_label = "<?php echo get_option('UTL_stage_BD_label'); ?>";
		window.config.UTL_stage_FM_title = "<?php echo get_option('UTL_stage_FM_title'); ?>";
		window.config.UTL_stage_FM_label = "<?php echo get_option('UTL_stage_FM_label'); ?>";
		window.config.UTL_stage_SE_title = "<?php echo get_option('UTL_stage_SE_title'); ?>";
		window.config.UTL_stage_SE_label = "<?php echo get_option('UTL_stage_SE_label'); ?>";
		window.config.UTL_stage_C_title = "<?php echo get_option('UTL_stage_C_title'); ?>";
		window.config.UTL_stage_C_label = "<?php echo get_option('UTL_stage_C_label'); ?>";
		window.config.UTL_stage_P_title = "<?php echo get_option('UTL_stage_P_title'); ?>";
		window.config.UTL_stage_P_label = "<?php echo get_option('UTL_stage_P_label'); ?>";
		window.config.UTL_stage_O_title = "<?php echo get_option('UTL_stage_O_title'); ?>";
		window.config.UTL_stage_O_label = "<?php echo get_option('UTL_stage_O_label'); ?>";
		window.config.UTL_stage_F_title = "<?php echo get_option('UTL_stage_F_title'); ?>";
		window.config.UTL_stage_F_label = "<?php echo get_option('UTL_stage_F_label'); ?>";
		window.config.UTL_stage_U_title = "<?php echo get_option('UTL_stage_U_title'); ?>";
		window.config.UTL_stage_U_label = "<?php echo get_option('UTL_stage_U_label'); ?>";
		</script>


	</head>

	<body <?php body_class(); ?>>
