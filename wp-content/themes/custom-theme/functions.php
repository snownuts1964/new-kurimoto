<?php
/**
 * Custom Theme functions and definitions
 *
 * @package custom-theme
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// テーマバージョン定数
define( 'CUSTOM_THEME_VERSION', '1.0.0' );
define( 'CUSTOM_THEME_DIR', get_template_directory() );
define( 'CUSTOM_THEME_URI', get_template_directory_uri() );

/**
 * テーマセットアップ
 */
function custom_theme_setup() {
    // 翻訳ファイルの読み込み
    load_theme_textdomain( 'custom-theme', CUSTOM_THEME_DIR . '/languages' );

    // タイトルタグ対応
    add_theme_support( 'title-tag' );

    // 投稿サムネイル（アイキャッチ画像）対応
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 1200, 630, true );

    // カスタムサムネイルサイズ
    add_image_size( 'custom-card', 400, 300, true );
    add_image_size( 'custom-wide', 1200, 500, true );

    // HTML5 マークアップ対応
    add_theme_support( 'html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ] );

    // カスタムロゴ対応
    add_theme_support( 'custom-logo', [
        'height'      => 80,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ] );

    // カスタム背景対応
    add_theme_support( 'custom-background', [
        'default-color' => 'ffffff',
    ] );

    // フィードリンク対応
    add_theme_support( 'automatic-feed-links' );

    // ウィジェットの選択的更新対応
    add_theme_support( 'customize-selective-refresh-widgets' );

    // ブロックエディター対応
    add_theme_support( 'align-wide' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'editor-styles' );

    // コンテンツ幅
    if ( ! isset( $content_width ) ) {
        $content_width = 1200;
    }
}
add_action( 'after_setup_theme', 'custom_theme_setup' );

/**
 * スクリプト・スタイルの読み込み
 */
function custom_theme_scripts() {
    // メインスタイルシート（テーマ識別用）
    wp_enqueue_style(
        'custom-theme-style',
        get_stylesheet_uri(),
        [],
        CUSTOM_THEME_VERSION
    );

    // コンパイル済みメインCSS
    wp_enqueue_style(
        'custom-theme-main',
        CUSTOM_THEME_URI . '/dist/css/main.css',
        [],
        CUSTOM_THEME_VERSION
    );

    // Google Fonts
    wp_enqueue_style(
        'custom-theme-fonts',
        'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&family=Noto+Serif+JP:wght@400;700&display=swap',
        [],
        null
    );

    // メインJavaScript
    wp_enqueue_script(
        'custom-theme-main',
        CUSTOM_THEME_URI . '/dist/js/main.js',
        [],
        CUSTOM_THEME_VERSION,
        true // フッターで読み込み
    );

    // コメントフォーム（スレッド表示時）
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'custom_theme_scripts' );

/**
 * ナビゲーションメニュー登録
 */
function custom_theme_register_menus() {
    register_nav_menus( [
        'primary'   => __( 'プライマリーメニュー', 'custom-theme' ),
        'footer'    => __( 'フッターメニュー', 'custom-theme' ),
        'social'    => __( 'ソーシャルメニュー', 'custom-theme' ),
    ] );
}
add_action( 'init', 'custom_theme_register_menus' );

/**
 * ウィジェットエリア（サイドバー）登録
 */
function custom_theme_register_sidebars() {
    // メインサイドバー
    register_sidebar( [
        'name'          => __( 'メインサイドバー', 'custom-theme' ),
        'id'            => 'sidebar-main',
        'description'   => __( 'ブログのメインサイドバーエリア', 'custom-theme' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ] );

    // フッターウィジェット 1
    register_sidebar( [
        'name'          => __( 'フッターウィジェット 1', 'custom-theme' ),
        'id'            => 'footer-widget-1',
        'description'   => __( 'フッター左エリア', 'custom-theme' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ] );

    // フッターウィジェット 2
    register_sidebar( [
        'name'          => __( 'フッターウィジェット 2', 'custom-theme' ),
        'id'            => 'footer-widget-2',
        'description'   => __( 'フッター中央エリア', 'custom-theme' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ] );

    // フッターウィジェット 3
    register_sidebar( [
        'name'          => __( 'フッターウィジェット 3', 'custom-theme' ),
        'id'            => 'footer-widget-3',
        'description'   => __( 'フッター右エリア', 'custom-theme' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ] );
}
add_action( 'widgets_init', 'custom_theme_register_sidebars' );

/**
 * body クラスにカスタムクラスを追加
 */
function custom_theme_body_classes( $classes ) {
    if ( is_singular() ) {
        $classes[] = 'singular';
    }
    if ( is_active_sidebar( 'sidebar-main' ) && ! is_full_width_page() ) {
        $classes[] = 'has-sidebar';
    }
    return $classes;
}
add_filter( 'body_class', 'custom_theme_body_classes' );

/**
 * フルワイドページかどうか判定
 */
function is_full_width_page() {
    if ( is_page() ) {
        $template = get_page_template_slug();
        if ( 'templates/full-width.php' === $template ) {
            return true;
        }
    }
    return false;
}

/**
 * 抜粋文字数の設定
 */
function custom_theme_excerpt_length( $length ) {
    return 80;
}
add_filter( 'excerpt_length', 'custom_theme_excerpt_length', 999 );

/**
 * 抜粋末尾の設定
 */
function custom_theme_excerpt_more( $more ) {
    return '&hellip;';
}
add_filter( 'excerpt_more', 'custom_theme_excerpt_more' );

/**
 * inc ファイルの読み込み
 */
$custom_theme_includes = [
    '/inc/template-tags.php',
    '/inc/custom-hooks.php',
    '/inc/custom-post-types.php',
];

foreach ( $custom_theme_includes as $file ) {
    if ( file_exists( CUSTOM_THEME_DIR . $file ) ) {
        require_once CUSTOM_THEME_DIR . $file;
    }
}
