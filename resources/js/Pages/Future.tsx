import { Head, Link } from '@inertiajs/react';
import { useShared, useT, useUrl } from '../lib/shared';
import { Reveal, StaggerGroup, StaggerItem } from '../lib/anim';
import { ArrowRight, PageHero, Prose } from '../Components/ui';
import type { SectionContent } from '../types';

export default function Future({ future }: { future: SectionContent }) {
    const { site } = useShared();
    const t = useT();
    const url = useUrl();

    const steps: [string, string, string][] = [
        ['挑戦', '毎日、ひとつ', 'A challenge a day'],
        ['つながり', '世界に友を', 'Friends worldwide'],
        ['しなやかさ', '生涯、自分の足で', 'Grace for a lifetime'],
    ];

    return (
        <>
            <Head title={`${t('nav.future')} — ${site.brand_ja}`} />

            <PageHero
                no="伍"
                eyebrow="The Road Ahead"
                seal="未来"
                title={future.title || 'これからの、ゴルフ。'}
                lead={future.lead || '一打ごとに、未来をひらいていく。あけみんが描く、これからの景色。'}
                image={future.image || '/storage/media/future.jpg'}
            />

            <section className="wrap-tight py-14 md:py-20">
                <Reveal>
                    <Prose
                        text={
                            future.body ||
                            '目標は、Global Grandmother。\n世界中のグリーンに立ち、年齢を重ねるほどに自由に、しなやかに。\n\nいつか、出会った友と同じコースを歩き、それぞれの国の言葉で笑い合いたい。\nゴルフは、その夢への一歩。これからも毎日挑戦し、エネルギーを高めていきます。'
                        }
                    />
                </Reveal>
            </section>

            <section className="wrap pb-8">
                <StaggerGroup className="grid gap-px bg-[var(--color-line)] border border-[var(--color-line)] md:grid-cols-3">
                    {steps.map((v, i) => (
                        <StaggerItem key={v[0]} className="bg-[var(--color-paper)] p-9">
                            <span className="sec-no text-xl">0{i + 1}</span>
                            <h3 className="display text-2xl mt-4">{v[0]}</h3>
                            <p className="mt-2 font-[var(--font-serif)] text-[var(--color-sumi-soft)]">{v[1]}</p>
                            <p className="eyebrow before:hidden !tracking-[0.2em] mt-3">{v[2]}</p>
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
