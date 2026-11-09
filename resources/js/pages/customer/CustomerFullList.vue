<script setup lang="ts">
import CustomerProfile from '@/components/customer/CustomerProfile.vue';
import { ref } from 'vue';

const selectedCustomer = ref<customers | null>(null);
const showModal = ref(false);

function viewCustomer(customer: customers) {
    selectedCustomer.value = customer;
    showModal.value = true;
}

function closeModal() {
    showModal.value = false;
    selectedCustomer.value = null;
}

interface customers{
    customer_id: number
    customer_fname:string
    customer_lname:string
    total: number
    contact_no: string
    employer: number
    employer_name: string
    total_amount: number
}

const props = defineProps<{
    customers: customers[];
}>();

const formatCurrency = (amount: number) => {
    return new Intl.NumberFormat('en-PH', {
        style: 'currency',
        currency: 'PHP'
    }).format(amount)
}

// const selectedCustomer = ref<customers | null>(null);

// function viewCustomer(customer: customers) {
//     selectedCustomer.value = customer
// }

</script>
<template>
    <div class=" w-full rounded-xl shadow-sm">
		<div>
                <table class="w-full text-left mt-8 p-6 rounded-xl shadow-sm"">

                    <thead class="bg-gray-900 text-sm">
                        <tr class="border-b-gray-200 ">
                            <th class="p-3">Customer Name</th>
                            <th class="p-3">Company</th>
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
                            v-for="customer in customers"
                            :key="customer.customer_id"
                            class="border-t-gray-500 hover:bg-slate-50 transition"
                        >

                            <td class="px-6 py-4 ">
                                <button
                                    class="font-semibold text-indigo-600
                                           hover:underline"
                                >
                                    {{ customer.customer_fname }}
                                    {{ customer.customer_lname }}
                                </button>
                            </td>

                            <td class="px-6 py-4 text-slate-300">
                                {{ customer.employer_name }} 
                            </td>

                            <td class="px-6 py-4 text-right
                                       font-bold text-slate-500">
                                {{ formatCurrency(customer.total_amount) }}
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

                        <tr v-if="customers.length === 0">
                            <td colspan="5"
                                class="text-center py-10 text-slate-400">
                                No customers found.
                            </td>
                        </tr>

                    </tbody>

                </table>
            </div>
            </div>
<CustomerProfile
    v-if="showModal"
    :customer="selectedCustomer"
    @close="closeModal"
/>
</template>