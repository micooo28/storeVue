<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

import CustomerLayout from '@/layouts/CustomerLayout.vue';

defineOptions({
    layout: CustomerLayout
})

// Dashboard title
const pageTitle = 'Dashboard';

// Sample statistics
const totalCustomers = ref(120);
const totalSales = ref(2500);
const totalOrders = ref(850);
const pendingOrders = ref(12);

// Sample transactions
const transactions = ref([
    {
        id: 1,
        customer: 'John Doe',
        amount: 1500,
        status: 'Completed',
    },
    {
        id: 2,
        customer: 'Jane Smith',
        amount: 2500,
        status: 'Pending',
    },
    {
        id: 3,
        customer: 'Michael Brown',
        amount: 1000,
        status: 'Completed',
    },
]);

function refreshDashboard() {
    alert('Dashboard refreshed!');
}
</script>

<template>
    <div class="min-h-screen w-full rounded-xl bg-gray-100 flex">

        <!-- MAIN CONTENT -->
        <main class="flex-1">

            <!-- HEADER -->
            <div class="flex justify-between items-center p-6">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800">
                        {{ pageTitle }}
                    </h2>

                    <p class="text-gray-500">
                        Welcome to your admin dashboard.
                    </p>
                </div>

                <button
                    @click="refreshDashboard"
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">
                    Refresh
                </button>
            </div>

            <!-- SUMMARY CARDS -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">

                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <p class="text-gray-500">Total Customers</p>
                    <h3 class="text-green-500 text-3xl font-bold mt-2">
                        {{ totalCustomers }}
                    </h3>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <p class="text-gray-500">Total Sales</p>
                    <h3 class="text-green-500 text-3xl font-bold mt-2">
                        ₱{{ totalSales.toLocaleString() }}
                    </h3>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <p class="text-gray-500">Total Orders</p>
                    <h3 class="text-green-500 text-3xl font-bold mt-2">
                        {{ totalOrders }}
                    </h3>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <p class="text-gray-500">Pending Orders</p>
                    <h3 class="text-3xl font-bold mt-2 text-orange-500">
                        {{ pendingOrders }}
                    </h3>
                </div>

            </div>

            <!-- TRANSACTIONS TABLE -->
            <div class="bg-white mt-8 p-6 rounded-xl shadow-sm">

                <h3 class="text-xl font-bold mb-5">
                    Recent Transactions
                </h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b text-gray-500">
                                <th class="p-3">ID</th>
                                <th class="p-3">Customer</th>
                                <th class="p-3">Amount</th>
                                <th class="p-3">Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr
                                v-for="transaction in transactions"
                                :key="transaction.id"
                                class="border-b hover:bg-gray-50">

                                <td class="p-3 font-mono text-gray-700">
                                    {{ transaction.id }}
                                </td>

                                <td class="p-3 font-mono text-gray-700">
                                    {{ transaction.customer }}
                                </td>

                                <td class="p-3 font-mono text-gray-700">
                                    ₱{{ transaction.amount.toLocaleString() }}
                                </td>

                                <td class="p-3">
                                    <span
                                        :class="transaction.status === 'Completed'
                                            ? 'bg-green-100 text-green-700'
                                            : 'bg-yellow-100 text-yellow-700'"
                                        class="px-3 py-1 rounded-full text-sm">
                                        {{ transaction.status }}
                                    </span>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </main>
    </div>
</template>
