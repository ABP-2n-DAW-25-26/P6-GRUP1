<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

interface GuidedActivity {
    id: number;
    title: string;
    description: string | null;
    start_date: string | null;
    end_date: string | null;
    exchange_id: number;
}

defineProps<{
    guidedActivities: GuidedActivity[];
}>();
</script>

<template>
    <div class="w-full p-6">
        <h1 class="mb-6 text-2xl font-bold text-hp-text">Activitats guiades</h1>

        <div
            v-if="guidedActivities.length === 0"
            class="text-sm text-hp-text-dim"
        >
            No hi ha activitats
        </div>

        <div class="grid gap-4">
            <Link
                v-for="activity in guidedActivities"
                :key="activity.id"
                :href="`/exchange/${activity.exchange_id}/guidedactivity/${activity.id}`"
                class="block rounded-xl border border-hp-border bg-white p-4 transition hover:shadow-md"
            >
                <h2 class="font-semibold text-hp-text">{{ activity.title }}</h2>
                <p
                    v-if="activity.description"
                    class="mt-1 text-sm text-hp-text-dim"
                >
                    {{ activity.description }}
                </p>
                <div
                    v-if="activity.start_date"
                    class="mt-2 text-xs text-hp-text-dim"
                >
                    {{ activity.start_date }} — {{ activity.end_date }}
                </div>
            </Link>
        </div>
    </div>
</template>
