<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';
import Swal from 'sweetalert2';
import AppLayout from '@/layouts/AppLayout.vue';
import UserCard from './components/UserCard.vue';
import { destroy, show, edit, create } from '@/routes/admin';

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

// Delete user
const deleteUser = async (id: number) => {
    const result = await Swal.fire({
        title: 'Eliminar usuari?',
        text: 'Aquesta acció no es pot desfer.',
        showCancelButton: true,
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancel·lar',
        icon: undefined,
        background: '#fff',
        color: '#111827',
        buttonsStyling: false,
        customClass: {
            popup: 'rounded-xl border border-gray-100',
            title: 'text-base font-medium',
            htmlContainer: 'text-sm text-gray-400',
            confirmButton:
                'text-red-600 font-medium px-3 py-2 rounded-lg transition hover:bg-red-50 hover:text-red-700 focus:outline-none',
            cancelButton:
                'text-gray-500 px-3 py-2 rounded-lg transition hover:bg-gray-100 hover:text-gray-700 ml-2 focus:outline-none',
        },
    });

    if (result.isConfirmed) {
        router.delete(destroy(id), {
            onSuccess: () => {
                Swal.fire({
                    title: 'Eliminat',
                    timer: 1200,
                    showConfirmButton: false,
                    background: '#fff',
                    color: '#111827',
                    customClass: { popup: 'rounded-xl border border-gray-100' },
                });
            },
        });
    }
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
