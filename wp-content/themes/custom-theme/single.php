<?php
/**
 * Single Post Template - くりもとテーマ
 *
 * @package custom-theme
 */

get_header();
?>

<main class="site-main" id="main" role="main">
    <div class="container">
        <div class="content-area">
            <?php while ( have_posts() ) : the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    <!-- 投稿ヘッダー -->
                    <header class="entry-header">

                        <?php
                        $categories = get_the_category();
                        if ( $categories ) :
                        ?>
                        <div class="entry-categories">
                            <?php foreach ( $categories as $cat ) : ?>
                            <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" class="entry-category">
                                <?php echo esc_html( $cat->name ); ?>
                            </a>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>

                        <h1 class="entry-title"><?php the_title(); ?></h1>

                        <div class="entry-meta">
                            <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                <?php echo esc_html( get_the_date( 'Y年m月d日' ) ); ?>
                            </time>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                <?php the_author_posts_link(); ?>
                            </span>
                            <?php if ( comments_open() || get_comments_number() ) : ?>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                <a href="<?php comments_link(); ?>"><?php comments_number( 'コメントなし', '1件', '%件' ); ?></a>
                            </span>
                            <?php endif; ?>
                        </div>

                    </header><!-- /.entry-header -->

                    <!-- アイキャッチ画像 -->
                    <?php if ( has_post_thumbnail() ) : ?>
                    <div class="entry-thumbnail">
                        <?php the_post_thumbnail( 'full', [
                            'loading' => 'eager',
                            'alt'     => esc_attr( get_the_title() ),
                        ] ); ?>
                    </div>
                    <?php endif; ?>

                    <!-- 本文 -->
                    <div class="entry-content">
                        <?php
                        the_content();
                        wp_link_pages( [
                            'before' => '<nav class="page-links"><span class="page-links-title">' . __( 'ページ:', 'custom-theme' ) . '</span>',
                            'after'  => '</nav>',
                        ] );
                        ?>
                    </div>

                    <!-- 投稿フッター -->
                    <footer class="entry-footer">

                        <?php
                        $tags = get_the_tags();
                        if ( $tags ) :
                        ?>
                        <div class="entry-tags">
                            <span class="entry-tags__label">タグ：</span>
                            <?php foreach ( $tags as $tag ) : ?>
                            <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="entry-tag">
                                #<?php echo esc_html( $tag->name ); ?>
                            </a>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>

                        <?php edit_post_link( __( '編集する', 'custom-theme' ), '<span class="edit-link">', '</span>' ); ?>

                    </footer>

                </article>

                <!-- 前後ナビ -->
                <nav class="post-navigation" aria-label="投稿ナビゲーション">
                    <div class="nav-links">
                        <?php
                        $prev_post = get_previous_post();
                        if ( $prev_post ) :
                        ?>
                        <div class="nav-previous">
                            <a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>">
                                <span class="nav-subtitle">← 前の投稿</span>
                                <span class="nav-title"><?php echo esc_html( get_the_title( $prev_post->ID ) ); ?></span>
                            </a>
                        </div>
                        <?php endif; ?>
                        <?php
                        $next_post = get_next_post();
                        if ( $next_post ) :
                        ?>
                        <div class="nav-next">
                            <a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>">
                                <span class="nav-subtitle">次の投稿 →</span>
                                <span class="nav-title"><?php echo esc_html( get_the_title( $next_post->ID ) ); ?></span>
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </nav>

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
