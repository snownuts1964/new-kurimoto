<?php
/**
 * Index / Front Page Template - くりもとテーマ
 *
 * @package custom-theme
 */

get_header();

// フロントページかどうかで表示を切り替え
if ( is_front_page() && ! is_home() ) :
    // ページが「フロントページ」に設定されているときはページテンプレートへ
    while ( have_posts() ) : the_post();
        get_template_part( 'page' );
    endwhile;

elseif ( is_front_page() ) :
    // フロントページ = 最新投稿表示（ホームページ）
?>

<!-- =====================================================
     ヒーロースライダー
====================================================== -->
<section class="hero-slider" id="hero-slider" aria-label="メインビジュアル">

    <?php
    // スライドデータ（ACF等があれば差し替え可）
    $slides = [
        [
            'image'   => CUSTOM_THEME_URI . '/assets/images/hero-1.jpg',
            'eyebrow' => '群馬・吉井町',
            'title'   => '江戸前手打ちそば',
            'text'    => '吟味した素材と職人の技で打つ、本格江戸前そば。<br>自然豊かな群馬でのひとときを、どうぞご堪能ください。',
            'btn'     => 'メニューを見る',
            'btn_url' => home_url( '/menu/' ),
        ],
        [
            'image'   => CUSTOM_THEME_URI . '/assets/images/hero-2.jpg',
            'eyebrow' => 'こだわりの一杯',
            'title'   => '手打ちならではの<br>風味と食感',
            'text'    => '毎朝打ちたてのそばを、その日限りお出しします。<br>素材と丁寧な仕事が生む、シンプルで深い味わい。',
            'btn'     => 'こだわりを見る',
            'btn_url' => home_url( '/kodawari/' ),
        ],
        [
            'image'   => CUSTOM_THEME_URI . '/assets/images/hero-3.jpg',
            'eyebrow' => '店舗案内',
            'title'   => '上信越道 吉井 IC<br>より車で5分',
            'text'    => '富岡製糸場や群馬サファリパークへのお立ち寄りにも便利な立地です。<br>お気軽にお越しください。',
            'btn'     => 'アクセスを見る',
            'btn_url' => home_url( '/access/' ),
        ],
    ];
    ?>

    <?php foreach ( $slides as $i => $slide ) : ?>
    <div class="hero-slide <?php echo $i === 0 ? 'is-active' : ''; ?>" data-slide="<?php echo esc_attr( $i ); ?>">
        <div class="hero-slide__bg">
            <img
                src="<?php echo esc_url( $slide['image'] ); ?>"
                alt="<?php echo esc_attr( $slide['eyebrow'] . ' - ' . strip_tags( $slide['title'] ) ); ?>"
                <?php echo $i === 0 ? '' : 'loading="lazy"'; ?>
            >
        </div>
        <div class="hero-slide__overlay"></div>
        <div class="hero-slide__content">
            <div class="container">
                <div class="hero-slide__inner">
                    <span class="hero-slide__eyebrow"><?php echo esc_html( $slide['eyebrow'] ); ?></span>
                    <h1 class="hero-slide__title"><?php echo wp_kses_post( $slide['title'] ); ?></h1>
                    <p class="hero-slide__text"><?php echo wp_kses_post( $slide['text'] ); ?></p>
                    <div class="hero-slide__actions">
                        <a href="<?php echo esc_url( $slide['btn_url'] ); ?>" class="btn btn--primary btn--lg">
                            <?php echo esc_html( $slide['btn'] ); ?>
                        </a>
                        <a href="<?php echo esc_url( home_url( '/access/' ) ); ?>" class="btn btn--outline-white btn--lg">
                            店舗案内
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <!-- 矢印ボタン -->
    <button class="hero-prev" id="hero-prev" aria-label="前のスライド">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="15 18 9 12 15 6"/></svg>
    </button>
    <button class="hero-next" id="hero-next" aria-label="次のスライド">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
    </button>

    <!-- ドットインジケーター -->
    <div class="hero-dots" role="tablist" aria-label="スライドインジケーター">
        <?php foreach ( $slides as $i => $slide ) : ?>
        <button
            class="hero-dot <?php echo $i === 0 ? 'is-active' : ''; ?>"
            data-target="<?php echo esc_attr( $i ); ?>"
            role="tab"
            aria-selected="<?php echo $i === 0 ? 'true' : 'false'; ?>"
            aria-label="スライド <?php echo esc_attr( $i + 1 ); ?>"
        ></button>
        <?php endforeach; ?>
    </div>

    <!-- スクロールインジケーター -->
    <a href="#home-menu" class="hero-scroll" aria-label="コンテンツへスクロール">
        <span>SCROLL</span>
        <span class="scroll-line"></span>
    </a>

