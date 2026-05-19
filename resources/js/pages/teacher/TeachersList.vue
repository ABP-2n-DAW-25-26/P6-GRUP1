<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Eye, Trash2, Copy, X } from 'lucide-vue-next';
import { ref } from 'vue';
import ButtonTabs from './components/ButtonTabs.vue';
import HeaderExchangeInfo from './components/HeaderExchangeInfo.vue';

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
    teachers: Array<{
        id: number;
        name: string;
        surname: string;
        email: string;
    }>;
}>();

const teachersList = ref([...props.teachers]);

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Intercanvis',
            },
        ],
    },
});
    const url = import.meta.env.VITE_APP_URL;
    console.log('URL', url);

const copied = ref<number | null>(null);

const copyEmail = async (email: string, id: number) => {
    await navigator.clipboard.writeText(email);
    copied.value = id;

    setTimeout(() => {
        copied.value = null;
    }, 1300);
};

interface Teacher {
    id: number;
    name: string;
    surname: string;
    email: string;
}

const showAssignTeacherModal = ref(false);
const searchTeacher = ref('');
const foundTeachers = ref<Teacher[]>([]);
const loadingTeachers = ref(false);

const searchTeachers = () => {
    if (!searchTeacher.value.trim()) {
        foundTeachers.value = [];

        return;
    }

    loadingTeachers.value = true;

    const query = searchTeacher.value;
    fetch(
        `/teacher/search?query=${encodeURIComponent(query)}&exchangeId=${props.exchange?.id}`,
    )
        .then((response) => response.json())
        .then((data) => {
            foundTeachers.value = data.teachers;
        })
        .catch((error) => {
            console.error('Error', error);
        })
        .finally(() => {
            loadingTeachers.value = false;
        });
};

const assignTeacher = (userId: number) => {
    if (!props.exchange?.id) {
        return;
    }

    const url = import.meta.env.VITE_APP_URL;

    fetch(`${url}/exchange/${props.exchange.id}/teacher/`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN':
                document
                    .querySelector('meta[name="csrf-token"]')
                    ?.getAttribute('content') || '',
            Accept: 'application/json',
        },
        body: JSON.stringify({
            user_id: userId,
        }),
    })
        .then((res) => res.json())
        .then(() => {
            // quitar de resultados búsqueda
            const teacher = foundTeachers.value.find((t) => t.id === userId);

            foundTeachers.value = foundTeachers.value.filter(
                (t) => t.id !== userId,
            );

            // añadir a tabla (mutación local)
            if (teacher) {
                teachersList.value.push(teacher);
            }
        })
        .catch((err) => {
            console.error('Error assigning teacher', err);
        });
};

