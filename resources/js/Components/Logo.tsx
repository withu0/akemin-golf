type LogoTone = 'default' | 'light' | 'gold';
type LogoVariant = 'header' | 'menu' | 'footer' | 'center';

const TONE_CLASS: Record<LogoTone, string> = {
    default: 'brand-wordmark--default',
    light: 'brand-wordmark--light',
    gold: 'brand-wordmark--gold',
};

function splitBrandJa(brandJa: string): { name: string; suffix: string } {
    const suffix = 'ゴルフ';
    if (brandJa.endsWith(suffix)) {
        return { name: brandJa.slice(0, -suffix.length), suffix };
    }
    return { name: brandJa, suffix: '' };
}

/** Text-only brand lockup — no icon. */
export function Logo({
    brandJa,
    brandEn = 'Akemin Golf',
    tone = 'default',
    variant = 'header',
    showEn = true,
    className = '',
}: {
    brandJa: string;
    brandEn?: string;
    tone?: LogoTone;
    variant?: LogoVariant;
    showEn?: boolean;
    className?: string;
}) {
    const { name, suffix } = splitBrandJa(brandJa);

    return (
        <span
            className={`brand-wordmark brand-wordmark--${variant} ${TONE_CLASS[tone]} ${className}`}
        >
            <span className="brand-wordmark-ja" aria-label={brandJa}>
                <span className="brand-wordmark-ja-name">{name}</span>
                {suffix && <span className="brand-wordmark-ja-suffix">{suffix}</span>}
            </span>
            {showEn && (
                <span className="brand-wordmark-en">{brandEn.replace(' ', '\u00a0')}</span>
            )}
        </span>
    );
}
