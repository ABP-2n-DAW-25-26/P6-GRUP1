<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import { ref } from 'vue';
import { store } from '@/routes/exchange';

const selectedColor = ref('#10b981');

const colors = [
    '#a855f7',
    '#6366f1',
    '#60a5fa',
    '#22c55e',
    '#10b981',
    '#84cc16',
    '#facc15',
    '#fb923c',
    '#ef4444',
    '#ec4899',
];

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Crear un nou Intercanvi',
            },
        ],
    },
});
</script>

<template>
    <div class="flex w-full items-center p-4">
        <div class="mx-auto w-full max-w-lg">
            <h1 class="text-3xl font-semibold text-hp-text pt-8">
                Crea un intercanvi
            </h1>

            <div class="rounded-2xl bg-white p-4 dark:bg-gray-800">
                <Form :action="store()" method="post" class="space-y-5">
                    <div>
                        <label
                            for="title"
                            class="text-sm font-medium text-gray-700 dark:text-gray-300"
                        >
                            Títol
                        </label>

                        <input
                            id="title"
                            type="text"
                            name="title"
                            placeholder="Escandinavia-2026"
                            autocomplete="off"
                            class="mt-1 w-full rounded-md border px-3 py-2 text-sm focus:ring-2 focus:ring-teal-400 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                        />
                    </div>

                    <div>
                        <label
                            class="text-sm font-medium text-gray-700 dark:text-gray-300"
                        >
                            Color
                        </label>

                        <div
                            class="mt-2 flex flex-wrap gap-2"
                            role="radiogroup"
                            aria-label="Selector de color"
                        >
                            <button
                                v-for="color in colors"
                                :key="color"
                                type="button"
                                :aria-label="`Seleccionar color ${color}`"
                                :aria-checked="selectedColor === color"
                                role="radio"
                                @click="selectedColor = color"
                                class="h-8 w-8 rounded-full border-2 transition sm:h-6 sm:w-6"
                                :style="{ backgroundColor: color }"
                                :class="
                                    selectedColor === color
                                        ? 'scale-110 border-gray-900 dark:border-white'
                                        : 'border-transparent opacity-80'
                                "
                            ></button>
                        </div>

                        <input
                            type="hidden"
                            name="color"
                            :value="selectedColor"
                        />
                    </div>

                    <div>
                        <label
                            for="origin"
                            class="text-sm font-medium text-gray-700 dark:text-gray-300"
                        >
                            Origen
                        </label>

                        <input
                            id="origin"
                            type="text"
                            name="origin"
                            placeholder="Figueres"
                            autocomplete="off"
                            class="mt-1 w-full rounded-md border px-3 py-2 text-sm focus:ring-2 focus:ring-teal-400 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                        />
                    </div>

                    <div>
                        <label
                            for="destiny"
                            class="mb-1 text-sm font-medium text-gray-700 dark:text-gray-300"
                        >
                            Desti
                        </label>

                        <input
                            id="destiny"
                            type="text"
                            name="destiny"
                            placeholder="Italia"
                            autocomplete="off"
                            class="mt-1 w-full rounded-md border px-3 py-2 text-sm focus:ring-2 focus:ring-teal-400 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                        />
                    </div>

                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                        <div>
                            <label
                                for="start_date"
                                class="text-sm font-medium text-gray-700 dark:text-gray-300"
                            >
                                Comença
                            </label>

                            <input
                                id="start_date"
                                type="datetime-local"
                                name="start_date"
                                class="mt-1 w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2 text-sm focus:ring-2 focus:ring-teal-400 focus:outline-none dark:border-gray-700 dark:bg-gray-900"
                            />
                        </div>

                        <div>
                            <label
                                for="end_date"
                                class="text-sm font-medium text-gray-700 dark:text-gray-300"
                            >
                                Acaba
                            </label>

                            <input
                                id="end_date"
                                type="datetime-local"
                                name="end_date"
                                class="mt-1 w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2 text-sm focus:ring-2 focus:ring-teal-400 focus:outline-none dark:border-gray-700 dark:bg-gray-900"
                            />
                        </div>
                    </div>

                    <div class="flex w-full gap-3 pt-2 lg:mt-20">
                        <button
                            type="button"
                            aria-label="Cancel·lar creació intercanvi"
                            class="flex-1 rounded-md border border-gray-300 py-2 text-sm dark:border-gray-600"
                        >
                            Cancel·lar
                        </button>

                        <button
                            type="submit"
                            aria-label="Crear intercanvi"
                            class="flex-1 rounded-md bg-teal-400 py-2 text-sm font-semibold hover:bg-teal-300"
                        >
                            Crear Intercanvi
                        </button>
                    </div>
                </Form>
            </div>
        </div>
    </div>
</template>
