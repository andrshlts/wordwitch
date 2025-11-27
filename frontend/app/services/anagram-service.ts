import { anagramFinderConfig, apiUrl } from 'config/config';

export interface ValidationError {
    field: string;
    message: string;
    code: string;
}

export interface ErrorResponse {
    success: false;
    error: {
        type: string;
        status: number;
        message: string;
        timestamp: string;
        validation_errors?: ValidationError[];
    };
}

export type FetchResponse = {
    success: true;
    data: {
        word: string;
        anagrams: string[];
        meta: {
            total: number;
            per_page: number;
            current_page: number;
            last_page: number;
        };
    };
} | ErrorResponse;

export async function fetchAnagrams(query: string, signal?: AbortSignal): Promise<FetchResponse> {

    // We can implement pagination or "load more" functionality here
    // by adjusting the `page` and `per_page` parameters as needed.

    const response = await fetch(
        `${apiUrl}/getAnagrams?word=${encodeURIComponent(query.trim())}&page=1&per_page=${anagramFinderConfig.perPage}`,
        { signal }
    );

    const data = await response.json().catch(() => null);

    if (!response.ok) {
        if (data?.error?.validation_errors?.length) {

            // This part is messy, I had planned to rework this
            // but due to time constraints I left it as is for now

            const firstError = data.error.validation_errors[0];
            const err = new Error(firstError.message);
            (err as any).code = firstError.code;
            (err as any).field = firstError.field;

            throw err;
        }

        const text = await response.text();
        throw new Error(text || 'Request failed');
    }

    return data as FetchResponse;
}