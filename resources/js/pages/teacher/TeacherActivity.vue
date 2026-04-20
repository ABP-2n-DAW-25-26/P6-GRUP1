<script setup lang="ts">
import { ChevronDown, Pencil, Trash, Users, MonitorCog, UserPlus } from 'lucide-vue-next';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
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
}>();

const expandedId = ref<number | null>(null);
const isCreateMenuOpen = ref(false);
const isUploadModalOpen = ref(false);
const fileInput = ref<HTMLInputElement | null>(null);
const selectedFile = ref<File | null>(null);
const isUploadingCsv = ref(false);
const uploadError = ref('');

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
    { label: 'Anunci', path: '/admin/activity/create/announcement' },
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
        <!-- <PageTopBar :icon="MonitorCog" title="Intercanvi">
            <template #actions>
                <button
                    type="button"
                    @click="openUploadModal"
                    class="inline-flex items-center gap-2 rounded-full border border-hp-border bg-hp-bg-card px-4 py-2 text-sm font-semibold text-hp-text shadow-sm transition hover:bg-hp-secondary hover:border-hp-primary hover:shadow-md hover:shadow-hp-primary/60"
                >
                    <span class="flex h-8 w-8 items-center justify-center rounded-full text-hp-icon">
                        <UserPlus :size="17" />
                    </span>
                    <span class="hidden sm:inline">Afegir usuaris</span>
                </button>
            </template>
        </PageTopBar> -->
        <div class="flex flex-row items-center justify-between p-4">
            <button
                type="button"
                @click="openUploadModal"
                class="inline-flex items-center gap-2 rounded-full border border-hp-border bg-hp-bg-card px-4 py-2 text-sm font-semibold text-hp-text shadow-sm transition hover:bg-hp-secondary hover:border-hp-primary hover:shadow-md hover:shadow-hp-primary/60"
            >
                <span class="flex h-8 w-8 items-center justify-center rounded-full text-hp-icon">
                    <UserPlus :size="17" />
                </span>
                <span class="hidden sm:inline">Afegir usuaris</span>
            </button>

            <div v-if="currentExchange" class="flex mb-1 mt-1 mr-1 flex-row items-center top-2 right-3 ">
                <div class="flex items-center rounded-md bg-hp-primary/40 p-1">
                    <Users :size="16" class="mr-1 text-hp-text-dim" />
                    <span class="text-xs text-hp-text-dim">{{ currentExchange.users?.length ?? 0 }}</span>
                </div>
            </div>
        </div>
        <div
            v-if="isUploadModalOpen"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4"
            @click.self="closeUploadModal"
        >
            <div class="w-full max-w-md rounded-xl bg-white p-5 shadow-xl">
                <div class="mb-4 flex items-center">
                    <h2 class="text-lg font-semibold text-gray-800">Importar usuaris amb CSV</h2>
                </div>

                <form class="space-y-4" @submit.prevent="submitCsv">
                    <input
                        ref="fileInput"
                        type="file"
                        accept=".csv,.txt"
                        class="hidden"
                        @change="handleFileSelect"
                    />

                    <div class="rounded-lg border border-dashed border-gray-300 p-4 text-sm text-gray-700">
                        <p class="mb-3 truncate">{{ selectedFile?.name || 'Selecciona un archivo CSV' }}</p>
                        <button
                            type="button"
                            class="rounded-lg bg-hp-primary px-4 py-2 text-sm font-medium text-white hover:bg-hp-primary-dark"
                            @click="selectFile"
                        >
                            Elegir archivo
                        </button>
                    </div>

                    <p v-if="uploadError" class="text-sm text-red-600">{{ uploadError }}</p>

                    <div class="flex justify-end gap-2">
                        <button
                            type="button"
                            class="rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                            @click="closeUploadModal"
                        >
                            Cancelar
                        </button>
                        <button
                            type="submit"
                            :disabled="!selectedFile || isUploadingCsv"
                            class="rounded-lg bg-hp-primary px-4 py-2 text-sm font-semibold text-white disabled:cursor-not-allowed disabled:opacity-50"
                        >
                            {{ isUploadingCsv ? 'Importando...' : 'Importar CSV' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="lg:min-w-full sm:mx-auto sm:max-w-4xl lg:max-w-0 sm:mt-3 lg:mt-0 sm:ml-3 lg:ml-0 sm:mr-3 lg:mr-0">
            <div class="lg:border sm:border-b sm:rounded-t-xl border-gray-200 bg-hp-bg-card lg:rounded-xl lg:m-4 p-4">
                <div v-if="currentExchange" class="flex flex-row items-center justify-between">
                    <div class="text-center">
                        <p class="text-xs font-semibold uppercase">{{ formatDate(currentExchange.start_date).weekday }}</p>
                        <p class="text-[10px] text-hp-text-dim">{{ formatDate(currentExchange.start_date).date }}</p>
                    </div>
                    <hr class="lg:w-full lg:mx-4">
                    <div class="flex flex-row items-center w-full justify-center">
                        <p class="text-md font-bold text-hp-text">{{ currentExchange.origin }}</p>
                    </div>
                    <hr class="lg:w-full lg:mx-4">
                    <div class="text-center">
                        <p class="text-xs font-semibold text-hp-primary-dark uppercase">{{ formatDate(currentExchange.end_date).weekday }}</p>
                        <p class="text-[10px] text-hp-text-dim">{{ formatDate(currentExchange.end_date).date }}</p>
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
                        <p class="mb-3 text-sm font-bold text-hp-text">{{ new Date(date).toLocaleDateString('ca-ES', { weekday: 'long', day: 'numeric', month: 'long' }) }}</p>
                        <div class="space-y-2">
                            <div v-for="activity in activities" :key="activity.id" class="overflow-hidden rounded-lg border bg-stone-100 border-gray-200">
                                <button @click="toggleExpand(activity.id)" class="flex w-full items-center justify-between p-3 transition hover:bg-gray-50">
                                    <!-- <ChevronDown :class="['text-gray-400 transition-transform duration-300', expandedId === activity.id ? 'rotate-180' : '']" :size="20" /> -->
                                    <div class="flex flex-row items-center">
                                        <div class="flex flex-col items-start px-2">
                                            <p class="text-md font-bold text-hp-text">{{ formatTime(activity.start_date) }} </p>
                                            <p class="text-xs text-hp-text-dim">{{ formatTime(activity.end_date) }}</p>
                                        </div>
                                        <p class="flex ml-5 text-sm font-semibold text-hp-text">{{ activity.title }}</p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button class="rounded p-1 hover:bg-gray-100">
                                            <Pencil :size="16" class="text-gray-600" />
                                        </button>
                                        <button class="rounded p-1 hover:bg-gray-100">
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
        <div class="fixed bottom-8 right-5 z-50 flex flex-col items-end gap-3 animate-">
            <div v-show="isCreateMenuOpen" class="flex flex-col gap-2 rounded-2xl p-2 shadow-xl transform-3d transition-all items-center border border-hp-primary bg-hp-bg-card px-4 py-2 text-sm font-semibold text-hp-text">
                <a v-for="option in createOptions" :key="option.path" :href="option.path"
                    class="min-w-40 px-4 py-3 text-left text-sm font-medium text-hp-text transition hover:bg-gray-100 border-b border-hp-primary/40 last:border-b-0 w-full">
                    {{ option.label }}
                </a>
            </div>

            <button type="button" @click="toggleCreateMenu" :aria-expanded="isCreateMenuOpen"
                :class="['create-toggle flex h-14 w-14 items-center justify-center rounded-full bg-hp-primary text-hp-text shadow-lg transition-all', { 'is-open': isCreateMenuOpen }]">
                <span class="create-toggle-line create-toggle-line-vertical"></span>
                <span class="create-toggle-line create-toggle-line-horizontal"></span>
            </button>
        </div>
    </div>
</template>
<style>
.create-toggle {
        position: relative;
}

.create-toggle-line {
        position: absolute;
        background: white;
        border-radius: 9999px;
        transition: transform 0.3s ease, opacity 0.3s ease;
}

.create-toggle-line-vertical {
        width: 3px;
        height: 22px;
}

.create-toggle-line-horizontal {
        width: 22px;
        height: 3px;
}

.create-toggle.is-open .create-toggle-line-vertical {
        opacity: 0;
        transform: scaleY(0.2);
}
</style>