</section><!-- /.hero-slider -->

<!-- =====================================================
     お知らせバナー
====================================================== -->
<?php
$notice_posts = get_posts( [
    'post_type'      => 'post',
    'posts_per_page' => 1,
    'category_name'  => 'notice',
] );
if ( $notice_posts ) :
    $notice = $notice_posts[0];
?>
<div class="notice-bar" role="alert">
    <div class="container">
        <span class="notice-bar__label">お知らせ</span>
        <p class="notice-bar__text">
            <a href="<?php echo esc_url( get_permalink( $notice->ID ) ); ?>" style="color:inherit;">
                <?php echo esc_html( $notice->post_title ); ?>
            </a>
        </p>
    </div>
</div>
<?php endif; ?>

<!-- =====================================================
     店主のオススメメニュー
====================================================== -->
<section class="section section--white home-menu" id="home-menu">
    <div class="container">
        <header class="section-header">
            <span class="section-subtitle">RECOMMEND</span>
            <h2 class="section-title">店主のオススメメニュー</h2>
            <p>厳選素材と職人の手仕事から生まれた、くりもと自慢の一品</p>
        </header>

        <?php
        // メニューカードデータ（カスタム投稿タイプ or 固定データ）
        $menu_items = [
            [
                'name'  => 'カレーつけ麺',
                'desc'  => 'スパイス香るカレーつけ汁に、手打ちそばを絡めてお召し上がりください。',
                'price' => '1,200',
                'badge' => '人気 No.1',
                'image' => CUSTOM_THEME_URI . '/assets/images/menu-curry.jpg',
                'url'   => home_url( '/menu/' ),
            ],
            [
                'name'  => 'ミニ天丼付きせいろ',
                'desc'  => '香ばしく揚げた天ぷらと、香り高いせいろそばのセットです。',
                'price' => '1,600',
                'badge' => 'おすすめ',
                'image' => CUSTOM_THEME_URI . '/assets/images/menu-tendon.jpg',
                'url'   => home_url( '/menu/' ),
            ],
            [
                'name'  => 'かき揚げせいろ',
                'desc'  => '旬の野菜を使ったかき揚げと、手打ちのせいろそば。',
                'price' => '1,400',
                'badge' => '季節限定',
                'image' => CUSTOM_THEME_URI . '/assets/images/menu-kakiage.jpg',
                'url'   => home_url( '/menu/' ),
            ],
            [
                'name'  => '天ぷら付きそば',
                'desc'  => '海老天と季節野菜の天ぷらが添えられた、定番の温かいそばです。',
                'price' => '1,500',
                'badge' => '定番人気',
                'image' => CUSTOM_THEME_URI . '/assets/images/menu-tenpura.jpg',
                'url'   => home_url( '/menu/' ),
            ],
        ];
        ?>

        <div class="home-menu__grid">
            <?php foreach ( $menu_items as $item ) : ?>
            <a href="<?php echo esc_url( $item['url'] ); ?>" class="menu-card">
                <div class="menu-card__image">
                    <img
                        src="<?php echo esc_url( $item['image'] ); ?>"
                        alt="<?php echo esc_attr( $item['name'] ); ?>"
                        loading="lazy"
                        width="600"
                        height="450"
                    >
                    <span class="menu-card__badge"><?php echo esc_html( $item['badge'] ); ?></span>
                </div>
                <div class="menu-card__body">
                    <h3 class="menu-card__name"><?php echo esc_html( $item['name'] ); ?></h3>
                    <p class="menu-card__desc"><?php echo esc_html( $item['desc'] ); ?></p>
                    <p class="menu-card__price">
                        ¥<?php echo esc_html( $item['price'] ); ?>
                        <small>（税込）</small>
                    </p>
                </div>
            </a>
            <?php endforeach; ?>
        </div>

        <div class="home-menu__footer">
            <a href="<?php echo esc_url( home_url( '/menu/' ) ); ?>" class="btn btn--outline btn--lg">
                全メニューを見る
            </a>
        </div>

    </div>
