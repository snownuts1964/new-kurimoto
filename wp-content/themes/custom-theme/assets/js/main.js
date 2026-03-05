// SCSS エントリーポイント
require('../scss/main.scss');

/**
 * Custom Theme - Main JavaScript
 *
 * @package custom-theme
 * @version 1.0.0
 */

'use strict';

// =============================================================================
// DOM Ready
// =============================================================================
document.addEventListener('DOMContentLoaded', () => {
    initHamburgerMenu();
    initStickyHeader();
    initSmoothScroll();
    initDropdownMenus();
    initBackToTop();
    initLazyImages();
    initExternalLinks();
});

// =============================================================================
// ハンバーガーメニュー
// =============================================================================
function initHamburgerMenu() {
    const menuToggle = document.querySelector('.menu-toggle');
    const navMenu    = document.querySelector('.main-navigation .nav-menu');
    const header     = document.querySelector('.site-header');

    if (!menuToggle || !navMenu) return;

    // モバイルメニュー要素を作成
    const mobileMenu = document.createElement('div');
    mobileMenu.className = 'mobile-menu';
    mobileMenu.id = 'mobile-menu';
    mobileMenu.setAttribute('aria-hidden', 'true');

    const mobileNav = navMenu.cloneNode(true);
    mobileNav.id = '';
    mobileMenu.appendChild(mobileNav);
    document.body.appendChild(mobileMenu);

    // オーバーレイ
    const overlay = document.createElement('div');
    overlay.className = 'mobile-menu-overlay';
    document.body.appendChild(overlay);

    // 開閉トグル
    function toggleMenu(open) {
        const isOpen = open !== undefined ? open : !mobileMenu.classList.contains('is-open');

        menuToggle.classList.toggle('is-active', isOpen);
        menuToggle.setAttribute('aria-expanded', String(isOpen));
        mobileMenu.classList.toggle('is-open', isOpen);
        mobileMenu.setAttribute('aria-hidden', String(!isOpen));
        overlay.classList.toggle('is-visible', isOpen);
        document.body.style.overflow = isOpen ? 'hidden' : '';
    }

    menuToggle.addEventListener('click', () => toggleMenu());
    overlay.addEventListener('click', () => toggleMenu(false));

    // ESCキーで閉じる
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && mobileMenu.classList.contains('is-open')) {
            toggleMenu(false);
            menuToggle.focus();
        }
    });

    // リサイズ時にモバイルメニューを閉じる
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            if (window.innerWidth >= 992) {
                toggleMenu(false);
            }
        }, 150);
    });

    // モバイルメニュー内のサブメニュートグル
    const hasChildrenItems = mobileMenu.querySelectorAll('.menu-item-has-children > a');
    hasChildrenItems.forEach((link) => {
        const toggle = document.createElement('button');
        toggle.className = 'submenu-toggle';
        toggle.setAttribute('aria-expanded', 'false');
        toggle.setAttribute('aria-label', 'サブメニューを開く');
        toggle.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="16" height="16"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>';
        link.parentNode.insertBefore(toggle, link.nextSibling);

        toggle.addEventListener('click', (e) => {
            e.preventDefault();
            const subMenu = link.nextElementSibling?.nextElementSibling || link.nextElementSibling;
            if (!subMenu || !subMenu.classList.contains('sub-menu')) return;

            const isExpanded = toggle.getAttribute('aria-expanded') === 'true';
            toggle.setAttribute('aria-expanded', String(!isExpanded));
            toggle.classList.toggle('is-active', !isExpanded);
            subMenu.style.display = isExpanded ? '' : 'block';
        });
    });
}

// =============================================================================
// スティッキーヘッダー
// =============================================================================
function initStickyHeader() {
    const header = document.querySelector('.site-header');
    if (!header) return;

    const scrollThreshold = 50;
    let lastScrollY = window.scrollY;
    let ticking = false;

    function updateHeader() {
        const scrollY = window.scrollY;

        // スクロールクラス追加
        header.classList.toggle('is-scrolled', scrollY > scrollThreshold);

        lastScrollY = scrollY;
        ticking = false;
    }

    window.addEventListener('scroll', () => {
        if (!ticking) {
            requestAnimationFrame(updateHeader);
            ticking = true;
        }
    }, { passive: true });
}

// =============================================================================
// スムーススクロール
// =============================================================================
function initSmoothScroll() {
    const links = document.querySelectorAll('a[href^="#"]');
    const header = document.querySelector('.site-header');

    links.forEach((link) => {
        link.addEventListener('click', (e) => {
            const href = link.getAttribute('href');
            if (href === '#' || href === '#0') return;

            const target = document.querySelector(href);
            if (!target) return;

            e.preventDefault();

            const headerHeight = header ? header.offsetHeight : 0;
            const targetTop = target.getBoundingClientRect().top + window.scrollY - headerHeight - 16;

            window.scrollTo({
                top: targetTop,
                behavior: 'smooth',
            });

            // フォーカスをターゲットへ
            target.setAttribute('tabindex', '-1');
            target.focus({ preventScroll: true });
        });
    });
}

