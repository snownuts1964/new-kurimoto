<?php
/**
 * Kurimoto Custom Theme - functions.php
 *
 * @package custom-theme
 * @version 2.0.0
 */

// 定数
define( 'CUSTOM_THEME_VERSION', '2.0.0' );
define( 'CUSTOM_THEME_DIR', get_template_directory() );
define( 'CUSTOM_THEME_URI', get_template_directory_uri() );

// =============================================================================
// テーマサポート
// =============================================================================
function custom_theme_setup() {
    // 翻訳
    load_theme_textdomain( 'custom-theme', CUSTOM_THEME_DIR . '/languages' );

    // テーマサポート
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'html5', [
        'search-form', 'comment-form', 'comment-list',
        'gallery', 'caption', 'style', 'script',
    ] );
    add_theme_support( 'custom-logo', [
        'height'      => 80,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ] );
    add_theme_support( 'align-wide' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'editor-styles' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'customize-selective-refresh-widgets' );

    // 画像サイズ
    add_image_size( 'hero-slide',     1920, 720,  true );
    add_image_size( 'menu-card',      600,  450,  true );
    add_image_size( 'post-card',      600,  400,  true );
    add_image_size( 'post-thumbnail', 800,  533,  true );

    // ナビゲーションメニュー
    register_nav_menus( [
        'primary'    => __( 'メインナビゲーション', 'custom-theme' ),
        'footer'     => __( 'フッターナビゲーション', 'custom-theme' ),
        'mobile'     => __( 'モバイルナビゲーション', 'custom-theme' ),
    ] );
}
add_action( 'after_setup_theme', 'custom_theme_setup' );

// コンテンツ幅
function custom_theme_content_width() {
    $GLOBALS['content_width'] = 1200;
}
add_action( 'after_setup_theme', 'custom_theme_content_width', 0 );

// =============================================================================
// ウィジェットエリア登録
// =============================================================================
function custom_theme_widgets_init() {
    $defaults = [
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ];

    register_sidebar( array_merge( $defaults, [
        'name' => __( 'サイドバー', 'custom-theme' ),
        'id'   => 'sidebar-main',
    ] ) );

    for ( $i = 1; $i <= 3; $i++ ) {
        register_sidebar( array_merge( $defaults, [
            'name' => sprintf( __( 'フッターウィジェット %d', 'custom-theme' ), $i ),
            'id'   => 'footer-widget-' . $i,
        ] ) );
    }
}
add_action( 'widgets_init', 'custom_theme_widgets_init' );

// =============================================================================
// スクリプト・スタイル登録
// =============================================================================
function custom_theme_enqueue_assets() {
    $ver = CUSTOM_THEME_VERSION;

    // Google Fonts
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&family=Noto+Serif+JP:wght@400;700&display=swap',
        [],
        null
    );

    // テーマスタイル（dist/css/main.css + style.css 経由）
    wp_enqueue_style(
        'custom-theme-style',
        get_stylesheet_uri(),
        [ 'google-fonts' ],
        $ver
    );

    // メイン JS
    wp_enqueue_script(
        'custom-theme-main',
        CUSTOM_THEME_URI . '/dist/js/main.js',
        [],
        $ver,
        true
    );

    // コメント返信
    if ( is_singular() && comments_open() ) {
        wp_enqueue_script( 'comment-reply' );
    }

    // JS にデータを渡す
    wp_localize_script( 'custom-theme-main', 'kurimotoTheme', [
        'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
        'homeUrl'   => home_url( '/' ),
        'themeUrl'  => CUSTOM_THEME_URI,
        'nonce'     => wp_create_nonce( 'custom_theme_nonce' ),
        'isHome'    => is_front_page() ? 'true' : 'false',
    ] );
}
add_action( 'wp_enqueue_scripts', 'custom_theme_enqueue_assets' );

// =============================================================================
// カスタム抜粋
// =============================================================================
function custom_theme_excerpt_length( $length ) {
    return 60;
}
add_filter( 'excerpt_length', 'custom_theme_excerpt_length' );

function custom_theme_excerpt_more( $more ) {
    return '…';
}
add_filter( 'excerpt_more', 'custom_theme_excerpt_more' );

// =============================================================================
// ボディクラス
// =============================================================================
function custom_theme_body_classes( $classes ) {
    if ( is_singular() ) {
        $classes[] = 'is-singular';
    }
    if ( has_post_thumbnail() ) {
        $classes[] = 'has-thumbnail';
    }
    if ( is_active_sidebar( 'sidebar-main' ) ) {
        $classes[] = 'has-sidebar';
    }
    return $classes;
}
add_filter( 'body_class', 'custom_theme_body_classes' );

// =============================================================================
// インクルード
// =============================================================================
foreach ( [ 'template-tags', 'custom-hooks', 'custom-post-types' ] as $include ) {
    $path = CUSTOM_THEME_DIR . '/inc/' . $include . '.php';
    if ( file_exists( $path ) ) {
        require_once $path;
    }
}

// =============================================================================
// ナビゲーション Walker（カスタムクラス付与）
// =============================================================================
class Custom_Theme_Walker_Nav extends Walker_Nav_Menu {

    public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
        $item = $data_object;
        $classes = empty( $item->classes ) ? [] : (array) $item->classes;
        $has_children = in_array( 'menu-item-has-children', $classes );

        $output .= '<li class="' . esc_attr( implode( ' ', $classes ) ) . '">';

        $attrs = '';
        $link_class = $depth === 0 ? 'nav-link' : 'sub-nav-link';
        if ( $has_children && $depth === 0 ) {
            $attrs .= ' aria-haspopup="true" aria-expanded="false"';
        }

        $output .= '<a href="' . esc_url( $item->url ) . '" class="' . esc_attr( $link_class ) . '"' . $attrs . '>';
        $output .= esc_html( $item->title );
        if ( $has_children && $depth === 0 ) {
            $output .= '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>';
        }
        $output .= '</a>';
    }
}
