
<script setup lang="ts">
import { ref, computed } from 'vue'
import CustomerLayout from '@/layouts/CustomerLayout.vue'
import { router } from '@inertiajs/vue3'
defineOptions({
    layout: CustomerLayout
})

interface Customer {
    id: number
    first_name: string
    last_name: string
    company: string
    contact_number: string
    total_credits: number
}

const search = ref('')

const customers = ref<Customer[]>([
    {
        id: 1,
        first_name: 'Juan',
        last_name: 'Dela Cruz',
        company: 'Shipyard',
        contact_number: '09123456789',
        total_credits: 15000
    },
    {
        id: 2,
        first_name: 'Pedro',
        last_name: 'Santos',
        company: 'Powerzone',
        contact_number: '09987654321',
        total_credits: 25000
    },
    {
        id: 3,
        first_name: 'Maria',
        last_name: 'Reyes',
        company: 'Shipyard',
        contact_number: '09234567891',
        total_credits: 12000
    },
    {
        id: 4,
        first_name: 'Jose',
        last_name: 'Garcia',
        company: 'Powerzone',
        contact_number: '09567891234',
        total_credits: 18000
    }
])

const filteredCustomers = computed(() => {
    const keyword = search.value.toLowerCase()

    return customers.value.filter(customer => {
        const fullName =
            `${customer.first_name} ${customer.last_name}`.toLowerCase()

        return fullName.includes(keyword) ||
            customer.company.toLowerCase().includes(keyword)
    })
})

const totalCredits = computed(() => {
    return customers.value.reduce(
        (total, customer) => total + customer.total_credits,
        0
    )
})

const formatCurrency = (amount: number) => {
    return new Intl.NumberFormat('en-PH', {
        style: 'currency',
        currency: 'PHP'
    }).format(amount)
}

const selectedCustomer = ref<Customer | null>(null)

function viewCustomer(customer: Customer) {
    selectedCustomer.value = customer
}
const createCustomer = ref<Customer | null>(null)

function addCustomer() {
    router.visit('/customer/register')
}
</script>