// =============================================================================
// ドロップダウンメニュー（キーボード対応）
// =============================================================================
function initDropdownMenus() {
    const navItems = document.querySelectorAll('.nav-menu .menu-item-has-children');

    navItems.forEach((item) => {
        const link = item.querySelector(':scope > a');
        const subMenu = item.querySelector('.sub-menu');

        if (!link || !subMenu) return;

        // キーボードサポート
        link.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                const firstLink = subMenu.querySelector('a');
                if (firstLink) firstLink.focus();
            }
        });

        // フォーカスアウトで閉じる
        item.addEventListener('focusout', (e) => {
            if (!item.contains(e.relatedTarget)) {
                subMenu.style.opacity = '';
                subMenu.style.visibility = '';
            }
        });
    });
}

// =============================================================================
// トップへ戻るボタン
// =============================================================================
function initBackToTop() {
    // ボタン要素を作成
    const btn = document.createElement('button');
    btn.id = 'back-to-top';
    btn.className = 'back-to-top';
    btn.setAttribute('aria-label', 'ページトップへ戻る');
    btn.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="20" height="20" aria-hidden="true">
            <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"/>
        </svg>
    `;
    document.body.appendChild(btn);

    // スタイルをインライン追加（SCSSで管理できるが、JSで動的に追加）
    const style = document.createElement('style');
    style.textContent = `
        .back-to-top {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background-color: #2563EB;
            color: #fff;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(37,99,235,0.4);
            opacity: 0;
            visibility: hidden;
            transform: translateY(16px);
            transition: opacity 0.2s ease, visibility 0.2s ease, transform 0.2s ease;
            z-index: 999;
        }
        .back-to-top.is-visible {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .back-to-top:hover {
            background-color: #1D4ED8;
            box-shadow: 0 6px 16px rgba(37,99,235,0.5);
            transform: translateY(-2px);
        }
        .submenu-toggle {
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
            display: inline-flex;
            align-items: center;
            color: inherit;
            transition: transform 0.2s ease;
        }
        .submenu-toggle.is-active {
            transform: rotate(180deg);
        }
    `;
    document.head.appendChild(style);

    // 表示制御
    let ticking = false;
    window.addEventListener('scroll', () => {
        if (!ticking) {
            requestAnimationFrame(() => {
                btn.classList.toggle('is-visible', window.scrollY > 300);
                ticking = false;
            });
            ticking = true;
        }
    }, { passive: true });

    btn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
}

// =============================================================================
// 遅延画像読み込み（Intersection Observer）
// =============================================================================
function initLazyImages() {
    if (!('IntersectionObserver' in window)) return;

    const images = document.querySelectorAll('img[loading="lazy"]');
    if (!images.length) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.classList.add('is-loaded');
                observer.unobserve(img);
            }
        });
    }, {
        rootMargin: '0px 0px 200px 0px',
    });

    images.forEach((img) => {
        img.addEventListener('load', () => img.classList.add('is-loaded'));
        observer.observe(img);
    });
}

// =============================================================================
// 外部リンクに target="_blank" と rel を付与
// =============================================================================
function initExternalLinks() {
    const links = document.querySelectorAll('.entry-content a, .page-content a');
    const currentHost = window.location.hostname;

    links.forEach((link) => {
        try {
            const url = new URL(link.href);
            if (url.hostname && url.hostname !== currentHost) {
                link.setAttribute('target', '_blank');
                link.setAttribute('rel', 'noopener noreferrer');

                // スクリーンリーダー向けテキスト
                if (!link.querySelector('.screen-reader-text')) {
                    const srText = document.createElement('span');
                    srText.className = 'screen-reader-text';
                    srText.textContent = '（外部リンク）';
                    link.appendChild(srText);
                }
            }
        } catch (e) {
            // 無効なURLは無視
        }
    });
}

// =============================================================================
// ユーティリティ
// =============================================================================

/**
 * デバウンス関数
 */
function debounce(fn, delay = 200) {
    let timer;
    return (...args) => {
        clearTimeout(timer);
        timer = setTimeout(() => fn(...args), delay);
    };
}

/**
 * スロットル関数
 */
function throttle(fn, limit = 100) {
    let inThrottle;
    return (...args) => {
        if (!inThrottle) {
            fn(...args);
            inThrottle = true;
            setTimeout(() => { inThrottle = false; }, limit);
        }
    };
}
