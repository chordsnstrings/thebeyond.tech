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

/* ----- Hero ----- */
initHero(document.querySelector('[data-hero]'));
