export function setCookie(name: string, value: string, days: number = 365) {
    const expiration = new Date();
    expiration.setTime(expiration.getTime() + days * 24 * 60 * 60 * 1000);
    document.cookie = `${name}=${value};expires=${expiration.toUTCString()};path=/`;
}

export function getCookie(name: string): string | null {
    const match = document.cookie.match(new RegExp(`(^| )${name}=([^;]+)`));
    return match && match.length >= 3 ? match[2] : null;
}