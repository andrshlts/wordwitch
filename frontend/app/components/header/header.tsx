import { useTranslation } from 'react-i18next';
import { Settings } from 'lucide-react';
import { useLocalizedUrl } from '~/hooks/useLocalizedUrl';
import { socialLinks } from 'config/config';

import LanguageSwitcher from '../language-switcher/language-switcher';
import ThemeSwitcher from '../theme-switcher/theme-switcher';

import { LinkedIn } from '~/components/symbols/symbols';
import logoDark from './logo-dark.webp';
import logoLight from './logo-light.webp';

export default function Header() {

    const { t } = useTranslation();
    const localizedUrl = useLocalizedUrl();

    return (
        <header>
            <div className="grid grid-cols-[1fr_auto_1fr] gap-8 items-center mx-auto px-16 py-16 max-w-6xl">
                <a
                    href={socialLinks.linkedin}
                    title="Andres Holts - LinkedIn"
                    target="_blank"
                    rel="noreferrer"
                    className="h-6 w-6 hover:opacity-80 transition-opacity duration-200"
                >
                    <LinkedIn className="text-violet-500" />
                </a>
                <a
                    href={localizedUrl('/')}
                    title={t('app_name', 'WordWitch')}
                    className="flex justify-center w-full max-w-xl hover:opacity-80 transition-opacity duration-200"
                >
                    <img
                        src={logoLight}
                        alt={t('app_name', 'WordWitch')}
                        className="block w-full dark:hidden"
                    />
                    <img
                        src={logoDark}
                        alt={t('app_name', 'WordWitch')}
                        className="hidden w-full dark:block"
                    />
                </a>
                <div className="flex justify-end items-center gap-6">
                    <LanguageSwitcher />
                    <ThemeSwitcher />
                    <a
                        href={localizedUrl('/refresh')}
                        title={t('refresh_wordbase.meta.title', 'Refresh Wordbase - WordWitch')}
                        className="hover:opacity-80 transition-opacity duration-200"
                    >
                        <Settings
                            className="h-6 w-6 text-gray-700 dark:text-gray-200"
                        />
                    </a>
                </div>
            </div>
        </header>
    );
}