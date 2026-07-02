import { Head, Link } from '@inertiajs/react';
import { useT, useUrl, useBrand } from '../lib/shared';
import { Reveal, StaggerGroup, StaggerItem } from '../lib/anim';
import { ArrowRight, PageHero, Prose } from '../Components/ui';
import type { SectionContent } from '../types';

export default function Future({ future }: { future: SectionContent }) {
    const t = useT();
    const brand = useBrand();
    const url = useUrl();

    const steps = [
        { title: t('pages.future.step1_title'), label: t('pages.future.step1_label') },
        { title: t('pages.future.step2_title'), label: t('pages.future.step2_label') },
        { title: t('pages.future.step3_title'), label: t('pages.future.step3_label') },
    ];

    return (
        <>
            <Head title={`${t('nav.future')} — ${brand.name}`} />

            <PageHero
                no="伍"
                eyebrow={t('nav.future')}
                seal="未来"
                title={future.title || t('pages.future.hero_title')}
                lead={future.lead || t('pages.future.hero_lead')}
                image={future.image || '/storage/media/future.jpg'}
            />

            <section className="wrap-tight py-14 md:py-20">
                <Reveal>
                    <Prose text={future.body || t('pages.future.body')} />
                </Reveal>
            </section>

            <section className="wrap pb-8">
                <StaggerGroup className="grid gap-px bg-[var(--color-line)] border border-[var(--color-line)] md:grid-cols-3">
                    {steps.map((v, i) => (
                        <StaggerItem key={v.title} className="bg-[var(--color-paper)] p-9">
                            <span className="sec-no text-xl">0{i + 1}</span>
                            <h3 className="display text-2xl mt-4">{v.title}</h3>
                            <p className="mt-2 font-[var(--font-serif)] text-[var(--color-sumi-soft)]">{v.label}</p>
                        </StaggerItem>
                    ))}
                </StaggerGroup>
            </section>

            <section className="wrap py-12 text-center">
                <Reveal><Link href={url('/join')} className="btn btn-gold">{t('cta.join')} <ArrowRight /></Link></Reveal>
            </section>
        </>
    );
}
