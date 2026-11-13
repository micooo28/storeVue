<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import { computed } from 'vue';

const props = defineProps<{
    customer: any
}>()

const emit = defineEmits<{
    closePayment: [];
}>();

const closePayment = () => emit('closePayment')

const form = useForm({
    customer_id: null as number | null,
    employer: null as number | null,
    date_paid: new Date().toISOString().slice(0, 10),
    amount: 0,
    method_pay: 'Cash',
})

form.customer_id = props.customer.customer_id;
form.employer = props.customer.employer;

const remainingBalance = computed(() => {
   
    const balance = Number(props.customer.total_amount) || 0;
    const amount = Number(form.amount) || 0;
    return balance - amount;
});

 
function submitPayment() {
    form.post('/payment', {
        onSuccess: () => {
            console.log('Payment saved successfully');
            closePayment();
        },

        onError: (errors) => {
            console.error('Payment errors:', errors);
        },

        onFinish: () => {
            console.log('Payment request finished');
        }
    });
}
</script>

<template>
     <div v-if="customer"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
            <div class="bg-white rounded-2xl p-8 text-black">
                <h2 class="text-xl font-bold text-slate-800 mb-6">
                    Payment Form
                </h2>
   <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-slate-800">
                    Customer Payment
                </h2>

                <button
                    type="button"
                    @click="closePayment"
                    class="text-gray-500 hover:text-red-500"
                >
                    ✕
                </button>
            </div>

            <input
                type="hidden"
                v-model="form.customer_id"
            />
            <input
                type="hidden"
                v-model="form.employer"
            />

            <!-- Customer -->
            <div class="bg-slate-50 rounded-xl p-4 mb-5">
                <p class="text-sm text-slate-500">Customer Name</p>
                <p class="font-bold text-slate-800">
                    {{ customer.customer_fname }}
                    {{ customer.customer_lname }}
                </p>
            </div>

            <!-- Outstanding Balance -->
            <div class="bg-indigo-50 rounded-xl p-4 mb-5">
                <p class="text-sm text-indigo-600">
                    Outstanding Balance
                </p>
                <h2 class="text-2xl font-bold text-indigo-700">
                     ₱{{ customer.total_amount.toLocaleString('en-PH', {
                        minimumFractionDigits: 2 
                    }) }}
                </h2>
            </div>

            <form @submit.prevent="submitPayment" class="space-y-4">
                
                <div>
                    <label class="block text-sm font-medium mb-2">
                        Payment Date
                    </label>

                    <input
                        v-model="form.date_paid"
                        type="date"
                        required
                        class="w-full border rounded-lg px-3 py-2"
                    />
                </div>

                <!-- Payment Amount -->
                <div>
                    <label class="block text-sm font-medium mb-2">
                        Payment Amount (₱)
                    </label>
                    
                    <input
                        v-model.number="form.amount"
                        type="number"
                        min="0.01"

                        step="0.01"
                        required
                        placeholder="Enter payment amount"
                        class="w-full border rounded-lg px-3 py-2"
                    />
                </div>

                <!-- Payment Method -->
                <div>
                    <label class="block text-sm font-medium mb-2">
                        Payment Method
                    </label>

                    <select
                        v-model="form.method_pay"
                        class="w-full border rounded-lg px-3 py-2"
                    >
                        <option value="Cash">Cash</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                        <option value="GCash">GCash</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <!-- Remaining Balance -->
                <div class="bg-green-50 rounded-xl p-4">
                    <p class="text-sm text-green-700">
                        Remaining Balance After Payment
                    </p>

                    <h2 class="text-2xl font-bold text-green-700">
                        ₱{{ remainingBalance.toLocaleString('en-PH', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }) }}
                    </h2>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3 pt-3">
                    <button
                        type="button"
                        @click="closePayment"
                        class="w-full border rounded-lg py-3
                               hover:bg-gray-100"
                    >
                        Cancel
                    </button>

                       <button
                            type="submit"
                            :disabled="form.processing"
                            class="w-full bg-green-500 text-white
                               rounded-lg py-3 hover:bg-green-600"
                        >
                            {{ form.processing ? 'Processing...' : 'Submit Payment' }}
                        </button>
                </div>

            </form>
        </div>
            </div>
</template>