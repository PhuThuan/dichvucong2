<script setup>
import { ref, onMounted, reactive } from 'vue'
import { Link, useForm, Head } from '@inertiajs/vue3';

import HeaderCustomer from '@/Components/HeaderCustomer.vue';
import TextInputs from '@/Components/TextInputs.vue';
import NumberInputs from '@/Components/NumberInputs.vue';
import CheckboxInputs from '@/Components/CheckboxInputs.vue';
import RadioInputs from '@/Components/RadioInputs.vue';
import FileInputs from '@/Components/FileInputs.vue';
import AddressInputs from '@/Components/AddressInputs.vue';
import ComboboxInputs from '@/Components/ComboboxInputs.vue';
import TelInputs from '@/Components/TelInputs.vue';

// Khởi tạo các biến lưu giá trị form
let formData = ref({})
const props = defineProps({
    id: Number,
    services: Array,
    message: String,
    service_name: {},
});

const formValidate = ref({})

let submitClicked = ref(false);

// Trạng thái popup thông báo
let isModalOpen = ref(false);

// Các hàm tắt mở model
function openModal() {
    isModalOpen.value = true;
};

// Submit form
async function submitForm() {
    let exitFlag = false;

    // Kích hoạt sự kiện xác thực ở thành phần con
    submitClicked.value = true;

    // Nếu có field chưa hợp lệ thì sữa exitFlad
    services_fields_array.forEach(element => {
        // Tao formData default
        if (!formData.value[element.field_name])
            formData.value[element.field_name] = '';
        // console.log(formData.value[element.field_name]);
        if (formValidate.value[element.field_name]?.required) {
            if (!formData.value[element.field_name]) {
                exitFlag = true;
                return;
            }
        }
    });

    // Post
    console.log('Form Data');
    console.log(formData.value);
    // console.log(formValidate.value);

    if (exitFlag) {
        return; // Thoát khỏi hàm nếu có trường field không hợp lệ
    } else {
        let form = useForm(formData.value);
        // console.log(form);
        form.post(`/user/service/${props.id}`, {
            onSuccess: () => {
                // Gui form thanh cong
                if (props.message) {
                    openModal();
                }
            }
        })
    }
}

let services = {}

// Kiểm tra fetch dữ liệu
let isLoading = ref({});

let services_fields_array = reactive([])

const fetchData = async () => {
    // console.log(props.services);
    // console.log(props.id);
    props.services.forEach(element => {
        if (element.services_id == props.id) {
            services_fields_array.push(element);
            // console.log(element);
        }
        // console.log(element.services_id);
    });
    isLoading.value = false;
    // console.log(services_fields_array);
};
// Chạy sau khi render
onMounted(() => {
    fetchData();
})
</script>

<template>
    <section class="bg-[#ffffff] pb-[.5rem]">
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        
        <Head title="Đăng Ký Dịch Vụ" />
        <!-- Header -->
        <HeaderCustomer />

        <!-- Popup Model  -->
        <div class="popup-modal">
            <div v-if="isModalOpen" id="popup-modal" tabindex="-1"
                class="flex flex-wrap content-center justify-center fixed top-0 left-0 right-0 z-50 p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="text-center px-[1rem] py-[.5rem] relative bg-[#fff6f6] rounded-[.25rem]">
                    <h3 class="mb-[3rem] text-[1.75rem] font-normal">{{ message }}
                    </h3>
                    <Link href="/"
                        class="bg-[#37b6ff] text-[#ffffff] hover:bg-[#58b3e8] focus:outline-none font-medium rounded-full text-sm inline-flex items-center px-5 text-center">
                    Xong
                    </Link>
                </div>
            </div>
        </div>

        <!-- Form tạo yêu cầu -->
        <form
            class="text-[#4f4f4f] px-[2rem] py-[.2rem] text-[1rem] w-[90%] sm:w-[40rem] sm:px-[4rem] sm:py-[1rem] mx-auto bg-[#ffffff] my-[1rem] rounded-[.25rem] shadow-lg"
            enctype="multipart/form-data">
            <!-- sub header -->
            <nav class="flex text-center font-semibold flex-wrap content-center justify-between my-[.5rem] sm:my-[1rem]">
                <div class="w-[2rem]">
                </div>
                <div class="flex content-center text-[1.5rem] flex-wrap">
                    {{ props.service_name.name }}
                </div>
                <Link href="#" class="flex content-center flex-wrap">
                <span title="Quét QR để điền thông tin tự động"
                    class="material-symbols-outlined rounded-[.25rem] hover:bg-[#58b3e8] hover:text-[#f1f5f9] focus:ring-4 focus:outline-none focus:ring-blue-300"
                    style="font-size: 2rem;">
                    qr_code_scanner
                </span>
                </Link>
            </nav>

            <!-- Tạo input tự động  -->
            <div class="m-[.0rem]" v-for="item in services_fields_array">
                <TextInputs @keyup.enter="submitForm" :submitClicked="submitClicked" :services_fields="item"
                    :formData="formData" v-if="item.html_type === 0"
                    @textResponse="(data) => formValidate[item.field_name] = data" />
                <NumberInputs @keyup.enter="submitForm" :submitClicked="submitClicked" :services_fields="item"
                    :formData="formData" v-if="item.html_type === 1"
                    @numberResponse="(data) => formValidate[item.field_name] = data" />
                <CheckboxInputs @keyup.enter="submitForm" :submitClicked="submitClicked" :services_fields="item"
                    :formData="formData" v-if="item.html_type === 2"
                    @checkboxResponse="(data) => formValidate[item.field_name] = data" />
                <RadioInputs @keyup.enter="submitForm" :submitClicked="submitClicked" :services_fields="item"
                    :formData="formData" v-if="item.html_type === 6"
                    @radioResponse="(data) => formValidate[item.field_name] = data" />
                <FileInputs @keyup.enter="submitForm" :submitClicked="submitClicked" :services_fields="item"
                    :formData="formData" v-if="item.html_type === 5"
                    @fileResponse="(data) => formValidate[item.field_name] = data" />
                <AddressInputs @keyup.enter="submitForm" :submitClicked="submitClicked" :services_fields="item"
                    :formData="formData" v-if="item.html_type === 21"
                    @addressResponse="(data) => formValidate[item.field_name] = data" />
                <ComboboxInputs @keyup.enter="submitForm" :submitClicked="submitClicked" :services_fields="item"
                    :formData="formData" v-if="item.html_type === 7"
                    @comboboxResponse="(data) => formValidate[item.field_name] = data" />
                <TelInputs @keyup.enter="submitForm" :submitClicked="submitClicked" :services_fields="item" :formData="formData"
                    v-if="item.html_type === 10" @telResponse="(data) => formValidate[item.field_name] = data" />
            </div>

            <div class="mx-[.0rem] m-[1rem] text-center">
                <button @click="submitForm" type="button" class="rounded-[.25rem] text-white bg-[#1c4ed8] hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium px-5 py-2.5 
                text-center">
                    Đăng Ký Dịch Vụ</button>
            </div>
        </form>
    </section>
</template>