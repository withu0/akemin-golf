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

// Friend card videos: play when in view on touch devices (hover handles desktop)
const initFriendCardVideos = () => {
    if (window.matchMedia('(hover: hover) and (pointer: fine)').matches) return;

    document.querySelectorAll('[data-friend-card-video]').forEach((frame) => {
        const video = frame.querySelector('video');
        if (!video) return;

        const observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting) {
                    video.play().catch(() => {});
                    frame.dataset.playing = '1';
                } else {
                    video.pause();
                    video.currentTime = 0;
                    frame.dataset.playing = '0';
                }
            },
            { threshold: 0.55 },
        );

        observer.observe(frame);
    });
};

document.addEventListener('DOMContentLoaded', initFriendCardVideos);
initFriendCardVideos();

// Subtle header state on scroll
const header = document.querySelector('[data-header]');
if (header) {
    const onScroll = () => header.classList.toggle('is-scrolled', window.scrollY > 24);
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
}
