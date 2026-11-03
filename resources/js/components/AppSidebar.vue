<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { BookOpen, FolderGit2, LayoutGrid } from '@lucide/vue';
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
import { dashboard } from '@/routes';
import type { NavItem } from '@/types';

const mainNavItems: NavItem[] = [
   {
        name: 'Dashboard',
        icon: LayoutGrid,
        route: '/here'
    },
    {
        name: 'Customer',
        icon: BookOpen,
        route: '/customerlist'
    },
    {
        name: 'Orders',
        icon: FolderGit2,
        route: '/order'
    },
    {
        name: 'Notifications',
        icon: FolderGit2,
        route: '/customer/support'
    },
    {
        name: 'Settings',
        icon: FolderGit2,
        route: '/customer/profile'
    },
];

const footerNavItems: NavItem[] = [
    {
        name: 'Repository',
        route: 'https://github.com/laravel/vue-starter-kit',
        icon: FolderGit2,
    },
    {
        name: 'Documentation',
        route: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="offcanvas" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" >
                       <div class="px-6 py-7 border-b border-slate-700" flex>                    
                            <h1 class="text-2xl font-bold tracking-wide">
                                Quincy Store
                            </h1>                            
                            <p class="text-xs text-slate-400 mt-1">
                                Admin Portal
                            </p>
                        </div>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <!-- <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter> -->
    </Sidebar>
    <slot />
</template>
