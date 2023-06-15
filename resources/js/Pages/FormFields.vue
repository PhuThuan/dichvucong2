<script setup>
import HeaderAdmin from '@/Components/HeaderAdmin.vue'
import { ref } from 'vue'

import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
const htmlType = [
    'text', 'number', 'checkbox', 'email', 'password', 'file', 'radio', 'submit', 'range', 'tel', 'search', 'reset', 'image', 'time', 'date', 'month', 'week', 'color', 'url', 'hidden'
]
const dbType = [
    'char', 'varchar', 'int', 'bigint', 'decimal', 'float', 'date', 'time', 'datetime', 'boolean', 'text', 'json', 'enum', 'set', 'blob'
]
const fieldList = ref([0])
const pos = ref(0)
const addField = () => {
    pos.value++
    fieldList.value.push(pos.value)
}
const delField = (value) => {
    fieldList.value = fieldList.value.filter(item => item !== value);

}

const data = []

const submit = () => {

    for (let i in fieldList.value) {
        const field_name = document.getElementById('name' + i).value;
        const html_type = document.getElementById('html' + i).value;
        const db_type = document.getElementById('db' + i).value;
        const label = document.getElementById('label' + i).value;
        const validate = document.getElementById('validate' + i).value;
        const placehoder = document.getElementById('placehoder' + i).value;
        const object = {
            field_name: field_name,
            html_type: html_type,
            db_type: db_type,
            label: label,
            validate: validate,
            placehoder: placehoder
        }
        data.push(object)
    };

    const form = useForm(data)
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
    <div class="p-2">
        <h3 class="font-bold">Trường dữ liệu</h3>

        <div class="" style="margin: 0 auto;">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3 w-40 whitespace-nowrap text-center">
                                Field Name
                            </th>
                            <th scope="col" class="px-6 py-3 w-40 whitespace-nowrap text-center">
                                Html Type
                            </th>
                            <th scope="col" class="px-6 py-3 w-40 text-center">
                                DB Type
                            </th>
                            <th scope="col" class="px-6 py-3 w-40 text-center">
                                Label
                            </th>
                            <th scope="col" class="px-6 py-3 w-40 text-center">
                                Validate
                            </th>
                            <th scope="col" class="px-6 py-3 w-40 text-center">
                                Placehoder
                            </th>
                            <th scope="col" class="px-6 py-3 w-40 text-center">
                                Xóa
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in fieldList" :key="item"
                            class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                            <th scope="row" class="px-2 py-2  whitespace-nowrap dark:text-white">
                                <input type="text" :id="'name' + item"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            </th>
                            <td class="px-2 py-2 whitespace-nowrap ">
                                <select :id="'html' + item"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option v-for="i in htmlType" :key="i" :value="i">{{ i }}</option>
                                </select>
                            </td>
                            <td class="px-2 py-2 whitespace-nowrap">
                                <select :id="'db' + item"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option v-for="i in dbType" :key="i" :value="i">{{ i }}</option>
                                </select>
                            </td>
                            <td class="px-2 py-2 whitespace-nowrap">
                                <input type="text" :id="'label' + item"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            </td>
                            <td class="px-2 py-2 whitespace-nowrap">
                                <input type="text" :id="'validate' + item"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            </td>
                            <td class="px-2 py-2 whitespace-nowrap">
                                <input type="text" :id="'placehoder' + item"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            </td>
                            <td class="px-2 py-2 whitespace-nowrap text-center">
                                <i class="far fa-trash-alt fa-lg" style="color: #ea0b0b; cursor: pointer;"
                                    @click="delField(item)"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <button @click="addField"
            class="text-white mt-2 bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Thêm
            trường</button>
        <button type="button" @click="submit"
            class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Tiếp
            tục</button>
    </div>
</template>

<style>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
</style>