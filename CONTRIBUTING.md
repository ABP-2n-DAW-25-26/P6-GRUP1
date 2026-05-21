# Com contribuir

## Estil de codi

- **PHP:** Laravel Pint → `composer run lint`
- **JS/Vue:** ESLint + Prettier → `npm run lint`
- Components Vue amb `<script setup lang="ts">` (Composition API).
- Estils amb Tailwind.

## Tests

```bash
composer run test       # backend (Pest)
npm run test:unit       # frontend (Vitest)
npm run test:e2e        # E2E (Playwright)
```

## Flux Git

- `main` → producció
- `develop` → integració
- `feature/<nom>` → noves funcionalitats
- `fix/<nom>` → correccions

Cap commit directe a `main` o `develop`. Pull Request sempre cap a `develop`.

## Commits

Format curt en imperatiu:

```
feat: afegeix sistema d'intercanvi
fix: corregeix login
docs: actualitza README
```
