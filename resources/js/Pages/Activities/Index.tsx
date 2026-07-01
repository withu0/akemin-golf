import { Head } from '@inertiajs/react';
import { useShared, useT } from '../../lib/shared';
import { StaggerGroup, StaggerItem } from '../../lib/anim';
import { PageHero } from '../../Components/ui';
import { ActivityCardView } from '../../Components/cards';
import type { ActivityCard } from '../../types';

export default function Index({ activities }: { activities: ActivityCard[] }) {
    const { site } = useShared();
    const t = useT();

    return (
        <>
            <Head title={`${t('nav.activities')} — ${site.brand_ja}`} />

            <PageHero
                no="参"
                eyebrow="Activities"
                seal="活動"
                title="最近の、活動。"
                lead="ラウンド、旅、出会い。あけみんゴルフの、いきいきとした日々。"
            />

            <section className="wrap py-12 md:py-16">
                {activities.length === 0 ? (
                    <p className="text-center text-[var(--color-mist)] py-16 font-[var(--font-serif)] text-xl">
                        準備中です。もうすこしお待ちください。
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
