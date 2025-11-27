import { useState, useRef, useEffect, useCallback } from 'react';
import { useTranslation } from 'react-i18next';

import type { RefreshResponse } from '~/services/wordbase-service';
import { refreshWordbase } from '~/services/wordbase-service';

export function useWordbaseUpdater() {

    const { t } = useTranslation();

    const [loading, setLoading] = useState<boolean>(false);
    const [error, setError] = useState<string | null>(null);
    const [success, setSuccess] = useState<string | null>(null);

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
            'wordbaseUpdater.errors.generic',
            'An error occurred while updating the wordbase. Please try again later.'
        );
    }, [t]);

    const showFeedback = useCallback((message: string, isError = false) => {
        if (isError) setError(message);
        else setSuccess(message);

        if (timeoutRef.current) clearTimeout(timeoutRef.current);

        timeoutRef.current = setTimeout(() => {
            setError(null);
            setSuccess(null);
        }, 5000);
    }, []);

    const updateWordbase = useCallback(async () => {
        const now = Date.now();
        if (now - lastSubmitRef.current < 1000) return;
        lastSubmitRef.current = now;

        setLoading(true);
        setError(null);
        setSuccess(null);

        abortControllerRef.current?.abort();
        const controller = new AbortController();
        abortControllerRef.current = controller;

        try {
            const data: RefreshResponse = await refreshWordbase(controller.signal);

            if (data.success) {
                showFeedback(t('wordbaseUpdater.success', 'Wordbase updated successfully.'));
            } else {
                showFeedback(getGenericError(), true);
            }
        } catch (err) {
            if (err instanceof Error && err.name !== 'AbortError') {
                console.error(err.message);
                showFeedback(getGenericError(), true);
            }
        } finally {
            setLoading(false);
        }
    }, [showFeedback, t, getGenericError]);

    return { loading, error, success, updateWordbase };
}