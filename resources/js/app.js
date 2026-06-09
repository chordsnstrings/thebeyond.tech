/* ==========================================================================
   Beyond — app entry
   ========================================================================== */
import { initHero } from './hero.js';

/* ----- Sticky nav state ----- */
const nav = document.querySelector('.nav');
if (nav) {
    const onScroll = () => nav.classList.toggle('is-scrolled', window.scrollY > 8);
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
}

/* ----- Mobile nav drawer ----- */
const drawer = document.querySelector('[data-nav-drawer]');
const toggles = document.querySelectorAll('[data-nav-toggle]');
if (drawer && toggles.length) {
    const setOpen = (open) => {
        drawer.toggleAttribute('data-open', open);
        toggles.forEach((t) => t.setAttribute('aria-expanded', String(open)));
        document.body.style.overflow = open ? 'hidden' : '';
    };
    toggles.forEach((t) =>
        t.addEventListener('click', () => setOpen(!drawer.hasAttribute('data-open')))
    );
    drawer.querySelectorAll('a').forEach((a) => a.addEventListener('click', () => setOpen(false)));
}

/* ----- Scroll reveal ----- */
const revealEls = document.querySelectorAll('[data-reveal]');
if (revealEls.length) {
    const io = new IntersectionObserver(
        (entries, obs) => {
            entries.forEach((e) => {
                if (e.isIntersecting) {
                    e.target.classList.add('is-visible');
                    obs.unobserve(e.target);
                }
            });
        },
        { threshold: 0.12, rootMargin: '0px 0px -8% 0px' }
    );
    revealEls.forEach((el) => io.observe(el));
}

/* ----- Card pointer glow ----- */
document.querySelectorAll('.card').forEach((card) => {
    card.addEventListener('pointermove', (e) => {
        const r = card.getBoundingClientRect();
        card.style.setProperty('--mx', `${e.clientX - r.left}px`);
        card.style.setProperty('--my', `${e.clientY - r.top}px`);
    });
});

/* ----- Wrap article tables so they scroll on narrow screens ----- */
document.querySelectorAll('.prose table').forEach((table) => {
    if (table.parentElement && table.parentElement.classList.contains('table-wrap')) return;
    const wrap = document.createElement('div');
    wrap.className = 'table-wrap';
    table.parentNode.insertBefore(wrap, table);
    wrap.appendChild(table);
});

/* ----- Micro-interactions ----- */
const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

/* Click ripple on buttons */
document.querySelectorAll('.btn').forEach((btn) => {
    btn.addEventListener('pointerdown', (e) => {
        if (reduceMotion) return;
        const r = btn.getBoundingClientRect();
        const size = Math.max(r.width, r.height);
        const span = document.createElement('span');
        span.className = 'ripple';
        span.style.width = span.style.height = `${size}px`;
        span.style.left = `${e.clientX - r.left - size / 2}px`;
        span.style.top = `${e.clientY - r.top - size / 2}px`;
        btn.appendChild(span);
        span.addEventListener('animationend', () => span.remove());
    });
});

/* Magnetic pull on primary CTAs (pointer devices only) */
if (!reduceMotion && window.matchMedia('(hover: hover)').matches) {
    document.querySelectorAll('.btn--primary, [data-magnetic]').forEach((el) => {
        const strength = 0.28;
        el.addEventListener('pointermove', (e) => {
            const r = el.getBoundingClientRect();
            const mx = e.clientX - (r.left + r.width / 2);
            const my = e.clientY - (r.top + r.height / 2);
            el.style.transform = `translate(${(mx * strength).toFixed(1)}px, ${(my * strength).toFixed(1)}px)`;
        });
        el.addEventListener('pointerleave', () => {
            el.style.transform = '';
        });
    });
}

/* ----- Hero ----- */
initHero(document.querySelector('[data-hero]'));
