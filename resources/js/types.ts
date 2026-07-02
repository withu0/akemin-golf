export interface LocaleMeta {
    label: string;
    flag: string;
    html: string;
}

export interface SiteMeta {
    brand_ja: string;
    brand_en: string;
    owner_ja: string;
    owner_en: string;
    tagline_en: string;
    instagram: string;
    harisienne: string;
}

export interface SharedProps {
    locale: string;
    locales: Record<string, LocaleMeta>;
    site: SiteMeta;
    lang: Record<string, any>;
    flash: { joined?: boolean };
    [key: string]: any;
}

export interface SectionContent {
    eyebrow: string | null;
    title: string;
    lead: string;
    body: string;
    image: string | null;
}

export interface ActivityCard {
    id: number;
    title: string;
    body: string;
    location: string | null;
    date: string | null;
    cover: string | null;
    url: string;
}

export interface FriendCard {
    id: number;
    name: string;
    country: string | null;
    flag: string | null;
    instagram: string | null;
    photo: string | null;
    video: string | null;
    message: string;
}

export interface PostCard {
    id: number;
    slug: string;
    title: string;
    excerpt: string;
    body: string;
    category: string | null;
    date: string | null;
    cover: string | null;
    url: string;
}
