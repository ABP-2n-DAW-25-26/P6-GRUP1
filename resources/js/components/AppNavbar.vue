<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { translatePage } from '@/composables/useTranslate';
import { login, schedule } from '@/routes';

const page = usePage();
const isLoggedIn = computed(() => !!page.props.auth?.user);

const loading = ref(false);
const selectedLang = ref(localStorage.getItem('app_lang') ?? 'ca');

async function onLangChange(e: Event) {
    const lang = (e.target as HTMLSelectElement).value;
    selectedLang.value = lang;
    loading.value = true;
    await translatePage(lang);
    loading.value = false;
}
</script>

<template>
    <div class="fixed top-0 right-0 left-0 z-50 px-4 py-3">
        <nav
            class="relative mx-auto flex max-w-[95vw] items-center justify-between rounded-2xl border border-hp-border bg-white px-8 py-3 shadow-sm transition-colors"
        >
            <Link href="/" class="flex items-center gap-3 no-underline">
                <img
                    src="/cendraquest-256.png"
                    alt="CendraQuest"
                    class="h-9 w-9 rounded-full"
                />
                <div class="flex flex-col leading-tight">
                    <span
                        class="text-sm font-black tracking-widest text-hp-text uppercase"
                        >CendraQuest</span
                    >
                    <span
                        class="text-xs font-semibold tracking-widest text-hp-primary uppercase"
                        >Institut Cendrassos</span
                    >
                </div>
            </Link>

            <div class="flex items-center gap-3">
                <label for="language">
                    <select
                        :disabled="loading"
                        :value="selectedLang"
                        class="cursor-pointer rounded-lg border border-hp-border bg-white px-3 py-2 text-sm text-hp-text disabled:opacity-50"
                        @change="onLangChange"
                    >
                        <option value="ca">CA</option>
                        <option value="es">ES</option>
                        <option value="en">EN</option>
                        <option value="fr">FR</option>
                        <option value="de">DE</option>
                    </select>
                </label>
                <Link
                    v-if="isLoggedIn"
                    :href="schedule()"
                    class="rounded-lg bg-hp-primary px-5 py-2 text-sm font-bold text-white transition-colors duration-200 hover:bg-hp-primary-dark"
                >
                    Agenda
                </Link>
                <Link
                    v-else
                    :href="login()"
                    class="rounded-lg bg-hp-primary px-5 py-2 text-sm font-bold text-white transition-colors duration-200 hover:bg-hp-primary-dark"
                >
                    Iniciar sessió
                </Link>
            </div>
        </nav>
    </div>
</template>
