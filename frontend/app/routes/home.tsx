import type { Route } from './+types/home';
import i18next from '~/i18n';

import Header from '../components/header/header';
import AnagramFinder from '~/components/anagram-finder/anagram-finder';

export function meta({}: Route.MetaArgs) {

    /**
     * Meta should be a lot more feature-rich
     * 
     * Canonical, alternate URL-s,
     * OpenGraph, Twitter Cards, JSON-LD
     * should be added to this
     */

    return [
        { title: i18next.t('home.meta.title', 'WordWitch') },
        { name: 'description', content: i18next.t('home.meta.description', 'Your magical anagram finder') },
    ];
}

export default function Home() {
    return (
        <>
            <Header />
            <AnagramFinder />
        </>
    );
}