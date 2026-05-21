<script setup lang="ts">
import AppNavbar from '@/components/AppNavbar.vue';
</script>

<template>
    <div class="bg-hipatia-bg flex min-h-screen flex-col">
        <AppNavbar />
        <div class="pt-24">
            <slot />
        </div>
    </div>
</template>
