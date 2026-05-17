<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { edit, index } from '@/routes/admin';
import UserAvatar from './components/UserAvatar.vue';
import RoleBadge from './components/RoleBadge.vue';

defineProps<{
    user: any;
}>();

defineOptions({ layout: AppLayout });
</script>

<template>
    <Head title="Perfil d'usuari" />

    <div class="flex h-full flex-1 flex-col gap-6 p-6">

        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-hp-text">Perfil d'usuari</h1>
                <p class="mt-1 text-sm text-hp-text-dim">Informació detallada de l'usuari.</p>
            </div>
            <div class="flex items-center gap-2">
                <Link
                    :href="index()"
                    class="rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-hp-text shadow-sm transition hover:bg-gray-50"
                >
                    Tornar
                </Link>
                <Link
                    :href="edit(user.id)"
                    class="inline-flex items-center gap-2 rounded-xl bg-hp-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:opacity-90 active:scale-95"
                >
                    Editar
                </Link>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-4">

            <!-- Avatar card -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex flex-col items-center text-center">
                    <UserAvatar :name="user.name" size="lg" />
                    <h2 class="mt-4 text-lg font-semibold text-hp-text">{{ user.name }}</h2>
                    <p class="mt-1 text-sm text-hp-text-dim">{{ user.email }}</p>
                    <div class="mt-3">
                        <RoleBadge :role="user.role" />
                    </div>
                </div>

                <div class="mt-6 space-y-2 border-t border-gray-100 pt-4 text-sm text-hp-text-dim">
                    <p><span class="font-medium text-hp-text">ID:</span> {{ user.id }}</p>
                    <p><span class="font-medium text-hp-text">Registrat:</span> {{ new Date(user.created_at).toLocaleDateString('ca-ES') }}</p>
                </div>
            </div>

            <!-- Main content -->
            <div class="space-y-6 lg:col-span-3">

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-4">
                    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                        <p class="text-2xl font-bold text-hp-text">{{ user.exchanges.length }}</p>
                        <p class="mt-1 text-xs text-hp-text-dim">Intercanvis</p>
                    </div>
                    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                        <p class="text-2xl font-bold text-hp-text capitalize">{{ user.role }}</p>
                        <p class="mt-1 text-xs text-hp-text-dim">Rol</p>
                    </div>
                    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                        <p class="text-2xl font-bold text-green-600">Actiu</p>
                        <p class="mt-1 text-xs text-hp-text-dim">Estat</p>
                    </div>
                </div>

                <!-- Exchanges list -->
                <div class="rounded-2xl border border-gray-200 bg-white shadow-sm">
                    <div class="border-b border-gray-100 px-6 py-4">
                        <h3 class="font-semibold text-hp-text">Intercanvis</h3>
                    </div>
                    <div v-if="user.exchanges.length > 0" class="divide-y divide-gray-100">
                        <div
                            v-for="ex in user.exchanges"
                            :key="ex.id"
                            class="flex items-center justify-between px-6 py-4"
                        >
                            <div>
                                <p class="font-medium text-hp-text">{{ ex.title }}</p>
                                <p class="text-sm text-hp-text-dim">{{ ex.origin }} → {{ ex.destiny }}</p>
                            </div>
                        </div>
                    </div>
                    <div v-else class="px-6 py-8 text-center text-sm text-hp-text-dim">
                        Sense intercanvis assignats.
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>
