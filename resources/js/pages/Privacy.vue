<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { login, privacy } from '@/routes';
import { ArrowUpRight } from 'lucide-vue-next';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Autoplay } from 'swiper/modules';
import 'swiper/css';

defineOptions({ layout: PublicLayout });
</script>

<template>
    <Head title="Privacy" />
    <main class="mx-auto flex max-w-6xl flex-col gap-16 px-4 pt-16">
        <div>
            <img
                src="/assets/cloud-corner-tr.png"
                alt=""
                class="absolute top-0 right-0 w-1/3 [mask-image:radial-gradient(ellipse_at_top_right,black_0%,black_45%,transparent_75%)] [-webkit-mask-image:radial-gradient(ellipse_at_top_right,black_0%,black_45%,transparent_75%)]"
            />
        </div>
        <div>
            <img
                src="/assets/cloud-corner-tr.png"
                alt=""
                class="absolute top-0 left-0 w-1/2 [mask-image:radial-gradient(ellipse_at_center,black_0%,black_45%,transparent_75%)] object-contain [-webkit-mask-image:radial-gradient(ellipse_at_center,black_0%,black_45%,transparent_75%)]"
            />
        </div>
        <section class="z-20 flex flex-col gap-4">
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-primary/70">
                Politica de privacitat
            </p>
            <h1 class="text-hipatia-text font-inter text-5xl font-medium text-primary">
                Una politica clara, sense sorpreses
            </h1>
            <p class="max-w-2xl text-base leading-7 text-primary/70">
                Aquesta pagina descriu com recollim, utilitzem i protegim les
                teves dades quan fas servir Hipàtia. El nostre objectiu
                es ser transparents i donar-te el control.
            </p>
        </section>

        <section class="grid z-20 gap-10 md:grid-cols-[2fr,1fr]">
            <div class="space-y-10">
                <div class="space-y-3">
                    <h2 class="text-xl font-semibold text-primary">
                        1. Qui som
                    </h2>
                    <p class="text-sm leading-7 text-primary/70">
                        Hipàtia es una aplicacio educativa creada per
                        ajudar estudiants i coordinadors a gestionar estades
                        Erasmus de manera simple i segura.
                    </p>
                </div>

                <div class="space-y-3">
                    <h2 class="text-xl font-semibold text-primary">
                        2. Dades que recollim
                    </h2>
                    <p class="text-sm leading-7 text-primary/70">
                        Recollim dades necessaries per oferir el servei:
                        identificacio, contacte, informacio academica bàsica i
                        activitats que decideixes compartir.
                    </p>
                </div>

                <div class="space-y-3">
                    <h2 class="text-xl font-semibold text-primary">
                        3. Per a que les fem servir
                    </h2>
                    <p class="text-sm leading-7 text-primary/70">
                        Utilitzem les dades per crear el teu compte, gestionar
                        processos Erasmus, enviar comunicacions rellevants i
                        millorar el servei. No venem les teves dades.
                    </p>
                </div>

                <div class="space-y-3">
                    <h2 class="text-xl font-semibold text-primary">
                        4. Base legal
                    </h2>
                    <p class="text-sm leading-7 text-primary/70">
                        Tractem les dades per execucio d'un contracte, interès
                        legitím i, quan cal, pel teu consentiment.
                    </p>
                </div>

                <div class="space-y-3">
                    <h2 class="text-xl font-semibold text-primary">
                        5. Conservacio
                    </h2>
                    <p class="text-sm leading-7 text-primary/70">
                        Mantenim les dades mentre tens compte actiu o mentre
                        sigui necessari per complir obligacions legals.
                    </p>
                </div>

                <div class="space-y-3">
                    <h2 class="text-xl font-semibold text-primary">
                        6. Amb qui compartim dades
                    </h2>
                    <p class="text-sm leading-7 text-primary/70">
                        Nomes compartim dades amb proveidors tecnics que ens
                        ajuden a operar la plataforma, sempre sota acords de
                        confidencialitat.
                    </p>
                </div>

                <div class="space-y-3">
                    <h2 class="text-xl font-semibold text-primary">
                        7. Els teus drets
                    </h2>
                    <p class="text-sm leading-7 text-primary/70">
                        Pots accedir, rectificar o suprimir les teves dades, o
                        limitar-ne el tractament. Escriu-nos i t'ajudarem.
                    </p>
                </div>

                <div class="space-y-3">
                    <h2 class="text-xl font-semibold text-primary">
                        8. Contacte
                    </h2>
                    <p class="text-sm leading-7 text-primary/70">
                        Per consultes de privacitat: hipatiaweb@cendrassos.net
                    </p>
                </div>
            </div>

            <aside class="z-20 rounded-3xl border border-primary/10 bg-white/70 p-6 shadow-sm">
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-primary">
                        Resum rapid
                    </h3>
                    <ul class="space-y-3 text-sm text-primary/70">
                        <li>Recollim nomes el necessari per al servei.</li>
                        <li>No venem ni cedim dades personals.</li>
                        <li>Pots gestionar els teus drets en qualsevol moment.</li>
                        <li>Protegim la informació amb mesures tecnològiques.</li>
                    </ul>
                    <Link
                        :href="login()"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-primary transition hover:text-primary/80"
                    >
                        Accedeix al teu compte
                        <ArrowUpRight class="h-4 w-4" />
                    </Link>
                </div>
            </aside>
        </section>
        <footer class="z-20 w-full border-t border-gray-200 bg-background">
            <div
                class="mx-auto flex max-w-7xl flex-col gap-10 px-4 py-12 md:flex-row md:items-start md:justify-between"
            >
                <div class="max-w-sm">
                    <h3 class="text-lg font-semibold text-primary">
                        Hipàtia
                    </h3>
                    <p class="mt-2 text-sm text-primary/60">
                        Plataforma per a la gestió i organització d’experiències
                        Erasmus de manera simple i moderna.
                    </p>
                </div>

                <div class="flex flex-col gap-2">
                    <h4 class="text-sm font-semibold text-primary">
                        Equip de desenvolupadors
                    </h4>
                    <div
                        class="flex flex-col gap-1 *:text-blue-800 *:underline *:underline-offset-3"
                    >
                        <a
                            href="https://github.com/robert-gab-poe"
                            target="_blank"
                            class="text-sm transition hover:text-primary"
                        >
                            GitHub - Robert Poenaru
                        </a>

                        <a
                            href="https://github.com/SolaimanBaraka"
                            target="_blank"
                            class="text-sm transition hover:text-primary"
                        >
                            GitHub - Solaiman Baraka
                        </a>

                        <a
                            href="https://github.com/Bal-cpu8"
                            target="_blank"
                            class="text-sm transition hover:text-primary"
                        >
                            GitHub - Balvinder Singh
                        </a>

                        <a
                            href="https://github.com/jeffffff6"
                            target="_blank"
                            class="text-sm transition hover:text-primary"
                        >
                            GitHub - Youssef Bakouh
                        </a>
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <h4 class="text-sm font-semibold text-primary">Legal</h4>

                    <Link
                        :href="privacy()"
                        class="text-sm text-primary/60 transition hover:text-primary"
                    >
                        Política de privacitat
                    </Link>
                </div>
            </div>

            <div
                class="border-t border-gray-200 py-4 text-center text-xs text-primary/50"
            >
                © {{ new Date().getFullYear() }} Hipàtia. Tots els
                drets reservats.
            </div>
        </footer>
    </main>
</template>
