<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import {
    SidebarGroup,
    SidebarGroupLabel,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { useCurrentUrl } from '@/composables/useCurrentUrl';
import { useInitials } from '@/composables/useInitials';
import type { NavItem } from '@/types';

defineProps<{
    items: NavItem[];
}>();

const page = usePage<{
    auth: {
        user: { name: string; role?: string; avatar?: string; image?: string };
    };
    unreadNotifications: number;
}>();
const user = page.props.auth.user;
const unreadNotifications = computed(() => page.props.unreadNotifications ?? 0);
const { getInitials } = useInitials();
const userImage = computed(() => user.image || user.avatar || '');
const showUserImage = computed(() => userImage.value !== '');

const { isCurrentUrl } = useCurrentUrl();
</script>

<template>
    <SidebarGroup class="px-2 py-0">
        <div class="mt-6 mb-4 flex items-center gap-3 px-3">
            <Avatar class="h-14 w-14 overflow-hidden rounded-full">
                <AvatarImage
                    v-if="showUserImage"
                    :src="userImage"
                    :alt="user.name"
                />
                <AvatarFallback
                    class="rounded-full font-bold text-white dark:text-white"
                >
                    {{ getInitials(user.name) }}
                </AvatarFallback>
            </Avatar>

            <div class="min-w-0">
                <div class="truncate text-xl font-semibold capitalize">
                    {{ user.name }}
                </div>
                <div v-if="user.role" class="text-md truncate text-hp-primary">
                    {{ user.role }}
                </div>
            </div>
        </div>

        <SidebarGroupLabel>Menú</SidebarGroupLabel>
        <SidebarMenu>
            <SidebarMenuItem v-for="item in items" :key="item.title">
                <SidebarMenuButton
                    as-child
                    :is-active="isCurrentUrl(item.href)"
                    :tooltip="item.title"
                >
                    <Link :href="item.href">
                        <component :is="item.icon" />
                        <span>{{ item.title }}</span>
                        <span
                            v-if="item.href === '/notifications' && unreadNotifications > 0"
                            class="ml-auto rounded-full bg-hp-primary px-1.5 py-0.5 text-[10px] font-bold leading-none text-white"
                        >+1</span>
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarGroup>
</template>
