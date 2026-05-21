import { test, expect } from '@playwright/test';

// Theme index requires authentication
test('Theme index requires authentication', async ({ request }) => {
    const response = await request.get('/theme');

    expect(response.status()).toBe(302);
    expect(response.headers()['location']).toContain('/login');
});

// Theme creation page requires authentication
test('Theme create requires authentication', async ({ request }) => {
    const response = await request.get('/theme/create');

    expect(response.status()).toBe(302);
    expect(response.headers()['location']).toContain('/login');
});

// Theme search requires authentication
test('Theme search requires authentication', async ({ request }) => {
    const response = await request.get('/theme/search?q=Ocean');

    expect(response.status()).toBe(302);
    expect(response.headers()['location']).toContain('/login');
});

// Theme detail requires authentication
test('Theme detail requires authentication', async ({ request }) => {
    const response = await request.get('/theme/1');

    expect(response.status()).toBe(302);
    expect(response.headers()['location']).toContain('/login');
});
