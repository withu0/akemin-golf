import { useCallback, useEffect, useRef, useState } from 'react';
import { Link } from '@inertiajs/react';
import type { ActivityCard, FriendCard, PostCard } from '../types';
import { useShared, useT } from '../lib/shared';

export function FriendCardMedia({
    friend,
    className = '',
}: {
    friend: Pick<FriendCard, 'name' | 'photo' | 'video' | 'flag'>;
    className?: string;
}) {
    const videoRef = useRef<HTMLVideoElement>(null);
    const frameRef = useRef<HTMLDivElement>(null);
    const [playing, setPlaying] = useState(false);
    const [fullscreen, setFullscreen] = useState(false);
    const hasVideo = Boolean(friend.video);

    const play = useCallback(() => {
        const video = videoRef.current;
        if (!video || !hasVideo || fullscreen) return;
        video.play().catch(() => {});
        setPlaying(true);
    }, [fullscreen, hasVideo]);

    const pause = useCallback(() => {
        const video = videoRef.current;
        if (!video || fullscreen) return;
        video.pause();
        video.currentTime = 0;
        setPlaying(false);
    }, [fullscreen]);

    useEffect(() => {
        const video = videoRef.current;
        if (!video || !hasVideo) return;

        const showFirstFrame = () => {
            video.currentTime = 0;
            video.pause();
        };

        video.addEventListener('loadeddata', showFirstFrame);
        if (video.readyState >= HTMLMediaElement.HAVE_CURRENT_DATA) {
            showFirstFrame();
        }

        return () => video.removeEventListener('loadeddata', showFirstFrame);
    }, [friend.video, hasVideo]);

    useEffect(() => {
        const onFullscreenChange = () => {
            const video = videoRef.current;
            const frame = frameRef.current;
            const isFullscreen =
                document.fullscreenElement === video ||
                document.fullscreenElement === frame;
            setFullscreen(isFullscreen);

            if (!video) return;

            video.controls = isFullscreen;
            video.muted = !isFullscreen;

            if (isFullscreen) {
                video.play().catch(() => {});
                setPlaying(true);
                return;
            }

            video.pause();
            video.currentTime = 0;
            setPlaying(false);
        };

        document.addEventListener('fullscreenchange', onFullscreenChange);
        return () => document.removeEventListener('fullscreenchange', onFullscreenChange);
    }, []);

    const enterFullscreen = useCallback((e: React.MouseEvent) => {
        e.preventDefault();
        e.stopPropagation();
        const target = videoRef.current ?? frameRef.current;
        target?.requestFullscreen?.();
    }, []);

    return (
        <div
            ref={frameRef}
            className={`img-frame aspect-[3/4] group ${className}`}
            onMouseEnter={play}
            onMouseLeave={pause}
        >
            {friend.photo ? (
                <img
                    src={friend.photo}
                    alt={friend.name}
                    className={`relative z-[1] h-full w-full object-cover transition-opacity duration-300 ${hasVideo && playing ? 'opacity-0' : ''}`}
                />
            ) : !hasVideo ? (
                <div className="h-full w-full grid place-items-center text-5xl">{friend.flag ?? '⛳'}</div>
            ) : null}

            {hasVideo && (
                <>
                    <video
                        ref={videoRef}
                        src={friend.video!}
                        className={`absolute inset-0 h-full w-full object-cover transition-opacity duration-300 ${
                            !friend.photo || playing ? 'opacity-100' : 'opacity-0'
                        }`}
                        muted
                        loop
                        playsInline
                        preload={friend.photo ? 'metadata' : 'auto'}
                        poster={friend.photo ?? undefined}
                    />
                    <button
                        type="button"
                        onClick={enterFullscreen}
                        className="absolute bottom-3 right-3 z-10 flex h-9 w-9 items-center justify-center rounded-full bg-black/50 text-white opacity-0 transition-opacity group-hover:opacity-100 hover:bg-black/70"
                        aria-label="Fullscreen"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" className="h-4 w-4">
                            <path d="M8 3H5a2 2 0 0 0-2 2v3M21 8V5a2 2 0 0 0-2-2h-3M3 16v3a2 2 0 0 0 2 2h3M16 21h3a2 2 0 0 0 2-2v-3" />
                        </svg>
                    </button>
                </>
            )}

            {friend.flag && (
                <span className="absolute top-4 left-4 z-10 text-2xl drop-shadow">{friend.flag}</span>
            )}
        </div>
    );
}

export function ActivityCardView({ activity }: { activity: ActivityCard }) {
    const { site } = useShared();
    return (
        <Link href={activity.url} className="card group block h-full">
            <div className="img-frame aspect-[4/3]">
                {activity.cover ? (
                    <img src={activity.cover} alt={activity.title} className="h-full w-full object-cover" />
                ) : (
                    <div className="h-full w-full grid place-items-center text-[var(--color-mist)] display text-2xl">
                        {site.brand_ja}
                    </div>
                )}
            </div>
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
