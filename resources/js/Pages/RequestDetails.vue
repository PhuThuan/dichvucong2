<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Home_Admin from '@/Components/Home_Admin.vue';

import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed, ref, onMounted } from 'vue';
const message = ref('')
const showToast = ref(false)
const isProcessed = ref(false)
const data = ['zzz', '123', '1234', 'Cần Thơ']
const field = ['Họ và tên', 'CCCD', 'Số điện thoại', 'Địa chỉ']
const service = {
    id: 1,
    name: 'Đặt lịch khám bệnh'
}
onMounted(() => {

})


const showAndHideToast = (content) => {
    showToast.value = true;
    message.value = content
    setTimeout(() => {
        showToast.value = false;
    }, 1000);
}
const copyText = (id) => {
    // const input = document.getElementById(id);
    navigator.clipboard.writeText(id)
        .then(() => {
            showAndHideToast('Đã sao chép thành công!')
            console.log('Đã sao chép thành công!');
        })
        .catch((error) => {
            showAndHideToast('Lỗi sao chép')
            console.error('Lỗi sao chép:', error);
        });
}
</script>


<template>
    <Head title="Chi Tiết Yêu Cầu" />
    <Home_Admin>
        <div  class="w-full text-center font-bold text-base">
            <h3>Mã yêu cầu: xzz</h3>
        </div>
        <div class="font-bold text-base p-3 ">
            <div class="flex p-2 items-center " v-for="(i, index) in data">
                <strong class="mr-2 ">{{ field[index] }}: </strong>
                <strong class="mr-2 ">{{ i }}</strong>
                <i class="fas fa-clone fa-lg" style="color: #b3b4b7;cursor: pointer;" @click="copyText(i)"></i>
            </div>

            <div class="flex p-2 items-center">
                <strong class="mr-2 ">Dịch vụ đã chọn:</strong>
                <strong class="mr-2 ">{{ service.name }}</strong>
            </div>
            <div class="flex w-full text-center p-3 mt-2" style="margin: 0 auto;">
                <h6 class="mr-4">Trạng thái: </h6>
                <div>
                    <button type="button" :style="{ backgroundColor: isProcessed ? '#e6e6e6' : '#38b6ff' }"
                        class="text-sm px-1 py-1 mb-2" @click="isProcessed = false">
                        Chưa xử lý
                    </button>
                    <button type="button" :style="{ backgroundColor: isProcessed ? '#38b6ff' : '#e6e6e6' }"
                        class="text-sm px-1 py-1 mr-2 mb-2" @click="isProcessed = true">
                        Đã xử lý
                    </button>
                </div>
            </div>
        </div>
        <div class="flex p-4 text-3xl  w-10/12" style="margin: 0 auto; justify-content: space-between;">
            <i class="far fa-trash-alt fa-lg" style="cursor: pointer;"></i>

            <i class="far fa-edit fa-lg" style="cursor: pointer;"></i>
        </div>
        <div class="absolute  bottom-2 max-w-screen-sm" style="z-index: 99;">
            <div id="toast-simple"
                :style="{ visibility: showToast ? 'visible' : 'hidden', backgroundColor: '#e8e8e8', margin: '0 auto' }"
                class="flex    items-center w-fit p-2  divide-gray-200 rounded-lg " role="alert">
                <div class=" text-sm font-normal whitespace-nowrap">{{ message }}</div>
            </div>
        </div>
    </Home_Admin>
</template>
<style>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');


</style>
