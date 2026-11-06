<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'

const form = useForm({
    fname: '',
    lname: '',
    street: '',
    barangay: '',
    city: '',
    province: '',
    contact_no: '',
    employer: '',
    supervisor: '',
    email: '',
    password: '',
    password_confirmation: '',
})

const submit = () => {
    form.post('/customer/register/submit', {
        onSuccess: (
            
        ) => {
            form.reset()
        },
    }
)
}
</script>

<template>
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-md bg-black rounded-xl shadow-lg p-8">

            <h1 class="text-2xl font-bold text-center mb-2">
                Create Account
            </h1>

            <p class="text-gray-500 text-center mb-6">
                Register to get started.
            </p>

            <form @submit.prevent="submit" class="space-y-4">

                <!-- Personal Info -->
                 <div>
                    <label class="block text-sm font-medium mb-1">
                        Full Name
                    </label>
                 </div>
                <div>
                    <label class="block text-sm font-medium mb-1">
                        First Name
                    </label>
                    <input
                        v-model="form.fname"
                        type="text"
                        placeholder="Enter first name"
                        class="w-full border rounded-lg px-3 py-2"
                    />

                    <p v-if="form.errors.fname" class="text-red-500 text-sm mt-1">
                        {{ form.errors.fname }}
                    </p>
                </div>

                <!-- Last Name -->
                <div>
                    <label class="block text-sm font-medium mb-1">
                        Last Name
                    </label>
                    <input
                        v-model="form.lname"
                        type="text"
                        placeholder="Enter last name"
                        class="w-full border rounded-lg px-3 py-2"
                    />

                    <p v-if="form.errors.lname" class="text-red-500 text-sm mt-1">
                        {{ form.errors.lname }}
                    </p>
                </div>
                <div class="mt-9">
                    <label class="block text-sm font-medium mb-1">
                    Employment Details
                    </label>
                </div>
                  <div>
                    <label class="block text-sm font-medium mb-1">
                        Employer 
                    </label>

                    <input
                        v-model="form.employer"
                        type="number"
                        placeholder="Enter Employer"
                        class="w-full border rounded-lg px-3 py-2"
                    />

                    <p v-if="form.errors.employer" class="text-red-500 text-sm mt-1">
                        {{ form.errors.employer }}
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">
                        Immediate Supervisor 
                    </label>
                    <input
                        v-model="form.supervisor"
                        type="text"
                        placeholder="Enter Supervisor"
                        class="w-full border rounded-lg px-3 py-2"
                    />
                    <p v-if="form.errors.supervisor" class="text-red-500 text-sm mt-1">
                        {{ form.errors.supervisor }}
                    </p>
                </div> 

                <div class="mt-9">
                    <label class="block text-sm font-medium mb-1">
                        Address
                    </label>
                </div>

                 <div>
                    <label class="block text-sm font-medium mb-1">
                        Enter Street
                    </label>

                    <input
                        v-model="form.street"
                        type="text"
                        placeholder="Enter street"
                        class="w-full border rounded-lg px-3 py-2"
                    />

                    <p v-if="form.errors.street" class="text-red-500 text-sm mt-1">
                        {{ form.errors.street }}
                    </p>
                </div>

                 <div>
                    <label class="block text-sm font-medium mb-1">
                        Barangay
                    </label>

                    <input
                        v-model="form.barangay"
                        type="text"
                        placeholder="Enter barangay"
                        class="w-full border rounded-lg px-3 py-2"
                    />

                    <p v-if="form.errors.barangay" class="text-red-500 text-sm mt-1">
                        {{ form.errors.barangay }}
                    </p>
                </div>

                 <div>
                    <label class="block text-sm font-medium mb-1">
                        City
                    </label>

                    <input
                        v-model="form.city"
                        type="text"
                        placeholder="Enter city"
                        class="w-full border rounded-lg px-3 py-2"
                    />

                    <p v-if="form.errors.city" class="text-red-500 text-sm mt-1">
                        {{ form.errors.city }}
                    </p>
                </div>

                 <div>
                    <label class="block text-sm font-medium mb-1">
                        Province
                    </label>

                    <input
                        v-model="form.province"
                        type="text"
                        placeholder="Enter province"
                        class="w-full border rounded-lg px-3 py-2"
                    />

                    <p v-if="form.errors.province" class="text-red-500 text-sm mt-1">
                        {{ form.errors.province }}
                    </p>
                </div>

                <div class="mt-9">
                    <label class="block text-sm font-medium mb-1">
                        Login Credentials
                    </label>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">
                        Contact Number
                    </label>

                    <input
                        v-model="form.contact_no"
                        type="text"
                        placeholder="Enter contact number"
                        class="w-full border rounded-lg px-3 py-2"
                    />

                    <p v-if="form.errors.contact_no" class="text-red-500 text-sm mt-1">
                        {{ form.errors.contact_no }}
                    </p>
                </div>

                    <div>
                    <label class="block text-sm font-medium mb-1">
                        Email Address
                    </label>

                    <input
                        v-model="form.email"
                        type="email"
                        placeholder="Enter email address"
                        class="w-full border rounded-lg px-3 py-2"
                    />

                    <p v-if="form.errors.email" class="text-red-500 text-sm mt-1">
                        {{ form.errors.email }}
                    </p>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium mb-1">
                        Password
                    </label>

                    <input
                        v-model="form.password"
                        type="password"
                        placeholder="Enter your password"
                        class="w-full border rounded-lg px-3 py-2"
                    />

                    <p v-if="form.errors.password" class="text-red-500 text-sm mt-1">
                        {{ form.errors.password }}
                    </p>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-sm font-medium mb-1">
                        Confirm Password
                    </label>

                    <input
                        v-model="form.password_confirmation"
                        type="password"
                        placeholder="Confirm your password"
                        class="w-full border rounded-lg px-3 py-2"
                    />
                </div>

                <!-- Submit -->
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 disabled:opacity-50"
                >
                    {{ form.processing ? 'Registering...' : 'Register' }}
                </button>

            </form>

            <p class="text-center text-sm text-gray-500 mt-5">
                Already have an account?
                <a href="/login" class="text-blue-600 hover:underline">
                    Login
                </a>
            </p>

        </div>
    </div>
</template>