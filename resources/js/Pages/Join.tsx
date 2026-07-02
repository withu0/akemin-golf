import { Head, Link, useForm } from '@inertiajs/react';
import { AnimatePresence, motion } from 'framer-motion';
import { useShared, useT, useUrl, useBrand } from '../lib/shared';
import { Reveal } from '../lib/anim';
import { ArrowRight, PageHero } from '../Components/ui';

export default function Join({ image }: { image: string }) {
    const { site, flash } = useShared();
    const t = useT();
    const brand = useBrand();
    const url = useUrl();

    const form = useForm({ name: '', email: '', country: '', interest: '', message: '' });

    const submit = (e: React.FormEvent) => {
        e.preventDefault();
        form.post(url('/join'), { preserveScroll: true });
    };

    const interests: [string, string][] = [
        ['golf', t('join.i_golf')],
        ['beauty', t('join.i_beauty')],
        ['community', t('join.i_community')],
    ];

    return (
        <>
            <Head title={`${t('nav.join')} — ${brand.name}`} />

            <PageHero no="捌" eyebrow={t('nav.join')} seal="募集" title={t('join.hero_title')} lead={t('join.lead')} />

            <section className="wrap py-10 md:py-16">
                <div className="grid gap-12 lg:gap-16 lg:grid-cols-[0.85fr_1.15fr]">
                    <Reveal>
                        <div className="img-frame aspect-[4/5] max-w-sm paper-edge mb-8">
                            <img src={image} alt="" className="h-full w-full object-cover" />
                        </div>
                        <p className="prose-wa whitespace-pre-line">
                            {t('join.intro')}
                        </p>
                        <a href={site.instagram} target="_blank" rel="noopener" className="link-arrow mt-6">
                            {t('meta.instagram_handle')} <ArrowRight />
                        </a>
                    </Reveal>

                    <Reveal delay={0.1}>
                        <AnimatePresence mode="wait">
                            {flash.joined ? (
                                <motion.div
                                    key="thanks"
                                    initial={{ opacity: 0, y: 20 }}
                                    animate={{ opacity: 1, y: 0 }}
                                    className="bg-[var(--color-matsuba)] grain-dark text-[var(--color-paper)] p-10 md:p-12 text-center"
                                >
                                    <motion.span
                                        className="hanko mx-auto mb-6 bg-transparent !text-[var(--color-gold-soft)] !border-[var(--color-gold-soft)]"
                                        initial={{ scale: 0.6, rotate: -10 }}
                                        animate={{ scale: 1, rotate: -2 }}
                                        transition={{ delay: 0.15, duration: 0.5 }}
                                    >
                                        謝
                                    </motion.span>
                                    <h2 className="display text-2xl md:text-3xl">{t('join.thanks')}</h2>
                                    <p className="mt-4 text-white/75 leading-loose max-w-md mx-auto">{t('join.thanks_body')}</p>
                                    <Link href={url('')} className="link-arrow mt-8 !text-[var(--color-paper)] justify-center">
                                        {t('nav.home')} <ArrowRight />
                                    </Link>
                                </motion.div>
                            ) : (
                                <motion.form
                                    key="form"
                                    onSubmit={submit}
                                    exit={{ opacity: 0 }}
                                    className="bg-[var(--color-paper)] border border-[var(--color-line)] p-8 md:p-12"
                                >
                                    {Object.keys(form.errors).length > 0 && (
                                        <div className="mb-8 border border-[var(--color-shu)]/40 text-[var(--color-shu)] px-4 py-3 text-sm">
                                            {Object.values(form.errors)[0]}
                                        </div>
                                    )}

                                    <div className="grid gap-8 sm:grid-cols-2">
                                        <div className="sm:col-span-2">
                                            <label className="field-label" htmlFor="name">{t('join.name')}</label>
                                            <input id="name" value={form.data.name} onChange={(e) => form.setData('name', e.target.value)} required className="field mt-2" />
                                        </div>
                                        <div>
                                            <label className="field-label" htmlFor="email">{t('join.email')} <span className="lowercase">— {t('join.optional')}</span></label>
                                            <input id="email" type="email" value={form.data.email} onChange={(e) => form.setData('email', e.target.value)} className="field mt-2" />
                                        </div>
                                        <div>
                                            <label className="field-label" htmlFor="country">{t('join.country')} <span className="lowercase">— {t('join.optional')}</span></label>
                                            <input id="country" value={form.data.country} onChange={(e) => form.setData('country', e.target.value)} className="field mt-2" />
                                        </div>
                                    </div>

                                    <fieldset className="mt-8">
                                        <legend className="field-label mb-3">{t('join.interest')}</legend>
                                        <div className="flex flex-wrap gap-3">
                                            {interests.map(([val, label]) => (
                                                <button
                                                    type="button"
                                                    key={val}
                                                    onClick={() => form.setData('interest', val)}
                                                    className={`px-5 py-2.5 border rounded-full text-sm font-[var(--font-serif)] transition-colors ${
                                                        form.data.interest === val
                                                            ? 'bg-[var(--color-sumi)] text-[var(--color-paper)] border-[var(--color-sumi)]'
                                                            : 'border-[var(--color-line)] hover:border-[var(--color-sumi)]'
                                                    }`}
                                                >
                                                    {label}
                                                </button>
                                            ))}
                                        </div>
                                    </fieldset>

                                    <div className="mt-8">
                                        <label className="field-label" htmlFor="message">{t('join.message')} <span className="lowercase">— {t('join.optional')}</span></label>
                                        <textarea id="message" rows={4} value={form.data.message} onChange={(e) => form.setData('message', e.target.value)} className="field mt-2 resize-none" />
                                    </div>

                                    <button type="submit" disabled={form.processing} className="btn btn-gold mt-10 w-full justify-center disabled:opacity-60">
                                        {t('join.submit')} <ArrowRight />
                                    </button>
                                </motion.form>
                            )}
                        </AnimatePresence>
                    </Reveal>
                </div>
            </section>
        </>
    );
}
