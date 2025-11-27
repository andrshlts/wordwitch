import { useState, useEffect, useCallback } from 'react';
import { setCookie } from '~/utility/cookie';

export type ThemeOption = 'light' | 'dark' | 'system';

export function useDarkMode() {
    const [theme, setTheme] = useState<ThemeOption>(() => {
        if (typeof document === 'undefined') {
            return 'system';
        }

        const initial = document.documentElement.dataset.theme as ThemeOption;
        return initial ?? 'system';
    });

    const applyTheme = useCallback((theme: ThemeOption) => {
        const root = document.documentElement;

        if (theme === 'system') {
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            root.classList.toggle('dark', prefersDark);
        } else {
            root.classList.toggle('dark', theme === 'dark');
        }

        root.dataset.theme = theme;
        setCookie('theme', theme);
    }, []);

    useEffect(() => {
        applyTheme(theme);
    }, [theme]);

    useEffect(() => {
        if (theme !== 'system') return;

        const media = window.matchMedia('(prefers-color-scheme: dark)');
        const listener = () => applyTheme('system');

        media.addEventListener('change', listener);

        return () => media.removeEventListener('change', listener);
    }, [theme]);

    return { theme, setTheme };
}