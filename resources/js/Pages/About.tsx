import { Head } from '@inertiajs/react';
import { useT, useBrand } from '../lib/shared';
import { Reveal, StaggerGroup, StaggerItem, useParallax } from '../lib/anim';
import { PageHero, Prose, SectionHead } from '../Components/ui';
import type { SectionContent } from '../types';

export default function About({
    about,
    portrait,
    film,
    poster,
}: {
    about: SectionContent;
    portrait: string;
    film: string;
    poster: string;
}) {
    const t = useT();
    const brand = useBrand();
    const pPortrait = useParallax<HTMLDivElement>(40);

    const stats = [
        { value: t('pages.about.stat1_value'), label: t('pages.about.stat1_label') },
        { value: t('pages.about.stat2_value'), label: t('pages.about.stat2_label') },
        { value: t('pages.about.stat3_value'), label: t('pages.about.stat3_label') },
    ];

    return (
        <>
            <Head title={`${t('nav.about')} — ${brand.name}`} />

            <PageHero
                no="弐"
                eyebrow={t('pages.about.eyebrow')}
                seal="朱見"
                title={about.title || t('pages.about.hero_title')}
                lead={about.lead || t('pages.about.hero_lead')}
                image={about.image || portrait}
            />

            {/* bio */}
            <section className="wrap py-14 md:py-20">
                <div className="grid gap-12 lg:gap-16 lg:grid-cols-[0.9fr_1.1fr]">
                    <Reveal className="relative">
                        <div ref={pPortrait} className="img-frame aspect-[4/5] max-w-md paper-edge">
                            <img src={portrait} alt={brand.owner} className="h-full w-full object-cover" />
                        </div>
                        <span className="tategaki absolute -right-7 top-6 text-xs tracking-[0.22em] text-[var(--color-gold)] hidden lg:block">
                            {t('pages.about.motto')}
                        </span>
                    </Reveal>

                    <Reveal delay={0.1}>
                        <Prose text={about.body || t('pages.about.body')} />
                    </Reveal>
                </div>
            </section>

            {/* credentials */}
            <section className="wrap pb-6">
                <StaggerGroup className="grid gap-px bg-[var(--color-line)] border border-[var(--color-line)] sm:grid-cols-3">
                    {stats.map((s) => (
                        <StaggerItem key={s.label} className="bg-[var(--color-paper)] p-8 text-center">
                            <p className="display text-4xl text-[var(--color-gold)]">{s.value}</p>
                            <p className="mt-2 font-[var(--font-serif)] text-lg">{s.label}</p>
                        </StaggerItem>
                    ))}
                </StaggerGroup>
            </section>

            {/* film */}
            <section id="film" className="wrap py-16 md:py-24 scroll-mt-28">
                <SectionHead align="center" eyebrow={t('pages.about.film_eyebrow')} title={t('pages.about.film_title')} className="mb-10 md:mb-14" />
                <Reveal className="img-frame aspect-video max-w-4xl mx-auto paper-edge bg-[var(--color-sumi)]">
                    <video className="h-full w-full object-cover" controls preload="metadata" playsInline poster={poster}>
                        <source src={film} type="video/mp4" />
                    </video>
                </Reveal>
            </section>
        </>
    );
}
