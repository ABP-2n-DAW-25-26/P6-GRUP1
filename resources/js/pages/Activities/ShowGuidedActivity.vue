<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'

interface Locations {
    id: number;
    name: string;
    description: string | null;
    latitude: string | null;
    longitude: string | null;
    activity_id: number | null;
}

interface GuidedActivity {
    id: number;
    title: string;
    description: string | null;
    start_date: string | null;
    end_date: string | null;
    latitude: string | null;
    longitude: string | null;
    type: string | null;
    file: string | null;
    exchange_id: number | null;
    locations: Locations[];
}

const props = defineProps<{
    guidedactivity: GuidedActivity;
    locations: Locations;
}>();
</script>

<template>

    <Head :title="guidedactivity.title" />

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 p-4">

        <div class="max-w-md mx-auto">

            <!-- Header -->
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-xl font-semibold text-teal-700 dark:text-teal-400">
                    Visita guiada
                </h1>
            </div>

            <!-- Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-4 space-y-4">

                <!-- Nom de la activitat i horari -->
                <div>
                    <h2 class="font-semibold text-gray-800 dark:text-white">
                        {{ guidedactivity.title }}
                    </h2>
                    <p class="text-sm text-gray-500">
                        {{ guidedactivity.start_date }} - {{ guidedactivity.end_date }}
                    </p>
                </div>

                <!-- Imatge -->
                <div class="w-full h-40 bg-gray-200 dark:bg-gray-700 rounded-lg overflow-hidden relative">
                    <img v-if="guidedactivity.file" :src="guidedactivity.file" class="w-full h-full object-cover" />
                </div>

                <!-- Descripció -->
                <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                    {{ guidedactivity.description }}
                </p>

                <!-- Mapa -->
                <div class="w-full h-40 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400">
                </div>
                <!-- Parades -->
                <div>
                    <h2 class="font-semibold text-teal-500 dark:text-white">
                        Parades
                    </h2>
                    <div v-for="location in guidedactivity.locations" :key="location.id"
                        class="mb-4 p-3 bg-gray-100 dark:bg-gray-700 rounded-lg">
                        <h3 class="font-semibold text-gray-800 dark:text-white">
                            {{ location.name }}
                        </h3>

                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            {{ location.description }}
                        </p>

                        <p class="flex items-center justify-between text-sm text-gray-500 border-t pt-2">
                            Lat: {{ location.latitude }} | Lng: {{ location.longitude }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>