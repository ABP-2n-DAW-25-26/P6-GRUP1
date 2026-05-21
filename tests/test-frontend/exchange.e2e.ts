import { test, expect } from '@playwright/test';

// Home page is reachable
test('Home page is reachable', async ({ request }) => {
    const response = await request.get('/');

    expect(response.ok()).toBeTruthy();
});

// Login page is reachable
test('Login page is reachable', async ({ request }) => {
    const response = await request.get('/login');

    expect(response.ok()).toBeTruthy();
});

// Exchange page route responds (redirect or success)
test('Exchange route responds', async ({ request }) => {
    const response = await request.get('/exchange');

    expect(response.status()).toBeLessThan(500);
});

// Unknown route returns 404
test('Unknown route returns 404', async ({ request }) => {
    const response = await request.get('/route-that-does-not-exist');

    expect(response.status()).toBe(404);
});
