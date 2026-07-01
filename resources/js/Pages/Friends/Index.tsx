import { Head, Link } from '@inertiajs/react';
import { useShared, useT, useUrl } from '../../lib/shared';
import { Reveal, StaggerGroup, StaggerItem } from '../../lib/anim';
import { ArrowRight, PageHero } from '../../Components/ui';
import { FriendCardView } from '../../Components/cards';
import type { FriendCard } from '../../types';

export default function Index({ friends }: { friends: FriendCard[] }) {
    const { site } = useShared();
    const t = useT();
    const url = useUrl();

    return (
        <>
            <Head title={`${t('nav.friends')} — ${site.brand_ja}`} />

            <PageHero
                no="肆"
                eyebrow="Golf Friends"
                seal="友"
                title="あけみんゴルフ、友。"
                lead="一打が、ひとつの出会い。世界中でつながった、大切な仲間たち。"
            />

            <section className="wrap py-12 md:py-16">
                {friends.length === 0 ? (
                    <p className="text-center text-[var(--color-mist)] py-16 font-[var(--font-serif)] text-xl">仲間を紹介中です。</p>
                ) : (
                    <StaggerGroup className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        {friends.map((f) => (
                            <StaggerItem key={f.id}><FriendCardView friend={f} /></StaggerItem>
                        ))}
                    </StaggerGroup>
                )}
            </section>

            <section className="wrap py-12 text-center">
                <Reveal>
                    <p className="font-[var(--font-serif)] text-xl text-[var(--color-sumi-soft)]">あなたも、ゴルフ友になりませんか。</p>
                    <Link href={url('/join')} className="btn btn-gold mt-6">{t('cta.join')} <ArrowRight /></Link>
                </Reveal>
            </section>
        </>
    );
}
