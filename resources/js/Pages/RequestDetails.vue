<script setup>

import Home_Admin from '@/Components/Home_Admin.vue';

import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed, ref, onMounted } from 'vue';
const props = defineProps({ data: Array,status:Number })

const message = ref('')
const showToast = ref(false)
const isProcessed = ref()
const address = ref()
onMounted(() => {
    console.log(props.data);
    if (props.data.status == 0) {
        isProcessed.value = false
    }
    else {
        isProcessed.value = true
    }
    if (props.data.address) {
        address.value = JSON.parse(props.data.address)
        console.log(address.value);
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
const formatDay = (date) => {
    const utcTime = moment.utc(date);

    // Chuyển đổi sang múi giờ Việt Nam
    const vietnamTime = utcTime.utcOffset(7);

    // Định dạng đầu ra
    return vietnamTime.format('HH:mm:ss DD-MM-YYYY');
    // return moment('2023-06-20T11:00:05.000000Z').format('YYYY-MM-DD');
};

function changeStatus(status) {
    const change = useForm({
        status: status
    })
    console.log(change);
    change.post(`/admin/order/detail/${props.data.service_id}/${props.data.id}`, {
        onSuccess: () => {
            // Gui form thanh cong
            if (props.status==0) {
                isProcessed.value=false
            }
            else{
                isProcessed.value=true

            }
        }
    });
    // location.reload();
    // if(status==0){
    //     isProcessed.value=false
    // }
    // else{
    //     isProcessed.value=true
    // }

}
</script>


<template>
    <Head title="Chi Tiết Yêu Cầu" />
    <Home_Admin>
        <div class="w-full text-center font-bold text-base">
            <h3>Mã yêu cầu: {{ props.data.service_id + '0' + props.data.id }}</h3>
        </div>
        <div class="flex p-2 items-center ">
            <strong class="mr-2 ">Ngày tạo đơn: </strong>
            <strong class=" ">{{ formatDay(props.data.created_at) }}</strong>
            <!-- <i class="fas fa-clone fa-lg ml-2" style="color: #b3b4b7;cursor: pointer;"
                        @click="copyText(address.city)"></i> -->
        </div>
        <div class="font-bold text-base p-3 ">
            <template class=" " v-for="(i, index) in props.data.label" :key="index">
                <div v-if="index != 'address'" class="flex p-2 items-center">
                    <strong class="mr-2 ">{{ i }}: </strong>
                    <div v-if="Array.isArray(props.data[index])" v-for="(y, z) in props.data[index]" :key="i" class="flex"
                        style="flex-wrap: wrap;">
                        <strong class="">{{ y }}</strong>
                        <strong class="mr-2 " v-if="z < props.data[index].length - 1">,</strong>
                    </div>
                    <strong class=" " v-else-if="index != 'address'">{{ props.data[index] }}</strong>

                    <i class="fas fa-clone fa-lg ml-2" v-if="index != 'address'" style="color: #b3b4b7;cursor: pointer;"
                        @click="copyText(props.data[index])"></i>
                </div>

            </template>
            <!-- show address -->
            <div v-if="address">
                <div class="flex p-2 items-center ">
                    <strong class="mr-2 ">Tỉnh/Thành phố: </strong>
                    <strong class=" ">{{ address.city }}</strong>
                    <i class="fas fa-clone fa-lg ml-2" style="color: #b3b4b7;cursor: pointer;"
                        @click="copyText(address.city)"></i>
                </div>
                <div class="flex p-2 items-center ">
                    <strong class="mr-2 ">Quận/Huyện: </strong>
                    <strong class=" ">{{ address.district }}</strong>
                    <i class="fas fa-clone fa-lg ml-2" style="color: #b3b4b7;cursor: pointer;"
                        @click="copyText(address.district)"></i>
                </div>
                <div class="flex p-2 items-center ">
                    <strong class="mr-2 ">Phường/Xã: </strong>
                    <strong class=" ">{{ address.ward }}</strong>
                    <i class="fas fa-clone fa-lg ml-2" style="color: #b3b4b7;cursor: pointer;"
                        @click="copyText(address.ward)"></i>
                </div>
                <div class="flex p-2 items-center ">
                    <strong class="mr-2 ">Tên đường: </strong>
                    <strong class=" ">{{ address.streetName }}</strong>
                    <i class="fas fa-clone fa-lg ml-2" style="color: #b3b4b7;cursor: pointer;"
                        @click="copyText(address.streetName)"></i>
                </div>
            </div>


            <div class="flex p-4 ml-2 items-center">
                <strong class="mr-2 ">Dịch vụ đã chọn:</strong>
                <strong class="mr-2 ">{{ props.data.service_name }}</strong>
            </div>
            <div class="flex w-full text-center p-3 mt-2" style="margin: 0 auto;">
                <h6 class="mr-4">Trạng thái: </h6>
                <div>
                    <button type="button" :style="{ backgroundColor: isProcessed ? '#e6e6e6' : '#38b6ff' }"
                        class="text-sm px-1 py-1 mb-2" @click="changeStatus(0)">
                        Chưa xử lý
                    </button>
                    <button type="button" :style="{ backgroundColor: isProcessed ? '#38b6ff' : '#e6e6e6' }"
                        class="text-sm px-1 py-1 mr-2 mb-2" @click="changeStatus(1)">
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
