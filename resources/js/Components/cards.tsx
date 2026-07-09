import { useCallback, useEffect, useRef, useState, type ReactNode } from 'react';
import { Link } from '@inertiajs/react';
import type { ActivityCard, FriendCard, PostCard } from '../types';
import { useShared, useT } from '../lib/shared';
import { ExpandIcon, LightboxImage, LightboxVideo, MediaLightbox } from './CoverImageLightbox';

type FriendFlagProps = Pick<FriendCard, 'country' | 'flag' | 'flag_url'>;

export function FriendFlagBadge({
    country,
    flag_url,
    flag,
    className = 'absolute top-4 left-4 z-10',
    size = 'h-9 w-9',
}: FriendFlagProps & { className?: string; size?: string }) {
    if (flag_url) {
        return (
            <img
                src={flag_url}
                alt={country ?? ''}
                className={`${className} ${size} rounded-full object-cover ring-2 ring-white/80 shadow-md`}
            />
        );
    }

    if (flag) {
        return (
            <span
                className={`${className} flex ${size} items-center justify-center rounded-full bg-[var(--color-paper)]/90 text-xl shadow-md ring-2 ring-white/80`}
            >
                {flag}
            </span>
        );
    }

    return null;
}

export function CardMedia({
    photo,
    video,
    alt,
    aspectClass = 'aspect-[3/4]',
    className = '',
    fallback,
    overlay,
    frameClassName = 'img-frame',
}: {
    photo: string | null;
    video: string | null;
    alt: string;
    aspectClass?: string;
    className?: string;
    fallback?: ReactNode;
    overlay?: ReactNode;
    frameClassName?: string;
}) {
    const t = useT();
    const videoRef = useRef<HTMLVideoElement>(null);
    const lightboxVideoRef = useRef<HTMLVideoElement>(null);
    const frameRef = useRef<HTMLDivElement>(null);
    const [playing, setPlaying] = useState(false);
    const [lightbox, setLightbox] = useState<'photo' | 'video' | null>(null);
    const hasVideo = Boolean(video);
    const hasPhoto = Boolean(photo);

    const play = useCallback(() => {
        const el = videoRef.current;
        if (!el || !hasVideo || lightbox) return;
        el.play().catch(() => {});
        setPlaying(true);
    }, [hasVideo, lightbox]);

    const pause = useCallback(() => {
        const el = videoRef.current;
        if (!el || lightbox) return;
        el.pause();
        el.currentTime = 0;
        setPlaying(false);
    }, [lightbox]);

    const closeLightbox = useCallback(() => {
        lightboxVideoRef.current?.pause();
        setLightbox(null);
        const el = videoRef.current;
        if (el) {
            el.pause();
            el.currentTime = 0;
            setPlaying(false);
        }
    }, []);

    const openLightbox = useCallback(
        (e: React.MouseEvent) => {
            e.preventDefault();
            e.stopPropagation();

            if (hasVideo && playing) {
                videoRef.current?.pause();
                setLightbox('video');
                return;
            }

            if (hasPhoto) {
                setLightbox('photo');
                return;
            }

            if (hasVideo) {
                setLightbox('video');
            }
        },
        [hasPhoto, hasVideo, playing],
    );

    useEffect(() => {
        const el = videoRef.current;
        if (!el || !hasVideo) return;

        const showFirstFrame = () => {
            el.currentTime = 0;
            el.pause();
        };

        el.addEventListener('loadeddata', showFirstFrame);
        if (el.readyState >= HTMLMediaElement.HAVE_CURRENT_DATA) {
            showFirstFrame();
        }

        return () => el.removeEventListener('loadeddata', showFirstFrame);
    }, [video, hasVideo]);

    useEffect(() => {
        const frame = frameRef.current;
        if (!frame || !hasVideo) return;

        const hoverCapable = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
        if (hoverCapable) return;

        const observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting) {
                    play();
                } else {
                    pause();
                }
            },
            { threshold: 0.55 },
        );

        observer.observe(frame);
        return () => observer.disconnect();
    }, [hasVideo, play, pause]);

    useEffect(() => {
        if (lightbox !== 'video') return;
        lightboxVideoRef.current?.play().catch(() => {});
    }, [lightbox]);

    return (
        <div
            ref={frameRef}
            className={`${frameClassName} ${aspectClass} group ${className}`}
            onMouseEnter={play}
            onMouseLeave={pause}
        >
            {photo ? (
                <img
                    src={photo}
                    alt={alt}
                    className={`absolute inset-0 h-full w-full object-cover transition-opacity duration-300 ${
                        hasVideo && playing ? 'opacity-0' : ''
                    }`}
                />
            ) : !hasVideo ? (
                fallback ?? null
            ) : null}

            {hasVideo && (
                <>
                    <video
                        ref={videoRef}
                        src={video!}
                        className={`absolute inset-0 h-full w-full object-cover transition-opacity duration-300 ${
                            !photo || playing ? 'opacity-100' : 'opacity-0'
                        }`}
                        muted
                        loop
                        playsInline
                        preload={photo ? 'metadata' : 'auto'}
                        poster={photo ?? undefined}
                    />
                    <div
                        className={`pointer-events-none absolute inset-0 z-[2] flex items-center justify-center transition-opacity duration-300 ${
                            playing ? 'opacity-0' : 'opacity-100'
                        }`}
                        aria-hidden={playing}
                    >
                        <div className="absolute inset-0 bg-black/25" />
                        <span className="relative flex h-16 w-16 items-center justify-center rounded-full bg-[var(--color-paper)]/95 text-[var(--color-sumi)] shadow-lg ring-2 ring-white/40 transition-transform duration-300 group-hover:scale-110">
                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" className="ml-1">
                                <path d="M6 4.5l12 6.5-12 6.5V4.5z" fill="currentColor" />
                            </svg>
                        </span>
                    </div>
                </>
            )}

            {(hasPhoto || hasVideo) && (
                <button
                    type="button"
                    onClick={openLightbox}
                    className={`absolute bottom-3 right-3 z-10 flex h-9 w-9 items-center justify-center rounded-full bg-black/50 text-white transition-opacity hover:bg-black/70 ${
                        hasVideo && playing ? 'opacity-100' : 'opacity-0 group-hover:opacity-100'
                    }`}
                    aria-label={t('cta.view_image')}
                >
                    <ExpandIcon />
                </button>
            )}

            <MediaLightbox open={lightbox !== null} onClose={closeLightbox}>
                {lightbox === 'photo' && photo && <LightboxImage src={photo} alt={alt} />}
                {lightbox === 'video' && video && <LightboxVideo ref={lightboxVideoRef} src={video} />}
            </MediaLightbox>

            {overlay}
        </div>
    );
}

