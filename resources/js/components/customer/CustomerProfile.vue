<script setup lang="ts">

interface customer {
    customer_id: number;
    customer_fname: string;
    customer_lname: string;
    employer_name: string;
    total_amount: number;
}

defineProps<{
    customer: customer | null;
}>();

const emit = defineEmits<{
    close: [];
}>();

</script>
<template>
            <div
            v-if="customer"
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
             @click.self="emit('close')"
        >
            <div class="bg-white rounded-2xl p-8 w-full max-w-md text-black">
                <h2 class="text-xl font-bold text-slate-800 mb-6">
                    Customer Information
                </h2>

 <div class="space-y-4 max-h-[60vh] overflow-y-auto pr-3">

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
        <p class="text-sm text-slate-500">Company</p>
        <p class="font-semibold">
            {{ customer.employer_name }}
        </p>
    </div>
        <div>
        <p class="text-sm text-slate-500">Company</p>
        <p class="font-semibold">
            {{ customer.employer_name }}
        </p>
    </div>
        <div>
        <p class="text-sm text-slate-500">Company</p>
        <p class="font-semibold">
            {{ customer.employer_name }}
        </p>
    </div>
        <div>
        <p class="text-sm text-slate-500">Company</p>
        <p class="font-semibold">
            {{ customer.employer_name }}
        </p>
    </div>
        <div>
        <p class="text-sm text-slate-500">Company</p>
        <p class="font-semibold">
            {{ customer.employer_name }}
        </p>
    </div>
        <div>
        <p class="text-sm text-slate-500">Company</p>
        <p class="font-semibold">
            {{ customer.employer_name }}
        </p>
    </div>
        <div>
        <p class="text-sm text-slate-500">Company</p>
        <p class="font-semibold">
            {{ customer.employer_name }}
        </p>
    </div>
        <div>
        <p class="text-sm text-slate-500">Company</p>
        <p class="font-semibold">
            {{ customer.employer_name }}
        </p>
    </div>
        <div>
        <p class="text-sm text-slate-500">Company</p>
        <p class="font-semibold">
            {{ customer.employer_name }}
        </p>
    </div>
    

    <div>
        <p class="text-sm text-slate-500">Contact</p>
        <p class="font-semibold">
            <!-- {{ customer.contact_no }} -->
        </p>
    </div>

    <!-- Other customer information -->

    <div class="bg-indigo-50 rounded-xl p-5">
        <p class="text-sm text-indigo-600">
            Total Credits
        </p>

        <h2 class="text-2xl font-bold text-indigo-700 mt-2">
            <!-- {{ formatCurrency(customer.total_amount) }} -->
        </h2>
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
</template>
