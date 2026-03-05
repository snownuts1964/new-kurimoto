/**
 * Kurimoto Custom Theme - main.js
 * くりもと カスタムWordPressテーマ メインスクリプト
 *
 * @package custom-theme
 * @version 2.0.0
 */

require('../scss/main.scss');

'use strict';

// =============================================================================
// DOMContentLoaded 後に初期化
// =============================================================================
document.addEventListener('DOMContentLoaded', function () {
  initHeroSlider();
  initStickyHeader();
  initMobileMenu();
  initBackToTop();
  initSmoothScroll();
  initDropdownMenus();
  initExternalLinks();
  initLazyImages();
  initScrollReveal();
});

// =============================================================================
// 1. ヒーロースライダー
// =============================================================================
function initHeroSlider() {
  var slider      = document.getElementById('hero-slider');
  if (!slider) return;

  var slides      = slider.querySelectorAll('.hero-slide');
  var dots        = slider.querySelectorAll('.hero-dot');
  var prevBtn     = document.getElementById('hero-prev');
  var nextBtn     = document.getElementById('hero-next');
  var total       = slides.length;
  var current     = 0;
  var autoPlayMs  = 5500;
  var timer       = null;
  var isAnimating = false;

  if (total <= 1) return;

  // スライドを切り替える
  function goTo(index, direction) {
    if (isAnimating) return;
    isAnimating = true;

    var prev = current;
    current  = (index + total) % total;

    // 現在スライドを非アクティブ化
    slides[prev].classList.remove('is-active');
    dots[prev] && dots[prev].classList.remove('is-active');
    dots[prev] && dots[prev].setAttribute('aria-selected', 'false');

    // 新スライドをアクティブ化
    slides[current].classList.add('is-active');
    dots[current] && dots[current].classList.add('is-active');
    dots[current] && dots[current].setAttribute('aria-selected', 'true');

    // アニメーション完了待ち
    setTimeout(function () { isAnimating = false; }, 800);
  }

  function next() { goTo(current + 1, 'next'); }
  function prev() { goTo(current - 1, 'prev'); }

  // 自動再生
  function startAutoPlay() {
    stopAutoPlay();
    timer = setInterval(next, autoPlayMs);
  }

  function stopAutoPlay() {
    if (timer) { clearInterval(timer); timer = null; }
  }

  // 矢印ボタン
  if (nextBtn) {
    nextBtn.addEventListener('click', function () {
      next();
      startAutoPlay();
    });
  }

  if (prevBtn) {
    prevBtn.addEventListener('click', function () {
      prev();
      startAutoPlay();
    });
  }

  // ドットボタン
  dots.forEach(function (dot, i) {
    dot.addEventListener('click', function () {
      goTo(i);
      startAutoPlay();
    });
  });

  // キーボード操作
  slider.addEventListener('keydown', function (e) {
    if (e.key === 'ArrowLeft')  { prev(); startAutoPlay(); }
    if (e.key === 'ArrowRight') { next(); startAutoPlay(); }
  });

  // タッチスワイプ
  var touchStartX = 0;
  var touchDeltaX = 0;

  slider.addEventListener('touchstart', function (e) {
    touchStartX = e.touches[0].clientX;
    stopAutoPlay();
  }, { passive: true });

  slider.addEventListener('touchmove', function (e) {
    touchDeltaX = e.touches[0].clientX - touchStartX;
  }, { passive: true });

  slider.addEventListener('touchend', function () {
    if (Math.abs(touchDeltaX) > 50) {
      touchDeltaX < 0 ? next() : prev();
    }
    startAutoPlay();
    touchDeltaX = 0;
  });

  // ホバーで一時停止
  slider.addEventListener('mouseenter', stopAutoPlay);
  slider.addEventListener('mouseleave', startAutoPlay);

  // 非表示タブに切り替わったら一時停止
  document.addEventListener('visibilitychange', function () {
    document.hidden ? stopAutoPlay() : startAutoPlay();
  });

  // 初期化
  startAutoPlay();
}

// =============================================================================
// 2. スティッキーヘッダー（スクロールで背景変化）
// =============================================================================
function initStickyHeader() {
  var header    = document.getElementById('site-header');
  if (!header) return;

  var heroSlider = document.getElementById('hero-slider');
  var ticking    = false;
  var threshold  = 80;

  function updateHeader() {
    var scrollY = window.scrollY || window.pageYOffset;

    if (scrollY > threshold) {
      header.classList.add('is-scrolled');
      header.classList.remove('is-transparent');
    } else {
      header.classList.remove('is-scrolled');
      if (heroSlider) {
        header.classList.add('is-transparent');
      }
    }

    ticking = false;
  }

  function onScroll() {
    if (!ticking) {
      requestAnimationFrame(updateHeader);
      ticking = true;
    }
  }

  // ヒーロースライダーがある場合は最初は透明
  if (heroSlider) {
    header.classList.add('is-transparent');
  }

  window.addEventListener('scroll', onScroll, { passive: true });
  updateHeader();
}

