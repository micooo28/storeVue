
<script setup lang="ts">
import CustomerLayout from '@/layouts/CustomerLayout.vue'
defineOptions({
    layout: CustomerLayout
})

const transactions = [
    {
        id: 1,
        description: 'Credit Added',
        date: 'October 28, 2026',
        amount: 5000,
        type: 'credit'
    },
    {
        id: 2,
        description: 'Payment',
        date: 'October 25, 2026',
        amount: 2000,
        type: 'payment'
    },
    {
        id: 3,
        description: 'Credit Added',
        date: 'October 20, 2026',
        amount: 3000,
        type: 'credit'
    }
]

const formatCurrency = (amount: number) =>
    new Intl.NumberFormat('en-PH', {
        style: 'currency',
        currency: 'PHP'
    }).format(amount)
</script>

<template>
    <CustomerLayout>

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-800">
                My Dashboard
            </h1>

            <p class="text-slate-500 mt-2">
                Welcome back! Here's your account overview.
            </p>
        </div>

        <!-- Balance -->
        <div class="bg-gradient-to-red from-indigo-700 to-blue-600
                    rounded-2xl p-8 text-white shadow-lg mb-8">

            <p class="text-indigo-100 text-sm">
                Available Credit Balance
            </p>

            <h2 class="text-4xl font-bold mt-3">
                ₱25,500.00
            </h2>

            <p class="text-indigo-200 text-sm mt-4">
                Your current remaining balance
            </p>

        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

            <div class="bg-white p-6 rounded-xl shadow-sm border">
                <p class="text-sm text-slate-500">Total Credits</p>
                <h2 class="text-2xl font-bold mt-2 text-slate-800">
                    ₱35,000.00
                </h2>
                <p class="text-xs text-slate-400 mt-2">
                    Total credit received
                </p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border">
                <p class="text-sm text-slate-500">Total Payments</p>
                <h2 class="text-2xl font-bold mt-2 text-green-600">
                    ₱9,500.00
                </h2>
                <p class="text-xs text-slate-400 mt-2">
                    Total payments made
                </p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border">
                <p class="text-sm text-slate-500">Transactions</p>
                <h2 class="text-2xl font-bold mt-2 text-slate-800">
                    3
                </h2>
                <p class="text-xs text-slate-400 mt-2">
                    Recorded transactions
                </p>
            </div>

        </div>

        <!-- Recent Transactions -->
        <div class="bg-white rounded-xl border shadow-sm">

            <div class="p-6 border-b flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-bold text-slate-800">
                        Recent Transactions
                    </h2>
                    <p class="text-sm text-slate-500">
                        Your latest account activities
                    </p>
                </div>

                <a href="/customer/transactions"
                   class="text-indigo-600 text-sm font-medium">
                    View All
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">

                    <thead class="bg-slate-50 text-slate-500 text-sm">
                        <tr>
                            <th class="px-6 py-4">Description</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Amount</th>
                            <th class="px-6 py-4">Type</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="transaction in transactions"
                            :key="transaction.id"
                            class="border-t hover:bg-slate-50"
                        >
                            <td class="px-6 py-4 font-medium">
                                {{ transaction.description }}
                            </td>

                            <td class="px-6 py-4 text-sm text-slate-500">
                                {{ transaction.date }}
                            </td>

                            <td class="px-6 py-4 font-semibold">
                                {{ formatCurrency(transaction.amount) }}
                            </td>

                            <td class="px-6 py-4">
                                <span
                                    class="px-3 py-1 rounded-full text-xs"
                                    :class="transaction.type === 'credit'
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-orange-100 text-orange-700'"
                                >
                                    {{ transaction.type }}
                                </span>
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>

        </div>

    </CustomerLayout>
</template>