</section><!-- /.home-menu -->

<!-- =====================================================
     こだわりセクション
====================================================== -->
<section class="section home-feature">
    <div class="container">

        <div class="home-feature__inner">
            <div class="home-feature__image">
                <img
                    src="<?php echo esc_url( CUSTOM_THEME_URI . '/assets/images/feature-soba.jpg' ); ?>"
                    alt="手打ちそばのこだわり"
                    loading="lazy"
                    width="600"
                    height="450"
                >
            </div>
            <div class="home-feature__content">
                <span class="section-subtitle">OUR CRAFT</span>
                <h2 class="section-title">職人のこだわり</h2>
                <p class="home-feature__text">
                    北海道産の玄そば粉を中心に、季節と産地にこだわった素材を使用。
                    毎朝丁寧に打つ「二八そば」は、香りとコシが自慢です。
                    江戸前の技法を守りながら、現代の食卓に合うそばを追求しています。
                </p>
                <ul class="home-feature__list">
                    <li>厳選された国産そば粉を使用</li>
                    <li>毎朝手打ち・当日限りの提供</li>
                    <li>職人が一枚一枚丁寧に仕上げ</li>
                    <li>自家製つゆで素材の旨みを引き立て</li>
                </ul>
                <div class="home-feature__action">
                    <a href="<?php echo esc_url( home_url( '/kodawari/' ) ); ?>" class="btn btn--primary">
                        こだわりをもっと見る
                    </a>
                </div>
            </div>
        </div>

    </div>
</section><!-- /.home-feature -->

<!-- =====================================================
     新着ブログ
====================================================== -->
<?php
$recent_posts = get_posts( [
    'posts_per_page' => 3,
    'post_status'    => 'publish',
] );

if ( $recent_posts ) :
?>
<section class="section section--bg home-blog">
    <div class="container">
        <header class="section-header">
            <span class="section-subtitle">BLOG</span>
            <h2 class="section-title">新着ブログ</h2>
            <p>お店の最新情報や季節のお知らせをお届けします</p>
        </header>

        <div class="home-blog__grid">
            <?php foreach ( $recent_posts as $post ) : setup_postdata( $post ); ?>
            <article class="post-card">
                <?php if ( has_post_thumbnail( $post->ID ) ) : ?>
                <div class="post-card__image">
                    <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" tabindex="-1" aria-hidden="true">
                        <?php echo get_the_post_thumbnail( $post->ID, 'post-card', [
                            'class'   => '',
                            'loading' => 'lazy',
                            'alt'     => esc_attr( get_the_title( $post->ID ) ),
                        ] ); ?>
                    </a>
                    <?php
                    $categories = get_the_category( $post->ID );
                    if ( $categories ) :
                        $cat = $categories[0];
                    ?>
                    <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" class="post-card__category">
                        <?php echo esc_html( $cat->name ); ?>
                    </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <div class="post-card__body">
                    <h3 class="post-card__title">
                        <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>">
                            <?php echo esc_html( get_the_title( $post->ID ) ); ?>
                        </a>
                    </h3>
                    <p class="post-card__excerpt">
                        <?php echo wp_trim_words( get_the_excerpt( $post->ID ), 40, '…' ); ?>
                    </p>
                    <div class="post-card__meta">
                        <time datetime="<?php echo esc_attr( get_the_date( 'c', $post->ID ) ); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            <?php echo esc_html( get_the_date( 'Y.m.d', $post->ID ) ); ?>
                        </time>
                    </div>
                </div>
            </article>
            <?php endforeach; wp_reset_postdata(); ?>
        </div>

        <div class="home-blog__footer">
            <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' ) ); ?>" class="btn btn--outline">
                ブログ一覧を見る
            </a>
        </div>

    </div>
</section><!-- /.home-blog -->
<?php endif; ?>

<!-- =====================================================
     店舗案内・アクセス
