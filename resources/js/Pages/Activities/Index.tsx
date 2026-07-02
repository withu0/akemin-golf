import { Head } from '@inertiajs/react';
import { useT, useBrand } from '../../lib/shared';
import { StaggerGroup, StaggerItem } from '../../lib/anim';
import { PageHero } from '../../Components/ui';
import { ActivityCardView } from '../../Components/cards';
import type { ActivityCard } from '../../types';

export default function Index({ activities }: { activities: ActivityCard[] }) {
    const t = useT();
    const brand = useBrand();

    return (
        <>
            <Head title={`${t('nav.activities')} — ${brand.name}`} />

            <PageHero
                no="参"
                eyebrow={t('nav.activities')}
                seal="活動"
                title={t('pages.activities.hero_title')}
                lead={t('pages.activities.hero_lead')}
            />

            <section className="wrap py-12 md:py-16">
                {activities.length === 0 ? (
                    <p className="text-center text-[var(--color-mist)] py-16 font-[var(--font-serif)] text-xl">
                        {t('pages.activities.empty')}
                    </p>
                ) : (
                    <StaggerGroup className="grid gap-7 sm:grid-cols-2 lg:grid-cols-3">
                        {activities.map((a) => (
                            <StaggerItem key={a.id}><ActivityCardView activity={a} /></StaggerItem>
                        ))}
                    </StaggerGroup>
                )}
            </section>
        </>
    );
}
