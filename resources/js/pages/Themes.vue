<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Trash } from 'lucide-vue-next';
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
</script>
<template>
    <Head title="Temes" />

    <div class="flex h-full flex-1 flex-col gap-6 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-hp-text">Temes</h1>
                <p class="text-sm text-hp-text-dim">
                    Paletes disponibles a la base de dades.
                </p>
            </div>
            <Link
                href="/theme/create"
                class="inline-flex items-center gap-2 rounded-xl bg-hp-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-hp-primary/90"
            >
                Nou tema
            </Link>
        </div>

        <div
            v-if="props.theme.length === 0"
            class="rounded-xl border border-dashed border-gray-200 bg-white p-8 text-center text-hp-text-dim"
        >
            Encara no hi ha temes.
        </div>

        <div v-else class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <div
                v-for="item in props.theme"
                :key="item.id"
                class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm"
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
                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-gray-100 text-gray-500 transition hover:bg-gray-200"
                        >
                            <Trash />
                        </Link>
                    </div>
                </div>

                <div class="mt-4 grid grid-cols-6 grid-rows-3 gap-2">
                    <div
                        class="col-span-6 row-span-2 rounded-2xl border border-gray-200 p-3"
                        :style="{ backgroundColor: item.primary }"
                    >
                        <div class="text-xs font-semibold text-white/90">
                            Primary
                        </div>
                        <div class="text-[11px] text-white/80">
                            {{ item.primary }}
                        </div>
                    </div>
                    <div
                        class="col-span-3 row-span-1 rounded-xl border border-gray-200 p-2"
                        :style="{ backgroundColor: item.primary_dark }"
                    >
                        <div class="text-[11px] font-semibold text-white/90">
                            Primary Dark
                        </div>
                        <div class="text-[10px] text-white/80">
                            {{ item.primary_dark }}
                        </div>
                    </div>
                    <div
                        class="col-span-3 row-span-1 rounded-xl border border-gray-200 p-2"
                        :style="{ backgroundColor: item.secondary }"
                    >
                        <div class="text-[11px] font-semibold text-white/90">
                            Secondary
                        </div>
                        <div class="text-[10px] text-white/80">
                            {{ item.secondary }}
                        </div>
                    </div>
                    <div
                        class="col-span-2 row-span-1 rounded-lg border border-gray-200 p-2"
                        :style="{ backgroundColor: item.text }"
                    >
                        <div class="text-[10px] font-semibold text-white/90">
                            Text
                        </div>
                        <div class="text-[10px] text-white/80">
                            {{ item.text }}
                        </div>
                    </div>
                    <div
                        class="col-span-2 row-span-1 rounded-lg border border-gray-200 p-2"
                        :style="{ backgroundColor: item.text_secondary }"
                    >
                        <div class="text-[10px] font-semibold text-white/90">
                            Text Sec.
                        </div>
                        <div class="text-[10px] text-white/80">
                            {{ item.text_secondary }}
                        </div>
                    </div>
                    <div
                        class="col-span-1 row-span-1 rounded-md border border-gray-200 p-2"
                        :style="{ backgroundColor: item.background }"
                    >
                        <div class="text-[10px] font-semibold text-hp-text">
                            Bg
                        </div>
                    </div>
                    <div
                        class="col-span-1 row-span-1 rounded-md border border-gray-200 p-2"
                        :style="{ backgroundColor: item.background_card }"
                    >
                        <div class="text-[10px] font-semibold text-hp-text">
                            Card
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
