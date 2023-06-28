<script setup>
import { ref, onMounted, reactive } from 'vue'
import { Link, useForm } from '@inertiajs/vue3';

import HeaderCustomer from '@/Components/Home_Admin.vue';
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
    // Post
    console.log('Form Data');
    console.log(formData.value);
    // console.log(formValidate.value);

    // Kích hoạt sự kiện ở thành phần con
    submitClicked.value = true;

    // Nếu có field chưa hợp lệ thì sữa exitFlad
    services_fields_array.forEach(element => {
        // console.log(formData.value[element.field_name]);
        if (formValidate.value[element.field_name]?.required) {
            if (!formData.value[element.field_name]) {
                exitFlag = true;
                return;
            }
        }
    });

    if (exitFlag) {
        return; // Thoát khỏi hàm nếu có trường field không hợp lệ
    } else {
        let form = useForm(formData.value);
        // console.log(form);
        form.post(route('dataForm',[props.id]), {
            forceFormData: true,
            onSuccess: () => {
                // Gui form thanh cong
                console.log(props.message);
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
    
    <HeaderCustomer >
    <!-- Popup Model  -->
    <div class="popup-modal">
        <div v-if="isModalOpen" id="popup-modal" tabindex="-1"
            class="flex flex-wrap content-center justify-center fixed top-0 left-0 right-0 z-50 p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="p-[0.5rem] text-center px-[1.5rem] pb-[1.5rem] relative bg-[#d9d9d9] rounded-[1.5rem]">
                <h3 class="mb-[3rem] text-[1.75rem] font-normal text-[#000000]">{{ message }}
                </h3>

                <Link href="/admin/list/service"
                    class="text-[#000000] bg-[#37b6ff] hover:bg-[#58b3e8] focus:outline-none font-medium rounded-full text-sm inline-flex items-center px-5 text-center">
                Xong
                </Link>
            </div>
        </div>
    </div>

    <!-- Form tạo yêu cầu -->
    <form class="px-[2rem] py-[.2rem] text-[1rem]" enctype="multipart/form-data">
        <!-- Tạo input tự động  -->
        <div class="m-[.0rem]" v-for="item in services_fields_array">
            <TextInputs :submitClicked="submitClicked" :services_fields="item" :formData="formData" v-if="item.html_type === 0"
                @textResponse="(data) => formValidate[item.field_name] = data" />
            <NumberInputs :submitClicked="submitClicked" :services_fields="item" :formData="formData" v-if="item.html_type === 1"
                @numberResponse="(data) => formValidate[item.field_name] = data" />
            <CheckboxInputs :submitClicked="submitClicked" :services_fields="item" :formData="formData" v-if="item.html_type === 2"
                @checkboxResponse="(data) => formValidate[item.field_name] = data" />
            <RadioInputs :submitClicked="submitClicked" :services_fields="item" :formData="formData" v-if="item.html_type === 6"
                @radioResponse="(data) => formValidate[item.field_name] = data" />
            <FileInputs :submitClicked="submitClicked" :services_fields="item" :formData="formData" v-if="item.html_type === 5"
                @fileResponse="(data) => formValidate[item.field_name] = data" />
            <AddressInputs :submitClicked="submitClicked" :services_fields="item" :formData="formData" v-if="item.html_type === 21"
                @addressResponse="(data) => formValidate[item.field_name] = data" />
            <ComboboxInputs :submitClicked="submitClicked" :services_fields="item" :formData="formData" v-if="item.html_type === 7"
                @comboboxResponse="(data) => formValidate[item.field_name] = data" />
            <TelInputs :submitClicked="submitClicked" :services_fields="item" :formData="formData" v-if="item.html_type === 10"
                @telResponse="(data) => formValidate[item.field_name] = data" />
        </div>
        
        <div class="mx-[.0rem] mt-[.5rem]">
            <button @click="submitForm" type="button" class="rounded-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium px-5 py-2.5 
            text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-full">
                Gửi</button>
        </div>
    </form>
    
</HeaderCustomer >

</template>