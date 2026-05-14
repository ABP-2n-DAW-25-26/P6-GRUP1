<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';

defineOptions({ layout: AppLayout });
</script>

<template>
    <Head title="Notificacions" />
    <div class="p-6">
        <h1 class="mb-4 text-2xl font-semibold">Notificacions</h1>
        <p class="text-muted-foreground">Pròximament...</p>
    </div>
</template>
