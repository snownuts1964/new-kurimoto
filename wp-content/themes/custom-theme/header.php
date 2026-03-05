<?php
/**
 * Header Template - くりもとテーマ
 *
 * @package custom-theme
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'site-wrapper' ); ?>>
<?php wp_body_open(); ?>

<!-- ========== サイトヘッダー ========== -->
<header class="site-header" id="site-header" role="banner">
    <div class="header-inner">

        <!-- ブランディング（ロゴ / サイト名）-->
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-branding" rel="home" aria-label="<?php bloginfo( 'name' ); ?> - ホームへ戻る">
            <?php if ( has_custom_logo() ) : ?>
                <?php
                $logo_id  = get_theme_mod( 'custom_logo' );
                $logo_img = wp_get_attachment_image( $logo_id, 'full', false, [
                    'class' => 'site-branding__logo',
                    'alt'   => get_bloginfo( 'name' ),
                ] );
                echo $logo_img;
                ?>
            <?php else : ?>
                <span class="site-branding__name">
                    <?php bloginfo( 'name' ); ?>
                    <?php if ( get_bloginfo( 'description' ) ) : ?>
                        <small><?php bloginfo( 'description' ); ?></small>
                    <?php endif; ?>
                </span>
            <?php endif; ?>
        </a>

        <!-- ヘッダー右エリア -->
        <div class="header-right">

            <!-- デスクトップナビゲーション -->
            <nav class="main-navigation" id="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'メインナビゲーション', 'custom-theme' ); ?>">
                <?php
                wp_nav_menu( [
                    'theme_location' => 'primary',
                    'menu_class'     => 'nav-menu',
                    'container'      => false,
                    'walker'         => new Custom_Theme_Walker_Nav(),
                    'fallback_cb'    => function() {
                        echo '<ul class="nav-menu">';
                        $pages = get_pages( [ 'sort_column' => 'menu_order' ] );
                        foreach ( $pages as $page ) {
                            $active = is_page( $page->ID ) ? ' current-menu-item' : '';
                            printf(
                                '<li class="menu-item%s"><a href="%s" class="nav-link">%s</a></li>',
                                esc_attr( $active ),
                                esc_url( get_permalink( $page->ID ) ),
                                esc_html( $page->post_title )
                            );
                        }
                        echo '</ul>';
                    },
                ] );
                ?>
            </nav>

            <!-- 電話番号 -->
            <a href="tel:0274747788" class="header-contact" aria-label="お電話でのお問い合わせ">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 11a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 0h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 7.91a16 16 0 0 0 8 8l1.27-.9a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 24 17.92z"/>
                </svg>
                <div>
                    <span>0274-74-7788</span>
                    <small>営業時間 11:00〜14:30</small>
                </div>
            </a>

            <!-- ハンバーガーボタン -->
            <button
                class="menu-toggle"
                id="menu-toggle"
                aria-expanded="false"
                aria-controls="mobile-menu"
                aria-label="<?php esc_attr_e( 'メニューを開く', 'custom-theme' ); ?>"
            >
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </button>

        </div><!-- /.header-right -->
    </div><!-- /.header-inner -->
</header><!-- /.site-header -->

<!-- ========== モバイルメニュー ========== -->
<div class="mobile-menu" id="mobile-menu" aria-hidden="true" role="dialog" aria-label="<?php esc_attr_e( 'モバイルメニュー', 'custom-theme' ); ?>">
    <div class="mobile-menu__header">
        <span class="mobile-menu__title">MENU</span>
        <button class="mobile-menu__close" id="mobile-menu-close" aria-label="<?php esc_attr_e( 'メニューを閉じる', 'custom-theme' ); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
    </div>

    <nav class="mobile-menu__nav" aria-label="<?php esc_attr_e( 'モバイルナビゲーション', 'custom-theme' ); ?>">
        <?php
        wp_nav_menu( [
            'theme_location' => 'primary',
            'container'      => false,
            'menu_class'     => 'mobile-nav-list',
            'item_spacing'   => 'discard',
            'fallback_cb'    => function() {
                echo '<ul class="mobile-nav-list">';
                $pages = get_pages( [ 'sort_column' => 'menu_order' ] );
                foreach ( $pages as $page ) {
                    printf(
                        '<li class="mobile-nav-item"><a href="%s">%s <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg></a></li>',
                        esc_url( get_permalink( $page->ID ) ),
                        esc_html( $page->post_title )
                    );
                }
                echo '</ul>';
            },
        ] );
        ?>
    </nav>

    <div class="mobile-menu__footer">
        <a href="tel:0274747788" class="mobile-contact" aria-label="お電話でのお問い合わせ">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 11a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 0h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 7.91a16 16 0 0 0 8 8l1.27-.9a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 24 17.92z"/>
            </svg>
            <div>
                <span>0274-74-7788</span>
                <small>営業時間 11:00〜14:30（木曜定休）</small>
            </div>
        </a>
    </div>
</div>

<!-- オーバーレイ -->
<div class="mobile-menu-overlay" id="mobile-menu-overlay" aria-hidden="true"></div>

<!-- ========== メインコンテンツ開始 ========== -->
<div id="content" class="site-content">
