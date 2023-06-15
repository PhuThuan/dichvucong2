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

let dataFields = []
let serviceField = {
    name: '',
    model_name: '',
    table_name: '',
    slug: '',
    description: '',
    status: '1',
}


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
            placehoder: placehoder,
            fields_value : {[field_name] : ['123','456','631']}  ,
        }
        dataFields.push(object)
    };

    let form = useForm({
        name: serviceField.name,
        model_name: serviceField.model_name,
        table_name: serviceField.table_name,
        slug: serviceField.slug,
        description: serviceField.description,
        status: serviceField.status ?? '1',
        fields: dataFields,
        
    });
    console.log(form);
    form.post('/admin/service');

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
                <input type="text" id="nameService" v-model="serviceField.name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Nhập tên dịch vụ" required>
            </div>
            <div>
                <label for="name_model" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tên
                    Model</label>
                <input type="text" id="name_model" v-model="serviceField.model_name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Nhập tên Model" required>
            </div>
            <div>
                <label for="table" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tên Table</label>
                <input type="text" id="table" v-model="serviceField.table_name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Nhập tên bảng dữ liệu" required>
            </div>
            <div>
                <label for="slug" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Slug</label>
                <input type="text" id="slug" v-model="serviceField.slug"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Nhập slug" required>
            </div>
            <div>
                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mô tả</label>
                <textarea id="message" rows="4" v-model="serviceField.description"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Nhập mô tả..."></textarea>
            </div>
            <div>
                <div class="flex align-items">
                    <label class="mr-3 block mb-2 text-sm font-medium text-gray-900 dark:text-white">Trạng thái:</label>
                    <div>
                        <input checked id="default-radio-1" type="radio" value="1" name="default-radio"
                            v-model="serviceField.status"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="default-radio-1"
                            class="mr-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Hiển thị</label>
                    </div>
                    <div>
                        <input id="default-radio-2" type="radio" value="0" name="default-radio"
                            v-model="serviceField.status"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="default-radio-2" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Không
                            hiển thị</label>
                    </div>
                </div>
            </div>
        </div>
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
           

        </div>
        <button type="submit"
            class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Tiếp
            tục</button>
    </form>
    <button @click="addField" 
                class="text-white mt-2 bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Thêm
                trường</button>
</template>

<style>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
</style>