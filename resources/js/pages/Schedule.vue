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
        case 'gimcana':
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

        default:
            return {
                show: '#',
                edit: '#',
                delete: '#',
            };
    }
}
</script>

<template>
    <Head title="Agenda" />

    <div
        class="flex h-full flex-1 flex-col gap-8 overflow-x-hidden rounded-xl p-4"
    >
        <h1 class="text-center font-hp text-6xl text-hp-primary">agenda</h1>
        <div
            v-if="exchange !== null"
            class="sticky top-0 mx-auto flex w-full gap-6 overflow-x-auto rounded-3xl bg-stone-100 px-4 py-6 uppercase"
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
                        <time :datetime="day.date" class="text-gray-400"
                            >{{ day.day }} {{ formatMonthName(day.date) }}</time
                        >
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
                                    class="flex w-full items-center justify-between rounded-xl border bg-stone-100 p-4"
                                >
                                    <div>
                                        <h4 class="font-semibold text-gray-700">
                                            {{ activity.title }}
                                        </h4>
                                        <p class="text-gray-500">
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
                                            class="text-gray-500 group-hover:text-gray-900"
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
