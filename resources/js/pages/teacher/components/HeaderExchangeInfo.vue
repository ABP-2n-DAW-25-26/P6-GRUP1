<script setup lang="ts">

interface Exchange {
    id: number;
    title: string;
    origin: string;
    start_date: string;
    end_date: string | null;
    destiny: string;
    users?: { id: number }[];
}

const props = defineProps<{
    exchange?: Exchange | null;
}>();

const formatDate = (value: string | null | undefined): { weekday: string; date: string } => {
    if (!value) return { weekday: '—', date: '' };

    const date = new Date(value);
    if (Number.isNaN(date.getTime())) return { weekday: '—', date: '' };

    const weekday = date.toLocaleDateString('ca-ES', { weekday: 'long' });
    const dateStr = date.toLocaleDateString('ca-ES', { day: 'numeric', month: 'long' });

    return { weekday, date: dateStr };
};
</script>
<template>
    <div class="flex flex-col gap-4 w-full border rounded-lg p-4">
        <div v-if="exchange" class="flex flex-row items-center  w-full">
            <div class="text-center">
                <p class="font-semibold text-nowrap">{{ formatDate(exchange.start_date).date }}
                </p>
                <p class="text-sm text-gray-500">{{ formatDate(exchange.start_date).weekday }}</p>
            </div>
            <hr class="w-full mx-4">
            <div class="flex flex-row items-center w-full justify-center">
                <p
                    class="px-4 py-2 text-white bg-black bg-linear-to-br from-hp-primary-dark to-hp-secondary-dark/20 rounded-xl font-semibold text-xl w-max">
                    {{ exchange.title }}</p>
            </div>
            <hr class="w-full mx-4">
            <div class="text-center">
                <p class="font-semibold text-nowrap">{{
                    formatDate(exchange.end_date).date }}</p>
                <p class="text-sm text-gray-500">{{ formatDate(exchange.end_date).weekday }}</p>
            </div>
        </div>
        <div v-else class="text-center text-sm text-hp-text-dim">
            No hi ha activitats associades a aquest intercanvi. Crea una nova activitat per començar a planificar!
        </div>
    </div>
</template>