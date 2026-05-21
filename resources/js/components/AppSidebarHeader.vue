<script setup lang="ts">
import { ref } from 'vue';
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import { SidebarTrigger } from '@/components/ui/sidebar';
import { translatePage } from '@/composables/useTranslate';
import type { BreadcrumbItem } from '@/types';

withDefaults(
    defineProps<{
        breadcrumbs?: BreadcrumbItem[];
    }>(),
    {
        breadcrumbs: () => [],
    },
);

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
    <header
        class="flex h-16 shrink-0 items-center justify-between gap-2 border-b border-sidebar-border/70 px-6 transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-12 md:px-4"
    >
        <div class="flex items-center gap-2">
            <SidebarTrigger class="-ml-1" />
            <template v-if="breadcrumbs && breadcrumbs.length > 0">
                <Breadcrumbs :breadcrumbs="breadcrumbs" />
            </template>
        </div>
        <label for="language">
            <select
                :disabled="loading"
                :value="selectedLang"
                class="cursor-pointer rounded-lg border border-hp-border bg-white px-3 py-1.5 text-sm text-hp-text disabled:opacity-50"
                @change="onLangChange"
            >
                <option value="ca">CA</option>
                <option value="es">ES</option>
                <option value="en">EN</option>
                <option value="fr">FR</option>
                <option value="de">DE</option>
            </select>
        </label>
    </header>
</template>
