<script setup lang="ts">
import { ChevronDown, Pencil, Eye, Trash, Users, MonitorCog, UserPlus, User2Icon, UserCog, Search } from 'lucide-vue-next';
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

interface Teacher {
    id: number;
    name: string;
    email: string;
}

interface ExchangeTeachers {
    users: Teacher[];
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
    studentsCount: number;
}>();

const expandedId = ref<number | null>(null);
const isCreateMenuOpen = ref(false);
const isStudentModalOpen = ref(false);
const isTeacherModalOpen = ref(false);
const teacherSearchData = ref<Teacher[]>([]);
const exchangeTeachers = ref<ExchangeTeachers | null>(null);
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

const openStudentModal = () => {
    isStudentModalOpen.value = true;
};
const openTeacherModal = () => {
    isTeacherModalOpen.value = true;
    loadExchangeTeachers();
};


const closeStudentModal = () => {
    isStudentModalOpen.value = false;
    selectedFile.value = null;
    uploadError.value = '';
    if (fileInput.value) {
        fileInput.value.value = '';
    }
};
const closeTeacherModal = () => {
    isTeacherModalOpen.value = false;
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

const getActivityDescription = (activity: Activity): string => {
    const description = activity.description?.trim();
    if (!description) return '—';

    if (activity.type !== 'post') return description;

    const withoutHtmlTags = description
        .replace(/<style[\s\S]*?<\/style>/gi, ' ')
        .replace(/<script[\s\S]*?<\/script>/gi, ' ')
        .replace(/<[^>]+>/g, ' ')
        .replace(/\s+/g, ' ')
        .trim();

    return withoutHtmlTags || '—';
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

    //console log para ver el csv
    console.log('Enviando CSV:', selectedFile.value);

    router.post(`/exchange/${currentExchange.id}/addUser`, formData, {
        forceFormData: true,
        onSuccess: () => {
            closeStudentModal();
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

const teacherSearch = (event: KeyboardEvent) => {
    const target = event.target as HTMLInputElement;
    const query = target.value.trim();
    if (query.length === 0) {
        teacherSearchData.value = [];
        return;
    }
    if (!currentExchange?.id) {
        console.error('No hay intercambio seleccionado');
        return;
    }
    fetch(`/teacher/search/` + encodeURIComponent(query) + `?exchangeId=${currentExchange.id}`)
        .then(response => response.json())
        .then(message => {
            console.log('profes:', message.teachers);
            teacherSearchData.value = message.teachers;
            console.log('teacherSearchData:', teacherSearchData.value);
        })
        .catch(error => {
            console.error('error profes:', error);
        });
};

const loadExchangeTeachers = () => {
    if (!currentExchange?.id) {
        console.error('No hay intercambio seleccionado');
        return;
    }
    fetch(`/exchange/${currentExchange.id}/teachers`)
        .then(response => response.json())
        .then(data => {
            exchangeTeachers.value = data;
            console.log('exchangeTeachers:', exchangeTeachers.value);
        })
        .catch(error => {
            console.error('Error al cargar profesores del intercambio:', error);
        });
};

const addTeacherToExchange = (teacherId: number, exchangeId: number) => {
    if (!exchangeId) {
        console.error('No hay intercambio seleccionado');
        return;
    }
    fetch(`/exchange/${exchangeId}/addTeacher/${teacherId}`)
        .then(response => response.json())
        .then(message => {
            console.log('addTeacherToExchange response:', message);
            teacherSearchData.value = [];
            loadExchangeTeachers();
        })
        .catch(error => {
            console.error('Error al añadir profesor al intercambio:', error);
        });
};

const removeTeacherFromExchange = (teacherId: number, exchangeId: number) => {
    if (!exchangeId) {
        console.error('No hay intercambio seleccionado');
        return;
    }
    fetch(`/exchange/${exchangeId}/removeTeacher/${teacherId}`, {
        method: 'DELETE',
    })
        .then(response => response.json())
        .then(message => {
            console.log('removeTeacherFromExchange response:', message);
            loadExchangeTeachers();
        })
        .catch(error => {
            console.error('Error al eliminar profesor del intercambio:', error);
        });
};
const createOptions = [
    { label: 'Visita guiada', path: '/guidedactivity' },
    { label: 'Anunci', path: currentExchange?.id ? `/exchange/${currentExchange.id}/post/create` : '#' },
    { label: "Punt d'interes", path: '/admin/activity/create/interestPoint' },
    { label: 'Gimcana', path: '/admin/activity/create/gimcana' },
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
        <!-- <PageTopBar :icon="MonitorCog" title="Intercanvi">
            <template #actions>
                <button
                    type="button"
                    @click="openStudentModal"
                    class="inline-flex items-center gap-2 rounded-full border border-hp-border bg-hp-bg-card px-4 py-2 text-sm font-semibold text-hp-text shadow-sm transition hover:bg-hp-secondary hover:border-hp-primary hover:shadow-md hover:shadow-hp-primary/60"
                >
                    <span class="flex h-8 w-8 items-center justify-center rounded-full text-hp-icon">
                        <UserPlus :size="17" />
                    </span>
                    <span class="hidden sm:inline">Afegir usuaris</span>
                </button>
            </template>
</PageTopBar> -->
        <div class="flex flex-row items-center justify-end gap-2 p-4">
            <div class="flex gap-8 items-center">
                <button type="button" @click="openTeacherModal"
                    class="text-sm sm:text-[16px] flex gap-3 items-center px-4 py-2 rounded-xl cursor-pointer bg-hp-primary font-medium text-white hover:bg-hp-primary-dark transition">
                    <UserCog :size="22" />
                    Afegir professors
                </button>
                <button type="button" @click="openStudentModal"
                    class="text-sm sm:text-[16px] flex gap-3 items-center px-4 py-2 rounded-xl cursor-pointer bg-hp-primary font-medium text-white hover:bg-hp-primary-dark transition">
                    <UserPlus :size="22" />
                    Afegir alumnes
                </button>
            </div>

            <div v-if="currentExchange" class="">
                <div class="flex items-center rounded-xl border border-gray-300 p-3">
                    <Users :size="16" class="mr-1 text-hp-text-dim" />
                    <span class="text-xs text-hp-text-dim">{{ props.studentsCount ?? 0 }}</span>
                </div>
            </div>
        </div>
        <div v-if="isStudentModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4"
            @click.self="closeStudentModal">
            <div class="w-full max-w-md rounded-xl bg-white p-5 shadow-xl">
                <div class="mb-4 items-center">
                    <h2 class="text-lg font-semibold text-gray-800">Importar alumnes amb CSV</h2>
                    <span class="ml-auto text-sm text-gray-500">El CSV ha de tenir el format: nom, cognom, email</span>
                </div>

                <form class="space-y-4" @submit.prevent="submitCsv">
                    <input ref="fileInput" type="file" accept=".csv,.txt" class="hidden" @change="handleFileSelect" />

                    <div class="rounded-lg border border-dashed border-gray-300 p-4 text-sm text-gray-700">
                        <p class="mb-3 truncate">{{ selectedFile?.name || 'Selecciona un arxiu CSV' }}</p>
                        <button type="button"
                            class="rounded-lg bg-hp-primary px-4 py-2 text-sm font-medium text-white hover:bg-hp-primary-dark"
                            @click="selectFile">
                            Escollir fitcher
                        </button>
                    </div>

                    <p v-if="uploadError" class="text-sm text-red-600">{{ uploadError }}</p>

                    <div class="flex justify-end gap-2">
                        <button type="button"
                            class="rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                            @click="closeStudentModal">
                            Cancelar
                        </button>
                        <button type="submit" :disabled="!selectedFile || isUploadingCsv"
                            class="rounded-lg bg-hp-primary px-4 py-2 text-sm font-semibold text-white disabled:cursor-not-allowed disabled:opacity-50">
                            {{ isUploadingCsv ? 'Importando...' : 'Importar CSV' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div v-if="isTeacherModalOpen"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4 h-auto transition-transform duration-300"
            @click.self="closeTeacherModal">
            <div class="w-full max-w-md rounded-xl bg-white p-5 shadow-xl">
                <div class="mb-4 flex flex-col gap-6 items-center">
                    <h2 class="text-lg font-semibold text-gray-800">Afegir professors</h2>
                    <div
                        class="group relative flex w-full items-center rounded-xl bg-gray-100 px-4 py-2 transition-all">
                        <Search :size="16" class="text-gray-400" />
                        <input type="text" placeholder="Cercar professors..." @keyup="teacherSearch"
                            class="ml-3 flex-1 bg-transparent text-sm outline-none placeholder:text-gray-400 md:text-base" />
                    </div>
                    <div class="w-full">
                        <p class="mb-2 text-sm font-semibold text-gray-800">Professors inscrits</p>
                        <span
                            v-if="exchangeTeachers && (!exchangeTeachers.users || exchangeTeachers.users.length === 0)"
                            class="text-sm text-gray-500">No hi han professors associats a aquest intercanvi</span>
                        <ul v-else-if="exchangeTeachers && exchangeTeachers.users && exchangeTeachers.users.length > 0"
                            class="mb-4 max-h-48 overflow-y-auto rounded-md border border-gray-200 bg-white shadow-sm w-full">
                            <li v-for="user in exchangeTeachers.users" :key="user.id"
                                class="flex items-center justify-between px-4 py-2 border-b border-gray-100 last:border-b-0">
                                <div class="flex flex-col gap-1">
                                    <span class="text-sm font-medium text-gray-800">{{ user.name }}</span>
                                    <span class="text-xs text-gray-500">{{ user.email }}</span>
                                </div>
                                <button
                                    class="rounded-md bg-red-500 px-3 py-1 text-sm font-medium text-white hover:bg-red-600 cursor-pointer transition"
                                    @click="currentExchange && removeTeacherFromExchange(user.id, currentExchange.id)">
                                    <Trash :size="16" />
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div v-if="teacherSearchData.length > 0" class="w-full">
                        <p class="mb-2 text-sm font-semibold text-gray-800">Resultats de la cerca</p>
                        <ul class="max-h-60 overflow-y-auto rounded-md border border-gray-200 bg-white shadow-sm">
                            <li v-for="teacher in teacherSearchData" :key="teacher.id"
                                class="flex items-center justify-between px-4 py-2 border-b border-gray-100 last:border-b-0">
                                <div class="flex flex-col gap-1">
                                    <span class="text-sm font-medium text-gray-800">{{ teacher.name }}</span>
                                    <span class="text-xs text-gray-500">{{ teacher.email }}</span>
                                </div>
                                <button
                                    class="rounded-md bg-hp-primary px-3 py-1 text-sm font-medium text-white hover:bg-hp-primary-dark cursor-pointer transition"
                                    @click="currentExchange && addTeacherToExchange(teacher.id, currentExchange.id)">
                                    <UserPlus :size="16" />
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

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
                            <div v-for="activity in activities" :key="activity.id"
                                class="overflow-hidden rounded-lg border bg-stone-100 border-gray-200">
                                <button @click="toggleExpand(activity.id)"
                                    class="flex w-full items-center justify-between p-3 transition hover:bg-gray-50">
                                    <!-- <ChevronDown :class="['text-gray-400 transition-transform duration-300', expandedId === activity.id ? 'rotate-180' : '']" :size="20" /> -->
                                    <div class="flex flex-row items-center">
                                        <div class="flex flex-col items-start">
                                            <p class="text-xl font-hp font-bold text-hp-text">{{
                                                formatTime(activity.start_date)
                                            }} </p>
                                            <p class="text-md font-hp text-hp-text-dim">{{ formatTime(activity.end_date)
                                            }}</p>
                                        </div>
                                        <div class="flex flex-col items-start ml-5">
                                            <p class="flex ml-5 text-sm font-semibold text-hp-primary">{{ activity.title }}</p>
                                            <p class="ml-3 text-xs font-medium font-hp text-hp-primary-dark uppercase">{{ activity.type }}</p>
                                        </div>
                                    </div>
                                    <div v-if="activity.type === 'post'" class="flex items-center gap-2">
                                        <Link :href="`/exchange/${currentExchange?.id}/post/${activity.id}/edit`" class="rounded p-1 hover:bg-hp-primary/20 ">
                                            <Pencil :size="16" class="text-hp-icon hover:text-hp-primary" />
                                        </Link>
                                        <Link :href="`/exchange/${currentExchange?.id}/post/${activity.id}`" class="rounded p-1 hover:text-primary-dark hover:bg-hp-primary-dark/20">
                                            <Eye :size="16" class="text-hp-icon hover:text-hp-primary-dark" />
                                        </Link>
                                        <button class="rounded p-1 hover:bg-hp-red/20 hover:text-hp-red">
                                            <Trash :size="16" class="text-hp-icon hover:text-hp-red" />
                                        </button>
                                    </div>
                                    <div v-if="activity.type === 'interest_point'" class="flex items-center gap-2">
                                        <Link :href="`/exchange/${currentExchange?.id}/interestpoint/${activity.id}/edit`" class="rounded p-1 hover:bg-hp-primary/20 ">
                                            <Pencil :size="16" class="text-hp-icon hover:text-hp-primary" />
                                        </Link>
                                        <Link :href="`/exchange/${currentExchange?.id}/interestpoint/${activity.id}`" class="rounded p-1 hover:text-primary-dark hover:bg-hp-primary-dark/20">
                                            <Eye :size="16" class="text-hp-icon hover:text-hp-primary-dark" />
                                        </Link>
                                        <button class="rounded p-1 hover:bg-hp-red/20 hover:text-hp-red">
                                            <Trash :size="16" class="text-hp-icon hover:text-hp-red" />
                                        </button>
                                    </div>
                                    <div v-if="activity.type === 'guided_visit'" class="flex items-center gap-2">
                                        <Link :href="`/exchange/${currentExchange?.id}/guidedactivity/${activity.id}/edit`" class="rounded p-1 hover:bg-hp-primary/20 ">
                                            <Pencil :size="16" class="text-hp-icon hover:text-hp-primary" />
                                        </Link>
                                        <Link :href="`/exchange/${currentExchange?.id}/guidedactivity/${activity.id}`" class="rounded p-1 hover:text-primary-dark hover:bg-hp-primary-dark/20">
                                            <Eye :size="16" class="text-hp-icon hover:text-hp-primary-dark" />
                                        </Link>
                                        <button class="rounded p-1 hover:bg-hp-red/20 hover:text-hp-red">
                                            <Trash :size="16" class="text-hp-icon hover:text-hp-red" />
                                        </button>
                                    </div>
                                    <div v-if="activity.type === 'gimcana'" class="flex items-center gap-2">
                                        <Link :href="`/exchange/${currentExchange?.id}/gimcana/${activity.id}/edit`" class="rounded p-1 hover:bg-hp-primary/20 ">
                                            <Pencil :size="16" class="text-hp-icon hover:text-hp-primary" />
                                        </Link>
                                        <Link :href="`/exchange/${currentExchange?.id}/gimcana/${activity.id}`" class="rounded p-1 hover:text-primary-dark hover:bg-hp-primary-dark/20">
                                            <Eye :size="16" class="text-hp-icon hover:text-hp-primary-dark" />
                                        </Link>
                                        <button class="rounded p-1 hover:bg-hp-red/20 hover:text-hp-red">
                                            <Trash :size="16" class="text-hp-icon hover:text-hp-red" />
                                        </button>
                                    </div>
                                </button>
                                <div v-show="expandedId === activity.id"
                                    class="border-t border-gray-200 bg-gray-50 px-3 py-2">
                                    <p class="text-xs text-gray-600"><strong>Descripción:</strong> {{ 
                                    getActivityDescription(activity) ||
                                        '—' }}</p>
                                    <p class="mt-1 text-xs text-gray-600"><strong>Tipo:</strong> {{ activity.type }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="fixed bottom-8 right-5 z-50 flex flex-col items-end gap-3 animate-">
            <div v-show="isCreateMenuOpen"
                class="flex flex-col gap-2 rounded-2xl p-2 shadow-xl transform-3d transition-all items-center border border-hp-primary bg-hp-bg-card px-4 py-2 text-sm font-semibold text-hp-text">
                <a v-for="option in createOptions" :key="option.path" :href="option.path"
                    class="min-w-40 px-4 py-3 text-left text-sm font-medium text-hp-text transition hover:bg-hp-primary/20 hover:rounded-t-lg border-b border-hp-primary/40 last:border-b-0 w-full">
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