<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>
<html class="i7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>
<html class="ie" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
    <meta charset="<?php bloginfo( 'charset' ); ?>" >
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=yes">
    <meta name="format-detection" content="telephone=no" >

    <?php if ( is_home() && !is_paged() ): ?>
        <meta name="robots" content="index,follow">
    <?php elseif ( is_search() or is_404() ): ?>
        <meta name="robots" content="noindex,follow">
    <?php elseif ( !is_category() && is_archive() ): ?>
        <meta name="robots" content="noindex,follow">
    <?php elseif ( is_paged() ): ?>
        <meta name="robots" content="noindex,follow">
    <?php endif; ?>

    <link rel="alternate" type="application/rss+xml" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> RSS Feed" href="<?php bloginfo( 'rss2_url' ); ?>" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" >
    <!--[if lt IE 9]>
    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <script src="<?php echo esc_url( get_template_directory_uri() ) ; ?>/js/html5shiv.js"></script>
    <![endif]-->
    <?php if ( is_singular() ) wp_enqueue_script( "comment-reply" ); ?>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?> >
<div id="wrapper">
<div id="wrapper-in">
    <header id="header"><!-- header -->
        <div class="inner container" class="clearfix"><!-- header-inner -->
            <div class="row">
                <!-- ハンバーガーボタン -->
                <div class="drawer drawer--left sp-nav none-pc">
                    <button type="button" class="drawer-toggle drawer-hamburger">
                        <span class="sr-only">toggle navigation</span>
                        <span class="drawer-hamburger-icon"></span>
                    </button>
                    <nav class="drawer-nav">
                        <?php
                        wp_nav_menu( array(
                            'theme_location' => 'primary-menu',
                            'container' => false,
                            'items_wrap' => '<ul>%3$s</ul>'
                        ) );
                        ?>
                    </nav>
                </div>
                <div class="column header_logo"><!-- sitettl -->
                    <p class="homename">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/masakydesign-logo-brack.svg" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" width="120" /></a>
                    </p>
                </div><!-- /sitettl -->
                <div class="column column-60 pc-nav sp-none">
                    <?php if ( has_nav_menu( 'primary-menu' ) ) : //メニューセットあり ?>
                        <nav class="container none-sp none-edge" role="navigation" itemscope="itemscope" itemtype="http://scheme.org/SiteNavigationElement">
                            <?php
                            wp_nav_menu( array(
                                'theme_location' => 'primary-menu',
                                'container' => false,
                                'menu_class' => 'row',
                                'items_wrap' => '<ul class="%2$s">%3$s</ul>'
                            ) );
                            ?>
                        </nav>
                    <?php endif; ?>
                </div>
            </div>
        </div><!-- header-inner -->
    </header><!-- /header -->
