<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';

defineOptions({ layout: AppLayout });
</script>

<template>
    <Head title="Panell de professor" />
    <div class="p-6">
        <h1 class="text-2xl font-semibold mb-4">Panell de professor</h1>
        <p class="text-muted-foreground">Pròximament...</p>
    </div>
</template>
