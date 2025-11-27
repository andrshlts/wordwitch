import { useTranslation } from 'react-i18next';
import { Sun, Moon, Monitor } from 'lucide-react';
import { useDarkMode } from '~/hooks/useDarkMode';

import HeaderDropdown from '../header-dropdown/header-dropdown';


const themes = [
    { code: 'system', icon: Monitor },
    { code: 'light', icon: Sun },
    { code: 'dark', icon: Moon },
];

export default function ThemeSwitcher() {
    const { t } = useTranslation();
    const { theme, setTheme } = useDarkMode();

    const currentTheme = themes.find((t) => t.code === theme) ?? themes[0];
    const CurrentIcon = currentTheme.icon;

    return (
        <HeaderDropdown
            title={t('themeSwitcher.title', 'Choose theme')}
            trigger={
                <CurrentIcon
                    className="h-6 w-6 text-gray-700 dark:text-gray-200"
                />
            }
            triggerText={t('themeSwitcher.theme', 'Theme')}
            items={themes.map(item => {
                const Icon = item.icon;

                return {
                    title: t(`themeSwitcher.themes.${item.code}`, item.code),
                    onClick: () => setTheme(item.code as any),
                    content: (
                        <>
                            <Icon className="h-5 w-5" />
                            {t(`themeSwitcher.themes.${item.code}`, item.code)}
                        </>
                    ),
                };
            })}
        />
    );
}