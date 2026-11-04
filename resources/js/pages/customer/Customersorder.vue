
<script setup lang="ts">
import CustomerLayout from '@/layouts/CustomerLayout.vue'
import { computed, ref, watch } from 'vue'
import { useForm } from '@inertiajs/vue3'

defineOptions({
    layout: CustomerLayout
})
interface OrderItem {
    date_created: string
    item_name: string
    quantity: number
    amount: number
    total: number
    initial_amount: number
    user_id: number
    employeeName: string
}

interface Employee {
    customer_id: number;
    customer_fname: string;
    customer_lname: string;
}

const props = defineProps<{
    employee: Employee[]
    
}>()

const search = ref('')


const filteredCustomers = computed(() => {
    const keyword = search.value.toLowerCase().trim()

       if (keyword.length < 3) {
        return []
        }

    return props.employee.filter(employee => {
        const fullName =
            `${employee.customer_fname} ${employee.customer_lname}`.toLowerCase()

        return fullName.includes(keyword)         
    })
})


console.log('Customers:', props.employee)
console.log('Filtered:', filteredCustomers.value)

const form = useForm({
    date_created: new Date().toISOString().split('T')[0],
    items: [
        {
            date_created: new Date().toISOString().split('T')[0],
            item_name: '',
            quantity: 1,
            amount: 0,
            total: 0,
            initial_amount: 0,
            user_id: 0,
            employeeName: ''
        }
    ] as unknown as OrderItem[]
})

// Add another item
const addOrder = () => {
    form.items.push({
        date_created: new Date().toISOString().split('T')[0],
        item_name: '',
        quantity: 1,
        amount: 0,
        total: 0,
        initial_amount: 0,
        user_id: 0,
        employeeName: '',
    })
}

// Remove an item
const removeOrder = (index: number) => {
    if (form.items.length > 1) {
        form.items.splice(index, 1)
    }
}

// Calculate individual item total
const getItemTotal = (item: OrderItem) => {
    return item.quantity * item.amount
}

// Calculate grand total
const grandTotal = computed(() => {
    return form.items.reduce((total, item) => {
        return total + item.total
    }, 0)
})

const formatCurrency = (amount: number) => {
    return new Intl.NumberFormat('en-PH', {
        style: 'currency',
        currency: 'PHP'
    }).format(amount)
}
watch(
    form.items,
    (items) => {
        items.forEach((item) => {
            item.total = item.quantity * item.amount
        })
    },
    { deep: true }
)


// Submit all items together
const submit = () => {
    form.post('/customer/orders', 
    {
        onSuccess: () => {
            console.log('Order successfully submitted!'),
            form.reset()
        },
        onError: (errors) => {
            console.log('Validation errors:', errors)
        }
    }
)
}
</script>

<template>
    <div class="bg-black max-w-md mx-auto rounded-xl p-6 md:p-8 shadow-sm">

        <!-- Header -->
        <div class="mb-4 rounded-xl">
            <h1 class="text-3xl font-bold">
                Place an Order
            </h1>

            <p>
                Add one or more items to your order.
            </p>

        </div>

        <div class=" rounded-2xl shadow-sm p-2 ">

            <!-- Form Header -->
            <div class="p-6 ">
                <h2 class="text-lg font-bold text-slate-800">
                    Order Information
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Enter your order date and item details.
                </p>
            </div>

            <form @submit.prevent="submit" class="p-6">

                <!-- Date -->
                <div class="mb-4 max-w-sm">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Order Date
                    </label>

                    <input
                        v-model="form.date_created"
                        type="date"
                        required
                        class="text-gray-700 placeholder:text-gray-400 border rounded-lg px-4 py-3
                               focus:ring-2 focus:ring-indigo-500
                               outline-none"
                    />

                    <p v-if="form.errors.date_created"
                       class="text-red-500 text-sm mt-1">
                        {{ form.errors.date_created }}
                    </p>
                </div>
                <div class="mb-4 max-w-sm">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Employee Name
                    </label>
                    </div>
<input
    v-model="search"
    type="text"
    placeholder="Search customer..."
    class="w-full md:w-72 border border-slate-300
           rounded-lg px-4 py-2 text-sm
           focus:ring-2 focus:ring-indigo-500
           outline-none"
/>

<div
    v-for="customer in filteredCustomers"
    :key="customer.customer_id"
    class="border-t border-gray-200 hover:bg-slate-50 transition p-3"
