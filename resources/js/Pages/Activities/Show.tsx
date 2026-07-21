import { Head, Link } from '@inertiajs/react';
import { useT, useUrl, useBrand } from '../../lib/shared';
import { Reveal, StaggerGroup, StaggerItem } from '../../lib/anim';
import { ArrowLeft, Prose, SectionHead } from '../../Components/ui';
import { ActivityCardMedia, ActivityCardView } from '../../Components/cards';
import { ActivityGallery } from '../../Components/ActivityGallery';
import type { ActivityCard } from '../../types';

export default function Show({ activity, more }: { activity: ActivityCard; more: ActivityCard[] }) {
    const t = useT();
    const brand = useBrand();
    const url = useUrl();
    const gallery = activity.gallery ?? [];
    const hasCover = Boolean(activity.cover || activity.video);
    const showGallery = gallery.length > 1 || (!hasCover && gallery.length > 0);

    return (
        <>
            <Head title={`${activity.title} — ${brand.name}`} />

            <article className="pt-32 md:pt-40">
                <div className="wrap-tight">
                    <Reveal>
                        <Link href={url('/activities')} className="link-arrow mb-8"><ArrowLeft /> {t('cta.back')}</Link>
                    </Reveal>
                    <Reveal delay={0.05}>
                        <div className="flex items-center gap-3 text-[var(--color-mist)] text-xs tracking-widest uppercase font-[var(--font-label)] mb-5">
                            {activity.date && <span>{activity.date}</span>}
                            {activity.location && <span className="text-[var(--color-gold)]">— {activity.location}</span>}
                        </div>
                    </Reveal>
                    <Reveal delay={0.1}>
                        <h1 className="display text-3xl md:text-5xl leading-tight text-balance">{activity.title}</h1>
                    </Reveal>
                </div>

                {hasCover && (
                    <div className="wrap mt-10 md:mt-12">
                        <Reveal>
                            <ActivityCardMedia
                                activity={activity}
                                aspectClass="aspect-[16/9]"
                                frameClassName="img-frame paper-edge"
                            />
                        </Reveal>
                    </div>
                )}

                {showGallery && (
                    <div className="wrap mt-6 md:mt-8">
                        <Reveal>
                            <ActivityGallery items={gallery} title={activity.title} />
                        </Reveal>
                    </div>
                )}

                <div className="wrap-tight py-12 md:py-16">
                    <Reveal><Prose text={activity.body} /></Reveal>
                </div>
            </article>

            {more.length > 0 && (
                <section className="wrap pb-12">
                    <hr className="rule-gold mb-12" />
                    <SectionHead eyebrow={t('common.more')} title={t('pages.activities.more_title')} className="mb-10" />
                    <StaggerGroup className="grid gap-7 sm:grid-cols-3">
                        {more.map((a) => (
                            <StaggerItem key={a.id}><ActivityCardView activity={a} /></StaggerItem>
                        ))}
                    </StaggerGroup>
                </section>
            )}
        </>
    );
}
