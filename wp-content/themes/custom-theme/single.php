<?php
/**
 * The template for displaying all single posts
 *
 * @package custom-theme
 */

get_header();
?>

<main id="primary" class="site-main" role="main">
    <div class="container">
        <div class="content-area">

            <?php while ( have_posts() ) : the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post' ); ?>>

                    <!-- 投稿ヘッダー -->
                    <header class="entry-header">
                        <?php
                        $categories = get_the_category();
                        if ( $categories ) : ?>
                            <div class="entry-categories">
                                <?php foreach ( $categories as $cat ) : ?>
                                    <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>"
                                       class="entry-category">
                                        <?php echo esc_html( $cat->name ); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

                        <div class="entry-meta">
                            <time class="entry-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="16" height="16" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                                <?php echo esc_html( get_the_date() ); ?>
                            </time>

                            <span class="entry-author">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="16" height="16" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                                <?php the_author_posts_link(); ?>
                            </span>

                            <?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
                                <span class="entry-comments">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="16" height="16" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                                    </svg>
                                    <a href="<?php comments_link(); ?>">
                                        <?php
                                        printf(
                                            esc_html( _n( '%s コメント', '%s コメント', get_comments_number(), 'custom-theme' ) ),
                                            number_format_i18n( get_comments_number() )
                                        );
                                        ?>
                                    </a>
                                </span>
                            <?php endif; ?>
                        </div><!-- .entry-meta -->
                    </header><!-- .entry-header -->

                    <!-- アイキャッチ画像 -->
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="entry-thumbnail">
                            <?php the_post_thumbnail( 'custom-wide', [
                                'alt' => the_title_attribute( [ 'echo' => false ] ),
                            ] ); ?>
                        </div>
                    <?php endif; ?>

                    <!-- コンテンツ -->
                    <div class="entry-content">
                        <?php
                        the_content( sprintf(
                            wp_kses(
                                /* translators: %s: Name of current post. */
                                __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'custom-theme' ),
                                [ 'span' => [ 'class' => [] ] ]
                            ),
                            wp_kses_post( get_the_title() )
                        ) );

                        wp_link_pages( [
                            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'custom-theme' ),
                            'after'  => '</div>',
                        ] );
                        ?>
                    </div><!-- .entry-content -->

                    <!-- 投稿フッター（タグ・編集リンク） -->
                    <footer class="entry-footer">
                        <?php
                        $tags = get_the_tags();
                        if ( $tags ) : ?>
                            <div class="entry-tags">
                                <span class="entry-tags__label">
                                    <?php esc_html_e( 'タグ:', 'custom-theme' ); ?>
                                </span>
                                <?php foreach ( $tags as $tag ) : ?>
                                    <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>"
                                       class="entry-tag">
                                        <?php echo esc_html( $tag->name ); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <?php
                        edit_post_link(
                            sprintf(
                                wp_kses(
                                    __( 'Edit <span class="screen-reader-text">%s</span>', 'custom-theme' ),
                                    [ 'span' => [ 'class' => [] ] ]
                                ),
                                wp_kses_post( get_the_title() )
                            ),
                            '<span class="edit-link">',
                            '</span>'
                        );
                        ?>
                    </footer><!-- .entry-footer -->

                </article><!-- #post-<?php the_ID(); ?> -->

                <!-- 前後の投稿ナビゲーション -->
                <nav class="post-navigation" aria-label="<?php esc_attr_e( '投稿ナビゲーション', 'custom-theme' ); ?>">
                    <?php
                    the_post_navigation( [
                        'prev_text' => '<span class="nav-subtitle">' . esc_html__( '前の投稿', 'custom-theme' ) . '</span> <span class="nav-title">%title</span>',
                        'next_text' => '<span class="nav-subtitle">' . esc_html__( '次の投稿', 'custom-theme' ) . '</span> <span class="nav-title">%title</span>',
                    ] );
                    ?>
                </nav>

                <!-- コメント -->
                <?php
                if ( comments_open() || get_comments_number() ) {
                    comments_template();
                }
                ?>

            <?php endwhile; ?>

        </div><!-- .content-area -->

        <?php if ( is_active_sidebar( 'sidebar-main' ) ) : ?>
            <aside id="secondary" class="widget-area" role="complementary">
                <?php dynamic_sidebar( 'sidebar-main' ); ?>
            </aside>
        <?php endif; ?>

    </div><!-- .container -->
</main><!-- #primary -->

<?php
get_footer();
