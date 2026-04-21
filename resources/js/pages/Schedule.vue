<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { schedule } from '@/routes';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { useInitials } from '@/composables/useInitials';
import { computed } from 'vue';

const { getInitials } = useInitials();


defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Agenda',
                href: schedule(),
            },
        ],
    },
});

const props = defineProps<{
    exchange: any;
    exchangeDays: Array<{
        date: string;
        day: number;
        activities: any[];
    }>;
}>();

const userImage = computed(() => props.exchange.user.image || props.exchange.user.avatar || '');
const showUserImage = computed(() => userImage.value !== '');

function currentDay() {
    return new Date().getDate();
}

function formatDayName(dateString: string) {
    const date = new Date(dateString + 'T00:00:00');

    return date.toLocaleDateString('ca-ES', {
        weekday: 'long',
    });
}

function formatMonthName(dateString: string) {
    const date = new Date(dateString + 'T00:00:00');

    return date.toLocaleDateString('ca-ES', {
        month: 'long',
    });
}

function formatTime(dateString: string) {
    const date = new Date(dateString);
    return date.toLocaleTimeString('ca-ES', {
        hour: '2-digit',
        minute: '2-digit',
        hour12: false,
    });
}

</script>

<template>

    <Head title="Agenda" />

    <div class="flex h-full flex-1 flex-col gap-8 overflow-x-auto rounded-xl p-4">

        <div class="font-catalona">
            {{ exchange.user }}
        </div>

        <div class="mx-auto flex gap-6 px-4 py-6 bg-stone-100 rounded-3xl uppercase sticky top-0">
            <div v-for="day in exchangeDays" :key="day.date" class="text-center font-bold">

                <div v-if="day.day === currentDay()"
                    class="p-5 text-white bg-linear-to-br from-hp-primary-dark to-hp-secondary-dark rounded-2xl shadow-xl/10">
                    <p class="text-xs">día</p>
                    <span class="font-extrabold text-xl">{{ day.day }}</span>
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
                    <div class="flex gap-3 items-center mb-4">
                        <h3 class="font-bold text-xl capitalize">
                            {{ formatDayName(day.date) }}
                        </h3>
                        <span class="text-gray-400">{{ day.day }} {{ formatMonthName(day.date) }}</span>
                    </div>

                    <div v-if="day.activities.length > 0" class="space-y-2">
                        <div v-for="activity in day.activities" :key="activity.id" class="flex gap-3">
                            <div class="text-gray-400 mt-4">
                                {{ formatTime(activity.start_date) }}
                            </div>
                            <div class="p-4 bg-stone-100 border rounded-xl w-full flex justify-between items-center">
                                <div>
                                    <h4 class="font-semibold text-gray-700">{{ activity.title }}</h4>
                                    <p class="text-gray-500">{{ activity.description }}</p>
                                </div>
                                <Avatar class="h-12 w-12 overflow-hidden rounded-full">
                                    <AvatarImage v-if="showUserImage" :src="userImage" :alt="exchange.user.name" />
                                    <AvatarFallback class="rounded-full text-white dark:text-white font-bold">
                                        {{ getInitials(exchange.user.name) }}
                                    </AvatarFallback>
                                </Avatar>
                            </div>
                        </div>
                    </div>
                    <div v-else class="text-gray-600">
                        Sense activitats
                    </div>

                </div>

            </div>
        </div>

    </div>
</template>