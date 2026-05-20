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
    <main
        class="mx-auto flex max-w-7xl flex-col items-center gap-24 px-4 pt-16"
    >
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
                class="absolute top-0 left-0 w-1/2 [mask-image:radial-gradient(center,black_0%,black_45%,transparent_75%)] object-contain [-webkit-mask-image:radial-gradient(ellipse_at_center,black_0%,black_45%,transparent_75%)]"
            />
        </div>
        <section class="z-10 flex flex-col items-center gap-3">
            <h1
                class="text-hipatia-text text-center font-inter text-6xl leading-22 font-medium tracking-tight text-primary capitalize"
            >
                Control total del teu Erasmus
                <img
                    src="/assets/plane.jpg"
                    alt="Ala d'avió"
                    class="mb-4 inline-flex h-14 w-24 rounded-full border border-2 border-stone-300 object-cover shadow-md/30"
                />
                <br />
                en una
                <img
                    src="/assets/river.jpg"
                    alt="Muntanya i riu"
                    class="mb-4 inline-flex h-14 w-24 rounded-full border border-2 border-stone-300 object-cover shadow-md/30"
                />
                plataforma
            </h1>
        </section>
        <footer class="w-full border-t border-gray-200 bg-background">
            <div
                class="mx-auto flex max-w-7xl flex-col gap-10 px-4 py-12 md:flex-row md:items-start md:justify-between"
            >
                <div class="max-w-sm">
                    <h3 class="text-lg font-semibold text-primary">
                        Erasmus Platform
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
                © {{ new Date().getFullYear() }} Erasmus Platform. Tots els
                drets reservats.
            </div>
        </footer>
    </main>
</template>
