<script setup lang="ts">
import { ChevronDown, Eye, Trash, Users, MonitorCog, UserPlus } from 'lucide-vue-next';
import { ref } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import PageTopBar from '@/components/PageTopBar.vue';

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
    exchange?: Exchange | null;
}>();

const expandedId = ref<number | null>(null);
const isCreateMenuOpen = ref(false);
const isUploadModalOpen = ref(false);
const fileInput = ref<HTMLInputElement | null>(null);
const selectedFile = ref<File | null>(null);
const isUploadingCsv = ref(false);
const uploadError = ref('');
const currentExchange = props.exchange ?? props.activity[0]?.exchange ?? null;

const toggleExpand = (id: number) => {
    expandedId.value = expandedId.value === id ? null : id;
};

const toggleCreateMenu = () => {
    isCreateMenuOpen.value = !isCreateMenuOpen.value;
};

const openUploadModal = () => {
    isUploadModalOpen.value = true;
};

const closeUploadModal = () => {
    isUploadModalOpen.value = false;
    selectedFile.value = null;
    uploadError.value = '';
    if (fileInput.value) {
        fileInput.value.value = '';
    }
};

const selectFile = () => {
    fileInput.value?.click();
};

const handleFileSelect = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files?.length) {
        selectedFile.value = target.files[0];
        uploadError.value = '';
    }
};

const submitCsv = () => {
    if (!currentExchange?.id) {
        uploadError.value = 'No hay intercambio seleccionado';
        return;
    }

    if (!selectedFile.value) {
        uploadError.value = 'Por favor selecciona un archivo CSV';
        return;
    }

    isUploadingCsv.value = true;
    const formData = new FormData();
    formData.append('import_csv', selectedFile.value);

    router.post(`/exchange/${currentExchange.id}/addUser`, formData, {
        forceFormData: true,
        onSuccess: () => {
            closeUploadModal();
        },
        onError: (errors) => {
            const csvError = errors.import_csv;
            uploadError.value = Array.isArray(csvError)
                ? csvError[0]
                : (csvError ?? 'Error al importar el archivo');
        },
        onFinish: () => {
            isUploadingCsv.value = false;
        },
    });
};

const createOptions = [
    { label: 'Visita guiada', path: '/guidedactivity' },
    { label: 'Anunci', path: currentExchange?.id ? `/exchange/${currentExchange.id}/post/create` : '#' },
    { label: "Punt d'interes", path: '/admin/activity/create/interestPoint' },
    { label: 'Gimcana', path: '/admin/activity/create/gimcana'},
];

const formatTime = (value: string | null | undefined): string => {
    if (!value) return '--:--';
    const parts = value.split(/[Time ]/);
    const timePart = parts[1];
    return timePart ? timePart.slice(0, 5) : '--:--';
};

const formatDate = (value: string | null | undefined): { weekday: string; date: string } => {
    if (!value) return { weekday: '—', date: '' };

    const date = new Date(value);
    if (Number.isNaN(date.getTime())) return { weekday: '—', date: '' };

    const weekday = date.toLocaleDateString('ca-ES', { weekday: 'long' });
    const dateStr = date.toLocaleDateString('ca-ES', { day: 'numeric', month: 'long' });

    return { weekday, date: dateStr };
};

const groupedActivities = () => {
    const grouped: { [key: string]: Activity[] } = {};
    props.activity.forEach(act => {
        const date = act.start_date.split(/[Time ]/)[0];
        if (!grouped[date]) grouped[date] = [];
        grouped[date].push(act);
    });
    return grouped;
};


defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Intercanvis',
                // href: schedule(),
            },
        ],
    },
});
</script>

