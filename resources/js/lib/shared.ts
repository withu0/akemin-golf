import { usePage } from '@inertiajs/react';
import type { SharedProps } from '../types';

export function useShared(): SharedProps {
    return usePage<SharedProps>().props;
}

/** Translate a dotted key against the shared lang bundle, e.g. t('nav.home'). */
export function useT() {
    const { lang } = useShared();
    return (path: string): string => {
        const value = path
            .split('.')
            .reduce<any>((o, k) => (o == null ? undefined : o[k]), lang);
        return typeof value === 'string' ? value : path;
    };
}

/** Build a locale-prefixed URL, e.g. useUrl()('/about') => '/ja/about'. */
export function useUrl() {
    const { locale } = useShared();
    return (path = ''): string => `/${locale}${path}`;
}

/** Rewrite the current path to a different locale (first path segment). */
export function useSwitchLocale() {
    const { locales } = useShared();
    const { url } = usePage();
    return (code: string): string => {
        const [pathOnly, query = ''] = url.split('?');
        const segments = pathOnly.replace(/^\//, '').split('/');
        if (segments[0] && segments[0] in locales) {
            segments[0] = code;
        } else {
            segments.unshift(code);
        }
        return '/' + segments.join('/') + (query ? '?' + query : '');
    };
}
