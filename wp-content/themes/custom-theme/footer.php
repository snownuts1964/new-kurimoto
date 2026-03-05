<?php
/**
 * The template for displaying the footer
 *
 * @package custom-theme
 */
?>
    </div><!-- #content -->

    <footer id="colophon" class="site-footer" role="contentinfo">

        <!-- フッターウィジェットエリア -->
        <?php if ( is_active_sidebar( 'footer-widget-1' ) || is_active_sidebar( 'footer-widget-2' ) || is_active_sidebar( 'footer-widget-3' ) ) : ?>
        <div class="footer-widgets">
            <div class="container">
                <div class="footer-widgets__grid">
                    <?php if ( is_active_sidebar( 'footer-widget-1' ) ) : ?>
                    <div class="footer-widgets__col">
                        <?php dynamic_sidebar( 'footer-widget-1' ); ?>
                    </div>
                    <?php endif; ?>

                    <?php if ( is_active_sidebar( 'footer-widget-2' ) ) : ?>
                    <div class="footer-widgets__col">
                        <?php dynamic_sidebar( 'footer-widget-2' ); ?>
                    </div>
                    <?php endif; ?>

                    <?php if ( is_active_sidebar( 'footer-widget-3' ) ) : ?>
                    <div class="footer-widgets__col">
                        <?php dynamic_sidebar( 'footer-widget-3' ); ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div><!-- .footer-widgets -->
        <?php endif; ?>

        <!-- フッターナビゲーション -->
        <?php if ( has_nav_menu( 'footer' ) ) : ?>
        <div class="footer-navigation">
            <div class="container">
                <nav aria-label="<?php esc_attr_e( 'フッターメニュー', 'custom-theme' ); ?>">
                    <?php
                    wp_nav_menu( [
                        'theme_location' => 'footer',
                        'menu_id'        => 'footer-menu',
                        'menu_class'     => 'footer-menu',
                        'container'      => false,
                        'depth'          => 1,
                        'fallback_cb'    => '__return_false',
                    ] );
                    ?>
                </nav>
            </div>
        </div>
        <?php endif; ?>

        <!-- コピーライト -->
        <div class="site-info">
            <div class="container">
                <div class="site-info__inner">
                    <p class="copyright">
                        &copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?>
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <?php bloginfo( 'name' ); ?>
                        </a>
                        <?php esc_html_e( 'All Rights Reserved.', 'custom-theme' ); ?>
                    </p>
                    <p class="powered-by">
                        <?php
                        printf(
                            /* translators: %s: WordPress link */
                            esc_html__( 'Powered by %s', 'custom-theme' ),
                            '<a href="https://wordpress.org/" target="_blank" rel="noopener noreferrer">WordPress</a>'
                        );
                        ?>
                    </p>
                </div>
            </div>
        </div><!-- .site-info -->

    </footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
