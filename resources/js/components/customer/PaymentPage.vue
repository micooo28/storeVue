<script setup lang="ts">
defineProps<{
    showPayment: boolean
}>()

const emit = defineEmits<{
    closePayment: []
}>()

const closePayment = () => emit('closePayment')
</script>

<template>
     <div v-if="showPayment"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
            <div class="bg-white rounded-2xl p-8 text-black">
                
                <h2 class="text-xl font-bold text-slate-800 mb-6">
                    Customer Information
                </h2>
 <div class="space-y-4 max-h-[60vh] overflow-y-auto pr-3 max-w-fit">

    <div>
        <p class="text-sm text-slate-500">Full Name</p>
        <p class="font-semibold">
            Payment
        </p>
    </div>

    <div>
        <p class="text-sm text-slate-500">Company</p>
        <p class="font-semibold">
            Company
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

<tr class="border-t border-gray-200 hover:bg-slate-50 transition">

    <!-- ITEM NAME -->
    <td class="p-5">

        <input
            type="text"
            class="border rounded-lg px-3 py-2 w-full"
        />

        <span class="font-semibold text-slate-600">
            amount
        </span>

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
            Pending
        </h2>
        <button
                    class="w-full mt-2 bg-green-400 text-white
                           rounded-lg py-3 hover:bg-green-500"
                >
                    Pay Credit
                </button>
    </div>

</div>
</div>
            </div>
</template>