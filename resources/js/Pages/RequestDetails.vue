<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import HeaderAdmin from '@/Components/HeaderAdmin.vue'

import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed, ref, onMounted } from 'vue';
const message = ref('')
const showToast = ref(false)
const isProcessed = ref(false)
const data = {
    name: 'zzz',
    cccd: '123',
    phone: '1234'
}
onMounted(() => {

})
const totalPages = computed(() => {
    return Math.ceil(totalItems.value / itemsPerPage.value);
})
const visiblePages = computed(() => {
    const startPage = Math.max(1, currentPage.value - 2);
    const endPage = Math.min(startPage + 2, totalPages.value);
    return Array.from({ length: endPage - startPage + 1 }, (_, i) => startPage + i);
})
const displayData = computed(() => {
    return listData;
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
    <Head title="Quản Lý Tài Khoản" />
    <HeaderAdmin>
        <div class=" p-2" style="">
            <i class="fas fa-arrow-left text-2xl float-left"></i>
            <div style="width: 14rem; margin: 0 auto;" class="whitespace-nowrap">
                <p class="text-black text-xl font-bold">Mã yêu cầu:xxx</p>
            </div>
        </div>
    </HeaderAdmin>
    <div class="font-bold text-base p-3">
        <div class="flex p-2 items-center">
            <strong class="mr-2 ">tên</strong>
            <strong class="mr-2 ">zzz</strong>
            <i class="fas fa-clone fa-lg" style="color: #b3b4b7;cursor: pointer;" @click="copyText('name')"></i>
        </div>
        <div class="flex p-2 items-center">
            <strong class="mr-2 ">Họ & tên:</strong>
            <strong class="mr-2 ">zzz</strong>
            <i class="fas fa-clone fa-lg" style="color: #b3b4b7; cursor: pointer;" @click="copyText('name')"></i>
        </div>
        <div class="flex p-2 items-center">
            <strong class="mr-2 ">CCCD:</strong>
            <strong class="mr-2 ">098</strong>
            <i class="fas fa-clone fa-lg" style="color: #b3b4b7;cursor: pointer;" @click="copyText('098')"></i>
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
    <div class="flex p-4 text-3xl items-center w-10/12" style="margin: 0 auto;">
        <i class="far fa-trash-alt fa-lg" style="cursor: pointer;"></i>
        <div id="toast-simple"
            :style="{ visibility: showToast ? 'visible' : 'hidden', backgroundColor: '#e8e8e8', margin: '0 auto' }"
            class="flex items-center w-fit p-2  divide-gray-200 rounded-lg " role="alert">
            <div class=" text-sm font-normal whitespace-nowrap">{{ message }}</div>
        </div>
        <i class="far fa-edit fa-lg" style="cursor: pointer;"></i>
    </div>
</template>
<style>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');

table {
    border-collapse: collapse;
}


table,
th,
td {
    border: none;
}
</style>
