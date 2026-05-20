<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Plus, Search } from 'lucide-vue-next';
import { ref, onMounted } from 'vue';
import { useConfirmDelete } from '@/composables/useConfirmDelete';
import AppLayout from '@/layouts/AppLayout.vue';
import UserCard from './components/UserCard.vue';
import { destroy, show, edit, create } from '@/routes/admin';

const props = defineProps<{
    users: Array<any>;
    stats: {
        users: number;
        exchanges: number;
        activities: number;
        themes: number;
    };
}>();

defineOptions({ layout: AppLayout });

const { confirmDelete } = useConfirmDelete();

const deleteUser = (id: number) => {
    confirmDelete(() => router.delete(destroy(id)), {
        title: 'Eliminar usuari?',
    });
};

const searchQuery = ref('');
const visibleUsers = ref<typeof props.users>([]);
const noResults = ref(false);

onMounted(() => {
    // Show all users
    visibleUsers.value = props.users;
    noResults.value = false;
});

function onSearch() {
    const search = searchQuery.value.toLowerCase().trim();

    if (!search) {
        visibleUsers.value = props.users;
        noResults.value = false;
        return;
    }

    // Filter by name
    const results = props.users.filter((u) =>
        u.name?.toLowerCase().includes(search),
    );

    visibleUsers.value = results;
    noResults.value = results.length === 0;
}
</script>

<template>
    <Head title="Tauler d'administració" />

    <div class="flex h-full flex-1 flex-col gap-6 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-hp-text">
                    Tauler d'administració
                </h1>
                <p class="mt-1 text-sm text-hp-text-dim">
                    Gestió global de la plataforma.
                </p>
            </div>
            <Link
                :href="create()"
                class="inline-flex items-center gap-2 rounded-xl bg-hp-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:opacity-90 active:scale-95"
            >
                <Plus class="h-4 w-4" />
                Nou usuari
            </Link>
        </div>

        <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
            <div
                v-for="[label, value] in [
                    ['Usuaris', stats.users],
                    ['Intercanvis', stats.exchanges],
                    ['Activitats', stats.activities],
                    ['Temes', stats.themes],
                ]"
                :key="label"
                class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm"
            >
                <p class="text-2xl font-bold text-hp-text">{{ value }}</p>
                <p class="mt-1 text-xs text-hp-text-dim">{{ label }}</p>
            </div>
        </div>

        <div class="relative max-w-sm">
            <Search class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" />
            <input
                id="search-users"
                v-model="searchQuery"
                type="text"
                placeholder="Cerca usuaris per nom..."
                class="w-full rounded-xl border border-gray-200 bg-white py-2.5 pl-9 pr-4 text-sm shadow-sm focus:border-hp-primary focus:outline-none focus:ring-1 focus:ring-hp-primary"
                @input="onSearch"
            />
        </div>

        <div
            v-if="visibleUsers.length > 0"
            class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
        >
            <UserCard
                v-for="user in visibleUsers"
                :key="user.id"
                :user="user"
                :show-href="show(user.id).url"
                :edit-href="edit(user.id).url"
                @delete="deleteUser"
            />
        </div>

        <div
            v-else-if="noResults"
            id="no-results"
            class="rounded-xl border border-dashed border-gray-200 bg-white p-12 text-center text-sm text-hp-text-dim"
        >
            No s'han trobat usuaris amb "{{ searchQuery }}".
        </div>

        <!-- Default empty state (no search active) -->
        <div
            v-else-if="!searchQuery && users.length === 0"
            class="rounded-xl border border-dashed border-gray-200 bg-white p-12 text-center text-sm text-hp-text-dim"
        >
            No hi ha usuaris registrats.
        </div>
    </div>
</template>
