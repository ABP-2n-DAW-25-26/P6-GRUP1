<script setup lang="ts">
import AppNavbar from '@/components/AppNavbar.vue';
</script>

<template>
    <div class="min-h-screen flex flex-col bg-hipatia-bg">
        <AppNavbar />
        <div class="pt-24">
            <slot />
        </div>
    </div>
</template>
