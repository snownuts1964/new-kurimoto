<?php
/**
 * The main template file
 *
 * @package custom-theme
 */

get_header();
?>

<main id="primary" class="site-main" role="main">
    <div class="container">
        <div class="content-area">

            <?php if ( have_posts() ) : ?>

                <?php if ( is_home() && ! is_front_page() ) : ?>
                    <header class="page-header">
                        <h1 class="page-title"><?php single_post_title(); ?></h1>
                    </header>
                <?php endif; ?>

                <div class="posts-grid">
                    <?php while ( have_posts() ) : the_post(); ?>

                        <article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>

                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="post-card__thumbnail">
                                    <a href="<?php the_permalink(); ?>" tabindex="-1">
                                        <?php the_post_thumbnail( 'custom-card', [
                                            'alt' => the_title_attribute( [ 'echo' => false ] ),
                                        ] ); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <div class="post-card__body">

                                <!-- カテゴリー -->
                                <?php if ( 'post' === get_post_type() ) : ?>
                                    <div class="post-card__meta">
                                        <?php
                                        $categories = get_the_category();
                                        if ( $categories ) :
                                            foreach ( array_slice( $categories, 0, 2 ) as $cat ) :
                                        ?>
                                            <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>"
                                               class="post-card__category">
                                                <?php echo esc_html( $cat->name ); ?>
                                            </a>
                                        <?php
                                            endforeach;
                                        endif;
                                        ?>
                                    </div>
                                <?php endif; ?>

                                <!-- タイトル -->
                                <h2 class="post-card__title">
                                    <a href="<?php the_permalink(); ?>" rel="bookmark">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>

                                <!-- 投稿情報 -->
                                <?php if ( 'post' === get_post_type() ) : ?>
                                    <div class="post-card__info">
                                        <time class="post-card__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                                            <?php echo esc_html( get_the_date() ); ?>
                                        </time>
                                        <span class="post-card__author">
                                            <?php esc_html_e( 'by', 'custom-theme' ); ?>
                                            <?php the_author_posts_link(); ?>
                                        </span>
                                    </div>
                                <?php endif; ?>

                                <!-- 抜粋 -->
                                <div class="post-card__excerpt">
                                    <?php the_excerpt(); ?>
                                </div>

                                <!-- 続きを読む -->
                                <div class="post-card__footer">
                                    <a href="<?php the_permalink(); ?>" class="btn btn--primary btn--sm">
                                        <?php esc_html_e( '続きを読む', 'custom-theme' ); ?>
                                        <span class="screen-reader-text">
                                            <?php the_title( '"', '"' ); ?>
                                        </span>
                                    </a>
                                </div>

                            </div><!-- .post-card__body -->
                        </article><!-- #post-<?php the_ID(); ?> -->

                    <?php endwhile; ?>
                </div><!-- .posts-grid -->

                <!-- ページネーション -->
                <nav class="pagination" aria-label="<?php esc_attr_e( 'ページナビゲーション', 'custom-theme' ); ?>">
                    <?php
                    the_posts_pagination( [
                        'mid_size'           => 2,
                        'prev_text'          => '<span aria-hidden="true">&laquo;</span><span class="screen-reader-text">' . __( '前へ', 'custom-theme' ) . '</span>',
                        'next_text'          => '<span class="screen-reader-text">' . __( '次へ', 'custom-theme' ) . '</span><span aria-hidden="true">&raquo;</span>',
                        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'custom-theme' ) . ' </span>',
                    ] );
                    ?>
                </nav>

            <?php else : ?>

                <!-- 投稿が見つからない場合 -->
                <div class="no-results">
                    <header class="page-header">
                        <h1 class="page-title"><?php esc_html_e( 'コンテンツが見つかりませんでした', 'custom-theme' ); ?></h1>
                    </header>
                    <div class="page-content">
                        <p><?php esc_html_e( 'お探しのコンテンツは見つかりませんでした。別のキーワードで検索してみてください。', 'custom-theme' ); ?></p>
                        <?php get_search_form(); ?>
                    </div>
                </div>

            <?php endif; ?>

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
