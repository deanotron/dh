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
		
		<link rel="EditURI" type="application/rsd+xml" title="RSD" href="/xmlrpc.php?rsd" />
		<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="/wp-includes/wlwmanifest.xml" />
		

		<!-- <link rel="stylesheet" href="//brick.a.ssl.fastly.net/Linux+Libertine:400,700"> -->
		<!-- <link href='http://fonts.googleapis.com/css?family=PT+Serif' rel='stylesheet' type='text/css'> -->
		<link href='<?php echo get_stylesheet_directory_uri(); ?>/css/consulting.css' rel='stylesheet' type='text/css'>

		 <!--[if lt IE 9]>
	      	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	      	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	    <![endif]-->

		<script src='<?php echo get_stylesheet_directory_uri(); ?>/js/vendor/modernizr.custom.48341.js'></script>



		<!-- UTL CONFIG -->
		<style id="utl-colors" type="text/css"></style>
		<script>
		window.config = window.config || {};
		window.UTL = {
			"title": "<?php bloginfo( 'name' ); ?>",
		};

		window.config.UTL_stage_UD_title = "<?php echo get_option('UTL_stage_UD_title'); ?>";

		</script>


	</head>

	<body <?php body_class(); ?>>
