<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Trash, Plus } from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue';
import { destroy } from '@/routes/theme';

interface Theme {
    id: number;
    name: string;
    primary: string;
    primary_dark: string;
    secondary: string;
    text: string;
    text_secondary: string;
    background: string;
    background_card: string;
    default: number;
}

const props = defineProps<{ theme: Theme[] }>();

defineOptions({ layout: AppLayout });

// Palette colors come from the DB at runtime,
// so dynamic :style is required — Tailwind cannot generate classes with unknown values at build time.
function bg(color: string) {
    return { backgroundColor: color };
}
</script>
<template>
    <Head title="Temes" />

    <div class="flex h-full flex-1 flex-col gap-6 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-hp-text">Temes</h1>
                <p class="mt-1 text-sm text-hp-text-dim">
                    Paletes disponibles a la base de dades.
                </p>
            </div>
            <Link
                href="/theme/create"
                class="inline-flex items-center gap-2 rounded-xl bg-hp-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:opacity-90 active:scale-95"
            >
                <Plus class="h-4 w-4" />
                Nou tema
            </Link>
        </div>

        <div
            v-if="props.theme.length === 0"
            class="rounded-xl border border-dashed border-gray-200 bg-white p-12 text-center text-sm text-hp-text-dim"
        >
            Encara no hi ha temes.
        </div>

        <div v-else class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <div
                v-for="item in props.theme"
                :key="item.id"
                class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition hover:shadow-md"
            >
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-hp-text">
                            {{ item.name }}
                        </h2>
                        <span
                            v-if="item.default === 1"
                            class="mt-2 inline-flex items-center rounded-full bg-hp-primary/10 px-3 py-1 text-xs font-semibold text-hp-primary"
                        >
                            Predeterminat
                        </span>
                    </div>
                    <div v-if="item.default === 0">
                        <Link
                            :href="destroy(item.id)"
                            method="delete"
                            as="button"
                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-gray-400 transition hover:bg-red-50 hover:text-red-500"
                        >
                            <Trash class="h-4 w-4" />
                        </Link>
                    </div>
                </div>

                <!-- Color palette -->
                <div class="mt-4 flex flex-col gap-2">
                    <div
                        class="group relative h-16 w-full cursor-default rounded-xl border border-black/5"
                        :style="bg(item.primary)"
                        :title="`Primary · ${item.primary}`"
                    >
                        <div class="absolute inset-0 flex flex-col items-center justify-center rounded-xl opacity-0 transition group-hover:opacity-100">
                            <span class="text-xs font-semibold text-white/90">Primary</span>
                            <span class="text-[11px] text-white/70">{{ item.primary }}</span>
                        </div>
                    </div>

                    <!-- Remaining colors -->
                    <div class="grid grid-cols-5 gap-2">
                        <div
                            v-for="[label, value] in [
                                ['Primary Dark', item.primary_dark],
                                ['Secondary', item.secondary],
                                ['Text', item.text],
                                ['Text Sec.', item.text_secondary],
                                ['Background', item.background],
                            ]"
                            :key="label"
                            class="group relative h-10 cursor-default rounded-lg border border-black/5"
                            :style="bg(value as string)"
                            :title="`${label} · ${value}`"
                        >
                            <div class="absolute inset-0 flex flex-col items-center justify-center rounded-lg opacity-0 transition group-hover:opacity-100">
                                <span class="text-center text-[9px] font-semibold leading-tight text-white/90">{{ label }}</span>
                                <span class="text-[8px] text-white/70">{{ value }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
