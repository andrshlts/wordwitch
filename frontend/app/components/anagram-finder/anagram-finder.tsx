import type { FormEvent } from 'react';
import { useState } from 'react';
import { useTranslation } from 'react-i18next';
import { motion, AnimatePresence } from 'framer-motion';

import { useAnagramFinder } from '~/hooks/useAnagramFinder';
import LoadingButton from '../loading-button/loading-button';


export default function AnagramFinder() {

    const { t } = useTranslation();
    const { loading, error, results, findAnagrams } = useAnagramFinder();

    const [query, setQuery] = useState<string>('');

    const handleSearch = (e: FormEvent) => {
        e.preventDefault();
        findAnagrams(query);
    };

    return (
        <main className="flex flex-col items-center justify-center gap-16 py-16">
            <form onSubmit={handleSearch} className="flex flex-col items-center gap-4">
                <label
                    htmlFor="word_input"
                    className="text-black dark:text-white"
                >
                    {t('anagramFinder.label', 'Word')}
                </label>
                <input
                    id="word_input"
                    className="
                        border border-solid border-black dark:border-white rounded-md
                        text-black dark:text-white bg-white dark:bg-black
                        px-4 py-2 text-lg
                    "
                    type="text"
                    value={query ?? ''}
                    onChange={(e) => setQuery(e.target.value)}
                    placeholder={t('anagramFinder.placeholder', 'Enter a word...')}
                />
                <LoadingButton isLoading={loading} className="shadow-lg/30">
                    {t('anagramFinder.submit', 'Find anagrams')}
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

                {!loading && (
                    <ul className="flex flex-wrap justify-center gap-4 max-w-2xl">
                        {results.map((anagram, i) => (
                            <motion.li
                                key={i}
                                className="px-6 py-1 text-xl rounded-lg bg-violet-700 shadow-lg/30 text-white"
                                initial={{ opacity: 0, y: -10 }}
                                animate={{ opacity: 1, y: 0 }}
                                exit={{ opacity: 0, y: -10 }}
                                transition={{ duration: .1 }}
                            >
                                {anagram}
                            </motion.li>
                        ))}
                    </ul>
                )}
            </AnimatePresence>
        </main>
    );
}