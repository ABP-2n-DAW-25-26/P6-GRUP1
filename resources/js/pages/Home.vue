<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { login, privacy } from '@/routes';
import { ArrowUpRight } from 'lucide-vue-next';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Autoplay } from 'swiper/modules';
import 'swiper/css';
import { ref } from 'vue';

defineOptions({ layout: PublicLayout });

// Regex simple para validar que el título no tenga símbolos raros
const safeTitleRegex = /^[A-Za-z0-9\s]+$/;

// Log de prueba (no afecta a la UI)
console.log('Title check:', safeTitleRegex.test('Cendraquest'));
console.log('App loaded: Cendraquest');
import { initCookieConsent } from '@/cookieconsent';


onMounted(() => {
    initCookieConsent();
});
</script>

<template>
    <Head title="Cendraquest" />
    <main
        class="mx-auto flex max-w-7xl flex-col items-center gap-24 px-4"
    >
        <div>
            <img
                src="/assets/cloud-corner-tr.webp"
                alt="bg image"
                class="absolute top-0 right-0 w-1/3 [mask-image:radial-gradient(ellipse_at_top_right,black_0%,black_45%,transparent_75%)] [-webkit-mask-image:radial-gradient(ellipse_at_top_right,black_0%,black_45%,transparent_75%)] dark:hidden"
            />
        </div>
        <div>
            <img
                src="/assets/cloud-corner-tr.webp"
                alt="bg image"
                class="absolute top-0 left-0 w-1/2 [mask-image:radial-gradient(center,black_0%,black_45%,transparent_75%)] object-contain [-webkit-mask-image:radial-gradient(ellipse_at_center,black_0%,black_45%,transparent_75%)] dark:hidden"
            />
        </div>
        <section class="z-10 flex flex-col items-center gap-3">
            <h1
                class="text-hipatia-text text-center font-inter text-6xl leading-22 font-medium tracking-tight text-primary capitalize"
            >
                Control total del teu Erasmus
                <img
                    src="/assets/plane.webp"
                    alt="Ala d'avió"
                    class="mb-4 inline-flex h-14 w-24 rounded-full border border-2 border-stone-300 object-cover shadow-md/30"
                />
                <br />
                en una
                <img
                    src="/assets/river.webp"
                    alt="Muntanya i riu"
                    class="mb-4 inline-flex h-14 w-24 rounded-full border border-2 border-stone-300 object-cover shadow-md/30"
                />
                plataforma
            </h1>
            <p
                class="text-hipatia-text mt-4 max-w-3xl text-center font-inter text-lg tracking-tighter text-primary/50"
            >
                Dissenyada per a centres educatius que volen una gestió Erasmus
                més simple, moderna i organitzada. Tot el que necessites per
                coordinar el teu intercanvi en una sola plataforma.
            </p>
            <Link
                :href="login()"
                class="mt-6 rounded-lg bg-hp-primary px-5 py-2 text-sm font-semibold text-white transition-colors duration-200 hover:bg-hp-primary-dark"
            >
                Inicia sessió
            </Link>
            <div
                class="[mask-image:linear-gradient(to_bottom,black_80%,transparent_100%)] [-webkit-mask-image:linear-gradient(to_bottom,black_70%,transparent_96%)]"
            >
                <img
                    src="/assets/schedule.webp"
                    alt="Imatge preview de la pàgina de l'horari"
                    class="mt-8 h-auto w-full max-w-5xl rounded-lg"
                />
            </div>
            <div>
                <p
                    class="text-hipatia-text mt-4 flex max-w-3xl flex-row items-center justify-center text-center font-inter text-sm tracking-wide text-primary/50"
                >
                    Fet per estudiants del

                    <a
                        target="_blank"
                        href="https://www.cendrassos.net/"
                        class="group ml-2 flex items-center rounded-full font-bold text-hp-primary-darker underline underline-offset-4 transition-all duration-200 hover:text-primary"
                    >
                        INS Cendrassos
                        <ArrowUpRight
                            class="text-hp-primary-darker transition-colors transition-transform duration-200 group-hover:scale-125 group-hover:text-primary"
                        />
                    </a>
                </p>
            </div>
        </section>

        <section class="relative flex flex-col items-center gap-3 py-24">
            <div
                class="absolute inset-0 z-10 flex justify-center overflow-visible"
            >
                <img
                    src="/assets/clouds.webp"
                    alt="bg image"
                    class="absolute top-10 left-1/2 h-full w-[95dvw] max-w-none -translate-x-1/2 [mask-image:linear-gradient(to_right,transparent_0%,black_15%,black_85%,transparent_100%),linear-gradient(to_bottom,transparent_0%,black_15%,black_85%,transparent_100%)] [mask-composite:intersect] object-cover opacity-60 select-none [-webkit-mask-composite:source-in] [-webkit-mask-image:linear-gradient(to_right,transparent_0%,black_15%,black_85%,transparent_100%),linear-gradient(to_bottom,transparent_0%,black_15%,black_85%,transparent_100%)] dark:hidden"
                />
            </div>
            <div class="relative z-20 flex flex-col items-center gap-3">
                <h2
                    class="text-hipatia-text text-center font-inter text-5xl leading-22 font-medium tracking-tight text-primary capitalize"
                >
                    Planifica els viatges en segons
                </h2>
                <p
                    class="text-hipatia-text mt-4 max-w-3xl text-center font-inter text-lg tracking-tighter text-gray-500"
                >
                    Amb la nostra plataforma, pots planificar els teus viatges
                    Erasmus en només uns segons. No et preocupis per els
                    detalls, nosaltres ens encarreguem de tot.
                </p>
                <div
                    class="mt-8 grid grid-cols-1 gap-8 md:grid-cols-3 md:gap-12"
                >
                    <article
                        class="mt-18 flex h-110 w-80 flex-col rounded-xl border bg-background p-3 md:-rotate-7"
                    >
                        <img
                            src="/assets/step1.webp"
                            alt="imagen de una feature"
                            class="h-full w-full rounded-md object-cover"
                        />
                        <div class="mx-4">
                            <h3
                                class="text-hipatia-text mt-4 font-inter text-xl font-medium text-primary"
                            >
                                Crea un intercanvi
                            </h3>
                            <p
                                class="text-hipatia-text mt-2 max-w-md font-inter text-sm tracking-wide text-primary/50"
                            >
                                Defineix un nou intercanvi Erasmus on
                                gestionaràs tot el programa del centre.
                            </p>
                        </div>
                    </article>
                    <div class="flex flex-col items-center gap-12">
                        <article
                            class="flex h-110 w-80 flex-col rounded-xl border bg-background p-3"
                        >
                            <img
                                src="/assets/step2.webp"
                                alt="imagen de una feature"
                                class="h-full w-full rounded-md object-cover"
                            />
                            <div class="mx-4">
                                <h3
                                    class="text-hipatia-text mt-4 font-inter text-xl font-medium text-primary"
                                >
                                    Crea activitats
                                </h3>
                                <p
                                    class="text-hipatia-text mt-2 max-w-md font-inter text-sm tracking-wide text-primary/50"
                                >
                                    Afegeix una activitat (dels 4 tipus
                                    disponibles) per organitzar l’experiència
                                    dels estudiants.
                                </p>
                            </div>
                        </article>
                        <Link
                            :href="login()"
                            class="rounded-lg bg-primary px-10 py-2 text-sm font-semibold text-white transition-colors duration-200 hover:bg-hp-primary-dark"
                        >
                            Prova ja!
                        </Link>
                    </div>
                    <article
                        class="mt-18 flex h-110 w-80 flex-col rounded-xl border bg-background p-3 md:rotate-7"
                    >
                        <img
                            src="/assets/step3.webp"
                            alt="imagen de una feature"
                            class="h-full w-full rounded-md object-cover"
                        />
                        <div class="mx-4">
                            <h3
                                class="text-hipatia-text mt-4 font-inter text-xl font-medium text-primary"
                            >
                                Importa estudiants
                            </h3>
                            <p
                                class="text-hipatia-text mt-2 max-w-md font-inter text-sm tracking-wide text-primary/50"
                            >
                                Carrega els alumnes des d’un fitxer CSV i envia
                                automàticament les credencials d’accés per
                                correu electrònic.
                            </p>
                        </div>
                    </article>
                </div>
            </div>
        </section>
        <section class="z-10 flex w-full flex-col items-center gap-3">
            <h2
                class="text-hipatia-text text-center font-inter text-5xl leading-18 font-medium tracking-tight text-primary capitalize"
            >
                Programa activitats
                <img
                    src="/assets/museum.webp"
                    alt="Ala d'avió"
                    class="mb-3 inline-flex h-12 w-24 rounded-full border border-2 border-stone-300 object-cover shadow-md/30"
                />
                <br />
                pels teus
                <img
                    src="/assets/bosque.webp"
                    alt="Muntanya i riu"
                    class="mb-3 inline-flex h-12 w-24 rounded-full border border-2 border-stone-300 object-cover shadow-md/30"
                />
                estudiants Erasmus
            </h2>
            <p
                class="text-hipatia-text mt-4 max-w-3xl text-center font-inter text-lg tracking-tighter text-primary/50"
            >
                Pots programar activitats i excursions per als teus estudiants
                Erasmus per comunicar els plans de viatge i les activitats que
                poden fer durant el seu intercanvi. Fomenta la participació i
                l'exploració amb la nostra plataforma fàcil d'utilitzar.
            </p>
            <div
                class="mt-8 grid w-full grid-cols-1 gap-2 *:rounded-lg *:border *:border-gray-200 *:p-1 md:grid-cols-3 md:gap-4"
            >
                <div>
                    <div class="px-3 py-3">
                        <h3
                            class="text-hipatia-text font-inter text-xl font-medium text-primary"
                        >
                            Anuncis
                        </h3>
                        <p
                            class="text-hipatia-text mt-2 max-w-md font-inter text-sm tracking-tight text-primary/50"
                        >
                            Mostra informació que els professors volen comunicar
                            als seus estudiants.
                        </p>
                    </div>

                    <div class="rounded-lg bg-secondary">
                        <img
                            alt="img de una feature"
                            src="/assets/post.webp"
                            class="mx-auto h-full w-min rounded-xl object-contain"
                        />
                    </div>
                </div>

                <div>
                    <div class="px-4 py-3">
                        <h3
                            class="text-hipatia-text font-inter text-xl font-medium text-primary"
                        >
                            Punts d'interés
                        </h3>
                        <p
                            class="text-hipatia-text mt-2 max-w-md font-inter text-sm tracking-tight text-primary/50"
                        >
                            Ensenya l'ubicació d'un lloc escollit pels
                            professors. Útil per marcar un lloc de trobada o un
                            monument de la zona!
                        </p>
                    </div>
                    <div class="rounded-lg bg-secondary">
                        <img
                            alt="img de una feature"
                            src="/assets/point.webp"
                            class="mx-auto h-full w-min rounded-xl object-contain"
                        />
                    </div>
                </div>

                <div>
                    <div class="px-4 py-3">
                        <h3
                            class="text-hipatia-text font-inter text-xl font-medium text-primary"
                        >
                            Visita guiada
                        </h3>
                        <p
                            class="text-hipatia-text mt-2 max-w-md font-inter text-sm tracking-tight text-primary/50"
                        >
                            Es marca un recorregut, una serie de punts per fer
                            un volt a la zona.
                        </p>
                    </div>
                    <div class="rounded-lg bg-secondary">
                        <img
                            alt="img de una feature"
                            src="/assets/visit.webp"
                            class="mx-auto h-full w-min rounded-xl object-contain"
                        />
                    </div>
                </div>

                <div class="md:col-span-3 *:md:mx-auto *:md:text-center">
                    <div class="px-4 py-3 *:md:mx-auto *:md:text-center">
                        <h3
                            class="text-hipatia-text font-inter text-xl font-medium text-primary"
                        >
                            Gimcana
                        </h3>
                        <p
                            class="text-hipatia-text mt-2 max-w-md font-inter text-sm tracking-tight text-primary/50"
                        >
                            Proposa una ruta interactiva amb reptes, preguntes i
                            respostes en cada punt. Els estudiants han de
                            resoldre cada prova per avançar fins al final del
                            recorregut. Quí quedarà en primer lloc?
                        </p>
                    </div>
                    <div class="h-100 overflow-hidden rounded-lg bg-secondary">
                        <Swiper
                            :modules="[Autoplay]"
                            :autoplay="{
                                delay: 2000,
                                disableOnInteraction: false,
                            }"
                            :loop="true"
                            class="h-full w-full"
                        >
                            <SwiperSlide>
                                <img
                                    alt="img de una feature"
                                    src="/assets/gimcana1.webp"
                                    class="mx-auto h-full w-min rounded-xl object-contain"
                                />
                            </SwiperSlide>

                            <SwiperSlide>
                                <img
                                    alt="img de una feature"
                                    src="/assets/gimcana2.webp"
                                    class="mx-auto h-full w-min rounded-xl object-contain"
                                />
                            </SwiperSlide>

                            <SwiperSlide>
                                <img
                                    alt="img de una feature"
                                    src="/assets/gimcana3.webp"
                                    class="mx-auto h-full w-min rounded-xl object-contain"
                                />
                            </SwiperSlide>
                        </Swiper>
                    </div>
                </div>
            </div>
        </section>
        <section class="w-full border-t border-gray-200 bg-background">
            <div
                class="relative mx-auto -mb-10 grid max-w-7xl grid-cols-1 gap-12 px-4 pt-20 md:grid-cols-2"
            >
                <div class="flex flex-col gap-6">
                    <h2
                        class="text-hipatia-text text-3xl leading-tight font-medium text-primary"
                    >
                        Contacte amb
                        <img
                            src="/assets/centre3.webp"
                            alt="imagen de la entrada del INS Cendrassos"
                            class="mb-2 inline-flex h-12 w-22 rounded-full border border-stone-300 object-cover shadow-md/30"
                        />
                        el centre
                    </h2>

                    <p class="text-sm leading-relaxed text-primary/60">
                        Aquesta plataforma està destinada exclusivament a
                        centres educatius. Els comptes de professorat són
                        gestionats directament pel centre.
                    </p>

                    <div
                        class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm"
                    >
                        <p class="text-sm text-primary/70">
                            Centre responsable:
                            <span class="font-semibold text-primary">
                                INS Cendrassos
                            </span>
                        </p>
                    </div>
                </div>

                <div class="flex flex-col gap-6">
                    <h3 class="text-xl font-semibold text-primary">
                        Tens dubtes?
                    </h3>

                    <p class="text-sm text-primary/60">
                        Si necessites informació del projecte o suport, pots
                        contactar amb nosaltres directament.
                    </p>

                    <a
                        href="mailto:hipatiaweb@cendrassos.net"
                        class="w-fit rounded-lg bg-hp-primary px-6 py-2 text-sm font-semibold text-white transition-colors duration-200 hover:bg-hp-primary-dark"
                    >
                        Escriu-nos un email
                    </a>
                </div>
            </div>
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
