import { Link } from '@inertiajs/react';
import type { ActivityCard, FriendCard, PostCard } from '../types';
import { useShared, useT } from '../lib/shared';

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
            <div className="img-frame aspect-[3/4]">
                {friend.photo ? (
                    <img src={friend.photo} alt={friend.name} className="h-full w-full object-cover" />
                ) : (
                    <div className="h-full w-full grid place-items-center text-5xl">{friend.flag ?? '⛳'}</div>
                )}
                {friend.flag && (
                    <span className="absolute top-4 left-4 text-2xl drop-shadow">{friend.flag}</span>
                )}
            </div>
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
