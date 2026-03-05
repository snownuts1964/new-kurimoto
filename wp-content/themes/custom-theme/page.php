<?php
/**
 * Page Template - くりもとテーマ
 *
 * @package custom-theme
 */

get_header();
?>

<!-- ページヘッダー -->
<div class="page-header">
    <div class="container">
        <h1 class="page-title"><?php the_title(); ?></h1>
        <?php
        $description = get_the_excerpt();
        if ( $description ) :
        ?>
        <p class="page-description"><?php echo wp_kses_post( $description ); ?></p>
        <?php endif; ?>
    </div>
</div>

<main class="site-main" id="main" role="main">
    <div class="container">
        <div class="content-area">
            <?php while ( have_posts() ) : the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    <?php if ( has_post_thumbnail() ) : ?>
                    <div class="entry-thumbnail">
                        <?php the_post_thumbnail( 'full', [
                            'loading' => 'eager',
                            'alt'     => esc_attr( get_the_title() ),
                        ] ); ?>
                    </div>
                    <?php endif; ?>

                    <div class="entry-content page-content">
                        <?php
                        the_content();
                        wp_link_pages( [
                            'before' => '<nav class="page-links"><span class="page-links-title">' . __( 'ページ:', 'custom-theme' ) . '</span>',
                            'after'  => '</nav>',
                        ] );
                        ?>
                    </div>

                    <footer class="entry-footer">
                        <?php edit_post_link( __( '編集する', 'custom-theme' ), '<span class="edit-link">', '</span>' ); ?>
                    </footer>

                </article>

                <?php if ( comments_open() || get_comments_number() ) : ?>
                    <?php comments_template(); ?>
                <?php endif; ?>

            <?php endwhile; ?>
        </div><!-- /.content-area -->

        <?php if ( is_active_sidebar( 'sidebar-main' ) ) : ?>
            <aside class="widget-area" role="complementary">
                <?php dynamic_sidebar( 'sidebar-main' ); ?>
            </aside>
        <?php endif; ?>

    </div><!-- /.container -->
</main><!-- /.site-main -->

<?php get_footer(); ?>
