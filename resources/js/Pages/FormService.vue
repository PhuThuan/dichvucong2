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
    'text', 'number', 'checkbox', 'email', 'password', 'file', 'radio', 'select', 'submit', 'range', 'tel', 'search', 'reset', 'image', 'time', 'date', 'month', 'week', 'color', 'url', 'hidden'
]
const dbType = [
    'char', 'varchar', 'int', 'bigint', 'decimal', 'float', 'date', 'time', 'datetime', 'boolean', 'text', 'json', 'enum', 'set', 'blob'
]
const fieldList = ref([0])
const pos = ref(0)
const selectedValue = ref([])
const addField = () => {
    pos.value++
    fieldList.value.push(pos.value)
}
const delField = (value) => {
    fieldList.value = fieldList.value.filter(item => item !== value);
    // const obj = selectedValue.value.find(item => item.id === value);
    // console.log(obj);
    // if (obj) {
    //     selectedValue.value = selectedValue.value.filter(item => item.id !== value)
    // }
    // for (let i in fieldList.value) {
    //     const item = selectedValue.value.find(item => item.id === fieldList.value[i]);
    //     if (item !== undefined) {
    //         item.index = i
    //         break
    //     }
    // }
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

const handleSelectChange = (item, id) => {
    const field = document.getElementById(id).value;
    console.log(field);

    if (field === '2' || field === '6' || field === '7') {
        const row = document.getElementById('row_af' + item);
        if (row !== null) {
            row.remove()
        }
        const hiddenDiv = document.createElement("tr");
        hiddenDiv.id = 'row_af' + item

        hiddenDiv.style.class = "bg-white border-b dark:bg-gray-900 dark:border-gray-700";
        const html = `<td colspan="2" class="px-2 py-2 text-center">Nhập giá trị cho trường</td>
                                <td colspan="5" class="px-2 py-2 flex whitespace-nowrap w-max" style="align-items:center;flex-wrap: wrap;">
                                    <button id="${'btn' + item}" type="button" class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800  rounded-lg  px-5 py-2.5 text-center mr-2 mb-2"><i class="fas fa-plus fa-lg" ></i></button>
                                    <div id="${'div' + item}" class=" text-sm">
                                        
                                    </div>
                                </td>`
        hiddenDiv.innerHTML = html;

        const myElement = document.getElementById("row_f" + item);

        // Chèn phần tử <div> vào sau phần tử "myElement"
        myElement.insertAdjacentElement("afterend", hiddenDiv);
        const button = document.getElementById('btn' + item);
        button.addEventListener('click', () => {
            addItem('div' + item, 'name' + item, item);
        });
    }
    else {
        const row = document.getElementById('row_af' + item);
        if (row !== null) {
            row.remove()
        }
    }

}
const addItem = (id, name, index) => {

    const div = document.createElement("div");
    const divID = 'diva' + pos.value
    div.id = divID
    div.className = "flex text-sm"
    div.style = "align-items:center;"
    const input = document.createElement("input");
    input.type = "text"
    input.name = name
    const idInput = 'input' + pos.value
    input.id = idInput
    input.className = "bg-gray-50 border mt-1  mx-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-50 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
    const divA = document.getElementById(id);
    divA.appendChild(div);
    const myElement = document.getElementById(divID);
    // Chèn phần tử <div> vào sau phần tử "myElement"
    myElement.appendChild(input);
    const del = document.createElement("i");
    del.className = "fas fa-times-circle fa-lg ml-2 mr-2"
    del.style = "color: #ea1f10;cursor: pointer;"
    const Element = document.getElementById(divID);

    // Chèn phần tử <div> vào sau phần tử "myElement"
    Element.appendChild(del);
    del.addEventListener('click', () => {
        const inputID = document.getElementById(idInput);
        inputID.remove()
        del.remove()
    });
    pos.value++
}
// const delItem = (id, value) => {
//     const item = selectedValue.value.find(obj => obj.id === id);

//     if (item) {
//         // Tìm vị trí của giá trị cần xóa trong mảng arr
//         const index = item.arr.indexOf(value);

//         // Kiểm tra nếu giá trị cần xóa tồn tại trong mảng
//         if (index !== -1) {
//             // Xóa giá trị khỏi mảng arr
//             item.arr.splice(index, 1);
//         }
//     }
//     console.log(selectedValue.value);

// }

const submit = () => {
    for (let i of fieldList.value) {
        const field_name = document.getElementById('name' + i).value;
        const html_type = document.getElementById('html' + i).value;
        const db_type = document.getElementById('db' + i).value;
        const label = document.getElementById('label' + i).value;
        const validate = document.getElementById('validate' + i).value;
        const placehoder = document.getElementById('placehoder' + i).value;
        const arr = []

        if (html_type === '2' || html_type === '6' || html_type === '7') {
            const name = 'name' + i
            var inputElements = document.querySelectorAll('input[name="' + name + '"]');
            // Lặp qua từng phần tử và lấy giá trị
            inputElements.forEach(function (input) {
                var inputValue = input.value;
                arr.push(inputValue)
            });
        }
        const object = {
            field_name: field_name,
            html_type: html_type,
            db_type: db_type,
            label: label,
            validate: validate,
            placehoder: placehoder,
            fields_value: arr
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
    // form.post('/admin/service');

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
        <!-- Các Fields -->
        <div class="p-2">
            <h3 class="font-bold">Trường dữ liệu</h3>

            <div class="" style="margin: 0 auto;">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class=" text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <!-- <th scope="col" class="px-6 py-3  whitespace-nowrap text-center w-fit">
                                    STT
                                </th> -->
                                <th scope="col" class="px-6 py-3 w-40 whitespace-nowrap text-center">
                                    Field Name
                                </th>
                                <th scope="col" class="px-6 py-3 w-40 whitespace-nowrap text-center">
                                    Html Type
                                </th>
                                <th scope="col" class="px-6 py-3 w-40 text-center whitespace-nowrap">
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
                        <tbody v-for="(item, index) in fieldList" :key="item">
                            <tr :id="'row_f' + item" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                <!-- <th scope="row" class="px-2 py-2  whitespace-nowrap dark:text-white text-center">
                                    {{ index }}
                                </th> -->
                                <th scope="row" class="px-2 py-2  whitespace-nowrap dark:text-white">
                                    <input type="text" :id="'name' + item" required
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </th>
                                <td class="px-2 py-2 whitespace-nowrap ">
                                    <select :id="'html' + item" @change="handleSelectChange(item, 'html' + item)"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option v-for="(i, y) in htmlType" :key="i" :value="y">{{ i }}</option>
                                    </select>
                                </td>
                                <td class="px-2 py-2 whitespace-nowrap">
                                    <select :id="'db' + item"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option v-for="(i, y) in dbType" :key="i" :value="y">{{ i }}</option>
                                    </select>
                                </td>
                                <td class="px-2 py-2 whitespace-nowrap">
                                    <input type="text" :id="'label' + item" required
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
                <button @click="addField" type="button"
                    class="text-white mt-2 bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Thêm
                    trường</button>
            </div>
        </div>
        <div style="justify-content: center;" class="flex">
            <button type="submit"
                class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center  mr-2 mb-2">Submit</button>
        </div>
    </form>
</template>

<style>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
</style>