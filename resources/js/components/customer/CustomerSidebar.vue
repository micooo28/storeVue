
<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3'
import { SidebarOpen } from '@lucide/vue';

defineProps<{
    open: boolean
}>()

const page = usePage()

const menuItems = [
    {
        name: 'Dashboard',
        icon: '⌂',
        route: '/here'
    },
    {
        name: 'Customer',
        icon: '₱',
        route: '/customerlist'
    },
    {
        name: 'Orders',
        icon: '▤',
        route: '/order'
    },
    {
        name: 'Notifications',
        icon: '?',
        route: '/customer/support'
    },
    {
        name: 'Settings',
        icon: '⚙',
        route: '/customer/profile'
    },
]
</script>

<template>
    <aside
        v-if="open"
        class="w-64 min-h-screen bg-slate-900 text-white
               flex flex-col shrink-0"
    >

        <div class="px-6 py-7 border-b border-slate-700">
            <h1 class="text-2xl font-bold tracking-wide">
                Quincy Store
            </h1>
            <p class="text-xs text-slate-400 mt-1">
                Admin Portal
            </p>
        </div>

        <div class="p-5">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-full bg-indigo-500
                            flex items-center justify-center font-bold">
                    C
                </div>

                <div>
                    <p class="font-semibold text-sm">My Account</p>
                    <p class="text-xs text-slate-400">Customer</p>
                </div>
            </div>
        </div>

        <nav class="px-3 space-y-2 flex-1">
            <Link
                v-for="item in menuItems"
                :key="item.route"
                :href="item.route"
                class="flex items-center gap-3 px-4 py-3 rounded-lg
                       transition"
                :class="page.url === item.route
                    ? 'bg-indigo-600 text-white'
                    : 'text-slate-300 hover:bg-slate-800'"
            >
                <span class="text-xl w-6 text-center">
                    {{ item.icon }}
                </span>

                <span class="text-sm font-medium">
                    {{ item.name }}
                </span>
            </Link>

        </nav>

        <div class="p-4 border-t border-slate-700">
            <Link
                href="/logout"
                method="post"
                as="button"
                class="w-full text-left px-4 py-3 text-red-300
                       hover:bg-slate-800 rounded-lg"
            >
                ↪ Logout
            </Link>
        </div>

    </aside>
</template>
