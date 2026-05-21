<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import LeafletMap from '@/components/LeafletMap.vue';

interface InterestPoint {
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
}

defineProps<{
    activity: InterestPoint;
}>();

const getMarkerForMap = (activity: InterestPoint) => {
    if (activity.latitude && activity.longitude) {
        return [
            {
                id: activity.id,
                name: activity.title,
                description: activity.description,
                latitude: activity.latitude,
                longitude: activity.longitude,
                activity_id: activity.id,
            },
        ];
    }
    return [];
};
</script>

<template>
    <Head :title="activity.title" />

    <div class="relative min-h-full min-w-full overflow-hidden">
        <!-- Mapa -->
        <div class="absolute inset-0 z-0 rounded-xl">
            <LeafletMap :markers="getMarkerForMap(activity)" />
        </div>

        <div
            class="pointer-events-none absolute inset-0 z-10 rounded-xl bg-hp-primary/10"
        ></div>

        <div
            class="pointer-events-none relative z-20 flex min-h-[calc(100vh-6rem)] flex-col justify-start gap-3 px-3 py-3 md:items-start md:gap-6 md:px-4 md:py-4 lg:min-h-[calc(100vh-10rem)]"
        >
            <div class="flex w-full flex-col items-start gap-2 md:max-w-sm">
                <section
                    class="pointer-events-auto z-40 w-full rounded-2xl border-b-4 border-hp-primary bg-white px-4 py-3 shadow-xl md:px-5 md:py-4"
                >
                    <p class="font-bold tracking-widest text-hp-text-dim">
                        PUNT D'INTERÈS
                    </p>
                    <h1 class="mt-1 text-lg font-bold text-hp-text md:text-2xl">
                        {{ activity.title }}
                    </h1>
                    <p
                        v-if="activity.type"
                        class="mt-1 inline-flex rounded-full bg-hp-primary/10 px-2.5 py-0.5 text-xs font-semibold text-hp-primary"
                    >
                        {{ activity.type }}
                    </p>
                </section>
            </div>

            <section
                class="pointer-events-auto mt-auto mb-4 w-full rounded-4xl bg-linear-to-br from-hp-primary to-hp-primary-dark p-4 text-white shadow-2xl sm:max-w-md md:w-80 md:max-w-sm md:self-start md:p-6"
            >
                <div
                    v-if="activity.start_date || activity.end_date"
                    class="inline-flex rounded-full bg-white/20 px-2.5 py-1 text-xs font-bold tracking-wide md:px-3 md:text-xs"
                >
                    {{ activity.start_date }}
                    <template v-if="activity.start_date && activity.end_date">
                        &nbsp;–&nbsp;
                    </template>
                    {{ activity.end_date }}
                </div>

                <p
                    v-if="activity.description"
                    class="mt-4 text-sm leading-relaxed text-white/90 md:mt-5 md:text-base"
                >
                    {{ activity.description }}
                </p>

                <div
                    v-if="activity.latitude && activity.longitude"
                    class="mt-4 rounded-2xl bg-white/10 px-3 py-2 md:mt-5 md:px-4 md:py-3"
                >
                    <p class="text-xs font-semibold text-white/70 uppercase tracking-widest mb-1">
                        Ubicació
                    </p>
                    <p class="text-xs text-white/80">
                        <span class="font-semibold">Lat:</span> {{ activity.latitude }}
                    </p>
                    <p class="text-xs text-white/80">
                        <span class="font-semibold">Lng:</span> {{ activity.longitude }}
                    </p>
                </div>
            </section>
        </div>
    </div>
</template>