<script setup>
import { Link } from '@inertiajs/vue3';
// import TextInputs from './TextInputs.vue';
// import NumberInputs from './NumberInputs.vue';
// import CheckboxInputs from './CheckboxInputs.vue';
// import RadioInputs from './RadioInputs.vue';
// import FileInputs from './FileInputs.vue';
// import AddressInputs from './AddressInputs.vue';
// import ComboboxInputs from './ComboboxInputs.vue';

import HeaderCustomer from '@/Components/HeaderCustomer.vue';
import TextInputs from '@/Components/TextInputs.vue';
import NumberInputs from '@/Components/NumberInputs.vue';
import CheckboxInputs from '@/Components/CheckboxInputs.vue';
import RadioInputs from '@/Components/RadioInputs.vue';
import FileInputs from '@/Components/FileInputs.vue';
import AddressInputs from '@/Components/AddressInputs.vue';
import ComboboxInputs from '@/Components/ComboboxInputs.vue';

let services = {
    id: 1,
    name: 'Đặt lịch khám bệnh',
    model_name: '?',
    table_name: '',
    slug: '',
    descriptions: '',
    status: 1,
}
let services_fields_Array = [
    {
        id: 1,
        services_id: 1,
        field_name: 'name',
        html_type: 'text',
        db_type: 1,
        label: 'Họ và tên',
        validate: 'required',
        placeholder: 'Nhập họ và tên'
    },
    {
        id: 2,
        services_id: 1,
        field_name: 'cccd',
        html_type: 'text',
        db_type: 1,
        label: 'CCCD/CMND',
        validate: 'required',
        placeholder: 'Nhập CCCD/CMND'
    },
    {
        id: 3,
        services_id: 1,
        field_name: 'phone',
        html_type: 'text',
        db_type: 1,
        label: 'Số điện thoại',
        validate: 'required',
        placeholder: 'Nhập SĐT'
    },
    // {
    //     id: 2,
    //     services_id: 1,
    //     field_name: 'random',
    //     html_type: 'number',
    //     db_type: 1,
    //     label: 'Ngôn ngữ lập trình',
    //     validate: 'max:200',
    //     placeholder: 'Nhập một số ngẫu nhiên'
    // },
    // {
    //     id: 3,
    //     services_id: 2,
    //     field_name: 'time',
    //     html_type: 'checkbox',
    //     db_type: 1,
    //     label: 'Chọn thời gian muốn vượt qua',
    //     validate: 'required',
    //     placeholder: 'chọn'
    // },
    // {
    //     id: 4,
    //     services_id: 2,
    //     field_name: 'test',
    //     html_type: 'radio',
    //     db_type: 1,
    //     label: 'Trắc nghiệm',
    //     validate: '',
    //     placeholder: ''
    // },
    // {
    //     id: 1,
    //     services_id: 2,
    //     field_name: 'uploadfile',
    //     html_type: 'file',
    //     db_type: 1,
    //     label: 'Upload File',
    //     validate: '',
    //     placeholder: ''
    // },
    {
        id: 4,
        services_id: 2,
        field_name: 'address',
        html_type: 'address',
        db_type: 1,
        label: 'Địa chỉ',
        validate: '',
        placeholder: 'Chọn địa chỉ'
    },
    // {
    //     id: 1,
    //     services_id: 2,
    //     field_name: 'combobox',
    //     html_type: 'combobox',
    //     db_type: 1,
    //     label: 'Ngôn ngữ lập trình',
    //     validate: '',
    //     placeholder: 'Chọn một'
    // },
    {
        id: 5,
        services_id: 1,
        field_name: 'bhyt',
        html_type: 'text',
        db_type: 1,
        label: 'Bảo hiểm y tế',
        validate: 'required',
        placeholder: 'Nhập BHYT'
    },
]

let service_field_value = [
    {
        id: 1,
        services_fields_id: 2,
        name: 'Java', // Nội dung input radio, select,...
    }, {
        id: 1,
        services_fields_id: 2,
        name: 'C++', // Nội dung input radio, select,...
    },
]

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
    <form class="px-[2rem] py-[.2rem] text-[1rem]">
        <!-- Tạo input  -->
        <div class="m-[.0rem]" v-for="item in services_fields_Array">
            <TextInputs :services_fields="item" :service_field_value="service_field_value"
                v-if="item.html_type === 'text'" />
            <NumberInputs :services_fields="item" :service_field_value="service_field_value"
                v-if="item.html_type === 'number'" />
            <CheckboxInputs :services_fields="item" :service_field_value="service_field_value"
                v-if="item.html_type === 'checkbox'" />
            <RadioInputs :services_fields="item" :service_field_value="service_field_value"
                v-if="item.html_type === 'radio'" />
            <FileInputs :services_fields="item" :service_field_value="service_field_value"
                v-if="item.html_type === 'file'" />
            <AddressInputs :services_fields="item" :service_field_value="service_field_value"
                v-if="item.html_type === 'address'" />
            <ComboboxInputs :services_fields="item" :service_field_value="service_field_value"
                v-if="item.html_type === 'combobox'" />
        </div>

        <div class="mx-[.0rem] mt-[.5rem]">
            <button type="submit" class="rounded-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium px-5 py-2.5 
            text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-full">
                Gửi</button>
        </div>
    </form>
</template>