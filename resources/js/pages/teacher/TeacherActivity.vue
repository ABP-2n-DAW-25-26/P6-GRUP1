<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Eye, Pencil, Trash2 } from 'lucide-vue-next';
import { schedule } from '@/routes';
import ButtonTabs from './components/ButtonTabs.vue';
import HeaderExchangeInfo from './components/HeaderExchangeInfo.vue';
import {
    show as showGuidedActivity,
    edit as editGuidedActivity,
    destroy as deleteGuidedActivity,
} from '@/routes/exchange/guidedactivity';
import {
    show as showInterestPoint,
    edit as editInterestPoint,
    destroy as deleteInterestPoint,
} from '@/routes/exchange/interestpoint';
import {
    show as showPost,
    edit as editPost,
    destroy as deletePost,
} from '@/routes/exchange/post';
import {
    show as showGimcana,
    edit as editGimcana,
    destroy as deleteGimcana,
} from '@/routes/exchange/gimcana';

interface Exchange {
    id: number;
    title: string;
    origin: string;
    start_date: string;
    end_date: string | null;
    destiny: string;
    users?: { id: number }[];
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

const getDescription = (description: string | null): string => {
    const text = description?.trim();

    if (!text) {
        return '—';
    }

    const withoutHtmlTags = text
        .replace(/<style[\s\S]*?<\/style>/gi, ' ')
        .replace(/<script[\s\S]*?<\/script>/gi, ' ')
        .replace(/<[^>]+>/g, ' ')
        .replace(/\s+/g, ' ')
        .trim();

    return withoutHtmlTags || '—';
};

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
    post: 'Anunci',
    guided_visit: 'Visita guiada',
    gimcana: 'Gimcana',
    interest_point: "Punt d'interes",
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
                show: showInterestPoint({
                    exchange: exchangeId,
                    interestpoint: activity.id,
                }),
                edit: editInterestPoint({
                    exchange: exchangeId,
                    interestpoint: activity.id,
                }),
                delete: deleteInterestPoint({
                    exchange: exchangeId,
                    interestpoint: activity.id,
                }),
            };

        case 'guided_visit':
            return {
                show: showGuidedActivity({
                    exchange: exchangeId,
                    guidedactivity: activity.id,
                }),
                edit: editGuidedActivity({
                    exchange: exchangeId,
                    guidedactivity: activity.id,
                }),
                delete: deleteGuidedActivity({
                    exchange: exchangeId,
                    guidedactivity: activity.id,
                }),
            };

        case 'gimcana':
            return {
                show: showGimcana({ exchange: exchangeId, gimcana: activity.id }),
                edit: editGimcana({ exchange: exchangeId, gimcana: activity.id }),
                delete: deleteGimcana({ exchange: exchangeId, gimcana: activity.id }),
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

    <div
        class="flex h-full flex-1 flex-col gap-8 overflow-x-hidden rounded-xl p-4"
    >
        <HeaderExchangeInfo :exchange="exchange" />

        <ButtonTabs
            v-if="exchange"
            :active-tab="'activities'"
            :exchange="exchange"
        />

        <div class="flex flex-col gap-4">
            <div v-for="day in exchangeDays" :key="day.date" class="flex">
                <div class="flex-1 rounded-2xl p-4">
                    <div class="mb-4 flex items-center gap-3">
                        <h3 class="text-xl font-bold capitalize">
                            {{ formatDayName(day.date) }}
                        </h3>
                        <time :datetime="day.date" class="text-gray-400"
                            >{{ day.day }} {{ formatMonthName(day.date) }}</time
                        >
                    </div>

                    <div v-if="day.activities.length > 0" class="space-y-4">
                        <div
                            v-for="activity in day.activities"
                            :key="activity.id"
                        >
                            <div class="flex gap-3">
                                <div class="flex w-18 flex-col justify-around">
                                    <time class="text-gray-400">
                                        {{ formatTime(activity.start_date) }}
                                    </time>
                                    <time class="text-gray-400">
                                        {{ formatTime(activity.end_date) }}
                                    </time>
                                </div>
                                <div
                                    class="flex w-full items-center justify-between rounded-xl border bg-stone-100 p-4"
                                >
                                    <div class="min-w-0">
                                        <div class="flex gap-3">
                                            <h4
                                                class="font-semibold text-gray-700"
                                            >
                                                {{ activity.title }}
                                            </h4>
                                        </div>
                                        <p class="line-clamp-1 text-gray-500">
                                            {{ getDescription(activity.description) }}
                                        </p>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="badge-actiu inline-flex flex-1 items-center rounded-full px-4 py-1.5 text-xs font-semibold"
                                            >
                                                {{
                                                    activityTypeLabels[
                                                        activity.type
                                                    ]
                                                }}
                                            </span>
                                            <Link
                                                :href="
                                                    getActivityRoutes(activity)
                                                        .show
                                                "
                                                class="rounded-lg p-2 text-hp-text-dim transition hover:bg-white hover:text-hp-text"
                                                title="Veure"
                                            >
                                                <Eye class="h-4 w-4" />
                                            </Link>

                                            <Link
                                                :href="
                                                    getActivityRoutes(activity)
                                                        .edit
                                                "
                                                class="rounded-lg p-2 text-hp-text-dim transition hover:bg-white hover:text-hp-text"
                                                title="Editar"
                                            >
                                                <Pencil class="h-4 w-4" />
                                            </Link>

                                            <Link
                                                :href="
                                                    getActivityRoutes(activity)
                                                        .delete
                                                "
                                                class="rounded-lg p-2 text-hp-text-dim transition hover:bg-red-50 hover:text-hp-red"
                                                title="Eliminar"
                                            >
                                                <Trash2 class="h-4 w-4" />
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="text-gray-600">Sense activitats</div>
                </div>
            </div>
        </div>
    </div>
</template>
