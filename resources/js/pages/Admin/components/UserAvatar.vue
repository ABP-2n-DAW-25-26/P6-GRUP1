<script setup lang="ts">
defineProps<{
    name: string;
    size?: 'sm' | 'md' | 'lg';
}>();
</script>

<template>
    <div
        class="flex shrink-0 items-center justify-center rounded-full bg-hp-primary/10 font-bold text-hp-primary"
        :class="{
            'h-9 w-9 text-sm': size === 'sm' || !size,
            'h-12 w-12 text-base': size === 'md',
            'h-16 w-16 text-2xl': size === 'lg',
        }"
    >
        {{ name.charAt(0).toUpperCase() }}
    </div>
</template>
