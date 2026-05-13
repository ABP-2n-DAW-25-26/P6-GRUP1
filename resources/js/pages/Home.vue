<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';

defineOptions({ layout: PublicLayout });
</script>

<template>
    <Head title="Home" />
    <main class="flex items-center justify-center py-24">
        <h1 class="text-hipatia-text text-4xl font-bold">Home</h1>
    </main>
</template>
