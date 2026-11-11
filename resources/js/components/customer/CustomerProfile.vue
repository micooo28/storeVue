<script setup lang="ts">
import { ref } from 'vue'
import PaymentPage from './PaymentPage.vue';

const selectedCustomer = ref<null>(null);
const showPayment = ref(false);

function openPayment() {
    showPayment.value = true;
}

function closePayment() {
    showPayment.value = false;
    selectedCustomer.value = null;
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
    v-for="item in customer.items"
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
                            <td v-if="customer.items == null"
                                colspan="5"
                                class="text-center py-10 text-slate-400">
                                No customers found.
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
            @click="openPayment"
            class="w-full mt-2 bg-green-400 text-white
            rounded-lg py-3 hover:bg-green-500"
        >
            Pay Credit
        </button>
    </div>

</div>

                <button
                    @click="emit('close')"
                    class="w-full mt-6 bg-slate-900 text-white
                           rounded-lg py-3 hover:bg-slate-800"
                >
                    Close
                </button>

            </div>
        </div>
<PaymentPage
    v-if="showPayment"
    :show-payment="showPayment"
    @close-payment="closePayment"
/>
</template>
