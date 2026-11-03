
<script setup lang="ts">
// import CustomerSidebar from '@/components/customer/CustomerSidebar.vue'
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue'
// import { ref } from 'vue'

// const sidebarOpen = ref(true)

</script>

<template>
    <div class="min-h-screen bg-slate-50 flex w-full">
        <!-- <CustomerSidebar :open="sidebarOpen" :close="!sidebarOpen"/> -->
    
         <div class="flex-1 w-full" bg-slate-50>
            <AppSidebarLayout>
            <main class="w-full">
                <slot />
            </main>
</AppSidebarLayout>
        </div>
        
    </div>
</template>
<!-- <template>
    <div class="min-h-screen bg-slate-50 flex">

        <CustomerSidebar :open="sidebarOpen" />

        <div class="flex-1 min-w-0">

            <header class="h-16 bg-white border-b flex items-center
                           justify-between px-6">

                <button
                    @click="sidebarOpen = !sidebarOpen"
                    class="text-slate-600 hover:text-indigo-600 text-xl"
                >
                    ☰
                </button>

                <div class="flex items-center gap-3">
                    <span class="text-sm text-slate-600">
                        Customer Account
                    </span>

                    <div class="w-9 h-9 bg-indigo-100 rounded-full
                                flex items-center justify-center
                                text-indigo-700 font-bold">
                        C
                    </div>
                </div>

            </header>

            <main class="p-6 md:p-8">
                <slot />
            </main>

        </div>

    </div>
</template> -->