import { Head } from '@inertiajs/react';
import { useT, useBrand } from '../../lib/shared';
import { StaggerGroup, StaggerItem } from '../../lib/anim';
import { PageHero } from '../../Components/ui';
import { PostCardView } from '../../Components/cards';
import type { PostCard } from '../../types';

export default function Index({ posts }: { posts: PostCard[] }) {
    const t = useT();
    const brand = useBrand();

    return (
        <>
            <Head title={`${t('nav.life')} — ${brand.name}`} />

            <PageHero
                no="陸"
                eyebrow={t('nav.life')}
                seal="人生"
                title={t('pages.life.hero_title')}
                lead={t('pages.life.hero_lead')}
            />

            <section className="wrap py-12 md:py-16">
                {posts.length === 0 ? (
                    <p className="text-center text-[var(--color-mist)] py-16 font-[var(--font-serif)] text-xl">{t('pages.life.empty')}</p>
                ) : (
                    <StaggerGroup className="grid gap-12 md:gap-x-10 md:gap-y-16 md:grid-cols-2">
                        {posts.map((p) => (
                            <StaggerItem key={p.id}><PostCardView post={p} /></StaggerItem>
                        ))}
                    </StaggerGroup>
                )}
            </section>
        </>
    );
}
