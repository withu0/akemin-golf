import { Link, usePage } from '@inertiajs/react';
import { useEffect, useState, type ReactNode } from 'react';
import { AnimatePresence, motion, useMotionValueEvent, useScroll } from 'framer-motion';
import { useShared, useT, useUrl, useSwitchLocale, useBrand } from '../lib/shared';
import { ArrowRight } from '../Components/ui';

const NAV = [
    { key: 'about', path: '/about', no: '01' },
    { key: 'beauty', path: '/beauty', no: '02' },
    { key: 'activities', path: '/activities', no: '03' },
    { key: 'friends', path: '/friends', no: '04' },
    { key: 'future', path: '/future', no: '05' },
    { key: 'life', path: '/life', no: '06' },
    { key: 'global', path: '/global', no: '07' },
    { key: 'join', path: '/join', no: '08' },
];

const DESKTOP = ['about', 'activities', 'friends', 'global'];

export default function SiteLayout({ children }: { children: ReactNode }) {
    const { site, locales, locale } = useShared();
    const t = useT();
    const url = useUrl();
    const switchLocale = useSwitchLocale();
    const page = usePage();

    const [scrolled, setScrolled] = useState(false);
    const [menuOpen, setMenuOpen] = useState(false);
    const { scrollY } = useScroll();
    useMotionValueEvent(scrollY, 'change', (v) => setScrolled(v > 24));

    // close menu on navigation
    useEffect(() => setMenuOpen(false), [page.url]);

    // lock body scroll while menu open
    useEffect(() => {
        document.body.style.overflow = menuOpen ? 'hidden' : '';
        return () => {
            document.body.style.overflow = '';
        };
    }, [menuOpen]);

    const isActive = (path: string) => page.url.replace(/^\/[a-z-]+/, '').startsWith(path);

    return (
        <div className="min-h-screen">
            {/* ---------------- Header ---------------- */}
            <header className={`site-header fixed inset-x-0 top-0 z-50 ${scrolled ? 'is-scrolled' : ''}`}>
                <div className="wrap flex items-center justify-between py-5">
                    <Link href={url('')} className="flex items-baseline gap-3 leading-none">
                        <span className="display text-xl md:text-2xl tracking-[0.12em]">{site.brand_ja}</span>
                        <span className="hidden sm:inline eyebrow !text-[0.55rem] before:hidden">Akemin&nbsp;Golf</span>
                    </Link>

                    <nav className="hidden lg:flex items-center gap-7">
                        {DESKTOP.map((key) => {
                            const item = NAV.find((n) => n.key === key)!;
                            return (
                                <Link
                                    key={key}
                                    href={url(item.path)}
                                    className={`nav-link ${isActive(item.path) ? 'is-active' : ''}`}
                                >
                                    {t(`nav.${key}`)}
                                </Link>
                            );
                        })}
                        <Link href={url('/join')} className="btn btn-gold !px-6 !py-2.5">
                            {t('nav.join')}
                        </Link>
                    </nav>

                    <div className="flex items-center gap-5">
                        <div className="hidden sm:flex items-center gap-2 text-[0.7rem] tracking-widest font-[var(--font-label)]">
                            {Object.keys(locales).map((code, i, arr) => (
                                <span key={code} className="flex items-center gap-2">
                                    <Link
                                        href={switchLocale(code)}
                                        className={`uppercase transition-colors ${
                                            locale === code
                                                ? 'text-[var(--color-gold)]'
                                                : 'text-[var(--color-mist)] hover:text-[var(--color-sumi)]'
                                        }`}
                                    >
                                        {code === 'zh' ? '中' : code.toUpperCase()}
                                    </Link>
                                    {i < arr.length - 1 && <span className="text-[var(--color-line)]">/</span>}
                                </span>
                            ))}
                        </div>

                        <button
                            onClick={() => setMenuOpen(true)}
                            aria-label={t('meta.menu')}
                            className="flex items-center gap-2.5 text-sumi"
                        >
                            <span className="hidden md:inline eyebrow before:hidden !tracking-[0.3em]">{t('meta.menu')}</span>
                            <span className="flex flex-col gap-[5px]">
                                <span className="block h-px w-6 bg-[var(--color-sumi)]" />
                                <span className="block h-px w-6 bg-[var(--color-sumi)]" />
                            </span>
                        </button>
                    </div>
                </div>
            </header>

            {/* ---------------- Fullscreen menu ---------------- */}
            <AnimatePresence>
                {menuOpen && (
                    <motion.div
                        className="fixed inset-0 z-[60] bg-[var(--color-sumi)] grain-dark text-[var(--color-paper)]"
                        initial={{ opacity: 0 }}
                        animate={{ opacity: 1 }}
                        exit={{ opacity: 0 }}
                        transition={{ duration: 0.4 }}
                    >
                        <div className="wrap h-full flex flex-col">
                            <div className="flex items-center justify-between py-5">
                                <span className="display text-xl tracking-[0.12em]">{site.brand_ja}</span>
                                <button
                                    onClick={() => setMenuOpen(false)}
                                    className="eyebrow before:hidden !text-[var(--color-gold-soft)] !tracking-[0.3em]"
                                >
                                    {t('meta.close')} ✕
                                </button>
                            </div>

                            <motion.nav
                                className="flex-1 flex flex-col justify-center gap-3 md:gap-4"
                                initial="hidden"
                                animate="show"
                                variants={{ show: { transition: { staggerChildren: 0.05, delayChildren: 0.15 } } }}
                            >
                                <MenuLink href={url('')} no="00" label={t('nav.home')} />
                                {NAV.map((item) => (
                                    <MenuLink
                                        key={item.key}
                                        href={url(item.path)}
                                        no={item.no}
                                        label={t(`nav.${item.key}`)}
                                    />
                                ))}
                            </motion.nav>

                            <div className="flex flex-wrap items-center justify-between gap-4 py-7 border-t border-white/15">
                                <div className="flex items-center gap-4">
                                    {Object.entries(locales).map(([code, meta]) => (
                                        <Link
                                            key={code}
                                            href={switchLocale(code)}
                                            className={`text-sm tracking-widest uppercase ${
                                                locale === code ? 'text-[var(--color-gold-soft)]' : 'text-white/55 hover:text-white'
                                            }`}
                                        >
                                            {meta.label}
                                        </Link>
                                    ))}
                                </div>
                                <a
                                    href={site.instagram}
                                    target="_blank"
                                    rel="noopener"
                                    className="text-sm tracking-widest uppercase text-white/55 hover:text-white"
                                >
                                    {t('meta.instagram')}
                                </a>
                            </div>
                        </div>
                    </motion.div>
                )}
            </AnimatePresence>

            {/* ---------------- Page ---------------- */}
            <main>{children}</main>

            {/* ---------------- Footer ---------------- */}
            <Footer />
        </div>
    );
}

