<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';
import { ref } from 'vue';
import { show as activities } from '@/routes/exchange';
import { create as createGimcana } from '@/routes/exchange/gimcana';
import { create as createGuided } from '@/routes/exchange/guidedactivity';
import { create as createInterest } from '@/routes/exchange/interestpoint';
import { create as createPost } from '@/routes/exchange/post';
import { index as studentsIndex } from '@/routes/exchange/student';
import { index as teachersIndex } from '@/routes/exchange/teacher';
const activeClass =
    'font-bold border-b-3 border-hp-primary-dark text-hp-primary-dark!';

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

const showActivityOptions = ref(false);

const activityOptions = [
    { label: 'Anunci', href: (id: number) => createPost(id) },
    { label: 'Visita guiada', href: (id: number) => createGuided(id) },
    { label: "Punt d'interès", href: (id: number) => createInterest(id) },
    { label: 'Gimcana', href: (id: number) => createGimcana(id) },
];

const emit = defineEmits(['assign-teacher', 'assign-student']);
</script>
<template>
    <div
        class="mx-2 flex flex-wrap justify-between gap-6 border-b px-2 text-lg"
    >
        <div
            v-if="exchange"
            class="flex transition-colors duration-200 *:px-2 *:text-gray-700 hover:text-gray-300 *:md:px-4"
        >
            <Link
                :href="activities(exchange.id)"
                :class="props.activeTab === 'activities' ? activeClass : ''"
            >
                Activitats</Link
            >
            <Link
                :href="teachersIndex(exchange.id)"
                :class="props.activeTab === 'teachers' ? activeClass : ''"
            >
                Professors</Link
            >
            <Link
                :href="studentsIndex(exchange.id)"
                :class="props.activeTab === 'students' ? activeClass : ''"
            >
                Alumnes</Link
            >
        </div>
        <div v-if="$props.activeTab === 'activities'" class="relative">
            <button
                @click="showActivityOptions = !showActivityOptions"
                class="inline-flex items-center gap-2 rounded-xl bg-hp-primary px-5 py-2.5 text-sm font-semibold text-nowrap text-white shadow-sm transition hover:opacity-90 active:scale-95"
            >
                <Plus class="h-4 w-4" />
                Nova activitat
            </button>

            <div
                v-if="showActivityOptions"
                class="absolute top-full right-0 z-10 mt-2 flex flex-col gap-2 rounded-lg bg-white p-2 shadow-lg"
            >
                <Link
                    v-for="option in activityOptions"
                    :key="option.label"
                    :href="option.href(exchange!.id)"
                    class="cursor-pointer rounded-lg px-4 py-2 text-left text-sm font-medium text-gray-700 transition hover:bg-hp-primary hover:text-white"
                    @click="showActivityOptions = false"
                >
                    {{ option.label }}
                </Link>
            </div>
        </div>
        <button
            v-else-if="$props.activeTab === 'teachers'"
            @click="emit('assign-teacher')"
            class="inline-flex cursor-pointer items-center gap-2 rounded-xl bg-hp-primary px-5 py-2.5 text-sm font-semibold text-nowrap text-white shadow-sm transition hover:opacity-90 active:scale-95"
        >
            <Plus class="h-4 w-4" />
            Assigna professor
        </button>
        <button
            v-else-if="$props.activeTab === 'students'"
            @click="emit('assign-student')"
            class="inline-flex cursor-pointer items-center gap-2 rounded-xl bg-hp-primary px-5 py-2.5 text-sm font-semibold text-nowrap text-white shadow-sm transition hover:opacity-90 active:scale-95"
        >
            <Plus class="h-4 w-4" />
            Importa CSV
        </button>
    </div>
</template>
