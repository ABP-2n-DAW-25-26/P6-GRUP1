<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';

defineOptions({ layout: AppLayout });

interface Notification {
    id: number;
    type: string;
    message: string;
    read_at: string | null;
    created_at: string;
}

const props = defineProps<{ notifications: Notification[] }>();

const unread = () => props.notifications.filter((n: Notification) => !n.read_at);

function markAsRead(id: number) {
    router.post(`/notifications/${id}/read`);
}

function markAllAsRead() {
    router.post('/notifications/read-all');
}

function formatDate(date: string) {
    return new Date(date).toLocaleString('ca-ES');
}
</script>

<template>
    <Head title="Notificacions" />
    <div class="px-4 py-10 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-xl">

            <!-- Header -->
            <div class="mb-8 flex items-end justify-between border-b border-hp-border pb-4">
                <div>
                    <p class="text-xs font-medium uppercase tracking-widest text-hp-primary">Safata</p>
                    <h1 class="text-3xl font-semibold text-hp-text">Notificacions</h1>
                </div>
                <button
                    v-if="unread().length > 0"
                    @click="markAllAsRead"
                    class="text-xs text-hp-muted hover:text-hp-primary transition"
                >
                    Marcar totes com a llegides
                </button>
            </div>

            <!-- Empty state -->
            <div v-if="notifications.length === 0" class="py-20 text-center">
                <p class="text-lg font-medium text-hp-text">Tot net per aquí</p>
                <p class="mt-1 text-sm text-hp-muted">Quan rebis una notificació apareixerà aquí.</p>
            </div>

            <!-- List -->
            <ul v-else class="divide-y divide-hp-border">
                <li
                    v-for="n in notifications"
                    :key="n.id"
                    class="flex items-center justify-between gap-4 py-4 transition"
                >
                    <div class="flex min-w-0 items-center gap-3">
                        <span :class="['h-1.5 w-1.5 shrink-0 rounded-full', n.read_at ? 'bg-transparent' : 'bg-hp-primary']"></span>
                        <div class="min-w-0">
                            <p :class="['text-sm', n.read_at ? 'text-hp-muted' : 'font-medium text-hp-text']">{{ n.message }}</p>
                            <p class="mt-0.5 text-xs text-hp-primary">{{ formatDate(n.created_at) }}</p>
                        </div>
                    </div>
                    <button
                        v-if="!n.read_at"
                        @click="markAsRead(n.id)"
                        class="shrink-0 text-xs text-hp-primary hover:underline"
                    >
                        Llegida
                    </button>
                </li>
            </ul>

        </div>
    </div>
</template>
