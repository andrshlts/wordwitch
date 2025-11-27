import i18n from 'i18next';
import { initReactI18next } from 'react-i18next';
import LanguageDetector from 'i18next-browser-languagedetector';

import et from './locales/et.json';
import en from './locales/en.json';

i18n
    .use(LanguageDetector)
    .use(initReactI18next)
    .init({
        resources: {
            et: { translation: et },
            en: { translation: en },
        },
        fallbackLng: 'et',
        supportedLngs: ['et', 'en'],
        interpolation: {
            escapeValue: false,
        },
        detection: {
            order: ['path'],
        },
    });

export default i18n;