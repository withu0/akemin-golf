import { Head, Link } from '@inertiajs/react';
import { useShared, useT, useUrl } from '../lib/shared';
import { Reveal, StaggerGroup, StaggerItem } from '../lib/anim';
import { ArrowRight, PageHero, Prose, SectionHead } from '../Components/ui';
import { FriendCardView } from '../Components/cards';
import type { FriendCard, SectionContent } from '../types';

const CITIES = ['東京 Tokyo', 'Los Angeles', 'Singapore', 'Dubai', 'Paris', 'Mumbai'];

export default function Global({ global, friends }: { global: SectionContent; friends: FriendCard[] }) {
    const { site } = useShared();
    const t = useT();
    const url = useUrl();

    return (
        <>
            <Head title={`${t('nav.global')} — ${site.brand_ja}`} />

            <PageHero
                no="漆"
                eyebrow="Global Golf"
                seal="世界"
                title={global.title || 'グリーンは、<br>世界へつづいている。'}
                lead={global.lead || 'クラブひとつを携えて、国から国へ。ゴルフは、世界中の友と出会うためのパスポート。'}
                image={global.image || '/storage/media/airport.jpg'}
            />

            <section className="wrap py-12 md:py-16">
                <Reveal className="flex flex-wrap justify-center gap-x-10 gap-y-4">
                    {CITIES.map((c, i) => (
                        <span key={c} className="flex items-center gap-x-10">
                            <span className="font-[var(--font-serif)] text-xl md:text-2xl text-[var(--color-sumi-soft)]">{c}</span>
                            {i < CITIES.length - 1 && <span className="text-[var(--color-gold)]">✦</span>}
                        </span>
                    ))}
                </Reveal>
            </section>

            {global.body && (
                <section className="wrap-tight pb-8">
                    <Reveal><Prose text={global.body} /></Reveal>
                </section>
            )}

            {friends.length > 0 && (
                <section className="wrap py-12 md:py-16">
                    <SectionHead eyebrow={t('nav.friends')} title="世界の、ゴルフ友。" className="mb-10 md:mb-14" />
                    <StaggerGroup className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        {friends.map((f) => (
                            <StaggerItem key={f.id}><FriendCardView friend={f} /></StaggerItem>
                        ))}
                    </StaggerGroup>
                </section>
            )}

            <section className="wrap py-12 text-center">
                <Reveal><Link href={url('/join')} className="btn btn-gold">{t('cta.join')} <ArrowRight /></Link></Reveal>
            </section>
        </>
    );
}
