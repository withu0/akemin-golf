import { Head, Link } from '@inertiajs/react';
import { useShared, useT, useUrl } from '../../lib/shared';
import { Reveal, StaggerGroup, StaggerItem } from '../../lib/anim';
import { ArrowLeft, Prose, SectionHead } from '../../Components/ui';
import { PostCardView } from '../../Components/cards';
import type { PostCard } from '../../types';

export default function Show({ post, more }: { post: PostCard; more: PostCard[] }) {
    const { site } = useShared();
    const t = useT();
    const url = useUrl();

    return (
        <>
            <Head title={`${post.title} — ${site.brand_ja}`} />

            <article className="pt-32 md:pt-40">
                <div className="wrap-tight text-center">
                    <Reveal>
                        <Link href={url('/life')} className="link-arrow mb-8"><ArrowLeft /> {t('cta.back')}</Link>
                    </Reveal>
                    <Reveal delay={0.05}>
                        <div className="flex items-center justify-center gap-3 text-[var(--color-mist)] text-xs tracking-widest uppercase font-[var(--font-label)] mb-5">
                            {post.date && <span>{post.date}</span>}
                            {post.category && <span className="text-[var(--color-gold)]">— {post.category}</span>}
                        </div>
                    </Reveal>
                    <Reveal delay={0.1}>
                        <h1 className="display text-3xl md:text-5xl leading-tight text-balance max-w-3xl mx-auto">{post.title}</h1>
                    </Reveal>
                </div>

                {post.cover && (
                    <div className="wrap mt-10 md:mt-12">
                        <Reveal className="img-frame aspect-[16/9] max-w-4xl mx-auto paper-edge">
                            <img src={post.cover} alt={post.title} className="h-full w-full object-cover" />
                        </Reveal>
                    </div>
                )}

                <div className="wrap-tight py-12 md:py-16">
                    {post.excerpt && (
                        <Reveal>
                            <p className="display text-xl md:text-2xl leading-relaxed text-[var(--color-sumi-soft)] mb-10">{post.excerpt}</p>
                            <hr className="rule-ink mb-10" />
                        </Reveal>
                    )}
                    <Reveal delay={0.05}><Prose text={post.body} /></Reveal>
                </div>
            </article>

            {more.length > 0 && (
                <section className="wrap pb-12">
                    <hr className="rule-gold mb-12" />
                    <SectionHead eyebrow="More" title="ほかのことば" className="mb-10" />
                    <StaggerGroup className="grid gap-10 sm:grid-cols-3">
                        {more.map((p) => (
                            <StaggerItem key={p.id}><PostCardView post={p} /></StaggerItem>
                        ))}
                    </StaggerGroup>
                </section>
            )}
        </>
    );
}
