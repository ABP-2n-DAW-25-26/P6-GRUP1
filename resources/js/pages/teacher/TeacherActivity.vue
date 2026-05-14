<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Pencil, Eye, Trash2 } from 'lucide-vue-next';
import { show as showGuidedActivity, edit as editGuidedActivity, destroy as deleteGuidedActivity } from '@/routes/exchange/guidedactivity';
import { show as showInterestPoint, edit as editInterestPoint, destroy as deleteInterestPoint } from '@/routes/exchange/interestpoint';
import { show as showPost, edit as editPost, destroy as deletePost } from '@/routes/exchange/post';
import ButtonTabs from './components/ButtonTabs.vue';
import HeaderExchangeInfo from './components/HeaderExchangeInfo.vue';

interface Exchange {
    id: number;
    title: string;
    origin: string;
    start_date: string;
    end_date: string | null;
    destiny: string;
    users?: { id: number }[];
}

interface Teacher {
    id: number;
    name: string;
    email: string;
}

interface Activity {
    id: number;
    title: string;
    description: string;
    start_date: string;
    end_date: string;
    latitude: string;
    longitude: string;
    type: string;
    file: string;
    exchange_id: string;
    exchange?: Exchange | null;
}

const props = defineProps<{
    exchange?: Exchange | null;
    studentsCount: number;
    exchangeDays: Array<{
        date: string;
        day: number;
        activities: Activity[];
    }>;
}>();

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
const activityTypeLabels: Record<string, string> = {
    'post': 'Anunci',
    'guided_visit': 'Visita guiada',
    'gimcana': 'Gimcana',
    'interest_point': 'Punt d\'interes',
};

function getActivityRoutes(activity: Activity) {
    const exchangeId = props.exchange?.id ?? 0;

    switch (activity.type) {
        case 'post':
            return {
                show: showPost({ exchange: exchangeId, post: activity.id }),
                edit: editPost({ exchange: exchangeId, post: activity.id }),
                delete: deletePost({ exchange: exchangeId, post: activity.id }),
            };

        case 'interest_point':
            return {
                show: showInterestPoint({ exchange: exchangeId, interestpoint: activity.id }),
                edit: editInterestPoint({ exchange: exchangeId, interestpoint: activity.id }),
                delete: deleteInterestPoint({ exchange: exchangeId, interestpoint: activity.id }),
            };

        case 'guided_visit':
        case 'gimcana':
            return {
                show: showGuidedActivity({ exchange: exchangeId, guidedactivity: activity.id }),
                edit: editGuidedActivity({ exchange: exchangeId, guidedactivity: activity.id }),
                delete: deleteGuidedActivity({ exchange: exchangeId, guidedactivity: activity.id }),
            };

        default:
            return {
                show: '#',
                edit: '#',
                delete: '#',
            };
    }
}

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Intercanvis',
            },
        ],
    },
});
</script>

<template>

    <Head title="Agenda" />


    <div class="flex h-full flex-1 flex-col gap-8 overflow-x-hidden rounded-xl p-4">
        <HeaderExchangeInfo :exchange="exchange" />

        <ButtonTabs v-if="exchange" :active-tab="'activities'" :exchange="exchange" />

        <div class="flex flex-col gap-4">
            <div v-for="day in exchangeDays" :key="day.date" class="flex">

                <div class="flex-1 rounded-2xl p-4">
                    <div class="flex gap-3 items-center mb-4">
                        <h3 class="font-bold text-xl capitalize">
                            {{ formatDayName(day.date) }}
                        </h3>
                        <time :datetime="day.date" class="text-gray-400">{{ day.day }} {{ formatMonthName(day.date)
                            }}</time>
                    </div>

                    <div v-if="day.activities.length > 0" class="space-y-4">
                        <div v-for="activity in day.activities" :key="activity.id">
                            <div class="flex gap-3">
                                <div class="flex flex-col justify-around w-18">
                                    <time class="text-gray-400">
                                        {{ formatTime(activity.start_date) }}
                                    </time>
                                    <time class="text-gray-400">
                                        {{ formatTime(activity.end_date) }}
                                    </time>
                                </div>
                                <div
                                    class="p-4 bg-stone-100 border rounded-xl w-full flex justify-between items-center">
                                    <div class="min-w-0">
                                        <div class="flex gap-3">

                                            <h4 class="font-semibold text-gray-700">{{ activity.title }}</h4>
                                        </div>
                                        <p class="text-gray-500 line-clamp-1">{{ activity.description }}</p>
                                    </div>
                                    <div class="flex items-center ">
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="inline-flex flex-1 items-center rounded-full px-4 py-1.5 text-xs font-semibold badge-actiu">
                                                {{ activityTypeLabels[activity.type] }}
                                            </span>
                                            <Link :href="getActivityRoutes(activity).show"
                                                class="rounded-lg p-2 text-hp-text-dim transition hover:bg-white hover:text-hp-text"
                                                title="Veure">
                                                <Eye class="w-4 h-4" />
                                            </Link>

                                            <Link :href="getActivityRoutes(activity).edit"
                                                class="rounded-lg p-2 text-hp-text-dim transition hover:bg-white hover:text-hp-text"
                                                title="Editar">
                                                <Pencil class="w-4 h-4" />
                                            </Link>

                                            <Link :href="getActivityRoutes(activity).delete"
                                                class="rounded-lg p-2 text-hp-text-dim transition hover:bg-red-50 hover:text-hp-red"
                                                title="Eliminar">
                                                <Trash2 class="w-4 h-4" />
                                            </Link>
                                        </div>
                                    </div>
                                </div>
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