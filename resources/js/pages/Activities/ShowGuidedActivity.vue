<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import LeafletMap from '@/components/LeafletMap.vue';

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

defineProps<{
    guidedactivity: GuidedActivity;
}>();
</script>

<template>
    <Head :title="guidedactivity.title" />

    <div class="min-h-screen w-full p-4 dark:bg-gray-900">
        <div class="mx-auto">
            <!-- Header -->
            <div class="mb-4 flex items-center justify-between">
                <h1
                    class="text-xl font-semibold text-teal-700 dark:text-teal-400"
                >
                    Visita guiada
                </h1>
            </div>

            <!-- Card -->
            <div class="space-y-4 rounded-2xl bg-white dark:bg-gray-800">
                <!-- Nom de la activitat i horari -->
                <div>
                    <h2 class="font-semibold text-gray-800 dark:text-white">
                        {{ guidedactivity.title }}
                    </h2>
                    <p class="text-sm text-gray-500">
                        {{ guidedactivity.start_date }} -
                        {{ guidedactivity.end_date }}
                    </p>
                </div>

                <!-- Descripció -->
                <p
                    class="text-sm leading-relaxed text-gray-600 dark:text-gray-300"
                >
                    {{ guidedactivity.description }}
                </p>

                <!-- Mapa -->
                <div class="h-80 w-full overflow-hidden rounded-lg">
                    <LeafletMap :markers="guidedactivity.locations" />
                </div>
                <!-- Parades -->
                <div>
                    <h2 class="font-semibold text-teal-500 dark:text-white">
                        Parades
                    </h2>
                    <div
                        v-for="location in guidedactivity.locations"
                        :key="location.id"
                        class="mb-4 rounded-lg p-3 dark:bg-gray-700"
                    >
                        <h3 class="font-semibold text-gray-800 dark:text-white">
                            {{ location.name }}
                        </h3>

                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            {{ location.description }}
                        </p>

                        <p
                            class="flex items-center justify-between rounded-lg border border-solid border-gray-200 px-3 py-2 text-sm text-gray-600"
                        >
                            Lat: {{ location.latitude }} | Lng:
                            {{ location.longitude }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