const removeTeacherFromExchange = (teacherId: number) => {
    if (!props.exchange?.id) {
        return;
    }

    fetch(`/exchange/${props.exchange.id}/teacher/${teacherId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN':
                document
                    .querySelector('meta[name="csrf-token"]')
                    ?.getAttribute('content') || '',
            Accept: 'application/json',
        },
    })
        .then((res) => res.json())
        .then(() => {
            teachersList.value = teachersList.value.filter(
                (t) => t.id !== teacherId,
            );
        })
        .catch((err) => {
            console.error('Error removing teacher', err);
        });
};
</script>

<template>
    <Head title="Agenda" />

    <div
        class="flex h-full flex-1 flex-col gap-8 overflow-x-hidden rounded-xl p-4"
    >
        <HeaderExchangeInfo :exchange="exchange" />

        <ButtonTabs
            v-if="exchange"
            :active-tab="'teachers'"
            :exchange="exchange"
            @assign-teacher="showAssignTeacherModal = true"
        />
        <div
            class="w-full overflow-x-auto rounded-xl border border-gray-200 bg-white shadow-sm"
        >
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th
                            class="px-8 py-4 text-left text-xs font-semibold tracking-widest text-gray-400 uppercase"
                        >
                            Professor
                        </th>

                        <th
                            class="w-full px-8 py-4 text-left text-xs font-semibold tracking-widest text-gray-400 uppercase"
                        >
                            Correu
                        </th>

                        <th
                            class="px-8 py-4 text-right text-xs font-semibold tracking-widest text-gray-400 uppercase"
                        >
                            Accions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="teacher in teachersList"
                        :key="teacher.id"
                        class="border-b border-gray-100 transition-colors last:border-0 hover:bg-gray-50/60"
                    >
                        <td class="px-8 py-6">
                            <span class="font-semibold text-hp-text"
                                >{{ teacher.name }} {{ teacher.surname }}</span
                            >
                        </td>
                        <td class="px-8 py-6">
                            <div class="relative flex items-center gap-4">
                                <span class="text-gray-800">
                                    {{ teacher.email }}
                                </span>

                                <button
                                    @click="
                                        copyEmail(teacher.email, teacher.id)
                                    "
                                    class="group relative text-gray-500 transition hover:text-gray-800"
                                >
                                    <Copy class="h-4 w-4" />

                                    <span
                                        class="absolute -top-8 left-1/2 -translate-x-1/2 rounded-md px-2 py-1 text-xs text-white opacity-0 transition group-hover:opacity-100"
                                        :class="
                                            copied === teacher.id
                                                ? 'bg-hp-primary opacity-100'
                                                : 'bg-black'
                                        "
                                    >
                                        {{
                                            copied === teacher.id
                                                ? 'Copiat!'
                                                : 'Copia'
                                        }}
                                    </span>
                                </button>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center justify-end gap-2">
                                <Link
                                    class="rounded-lg p-2 text-hp-text-dim transition hover:bg-white hover:text-hp-text"
                                    title="Veure"
                                >
                                    <Eye class="h-4 w-4" />
                                </Link>
                                <button
                                    @click="
                                        removeTeacherFromExchange(teacher.id)
                                    "
                                    class="cursor-pointer rounded-lg p-2 text-hp-text-dim transition hover:bg-red-50 hover:text-hp-red"
                                    title="Eliminar"
                                >
                                    <Trash2 class="h-4 w-4" />
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="teachersList.length === 0">
                        <td
                            colspan="5"
                            class="px-8 py-24 text-center text-hp-text-dim"
                        >
                            No hi ha professors assignats a aquest intercanvi.
                        </td>
                    </tr>
                </tbody>
            </table>
            <div
                v-if="showAssignTeacherModal"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
            >
                <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl">
                    <div class="mb-4 flex items-center justify-between">
                        <h2 class="text-lg font-semibold">Assigna professor</h2>

                        <button
                            @click="showAssignTeacherModal = false"
                            class="p-2 text-gray-400 hover:text-gray-700"
                        >
                            <X />
                        </button>
                    </div>

                    <input
                        v-model="searchTeacher"
                        @keyup="searchTeachers"
                        type="text"
                        placeholder="Buscar professor..."
                        class="mb-4 w-full rounded-xl border border-gray-300 px-4 py-2"
                    />
                    <div class="max-h-72 space-y-2 overflow-y-auto">
                        <div
                            v-if="loadingTeachers"
                            class="py-4 text-center text-sm text-gray-500"
                        >
                            Buscant...
                        </div>

                        <div
                            v-for="teacher in foundTeachers"
                            :key="teacher.id"
                            class="flex items-center justify-between rounded-xl border p-3"
                        >
                            <div>
                                <p class="font-medium">
                                    {{ teacher.name }} {{ teacher.surname }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    {{ teacher.email }}
                                </p>
                            </div>

                            <button
                                class="cursor-pointer rounded-lg bg-hp-primary px-3 py-1 text-sm text-white"
                                @click="assignTeacher(teacher.id)"
                            >
                                Assignar
                            </button>
                        </div>

                        <div
                            v-if="
                                !loadingTeachers &&
                                foundTeachers.length === 0 &&
                                searchTeacher
                            "
                            class="py-4 text-center text-sm text-gray-500"
                        >
                            No s'han trobat professors
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
