import { useCallback, useEffect, useRef, useState } from 'react';
import type { ActivityMediaItem } from '../types';
import { ExpandIcon, LightboxImage, LightboxVideo, MediaLightbox } from './CoverImageLightbox';

function ChevronLeft() {
    return (
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" className="h-6 w-6">
            <path d="M15 18l-6-6 6-6" />
        </svg>
    );
}

function ChevronRight() {
    return (
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" className="h-6 w-6">
            <path d="M9 18l6-6-6-6" />
        </svg>
    );
}

export function ActivityGallery({
    items,
    title,
}: {
    items: ActivityMediaItem[];
    title: string;
}) {
    const [activeIndex, setActiveIndex] = useState<number | null>(null);
    const lightboxVideoRef = useRef<HTMLVideoElement>(null);
    const active = activeIndex !== null ? items[activeIndex] ?? null : null;
    const hasNav = items.length > 1;

    const close = useCallback(() => {
        lightboxVideoRef.current?.pause();
        setActiveIndex(null);
    }, []);

    const goPrev = useCallback(
        (e?: React.MouseEvent) => {
            e?.stopPropagation();
            if (!hasNav || activeIndex === null) return;
            lightboxVideoRef.current?.pause();
            setActiveIndex((activeIndex - 1 + items.length) % items.length);
        },
        [activeIndex, hasNav, items.length],
    );

    const goNext = useCallback(
        (e?: React.MouseEvent) => {
            e?.stopPropagation();
            if (!hasNav || activeIndex === null) return;
            lightboxVideoRef.current?.pause();
            setActiveIndex((activeIndex + 1) % items.length);
        },
        [activeIndex, hasNav, items.length],
    );

    useEffect(() => {
        if (active?.type !== 'video') return;
        lightboxVideoRef.current?.play().catch(() => {});
    }, [active]);

    useEffect(() => {
        if (activeIndex === null || !hasNav) return;

        const onKeyDown = (e: KeyboardEvent) => {
            if (e.key === 'ArrowLeft') {
                e.preventDefault();
                goPrev();
            } else if (e.key === 'ArrowRight') {
                e.preventDefault();
                goNext();
            }
        };

        document.addEventListener('keydown', onKeyDown);
        return () => document.removeEventListener('keydown', onKeyDown);
    }, [activeIndex, goNext, goPrev, hasNav]);

    if (items.length === 0) {
        return null;
    }

    return (
        <>
            <div className="grid gap-2 sm:gap-2.5 grid-cols-2 sm:grid-cols-4">
                {items.map((item, index) => (
                    <button
                        key={item.id}
                        type="button"
                        onClick={() => setActiveIndex(index)}
                        className="group relative img-frame aspect-square overflow-hidden text-left"
                    >
                        {item.type === 'image' ? (
                            <img
                                src={item.url}
                                alt={title}
                                className="h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.03]"
                            />
                        ) : (
                            <>
                                <video
                                    src={item.url}
                                    muted
                                    playsInline
                                    preload="metadata"
                                    className="h-full w-full object-cover"
                                />
                                <span className="absolute inset-0 flex items-center justify-center">
                                    <span className="flex h-9 w-9 items-center justify-center rounded-full bg-black/45 text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="h-4 w-4 ml-0.5">
                                            <path d="M8 5v14l11-7z" />
                                        </svg>
                                    </span>
                                </span>
                            </>
                        )}
                        <span className="absolute bottom-1.5 right-1.5 flex h-7 w-7 items-center justify-center rounded-full bg-black/45 text-white opacity-0 transition-opacity group-hover:opacity-100">
                            <ExpandIcon />
                        </span>
                    </button>
                ))}
            </div>

            <MediaLightbox open={active !== null} onClose={close}>
                {hasNav && (
                    <button
                        type="button"
                        onClick={goPrev}
                        className="absolute left-3 md:left-6 z-10 flex h-11 w-11 items-center justify-center rounded-full bg-white/10 text-white transition-colors hover:bg-white/25"
                        aria-label="Previous"
                    >
                        <ChevronLeft />
                    </button>
                )}

                {active?.type === 'image' && <LightboxImage src={active.url} alt={title} />}
                {active?.type === 'video' && <LightboxVideo ref={lightboxVideoRef} src={active.url} />}

                {hasNav && (
                    <button
                        type="button"
                        onClick={goNext}
                        className="absolute right-3 md:right-6 z-10 flex h-11 w-11 items-center justify-center rounded-full bg-white/10 text-white transition-colors hover:bg-white/25"
                        aria-label="Next"
                    >
                        <ChevronRight />
                    </button>
                )}

                {hasNav && activeIndex !== null && (
                    <span className="absolute bottom-4 left-1/2 -translate-x-1/2 z-10 rounded-full bg-black/50 px-3 py-1 text-xs tracking-widest text-white/90 font-[var(--font-label)]">
                        {activeIndex + 1} / {items.length}
                    </span>
                )}
            </MediaLightbox>
        </>
    );
}
