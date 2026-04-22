<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

interface GuidedActivity {
    id: number;
    title: string;
    description: string | null;
    start_date: string | null;
    end_date: string | null;
}

defineProps<{
    guidedActivities: GuidedActivity[];
}>();
</script>

<template>
    <div class="p-6 w-full">
        <h1 class="text-2xl font-bold text-hp-text mb-6">Activitats guiades</h1>

        <div v-if="guidedActivities.length === 0" class="text-hp-text-dim text-sm">
            No hi ha activitats
        </div>

        <div class="grid gap-4">
            <Link
                v-for="activity in guidedActivities"
                :key="activity.id"
                :href="`/guidedactivity/${activity.id}`"
                class="block bg-white border border-hp-border rounded-xl p-4 hover:shadow-md transition">
                <h2 class="font-semibold text-hp-text">{{ activity.title }}</h2>
                <p v-if="activity.description" class="text-sm text-hp-text-dim mt-1">{{ activity.description }}</p>
                <div v-if="activity.start_date" class="text-xs text-hp-text-dim mt-2">
                    {{ activity.start_date }} — {{ activity.end_date }}
                </div>
            </Link>
        </div>
    </div>
</template>
