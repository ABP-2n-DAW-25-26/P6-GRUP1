<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { schedule } from '@/routes';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Schedule',
                href: schedule(),
            },
        ],
    },
});

defineProps<{
    exchange: any;
    exchangeDays: Array<{
        date: string;
        day: number;
        activities: any[];
    }>;
}>();

function currentDay() {
    return new Date().getDate();
}

function formatDayName(dateString: string) {
    const date = new Date(dateString + 'T00:00:00');

    const weekday = date.toLocaleDateString('ca-ES', {
        weekday: 'long',
    });

    const dayNumber = date.getDate();

    return `${weekday}, ${dayNumber}`;
}

</script>

<template>

    <Head title="Agenda" />

    <div class="flex h-full flex-1 flex-col gap-8 overflow-x-auto rounded-xl p-4">

        <!-- {{ exchange }} -->

        <div class="mx-auto flex gap-6 px-4 py-6 bg-stone-100 rounded-3xl uppercase">
            <div v-for="day in exchangeDays" :key="day.date" class="text-center font-bold">

                <div v-if="day.day === currentDay()"
                    class="p-5 text-white bg-linear-to-br from-hp-primary-dark to-hp-secondary-dark rounded-2xl shadow-xl/10">

                    <p class="text-xs">día</p>
                    <span class="font-extrabold text-2xl">{{ day.day }}</span>
                </div>

                <div v-else class="p-5">
                    <p class="text-xs text-gray-400">día</p>
                    <span class="font-bold text-2xl">{{ day.day }}</span>
                </div>

            </div>
        </div>

        <div class="flex flex-col gap-4">
            <div v-for="day in exchangeDays" :key="day.date" class="flex">

                <div class="flex-1 rounded-2xl p-4">

                    <h3 class="font-bold text-lg mb-2 capitalize">
                        {{ formatDayName(day.date) }}
                    </h3>

                    <div v-if="day.activities.length > 0" class="space-y-2">
                        <div v-for="activity in day.activities" :key="activity.id"
                            class="p-2 bg-white rounded-lg shadow-sm">
                            {{ activity }}
                        </div>
                    </div>

                    <div v-else class="text-gray-400">
                        Sense activitats
                    </div>

                </div>

            </div>
        </div>

    </div>
</template>