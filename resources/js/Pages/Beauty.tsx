import { Head } from '@inertiajs/react';
import { useShared, useT, useBrand } from '../lib/shared';
import { Reveal, StaggerGroup, StaggerItem } from '../lib/anim';
import { PageHero, Prose } from '../Components/ui';
import type { SectionContent } from '../types';

export default function Beauty({ beauty }: { beauty: SectionContent }) {
    const { site } = useShared();
    const t = useT();
    const brand = useBrand();
    const pillars = ['p1', 'p2', 'p3', 'p4', 'p5'];

    return (
        <>
            <Head title={`${t('nav.beauty')} — ${brand.name}`} />

            <PageHero
                no="弐"
                eyebrow={t('beauty.eyebrow')}
                seal="美"
                title={beauty.title || t('beauty.title')}
                lead={beauty.lead || t('beauty.lead')}
                image={beauty.image || '/storage/media/beauty.jpg'}
            />

            <section className="wrap py-10 md:py-16">
                <StaggerGroup className="grid gap-px bg-[var(--color-line)] border border-[var(--color-line)] sm:grid-cols-2 lg:grid-cols-5">
                    {pillars.map((p, i) => (
                        <StaggerItem key={p} className="bg-[var(--color-paper)] p-7 flex flex-col">
                            <span className="sec-no text-xl">0{i + 1}</span>
                            <h3 className="display text-2xl mt-4 mb-3">{t(`beauty.${p}_t`)}</h3>
                            <p className="text-[var(--color-sumi-soft)] text-[0.95rem] leading-relaxed">{t(`beauty.${p}_b`)}</p>
                        </StaggerItem>
                    ))}
                </StaggerGroup>
            </section>

            {beauty.body && (
                <section className="wrap-tight py-12 md:py-20">
                    <Reveal><Prose text={beauty.body} /></Reveal>
                </section>
            )}

            <section className="wrap py-12">
                <Reveal className="bg-[var(--color-paper)] border border-[var(--color-line)] px-8 py-14 md:py-20 text-center">
                    <span className="eyebrow">Harisienne</span>
                    <p className="display text-2xl md:text-4xl leading-snug max-w-3xl mx-auto mt-6 text-balance">
                        {t('beauty.quote')}
                    </p>
                    <a href={site.harisienne} target="_blank" rel="noopener" className="link-arrow mt-8">
                        {t('footer.also')} <span>↗</span>
                    </a>
                </Reveal>
            </section>
        </>
    );
}
