<script setup lang="ts">
import { ChevronDown, Pencil, Eye, Trash2, Users, MonitorCog, UserPlus, User2Icon, UserCog, Search, Plus, Copy } from 'lucide-vue-next';
import { ref } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import { schedule } from '@/routes';
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

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Intercanvis',
            },
        ],
    },
});

const copied = ref<number | null>(null);

const copyEmail = async (email: string, id: number) => {
    await navigator.clipboard.writeText(email);
    copied.value = id;

    setTimeout(() => {
        copied.value = null;
    }, 1300);
};
</script>

<template>

    <Head title="Agenda" />

    <div class="flex h-full flex-1 flex-col gap-8 overflow-x-hidden rounded-xl p-4">
        <HeaderExchangeInfo :exchange="exchange" />

        <ButtonTabs v-if="exchange" :active-tab="'teachers'" :exchange="exchange" />

        <div class="w-full overflow-x-auto rounded-xl border border-gray-200 bg-white shadow-sm">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="px-8 py-4 text-left text-xs font-semibold uppercase tracking-widest text-gray-400">
                            Professor</th>

                        <th
                            class="w-full px-8 py-4 text-left text-xs font-semibold uppercase tracking-widest text-gray-400">
                            Correu</th>

                        <th class="px-8 py-4 text-right text-xs font-semibold uppercase tracking-widest text-gray-400">
                            Accions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="teacher in teachers" :key="teacher.id"
                        class="border-b border-gray-100 transition-colors last:border-0 hover:bg-gray-50/60">
                        <td class="px-8 py-6">
                            <span class="font-semibold text-hp-text">{{ teacher.name }} {{ teacher.surname }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="relative flex items-center gap-4">
                                <span class="text-gray-800">
                                    {{ teacher.email }}
                                </span>

                                <button @click="copyEmail(teacher.email, teacher.id)"
                                    class="relative group text-gray-500 hover:text-gray-800 transition">
                                    <Copy class="w-4 h-4" />

                                    <span
                                        class="absolute left-1/2 -translate-x-1/2 -top-8 text-xs px-2 py-1 rounded-md text-white transition opacity-0 group-hover:opacity-100"
                                        :class="copied === teacher.id ? 'bg-hp-primary opacity-100' : 'bg-black'">
                                        {{ copied === teacher.id ? 'Copiat!' : 'Copia' }}
                                    </span>
                                </button>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center justify-end gap-2">
                                <Link
                                    class="rounded-lg p-2 text-hp-text-dim transition hover:bg-white hover:text-hp-text"
                                    title="Veure">
                                    <Eye class="w-4 h-4" />
                                </Link>
                                <button
                                    class="rounded-lg p-2 text-hp-text-dim transition hover:bg-red-50 hover:text-hp-red"
                                    title="Eliminar">
                                    <Trash2 class="w-4 h-4" />
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="teachers.length === 0">
                        <td colspan="5" class="px-8 py-24 text-center text-hp-text-dim">
                            No hi ha professors assignats a aquest intercanvi.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</template>