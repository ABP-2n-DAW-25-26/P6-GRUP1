<script setup lang="ts">
defineProps<{
    role: string;
}>();

const colors: Record<string, { color: string; background: string }> = {
    admin:   { color: 'var(--color-hp-role-admin)',   background: 'var(--color-hp-role-admin-bg)' },
    teacher: { color: 'var(--color-hp-role-teacher)', background: 'var(--color-hp-role-teacher-bg)' },
    student: { color: 'var(--color-hp-role-student)', background: 'var(--color-hp-role-student-bg)' },
};
</script>

<template>
    <span
        class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold"
        :style="colors[role]"
    >
        {{ role }}
    </span>
</template>
