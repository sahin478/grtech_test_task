<template>

    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <button @click="openModal"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Add Employee
                        </button>

                    </div>

                    <a-table v-if="employees.data" :columns="columns" :data-source="employees.data"
                        :pagination="pagination" :loading="loading" @change="handleTableChange">
                        <template #bodyCell="{ column, text, record }">
                            <template v-if="column.key === 'company_id'">
                                <button @click="openCompanyModal(record.company)" class="text-blue-500 hover:underline">{{ record.company.name }}</button>
                            </template>
                            <template v-if="column.key === 'action'">

                                <button @click="openEditModal(record)" type="button"
                                    class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Edit</button>
                                <a-popconfirm title="Sure to delete?" @confirm="onDelete(record.id)">
                                    <a
                                        class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Delete</a>
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
                                            <label for="first_name"
                                                class="block text-sm font-medium text-gray-700">First
                                                Name</label>
                                            <input v-model="form.first_name" type="text" id="first_name"
                                                name="first_name" autocomplete="first_name"
                                                class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                        <div class="mb-4">
                                            <label for="last_name" class="block text-sm font-medium text-gray-700">Last
                                                Name</label>
                                            <input v-model="form.last_name" type="text" id="last_name" name="last_name"
                                                autocomplete="last_name"
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
                                            <label for="website_id"
                                                class="block text-sm font-medium text-gray-700">Company</label>
                                            <select v-model="form.company_id" id="company_id" name="company_id"
                                                class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">

                                                <option disabled value="">Select a company</option>
                                                <!-- Placeholder option -->
                                                <option v-for="company in companies" :key="company.id"
                                                    :value="company.id">
                                                    {{ company.name }}
                                                </option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label for="phone"
                                                class="block text-sm font-medium text-gray-700">Phone</label>
                                            <input v-model="form.phone" type="tel" id="phone" name="phone"
                                                autocomplete="phone"
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
             <!-- Company Modal -->
             <div v-if="showCompanyModal" class="fixed z-10 inset-0 overflow-y-auto">
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
                                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Company Details</h3>
                                    <!-- Form -->
                                 
                                        <div class="mb-4">
                                            <label for="name"
                                                class="block text-sm font-medium text-gray-700">Name</label>
                                            <input v-model="company.name" type="text" id="name" name="name"
                                                autocomplete="name"
                                                readonly
                                                class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                        <div class="mb-4">
                                            <label for="email"
                                                class="block text-sm font-medium text-gray-700">Email</label>
                                            <input v-model="company.email" type="email" id="email" name="email"
                                                autocomplete="email"
                                                class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                        <div class="mb-4">
                                            <label for="image"
                                                class="block text-sm font-medium text-gray-700">Logo</label>
                                                <img class="h-50 w-40 mt-2" :src="company.logo" alt="Compnay Image">
                                            
                                        </div>
                                        <div class="mb-4">
                                            <label for="website"
                                                class="block text-sm font-medium text-gray-700">Website</label>
                                            <input v-model="company.website" type="text" id="website" name="website"
                                                autocomplete="website"
                                                class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>

                                        <!-- Modal footer -->
                                        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                           
                                            <button @click="closeModal"
                                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm">
                                                Cancel
                                            </button>
                                        </div>
                                    
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
const showCompanyModal = ref(false);
const editMode = ref(false);
const companyId = ref(null);
const loading = ref(false);
const form = ref({
    first_name: '',
    last_name: '',
    email: '',
    company_id: '',
    phone: '',
});
const company = ref({
    name: '',
    email: '',
    website: '',
    logo: null,
});
const props = defineProps({
    employees: Object,
    companies: Object,
});
const columns = [
    { title: 'First Name', dataIndex: 'first_name', key: 'first_name' },
    { title: 'Last Name', dataIndex: 'last_name', key: 'last_name' },
    { title: 'Email', dataIndex: 'email', key: 'email' },
    { title: 'Company', dataIndex: 'company_id', key: 'company_id' },
    { title: 'Phone', dataIndex: 'phone', key: 'phone' },
    { title: 'Action', dataIndex: 'action', key: 'action', scopedSlots: { customRender: 'action' } }
];
const pagination = computed(() => ({
    total: props.employees ? props.employees.total : 0,
    current: props.employees ? props.employees.current_page : 0,
    pageSize: props.employees ? props.employees.per_page : 0,
}));

const handleTableChange = (pagination) => {

    loading.value = true;
    const newUrl = `${props.employees.path}?page=${pagination.current}`;
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
    form.value.first_name = record.first_name
    form.value.last_name = record.last_name
    form.value.email = record.email
    form.value.company_id = record.company_id
    form.value.phone = record.phone
    companyId.value = record.id
    editMode.value = true
    showModal.value = true
};
const closeModal = () => {
    showModal.value = false;
    showCompanyModal.value = false;
    form.value = {
        first_name: '',
        last_name: '',
        email: '',
        company_id: '',
        phone: '',
    };
};
const openCompanyModal = (data) => {
    console.log(data.name)
    showCompanyModal.value = true;
    company.value.name = data.name;
    company.value.email = data.email;
    company.value.website = data.website;
    // If you want to display the company logo in the modal, you can set it here as well
    company.value.logo = data.logo;
    // showModal.value = true;
};
const successMessage = async (res) => {
    message.success({
        content: () => res,
        class: 'custom-class',
        style: {
            marginTop: '10vh',
        },
    });
    updatedData()
}
const errorMessage = (res) => {
    message.error({
        content: () => res,
        class: 'custom-class',
        style: {
            marginTop: '10vh',
        },
    });
}
const updatedData = () => {
    const urlParams = new URLSearchParams(window.location.search);
    const pageParam = urlParams.get('page');
    console.log('pageParam', pageParam)
    if (pageParam != null) {
        router.visit(`${props.employees.path}?page=${pageParam}`);
    } else {
        router.visit(`${props.employees.path}`);
    }
}

const onDelete = async (id) => {
    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const response = await axios({
            method: 'DELETE',
            url: route('employees.destroy', { id: id }),
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
        formData.append('first_name', form.value.first_name);
        formData.append('last_name', form.value.last_name);
        formData.append('email', form.value.email);
        formData.append('company_id', form.value.company_id);
        formData.append('phone', form.value.phone);
        const routeName = editMode.value ? route('employees.update', { id: companyId.value }) : route('employees.store');
        const method = editMode.value ? 'put' : 'post';
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        formData.append('_token', csrfToken);
        console.log('csrfToken: ', csrfToken)
        const response = await axios({
            method: method,
            url: routeName,
            data: formData,
            headers: {
                'Content-Type': 'application/json',
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