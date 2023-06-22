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
    notification: String,
});

// Trạng thái popup thông báo
let isModalOpen = ref(false);

// Các hàm tắt mở model
function openModal() {
    isModalOpen.value = true;
};
function closeModal() {
    // Chuyển hướng đến trang chủ
    window.location.href = 'http://127.0.0.1:8000/';
};

// Submit form
function submitForm() {
    // Post
    console.log(formData);
    // let form = formData.value;
    let form = useForm(formData.value);
    console.log(form);
    form.post(`/user/service/${props.id}`);
    if (props.notification === 'Tạo thành công') {
        openModal();
    }
    console.log('notification'+props.flash.message);
}

let services = {}

// Kiểm tra fetch dữ liệu
let isLoading = ref({});

let services_fields_array = reactive([])

const fetchData = async () => {
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

    <!-- Popup Model  -->
    <div class="popup-modal">
        <!-- <button @click="openModal"
            class="block text-white bg-blue-700 hover:bg-blue-800 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center"
            type="button">
            Toggle modal
        </button> -->

        <div v-if="isModalOpen" id="popup-modal" tabindex="-1"
            class="flex flex-wrap content-center justify-center fixed top-0 left-0 right-0 z-50 p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="p-[0.5rem] text-center px-[1.5rem] pb-[1.5rem] relative bg-[#d9d9d9] rounded-[1.5rem]">
                <h3 class="mb-[3rem] text-[1.75rem] font-normal text-[#000000]">{{ notification }}
                </h3>
                <button @click="closeModal" data-modal-hide="popup-modal" type="button"
                    class="text-[#000000] bg-[#37b6ff] hover:bg-[#58b3e8] focus:outline-none font-medium rounded-full text-sm inline-flex items-center px-5 text-center">
                    Xong
                </button>
            </div>
        </div>
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