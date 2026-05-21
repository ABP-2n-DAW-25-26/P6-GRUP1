<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Sostenibilitat — ASG" />

    <main class="min-h-screen bg-background text-primary">
        <header class="border-b border-gray-200 bg-white/60 backdrop-blur dark:bg-gray-900/60">
            <div class="mx-auto flex max-w-5xl items-center justify-between px-4 py-4">
                <Link href="/" class="text-lg font-semibold text-hp-primary">
                    ← Hipatia
                </Link>
                <h1 class="text-base font-semibold sm:text-lg">
                    Ambiental, Social i Governança (ASG)
                </h1>
            </div>
        </header>

        <article class="mx-auto max-w-4xl space-y-12 px-4 py-12 leading-relaxed">
            <section>
                <h2 class="text-2xl font-bold text-hp-primary">Ambiental</h2>
                <p class="mt-2 text-primary/70">
                    Gestió de recursos i reducció de la petjada de carboni:
                </p>
                <ul class="mt-4 list-disc space-y-2 pl-6 text-sm">
                    <li>
                        <strong>Codi optimitzat:</strong> Vue 3 Composition API amb components
                        reutilitzables per evitar duplicació.
                    </li>
                    <li>
                        <strong>CSS modular:</strong> Tailwind CSS amb purge automàtic per
                        reduir el tamany del bundle final.
                    </li>
                    <li>
                        <strong>Imatges optimitzades:</strong> Format WebP i AVIF per reduir
                        el consum de banda.
                    </li>
                    <li>
                        <strong>Vite bundling:</strong> JavaScript i CSS minificat amb code
                        splitting automàtic.
                    </li>
                    <li>
                        <strong>Lazy loading:</strong> Càrrega diferida de components per
                        millorar el temps inicial.
                    </li>
                </ul>
            </section>

            <section>
                <h2 class="text-2xl font-bold text-hp-primary">Social</h2>
                <p class="mt-2 text-primary/70">
                    Accessibilitat, inclusió i experiència d'usuari:
                </p>
                <ul class="mt-4 list-disc space-y-2 pl-6 text-sm">
                    <li>
                        <strong>Disseny responsive:</strong> Tailwind CSS per garantir accés
                        des de qualsevol dispositiu.
                    </li>
                    <li>
                        <strong>Autenticació segura:</strong> Laravel Fortify amb passwords
                        xifrats amb bcrypt per protegir dades dels usuaris.
                    </li>
                    <li>
                        <strong>Rols diferenciats:</strong> Panells separats per usuaris i
                        administradors.
                    </li>
                    <li>
                        <strong>Middleware:</strong> Control d'accés per evitar que usuaris
                        normals accedeixin al panel d'admin.
                    </li>
                    <li>
                        <strong>Polítiques clares:</strong> Condicions d'ús i política de
                        privacitat transparents amb sistema de cookies consentides.
                    </li>
                    <li>
                        <strong>Accessibilitat WCAG 2.1:</strong> Navegació per teclat,
                        contrast adequat i etiquetes ARIA per a lectors de pantalla.
                    </li>
                    <li>
                        <strong>Comunitat sostenible:</strong> Sistema d'intercanvi per
                        allargar la vida útil dels cromos digitals.
                    </li>
                </ul>
            </section>

            <section>
                <h2 class="text-2xl font-bold text-hp-primary">Governança</h2>
                <p class="mt-2 text-primary/70">
                    Transparència, bones pràctiques i estructura del projecte:
                </p>
                <ul class="mt-4 list-disc space-y-2 pl-6 text-sm">
                    <li>
                        <strong>Arquitectura MVC:</strong> Laravel amb separació clara entre
                        Models, Vistes (Inertia/Vue) i Controladors.
                    </li>
                    <li>
                        <strong>Control de versions:</strong> Git amb branques per cada
                        funcionalitat (develop, feature/*, fix/*).
                    </li>
                    <li>
                        <strong>Consultes preparades:</strong> Eloquent ORM per prevenció
                        d'injeccions SQL a la base de dades.
                    </li>
                    <li>
                        <strong>Docker:</strong> Entorn consistent i documentat per a
                        desenvolupament i desplegament.
                    </li>
                    <li>
                        <strong>Testing:</strong> Tests unitaris amb Pest PHP i tests E2E amb
                        Playwright per garantir qualitat del codi.
                    </li>
                    <li>
                        <strong>Documentació:</strong> README.md detallat amb instruccions de
                        configuració i ús.
                    </li>
                </ul>
            </section>

            <section>
                <h2 class="text-2xl font-bold text-hp-primary">
                    Propostes i millores digitals
                </h2>
                <p class="mt-2 text-primary/70">
                    Per fer la nostra comunitat digital més sostenible i eficient, proposem:
                </p>
                <ul class="mt-4 list-disc space-y-2 pl-6 text-sm">
                    <li>
                        <strong>Allargar la vida útil del contingut digital:</strong>
                        optimitzar imatges, vídeos i recursos per evitar regenerar-los
                        constantment.
                    </li>
                    <li>
                        <strong>Optimització de la web:</strong> reduir el pes de les
                        pàgines, minimitzar scripts i càrregues innecessàries per disminuir
                        el consum energètic.
                    </li>
                    <li>
                        <strong>Disseny ecoeficient:</strong> càrrega selectiva i components
                        reutilitzables per reduir el consum de recursos.
                    </li>
                    <li>
                        <strong>Gamificació sostenible:</strong> premiar activitats que
                        impliquin menys consum de recursos digitals i reutilització de
                        continguts.
                    </li>
                    <li>
                        <strong>Educació digital:</strong> mostrar consells als usuaris per
                        utilitzar la pàgina de manera més sostenible.
                    </li>
                    <li>
                        <strong>Reducció de carboni digital:</strong> eines per mesurar i
                        reduir l'impacte energètic de la pàgina.
                    </li>
                    <li>
                        <strong>Actualitzacions ecoeficients:</strong> revisar regularment el
                        codi i les funcionalitats per mantenir un consum mínim de recursos.
                    </li>
                </ul>
            </section>

            <section>
                <h2 class="text-2xl font-bold text-hp-primary">
                    Noves funcionalitats sostenibles proposades
                </h2>

                <div class="mt-4 space-y-6">
                    <div class="rounded-xl border border-gray-200 bg-white p-5 dark:bg-gray-900">
                        <h3 class="font-semibold">1. Marketplace d'intercanvi de cromos</h3>
                        <p class="mt-2 text-sm text-primary/70">
                            Crear un sistema d'intercanvi de cromos digitals entre usuaris per
                            allargar la vida útil del contingut, evitar duplicats innecessaris i
                            fomentar l'economia circular dins la comunitat.
                        </p>
                    </div>

                    <div class="rounded-xl border border-gray-200 bg-white p-5 dark:bg-gray-900">
                        <h3 class="font-semibold">2. Mode estalvi d'energia</h3>
                        <p class="mt-2 text-sm text-primary/70">
                            Implementar un mode de visualització simplificat que desactivi
                            animacions, redueixi la qualitat de les imatges i minimitzi les
                            crides al servidor per reduir el consum energètic.
                        </p>
                    </div>

                    <div class="rounded-xl border border-gray-200 bg-white p-5 dark:bg-gray-900">
                        <h3 class="font-semibold">3. Indicador d'impacte ambiental</h3>
                        <p class="mt-2 text-sm text-primary/70">
                            Mostrar a cada usuari un comptador de CO₂ estalviat gràcies a
                            imatges WebP, caché optimitzada i càrrega diferida, amb badges
                            verds per als usuaris més sostenibles.
                        </p>
                    </div>
                </div>
            </section>
        </article>

        <footer class="border-t border-gray-200 bg-background py-6 text-center text-xs text-primary/50">
            © {{ new Date().getFullYear() }} Hipatia · Compromís ASG
        </footer>
    </main>
</template>