====================================================== -->
<section class="section section--white home-access">
    <div class="container">
        <header class="section-header">
            <span class="section-subtitle">ACCESS</span>
            <h2 class="section-title">店舗案内</h2>
        </header>

        <div class="home-access__inner">
            <div class="home-access__map">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3230.0!2d139.05!3d36.19!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzbCsDExJzM1LjAiTiAxMznCsDAzJzAwLjAiRQ!5e0!3m2!1sja!2sjp!4v1"
                    allowfullscreen
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="くりもと 地図"
                ></iframe>
            </div>

            <div class="home-access__info">
                <dl>
                    <dt>店舗名</dt>
                    <dd><?php bloginfo( 'name' ); ?></dd>

                    <dt>住所</dt>
                    <dd>〒370-2343<br>群馬県高崎市吉井町吉井</dd>

                    <dt>電話番号</dt>
                    <dd><a href="tel:0274747788">0274-74-7788</a></dd>

                    <dt>アクセス</dt>
                    <dd>上信越自動車道 吉井ICより車で5分<br>富岡製糸場より国道254号線 車で15分</dd>
                </dl>

                <div class="home-access__hours">
                    <h4>営業時間</h4>
                    <table>
                        <tr>
                            <td>営業時間</td>
                            <td>11:00〜14:30（L.O. 14:00）</td>
                        </tr>
                        <tr>
                            <td>定休日</td>
                            <td>木曜日</td>
                        </tr>
                        <tr>
                            <td>駐車場</td>
                            <td>完備（無料）</td>
                        </tr>
                    </table>
                </div>

                <div style="margin-top: 2rem;">
                    <a href="<?php echo esc_url( home_url( '/access/' ) ); ?>" class="btn btn--primary">
                        詳しいアクセスを見る
                    </a>
                </div>
            </div>
        </div>

    </div>
</section><!-- /.home-access -->

<?php

else :
    // 通常のブログ一覧
?>

<main class="site-main" id="main" role="main">
    <div class="container">
        <div class="content-area">

            <header class="page-header">
                <div class="container">
                    <?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
                    <?php the_archive_description( '<div class="page-description">', '</div>' ); ?>
                </div>
            </header>

            <?php if ( have_posts() ) : ?>

                <div class="posts-grid">
                    <?php while ( have_posts() ) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>

                        <?php if ( has_post_thumbnail() ) : ?>
                        <div class="post-card__image">
                            <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                                <?php the_post_thumbnail( 'post-card', [
                                    'class'   => '',
                                    'loading' => 'lazy',
                                    'alt'     => esc_attr( get_the_title() ),
                                ] ); ?>
                            </a>
                            <?php
                            $categories = get_the_category();
                            if ( $categories ) :
                                $cat = $categories[0];
                            ?>
                            <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" class="post-card__category">
                                <?php echo esc_html( $cat->name ); ?>
                            </a>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>

                        <div class="post-card__body">
                            <h2 class="post-card__title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <p class="post-card__excerpt"><?php the_excerpt(); ?></p>
                            <div class="post-card__meta">
                                <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                    <?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?>
                                </time>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    <?php the_author(); ?>
                                </span>
                            </div>
                        </div>

                    </article>
                    <?php endwhile; ?>
                </div>

                <div class="pagination">
                    <?php
                    the_posts_pagination( [
                        'mid_size'           => 2,
                        'prev_text'          => '&laquo; 前のページ',
                        'next_text'          => '次のページ &raquo;',
                        'screen_reader_text' => 'ページ移動',
                    ] );
                    ?>
                </div>

            <?php else : ?>

                <div class="no-results">
                    <header class="page-header">
                        <h1 class="page-title">投稿が見つかりませんでした</h1>
                    </header>
                    <div class="page-content">
                        <p>お探しの記事は見つかりませんでした。検索してみてください。</p>
                        <?php get_search_form(); ?>
                    </div>
                </div>

            <?php endif; ?>

        </div><!-- /.content-area -->

        <?php if ( is_active_sidebar( 'sidebar-main' ) ) : ?>
            <aside class="widget-area" role="complementary">
                <?php dynamic_sidebar( 'sidebar-main' ); ?>
            </aside>
        <?php endif; ?>

    </div><!-- /.container -->
</main><!-- /.site-main -->

<?php endif; ?>

<?php get_footer(); ?>
