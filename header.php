<!doctype html <?php language_attributes(); ?>>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title><?php wp_title(); ?></title>
	<meta property="og:url" content="<?php $url = get_permalink($post->ID); echo $url; ?>" />
	<meta property="og:title" content="<?php $title = get_the_title($post->ID); echo $title; ?>" />
	<meta property="og:image" content="<?php $media = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); echo $media; ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link href='https://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>

<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div class="demo-layout-transparent mdl-layout mdl-js-layout">
    <!-- MENU PRINCIPALE -->
    <header class="mdl-layout__header mdl-layout__header--transparent" style="background-image: url('<?php echo get_header_image(); ?>');">



        <div class="mdl-layout__header-row">
            <!-- CUSTOM LOGO -->
            <?php if ( get_theme_mod( 'themeslug_logo' ) ) : ?>
                <a  class="mdl-layout-title uno" href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'>
                    <img src='<?php echo esc_url( get_theme_mod( 'themeslug_logo' ) ); ?>' style="width:auto; height:120px;" alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> '>
                </a>
            <?php else : ?>
                <span class="mdl-layout-title uno"><a href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'><?php bloginfo( 'name' ); ?></a></span>
            <?php endif; ?>

            <?php wp_nav_menu( array(
                    'container' => 'nav',
                    'container_class' => 'mdl-navigation',
                    'container_id' => 'menu_principale',
                    'theme_location' => 'menu_principale'
                  ) ); ?>
        </div>
    </header>
    <!-- MENU SECONDARIO -->
    <?php $menu = wp_nav_menu( array(
                    'container' => 'nav',
                    'container_class' => 'mdl-navigation',
                    'container_id' => 'menu_secondario',
                    'theme_location' => 'menu_secondario',
                    'echo' => FALSE,
                'fallback_cb' => '__return_false'
                  ) );
    if(! empty ($menu) ){
     echo ('<header class="mdl-layout__header" id="cat-menu"><div class="mdl-layout__header-row">' . $menu . '</div></header>');
    } ?>
    <!-- MENU MOBILE -->
    <div class="mdl-layout__drawer">
        <span class="mdl-layout-title"><?php bloginfo('title'); ?></span>
        <!-- PRINCIPALE -->
        <?php wp_nav_menu( array(
                'container' => 'nav',
                'container_class' => 'mdl-navigation',
                'container_id' => 'menu_principale',
                'theme_location' => 'menu_principale'
              ) ); ?>
        <hr>
        <!-- SECONDARIO -->
        <?php wp_nav_menu( array(
                'container' => 'nav',
                'container_class' => 'mdl-navigation',
                'container_id' => 'menu_secondario',
                'theme_location' => 'menu_secondario'
              ) ); ?>
    </div>
    <!-- FINE HEADER -->
    <main class="mdl-layout__content">
        <div class="page-content">
