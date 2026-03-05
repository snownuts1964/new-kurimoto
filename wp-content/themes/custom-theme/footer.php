<?php
/**
 * Footer Template - くりもとテーマ
 *
 * @package custom-theme
 */
?>
</div><!-- /#content .site-content -->

<!-- ========== サイトフッター ========== -->
<footer class="site-footer" id="site-footer" role="contentinfo">

    <!-- フッター上部 -->
    <div class="footer-top">
        <div class="container">

            <!-- ブランドカラム -->
            <div class="footer-brand">
                <div class="footer-brand__name">
                    <?php bloginfo( 'name' ); ?>
                    <small><?php bloginfo( 'description' ); ?></small>
                </div>
                <p class="footer-brand__tagline">群馬の江戸前手打ちそば</p>
                <div class="footer-brand__contact">
                    <a href="tel:0274747788" aria-label="電話番号">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 11a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 0h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 7.91a16 16 0 0 0 8 8l1.27-.9a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 24 17.92z"/>
                        </svg>
                        <div>
                            <span>0274-74-7788</span>
                            <small>営業時間 11:00〜14:30</small>
                        </div>
                    </a>
                </div>
                <address class="footer-brand__address" style="font-style:normal;">
                    <p>〒370-2343 群馬県高崎市吉井町吉井</p>
                    <p>木曜定休 / 駐車場完備</p>
                </address>
            </div>

            <!-- ウィジェットカラム 1 -->
            <?php if ( is_active_sidebar( 'footer-widget-1' ) ) : ?>
                <div class="footer-widget">
                    <?php dynamic_sidebar( 'footer-widget-1' ); ?>
                </div>
            <?php else : ?>
                <div class="footer-widget">
                    <h3 class="footer-widget__title">ナビゲーション</h3>
                    <ul>
                        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">ホーム</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/kodawari/' ) ); ?>">こだわり</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/menu/' ) ); ?>">メニュー</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/access/' ) ); ?>">店舗案内</a></li>
                        <li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>">ブログ</a></li>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- ウィジェットカラム 2 -->
            <?php if ( is_active_sidebar( 'footer-widget-2' ) ) : ?>
                <div class="footer-widget">
                    <?php dynamic_sidebar( 'footer-widget-2' ); ?>
                </div>
            <?php else : ?>
                <div class="footer-widget">
                    <h3 class="footer-widget__title">営業情報</h3>
                    <ul>
                        <li><a href="#">営業時間：11:00〜14:30</a></li>
                        <li><a href="#">定休日：木曜日</a></li>
                        <li><a href="#">TEL：0274-74-7788</a></li>
                        <li><a href="#">駐車場完備</a></li>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- ウィジェットカラム 3 -->
            <?php if ( is_active_sidebar( 'footer-widget-3' ) ) : ?>
                <div class="footer-widget">
                    <?php dynamic_sidebar( 'footer-widget-3' ); ?>
                </div>
            <?php else : ?>
                <div class="footer-widget">
                    <h3 class="footer-widget__title">周辺観光</h3>
                    <ul>
                        <li><a href="#" rel="noopener">富岡製糸場</a></li>
                        <li><a href="#" rel="noopener">群馬サファリパーク</a></li>
                        <li><a href="#" rel="noopener">こんにゃくパーク</a></li>
                        <li><a href="#" rel="noopener">吉井温泉</a></li>
                    </ul>
                </div>
            <?php endif; ?>

        </div><!-- /.container -->
    </div><!-- /.footer-top -->

    <!-- フッター下部 -->
    <div class="footer-bottom">
        <div class="container">

            <nav class="footer-nav" aria-label="<?php esc_attr_e( 'フッターナビゲーション', 'custom-theme' ); ?>">
                <?php
                wp_nav_menu( [
                    'theme_location' => 'footer',
                    'container'      => false,
                    'depth'          => 1,
                    'fallback_cb'    => '__return_false',
                ] );
                ?>
            </nav>

            <p class="footer-copyright">
                <small>
                    &copy; <?php echo date_i18n( 'Y' ); ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color:inherit;">
                        <?php bloginfo( 'name' ); ?>
                    </a>
                    All Rights Reserved.
                </small>
            </p>

        </div><!-- /.container -->
    </div><!-- /.footer-bottom -->

</footer><!-- /.site-footer -->

<!-- バックトゥトップ -->
<button class="back-to-top" id="back-to-top" aria-label="<?php esc_attr_e( 'ページトップへ戻る', 'custom-theme' ); ?>">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <polyline points="18 15 12 9 6 15"/>
    </svg>
</button>

<?php wp_footer(); ?>
</body>
</html>
