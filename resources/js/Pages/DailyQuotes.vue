<template>

    <Head title="Daily Quotes" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                        <h1 class="text-2xl font-bold mb-4">Daily Quotes</h1>
                        <button @click="refreshQuotes" class="btn btn-primary mb-4">Refresh Quotes</button>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2">Quote</th>
                                        <th class="px-4 py-2">Author</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(quote, index) in quotes" :key="index">
                                        <td class="px-4 py-2">{{ quote.q }}</td>
                                        <td class="px-4 py-2">{{ quote.a }}</td>
                                    </tr>
                                    <tr v-if="quotes.length === 0">
                                        <td colspan="2" class="text-center py-4">No quotes available. Click 'Refresh
                                            Quotes' to fetch.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>

        </div>

    </AuthenticatedLayout>
</template>
<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';

import { Head } from '@inertiajs/vue3'
const quotes = ref([]);


const fetchQuotes = async () => {
    const response = await axios({
        method: 'get',
        url: '/api/daily-quotes',
    });
    quotes.value = response.data;
};

const refreshQuotes = () => {
    fetchQuotes();
};
fetchQuotes();
</script>
<style>
.custom-class {
    float: right;
}
</style>