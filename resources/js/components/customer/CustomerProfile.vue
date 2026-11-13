<script setup lang="ts">
import { computed, ref } from 'vue'
import PaymentPage from '@/components/customer/PaymentPage.vue';
import PaymentList from '@/components/customer/PaymentList.vue';

interface customers{
    customer_id: number
    customer_fname:string
    customer_lname:string
    total: number
    contact_no: string
    employer: number
    employer_name: string
    total_amount: number
    item_id: number
    item_name:string
    quantity:number
    amount:number
    date_created:Date
    pay_method: string
    payment_amount: number
    date: Date
    payment_total:number
}

const customerInfo = ref<customers | null>(null);
const showPayment = ref(false);
const showPaymentList = ref(false);

function openPaymentList(payment: customers) {
    customerInfo.value = payment
    showPaymentList.value = true;
}

function openPayment(customer: customers) {
    customerInfo.value = customer
    showPayment.value = true;
}
function closePayment() {
    showPayment.value = false;
}
function closePaymentList() {
    showPaymentList.value = false;
}

const props = defineProps<{
    customer: any
}>()

const emit = defineEmits<{
    close: [];
}>();

const formatCurrency = (total: number) => {
    return new Intl.NumberFormat('en-PH', {
        style: 'currency',
        currency: 'PHP'
    }).format(total)
}

const editingItemId = ref<number | null>(null)

const editForm = ref({
    item_name: '',
    quantity: 0,
    total: 0,
})

function editItem(item: any) {
    editingItemId.value = item.item_id

    editForm.value = {
        item_name: item.item_name,
        quantity: item.quantity,
        total: item.total,
    }
}


function cancelEdit() {
    editingItemId.value = null
}

function saveEdit(item: any) {
    item.item_name = editForm.value.item_name
    item.quantity = editForm.value.quantity
    item.total = editForm.value.total

    editingItemId.value = null

    console.log(saveEdit)
}

const unpaidItems = computed(() =>
    props.customer.items.filter((item: any) => Number(item.total) > 0)
);
</script>
<template>
            <div
            v-if="customer"
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
             @click.self="emit('close')"
        >
            <div class="bg-white rounded-2xl p-8 text-black">
                <h2 class="text-xl font-bold text-slate-800 mb-6">
                    Customer Information
                </h2>

 <div class="space-y-4 max-h-[60vh] overflow-y-auto pr-3 max-w-fit">

    <div>
        <p class="text-sm text-slate-500">Full Name</p>
        <p class="font-semibold">
            {{ customer.customer_fname }}
            {{ customer.customer_lname }}
        </p>
    </div>

    <div>
        <p class="text-sm text-slate-500">Company</p>
        <p class="font-semibold">
            {{ customer.employer_name }}
        </p>
    </div>
    <div>
        <p class="text-sm text-slate-500">Item Summary</p>
            <div class="overflow-x-auto">
                <table class="w-full text-left mt-8 p-6 rounded-xl shadow-sm"">

                    <thead class="bg-gray-300 text-sm">
                        <tr class="border-b-gray-200 ">
                            <th class="p-3">Item Name</th>
                            <th class="p-3">Quantity</th>
                            <th class="p-3">Amount</th>
                            <th class="p-3">Total</th>
                            <th class="p-3 text-center">
                                Date
                            </th>
                            <th class="p-5 text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
        

<tr
    v-for="item in unpaidItems"
    :key="item.item_id"
    class="border-t border-gray-200 hover:bg-slate-50 transition"
>
    <!-- ITEM NAME -->
    <td class="p-5">

        <input
            v-if="editingItemId === item.item_id"
            v-model="editForm.item_name"
            type="text"
            class="border rounded-lg px-3 py-2 w-full"
        />

        <span v-else class="font-semibold text-slate-600">
            {{ item.item_name }}
        </span>

    </td>

    <!-- QUANTITY -->
    <td class="p-5 font-semibold text-slate-600">

        <input
            v-if="editingItemId === item.item_id"
            v-model.number="editForm.quantity"
            type="number"
            min="1"
            class="border rounded-lg px-3 py-2 w-24"
        />

        <span v-else>
            {{ item.quantity }}
        </span>

    </td>
    <td class="p-5 font-semibold text-slate-600">

        <input
            v-if="editingItemId === item.item_id"
            type="number"
            min="1"
            class="border rounded-lg px-3 py-2 w-24"
        />

        <span v-else>
            {{ item.amount }}
        </span>

    </td>

    <!-- AMOUNT -->
    <td class="p-5 font-semibold text-slate-600">

        <input
            v-if="editingItemId === item.item_id"
            v-model.number="editForm.total"
            type="number"
            min="0"
            step="0.01"
            class="border rounded-lg px-3 py-2 w-32"
        />
        <span v-else>
            {{ formatCurrency(item.total) }}
        </span>

    </td>

    <!-- DATE -->
    <td class="p-5 text-right font-semibold text-slate-600">
        {{ item.date_created }}
    </td>

    <!-- ACTIONS -->
    <td class="p-5 text-center">

        <div v-if="editingItemId === item.item_id"
             class="flex justify-center gap-2">

            <button
                @click="saveEdit(item)"
                class="px-4 py-2 rounded-lg bg-green-50
                       text-green-600 hover:bg-green-100 text-sm"
            >
                Save
            </button>

            <button
                @click="cancelEdit"
                class="px-4 py-2 rounded-lg bg-red-50
                       text-red-600 hover:bg-red-100 text-sm"
            >
                Cancel
            </button>

        </div>

        <button
            v-else
            @click="editItem(item)"
            class="px-4 py-2 rounded-lg bg-indigo-50
                   text-indigo-600 hover:bg-indigo-100 text-sm"
        >
            Edit
        </button>

    </td>
</tr>
                        <tr>
                            <td v-if="props.customer.items == 0"
                                colspan="5"
                                class="text-center py-10 text-slate-400">
                                No Credit.
                            </td>
                        </tr>

                    </tbody>

                </table>

            </div>

    </div>

    <!-- Other customer information -->

    <div class="bg-indigo-50 rounded-xl p-5 text-center">
        <p class="text-sm text-indigo-600">
            Total Credits
        </p>

        <h2 class="text-2xl font-bold text-indigo-700 mt-2">
            {{ formatCurrency(customer.total_amount) }}
        </h2>
        <button
            @click="openPayment(customer)"
            class="w-full mt-2 bg-green-400 text-white
            rounded-lg py-3 hover:bg-green-500"
        >
            Pay Credit
        </button>
         <button
            @click="openPaymentList(customer)"
            class="w-full mt-2 bg-slate-800 text-white
            rounded-lg py-3 hover:bg-slate-900"
        >
            Payment Records
        </button>
    </div>

</div>

                <button
                    @click="emit('close')"
                    class="w-full bg-red-500 text-white
                           rounded-lg py-3 hover:bg-red-600"
                >
                    Close
                </button>

            </div>
        </div>
<PaymentPage
    v-if="showPayment"
    :customer.value = customerInfo
    @close-payment="closePayment"
/>

<PaymentList
v-if="showPaymentList"
:customer.value= customerInfo
@close-payment = "closePaymentList"
/>
</template>
