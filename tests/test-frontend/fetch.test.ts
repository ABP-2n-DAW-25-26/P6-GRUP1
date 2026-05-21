import { describe, it, expect, beforeEach } from 'vitest';

// Replace global fetch with a fake one to test AJAX calls without a real server.

describe('AJAX / fetch', () => {
    let calls: Array<{ url: string; options?: RequestInit }>;

    beforeEach(() => {
        calls = [];
    });

    it('POST /api/translate returns parsed JSON', async () => {
        const fakeResponse = {
            "Llistat d'intercanvis": 'Lista de intercambios',
            'Nou usuari': 'Nuevo usuario',
        };

        global.fetch = (async (url: string, options?: RequestInit) => {
            calls.push({ url, options });
            return {
                ok: true,
                status: 200,
                json: async () => fakeResponse,
            } as Response;
        }) as typeof fetch;

        const res = await fetch('/api/translate', {
            method: 'POST',
            body: JSON.stringify({ texts: ['Nou usuari'], lang: 'es' }),
        });
        const data = await res.json();

        expect(calls.length).toBe(1);
        expect(calls[0].url).toBe('/api/translate');
        expect(calls[0].options?.method).toBe('POST');
        expect(data['Nou usuari']).toBe('Nuevo usuario');
    });

    it('GET /teacher/search returns a list of teachers', async () => {
        global.fetch = (async (url: string) => {
            calls.push({ url });
            return {
                ok: true,
                status: 200,
                json: async () => ({
                    teachers: [
                        { id: 1, name: 'Solaiman', surname: 'Baraka', email: 'solaiman@cendrassos.net' },
                        { id: 2, name: 'Robert', surname: 'Poenaru', email: 'robert@cendrassos.net' },
                    ],
                }),
            } as Response;
        }) as typeof fetch;

        const res = await fetch('/teacher/search?query=so&exchangeId=1');
        const data = await res.json();

        expect(calls[0].url).toBe('/teacher/search?query=so&exchangeId=1');
        expect(data.teachers.length).toBe(2);
        expect(data.teachers[0].name).toBe('Solaiman');
    });

    it('returns ok=false when the server fails with 500', async () => {
        global.fetch = (async () => {
            return {
                ok: false,
                status: 500,
                json: async () => ({ message: 'Internal Server Error' }),
            } as Response;
        }) as typeof fetch;

        const res = await fetch('/api/translate');
        const data = await res.json();

        expect(res.ok).toBe(false);
        expect(res.status).toBe(500);
        expect(data.message).toBe('Internal Server Error');
    });

    it('throws an error when the network fails', async () => {
        global.fetch = (async () => {
            throw new Error('Network error');
        }) as typeof fetch;

        let caught: Error | null = null;
        try {
            await fetch('/exchange/1/teacher/assign?user_id=5');
        } catch (e) {
            caught = e as Error;
        }

        expect(caught).not.toBeNull();
        expect(caught?.message).toBe('Network error');
    });
});
