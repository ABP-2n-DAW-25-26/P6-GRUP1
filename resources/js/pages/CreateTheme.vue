<script setup lang="ts">
import { Form, Link } from '@inertiajs/vue3';
import { reactive } from 'vue';
import { store, index } from '@/routes/theme';

const themeIndexUrl = index().url;

const palette = reactive<Record<string, string>>({
    name: '',
    primary: '#008680',
    primary_dark: '#004238',
    secondary: '#4B645F',
    text: '#2A3432',
    text_secondary: '#58615F',
    background: '#F6FAF8',
    background_card: '#FFFFFF',
});

const colors = [
    {
        key: 'primary',
        name: 'primary',
        title: 'Principal',
        preview: 'solid',
    },
    {
        key: 'primary_dark',
        name: 'primary_dark',
        title: 'Principal fosc',
        preview: 'solid',
    },
    {
        key: 'secondary',
        name: 'secondary',
        title: 'Secundari',
        preview: 'solid',
    },
    {
        key: 'text',
        name: 'text',
        title: 'Text',
        preview: 'type',
    },
    {
        key: 'text_secondary',
        name: 'text_secondary',
        title: 'Text secundari',
        preview: 'readability',
    },
    {
        key: 'background',
        name: 'background',
        title: 'Fons',
        preview: 'canvas',
    },
    {
        key: 'background_card',
        name: 'background_card',
        title: 'Fons de cartes',
        preview: 'card',
    },
];

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Themes',
                // href: themeIndexUrl,
            },
            {
                title: 'Create',
            },
        ],
    },
});
</script>

<template>
    <div class="min-h-screen px-6 py-10">
        <div class="mx-auto w-full max-w-5xl">
            <Form :action="store()" method="post" class="space-y-8">
                <div>
                    <h1 class="text-3xl font-semibold text-slate-800 sm:text-4xl">Crea un tema personalitzat</h1>
                    <label class="mt-6 block text-sm font-medium text-slate-500">Nom del tema</label>
                    <input type="text" name="name" v-model="palette.name" placeholder="Girona"
                        class="mt-2 w-full border-b border-slate-200 bg-transparent pb-2 text-lg text-slate-700 placeholder:text-slate-300 focus:border-hp-primary focus:outline-none"/>
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-700">Paleta de colors</h2>
                    </div>
                </div>

                <div class="grid grid-cols-12 gap-4">
                    <div v-for="(color, index) in colors" :key="color.key"
                        class="rounded-2xl border border-slate-200 bg-white/85 p-4 shadow-sm"
                        :class="index < 3 ? 'col-span-12 sm:col-span-4' : 'col-span-12 sm:col-span-6 lg:col-span-3'">
                        <div class="flex h-24 items-center justify-center rounded-xl border border-slate-200"
                            :style="{ backgroundColor: palette[color.key] }">
                            <span v-if="color.preview === 'type'" class="text-2xl font-semibold text-white">Aa</span>
                            <span v-else-if="color.preview === 'readability'" class="text-sm font-semibold text-white">Aa</span>
                            <div v-else-if="color.preview === 'canvas'" class="w-30">
                                <div class="h-2 w-30 rounded bg-slate-300/60"></div>
                                <div class="mt-2 h-2 w-25 rounded bg-slate-300/60"></div>
                            </div>
                            <div v-else-if="color.preview === 'card'" class="w-30 rounded-lg bg-white/80 p-3">
                                <div class="h-2 w-25 rounded bg-slate-200/80"></div>
                                <div class="mt-2 h-2 w-20 rounded bg-slate-200/80"></div>
                            </div>
                        </div>

                        <div class="mt-4 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-hp-text">{{ color.title }}</p>
                            </div>
                            <span class="text-xs font-mono text-hp-text-dim">{{ palette[color.key] }}</span>
                        </div>

                        <div class="mt-3 flex items-center gap-3">
                            <input type="color" v-model="palette[color.key]" aria-label="Pick color"
                                class="h-9 w-12 cursor-pointer" style="border: none;"/>
                            <input type="text" :name="color.name" v-model="palette[color.key]" placeholder="#000000"
                                class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 focus:border-hp-primary focus:outline-none"/>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col justify-end gap-3 sm:flex-row">
                    <Link :href="themeIndexUrl"
                        class="inline-flex items-center justify-center rounded-full border border-hp-primary bg-white px-6 py-2 text-sm font-semibold text-hp-primary transition hover:border-hp-primary/80 hover:bg-hp-primary/10">
                        Cancelar
                    </Link>
                    <button type="submit"
                        class="inline-flex items-center cursor-pointer justify-center rounded-full bg-hp-primary px-6 py-2 text-sm font-semibold text-white shadow-lg shadow-hp-primary/20 transition hover:bg-hp-primary/80">
                        Guardar tema
                    </button>
                </div>
            </Form>
        </div>
    </div>
</template>
<style>

</style>