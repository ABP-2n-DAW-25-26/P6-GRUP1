<script setup lang="ts">
import { Head, Link, Form } from '@inertiajs/vue3';
import { Plus, Eye, Pencil, Trash2 } from 'lucide-vue-next';
import { ref, computed } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { destroy } from '@/routes/exchange';

interface Exchange {
    id: number;
    title: string;
    start_date: string;
    end_date: string;
    status: 'Actiu' | 'Finalitzat' | 'Pendent';
}

const props = defineProps<{ exchangesList: Exchange[] }>();

defineOptions({ layout: AppLayout });

// Regex per validar que la cerca no tingui símbols estranys
const safeSearchRegex = /^[A-Za-z0-9\s\-àáâãäåèéêëìíîïòóôõöùúûüÀÁÈÉÍÒÓÚÜçÇ]+$/;

const activeFilter = ref<'tots' | 'actius' | 'finalitzats'>('tots');
const deleteModalOpen = ref(false);
const exchangeToDelete = ref<Exchange | null>(null);

// AJAX
const searchQuery = ref('');
const exchanges = ref<Exchange[]>([...props.exchangesList]);

async function handleSearch() {
    if (!searchQuery.value.trim()) {
        exchanges.value = props.exchangesList;
        return;
    }

    if (!safeSearchRegex.test(searchQuery.value)) return;

    const response = await fetch(`/search/exchanges/${encodeURIComponent(searchQuery.value)}`);
    const data = await response.json();
    exchanges.value = data.exchanges;
}

const openDeleteModal = (exchange: Exchange) => {
    exchangeToDelete.value = exchange;
    deleteModalOpen.value = true;
};

const closeDeleteModal = () => {
    deleteModalOpen.value = false;
    exchangeToDelete.value = null;
};

const filteredExchanges = computed(() => {
    if (activeFilter.value === 'actius') return exchanges.value.filter((e) => e.status === 'Actiu');
    if (activeFilter.value === 'finalitzats') return exchanges.value.filter((e) => e.status === 'Finalitzat');
    return exchanges.value;
});

const statusClass: Record<string, string> = {
    Actiu: 'badge-actiu',
    Pendent: 'badge-pendent',
    Finalitzat: 'badge-finalitzat',
};
</script>

<template>
    <Head title="Llista Intercanvis" />

    <div class="flex h-full flex-1 flex-col gap-6 p-6">
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold text-hp-text">Llista intercanvis</h1>
            <Link
                href="/exchange/create"
                class="inline-flex items-center gap-2 rounded-xl bg-hp-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:opacity-90 active:scale-95"
            >
                <Plus class="h-4 w-4" />
                Nou intercanvi
            </Link>
        </div>

        <form @submit.prevent="handleSearch" class="flex items-center gap-2">
            <input
                v-model="searchQuery"
                @keyup="handleSearch"
                type="search"
                placeholder="Cerca intercanvis..."
                class="w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm text-hp-text shadow-sm outline-none transition focus:border-hp-primary"
            />
            <button
                type="submit"
                class="rounded-xl bg-hp-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:opacity-90"
            >
                Cerca
            </button>
        </form>

        <div class="flex gap-2">
            <button
                v-for="tab in ['tots', 'actius', 'finalitzats']"
                :key="tab"
                @click="activeFilter = tab as any"
                class="rounded-full border px-5 py-1.5 text-sm font-medium capitalize transition-all"
                :class="
                    activeFilter === tab
                        ? 'border-gray-300 bg-white text-hp-text shadow-sm'
                        : 'border-transparent text-hp-text-dim hover:text-hp-text'
                "
            >
                {{ tab.charAt(0).toUpperCase() + tab.slice(1) }}
            </button>
        </div>

        <div class="w-full overflow-x-auto rounded-xl border border-gray-200 bg-white shadow-sm">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="w-full px-8 py-4 text-left text-xs font-semibold tracking-widest text-gray-400 uppercase">
                            Intercanvi
                        </th>
                        <th class="w-36 px-4 py-4 text-left text-xs font-semibold tracking-widest whitespace-nowrap text-gray-400 uppercase">
                            Data inici
                        </th>
                        <th class="w-36 px-4 py-4 text-left text-xs font-semibold tracking-widest whitespace-nowrap text-gray-400 uppercase">
                            Data fi
                        </th>
                        <th class="w-32 px-4 py-4 text-left text-xs font-semibold tracking-widest text-gray-400 uppercase">
                            Estat
                        </th>
                        <th class="w-36 px-8 py-4 text-right text-xs font-semibold tracking-widest text-gray-400 uppercase">
                            Accions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="exchange in filteredExchanges"
                        :key="exchange.id"
                        class="border-b border-gray-100 transition-colors last:border-0 hover:bg-gray-50/60"
                    >
                        <td class="px-8 py-6">
                            <span class="font-semibold text-hp-text">{{ exchange.title }}</span>
                        </td>
                        <td class="px-4 py-6 whitespace-nowrap text-hp-text-dim">
                            {{ exchange.start_date }}
                        </td>
                        <td class="px-4 py-6 whitespace-nowrap text-hp-text-dim">
                            {{ exchange.end_date }}
                        </td>
                        <td class="px-4 py-6">
                            <span
                                class="inline-flex items-center rounded-full px-4 py-1.5 text-xs font-semibold"
                                :class="statusClass[exchange.status]"
                            >
                                {{ exchange.status }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center justify-end gap-2">
                                <Link
                                    :href="`/exchange/${exchange.id}`"
                                    class="rounded-lg p-2 text-hp-text-dim transition hover:bg-gray-100 hover:text-hp-text"
                                    title="Veure"
                                >
                                    <Eye class="h-4 w-4" />
                                </Link>
                                <Link
                                    :href="`/exchange/${exchange.id}/edit`"
                                    class="rounded-lg p-2 text-hp-text-dim transition hover:bg-gray-100 hover:text-hp-text"
                                    title="Editar"
                                >
                                    <Pencil class="h-4 w-4" />
                                </Link>
                                <button
                                    type="button"
                                    class="rounded-lg p-2 text-hp-text-dim transition hover:bg-red-50 hover:text-hp-red"
                                    title="Eliminar"
                                    @click="openDeleteModal(exchange)"
                                >
                                    <Trash2 class="h-4 w-4" />
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="filteredExchanges.length === 0">
                        <td colspan="5" class="px-8 py-24 text-center text-hp-text-dim">
                            No hi ha cap intercanvi.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div
            v-if="deleteModalOpen && exchangeToDelete"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4"
            @click.self="closeDeleteModal"
        >
            <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl">
                <Form
                    v-bind="destroy.form(exchangeToDelete.id)"
                    class="space-y-6"
                    :options="{ preserveScroll: true }"
                >
                    <div class="space-y-3">
                        <h2 class="text-lg font-semibold">Eliminar intercanvi</h2>
                        <p class="text-sm leading-6 text-gray-600">
                            Estàs segur de que desitges eliminar l'intercanvi
                            <strong>{{ exchangeToDelete.title }}</strong>? Aquesta acció no es pot desfer.
                        </p>
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button
                            type="button"
                            class="flex-1 rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:cursor-pointer hover:bg-gray-50"
                            @click="closeDeleteModal"
                        >
                            Cancel·lar
                        </button>
                        <button
                            type="submit"
                            class="flex-1 rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white transition hover:cursor-pointer hover:bg-red-500"
                        >
                            Eliminar
                        </button>
                    </div>
                </Form>
            </div>
        </div>
    </div>
</template>