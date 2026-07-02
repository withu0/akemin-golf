import { createInertiaApp } from '@inertiajs/react';
import { createRoot } from 'react-dom/client';
import { StrictMode, type ReactNode } from 'react';
import SiteLayout from './Layouts/SiteLayout';

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob('./Pages/**/*.tsx', { eager: true });
        const page = pages[`./Pages/${name}.tsx`] as any;
        page.default.layout =
            page.default.layout ?? ((p: ReactNode) => <SiteLayout>{p}</SiteLayout>);
        return page;
    },
    setup({ el, App, props }) {
        createRoot(el).render(
            <StrictMode>
                <App {...props} />
            </StrictMode>,
        );
    },
    progress: { color: '#A8D9D6', showSpinner: false },
});
