<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { update, show } from '@/routes/admin';
import UserFormCard from './components/UserFormCard.vue';

const props = defineProps<{
    user: any;
}>();

defineOptions({ layout: AppLayout });

const form = useForm({
    name:  props.user.name,
    email: props.user.email,
    role:  props.user.role,
});

const submit = () => {
    form.put(update(props.user.id).url);
};
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

        <UserFormCard
            :form="form"
            submit-label="Guardar canvis"
            @submit="submit"
        />

    </div>
</template>
