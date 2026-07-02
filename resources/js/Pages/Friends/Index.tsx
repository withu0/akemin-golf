import { Head, Link } from '@inertiajs/react';
import { useT, useUrl, useBrand } from '../../lib/shared';
import { Reveal, StaggerGroup, StaggerItem } from '../../lib/anim';
import { ArrowRight, PageHero } from '../../Components/ui';
import { FriendCardView } from '../../Components/cards';
import type { FriendCard } from '../../types';

export default function Index({ friends }: { friends: FriendCard[] }) {
    const t = useT();
    const brand = useBrand();
    const url = useUrl();

    return (
        <>
            <Head title={`${t('nav.friends')} — ${brand.name}`} />

            <PageHero
                no="肆"
                eyebrow={t('nav.friends')}
                seal="友"
                title={t('pages.friends.hero_title')}
                lead={t('pages.friends.hero_lead')}
            />

            <section className="wrap py-12 md:py-16">
                {friends.length === 0 ? (
                    <p className="text-center text-[var(--color-mist)] py-16 font-[var(--font-serif)] text-xl">{t('pages.friends.empty')}</p>
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
                    <p className="font-[var(--font-serif)] text-xl text-[var(--color-sumi-soft)]">{t('pages.friends.cta')}</p>
                    <Link href={url('/join')} className="btn btn-gold mt-6">{t('cta.join')} <ArrowRight /></Link>
                </Reveal>
            </section>
        </>
    );
}
