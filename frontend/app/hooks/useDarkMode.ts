import { useState, useEffect, useCallback } from 'react';
import { getCookie, setCookie } from '~/utility/cookie';

export type ThemeOption = 'light' | 'dark' | 'system';

export function useDarkMode() {
    const [theme, setTheme] = useState<ThemeOption>('system');

    const applyTheme = useCallback((theme: ThemeOption) => {
        const root = document.documentElement;

        if (theme === 'system') {
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            root.classList.toggle('dark', prefersDark);
        } else {
            root.classList.toggle('dark', theme === 'dark');
        }

        setCookie('theme', theme);
    }, []);

    useEffect(() => {
        const cookieTheme = getCookie('theme') as ThemeOption;
        if (cookieTheme) setTheme(cookieTheme);
    }, []);

    useEffect(() => {
        applyTheme(theme);
    }, [theme, applyTheme]);

    useEffect(() => {
        if (theme !== 'system') return;

        const media = window.matchMedia('(prefers-color-scheme: dark)');
        const listener = () => applyTheme('system');

        media.addEventListener('change', listener);

        return () => media.removeEventListener('change', listener);
    }, [theme]);

    return { theme, setTheme };
}