export function FriendCardMedia({
    friend,
    className = '',
}: {
    friend: Pick<FriendCard, 'name' | 'photo' | 'video' | 'country' | 'flag' | 'flag_url'>;
    className?: string;
}) {
    return (
        <CardMedia
            photo={friend.photo}
            video={friend.video}
            alt={friend.name}
            aspectClass="aspect-[3/4]"
            className={className}
            fallback={<div className="h-full w-full grid place-items-center text-5xl">{friend.flag ?? '⛳'}</div>}
            overlay={<FriendFlagBadge country={friend.country} flag_url={friend.flag_url} flag={friend.flag} />}
        />
    );
}

export function ActivityCardMedia({
    activity,
    aspectClass = 'aspect-[4/3]',
    className = '',
    frameClassName = 'img-frame',
}: {
    activity: Pick<ActivityCard, 'title' | 'cover' | 'video'>;
    aspectClass?: string;
    className?: string;
    frameClassName?: string;
}) {
    const { site } = useShared();

    return (
        <CardMedia
            photo={activity.cover}
            video={activity.video}
            alt={activity.title}
            aspectClass={aspectClass}
            className={className}
            frameClassName={frameClassName}
            fallback={
                <div className="h-full w-full grid place-items-center text-[var(--color-mist)] display text-2xl">
                    {site.brand_ja}
                </div>
            }
        />
    );
}

export function ActivityCardView({ activity }: { activity: ActivityCard }) {
    return (
        <Link href={activity.url} className="card group block h-full">
            <ActivityCardMedia activity={activity} />
            <div className="p-6">
                <div className="flex items-center gap-3 text-[var(--color-mist)] text-xs tracking-widest uppercase font-[var(--font-label)] mb-3">
                    {activity.date && <span>{activity.date}</span>}
                    {activity.location && <span className="text-[var(--color-gold)]">— {activity.location}</span>}
                </div>
                <h3 className="display text-xl leading-snug group-hover:text-[var(--color-gold)] transition-colors">
                    {activity.title}
                </h3>
            </div>
        </Link>
    );
}

export function FriendCardView({ friend }: { friend: FriendCard }) {
    return (
        <div className="card group block h-full">
            <FriendCardMedia friend={friend} />
            <div className="p-5">
                <h3 className="display text-lg leading-tight">{friend.name}</h3>
                {friend.country && (
                    <p className="eyebrow before:hidden !tracking-[0.2em] mt-1.5">{friend.country}</p>
                )}
                {friend.message && (
                    <p className="mt-3 text-sm text-[var(--color-sumi-soft)] leading-relaxed">{friend.message}</p>
                )}
                {friend.instagram && (
                    <a
                        href={`https://instagram.com/${friend.instagram.replace(/^@/, '')}`}
                        target="_blank"
                        rel="noopener"
                        className="mt-3 inline-block text-xs tracking-widest uppercase text-[var(--color-gold)] hover:underline font-[var(--font-label)]"
                    >
                        @{friend.instagram.replace(/^@/, '')} ↗
                    </a>
                )}
            </div>
        </div>
    );
}

export function PostCardView({ post }: { post: PostCard }) {
    const t = useT();
    return (
        <Link href={post.url} className="group block">
            <div className="img-frame aspect-[16/10] mb-5">
                {post.cover ? (
                    <img src={post.cover} alt={post.title} className="h-full w-full object-cover" />
                ) : (
                    <div className="h-full w-full grid place-items-center text-[var(--color-mist)] display text-2xl">
                        {t('pages.life.essay')}
                    </div>
                )}
            </div>
            <div className="flex items-center gap-3 text-[var(--color-mist)] text-xs tracking-widest uppercase font-[var(--font-label)] mb-2">
                {post.date && <span>{post.date}</span>}
                {post.category && <span className="text-[var(--color-gold)]">— {post.category}</span>}
            </div>
            <h3 className="display text-2xl leading-snug group-hover:text-[var(--color-gold)] transition-colors">
                {post.title}
            </h3>
            {post.excerpt && (
                <p className="mt-3 text-[var(--color-sumi-soft)] leading-relaxed line-clamp-2">{post.excerpt}</p>
            )}
        </Link>
    );
}
