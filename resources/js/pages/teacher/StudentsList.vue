<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Eye, Trash2, Copy, X } from 'lucide-vue-next';
import { ref } from 'vue';
import ButtonTabs from './components/ButtonTabs.vue';
import HeaderExchangeInfo from './components/HeaderExchangeInfo.vue';
import { downloadCSV, importCSV } from '@/routes';

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
    students: any;
}>();

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Intercanvis',
            },
        ],
    },
});

const studentsList = ref([...props.students]);

const copied = ref<number | null>(null);

const copyEmail = async (email: string, id: number) => {
    await navigator.clipboard.writeText(email);

    copied.value = id;

    setTimeout(() => {
        copied.value = null;
    }, 1300);
};

const showAssignStudentModal = ref(false);

const removeStudentFromExchange = (studentId: number) => {
    if (!props.exchange?.id) {
        return;
    }

    fetch(`/exchange/${props.exchange.id}/student/${studentId}`, {
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
            studentsList.value = studentsList.value.filter(
                (t) => t.id !== studentId,
            );
        })
        .catch((err) => {
            console.error('Error removing student', err);
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
            :active-tab="'students'"
            :exchange="exchange"
            @assign-student="showAssignStudentModal = true"
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
                            Estudiant
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
                        v-for="student in studentsList"
                        :key="student.id"
                        class="border-b border-gray-100 transition-colors last:border-0 hover:bg-gray-50/60"
                    >
                        <td class="px-8 py-6">
                            <span class="font-semibold text-hp-text">
                                {{ student.name }} {{ student.surname }}
                            </span>
                        </td>

                        <td class="px-8 py-6">
                            <div class="relative flex items-center gap-4">
                                <span class="text-gray-800">
                                    {{ student.email }}
                                </span>

                                <button
                                    @click="
                                        copyEmail(student.email, student.id)
                                    "
                                    class="group relative text-gray-500 transition hover:text-gray-800"
                                >
                                    <Copy class="h-4 w-4" />

                                    <span
                                        class="absolute -top-8 left-1/2 -translate-x-1/2 rounded-md px-2 py-1 text-xs text-white opacity-0 transition group-hover:opacity-100"
                                        :class="
                                            copied === student.id
                                                ? 'bg-hp-primary opacity-100'
                                                : 'bg-black'
                                        "
                                    >
                                        {{
                                            copied === student.id
                                                ? 'Copiat!'
                                                : 'Copia'
                                        }}
                                    </span>
                                </button>
                            </div>
                        </td>

                        <td class="px-8 py-6">
                            <div class="flex items-center justify-end gap-2">

                                <button
                                    @click="
                                        removeStudentFromExchange(student.id)
                                    "
                                    class="cursor-pointer rounded-lg p-2 text-hp-text-dim transition hover:bg-red-50 hover:text-hp-red"
                                    title="Eliminar"
                                >
                                    <Trash2 class="h-4 w-4" />
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr v-if="studentsList.length === 0">
                        <td
                            colspan="5"
                            class="px-8 py-24 text-center text-hp-text-dim"
                        >
                            No hi ha cap estudiant assignat a aquest intercanvi.
                        </td>
                    </tr>
                </tbody>
            </table>

            <div
                v-if="showAssignStudentModal"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
            >
                <div
                    class="mx-4 w-full max-w-md rounded-2xl bg-white p-6 shadow-xl"
                >
                    <div class="mb-8">
                        <div class="flex items-center justify-between">
                            <h2 class="mr-auto text-lg font-semibold">
                                Importa un archiu CSV
                            </h2>
                            <button
                                @click="showAssignStudentModal = false"
                                class="cursor-pointer p-2 text-gray-400 hover:text-gray-700"
                                aria-label="close modal"
                            >
                                <X />
                            </button>
                        </div>
                        <p class="mr-auto text-sm text-gray-600">
                            Assegura't que el fitxer inclogui el nom, cognom i
                            correu electrònic
                        </p>
                    </div>
                    <Form
                        :action="importCSV().url"
                        method="post"
                        class="flex flex-col space-y-5"
                        enctype="multipart/form-data"
                    >
                        <div class="w-full">
                            <label
                                for="csv"
                                class="mb-2 block text-sm font-medium text-gray-900"
                            >
                                Pujar archiu
                            </label>

                            <input
                                id="csv"
                                type="file"
                                name="csv"
                                accept=".csv"
                                class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 file:mr-4 file:cursor-pointer file:border-0 file:bg-hp-primary file:px-4 file:py-2 file:text-sm file:font-medium file:text-white hover:file:bg-hp-primary-dark focus:ring-teal-500/20 focus:outline-none"
                            />
                        </div>
                        <input
                            type="hidden"
                            name="exchangeId"
                            :value="exchange?.id"
                        />
                        <button
                            type="submit"
                            class="w-full cursor-pointer rounded-lg bg-hp-primary px-6 py-1 text-white"
                        >
                            Enviar!
                        </button>
                    </Form>
                    <div class="mt-6">
                        <p class="text-sm text-gray-600">
                            En enviar el CSV, s’enviarà un correu electrònic als
                            estudiants amb les credencials d’accés a
                            l’aplicació.
                        </p>
                        <a
                            :href="downloadCSV().url"
                            class="text-sm text-gray-600 underline hover:text-gray-800"
                        >
                            Descarrega un fitxer CSV de mostra
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
