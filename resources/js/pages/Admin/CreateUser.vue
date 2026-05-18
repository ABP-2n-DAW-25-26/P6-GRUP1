<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { store, index } from '@/routes/admin';
import UserFormCard from './components/UserFormCard.vue';

defineOptions({ layout: AppLayout });

const form = useForm({
    name: '',
    email: '',
    password: '',
    role: '',
});

const submit = () => {
    form.post(store().url);
};
</script>

<template>
    <Head title="Nou usuari" />

    <div class="flex h-full flex-1 flex-col gap-6 p-6">

        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-hp-text">Nou usuari</h1>
                <p class="mt-1 text-sm text-hp-text-dim">Completa les dades per crear un nou usuari.</p>
            </div>
            <Link
                :href="index()"
                class="rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-hp-text shadow-sm transition hover:bg-gray-50"
            >
                Cancel·lar
            </Link>
        </div>

        <UserFormCard
            :form="form"
            submit-label="Crear usuari"
            :with-password="true"
            @submit="submit"
        />

    </div>
</template>
