import type { Route } from './+types/refresh-wordbase';
import i18next from '~/i18n';

import Header from '../components/header/header';
import WordbaseUpdater from '~/components/wordbase-updater/wordbase-updater';

export function meta({}: Route.MetaArgs) {

    /**
     * Meta should be a lot more feature-rich
     * 
     * Canonical, alternate URL-s,
     * OpenGraph, Twitter Cards, JSON-LD
     * should be added to this
     */

    return [
        { title: i18next.t('refresh_wordbase.meta.title', 'Refresh Wordbase - WordWitch') },
        { name: 'description', content: i18next.t('refresh_wordbase.meta.description', 'Refresh the wordbase to keep your anagrams magical') },
    ];
}

export default function RefreshWordbase() {
    return (
        <>
            <Header />
            <WordbaseUpdater />
        </>
    );
}