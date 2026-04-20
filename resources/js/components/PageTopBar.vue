<script setup lang="ts">
import type { Component } from 'vue';
import { Menu } from 'lucide-vue-next';
defineProps<{
    icon: Component;
    title: string;
}>();
</script>

<template>
    <header class="sticky bg-hipatia-primary top-0 z-40">
        <div class="flex items-center justify-between p-4">
            <div class="flex items-center">
                <div class="mr-3 rounded-lg bg-hp-bg-icon p-2 text-hp-icon">
                    <component :is="icon" :size="24" />
                </div>
                <h1 class="text-xl font-bold text-hp-text">{{ title }}</h1>
            </div>

            <div class="flex items-center gap-2">
                <slot name="actions" />
            </div>
        </div>
    </header>
</template>