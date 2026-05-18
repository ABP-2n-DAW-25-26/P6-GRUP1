<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Eye, Pencil, Trash2 } from 'lucide-vue-next';
import UserAvatar from './UserAvatar.vue';
import RoleBadge from './RoleBadge.vue';

defineProps<{
    user: any;
    showHref: string;
    editHref: string;
}>();

const emit = defineEmits<{
    delete: [id: number];
}>();
</script>

<template>
    <div class="flex flex-col rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition hover:shadow-md">

        <!-- Avatar + name -->
        <div class="flex items-center gap-3">
            <UserAvatar :name="user.name" size="sm" />
            <div class="min-w-0">
                <p class="truncate font-semibold text-hp-text">{{ user.name }}</p>
                <RoleBadge :role="user.role" />
            </div>
        </div>

        <!-- Info -->
        <div class="mt-3 space-y-1 border-t border-gray-100 pt-3 text-sm text-hp-text-dim">
            <p class="truncate">{{ user.email }}</p>
            <p class="truncate text-xs">{{ user.exchanges?.[0]?.title ?? 'Sense intercanvi' }}</p>
        </div>

        <!-- Actions -->
        <div class="mt-4 flex items-center justify-end gap-1">
            <Link
                :href="showHref"
                class="rounded-lg p-2 text-hp-text-dim transition hover:bg-gray-100 hover:text-hp-text"
                title="Veure"
            >
                <Eye class="h-4 w-4" />
            </Link>
            <Link
                :href="editHref"
                class="rounded-lg p-2 text-hp-text-dim transition hover:bg-gray-100 hover:text-hp-text"
                title="Editar"
            >
                <Pencil class="h-4 w-4" />
            </Link>
            <button
                @click="emit('delete', user.id)"
                class="rounded-lg p-2 text-hp-text-dim transition hover:bg-red-50 hover:text-red-500"
                title="Eliminar"
            >
                <Trash2 class="h-4 w-4" />
            </button>
        </div>
    </div>
</template>
