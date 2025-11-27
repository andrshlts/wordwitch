import { apiUrl } from 'config/config';

export interface RefreshResponse {
    success: boolean;
    message: string;
}

export async function refreshWordbase(signal?: AbortSignal): Promise<RefreshResponse> {
    const response = await fetch(
        `${apiUrl}/refreshWordbase`,
        { method: 'PUT', signal }
    );

    if (!response.ok) {
        const text = await response.text();
        throw new Error(text || 'Request failed');
    }

    const data: RefreshResponse = await response.json();
    return data;
}