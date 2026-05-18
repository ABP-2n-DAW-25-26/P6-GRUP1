<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { update, show } from '@/routes/admin';

const props = defineProps<{ user: any }>();

defineOptions({ layout: AppLayout });

const form = useForm({
    name:  props.user.name,
    email: props.user.email,
    role:  props.user.role,
});

const submit = () => form.put(update(props.user.id).url);
</script>

<template>
    <Head title="Editar usuari" />

    <div class="flex h-full flex-1 flex-col gap-6 p-6">

        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-hp-text">Editar usuari</h1>
                <p class="mt-1 text-sm text-hp-text-dim">Modifica les dades de l'usuari.</p>
            </div>
            <Link
                :href="show(user.id)"
                class="rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-hp-text shadow-sm transition hover:bg-gray-50"
            >
                Cancel·lar
            </Link>
        </div>

        <!-- Form -->
        <div class="max-w-lg rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
            <div class="space-y-5">

                <div class="space-y-1.5">
                    <label class="text-xs font-semibold uppercase tracking-wide text-gray-400">Nom</label>
                    <input v-model="form.name" type="text" placeholder="Nom complet"
                        class="w-full rounded-lg border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-sm text-hp-text outline-none transition hover:bg-gray-100 focus:border-hp-primary focus:bg-white focus:ring-0" />
                    <p v-if="form.errors.name" class="text-xs text-red-500">{{ form.errors.name }}</p>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-semibold uppercase tracking-wide text-gray-400">Correu</label>
                    <input v-model="form.email" type="email" placeholder="correu@exemple.com"
                        class="w-full rounded-lg border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-sm text-hp-text outline-none transition hover:bg-gray-100 focus:border-hp-primary focus:bg-white focus:ring-0" />
                    <p v-if="form.errors.email" class="text-xs text-red-500">{{ form.errors.email }}</p>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-semibold uppercase tracking-wide text-gray-400">Rol</label>
                    <select v-model="form.role"
                        class="w-full rounded-lg border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-sm text-hp-text outline-none transition hover:bg-gray-100 focus:border-hp-primary focus:bg-white">
                        <option value="">Selecciona rol</option>
                        <option value="student">Student</option>
                        <option value="teacher">Teacher</option>
                        <option value="admin">Admin</option>
                    </select>
                    <p v-if="form.errors.role" class="text-xs text-red-500">{{ form.errors.role }}</p>
                </div>

            </div>

            <div class="mt-6 flex items-center justify-between border-t border-gray-100 pt-5">
                <p v-if="form.wasSuccessful" class="text-xs text-green-600">Desat correctament.</p>
                <div v-else />
                <button type="button" :disabled="form.processing" @click="submit"
                    class="inline-flex items-center gap-2 rounded-xl bg-hp-primary px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:opacity-90 active:scale-95 disabled:opacity-50">
                    {{ form.processing ? 'Desant...' : 'Guardar canvis' }}
                </button>
            </div>
        </div>

    </div>
</template>
