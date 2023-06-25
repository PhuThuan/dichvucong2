<script setup>

import Home_Admin from '@/Components/Home_Admin.vue';

import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed, ref, onMounted } from 'vue';
const props = defineProps({ data: Object })

const message = ref('')
const showToast = ref(false)
const isProcessed = ref(false)

onMounted(() => {
    console.log(props.data);
    if (props.data.status == 1) {
        isProcessed.value = true
    }
    else {
        isProcessed.value = false
    }
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
        <div class="w-full text-center font-bold text-base">
            <h3>Mã yêu cầu: {{ props.data.service_id + '0' + props.data.id }}</h3>
        </div>
        <div class="font-bold text-base p-3 ">
            <div class="flex p-2 items-center " v-for="(i, index) in props.data.label" :key="index">
                <strong class="mr-2 ">{{ i }}: </strong>
                <div v-if="Array.isArray(props.data[index])" v-for="(y, z) in props.data[index]" :key="i" class="flex"
                    style="flex-wrap: wrap;">
                    <strong class="">{{ y }}</strong>
                    <strong class="mr-2 " v-if="z < props.data[index].length - 1">,</strong>
                </div>
                <strong class=" " v-else>{{ props.data[index] }}</strong>

                <i class="fas fa-clone fa-lg ml-2" style="color: #b3b4b7;cursor: pointer;"
                    @click="copyText(props.data[index])"></i>
            </div>

            <div class="flex p-2 items-center">
                <strong class="mr-2 ">Dịch vụ đã chọn:</strong>
                <strong class="mr-2 ">{{ props.data.service_name }}</strong>
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
        <div class="relative w-full  flex items-end justify-center" style="bottom: -7rem;">
            <div class="absolute  bottom-2  left-0 right-0 flex justify-center" style="z-index: 99; ">
                <div id="toast-simple"
                    :style="{ visibility: showToast ? 'visible' : 'hidden', backgroundColor: '#e8e8e8', margin: '0 auto' }"
                    class="flex    items-center w-fit p-2  divide-gray-200 rounded-lg " role="alert">
                    <div class=" text-sm font-normal whitespace-nowrap">{{ message }}</div>
                </div>
            </div>
        </div>
    </Home_Admin>
</template>
<style>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
</style>
