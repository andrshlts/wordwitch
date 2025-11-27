import { useState, useRef, useEffect, useCallback } from 'react';
import { useTranslation } from 'react-i18next';

import type { FetchResponse } from '~/services/anagram-service';
import { fetchAnagrams } from '~/services/anagram-service';

export function useAnagramFinder() {

    const { t } = useTranslation();

    const [loading, setLoading] = useState<boolean>(false);
    const [error, setError] = useState<string | null>(null);
    const [results, setResults] = useState<string[]>([]);

    const lastSubmitRef = useRef<number>(0);
    const abortControllerRef = useRef<AbortController | null>(null);
    const timeoutRef = useRef<NodeJS.Timeout | null>(null);

    useEffect(() => {
        return () => {
            abortControllerRef.current?.abort();
            if (timeoutRef.current) {
                clearTimeout(timeoutRef.current);
            }
        };
    }, []);

    const getGenericError = useCallback(() => {
        return t(
            'anagramFinder.errors.generic',
            'An error occurred while fetching anagrams. Please try again later.'
        );
    }, [t]);

    const showError = useCallback((message: string) => {
        setError(message);

        if (timeoutRef.current) clearTimeout(timeoutRef.current);

        timeoutRef.current = setTimeout(() => {
            setError(null);
        }, 5000);
    }, []);

    const findAnagrams = useCallback(async (query: string) => {
        if (!query.trim()) return;

        const now = Date.now();
        if (now - lastSubmitRef.current < 1000) return;
        lastSubmitRef.current = now;

        setLoading(true);
        setError(null);
        setResults([]);

        abortControllerRef.current?.abort();
        const controller = new AbortController();
        abortControllerRef.current = controller;

        try {
            const data: FetchResponse = await fetchAnagrams(query, controller.signal);

            if (data.success) {
                const anagrams = data.data.anagrams || [];

                if (anagrams.length <= 0) {
                    showError(t('anagramFinder.errors.empty_result', 'No anagrams found.'));
                    setResults([]);
                    return;
                }

                setResults(anagrams);
            } else {
                // This block should theoretically never be reached
                showError(getGenericError());
            }
        } catch (err) {
            if (err instanceof Error && err.name !== 'AbortError') {
                // This part is messy, I had planned to rework this into a properly typed system
                // but due to time constraints I left it as is for now

                // @ts-ignore - err may have a `code` property from fetchAnagrams
                const code = (err as any).code;
                const field = (err as any).field;

                if (code && field === 'word') {
                    showError(t(`anagramFinder.errors.validation.${code}`, err.message));
                } else {
                    console.error(err.message);
                    showError(getGenericError());
                }
            }
        } finally {
            setLoading(false);
        }
    }, [showError, t, getGenericError]);

    return { loading, error, results, findAnagrams };
}