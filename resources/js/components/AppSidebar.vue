<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Bell, BookOpen, Calendar, FolderGit2, LayoutDashboard, LayoutGrid, PanelBottom, Repeat } from 'lucide-vue-next';
import AppLogo from '@/components/AppLogo.vue';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { schedule } from '@/routes';
import type { NavItem } from '@/types';

const mainNavItems: NavItem[] = [
    {
        title: 'Agenda',
        href: schedule(),
        icon: Calendar,
    },
    {
        title: 'Panell de professor',
        href: "/teacher",
        icon: LayoutDashboard,
    },
    {
        title: 'Intercanvis',
        href: "/exchange",
        icon: Repeat,
    },
    {
        title: 'Notificacions',
        href: "/notifications",
        icon: Bell,
    },
];

const footerNavItems: NavItem[] = [
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="schedule()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
