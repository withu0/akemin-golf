import { Head } from '@inertiajs/react';
import { useShared, useT } from '../lib/shared';
import { Reveal, StaggerGroup, StaggerItem, useParallax } from '../lib/anim';
import { PageHero, Prose, SectionHead } from '../Components/ui';
import type { SectionContent } from '../types';

export default function About({
    about,
    portrait,
    film,
    poster,
}: {
    about: SectionContent;
    portrait: string;
    film: string;
    poster: string;
}) {
    const { site } = useShared();
    const t = useT();
    const pPortrait = useParallax<HTMLDivElement>(40);

    const stats: [string, string, string][] = [
        ['35', '世界で学んだ国', 'Countries studied'],
        ['∞', '世界の友', 'Friends worldwide'],
        ['1日1歩', '毎日の挑戦', 'A challenge a day'],
    ];

    return (
        <>
            <Head title={`${t('nav.about')} — ${site.brand_ja}`} />

            <PageHero
                no="弐"
                eyebrow={`About — ${site.owner_en}`}
                seal="明見"
                title={about.title || '美容鍼の世界から、<br>グリーンの上へ。'}
                lead={about.lead || 'ハリジェンヌ主宰・光本朱見。世界を旅しながら、ゴルフで友をつないでいます。'}
                image={about.image || portrait}
            />

            {/* bio */}
            <section className="wrap py-14 md:py-20">
                <div className="grid gap-12 lg:gap-16 lg:grid-cols-[0.9fr_1.1fr]">
                    <Reveal className="relative">
                        <div ref={pPortrait} className="img-frame aspect-[4/5] max-w-md paper-edge">
                            <img src={portrait} alt={site.owner_ja} className="h-full w-full object-cover" />
                        </div>
                        <span className="tategaki absolute -right-7 top-6 text-xs tracking-[0.22em] text-[var(--color-gold)] hidden lg:block">
                            より美しく、未来を求めて
                        </span>
                    </Reveal>

                    <Reveal delay={0.1}>
                        <Prose
                            text={
                                about.body ||
                                'はじめまして、光本朱見（あけみん）です。\n美容鍼サロン「ハリジェンヌ」を主宰し、世界35カ国で美と健康を学んできました。\n\nゴルフは、私にとって人生そのもの。グリーンに立てば、年齢も国籍も関係なく、ひとつの笑顔でつながれます。\n\n美容・集中力・健康・体力・足腰——ゴルフはそのすべてを磨いてくれる。だから私は、ゴルフを通して世界中に友達を増やし、Global Grandmother を目指しています。'
                            }
                        />
                    </Reveal>
                </div>
            </section>

            {/* credentials */}
            <section className="wrap pb-6">
                <StaggerGroup className="grid gap-px bg-[var(--color-line)] border border-[var(--color-line)] sm:grid-cols-3">
                    {stats.map((s) => (
                        <StaggerItem key={s[1]} className="bg-[var(--color-paper)] p-8 text-center">
                            <p className="display text-4xl text-[var(--color-gold)]">{s[0]}</p>
                            <p className="mt-2 font-[var(--font-serif)] text-lg">{s[1]}</p>
                            <p className="eyebrow before:hidden !tracking-[0.2em] mt-1">{s[2]}</p>
                        </StaggerItem>
                    ))}
                </StaggerGroup>
            </section>

            {/* film */}
            <section id="film" className="wrap py-16 md:py-24 scroll-mt-28">
                <SectionHead align="center" eyebrow="Film" title="スウィングという、いちばんの自己紹介。" className="mb-10 md:mb-14" />
                <Reveal className="img-frame aspect-video max-w-4xl mx-auto paper-edge bg-[var(--color-sumi)]">
                    <video className="h-full w-full object-cover" controls preload="metadata" playsInline poster={poster}>
                        <source src={film} type="video/mp4" />
                    </video>
                </Reveal>
            </section>
        </>
    );
}
