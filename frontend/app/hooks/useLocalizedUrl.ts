import { useTranslation } from 'react-i18next';
import { defaultLang, languages } from 'config/config';

export function useLocalizedUrl() {
    const { i18n } = useTranslation();

    return (path: string, languageCode?: string) => {
        const lang = languageCode || i18n.language;

        if (!path.startsWith('/')) path = `/${path}`;

        const segments = path.replace(/^\/+/, '').split('/');

        if (segments.length > 0 && languages.map(l => l.code).includes(segments[0])) {
            segments.shift();
        }

        const newPath = segments.join('/');

        return lang === defaultLang ? `/${newPath}` : `/${lang}/${newPath}`;
    };
}