<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Bell, BookOpen, Calendar, FolderGit2, LayoutDashboard, LayoutGrid, PanelBottom, Repeat, Folder } from 'lucide-vue-next';
import AppLogo from '@/components/AppLogo.vue';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    SidebarGroupLabel,
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { schedule, home } from '@/routes';
import type { NavItem } from '@/types';
import { usePage } from '@inertiajs/vue3';

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
        title: 'Activitats guiades',
        href: "/guidedactivity",
        icon: BookOpen,
    },
    {
        title: 'Notificacions',
        href: "/notifications",
        icon: Bell,
    },
];

const footerNavItems: NavItem[] = [
];

const page = usePage();
const exchanges = page.props.exchanges;
</script>

<template>
    <Sidebar variant="inset">
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
        <SidebarGroupLabel class="ml-2">Intercanvis</SidebarGroupLabel>
        <div v-for="ex in exchanges" :key="ex.id" class="ml-2 pl-2 pb-4">
            <Link :href="`/exchange/${ex.id}`" class="flex flex-row gap-1 hover:bg-gray-200">
                <p  :style="{ color: ex.color }">
                    <Folder /> 
                </p>
                <p class="text-base">
                    {{ ex.title }}
                </p>
            </Link>
        </div>
        <SidebarFooter>

            <NavFooter :items="footerNavItems" />
            
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton as-child>
                        <Link :href="home()">
                            <LayoutGrid />
                            <span>Inici</span>
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