>
    <p
    class="font-semibold text-indigo-600 hover:underline">
        {{ customer.customer_fname }}
        {{ customer.customer_lname }}
    </p>
</div>
        
                <!-- Items Header -->
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="font-bold text-slate-800 text-lg">
                            Order Items
                        </h2>

                        <p class="text-sm text-slate-500">
                            {{ form.items.length }} item(s) added
                        </p>
                    </div>

                    <button
                        type="button"
                        @click="addOrder"
                        class="bg-indigo-600 hover:bg-indigo-700
                               text-white px-4 py-2 rounded-lg
                               text-sm font-semibold transition"
                    >
                        + Add Order
                    </button>
                </div>

                <!-- Dynamic Items -->
                <div class="space-y-4">

                    <div
                        v-for="(item, index) in form.items"
                        :key="index"
                        class="border rounded-xl p-5 "
                    >

                        <!-- Item Header -->
                        <div class="flex justify-between items-center mb-5">

                            <h3 class="font-semibold text-slate-700">
                                Item #{{ index + 1 }}
                            </h3>

                            <button
                                v-if="form.items.length > 1"
                                type="button"
                                @click="removeOrder(index)"
                                class="text-red-500 hover:text-red-700
                                       text-sm font-medium"
                            >
                                Remove
                            </button>

                        </div>

                        <!-- Fields -->
                        <div class="grid grid-cols-1 md:grid-cols-1 gap-5">

                            <!-- Item Name -->
                            <div>
                                <label class="block text-sm font-medium
                                              text-slate-700 mb-2">
                                    Item Name
                                </label>

                                <input
                                    v-model="item.item_name"
                                    type="text"
                                    placeholder="Enter item name"
                                    required
                                    class=" placeholder:text-gray-400 w-full border rounded-lg px-4 py-3
                                            outline-none
                                           focus:ring-2 focus:ring-indigo-500"
                                />
                            </div>

                            <!-- Quantity -->
                            <div>
                                <label class="block text-sm font-medium
                                              text-slate-700 mb-2">
                                    Quantity
                                </label>

                                <input
                                    v-model.number="item.quantity"
                                    type="number"
                                    min="1"
                                    required
                                    class=" placeholder:text-gray-400 w-full border rounded-lg px-4 py-3
                                            outline-none
                                           focus:ring-2 focus:ring-indigo-500"
                                />
                            </div>

                            <!-- Amount -->
                            <div>
                                <label class="block text-sm font-medium
                                              text-slate-700 mb-2">
                                    Amount per Item (₱)
                                </label>

                                <input
                                    v-model.number="item.amount"
                                    type="number"
                                    min="0.01"
                                    step="0.01"
                                    required
                                    class="placeholder:text-gray-400 w-full border rounded-lg px-4 py-3
                                           outline-none
                                           focus:ring-2 focus:ring-indigo-500"
                                />
                            </div>

                        </div>

                        <!-- Item Subtotal -->
                        <div class="flex justify-end mt-5">
                            <div class="text-right">
                                <p class="text-xs ">
                                    Item Subtotal
                                </p>

                                <p class="font-bold text-lg">
                                    {{ formatCurrency(getItemTotal(item)) }}
                                </p>
                            </div>
                        </div>

                    </div>

                </div>

                <!-- Grand Total -->
                <div class="mt-8 border border-white rounded-xl p-6
                            flex justify-between items-center">

                    <div>
                        <p class="font-semibold text-indigo-800">
                            Grand Total
                        </p>

                        <p class="text-sm text-indigo-500 mt-1">
                            {{ form.items.length }} item(s)
                        </p>
                    </div>

                    <h2 class="text-3xl font-bold text-indigo-700">
                        {{ formatCurrency(grandTotal) }}
                    </h2>

                </div>

                <!-- Submit -->
                <div class="flex justify-end gap-3 mt-8">

                    <button
                        type="button"
                        @click="form.reset()"
                        class="px-6 py-3 rounded-lg border
                               text-slate-600 hover:bg-slate-50"
                    >
                        Clear Form
                    </button>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="px-8 py-3 rounded-lg bg-indigo-600
                               hover:bg-indigo-700 text-white
                               font-semibold disabled:opacity-50"
                    >
                        {{
                            form.processing
                                ? 'Submitting...'
                                : 'Submit Order'
                        }}
                    </button>
                </div>

            </form>

        </div>
    </div>
</template>
