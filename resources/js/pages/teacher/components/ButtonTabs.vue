<script setup lang="ts">
import { schedule } from '@/routes';
import { show as activities } from '@/routes/exchange';
import { index as teachersIndex } from '@/routes/exchange/teacher';
import { index as studentsIndex } from '@/routes/exchange/student';
import { Link } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';
const activeClass = 'font-bold border-b-3 border-hp-primary-dark text-hp-primary-dark!';

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
    activeTab: 'activities' | 'teachers' | 'students';
    exchange: Exchange | null;
}>();
</script>
<template>
    <div class="flex justify-between border-b px-2 mx-2 text-lg">
        <div v-if="exchange" class="flex gap-8 *:text-gray-700 hover:text-gray-300 transition-colors duration-200">
            <Link :href="activities(exchange.id)" :class="props.activeTab === 'activities' ? activeClass : ''">
                Activitats</Link>
            <Link :href="teachersIndex(exchange.id)" :class="props.activeTab === 'teachers' ? activeClass : ''">
                Professors</Link>
            <Link :href="studentsIndex(exchange.id)" :class="props.activeTab === 'students' ? activeClass : ''">
                Alumnes</Link>
        </div>
        <button v-if="$props.activeTab === 'activities'" "
            class=" inline-flex items-center gap-2 rounded-xl bg-hp-primary px-5 py-2.5 text-sm font-semibold
            text-white shadow-sm transition hover:opacity-90 active:scale-95">
            <Plus class="w-4 h-4" />
            Nova activitat
        </button>
        <Link v-else-if="$props.activeTab === 'teachers'"
            class=" inline-flex items-center gap-2 rounded-xl bg-hp-primary px-5 py-2.5 text-sm font-semibold
            text-white shadow-sm transition hover:opacity-90 active:scale-95">
            <Plus class="w-4 h-4" />
            Assigna professor
        </Link>
        <Link v-else-if="$props.activeTab === 'students'"
            class=" inline-flex items-center gap-2 rounded-xl bg-hp-primary px-5 py-2.5 text-sm font-semibold
            text-white shadow-sm transition hover:opacity-90 active:scale-95">
            <Plus class="w-4 h-4" />
            Assigna alumne
        </Link>
    </div>
</template>