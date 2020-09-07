<?php
	if (is_single()) {
		$meta = get_post_meta($post->ID);
		$redirect = $meta['_cmb_redirect'][0];
		if (isset($redirect)) {
			header('HTTP/1.1 301 Moved Permanently');
			header ('Location: ' . $redirect);
			exit;
		}
	}
?>
<!doctype html>
<html lang="en" prefix="og: http://ogp.me/ns#">
<head>
<meta charset="<?php bloginfo('charset'); ?>">

<title><?php wp_title('|',true,'right'); bloginfo('name'); ?></title>

<!-- meta -->

  	<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame  -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<meta name="keywords" content="">
	<meta name="description" content="<?php bloginfo('description'); ?>">
  <meta name="author" content="">

<!-- social graph meta -->

	<?php if (have_posts()):while(have_posts()):the_post(); endwhile; endif;?>
 	<meta property="fb:admins" content="" />
	<meta name="twitter:card" value="summary">
	<meta name="twitter:site" value="@novaramedia">
<!-- 	<meta name="twitter:creator" value="@"> -->

<?php if (is_home()) { ?>
	<meta property="og:title" content="<?php bloginfo('name'); ?>" />
	<meta property="og:type" content="website" />
	<meta property="og:image" content="<?php bloginfo('stylesheet_directory'); ?>/img/favicon.png" />
<?php } if (is_single()) { ?>
	<meta property="og:url" content="<?php the_permalink() ?>"/>
	<meta property="og:title" content="<?php single_post_title(''); ?>" />
	<meta property="og:type" content="article" />
	<meta property="og:site_name" content="<?php bloginfo('name'); ?>" />
<?php	if(has_post_thumbnail()) { $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'mid-sq' ); ?>
	<meta property="og:image" content="<?php echo $thumb['0'] ?>" />
	<?php } else { ?>
	<meta property="og:image" content="<?php bloginfo('stylesheet_directory'); ?>/img/favicon.png" />
	<?php }
} else { ?>
	<meta property="og:site_name" content="<?php bloginfo('name'); ?>" />
	<meta property="og:description" content="<?php bloginfo('description'); ?>" />
	<meta property="og:type" content="website" />
	<meta property="og:image" content="<?php bloginfo('stylesheet_directory'); ?>/img/favicon.png" />
<?php } ?>

<!-- links -->

	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />

	<link rel="apple-touch-icon" sizes="180x180" href="<?php bloginfo('stylesheet_directory'); ?>/img/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="180x180" href="<?php bloginfo('stylesheet_directory'); ?>/img/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?php bloginfo('stylesheet_directory'); ?>/img/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?php bloginfo('stylesheet_directory'); ?>/img/favicon-16x16.png">
	<link rel="shortcut" href="<?php bloginfo('stylesheet_directory'); ?>/img/favicon.ico">

	<!-- wordpress header -->
	 <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php wp_head(); ?>
</head>

<!-- start page -->
<body <?php body_class(); ?>>
<div id="page-holder">
<div id="holder">

<section id="container">

<!-- sub 7.0 internet explorer warning-->
<!--[if lt IE 7 ]>The website will not work properly on Internet Explorer versions older than 7 as they are outdated, instable and insecure. Free (and improved) browsers can be downloaded for free: <a href="www.google.com/chrome">Google Chrome</a>, <a href="www.getfirefox.net/">Mozilla Firefox</a>, or <a href="www.apple.com/safari/">Apple Safari</a> <![endif]-->

<!-- start content -->
<header>

	<a href="https://novaramedia.com"><img id="logo" alt="Novara Media logomark" src="<?php bloginfo('stylesheet_directory'); ?>/img/nm-white-200.png"></a>

	<br/>

	<h3>Novara Media Podcast</h3>

</header>

<div class="row cf">
	<div class="col col12">
		<div class="podcast-link"><h2 class="arrow">&#8605;</h2><h2><a href="https://podfollow.com/novaramedia/view">Listen & Subscribe</a></h2></div>
	</div>
</div>

<div class="row cf">
	<div class="col col12">
		<div class="podcast-link"><h2 class="arrow">&#8605;</h2><h2><a href="https://novaramedia.com">novaramedia.com</a></h2></div>
	</div>
</div>