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
  
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta name="keywords" content="">
  <meta name="description" content="<?php bloginfo('description'); ?>">
  <meta name="author" content="Novara Media">

  <meta name="twitter:card" value="summary">
  <meta name="twitter:site" value="@novaramedia">

  <meta property="og:title" content="<?php bloginfo('name'); ?>" />
  <meta property="og:site_name" content="<?php bloginfo('name'); ?>" />
  <meta property="og:description" content="<?php bloginfo('description'); ?>" />
  <meta property="og:type" content="website" />
  <meta property="og:image" content="<?php bloginfo('stylesheet_directory'); ?>/img/favicon.png" />

<!--   <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" /> -->
  <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />

  <link rel="apple-touch-icon" sizes="180x180" href="<?php bloginfo('stylesheet_directory'); ?>/img/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="180x180" href="<?php bloginfo('stylesheet_directory'); ?>/img/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?php bloginfo('stylesheet_directory'); ?>/img/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?php bloginfo('stylesheet_directory'); ?>/img/favicon-16x16.png">
  <link rel="shortcut" href="<?php bloginfo('stylesheet_directory'); ?>/img/favicon.ico">

  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
  
  <?php wp_head(); ?>
  
  <style type="text/css">
    html {
      background-color: black;
      color: white;
      font-family: Helvetica Neue,Helvetica,Arial,sans-serif;
      font-size: 19px;
      letter-spacing: .001em;
    }
    
    .container {
      max-width: 700px;
      margin: 1rem;
    }
    
    .logomark {
      max-width: 40px;
      height: auto;
    }
    
    h1 {
      font-size: 24px;
      font-weight: 500;
    }
    
    a {
      color: white;
      text-decoration: underline;
    }
    
    a:hover {
      text-decoration: none;
    }
  </style>
</head>
<body <?php body_class(); ?>>
  <section class="container">
    <header>
      <a href="https://novaramedia.com"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 235 235" class="logomark"><path fill="#000" d="M0 0h235v235H0z"/><path fill="#fff" d="M39.245 166.85h156.51v14.335H39.245V166.85ZM162.973 53.815h29.257v101.99h-30.785v-44.219l-30.08 44.219h-27.691l-30.0798-44.219v44.219H42.8092V53.815h29.4925l29.9233 50.016V53.815h30.785v50.016l29.963-50.016ZM0 235h235V0H0v235Z"/><path fill="#fff" d="M66.5053 88.4386 107.709 148.52h18.251V60.8652h-16.685v68.5028L67.9153 60.8652h-18.095V148.52h16.685V88.4386Z"/></svg></a>
      
      <h1>This is where we keep our nuts, bolts, xml & audio files. Please find our podcasts below—or find more content on our website.</h1>
    </header>
    
    <ul>
      <li><a href="https://podfollow.com/novaramedia/view">NovaraFM</a></li>
      <li><a href="https://podfollow.com/acfm/view">ACFM</a></li>
      <li><a href="https://podfollow.com/if-i-speak/view">If I Speak</a></li>
      <li><a href="https://podfollow.com/novara-live/view">Novara Live Podcast</a></li>
      <li><a href="https://novaramedia.com/category/audio/foreign-agent/">Foreign Agent</a></li>
      <li><a href="https://podfollow.com/planet-b-everything-must-change/view">Planet B</a></li>
    </ul>
    
    <p>
      <a href="https://novaramedia.com">novaramedia.com</a>
    </p>