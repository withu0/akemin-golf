import { Head, Link } from '@inertiajs/react';
import { motion } from 'framer-motion';
import { useT, useUrl, useBrand } from '../lib/shared';
import { Reveal, StaggerGroup, StaggerItem, useParallax } from '../lib/anim';
import { ArrowRight, PlayIcon, SectionHead } from '../Components/ui';
import { ActivityCardView, PostCardView } from '../Components/cards';
import type { ActivityCard, FriendCard, PostCard, SectionContent } from '../types';

const EASE = [0.2, 0.7, 0.2, 1] as const;
const CITIES = ['Tokyo', 'Los Angeles', 'Singapore', 'Dubai', 'Paris', 'India'];

export default function Home({
    hero,
    about,
    activities,
    friends,
    posts,
}: {
    hero: SectionContent;
    about: SectionContent;
    activities: ActivityCard[];
    friends: FriendCard[];
    posts: PostCard[];
}) {
    const t = useT();
    const brand = useBrand();
    const url = useUrl();

    // parallax layers (different depths)
    const pPortrait = useParallax<HTMLDivElement>(34);
    const pCourse = useParallax<HTMLDivElement>(66);
    const pGroup = useParallax<HTMLDivElement>(96);

    const heroTitle = hero.title || t('home.hero_title');
    const heroLead = hero.lead || t('home.hero_lead');

    return (
        <>
            <Head title={`${brand.name} — ${brand.tagline}`} />

            {/* ============ HERO ============ */}
            <section className="relative overflow-hidden">
                <div className="wrap pt-32 md:pt-40 pb-16 md:pb-24">
                    <div className="grid items-center gap-12 lg:gap-16 lg:grid-cols-[1.05fr_0.95fr]">
                        {/* words */}
                        <motion.div
                            initial="hidden"
                            animate="show"
                            variants={{ show: { transition: { staggerChildren: 0.12, delayChildren: 0.1 } } }}
                        >
                            <FadeUp><span className="eyebrow">{t('home.hero_eyebrow')}</span></FadeUp>
                            <FadeUp>
                                <h1
                                    className="mt-6 display text-[2.9rem] sm:text-6xl lg:text-[4.4rem] leading-[1.12] text-balance"
                                    dangerouslySetInnerHTML={{ __html: heroTitle }}
                                />
                            </FadeUp>
                            <FadeUp><p className="mt-7 max-w-xl prose-wa">{heroLead}</p></FadeUp>
                            <FadeUp>
                                <div className="mt-9 flex flex-wrap items-center gap-4">
                                    <Link href={url('/join')} className="btn btn-gold">
                                        {t('cta.join')} <ArrowRight />
                                    </Link>
                                    <Link href={`${url('/about')}#film`} className="link-arrow">
                                        {t('home.watch')} <PlayIcon />
                                    </Link>
                                </div>
                            </FadeUp>
                        </motion.div>

                        {/* photo collage */}
                        <div className="relative">
                            <div className="relative mx-auto w-full max-w-md lg:max-w-none aspect-[5/6] sm:aspect-[6/5] lg:aspect-[5/5]">
                                <span className="absolute right-[2%] top-[4%] w-[55%] h-[72%] border border-[var(--color-gold-soft)]/55 -translate-x-3 -translate-y-3 z-10" />

                                <div ref={pPortrait} className="absolute right-0 top-0 w-[58%] z-20">
                                    <HeroPhoto src={hero.image || '/storage/media/portrait.jpg'} aspect="aspect-[4/5]" rotate={1.5} delay={0.15} alt={brand.owner} />
                                </div>
                                <div ref={pCourse} className="absolute left-0 top-[20%] w-[45%] z-30">
                                    <HeroPhoto src="/storage/media/tropical.jpg" aspect="aspect-[3/4]" rotate={-3} delay={0.3} />
                                </div>
                                <div ref={pGroup} className="absolute left-[14%] bottom-0 w-[46%] z-40">
                                    <HeroPhoto src="/storage/media/la-round.jpg" aspect="aspect-[4/3]" rotate={2.5} delay={0.45} />
                                </div>

                                <motion.span
                                    className="hanko absolute right-[8%] bottom-[24%] z-50 bg-[var(--color-paper)]"
                                    initial={{ opacity: 0, scale: 0.6, rotate: -12 }}
                                    animate={{ opacity: 1, scale: 1, rotate: -2 }}
                                    transition={{ delay: 0.8, duration: 0.6, ease: EASE }}
                                >
                                    明見
                                </motion.span>
                                <span className="tategaki absolute left-[1%] top-[2%] text-xs tracking-[0.24em] text-[var(--color-gold)] hidden lg:block z-50">
                                    {t('home.hero_tategaki')}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {/* marquee */}
                <div className="border-y border-[var(--color-line)] bg-[var(--color-paper)]/50 overflow-hidden">
                    <motion.div
                        className="py-4 flex items-center gap-x-8 whitespace-nowrap text-[var(--color-mist)] font-[var(--font-label)] uppercase tracking-[0.3em] text-[0.66rem]"
                        animate={{ x: ['0%', '-50%'] }}
                        transition={{ duration: 28, ease: 'linear', repeat: Infinity }}
                    >
                        {[...CITIES, ...CITIES, ...CITIES, ...CITIES].map((c, i) => (
                            <span key={i} className="flex items-center gap-x-8">
                                <span>{c}</span>
                                <span className="text-[var(--color-gold)]">✦</span>
                            </span>
                        ))}
                    </motion.div>
                </div>
            </section>

            {/* ============ PURPOSE ============ */}
            <section className="wrap py-20 md:py-28">
                <SectionHead
                    align="center"
                    no="壱"
                    eyebrow={t('purpose.eyebrow')}
                    title={t('purpose.title')}
                    lead={t('purpose.lead')}
                    className="mb-14 md:mb-20"
                />
                <StaggerGroup className="grid gap-px bg-[var(--color-line)] border border-[var(--color-line)] md:grid-cols-3">
                    {['one', 'two', 'three'].map((k, i) => (
                        <StaggerItem key={k} className="bg-[var(--color-paper)] p-9 md:p-10">
                            <div className="flex items-center justify-between mb-6">
                                <span className="sec-no text-2xl">0{i + 1}</span>
                                <span className="tick" />
                            </div>
                            <h3 className="display text-2xl leading-snug">{t(`purpose.${k}_t`)}</h3>
                            <p className="mt-4 text-[var(--color-sumi-soft)] leading-loose">{t(`purpose.${k}_b`)}</p>
                        </StaggerItem>
                    ))}
                </StaggerGroup>
            </section>

            {/* ============ ABOUT teaser ============ */}
            <section className="relative py-20 md:py-28 bg-[var(--color-paper)] border-y border-[var(--color-line)]">
                <div className="wrap grid items-center gap-12 lg:grid-cols-2">
                    <Reveal className="relative order-2 lg:order-1">
                        <div className="img-frame aspect-[5/6] max-w-md mx-auto paper-edge group">
                            <img src={about.image || '/storage/media/about.jpg'} alt={brand.owner} className="h-full w-full object-cover" />
                        </div>
                        <span className="tategaki absolute -left-2 -top-4 h-28 text-sm text-[var(--color-gold)] hidden md:block">{t('home.about_tategaki')}</span>
                    </Reveal>
                    <div className="order-1 lg:order-2">
                        <SectionHead
                            no="弐"
                            eyebrow={t('pages.about.eyebrow')}
                            title={about.title || t('pages.home.about_teaser_title')}
                        />
                        <Reveal delay={0.1}>
                            <p className="prose-wa mt-7 whitespace-pre-line">
                                {about.lead || t('pages.home.about_teaser_lead')}
                            </p>
                        </Reveal>
                        <Reveal delay={0.15}>
                            <Link href={url('/about')} className="link-arrow mt-8">
                                {t('cta.learn_more')} <ArrowRight />
                            </Link>
                        </Reveal>
                    </div>
                </div>
            </section>

            {/* ============ ACTIVITIES ============ */}
            {activities.length > 0 && (
                <section className="wrap py-20 md:py-28">
                    <div className="flex flex-wrap items-end justify-between gap-6 mb-12 md:mb-16">
                        <SectionHead no="参" eyebrow={t('nav.activities')} title={t('pages.home.activities_section')} />
                        <Reveal>
                            <Link href={url('/activities')} className="link-arrow">{t('cta.view_all')} <ArrowRight /></Link>
                        </Reveal>
                    </div>
                    <StaggerGroup className="grid gap-7 md:grid-cols-3">
                        {activities.map((a) => (
                            <StaggerItem key={a.id}><ActivityCardView activity={a} /></StaggerItem>
                        ))}
                    </StaggerGroup>
                </section>
            )}

            {/* ============ FRIENDS / GLOBAL ============ */}
            {friends.length > 0 && (
                <section className="relative py-20 md:py-28 bg-[var(--color-matsuba)] grain-dark text-[var(--color-paper)]">
                    <div className="wrap">
                        <div className="flex flex-wrap items-end justify-between gap-6 mb-12 md:mb-16">
                            <Reveal className="max-w-2xl">
                                <span className="eyebrow !text-[var(--color-gold-soft)]">{t('nav.global')}</span>
                                <h2 className="mt-5 display text-3xl md:text-[2.6rem] leading-snug">{t('pages.home.friends_section')}</h2>
                            </Reveal>
                            <Reveal>
                                <Link href={url('/friends')} className="link-arrow !text-[var(--color-paper)]">{t('cta.view_all')} <ArrowRight /></Link>
                            </Reveal>
                        </div>
                        <StaggerGroup className="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                            {friends.map((f) => (
                                <StaggerItem key={f.id}>
                                    <div className="img-frame aspect-[3/4] group">
                                        {f.photo ? (
                                            <img src={f.photo} alt={f.name} className="h-full w-full object-cover" />
                                        ) : (
                                            <div className="h-full w-full grid place-items-center text-5xl bg-white/5">{f.flag ?? '⛳'}</div>
                                        )}
                                    </div>
                                    <p className="mt-3 display text-lg">{f.name}</p>
                                    <p className="text-white/55 text-sm tracking-wide">{f.flag} {f.country}</p>
                                </StaggerItem>
                            ))}
                        </StaggerGroup>
                    </div>
                </section>
            )}

            {/* ============ LIFE ============ */}
            {posts.length > 0 && (
                <section className="wrap py-20 md:py-28">
                    <div className="flex flex-wrap items-end justify-between gap-6 mb-12 md:mb-16">
                        <SectionHead no="肆" eyebrow={t('nav.life')} title={t('pages.home.life_section')} />
                        <Reveal>
                            <Link href={url('/life')} className="link-arrow">{t('cta.view_all')} <ArrowRight /></Link>
                        </Reveal>
                    </div>
                    <StaggerGroup className="grid gap-12 md:grid-cols-2">
                        {posts.map((p) => (
                            <StaggerItem key={p.id}><PostCardView post={p} /></StaggerItem>
                        ))}
                    </StaggerGroup>
                </section>
            )}

            {/* ============ JOIN band ============ */}
            <section className="wrap pb-8">
                <Reveal className="relative overflow-hidden bg-[var(--color-sumi)] grain-dark text-[var(--color-paper)] px-7 py-16 md:px-16 md:py-24 text-center">
                    <span className="hanko mx-auto mb-8 bg-[var(--color-sumi)] !text-[var(--color-gold-soft)] !border-[var(--color-gold-soft)]">募集</span>
                    <h2 className="display text-3xl md:text-5xl leading-snug max-w-3xl mx-auto text-balance">{t('join.lead')}</h2>
                    <Link href={url('/join')} className="btn btn-gold mt-10">{t('cta.join')} <ArrowRight /></Link>
                </Reveal>
            </section>
        </>
    );
}

function FadeUp({ children }: { children: React.ReactNode }) {
    return (
        <motion.div
            variants={{ hidden: { opacity: 0, y: 30 }, show: { opacity: 1, y: 0, transition: { duration: 0.9, ease: EASE } } }}
        >
            {children}
        </motion.div>
    );
}

function HeroPhoto({
    src,
    aspect,
    rotate,
    delay,
    alt = '',
}: {
    src: string;
    aspect: string;
    rotate: number;
    delay: number;
    alt?: string;
}) {
    return (
        <motion.figure
            initial={{ opacity: 0, y: 50, scale: 0.94, rotate: 0 }}
            animate={{ opacity: 1, y: 0, scale: 1, rotate }}
            transition={{ delay, duration: 1, ease: EASE }}
        >
            <div className={`img-frame ${aspect} paper-edge`}>
                <img src={src} alt={alt} className="h-full w-full object-cover" />
            </div>
        </motion.figure>
    );
}
