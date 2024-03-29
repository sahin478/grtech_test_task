<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex justify-center">
                        <!-- Box for Companies -->
                        <div class=" p-6 m-4 rounded-lg flex items-center justify-center">
                            <div class="text-center">
                                <p class="text-lg">You can't access this page</p>
                            </div>
                        </div>
                      
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
