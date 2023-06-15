<script setup>

import HeaderAdmin from '@/Components/HeaderAdmin.vue'
import { ref } from 'vue'
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    model_name: '',
    table_name: '',
    slug: '',
    description: '',
    status: '1',
});


const submit = () => {
    console.log(form);
    form.post(route('post3'));

};
</script>


<template>
    <Head title="Thêm Dịch Vụ" />
    <HeaderAdmin>
        <div class=" p-2" style="">
            <i class="fas fa-arrow-left text-2xl float-left"></i>
            <div style="width: 14rem; margin: 0 auto;" class="whitespace-nowrap">
                <p class="text-black text-xl font-bold pr-0">Thêm dịch vụ</p>
            </div>
        </div>
    </HeaderAdmin>
    <form @submit.prevent="submit" class="p-3 w-full">
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
                <label for="nameService" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tên dịch
                    vụ</label>
                <input type="text" id="nameService" v-model="form.name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Nhập tên dịch vụ" required>
            </div>
            <div>
                <label for="name_model" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tên
                    Model</label>
                <input type="text" id="name_model" v-model="form.model_name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Nhập tên Model" required>
            </div>
            <div>
                <label for="table" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tên Table</label>
                <input type="text" id="table" v-model="form.table_name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Nhập tên bảng dữ liệu" required>
            </div>
            <div>
                <label for="slug" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Slug</label>
                <input type="text" id="slug" v-model="form.slug"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Nhập slug" required>
            </div>
            <div>
                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mô tả</label>
                <textarea id="message" rows="4" v-model="form.description"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Nhập mô tả..."></textarea>
            </div>
            <div>
                <div class="flex align-items">
                    <label class="mr-3 block mb-2 text-sm font-medium text-gray-900 dark:text-white">Trạng thái:</label>
                    <div>
                        <input checked id="default-radio-1" type="radio" value="1" name="default-radio"
                            v-model="form.status"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="default-radio-1"
                            class="mr-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Hiển thị</label>
                    </div>
                    <div>
                        <input id="default-radio-2" type="radio" value="0" name="default-radio" v-model="form.status"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="default-radio-2" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Không
                            hiển thị</label>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit"
            class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Tiếp
            tục</button>
    </form>
</template>

<style>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
</style>