// =============================================================================
// 3. モバイルメニュー
// =============================================================================
function initMobileMenu() {
  var toggle   = document.getElementById('menu-toggle');
  var menu     = document.getElementById('mobile-menu');
  var overlay  = document.getElementById('mobile-menu-overlay');
  var closeBtn = document.getElementById('mobile-menu-close');
  var header   = document.getElementById('site-header');

  if (!toggle || !menu) return;

  var isOpen     = false;
  var focusable  = 'a[href], button:not([disabled]), [tabindex="0"]';
  var firstFocus = null;
  var lastFocus  = null;

  function updateFocusable() {
    var items = menu.querySelectorAll(focusable);
    firstFocus = items[0] || null;
    lastFocus  = items[items.length - 1] || null;
  }

  function openMenu() {
    isOpen = true;
    menu.classList.add('is-open');
    overlay && overlay.classList.add('is-visible');
    toggle.classList.add('is-active');
    toggle.setAttribute('aria-expanded', 'true');
    menu.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
    updateFocusable();
    if (firstFocus) firstFocus.focus();
  }

  function closeMenu() {
    isOpen = false;
    menu.classList.remove('is-open');
    overlay && overlay.classList.remove('is-visible');
    toggle.classList.remove('is-active');
    toggle.setAttribute('aria-expanded', 'false');
    menu.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
    toggle.focus();
  }

  function toggleMenu() {
    isOpen ? closeMenu() : openMenu();
  }

  // フォーカストラップ
  menu.addEventListener('keydown', function (e) {
    if (!isOpen) return;

    if (e.key === 'Escape') {
      e.preventDefault();
      closeMenu();
      return;
    }

    if (e.key === 'Tab') {
      updateFocusable();
      if (e.shiftKey) {
        if (document.activeElement === firstFocus) {
          e.preventDefault();
          lastFocus && lastFocus.focus();
        }
      } else {
        if (document.activeElement === lastFocus) {
          e.preventDefault();
          firstFocus && firstFocus.focus();
        }
      }
    }
  });

  toggle.addEventListener('click', toggleMenu);
  closeBtn && closeBtn.addEventListener('click', closeMenu);
  overlay  && overlay.addEventListener('click', closeMenu);

  // 親メニュー項目の子メニュートグル（モバイル用）
  var mobileItems = menu.querySelectorAll('.mobile-nav-item');
  mobileItems.forEach(function (item) {
    var subMenu = item.querySelector('.sub-menu');
    if (!subMenu) return;

    var link = item.querySelector('a');
    var chevron = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    chevron.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
    chevron.setAttribute('width', '16');
    chevron.setAttribute('height', '16');
    chevron.setAttribute('viewBox', '0 0 24 24');
    chevron.setAttribute('fill', 'none');
    chevron.setAttribute('stroke', 'currentColor');
    chevron.setAttribute('stroke-width', '2');
    chevron.setAttribute('stroke-linecap', 'round');
    chevron.setAttribute('stroke-linejoin', 'round');
    chevron.setAttribute('aria-hidden', 'true');
    chevron.innerHTML = '<polyline points="6 9 12 15 18 9"/>';
    link && link.appendChild(chevron);

    link && link.addEventListener('click', function (e) {
      e.preventDefault();
      var expanded = subMenu.classList.toggle('is-open');
      chevron.style.transform = expanded ? 'rotate(180deg)' : '';
    });
  });

  // リサイズ時に閉じる
  window.addEventListener('resize', debounce(function () {
    if (window.innerWidth >= 1024 && isOpen) {
      closeMenu();
    }
  }, 200));
}

