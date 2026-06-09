/* ==========================================================================
   Hero — cursor-reactive type + grid
   A dot grid that displaces near the pointer, plus headline letters that
   magnetize/skew toward the cursor with spring easing. Touch-aware and
   reduced-motion aware. Lightweight canvas, capped DPR, RAF-driven.
   ========================================================================== */

export function initHero(root) {
    if (!root) return;

    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const canvas = root.querySelector('.hero__canvas');
    const letters = Array.from(root.querySelectorAll('.hero__title .ch'));

    // Pointer state (normalized to viewport), eased toward target.
    const pointer = { x: 0.5, y: 0.4, tx: 0.5, ty: 0.4, active: false };

    root.addEventListener('pointermove', (e) => {
        const r = root.getBoundingClientRect();
        pointer.tx = (e.clientX - r.left) / r.width;
        pointer.ty = (e.clientY - r.top) / r.height;
        pointer.active = true;
    });
    root.addEventListener('pointerleave', () => {
        pointer.active = false;
        pointer.tx = 0.5;
        pointer.ty = 0.4;
    });

    /* ----- Letter magnetism (DOM, cheap transforms) ----- */
    const letterMeta = letters.map((el) => ({ el, x: 0, y: 0, rot: 0 }));

    /* ----- Canvas dot grid ----- */
    let ctx, dpr, w, h, cols, rows, gap, dots = [];

    function setup() {
        if (!canvas) return;
        dpr = Math.min(window.devicePixelRatio || 1, 2);
        const r = root.getBoundingClientRect();
        w = r.width;
        h = r.height;
        canvas.width = w * dpr;
        canvas.height = h * dpr;
        canvas.style.width = w + 'px';
        canvas.style.height = h + 'px';
        ctx = canvas.getContext('2d');
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);

        gap = w < 640 ? 38 : 46;
        cols = Math.ceil(w / gap) + 1;
        rows = Math.ceil(h / gap) + 1;
        dots = [];
        for (let yi = 0; yi < rows; yi++) {
            for (let xi = 0; xi < cols; xi++) {
                dots.push({ ox: xi * gap, oy: yi * gap, x: xi * gap, y: yi * gap });
            }
        }
    }

    const RADIUS = 150; // px influence
    const PUSH = 26; // px max displacement

    function frame() {
        // Ease pointer toward target.
        pointer.x += (pointer.tx - pointer.x) * 0.08;
        pointer.y += (pointer.ty - pointer.y) * 0.08;

        const px = pointer.x * w;
        const py = pointer.y * h;

        if (ctx) {
            ctx.clearRect(0, 0, w, h);
            for (let i = 0; i < dots.length; i++) {
                const d = dots[i];
                const dx = d.ox - px;
                const dy = d.oy - py;
                const dist = Math.hypot(dx, dy);
                let tx = d.ox;
                let ty = d.oy;
                let glow = 0;
                if (dist < RADIUS) {
                    const f = (1 - dist / RADIUS);
                    const ang = Math.atan2(dy, dx);
                    tx = d.ox + Math.cos(ang) * PUSH * f;
                    ty = d.oy + Math.sin(ang) * PUSH * f;
                    glow = f;
                }
                d.x += (tx - d.x) * 0.12;
                d.y += (ty - d.y) * 0.12;

                const size = 1 + glow * 1.6;
                ctx.beginPath();
                ctx.arc(d.x, d.y, size, 0, Math.PI * 2);
                ctx.fillStyle = glow > 0.02
                    ? `rgba(94, 234, 212, ${0.18 + glow * 0.6})`
                    : 'rgba(255, 255, 255, 0.07)';
                ctx.fill();
            }
        }

        // Letters: magnetize toward pointer, subtle skew.
        for (let i = 0; i < letterMeta.length; i++) {
            const m = letterMeta[i];
            const rect = m.el.getBoundingClientRect();
            const rootRect = root.getBoundingClientRect();
            const cx = rect.left - rootRect.left + rect.width / 2;
            const cy = rect.top - rootRect.top + rect.height / 2;
            const dx = px - cx;
            const dy = py - cy;
            const dist = Math.hypot(dx, dy);
            const R = 170;
            let goalX = 0, goalY = 0, goalR = 0;
            if (dist < R) {
                const f = (1 - dist / R);
                goalX = (dx / R) * 14 * f;
                goalY = (dy / R) * 14 * f;
                goalR = (dx / R) * 6 * f;
            }
            m.x += (goalX - m.x) * 0.12;
            m.y += (goalY - m.y) * 0.12;
            m.rot += (goalR - m.rot) * 0.12;
            m.el.style.transform = `translate(${m.x.toFixed(2)}px, ${m.y.toFixed(2)}px) rotate(${m.rot.toFixed(2)}deg)`;
        }

        raf = requestAnimationFrame(frame);
    }

    let raf;

    if (reduceMotion) {
        // Static dot grid, no animation.
        setup();
        if (ctx) {
            ctx.clearRect(0, 0, w, h);
            for (const d of dots) {
                ctx.beginPath();
                ctx.arc(d.ox, d.oy, 1, 0, Math.PI * 2);
                ctx.fillStyle = 'rgba(255,255,255,0.07)';
                ctx.fill();
            }
        }
        return;
    }

    setup();
    frame();

    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(setup, 150);
    });

    // Pause when off-screen to save battery.
    const io = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                if (!raf) frame();
            } else if (raf) {
                cancelAnimationFrame(raf);
                raf = null;
            }
        });
    }, { threshold: 0 });
    io.observe(root);
}
