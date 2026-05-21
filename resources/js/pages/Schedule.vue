<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ChevronRight } from 'lucide-vue-next';
import { computed } from 'vue';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { useInitials } from '@/composables/useInitials';
import { schedule } from '@/routes';
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

const { getInitials } = useInitials();

interface Exchange {
    id: number;
    title: string;
    origin: string;
    start_date: string;
    end_date: string | null;
    destiny: string;
    users?: { id: number }[];
}
interface User {
    id: number;
    name: string;
    surname: string;
    email: string;
    role: string;
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
    user: User;
    exchange_id: string;
    exchange?: Exchange | null;
}

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
        activities: Activity[];
    }>;
}>();

const userImage = computed(
    () => props.exchange.user.image || props.exchange.user.avatar || '',
);
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
                show: showGimcana({
                    exchange: exchangeId,
                    gimcana: activity.id,
                }),
                edit: editGimcana({
                    exchange: exchangeId,
                    gimcana: activity.id,
                }),
                delete: deleteGimcana({
                    exchange: exchangeId,
                    gimcana: activity.id,
                }),
            };
            

        default:
            return {
                show: '#',
                edit: '#',
                delete: '#',
            };
    }
}

function downloadPdf() {
    window.print();
}
</script>

<template>
    <Head title="Agenda" />

    <div class="relative flex flex-1 flex-col gap-8 rounded-xl p-4" id="agenda">
        <button
            @click="downloadPdf"
            class="absolute w-min self-end rounded-xl bg-hp-primary px-4 py-2 font-semibold text-nowrap text-white hover:bg-hp-primary-dark"
        >
            Descarregar PDF
        </button>
        <h1 class="text-center font-hp text-6xl text-hp-primary">agenda</h1>

        <div class="flex items-center justify-center gap-4">
            <h2 class="text-center text-2xl font-bold">{{ exchange.title }}</h2>
        </div>

        <div
            v-if="exchange !== null"
            class="z-20 mx-auto flex w-full gap-6 rounded-3xl bg-stone-100 px-4 py-6 uppercase dark:bg-neutral-800"
        >
            <div class="mx-auto flex gap-2">
                <div
                    v-for="day in exchangeDays"
                    :key="day.date"
                    class="text-center font-bold"
                >
                    <div
                        v-if="day.day === currentDay()"
                        class="rounded-2xl bg-linear-to-br from-hp-primary-dark to-hp-secondary-dark p-5 text-white shadow-xl/10"
                    >
                        <p class="text-xs">día</p>
                        <time
                            :datetime="day.date"
                            class="text-xl font-extrabold"
                            >{{ day.day }}</time
                        >
                    </div>
                    <div v-else class="p-5">
                        <p class="text-xs text-gray-400">día</p>
                        <time :datetime="day.date" class="text-2xl font-bold">{{
                            day.day
                        }}</time>
                    </div>
                </div>
            </div>
        </div>

        <div v-else class="px-30 text-center text-gray-500">
            No hi ha cap intercanvi programat. Has d'esperar a que un professor
            creï un intercanvi i t'assigni a tu perquè puguis veure les
            activitats programades.
        </div>

        <div class="flex flex-col gap-4">
            <div v-for="day in exchangeDays" :key="day.date" class="flex">
                <div class="flex-1 rounded-2xl p-4">
                    <div class="mb-4 flex items-center gap-3">
                        <h3
                            v-if="day.day === currentDay()"
                            class="rounded-xl bg-linear-to-br from-hp-primary-dark to-hp-secondary-dark px-4 py-2 text-xl font-semibold text-white"
                        >
                            Avui,
                        </h3>
                        <h3 v-else class="text-xl font-bold capitalize">
                            {{ formatDayName(day.date) }}
                        </h3>
                        <time :datetime="day.date" class="text-gray-400">
                            {{ day.day }} {{ formatMonthName(day.date) }}
                        </time>
                    </div>

                    <div v-if="day.activities.length > 0" class="space-y-4">
                        <div
                            v-for="activity in day.activities"
                            :key="activity.id"
                            class="group flex gap-3"
                        >
                            <div class="flex w-18 flex-col justify-around">
                                <time class="text-gray-400">
                                    {{ formatTime(activity.start_date) }}
                                </time>
                                <time class="text-gray-400">
                                    {{ formatTime(activity.end_date) }}
                                </time>
                            </div>

                            <div class="flex w-full">
                                <Link
                                    :href="getActivityRoutes(activity).show"
                                    class="flex w-full items-center justify-between rounded-xl border bg-secondary/50 p-4 hover:bg-secondary"
                                >
                                    <div>
                                        <h4
                                            class="font-semibold text-primary/80"
                                        >
                                            {{ activity.title }}
                                        </h4>
                                        <p class="text-primary/60">
                                            {{ activity.description }}
                                        </p>
                                    </div>

                                    <div class="flex items-center gap-4">
                                        <Avatar
                                            class="h-12 w-12 overflow-hidden rounded-full"
                                        >
                                            <AvatarImage
                                                v-if="showUserImage"
                                                :src="userImage"
                                                :alt="activity.user.name"
                                            />
                                            <AvatarFallback
                                                class="rounded-full font-bold text-white dark:text-white"
                                            >
                                                {{
                                                    getInitials(
                                                        activity.user.name,
                                                    )
                                                }}
                                            </AvatarFallback>
                                        </Avatar>

                                        <ChevronRight
                                            class="text-gray-500 group-hover:text-gray-900 group-hover:dark:text-gray-100"
                                            :size="18"
                                        />
                                    </div>
                                </Link>
                            </div>
                        </div>
                    </div>

                    <div v-else class="text-gray-600">Sense activitats</div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
@media print {
    button {
        display: none !important;
    }
}
</style>