<template>
    <div class="bg-gray-100 w-full rounded-xl shadow-sm">
         <!-- <div class="p-6">
            <h1 class="text-3xl font-bold text-slate-800 ">
                Summary of Customers
            </h1>

            <p class="text-slate-500 mt-2">
                View customer information and credit totals.
            </p> 
                     </div>-->
                <div class="flex justify-between items-center p-6">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800">
                        Summary of Customers
                    </h2>

                    <p class="text-gray-500">
                        View customer information and credit totals.
                    </p>
                </div>
                <div>
                <button
                    @click=""
                    class="bg-red-600 text-white m-1.5 px-5 py-2 rounded-lg hover:bg-red-700">
                    Remove Customer
                </button>
                <button
                    @click="addCustomer"
                    class="bg-blue-600 m-1.5 text-white px-5 py-2 rounded-lg hover:bg-blue-700">
                    Add Customer
                </button>
   </div>
        </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 m-8 ">

            <div class="bg-white p-6 rounded-xl shadow-sm">
                    <p class="text-gray-500">
                    Total Customers
                    </p>

                <h2 class="text-3xl font-bold text-slate-800 mt-2">
                    {{ customers.length }}
                </h2>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm">
                    <p class="text-gray-500">
                    Combined Credit Total
                </p>

                <h2 class="text-3xl font-bold text-indigo-600 mt-2">
                    {{ formatCurrency(totalCredits) }}
                </h2>
            </div>
            
            <div class="bg-white p-6 rounded-xl shadow-sm">
                    <p class="text-gray-500">
                    Powerzone
                </p>
                <p class="text-sm text-slate-500">
                    Total Customer: {{ customers.length }}
                </p>

                <h2 class="text-3xl font-bold text-indigo-600 mt-2">
                   {{ formatCurrency(totalCredits) }}
                </h2>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm">
                    <p class="text-gray-500">
                    Shipyard
                </p>
                <p class="text-sm text-slate-500">
                      Total Customer: {{ customers.length }}
                </p>

                <h2 class="text-3xl font-bold text-indigo-600 mt-2">
                     {{ formatCurrency(totalCredits) }}
                </h2>
            </div>
            
        </div>

        <!-- Customer Table -->
        <div class="bg-white rounded-xl shadow-sm lg:m-8">

            <!-- Table Header -->
            <div class="p-6 flex flex-col md:flex-row
                        justify-between gap-4 ">

                <div>
                    <h2 class="text-lg font-bold text-slate-800">
                        Customer List
                    </h2>

                    <p class="text-sm text-slate-500">
                        Customer credit overview
                    </p>
                </div>

                <div>
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Search customer..."
                        class="w-full md:w-72 border border-slate-300
                               rounded-lg px-4 py-2 text-sm
                               focus:ring-2 focus:ring-indigo-500
                               outline-none"
                    />
                </div>

            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left bg-white mt-8 p-6 rounded-xl shadow-sm"">

                    <thead class="bg-slate-50 text-slate-500 text-sm">
                        <tr class="border-b-gray-200 text-gray-500">
                            <th class="p-3">Customer Name</th>
                            <th class="p-3">Company</th>
                            <th class="p-3">Contact Number</th>
                            <th class="p-3 text-right">
                                Total Credits
                            </th>
                            <th class="p-3 text-center">
                                Action
                            </th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr
                            v-for="customer in filteredCustomers"
                            :key="customer.id"
                            class="border-t-gray-500 hover:bg-slate-50 transition"
                        >

                            <td class="px-6 py-4 ">
                                <button
                                    @click="viewCustomer(customer)"
                                    class="font-semibold text-indigo-600
                                           hover:underline"
                                >
                                    {{ customer.first_name }}
                                    {{ customer.last_name }}
                                </button>
                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                {{ customer.company }}
                            </td>

                            <td class="px-6 py-4 text-slate-500">
                                {{ customer.contact_number }}
                            </td>

                            <td class="px-6 py-4 text-right
                                       font-bold text-slate-800">
                                {{ formatCurrency(customer.total_credits) }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                <button
                                    @click="viewCustomer(customer)"
                                    class="px-4 py-2 rounded-lg
                                           bg-indigo-50 text-indigo-600
                                           hover:bg-indigo-100 text-sm"
                                >
                                    View
                                </button>
                            </td>

                        </tr>

                        <tr v-if="filteredCustomers.length === 0">
                            <td colspan="5"
                                class="text-center py-10 text-slate-400">
                                No customers found.
                            </td>
                        </tr>

                    </tbody>

                </table>

            </div>

            <!-- Footer -->
            <div class="p-5 border-t-gray-100 text-sm text-slate-500">
                Showing {{ filteredCustomers.length }} of
                {{ customers.length }} customers
            </div>

        </div>

        <!-- Customer Details Modal -->
        <div
            v-if="createCustomer"
            class="fixed inset-0 z-50 bg-black/50
                   flex items-center justify-center p-4"
            @click.self="createCustomer = null"
        >
            <div class="bg-white rounded-2xl p-8 w-full max-w-md">

                <h2 class="text-xl font-bold text-slate-800 mb-6">
                    Customer Information
                </h2>

                <div class="space-y-4">

                    <div>
                        <p class="text-sm text-slate-500">Full Name</p>
                        <p class="font-semibold">
                            Here is the new customer information.
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Company</p>
                        <p class="font-semibold">
                           Form Set
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Contact</p>
                        <p class="font-semibold">
                          
                        </p>
                    </div>

                    <div class="bg-indigo-50 rounded-xl p-5">
                        <p class="text-sm text-indigo-600">
                            Total Credits
                        </p>

                        <h2 class="text-2xl font-bold text-indigo-700 mt-2">
                           
                        </h2>
                    </div> 
                   
                </div>

                <button
                    @click="createCustomer = null"
                    class="w-full mt-6 bg-slate-900 text-white
                           rounded-lg py-3 hover:bg-slate-800"
                >
                    Close
                </button>

            </div>
             
        </div>


         <!-- New Customer Modal  -->
        <div
            v-if="selectedCustomer"
            class="fixed inset-0 z-50 bg-black/50
                   flex items-center justify-center p-4"
            @click.self="selectedCustomer = null"
        >
            <div class="bg-white rounded-2xl p-8 w-full max-w-md">

                <h2 class="text-xl font-bold text-slate-800 mb-6">
                    Customer Information
                </h2>

                <div class="space-y-4">

                    <div>
                        <p class="text-sm text-slate-500">Full Name</p>
                        <p class="font-semibold">
                            {{ selectedCustomer.first_name }}
                            {{ selectedCustomer.last_name }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Company</p>
                        <p class="font-semibold">
                            {{ selectedCustomer.company }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Contact</p>
                        <p class="font-semibold">
                            {{ selectedCustomer.contact_number }}
                        </p>
                    </div>

                    <div class="bg-indigo-50 rounded-xl p-5">
                        <p class="text-sm text-indigo-600">
                            Total Credits
                        </p>

                        <h2 class="text-2xl font-bold text-indigo-700 mt-2">
                            {{ formatCurrency(
                                selectedCustomer.total_credits
                            ) }}
                        </h2>
                    </div>

                </div>

                <button
                    @click="selectedCustomer = null"
                    class="w-full mt-6 bg-slate-900 text-white
                           rounded-lg py-3 hover:bg-slate-800"
                >
                    Close
                </button>

            </div>
        </div>
    </div>
</template>