function MenuLink({ href, no, label }: { href: string; no: string; label: string }) {
    return (
        <motion.div
            variants={{
                hidden: { opacity: 0, y: 26 },
                show: { opacity: 1, y: 0, transition: { duration: 0.6, ease: [0.2, 0.7, 0.2, 1] } },
            }}
        >
            <Link href={href} className="menu-link inline-flex items-baseline gap-4">
                <span className="menu-no">{no}</span>
                {label}
            </Link>
        </motion.div>
    );
}

function Footer() {
    const { site } = useShared();
    const t = useT();
    const brand = useBrand();
    const url = useUrl();
    return (
        <footer className="relative mt-24 bg-[var(--color-sumi)] text-[var(--color-paper)] grain-dark">
            <div className="wrap py-16 md:py-20">
                <div className="grid gap-12 md:grid-cols-[1.4fr_1fr_1fr]">
                    <div>
                        <p className="display text-2xl tracking-[0.1em] mb-4">{site.brand_ja}</p>
                        <p className="text-white/65 max-w-sm leading-relaxed">{t('footer.tagline')}</p>
                        <p className="mt-6 eyebrow before:hidden !text-[var(--color-gold-soft)]">
                            {t('meta.founder')} — {brand.owner}
                        </p>
                    </div>
                    <div>
                        <p className="eyebrow before:hidden mb-5 !text-white/40">{t('footer.nav')}</p>
                        <ul className="space-y-2.5">
                            {NAV.map((item) => (
                                <li key={item.key}>
                                    <Link
                                        href={url(item.path)}
                                        className="text-white/70 hover:text-[var(--color-gold-soft)] transition-colors font-[var(--font-serif)]"
                                    >
                                        {t(`nav.${item.key}`)}
                                    </Link>
                                </li>
                            ))}
                        </ul>
                    </div>
                    <div>
                        <p className="eyebrow before:hidden mb-5 !text-white/40">{t('meta.connect')}</p>
                        <ul className="space-y-2.5">
                            <li>
                                <a href={site.instagram} target="_blank" rel="noopener" className="text-white/70 hover:text-[var(--color-gold-soft)] transition-colors font-[var(--font-serif)]">
                                    {t('meta.instagram_handle')}
                                </a>
                            </li>
                            <li>
                                <a href={site.harisienne} target="_blank" rel="noopener" className="text-white/70 hover:text-[var(--color-gold-soft)] transition-colors font-[var(--font-serif)]">
                                    {t('footer.also')} ↗
                                </a>
                            </li>
                            <li>
                                <Link href={url('/join')} className="text-white/70 hover:text-[var(--color-gold-soft)] transition-colors font-[var(--font-serif)]">
                                    {t('nav.join')}
                                </Link>
                            </li>
                        </ul>
                    </div>
                </div>

                <hr className="rule-gold my-12 opacity-40" />

                <div className="flex flex-col sm:flex-row items-center justify-between gap-4 text-white/45 text-xs tracking-widest uppercase font-[var(--font-label)]">
                    <span>© {new Date().getFullYear()} {brand.name} · {brand.owner}</span>
                    <span>{brand.tagline}</span>
                </div>
            </div>
        </footer>
    );
}
