<?php
/**
 * The template for displaying all pages
 *
 * @package custom-theme
 */

get_header();
?>

<main id="primary" class="site-main" role="main">
    <div class="container">
        <div class="content-area">

            <?php while ( have_posts() ) : the_post(); ?>

                <article id="page-<?php the_ID(); ?>" <?php post_class( 'page-content' ); ?>>

                    <!-- ページヘッダー -->
                    <header class="entry-header">
                        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                    </header>

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
                        the_content();

                        wp_link_pages( [
                            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'custom-theme' ),
                            'after'  => '</div>',
                        ] );
                        ?>
                    </div><!-- .entry-content -->

                    <!-- ページフッター -->
                    <?php if ( get_edit_post_link() ) : ?>
                        <footer class="entry-footer">
                            <?php
                            edit_post_link(
                                sprintf(
                                    wp_kses(
                                        /* translators: %s: Name of current post. Only visible to screen readers */
                                        __( 'Edit <span class="screen-reader-text">%s</span>', 'custom-theme' ),
                                        [ 'span' => [ 'class' => [] ] ]
                                    ),
                                    wp_kses_post( get_the_title() )
                                ),
                                '<span class="edit-link">',
                                '</span>'
                            );
                            ?>
                        </footer>
                    <?php endif; ?>

                </article><!-- #page-<?php the_ID(); ?> -->

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
