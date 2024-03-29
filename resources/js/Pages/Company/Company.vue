<template>

    <Head title="Dashboard" />
    <AuthenticatedLayout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <button @click="openModal"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Add Company
                        </button>

                    </div>

                    <a-table :columns="columns" :data-source="companies.data" :pagination="pagination"
                        :loading="loading" @change="handleTableChange">
                        <template #bodyCell="{ column, text, record }">
                            <template v-if="column.key === 'logo'">
                                <a-avatar :src="text" size="large" shape="circular"></a-avatar>
                            </template>
                            <template v-if="column.key === 'website'">
                                <!-- <a-avatar :src="text" size="large" shape="circular"></a-avatar> -->
                                <a :href="text" target="_blank">{{ text }}</a>
                            </template>
                            <template v-if="column.key === 'action'">

                                <button @click="openEditModal(record)" type="button"
                                    class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Edit</button>
                                <a-popconfirm title="Sure to delete?" @confirm="onDelete(record.id)">
                                    <a class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Delete</a>
                                </a-popconfirm>
                            </template>
                        </template>
                    </a-table>
                </div>
            </div>
        </div>
        <div>
            <div v-if="showModal" class="fixed z-10 inset-0 overflow-y-auto">
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <!-- Background overlay -->
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>

                    <!-- Modal content -->
                    <div
                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <!-- Modal header -->
                            <div class="">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Enter Details</h3>
                                    <!-- Form -->
                                    <form @submit.prevent="handleSubmit">
                                        <div class="mb-4">
                                            <label for="name"
                                                class="block text-sm font-medium text-gray-700">Name</label>
                                            <input v-model="form.name" type="text" id="name" name="name"
                                                autocomplete="name"
                                                class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                        <div class="mb-4">
                                            <label for="email"
                                                class="block text-sm font-medium text-gray-700">Email</label>
                                            <input v-model="form.email" type="email" id="email" name="email"
                                                autocomplete="email"
                                                class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                        <div class="mb-4">
                                            <label for="image"
                                                class="block text-sm font-medium text-gray-700">Logo</label>
                                            <input type="file" id="logo" name="logo" @change="handleFileChange"
                                                class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                <img class="h-50 w-40 mt-2" :src="form.logo" alt="Compnay Image">
                                            </div>
                                        <div class="mb-4">
                                            <label for="website"
                                                class="block text-sm font-medium text-gray-700">Website</label>
                                            <input v-model="form.website" type="text" id="website" name="website"
                                                autocomplete="website"
                                                class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>

                                        <!-- Modal footer -->
                                        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                            <button type="submit"
                                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                Save
                                            </button>
                                            <button @click="closeModal"
                                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3'
import { computed, ref } from 'vue';
import { message } from 'ant-design-vue';
const showModal = ref(false);
const editMode = ref(false);
const companyId = ref(null);
const loading = ref(false);
const form = ref({
    name: '',
    email: '',
    website: '',
    logo: null,
});
const props = defineProps({
    companies: Object
});
const columns = [
    { title: 'Name', dataIndex: 'name', key: 'name' },
    { title: 'Email', dataIndex: 'email', key: 'email' },
    { title: 'Logo', dataIndex: 'logo', key: 'logo' },
    { title: 'Website', dataIndex: 'website', key: 'website', scopedSlots: { customRender: 'website' } },
    { title: 'Action', dataIndex: 'action', key: 'action', scopedSlots: { customRender: 'action' } }
];
const pagination = computed(() => ({
    total: props.companies.total,
    current: props.companies.current_page,
    pageSize: props.companies.per_page,
}));

const handleTableChange = (pagination) => {

    loading.value = true;
    const newUrl = `${props.companies.path}?page=${pagination.current}`;
    fetchPaginatedData(newUrl);
}
const fetchPaginatedData = async (url) => {
    try {
        await router.visit(url);
    } catch (error) {
    } finally {
        loading.value = false;
    }
};
const openModal = () => {
    editMode.value = false
    showModal.value = true;
};
const openEditModal = (record) => {
    form.value.name = record.name
    form.value.email = record.email
    form.value.website = record.website
    form.value.logo = record.logo
    companyId.value = record.id
    editMode.value = true
    showModal.value = true
};
const closeModal = () => {
    showModal.value = false;
    form.value = {
        name: '',
        email: '',
        website: '',
        logo: null,
    };
};
const successMessage = async (res)=>{
    message.success({
            content: () => res,
            class: 'custom-class',
            style: {
                marginTop: '10vh',
            },
    });
    updatedData()
}
const errorMessage = (res)=>{
    message.error({
            content: () => res,
            class: 'custom-class',
            style: {
                marginTop: '10vh',
            },
    });
}
const updatedData = ()=>{
    const urlParams = new URLSearchParams(window.location.search);
    const pageParam = urlParams.get('page');
    console.log('pageParam',pageParam)
    if(pageParam != null){
        router.visit(`${props.companies.path}?page=${pageParam}`);
    }else{
        router.visit(`${props.companies.path}`);
    }
}
const handleFileChange = (event) => {
    form.value.logo = event.target.files[0];
};
const onDelete = async (id) => {
    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const response = await axios({
            method: 'DELETE',
            url: route('companies.destroy', { id: id }),
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': csrfToken,
            },
        });
        successMessage(response.data.message)
        closeModal();
    } catch (error) {
        console.error('Error:', error);
    }
};
const handleSubmit = async () => {
    try {
        var formData = new FormData();
        formData.append('name', form.value.name);
        formData.append('email', form.value.email);
        formData.append('website', form.value.website);
        formData.append('logo', form.value.logo);
        
        const routeName = editMode.value ?(formData.append('_method', 'put'),route('companies.update', { id: companyId.value }) ): route('companies.store');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        formData.append('_token', csrfToken);
        console.log('csrfToken: ', csrfToken)
        const response = await axios({
            method: 'POST',
            url: routeName,
            data: formData,
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': csrfToken,
            },
        });
        console.log(response.data);
        successMessage(response.data.message)
        closeModal();
    } catch (error) {
        errorMessage(error.response.data.message)
    }
};
</script>
<style>
.custom-class {
    float: right;
}
</style>