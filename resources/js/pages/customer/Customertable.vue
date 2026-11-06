<script setup lang="ts">
import { ref, computed } from 'vue'
import CustomerLayout from '@/layouts/CustomerLayout.vue'
import { router } from '@inertiajs/vue3'
defineOptions({
    layout: CustomerLayout
})

interface employee {
    customer_id: number;
    customer_fname: string;
    customer_lname: string;
    contact_no: string;
    employer: number;
    total: number;
    initial_amount: number;
}

interface employment{
    employer: number;
    employer_name: string;
}


const props = defineProps<{
    employee: employee[];
    employment:employment[];
}>();
console.log(props.employment)


const search = ref('')

const employee = ref<employee | null>(null)


const filteredCustomers = computed(() => {
    const keyword = search.value.toLowerCase()

    return props.employee.filter(employee => {
        const fullName =
            `${employee.customer_fname} ${employee.customer_lname}`.toLowerCase()

        return fullName.includes(keyword) 
            // || employee.employer.toLowerCase().includes(keyword)
    })
})

const totalCredits = computed(() => {
    return props.employee.reduce(
        (total, employee) => total + Number(employee.total),
        0
    )
})
const formatCurrency = (amount: number) => {
    return new Intl.NumberFormat('en-PH', {
        style: 'currency',
        currency: 'PHP'
    }).format(amount)
}

const selectedCustomer = ref<employee | null>(null)

function viewCustomer(customer: employee) {
    selectedCustomer.value = customer
}

const createCustomer = ref<employee | null>(null)

function addCustomer() {
    router.visit('/customer/register')
}
</script>

<template>
    <div class=" w-full rounded-xl shadow-sm">
                <div class="flex justify-between items-center p-6">
                <div>
       
                    <h2 class="text-3xl font-bold">
                        Summary of Customers
                    </h2>

                    <p>
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

            <div class="bg-gray-900  p-6 rounded-xl shadow-sm">
                    <p>
                    Total Customers
                    </p>

                <h2 class="text-3xl font-bold mt-2">
                    {{ props.employee.length }}
                </h2>
            </div>

            <div class="bg-gray-900  p-6 rounded-xl shadow-sm">
                    <p>
                    Combined Credit Total
                </p>

                <h2 class="text-3xl font-bold text-indigo-600 mt-2">
                    {{ formatCurrency(totalCredits) }}
                </h2>
            </div>
            <div 
                class="bg-gray-900  p-6 rounded-xl shadow-sm">
                    <p>
                    Powerzone
                </p>
                <p class="text-sm">
                    Total Customer: {{ props.employee.length }}
                </p>

                <h2 class="text-3xl font-bold text-indigo-600 mt-2">
                   {{ formatCurrency(totalCredits) }}
                </h2>
            </div>
        </div>

        <!-- Customer Table -->
        <div class="rounded-xl shadow-sm lg:m-8">

            <!-- Table Header -->
            <div class="p-6 flex flex-col md:flex-row
                        justify-between gap-4 ">

                <div>
                    <h2 class="text-lg font-bold">
                        Customer List
                    </h2>

                    <p class="text-sm">
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
                <table class="w-full text-left mt-8 p-6 rounded-xl shadow-sm"">

                    <thead class="bg-gray-900 text-sm">
                        <tr class="border-b-gray-200 ">
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
                            v-for="employee in filteredCustomers"
                            :key="employee.customer_id"
                            class="border-t-gray-500 hover:bg-slate-50 transition"
                        >

                            <td class="px-6 py-4 ">
                                <button
                                    class="font-semibold text-indigo-600
                                           hover:underline"
                                >
                                    {{ employee.customer_fname }}
                                    {{ employee.customer_lname }}
                                </button>
                            </td>

                            <td class="px-6 py-4 text-slate-300">
                                {{ employee.employer }}
                            </td>

                            <td class="px-6 py-4 text-slate-400">
                                {{ employee.contact_no }}   
                            </td>

                            <td class="px-6 py-4 text-right
                                       font-bold text-slate-500">
                                {{ formatCurrency(employee.total) }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                <button
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
                <!-- {{ employee.length }} customers -->
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
                            {{ selectedCustomer.customer_fname }}
                            {{ selectedCustomer.customer_lname }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Company</p>
                        <p class="font-semibold">
                            {{ selectedCustomer.employer }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Contact</p>
                        <p class="font-semibold">
                            {{ selectedCustomer.contact_no }}
                        </p>
                    </div>

                    <div class="bg-indigo-50 rounded-xl p-5">
                        <p class="text-sm text-indigo-600">
                            Total Credits
                        </p>

                        <h2 class="text-2xl font-bold text-indigo-700 mt-2">
                            <!-- {{ formatCurrency(
                                // selectedCustomer.total_credits
                            ) }} -->
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
