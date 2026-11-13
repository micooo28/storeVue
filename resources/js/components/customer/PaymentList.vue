<script setup lang="ts">
import { computed, ref } from 'vue'

const showPaymentList = ref(false);

const props = defineProps<{
    customer: any
}>()

const emit = defineEmits<{
    closePayment: [];
}>();

const closePayment = () => emit('closePayment')


const formatCurrency = (total: number) => {
    return new Intl.NumberFormat('en-PH', {
        style: 'currency',
        currency: 'PHP'
    }).format(total)
}

console.log(props.customer);

</script>

<template>
     <div
            v-if="customer"
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
             @click.self="closePayment"
        >
            <div class="bg-white rounded-2xl p-8 text-black text-center">

 <div class="space-y-4 max-h-[60vh] overflow-y-auto pr-3 max-w-fit">
                 <h2 class="text-xl font-bold text-slate-800 mb-6">
                    Payment Summary
                </h2>
    <div>
        <p class="text-sm text-slate-500 text-center">
            {{ customer.customer_fname }} 
            {{ customer.customer_lname }}
        </p>
    </div>

     <div class="bg-indigo-50 rounded-xl p-5 text-center">
        <p class="text-sm text-indigo-600">
            Total Payments
        </p>

        <h2 class="text-2xl font-bold text-indigo-700 mt-2">
            {{ formatCurrency(customer.total_payment) }}
        </h2>
    </div>
    <div>
            <div class="overflow-x-auto">
                <table class="w-full text-left mt-8 p-6 rounded-xl shadow-sm"">

                    <thead class="bg-gray-300 text-sm">
                        <tr class="border-b-gray-200 ">
                            <th class="p-3">Payment Amount</th>
                            <th class="p-3">Payment Method</th>
                            <th class="p-3 text-center">Date</th>
                        </tr>
                    </thead>

                    <tbody>
        

<tr
    v-for="payments in customer.payment"
    :key="payments.pay_id"
    class="border-t border-gray-200 hover:bg-slate-50 transition"
>
    <!-- ITEM NAME -->
    <td class="p-5">
        <span class="font-semibold text-slate-600">
            {{ formatCurrency(payments.payment_amount) }}
        </span>

    </td>

    <!-- QUANTITY -->
    <td class="p-5 font-semibold text-slate-600">
        <span>
            {{ payments.pay_method }}
        </span>

    </td>

    <td class="p-5 text-right font-semibold text-slate-600">
        {{ payments.date }}
    </td>
</tr>
                        <tr>
                            <td v-if="props.customer.payment == 0"
                                colspan="5"
                                class="text-center py-10 text-slate-400">
                                No Payments.
                            </td>
                        </tr>

                    </tbody>

                </table>

            </div>

    </div> 

</div>

                <button
                    @click="closePayment"
                    class="w-full bg-red-500 text-white
                           rounded-lg py-3 hover:bg-red-600"
                >
                    Close
                </button>

            </div>
        </div>
</template>