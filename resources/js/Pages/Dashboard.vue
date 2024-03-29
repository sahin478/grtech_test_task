<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
const props = defineProps({
    employees: Object,
    companies: Object,
});
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex justify-center">
                        <!-- Box for Companies -->
                        <div class="bg-blue-500 text-white p-6 m-4 rounded-lg flex items-center justify-center">
                            <div class="text-center">
                                <p class="text-3xl font-bold">{{companies}}</p>
                                <p class="text-lg">Companies</p>
                            </div>
                        </div>

                        <!-- Box for Employees -->
                        <div class="bg-green-500 text-white p-6 m-4 rounded-lg flex items-center justify-center">
                            <div class="text-center">
                                <p class="text-3xl font-bold">{{employees}}</p>
                                <p class="text-lg">Employees</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
