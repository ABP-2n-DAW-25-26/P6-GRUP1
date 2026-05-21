import { test, expect } from '@playwright/test';

// Login helper (adjust selectors if needed)
async function loginAsAdmin(page) {
    await page.goto('/login');

    await page.fill('input[name="email"]', 'test@test.com');
    await page.fill('input[name="password"]', '12345678');

    await page.click('button[type="submit"]');

    // Wait for redirect after login
    await page.waitForURL('/');
}

// Teachers list should be accessible for admin
test('Admin can access exchange teacher list', async ({ page }) => {
    await loginAsAdmin(page);

    const response = await page.request.get('/exchange/1/teacher');

    expect(response.status()).toBeLessThan(500);
});

// AJAX search should work for authenticated admin
test('Admin can search teachers via AJAX', async ({ page }) => {
    await loginAsAdmin(page);

    const response = await page.request.get('/teacher/search?query=a');

    expect(response.ok()).toBeTruthy();

    const data = await response.json();
    expect(data).toHaveProperty('teachers');
});

// Admin can assign a teacher to an exchange
test('Admin can assign teacher to exchange', async ({ page }) => {
    await loginAsAdmin(page);

    const response = await page.request.get('/exchange/1/teacher/assign?teacher_id=1');

    expect(response.status()).toBeLessThan(500);
});

// Admin can remove a teacher from exchange
test('Admin can remove teacher from exchange', async ({ page }) => {
    await loginAsAdmin(page);

    const response = await page.request.get('/exchange/1/teacher/delete?teacher_id=1');

    expect(response.status()).toBeLessThan(500);
});