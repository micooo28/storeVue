<script setup lang="ts">
import CustomerLayout from '@/layouts/CustomerLayout.vue'

defineOptions({
    layout: CustomerLayout
})

interface Employee {
    customer_id: number;
    customer_fname: string;
    customer_lname: string;
}

const props = defineProps<{
    employee: Employee[]
}>()

console.log('All Inertia props:', props)
console.log('Employee:', props.employee)
</script>

<template>
    <div>
        <h2>Total Employees: {{ props.employee?.length ?? 0 }}</h2>

        <div v-for="emp in props.employee" :key="emp.customer_id">
            {{ emp.customer_fname }} {{ emp.customer_lname }}
        </div>
    </div>
</template>