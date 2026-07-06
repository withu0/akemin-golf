import { useCallback, useEffect, useState } from 'react';
import { AnimatePresence, motion } from 'framer-motion';
import { useT } from '../lib/shared';

function ExpandIcon() {
    return (
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" className="h-4 w-4">
            <path d="M8 3H5a2 2 0 0 0-2 2v3M21 8V5a2 2 0 0 0-2-2h-3M3 16v3a2 2 0 0 0 2 2h3M16 21h3a2 2 0 0 0 2-2v-3" />
        </svg>
    );
}

function CloseIcon() {
    return (
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" className="h-5 w-5">
            <path d="M18 6 6 18M6 6l12 12" />
        </svg>
    );
}

export function CoverImageLightbox({
    src,
    alt,
    frameClassName = 'img-frame aspect-[16/9] paper-edge',
}: {
    src: string;
    alt: string;
    frameClassName?: string;
}) {
    const t = useT();
    const [open, setOpen] = useState(false);

    const close = useCallback(() => setOpen(false), []);

    useEffect(() => {
        if (!open) return;

        const onKeyDown = (e: KeyboardEvent) => {
            if (e.key === 'Escape') close();
        };

        document.body.style.overflow = 'hidden';
        document.addEventListener('keydown', onKeyDown);

        return () => {
            document.body.style.overflow = '';
            document.removeEventListener('keydown', onKeyDown);
        };
    }, [open, close]);

    return (
        <>
            <div className={`relative ${frameClassName}`}>
                <img src={src} alt={alt} className="h-full w-full object-cover" />
                <button
                    type="button"
                    onClick={() => setOpen(true)}
                    className="absolute bottom-3 right-3 z-10 flex h-9 w-9 items-center justify-center rounded-full bg-black/50 text-white transition-colors hover:bg-black/70"
                    aria-label={t('cta.view_image')}
                >
                    <ExpandIcon />
                </button>
            </div>

            <AnimatePresence>
                {open && (
                    <motion.div
                        className="fixed inset-0 z-[70] flex items-center justify-center bg-black/85 p-4"
                        initial={{ opacity: 0 }}
                        animate={{ opacity: 1 }}
                        exit={{ opacity: 0 }}
                        transition={{ duration: 0.3 }}
                        role="dialog"
                        aria-modal="true"
                        aria-label={t('cta.view_image')}
                        onClick={close}
                    >
                        <button
                            type="button"
                            onClick={close}
                            className="absolute top-4 right-4 z-10 flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-white transition-colors hover:bg-white/20"
                            aria-label={t('meta.close')}
                        >
                            <CloseIcon />
                        </button>

                        <motion.img
                            src={src}
                            alt={alt}
                            className="max-h-[90vh] max-w-[min(90vw,76rem)] object-contain"
                            initial={{ opacity: 0, scale: 0.97 }}
                            animate={{ opacity: 1, scale: 1 }}
                            exit={{ opacity: 0, scale: 0.97 }}
                            transition={{ duration: 0.3 }}
                            onClick={(e) => e.stopPropagation()}
                        />
                    </motion.div>
                )}
            </AnimatePresence>
        </>
    );
}
