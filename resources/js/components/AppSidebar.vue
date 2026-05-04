<script setup lang="ts">
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { Bell, BookOpen, Calendar, LayoutDashboard, LayoutGrid, Repeat, Folder, Palette } from 'lucide-vue-next';
import AppLogo from '@/components/AppLogo.vue';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    SidebarGroup,
    SidebarGroupContent,
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
        title: 'Llistat intercanvis',
        href: "/exchanges",
        icon: Folder,
    },
    {
        title: 'Notificacions',
        href: "/notifications",
        icon: Bell,
    },
    {
        title: 'Temes',
        href: "/theme",
        icon: Palette,
    },
];

const footerNavItems: NavItem[] = [
];

type ExchangeSidebarItem = {
    id: number | string;
    title: string;
    color?: string | null;
};

const page = usePage<{ exchanges?: ExchangeSidebarItem[] }>();
const exchanges = computed(() => page.props.exchanges ?? []);
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
            <SidebarGroup class="px-2 py-0">
                <SidebarGroupLabel>Intercanvis</SidebarGroupLabel>
                <SidebarGroupContent>
                    <SidebarMenu>
                        <SidebarMenuItem v-for="ex in exchanges" :key="ex.id">
                            <SidebarMenuButton as-child>
                                <Link :href="`/exchange/${ex.id}`">
                                    <Folder :color="ex.color ?? undefined" />
                                    <span>{{ ex.title }}</span>
                                </Link>
                            </SidebarMenuButton>
                        </SidebarMenuItem>
                    </SidebarMenu>
                </SidebarGroupContent>
            </SidebarGroup>
        </SidebarContent>
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
