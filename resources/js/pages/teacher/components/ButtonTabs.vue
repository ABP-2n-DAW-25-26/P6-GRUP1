<script setup lang="ts">
import { ref } from 'vue';
import { schedule } from '@/routes';
import { show as activities } from '@/routes/exchange';
import { index as teachersIndex } from '@/routes/exchange/teacher';
import { index as studentsIndex } from '@/routes/exchange/student';
import { create as createPost } from '@/routes/exchange/post';
import { create as createGuided } from '@/routes/exchange/guidedactivity';
import { create as createInterest } from '@/routes/exchange/interestpoint';
// import { create as createGimcana } from '@/routes/exchange/activity/gimcana';
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

const showActivityOptions = ref(false);

const activityOptions = [
    { label: 'Anunci', href: (id: number) => createPost(id) },
    { label: 'Visita guiada', href: (id: number) => createGuided(id) },
    { label: "Punt d'interès", href: (id: number) => createInterest(id) },
    // { label: 'Gimcana', href: (id: number) => createGimcana(id) }
];

const handleActivityOption = (option: string) => {
    console.log('Selected activity:', option);
    showActivityOptions.value = false;
};

const emit = defineEmits([
    'assign-teacher',
    'assign-student',
]);
</script>
<template>
    <div class="flex flex-wrap gap-6 justify-between border-b px-2 mx-2 text-lg">
        <div v-if="exchange" class="flex *:px-2 *:md:px-4 *:text-gray-700 hover:text-gray-300 transition-colors duration-200">
            <Link :href="activities(exchange.id)" :class="props.activeTab === 'activities' ? activeClass : ''">
                Activitats</Link>
            <Link :href="teachersIndex(exchange.id)" :class="props.activeTab === 'teachers' ? activeClass : ''">
                Professors</Link>
            <Link :href="studentsIndex(exchange.id)" :class="props.activeTab === 'students' ? activeClass : ''">
                Alumnes</Link>
        </div>
        <div v-if="$props.activeTab === 'activities'" class="relative">
            <button @click="showActivityOptions = !showActivityOptions" class="text-nowrap inline-flex items-center gap-2 rounded-xl bg-hp-primary px-5 py-2.5 text-sm font-semibold
                text-white shadow-sm transition hover:opacity-90 active:scale-95">
                <Plus class="w-4 h-4" />
                Nova activitat
            </button>

            <div v-if="showActivityOptions"
                class="absolute top-full right-0 mt-2 flex flex-col gap-2 bg-white rounded-lg shadow-lg p-2 z-10">
                <Link v-for="option in activityOptions" :key="option.label" :href="option.href(exchange.id)"
                    class="px-4 py-2 text-left text-sm font-medium text-gray-700 hover:bg-hp-primary hover:text-white rounded-lg transition cursor-pointer"
                    @click="showActivityOptions = false">
                    {{ option.label }}
                </Link>
            </div>
        </div>
        <button v-else-if="$props.activeTab === 'teachers'" @click="emit('assign-teacher')" class="text-nowrap inline-flex items-center gap-2 rounded-xl bg-hp-primary px-5 py-2.5 text-sm font-semibold
            text-white shadow-sm transition hover:opacity-90 cursor-pointer active:scale-95">
            <Plus class="w-4 h-4" />
            Assigna professor
        </button>
        <button v-else-if="$props.activeTab === 'students'" @click="emit('assign-student')" class="text-nowrap inline-flex items-center gap-2 rounded-xl bg-hp-primary px-5 py-2.5 text-sm font-semibold
            text-white shadow-sm transition hover:opacity-90 cursor-pointer active:scale-95">
            <Plus class="w-4 h-4" />
            Importa CSV
        </button>
    </div>
</template>