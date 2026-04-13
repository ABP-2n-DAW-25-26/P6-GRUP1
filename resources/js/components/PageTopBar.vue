<script setup lang="ts">
import type { Component } from 'vue';
import { Menu } from 'lucide-vue-next';
defineProps<{
    icon: Component;
    title: string;
}>();
</script>

<template>
    <header class="sticky top-0 z-40">
        <div class="flex items-center justify-between p-4">
            <div class="flex items-center">
                <div class="mr-3 rounded-lg bg-[#D8D9DC] p-2 text-[#5D5D5D]">
                    <component :is="icon" :size="24" />
                </div>
                <h1 class="text-xl font-bold text-[#181D1B]">{{ title }}</h1>
            </div>

            <div class="flex items-center gap-2">
                <slot name="actions" />
            </div>
            <button>
                <Menu :size="20" class="text-gray-600" />
            </button>
        </div>
    </header>
</template>