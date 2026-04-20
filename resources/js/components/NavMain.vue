<script setup lang="ts">
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
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

const page = usePage<{ auth: { user: { name: string; role?: string; avatar?: string; image?: string } } }>();
const user = page.props.auth.user;
const { getInitials } = useInitials();
const userImage = computed(() => user.image || user.avatar || '');
const showUserImage = computed(() => userImage.value !== '');

const { isCurrentUrl } = useCurrentUrl();
</script>

<template>
    <SidebarGroup class="px-2 py-0">
        <div class="mb-4 mt-6 flex items-center gap-3 px-3">
            <Avatar class="h-14 w-14 overflow-hidden rounded-full">
                <AvatarImage v-if="showUserImage" :src="userImage" :alt="user.name" />
                <AvatarFallback class="rounded-full text-white dark:text-white font-bold">
                    {{ getInitials(user.name) }}
                </AvatarFallback>
            </Avatar>

            <div class="min-w-0">
                <div class="truncate text-xl font-semibold capitalize">
                    {{ user.name }}
                </div>
                <div v-if="user.role" class="truncate text-md text-hp-primary">
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
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarGroup>
</template>
