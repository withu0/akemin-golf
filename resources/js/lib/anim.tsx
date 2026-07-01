import { useEffect, useRef, type ReactNode } from 'react';
import { motion, type Variants } from 'framer-motion';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

/* ----------------------------------------------------------------------------
   Framer Motion — reveal on scroll
   -------------------------------------------------------------------------- */
const EASE = [0.2, 0.7, 0.2, 1] as const;

export function Reveal({
    children,
    className,
    delay = 0,
    y = 28,
    as = 'div',
}: {
    children: ReactNode;
    className?: string;
    delay?: number;
    y?: number;
    as?: keyof typeof motion;
}) {
    const Tag = motion[as] as typeof motion.div;
    return (
        <Tag
            className={className}
            initial={{ opacity: 0, y }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true, margin: '0px 0px -8% 0px' }}
            transition={{ duration: 0.9, ease: EASE, delay }}
        >
            {children}
        </Tag>
    );
}

/** Stagger container + item, for grids / lists. */
export const staggerParent: Variants = {
    hidden: {},
    show: { transition: { staggerChildren: 0.09, delayChildren: 0.05 } },
};

export const staggerItem: Variants = {
    hidden: { opacity: 0, y: 30 },
    show: { opacity: 1, y: 0, transition: { duration: 0.9, ease: EASE } },
};

export function StaggerGroup({
    children,
    className,
}: {
    children: ReactNode;
    className?: string;
}) {
    return (
        <motion.div
            className={className}
            variants={staggerParent}
            initial="hidden"
            whileInView="show"
            viewport={{ once: true, margin: '0px 0px -10% 0px' }}
        >
            {children}
        </motion.div>
    );
}

export function StaggerItem({
    children,
    className,
}: {
    children: ReactNode;
    className?: string;
}) {
    return (
        <motion.div className={className} variants={staggerItem}>
            {children}
        </motion.div>
    );
}

/* ----------------------------------------------------------------------------
   GSAP — parallax
   -------------------------------------------------------------------------- */
/** Drift an element vertically as it scrolls through the viewport. */
export function useParallax<T extends HTMLElement>(amount = 60) {
    const ref = useRef<T>(null);
    useEffect(() => {
        const el = ref.current;
        if (!el || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
        const ctx = gsap.context(() => {
            gsap.fromTo(
                el,
                { yPercent: -amount / 10 },
                {
                    yPercent: amount / 10,
                    ease: 'none',
                    scrollTrigger: {
                        trigger: el,
                        start: 'top bottom',
                        end: 'bottom top',
                        scrub: true,
                    },
                },
            );
        }, el);
        return () => ctx.revert();
    }, [amount]);
    return ref;
}

/** Refresh ScrollTrigger after Inertia navigations so positions stay correct. */
export function useScrollTriggerRefresh(dep: unknown) {
    useEffect(() => {
        ScrollTrigger.refresh();
    }, [dep]);
}
