<script setup lang="ts">
import { MonitorCog, Menu, ChevronDown, Pencil, Trash, Users } from 'lucide-vue-next';
import { ref } from 'vue';

interface Exchange {
    id: number;
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
    activity: Activity[];
}>();

const expandedId = ref<number | null>(null);

const toggleExpand = (id: number) => {
    expandedId.value = expandedId.value === id ? null : id;
};

const formatTime = (value: string | null | undefined): string => {
    if (!value) return '--:--';
    const parts = value.split(/[Time ]/);
    const timePart = parts[1];
    return timePart ? timePart.slice(0, 5) : '--:--';
};

const formatDate = (value: string | null | undefined): string => {
    if (!value) return '—';

    const date = new Date(value);
    if (Number.isNaN(date.getTime())) return value;

    return date.toLocaleDateString('ca-ES', {
        day: 'numeric',
        month: 'short',
        year: 'numeric',
    });
};

const currentExchange = props.activity[0]?.exchange ?? null;

const groupedActivities = () => {
    const grouped: { [key: string]: Activity[] } = {};
    props.activity.forEach(act => {
        const date = act.start_date.split(/[Time ]/)[0];
        if (!grouped[date]) grouped[date] = [];
        grouped[date].push(act);
    });
    return grouped;
};
</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <div class="flex flex-row items-center justify-between border-b border-gray-200 bg-white p-4">
            <div class="flex flex-row items-center">
                <div class="mr-3 rounded-lg bg-[#D8D9DC] p-2 text-[#5D5D5D]">
                    <MonitorCog :size="24" />
                </div>
                <h1 class="text-xl font-bold text-[#181D1B]">Intercanvi</h1>
            </div>
            <Menu :size="24" class="cursor-pointer text-gray-600" />
        </div>

        <div class="border-b border-gray-200 bg-white p-4">
            <div v-if="currentExchange" class="flex flex-row items-center justify-between">
                <div class="text-center">
                    <p class="text-xs font-semibold text-gray-800">{{ formatDate(currentExchange.start_date) }}</p>
                </div>
                <div class="flex flex-row items-center">
                    <p class="text-md font-bold text-gray-800">{{ currentExchange.origin }}</p>
                    <div class="ml-1 mt-1 flex items-center rounded-md bg-gray-200 p-1">
                        <Users :size="16" class="mr-1 text-gray-600" />
                        <span class="text-xs text-gray-500">{{ currentExchange.users?.length ?? 0 }}</span>
                    </div>
                </div>
                <div class="text-center">
                    <p class="text-xs font-semibold text-gray-800">{{ formatDate(currentExchange.end_date) }}</p>
                </div>
            </div>
            <div v-else class="text-center text-sm text-gray-500">
                No n'hi han intercanvis
            </div>
        </div>

        <div class="bg-white p-4">
            <div v-if="activity.length === 0" class="py-8 text-center">
                <p class="text-gray-500">No hay actividades</p>
            </div>
            <div v-else>
                <div v-for="(activities, date) in groupedActivities()" :key="date" class="mb-6">
                    <p class="mb-3 text-sm font-bold text-gray-700">{{ new Date(date).toLocaleDateString('ca-ES', { weekday: 'long', day: 'numeric', month: 'long' }) }}</p>
                    <div class="space-y-2">
                        <div v-for="activity in activities" :key="activity.id" class="overflow-hidden rounded-lg border border-gray-200">
                            <button @click="toggleExpand(activity.id)" class="flex w-full items-center justify-between p-3 transition hover:bg-gray-50">
                                <ChevronDown :class="['text-gray-400 transition-transform duration-300', expandedId === activity.id ? 'rotate-180' : '']" :size="20" />
                                <div class="flex-1 flex flex-col items-start px-2">
                                    <p class="text-xs text-gray-600">{{ formatTime(activity.start_date) }} - {{ formatTime(activity.end_date) }}</p>
                                </div>
                                <p class="flex-1 text-sm font-semibold text-gray-800">{{ activity.title }}</p>
                                <div class="flex items-center gap-2">
                                    <button class="rounded p-1 hover:bg-gray-100" @click.stop>
                                        <Pencil :size="16" class="text-gray-600" />
                                    </button>
                                    <button class="rounded p-1 hover:bg-gray-100" @click.stop>
                                        <Trash :size="16" class="text-gray-600" />
                                    </button>
                                </div>
                            </button>
                            <div v-show="expandedId === activity.id" class="border-t border-gray-200 bg-gray-50 px-3 py-2">
                                <p class="text-xs text-gray-600"><strong>Descripción:</strong> {{ activity.description || '—' }}</p>
                                <p class="mt-1 text-xs text-gray-600"><strong>Tipo:</strong> {{ activity.type }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>