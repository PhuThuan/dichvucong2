<script setup>
import { ref, onMounted, reactive } from 'vue'
import { Link, useForm, Head } from '@inertiajs/vue3';

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
    service_name: {},
});
const serviceName = ref();

const formValidate = ref({})

let submitClicked = ref(false);

const isModalOpen = ref(false)
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
        form.post(`/admin/service/post/${props.id}`, {
            onSuccess: () => {
                // Gui form thanh cong
                if (props.message) {
                    modalNotication.showModal();
                }
            }
        })
    }
}

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
    serviceName.value = props.service_name.name;
})
</script>

<template>
    <section class="bg-[#ffffff] pb-[.5rem]">
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <Head title="Đăng Ký Dịch Vụ" />
        <!-- Header -->
        <HeaderCustomer >

        <!-- Popup Modal DaisyUI -->
        <dialog id="modalNotication" class="modal modal-bottom sm:modal-middle">
            <form method="dialog" class="modal-box">
                <h3 class="font-bold text-lg">Thông báo</h3>
                <p class="py-4">{{ message }}</p>
                <div class="modal-action">
                    <!-- if there is a button in form, it will close the modal -->
                    <!-- <Link href="/"><button class="btn">Đóng</button></Link> -->
                    <!-- if there is a button in form, it will close the modal -->
                    <Link href="/admin/list/service" v-if="props.message == 'Đã thêm yêu cầu thành công'"><button
                        class="btn">Đóng</button></Link>
                    <button v-else @click="isModalOpen = false" class="btn">Đóng</button>
                </div>
            </form>
        </dialog>
        

        <!-- Form tạo yêu cầu -->
        <form
            class="text-[#4f4f4f] px-[2rem] py-[.2rem] text-[1rem] w-[90%] sm:w-[40rem] sm:px-[4rem] sm:py-[1rem] mx-auto bg-[#ffffff] my-[1rem] rounded-[.25rem] shadow-lg"
            enctype="multipart/form-data">
            <!-- sub header -->
            <nav class="flex text-center font-semibold flex-wrap content-center justify-between my-[.5rem] sm:my-[1rem]">
                <div class="w-[2rem]">
                </div>
                <div class="flex content-center text-[1.5rem] flex-wrap">
                    {{ props.service_name?.name }}
                </div>
                <Link href="#" class="flex content-center flex-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" style="font-size: 2rem;" width="30" height="30" fill="currentColor"
                    class="bi bi-qr-code-scan rounded-[.25rem] focus:ring-4 focus:outline-none focus:ring-blue-300"
                    viewBox="0 0 16 16">
                    <path
                        d="M0 .5A.5.5 0 0 1 .5 0h3a.5.5 0 0 1 0 1H1v2.5a.5.5 0 0 1-1 0v-3Zm12 0a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0V1h-2.5a.5.5 0 0 1-.5-.5ZM.5 12a.5.5 0 0 1 .5.5V15h2.5a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5v-3a.5.5 0 0 1 .5-.5Zm15 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1H15v-2.5a.5.5 0 0 1 .5-.5ZM4 4h1v1H4V4Z" />
                    <path d="M7 2H2v5h5V2ZM3 3h3v3H3V3Zm2 8H4v1h1v-1Z" />
                    <path d="M7 9H2v5h5V9Zm-4 1h3v3H3v-3Zm8-6h1v1h-1V4Z" />
                    <path
                        d="M9 2h5v5H9V2Zm1 1v3h3V3h-3ZM8 8v2h1v1H8v1h2v-2h1v2h1v-1h2v-1h-3V8H8Zm2 2H9V9h1v1Zm4 2h-1v1h-2v1h3v-2Zm-4 2v-1H8v1h2Z" />
                    <path d="M12 9h2V8h-2v1Z" />
                </svg>
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
                <TelInputs @keyup.enter="submitForm" :submitClicked="submitClicked" :services_fields="item"
                    :formData="formData" v-if="item.html_type === 10"
                    @telResponse="(data) => formValidate[item.field_name] = data" />
            </div>

            <div class="mx-[.0rem] m-[1rem] text-center">
                <button @click="submitForm" type="button" class="rounded-[.25rem] text-white bg-[#1c4ed8] hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium px-5 py-2.5 
                text-center">
                    Đăng Ký Dịch Vụ</button>
            </div>
        </form>
    </HeaderCustomer>
    </section>
</template>
