import type { ReactNode } from 'react';
import { Reveal } from '../lib/anim';

export function ArrowRight({ className = '' }: { className?: string }) {
    return (
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" className={className}>
            <path d="M1 7h12M8 2l5 5-5 5" stroke="currentColor" strokeWidth="1.4" />
        </svg>
    );
}

export function ArrowLeft({ className = '' }: { className?: string }) {
    return (
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" className={className}>
            <path d="M13 7H1M6 2L1 7l5 5" stroke="currentColor" strokeWidth="1.4" />
        </svg>
    );
}

export function PlayIcon() {
    return (
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
            <circle cx="8" cy="8" r="7" stroke="currentColor" strokeWidth="1" />
            <path d="M6.5 5.5l4 2.5-4 2.5z" fill="currentColor" />
        </svg>
    );
}

export function Eyebrow({
    children,
    className = '',
}: {
    children: ReactNode;
    className?: string;
}) {
    return <span className={`eyebrow ${className}`}>{children}</span>;
}

export function Hanko({
    children,
    className = '',
}: {
    children: ReactNode;
    className?: string;
}) {
    return <span className={`hanko ${className}`}>{children}</span>;
}

export function SectionHead({
    eyebrow,
    no,
    title,
    lead,
    align = 'left',
    className = '',
}: {
    eyebrow?: ReactNode;
    no?: ReactNode;
    title: string;
    lead?: string;
    align?: 'left' | 'center';
    className?: string;
}) {
    return (
        <Reveal className={`max-w-2xl ${align === 'center' ? 'mx-auto text-center' : ''} ${className}`}>
            <div className={`flex items-center gap-4 mb-5 ${align === 'center' ? 'justify-center' : ''}`}>
                {no && <span className="sec-no">{no}</span>}
                {eyebrow && <span className="eyebrow">{eyebrow}</span>}
            </div>
            <h2 className="display text-3xl md:text-[2.6rem] leading-snug text-balance"
                dangerouslySetInnerHTML={{ __html: title }} />
            {lead && <p className="mt-5 text-[var(--color-sumi-soft)] leading-loose">{lead}</p>}
        </Reveal>
    );
}

export function PageHero({
    eyebrow,
    no,
    title,
    lead,
    image,
    seal,
}: {
    eyebrow?: ReactNode;
    no?: ReactNode;
    title: string;
    lead?: string;
    image?: string | null;
    seal?: string;
}) {
    return (
        <section className="relative overflow-hidden pt-36 md:pt-48 pb-14 md:pb-20">
            {image && (
                <div className="absolute inset-0 -z-10">
                    <img src={image} alt="" className="h-full w-full object-cover opacity-[0.16]" />
                    <div className="absolute inset-0 bg-gradient-to-b from-[var(--color-washi)] via-[var(--color-washi)]/70 to-[var(--color-washi)]" />
                </div>
            )}
            <div className="wrap relative">
                <Reveal className="flex items-center gap-4 mb-6">
                    {no && <span className="sec-no">{no}</span>}
                    {eyebrow && <span className="eyebrow">{eyebrow}</span>}
                </Reveal>
                <div className="flex items-end justify-between gap-8">
                    <Reveal as="h1" className="display text-[2.6rem] md:text-6xl leading-[1.15] text-balance">
                        <span dangerouslySetInnerHTML={{ __html: title }} />
                    </Reveal>
                    {seal && <Hanko className="shrink-0 mb-2 hidden sm:inline-grid">{seal}</Hanko>}
                </div>
                {lead && (
                    <Reveal delay={0.1}>
                        <p className="mt-7 max-w-2xl prose-wa">{lead}</p>
                    </Reveal>
                )}
                <Reveal delay={0.15}>
                    <hr className="rule-gold mt-10 md:mt-14" />
                </Reveal>
            </div>
        </section>
    );
}

/** Body copy with paragraph breaks preserved (\n\n => paragraphs). */
export function Prose({ text, className = '' }: { text: string; className?: string }) {
    return (
        <div className={`prose-wa ${className}`}>
            {text.split(/\n{2,}/).map((para, i) => (
                <p key={i}>
                    {para.split('\n').map((line, j, arr) => (
                        <span key={j}>
                            {line}
                            {j < arr.length - 1 && <br />}
                        </span>
                    ))}
                </p>
            ))}
        </div>
    );
}
