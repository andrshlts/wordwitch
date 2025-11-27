import type { FormEvent } from 'react';
import { useTranslation } from 'react-i18next';
import { motion, AnimatePresence } from 'framer-motion';

import { useWordbaseUpdater } from '~/hooks/useWordbaseUpdater';
import LoadingButton from '../loading-button/loading-button';

export default function WordbaseUpdater() {

    const { t } = useTranslation();
    const { loading, error, success, updateWordbase } = useWordbaseUpdater();

    const handleSubmit = (e: FormEvent) => {
        e.preventDefault();
        updateWordbase();
    };

    return (
        <main className="flex flex-col items-center justify-center gap-16 py-16">

            <form onSubmit={handleSubmit} className="flex flex-col items-center gap-4">
                <LoadingButton isLoading={loading}>
                    {t('wordbaseUpdater.submit', 'Update Wordbase')}
                </LoadingButton>
            </form>

            <AnimatePresence>
                {error && (
                    <motion.p
                        key="error"
                        role="alert"
                        initial={{ opacity: 0, y: -10 }}
                        animate={{ opacity: 1, y: 0 }}
                        exit={{ opacity: 0, y: -10 }}
                        transition={{ duration: .1 }}
                        className="text-red-500 font-semibold text-lg"
                    >
                        {error}
                    </motion.p>
                )}

                {success && (
                    <motion.p
                        key="success"
                        role="alert"
                        initial={{ opacity: 0, y: -10 }}
                        animate={{ opacity: 1, y: 0 }}
                        exit={{ opacity: 0, y: -10 }}
                        transition={{ duration: .1 }}
                        className="text-green-800 font-semibold text-lg"
                    >
                        {success}
                    </motion.p>
                )}
            </AnimatePresence>

        </main>
    );
}