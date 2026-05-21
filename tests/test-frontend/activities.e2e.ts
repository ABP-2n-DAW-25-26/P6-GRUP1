import { test, expect,type Page } from '@playwright/test';


// Helper per fer login abans de cada test
async function loginAsTeacher(page: Page) {
    await page.goto('/login');
    await page.getByLabel('Email').fill('teacher@test.com');
    await page.getByLabel('Contrasenya').fill('password');
    await page.getByRole('button', { name: 'Entrar' }).click();
    await page.waitForURL(/schedule|agenda/);
}

test.describe('Gestió d\'activitats', () => {
    test.beforeEach(async ({ page }) => {
        await loginAsTeacher(page);
    });

    test('mostra el llistat d\'activitats de l\'intercanvi', async ({ page }) => {
        await page.goto('/exchanges/1/activities');

        await expect(page.getByRole('heading', { level: 3 })).toBeVisible();
    });

    test('botó eliminar mostra modal de confirmació', async ({ page }) => {
        await page.goto('/exchanges/1/activities');

        // Clic al primer botó d'eliminar
        await page.getByTitle('Eliminar').first().click();

        // Comprova que SweetAlert2 apareix
        await expect(page.locator('.swal2-popup')).toBeVisible();
        await expect(page.locator('.swal2-title')).toContainText('Eliminar');
        await expect(page.getByRole('button', { name: 'Eliminar' })).toBeVisible();
        await expect(page.getByRole('button', { name: 'Cancel·lar' })).toBeVisible();
    });

    test('cancel·lar al modal no elimina l\'activitat', async ({ page }) => {
        await page.goto('/exchanges/1/activities');

        const activitiesBefore = await page.getByTitle('Eliminar').count();

        await page.getByTitle('Eliminar').first().click();
        await page.locator('.swal2-popup').waitFor();
        await page.getByRole('button', { name: 'Cancel·lar' }).click();

        // El modal desapareix
        await expect(page.locator('.swal2-popup')).not.toBeVisible();

        // El nombre d'activitats no ha canviat
        const activitiesAfter = await page.getByTitle('Eliminar').count();
        expect(activitiesAfter).toBe(activitiesBefore);
    });

    test('confirmar eliminar esborra l\'activitat', async ({ page }) => {
        await page.goto('/exchanges/1/activities');

        const activitiesBefore = await page.getByTitle('Eliminar').count();

        await page.getByTitle('Eliminar').first().click();
        await page.locator('.swal2-popup').waitFor();
        await page.getByRole('button', { name: 'Eliminar' }).click();

        // Toast d'èxit apareix
        await expect(page.locator('.swal2-popup')).toBeVisible();

        // Espera que la pàgina s'actualitzi
        await page.waitForTimeout(1500);

        const activitiesAfter = await page.getByTitle('Eliminar').count();
        expect(activitiesAfter).toBe(activitiesBefore - 1);
    });

    test('professor veu botons d\'editar i eliminar', async ({ page }) => {
        await page.goto('/exchanges/1/activities');

        await expect(page.getByTitle('Editar').first()).toBeVisible();
        await expect(page.getByTitle('Eliminar').first()).toBeVisible();
    });
});