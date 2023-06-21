<script setup>
import { ref, onMounted, reactive } from 'vue'
import { Link, useForm } from '@inertiajs/vue3';

import HeaderCustomer from '@/Components/HeaderCustomer.vue';
import TextInputs from '@/Components/TextInputs.vue';
import NumberInputs from '@/Components/NumberInputs.vue';
import CheckboxInputs from '@/Components/CheckboxInputs.vue';
import RadioInputs from '@/Components/RadioInputs.vue';
import FileInputs from '@/Components/FileInputs.vue';
import AddressInputs from '@/Components/AddressInputs.vue';
import ComboboxInputs from '@/Components/ComboboxInputs.vue';

// Khởi tạo các biến lưu giá trị form
let formData = ref({})
const props = defineProps({
    id: Number,
    services: Array,
});

// Submit form
function submitForm() {
    // Post
    console.log(formData);
    // let form = formData.value;
    let form = useForm(formData.value);
    console.log(form);
    form.post(`/user/service/${props.id}`);
}

// Dữ liệu được prop
// let services = {
//     id: 5,
//     name: 'Đặt lịch khám bệnh',
//     model_name: '?',
//     table_name: '',
//     slug: '',
//     descriptions: '',
//     status: 1,
// }
let services = {}

// Dữ liệu lấy từ Database, mảng field input. http://127.0.0.1:8000/user/service/{id_service}
// let services_fields_array = [
//     {
//         id: 1,
//         services_id: 1,
//         field_name: 'name',
//         html_type: '',
//         db_type: 1,
//         label: 'Họ và tên',
//         validate: 'required',
//         placeholder: 'Nhập họ và tên'
//     },
//     {
//         id: 2,
//         services_id: 1,
//         field_name: 'cccd',
//         html_type: '',
//         db_type: 1,
//         label: 'CCCD/CMND',
//         validate: 'required',
//         placeholder: 'Nhập CCCD/CMND'
//     },
//     {
//         id: 3,
//         services_id: 1,
//         field_name: 'sdt',
//         html_type: '',
//         db_type: 1,
//         label: 'Số điện thoại',
//         validate: 'required',
//         placeholder: 'Nhập SĐT'
//     },
//     {
//         id: 2,
//         services_id: 1,
//         field_name: 'random',
//         html_type: '',
//         db_type: 1,
//         label: 'Ngôn ngữ lập trình',
//         validate: 'max:200',
//         placeholder: 'Nhập một số ngẫu nhiên'
//     },
//     {
//         id: 3,
//         services_id: 2,
//         field_name: 'time',
//         html_type: 'checkbox',
//         db_type: 1,
//         label: 'Chọn thời gian muốn vượt qua',
//         validate: 'required',
//         placeholder: 'chọn',
//     },
//     {
//         id: 4,
//         services_id: 2,
//         field_name: 'test',
//         html_type: 'radio',
//         db_type: 1,
//         label: 'Trắc nghiệm',
//         validate: '',
//         placeholder: '',
//     },
//     {
//         id: 1,
//         services_id: 2,
//         field_name: 'uploadfile',
//         html_type: 'file',
//         db_type: 1,
//         label: 'Upload File',
//         validate: '',
//         placeholder: '',
//     },
//     {
//         id: 4,
//         services_id: 2,
//         field_name: 'address',
//         html_type: 21,
//         db_type: 1,
//         label: 'Địa chỉ',
//         validate: '',
//         placeholder: 'Chọn địa chỉ'
//     },
//     {
//         id: 1,
//         services_id: 2,
//         field_name: 'combobox',
//         html_type: 'combobox',
//         db_type: 1,
//         label: 'Ngôn ngữ lập trình',
//         validate: '',
//         placeholder: 'Chọn một',
//     },
//     {
//         id: 5,
//         services_id: 1,
//         field_name: 'bhyt',
//         html_type: 'text',
//         db_type: 1,
//         label: 'Bảo hiểm y tế',
//         validate: 'required',
//         placeholder: 'Nhập BHYT'
//     },
// ]

// Kiểm tra fetch dữ liệu
let isLoading = ref({});

let services_fields_array = reactive([])

const fetchData = async () => {
    // props.services.forEach((item, index) => {
    //     if (props.id === item.id) {
    //         services = item;
    //         console.log(services);
    //     }
    // })
    // console.log(props.services);
    // isLoading.value = true;
    // // try {
    // //     await axios({
    // //         method: 'get',
    // //         url: `http://127.0.0.1:8000/user/service/${props.id}`,
    // //     }).then(function (response) {
    // //         const tempData = response.data;
    // //         console.log(tempData);
    // //         tempData.forEach(element => {
    // //             if (element.services_id === services.id) {
    // //                 services_fields_array.push(element);
    // //             }
    // //         });
    // //         console.log(services_fields_array);
    // //     })

    // // } catch (error) {
    // //     console.error(error);
    // // }

    console.log(props.services);
    console.log(props.id);
    props.services.forEach(element => {
        if (element.services_id == props.id) {
            services_fields_array.push(element);
            console.log(element);
        }
        console.log(element.services_id);
    });
    isLoading.value = false;

    // services_fields_array = props.services;
    console.log(services_fields_array);
};
// Chạy sau khi render
onMounted(() => {
    fetchData();
})

</script>
<template>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <!-- Header -->
    <HeaderCustomer />

    <!-- sub header -->
    <div
        class="flex text-center font-semibold flex-wrap content-center bg-[#37b6ff] justify-between border-[#000000] border-2">
        <Link href="/" class="flex content-center flex-wrap">
        <span class="material-symbols-outlined ml-[4px]" style="font-size: 3rem;">
            arrow_back
        </span>
        </Link>
        <div class="flex content-center text-[1rem] flex-wrap">
            {{ services.name }}
        </div>
        <Link href="/customer-filter" class="flex content-center flex-wrap">
        <span class="material-symbols-outlined mr-[4px]" style="font-size: 3rem;">
            qr_code_scanner
        </span>
        </Link>
    </div>

    <!-- Form tạo yêu cầu -->
    <form @submit.prevent="submitForm" class="px-[2rem] py-[.2rem] text-[1rem]" enctype="multipart/form-data">
        <!-- Tạo input  -->
        <div class="m-[.0rem]" v-for="item in services_fields_array">
            <TextInputs :services_fields="item" :formData="formData" v-if="item.html_type === 0" />
            <NumberInputs :services_fields="item" :formData="formData" v-if="item.html_type === 1" />
            <CheckboxInputs :services_fields="item" :formData="formData" v-if="item.html_type === 2" />
            <RadioInputs :services_fields="item" :formData="formData" v-if="item.html_type === 6" />
            <FileInputs :services_fields="item" :formData="formData" v-if="item.html_type === 5" />
            <AddressInputs :services_fields="item" :formData="formData" v-if="item.html_type === 21" />
            <ComboboxInputs :services_fields="item" :formData="formData" v-if="item.html_type === 7" />
        </div>

        <div class="mx-[.0rem] mt-[.5rem]">
            <button @click="submitForm" class="rounded-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium px-5 py-2.5 
            text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-full">
                Gửi</button>
        </div>
    </form>
</template>