// =============================================================================
// 4. バックトゥトップ
// =============================================================================
function initBackToTop() {
  var btn = document.getElementById('back-to-top');
  if (!btn) return;

  var threshold = 300;
  var ticking   = false;

  function updateBtn() {
    var scrollY = window.scrollY || window.pageYOffset;
    if (scrollY > threshold) {
      btn.classList.add('is-visible');
    } else {
      btn.classList.remove('is-visible');
    }
    ticking = false;
  }

  window.addEventListener('scroll', function () {
    if (!ticking) {
      requestAnimationFrame(updateBtn);
      ticking = true;
    }
  }, { passive: true });

  btn.addEventListener('click', function () {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
}

// =============================================================================
// 5. スムーズスクロール（アンカーリンク）
// =============================================================================
function initSmoothScroll() {
  var header = document.getElementById('site-header');

  document.addEventListener('click', function (e) {
    var link = e.target.closest('a[href^="#"]');
    if (!link) return;

    var href = link.getAttribute('href');
    if (href === '#' || href === '#0') return;

    var target = document.querySelector(href);
    if (!target) return;

    e.preventDefault();

    var headerH = header ? header.offsetHeight : 0;
    var top     = target.getBoundingClientRect().top + window.scrollY - headerH - 16;

    window.scrollTo({ top: top, behavior: 'smooth' });
  });
}

// =============================================================================
// 6. デスクトップドロップダウン（キーボード操作）
// =============================================================================
function initDropdownMenus() {
  var menuItems = document.querySelectorAll('.nav-menu .menu-item-has-children');

  menuItems.forEach(function (item) {
    var link    = item.querySelector('.nav-link');
    var subMenu = item.querySelector('.sub-menu');
    if (!link || !subMenu) return;

    // ArrowDown でサブメニューを開く
    link.addEventListener('keydown', function (e) {
      if (e.key === 'ArrowDown') {
        e.preventDefault();
        var firstItem = subMenu.querySelector('a');
        if (firstItem) firstItem.focus();
      }
    });

    // ESC でサブメニューを閉じる
    item.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') {
        link.focus();
      }
    });

    // フォーカスアウトで閉じる
    item.addEventListener('focusout', function (e) {
      if (!item.contains(e.relatedTarget)) {
        link.setAttribute('aria-expanded', 'false');
      }
    });

    link.addEventListener('focus', function () {
      link.setAttribute('aria-expanded', 'true');
    });
  });
}

// =============================================================================
// 7. 外部リンクの自動処理
// =============================================================================
function initExternalLinks() {
  var host = window.location.hostname;

  document.querySelectorAll('a[href]').forEach(function (a) {
    var href = a.getAttribute('href');
    if (!href || href.startsWith('#') || href.startsWith('/') || href.startsWith('tel:') || href.startsWith('mailto:')) return;

    try {
      var url = new URL(href, window.location.href);
      if (url.hostname !== host) {
        a.setAttribute('target', '_blank');
        a.setAttribute('rel', 'noopener noreferrer');

        if (!a.querySelector('.sr-only')) {
          var srText = document.createElement('span');
          srText.className = 'screen-reader-text';
          srText.textContent = '（外部リンク）';
          a.appendChild(srText);
        }
      }
    } catch (err) { /* 無効なURL は無視 */ }
  });
}

// =============================================================================
// 8. 遅延読み込み画像（Intersection Observer）
// =============================================================================
function initLazyImages() {
  if (!('IntersectionObserver' in window)) return;

  var lazyImages = document.querySelectorAll('img[loading="lazy"]');
  if (!lazyImages.length) return;

  var observer = new IntersectionObserver(
    function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        var img = entry.target;
        if (img.dataset.src) {
          img.src = img.dataset.src;
          delete img.dataset.src;
        }
        img.classList.add('is-loaded');
        observer.unobserve(img);
      });
    },
    { rootMargin: '200px 0px', threshold: 0 }
  );

  lazyImages.forEach(function (img) { observer.observe(img); });
}

// =============================================================================
// 9. スクロールリビール（フェードイン）
// =============================================================================
function initScrollReveal() {
  if (!('IntersectionObserver' in window)) return;

  // CSS でアニメーション対象にクラスを付与
  var targets = document.querySelectorAll(
    '.menu-card, .post-card, .feature-card, .section-header, .home-feature__inner > *'
  );

  if (!targets.length) return;

  // 初期スタイルをインラインで設定（CSSに依存しない）
  targets.forEach(function (el) {
    el.style.opacity    = '0';
    el.style.transform  = 'translateY(24px)';
    el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
  });

  var observer = new IntersectionObserver(
    function (entries) {
      entries.forEach(function (entry, i) {
        if (!entry.isIntersecting) return;

        // 親グリッド内の兄弟要素にディレイを付与
        var siblings = entry.target.parentNode
          ? Array.from(entry.target.parentNode.children)
          : [];
        var delay = siblings.indexOf(entry.target) * 80;

        setTimeout(function () {
          entry.target.style.opacity   = '1';
          entry.target.style.transform = 'translateY(0)';
        }, delay);

        observer.unobserve(entry.target);
      });
    },
    { rootMargin: '-40px 0px', threshold: 0.1 }
  );

  targets.forEach(function (el) { observer.observe(el); });
}

// =============================================================================
// ユーティリティ関数
// =============================================================================

/**
 * Debounce：指定時間内の連続呼び出しを最後の1回にまとめる
 */
function debounce(fn, wait) {
  var timer;
  return function () {
    var args    = arguments;
    var context = this;
    clearTimeout(timer);
    timer = setTimeout(function () { fn.apply(context, args); }, wait);
  };
}

/**
 * Throttle：rAF ベースで呼び出しを間引く
 */
function throttle(fn) {
  var ticking = false;
  return function () {
    if (ticking) return;
    var args = arguments;
    requestAnimationFrame(function () {
      fn.apply(null, args);
      ticking = false;
    });
    ticking = true;
  };
}
