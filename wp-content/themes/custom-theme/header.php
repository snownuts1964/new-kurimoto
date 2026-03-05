<?php
/**
 * The header for the custom theme
 *
 * @package custom-theme
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary">
        <?php esc_html_e( 'コンテンツへスキップ', 'custom-theme' ); ?>
    </a>

    <header id="masthead" class="site-header" role="banner">
        <div class="container">
            <div class="header-inner">

                <!-- ロゴ / サイトタイトル -->
                <div class="site-branding">
                    <?php if ( has_custom_logo() ) : ?>
                        <div class="site-logo">
                            <?php the_custom_logo(); ?>
                        </div>
                    <?php else : ?>
                        <?php if ( is_front_page() && is_home() ) : ?>
                            <h1 class="site-title">
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                    <?php bloginfo( 'name' ); ?>
                                </a>
                            </h1>
                        <?php else : ?>
                            <p class="site-title">
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                    <?php bloginfo( 'name' ); ?>
                                </a>
                            </p>
                        <?php endif; ?>
                        <?php
                        $description = get_bloginfo( 'description', 'display' );
                        if ( $description || is_customize_preview() ) :
                        ?>
                            <p class="site-description"><?php echo esc_html( $description ); ?></p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div><!-- .site-branding -->

                <!-- ナビゲーション -->
                <nav id="site-navigation" class="main-navigation" role="navigation"
                     aria-label="<?php esc_attr_e( 'プライマリーメニュー', 'custom-theme' ); ?>">

                    <!-- ハンバーガーボタン -->
                    <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"
                            aria-label="<?php esc_attr_e( 'メニューを開く', 'custom-theme' ); ?>">
                        <span class="hamburger">
                            <span class="hamburger__line"></span>
                            <span class="hamburger__line"></span>
                            <span class="hamburger__line"></span>
                        </span>
                        <span class="menu-toggle__text"><?php esc_html_e( 'メニュー', 'custom-theme' ); ?></span>
                    </button>

                    <?php
                    wp_nav_menu( [
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'nav-menu',
                        'container'      => false,
                        'fallback_cb'    => '__return_false',
                    ] );
                    ?>
                </nav><!-- #site-navigation -->

            </div><!-- .header-inner -->
        </div><!-- .container -->
    </header><!-- #masthead -->

    <div id="content" class="site-content">
