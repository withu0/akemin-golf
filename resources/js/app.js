// あけみんゴルフ — light interactions only (no framework needed)

// Mobile menu toggle
document.addEventListener('click', (e) => {
    const toggle = e.target.closest('[data-menu-toggle]');
    if (toggle) {
        const menu = document.getElementById('site-menu');
        const open = menu.classList.toggle('is-open');
        document.body.classList.toggle('overflow-hidden', open);
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    }
    if (e.target.closest('[data-menu-close]')) {
        const menu = document.getElementById('site-menu');
        menu?.classList.remove('is-open');
        document.body.classList.remove('overflow-hidden');
    }
});

// Scroll reveal
const io = new IntersectionObserver((entries) => {
    for (const entry of entries) {
        if (entry.isIntersecting) {
            entry.target.classList.add('in');
            io.unobserve(entry.target);
        }
    }
}, { threshold: 0.12, rootMargin: '0px 0px -8% 0px' });

const armReveal = () => document.querySelectorAll('.reveal:not(.in)').forEach((el) => io.observe(el));
document.addEventListener('DOMContentLoaded', armReveal);
armReveal();

// Subtle header state on scroll
const header = document.querySelector('[data-header]');
if (header) {
    const onScroll = () => header.classList.toggle('is-scrolled', window.scrollY > 24);
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
}
