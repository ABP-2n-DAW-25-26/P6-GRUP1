<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue';
import UserCard from './components/UserCard.vue';
import { destroy, show, edit, create } from '@/routes/admin';
import { useConfirmDelete } from '@/composables/useConfirmDelete';

defineProps<{
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
    confirmDelete(
        () => router.delete(destroy(id)),
        { title: 'Eliminar usuari?' },
    );
};
</script>

<template>
    <Head title="Tauler d'administració" />

    <div class="flex h-full flex-1 flex-col gap-6 p-6">
        <!-- Header -->
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

        <!-- Stats -->
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

        <!-- User cards -->
        <div
            v-if="users.length > 0"
            class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
        >
            <UserCard
                v-for="user in users"
                :key="user.id"
                :user="user"
                :show-href="show(user.id).url"
                :edit-href="edit(user.id).url"
                @delete="deleteUser"
            />
        </div>

        <!-- Empty state -->
        <div
            v-else
            class="rounded-xl border border-dashed border-gray-200 bg-white p-12 text-center text-sm text-hp-text-dim"
        >
            No hi ha usuaris registrats.
        </div>
    </div>
</template>