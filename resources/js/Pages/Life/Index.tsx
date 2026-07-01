import { Head } from '@inertiajs/react';
import { useShared, useT } from '../../lib/shared';
import { StaggerGroup, StaggerItem } from '../../lib/anim';
import { PageHero } from '../../Components/ui';
import { PostCardView } from '../../Components/cards';
import type { PostCard } from '../../types';

export default function Index({ posts }: { posts: PostCard[] }) {
    const { site } = useShared();
    const t = useT();

    return (
        <>
            <Head title={`${t('nav.life')} — ${site.brand_ja}`} />

            <PageHero
                no="陸"
                eyebrow="Golf & Life"
                seal="人生"
                title="ゴルフと、人生。"
                lead="グリーンの上で気づいた、小さな哲学。あけみんの綴る、ことば。"
            />

            <section className="wrap py-12 md:py-16">
                {posts.length === 0 ? (
                    <p className="text-center text-[var(--color-mist)] py-16 font-[var(--font-serif)] text-xl">執筆中です。</p>
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
