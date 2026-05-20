import { defineConfig } from '@playwright/test';

export default defineConfig({
    testDir: './tests/test-frontend',
    testMatch: '**/*.e2e.ts',
    use: {
        baseURL: 'http://127.0.0.1:8107',
    },
    webServer: {
        command: 'APP_ENV=testing php artisan serve --host=127.0.0.1 --port=8107',
        url: 'http://127.0.0.1:8107',
        reuseExistingServer: true,
        timeout: 30000,
    },
});
