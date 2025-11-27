import { useLocation } from 'react-router';
import { useTranslation } from 'react-i18next';
import { useLocalizedUrl } from '~/hooks/useLocalizedUrl';
import { languages } from 'config/config';

import HeaderDropdown from '../header-dropdown/header-dropdown';

export default function LanguageSwitcher() {
    const { t, i18n } = useTranslation();

    const currentLocale = i18n.language;
    const currentLang = languages.find(l => l.code === currentLocale);
    const otherLanguages = languages.filter(l => l.code !== currentLocale);

    if (!currentLang) return null;

    const location = useLocation();
    const localizedUrl = useLocalizedUrl();

    return (
        <HeaderDropdown
            title={t('languageSwitcher.title', 'Choose language')}
            trigger={
                <img
                    src={currentLang.flag}
                    alt={currentLang.label}
                    className="h-6 w-6 rounded-full object-cover"
                />
            }
            triggerText={t('languageSwitcher.language', 'Language')}
            triggerClassName="h-6 w-6 rounded-full border border-gray-700 dark:border-none"
            items={otherLanguages.map(lang => ({
                href: localizedUrl(location.pathname, lang.code),
                title: lang.title,
                content: (
                    <>
                        <img
                            src={lang.flag}
                            alt={lang.label}
                            className="h-5 w-5 rounded-full object-cover"
                        />
                        {lang.label}
                    </>
                ),
            }))}
        />
    );
}