<template>
    <div class="sm:min-h-screen lg:min-w-full lg:min-h-full">
        <div class="lg:min-w-full sm:mx-auto sm:max-w-4xl lg:max-w-0 sm:mt-3 lg:mt-0 sm:ml-3 lg:ml-0 sm:mr-3 lg:mr-0">
            <div class="lg:border sm:border-b sm:rounded-t-xl border-gray-200 bg-hp-bg-card lg:rounded-xl lg:m-4 p-4">
                <div v-if="currentExchange" class="flex flex-row items-center justify-between">
                    <div class="text-center">
                        <p class="text-xs lg:text-lg font-semibold uppercase">{{ formatDate(currentExchange.start_date).weekday }}</p>
                        <p class="text-[10px] lg:text-sm text-hp-text-dim">{{ formatDate(currentExchange.start_date).date }}</p>
                    </div>
                    <hr class="lg:w-full lg:mx-4">
                    <div class="flex flex-row items-center w-full justify-center">
                        <p class="text-md lg:text-xl font-bold text-hp-text">{{ currentExchange.origin }}</p>
                    </div>
                    <hr class="lg:w-full lg:mx-4">
                    <div class="text-center">
                        <p class="text-xs lg:text-lg font-semibold text-hp-primary-dark uppercase">{{ formatDate(currentExchange.end_date).weekday }}</p>
                        <p class="text-[10px] lg:text-sm text-hp-text-dim">{{ formatDate(currentExchange.end_date).date }}</p>
                    </div>
                </div>
                <div v-else class="text-center text-sm text-hp-text-dim">
                    No n'hi han intercanvis
                </div>
            </div>

            <div class="bg-hp-bg-card p-4 relative rounded-b-xl">
                <div v-if="activity.length === 0" class="py-8 text-center">
                    <p class="text-gray-500">No hay actividades</p>
                </div>
                <div v-else>
                    <div v-for="(activities, date) in groupedActivities()" :key="date" class="mb-6">
                        <p class="mb-3 lg:text-lg sm:text-sm font-bold text-hp-text">{{ new Date(date).toLocaleDateString('ca-ES', { weekday: 'long', day: 'numeric', month: 'long' }) }}</p>
                        <div class="space-y-2">
                            <div v-for="activity in activities" :key="activity.id" class="overflow-hidden rounded-lg border bg-stone-100 border-gray-200">
                                <button @click="toggleExpand(activity.id)" class="flex w-full items-center justify-between p-3 transition hover:bg-gray-50">
                                    <!-- <ChevronDown :class="['text-gray-400 transition-transform duration-300', expandedId === activity.id ? 'rotate-180' : '']" :size="20" /> -->
                                    <div class="flex flex-row items-center">
                                        <div class="flex flex-col items-start">
                                            <p class="text-xl font-hp font-bold text-hp-text">{{ formatTime(activity.start_date) }} </p>
                                            <p class="text-md font-hp text-hp-text-dim">{{ formatTime(activity.end_date) }}</p>
                                        </div>
                                        <p class="flex ml-5 text-sm font-semibold text-hp-text">{{ activity.title }}</p>
                                    </div>
                                    <div v-if="activity.type === 'post'" class="flex items-center gap-2">
                                        <Link :href="`${currentExchange?.id}/post/${activity.id}`" class="rounded p-1 hover:bg-gray-100">
                                            <Eye :size="16" class="text-hp-icon" />post
                                        </Link>
                                    </div>
                                    <div v-if="activity.type === 'interest_point'" class="flex items-center gap-2">
                                        <Link :href="`${currentExchange?.id}/interestpoint/${activity.id}`" class="rounded p-1 hover:bg-gray-100">
                                            <Eye :size="16" class="text-hp-icon" />interest point
                                        </Link>
                                    </div>
                                    <div v-if="activity.type === 'guided_visit'" class="flex items-center gap-2">
                                        <Link :href="`${currentExchange?.id}/guidedactivity/${activity.id}`" class="rounded p-1 hover:bg-gray-100">
                                            <Eye :size="16" class="text-hp-icon" />guided visit
                                        </Link>
                                    </div>
                                    <div v-if="activity.type === 'gimcana'" class="flex items-center gap-2">
                                        <Link :href="`${currentExchange?.id}/gimcana/${activity.id}`" class="rounded p-1 hover:bg-gray-100">
                                            <Eye :size="16" class="text-hp-icon" />gimcana
                                        </Link>
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
        <div class="fixed bottom-8 right-5 z-50 flex flex-col items-end gap-3 animate-">
            <div v-show="isCreateMenuOpen" class="flex flex-col gap-2 rounded-2xl p-2 shadow-xl transform-3d transition-all items-center border border-hp-primary bg-hp-bg-card px-4 py-2 text-sm font-semibold text-hp-text">
                <a v-for="option in createOptions" :key="option.path" :href="option.path"
                    class="min-w-40 px-4 py-3 text-left text-sm font-medium text-hp-text transition hover:bg-hp-primary/20 hover:rounded-t-lg border-b border-hp-primary/40 last:border-b-0 w-full">
                    {{ option.label }}
                </a>
            </div>
        </div>
    </div>
</template>