<script setup>

import Home_Admin from '@/Components/Home_Admin.vue';
import Footer from '@/Components/Footer.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed, ref, onMounted, onBeforeUnmount } from 'vue';
import HeaderCustomer from '@/Components/HeaderCustomer.vue';
const props = defineProps({ data: Array, role: Number })

const message = ref('')
const showToast = ref(false)
const isProcessed = ref()
const address = ref([])
const label = ref([])
const keys = ref([])
const file = ref([])
const labelFile = ref([])
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
    for (const [key, value] of Object.entries(props.data)) {
        //         console.log();
        //   console.log(`${key}: ${value}`);
        if (slice(props.data[key])) {
            file.value.push(key)
        }
        if (isJSON(props.data[key])) {
            var a = JSON.parse(props.data[key])
            if (a?.city) {
                keys.value.push(key)
                label.value.push(props.data.label[key])
                address.value.push(a)
            }
        }

    }
})

function slice(e) {
    if (typeof e === 'string') {
        var lastThreeChars = e.slice(-3);
        if (lastThreeChars == 'png' || lastThreeChars == 'jpeg' || lastThreeChars == 'jpg' || lastThreeChars == 'pdf') {
            return true
        }
    }
    return false
}
function test(e) {
    var lastThreeChars = e.slice(-3);
    console.log(lastThreeChars);
    return lastThreeChars
}
function isJSON(str) {
    try {
        JSON.parse(str);
        return true;
    } catch (error) {
        return false;
    }
}


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
    if (status == 3) {
        if (confirm('Bạn có chắc chắn muốn hủy yêu cầu này?')) {
            console.log(change);
            change.post(`/admin/order/detail/${props.data.service_id}/${props.data.id}`);
        } else {
            return
        }
    }
    else if (status == 1) {
        if (confirm('Bạn có chắc chắn đã xử lý yêu cầu này?')) {
            console.log(change);
            change.post(`/admin/order/detail/${props.data.service_id}/${props.data.id}`);
        } else {
            return
        }
    }
    else {
        change.post(`/admin/order/detail/${props.data.service_id}/${props.data.id}`);
    }
}
onBeforeUnmount(() => {
    // Xử lý sự kiện trước khi component bị hủy

    console.log(props.role);
    if (props.role == 1) {
        if (props.data.status == 2) {
            window.addEventListener('beforeunload', function (event) {
                changeStatus(0)
                event.preventDefault();
                event.returnValue = ''; // Để hiển thị thông báo mặc định của trình duyệt
            })
            changeStatus(0)
        }
    }
});
</script>


<template>
    <Head title="Chi Tiết Yêu Cầu" />
    <Home_Admin v-if="$page.props.auth.user.role == 1">
        <button class="btn btn-outline btn-warning "><i class="far fa-edit fa-lg"></i></button>
        <div class="overflow-x-auto">
            <table class="table text-base" style="margin: 0 auto;">
                <!-- head -->
                <thead>
                    <tr>
                        <th class="w-full text-center text-base" colspan="3">
                            <h3>Mã yêu cầu: {{ props.data.service_id + '0' + props.data.id }}</h3>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <!-- row 1 -->
                    <tr>
                        <td class="   " colspan="1.5">
                            <strong class="mr-2 ">Ngày tạo đơn: </strong><br>
                            <strong class=" ">{{ formatDay(props.data.created_at) }}</strong>
                        </td>
                        <td class="   " colspan="1.5">
                            <strong class="mr-2 ">Dịch vụ đã chọn:</strong>
                            <strong class="mr-2 ">{{ props.data.service_name }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="1.5">
                            <strong class=" ">Trạng thái:</strong>
                        </td>
                        <td class="flex items-center" colspan="1.5">
                            <strong class="text-cyan-300 " v-if="props.data.status == 0">Chưa xử lý</strong>
                            <div class="text-yellow-300 " v-else-if="props.data.status == 2">
                                <strong>Đang xử lý</strong>
                                <span class="loading loading-dots loading-xs"
                                    style="margin-top: 10px; position: absolute;"></span>
                            </div>
                            <strong class="text-lime-300 " v-else-if="props.data.status == 1">Đã xử lý</strong>
                            <strong class="text-red-400 " v-else-if="props.data.status == 3">Đã hủy</strong>
                            <div class="flex items-center ml-10" v-if="props.data.status == 0 || props.data.status == 2">
                                <button class="btn btn-circle btn-outline btn-success mr-2 btn-sm" @click="changeStatus(1)">
                                    <i class="fas fa-check fa-lg"></i>
                                </button>
                                <button class="btn btn-circle btn-outline btn-error btn-sm" @click="changeStatus(3)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <template class=" " v-for="(i, index) in props.data.label" :key="index">
                        <tr v-if="!keys.includes(index) && file.indexOf(index)" class=" ">
                            <td colspan="1.5"><strong class="mr-2 ">{{ i }}: </strong></td>
                            <td colspan="1.5" class="flex">
                                <div v-if="Array.isArray(props.data[index])" v-for="(y, z) in props.data[index]" :key="i"
                                    class="flex" style="flex-wrap: wrap;">
                                    <strong class="">{{ y }}</strong>
                                    <strong class="mr-2 " v-if="z < props.data[index].length - 1">,</strong>
                                </div>
                                <strong class=" " v-else-if="!keys.includes(index)">{{ props.data[index] }}</strong>
                                <i class="far fa-copy fa-lg ml-2" v-if="index != 'address'"
                                    style="color: #b3b4b7;cursor: pointer;" @click="copyText(props.data[index])"></i>
                            </td>
                        </tr>
                    </template>
                    <!-- show address -->
                    <template v-for="(address, index) in address">
                        <tr>
                            <td colspan="1.5">
                                <strong class="">{{ label[index] }}: </strong>
                            </td>
                            <td colspan="1.5">
                                <div class=" pb-2 ">
                                    <strong class=" ">{{ address.city }}</strong>
                                    <i class="far fa-copy fa-lg ml-2" style="color: #b3b4b7;cursor: pointer;"
                                        @click="copyText(address.city)"></i>
                                </div>
                                <div class=" pb-2 ">
                                    <strong class=" ">{{ address.district }}</strong>
                                    <i class="far fa-copy fa-lg ml-2" style="color: #b3b4b7;cursor: pointer;"
                                        @click="copyText(address.district)"></i>
                                </div>
                                <div class=" pb-2 ">
                                    <strong class=" ">{{ address.ward }}</strong>
                                    <i class="far fa-copy fa-lg ml-2" style="color: #b3b4b7;cursor: pointer;"
                                        @click="copyText(address.ward)"></i>
                                </div>
                                <div class=" pb-2">
                                    <strong class="mr-2 ">Tên đường: </strong>
                                    <strong class=" ">{{ address.streetName }}</strong>
                                    <i class="far fa-copy fa-lg ml-2" style="color: #b3b4b7;cursor: pointer;"
                                        @click="copyText(address.streetName)"></i>
                                </div>
                            </td>
                        </tr>
                    </template>
                    <template v-for="i in file" :key="i">
                        <tr>
                            <td colspan="3">
                                <strong class="">{{ props.data.label[i] }}</strong>

                                <embed v-if="test(props.data[i]) == 'pdf'" :src="'/' + props.data[i]" type="application/pdf"
                                    width="100%" height="300px" />
                                <img v-else :src="'/' + props.data[i]" style="height:100px" alt="Image">
                            </td>
                        </tr>
                    </template>

                </tbody>
            </table>
        </div>
        <div class=" w-full  flex items-end justify-center" style="bottom: -7rem; position: fixed; z-index: 99;">
            <div class="  bottom-2  left-0 right-0 flex justify-center" style="z-index: 99;position: fixed; ">
                <div id="toast-simple"
                    :style="{ visibility: showToast ? 'visible' : 'hidden', backgroundColor: '#e8e8e8', margin: '0 auto' }"
                    class="flex    items-center w-fit p-2  divide-gray-200 rounded-lg " role="alert">
                    <div class=" text-sm font-normal whitespace-nowrap">{{ message }}</div>
                </div>
            </div>
        </div>

    </Home_Admin>
    <div v-if="$page.props.auth.user.role == 0">
        <HeaderCustomer />
        <div class="overflow-x-auto">
            <table class="table text-base" style="margin: 0 auto;">
                <!-- head -->
                <thead>
                    <tr>
                        <th class="w-full text-center text-base" colspan="3">
                            <h3>Mã yêu cầu: {{ props.data.service_id + '0' + props.data.id }}</h3>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <!-- row 1 -->
                    <tr>
                        <td class="   " colspan="1.5">
                            <strong class="mr-2 ">Ngày tạo đơn: </strong><br>
                            <strong class=" ">{{ formatDay(props.data.created_at) }}</strong>
                        </td>
                        <td class="   " colspan="1.5">
                            <strong class="mr-2 ">Dịch vụ đã chọn:</strong>
                            <strong class="mr-2 ">{{ props.data.service_name }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="1.5">
                            <strong class=" ">Trạng thái:</strong>
                        </td>
                        <td class="flex items-center" colspan="1.5">
                            <strong class="text-cyan-300 " v-if="props.data.status == 0">Chưa xử lý</strong>
                            <div class="text-yellow-300 " v-else-if="props.data.status == 2">
                                <strong>Đang xử lý</strong>
                                <span class="loading loading-dots loading-xs"
                                    style="margin-top: 10px; position: absolute;"></span>
                            </div>
                            <strong class="text-lime-300 " v-else-if="props.data.status == 1">Đã xử lý</strong>
                            <strong class="text-red-400 " v-else-if="props.data.status == 3">Đã hủy</strong>

                        </td>

                    </tr>
                    <template class=" " v-for="(i, index) in props.data.label" :key="index">
                        <tr v-if="!keys.includes(index) && file.indexOf(index)" class=" ">
                            <td colspan="1.5"><strong class="mr-2 ">{{ i }}: </strong></td>
                            <td colspan="1.5" class="flex">
                                <div v-if="Array.isArray(props.data[index])" v-for="(y, z) in props.data[index]" :key="i"
                                    class="flex" style="flex-wrap: wrap;">
                                    <strong class="">{{ y }}</strong>
                                    <strong class="mr-2 " v-if="z < props.data[index].length - 1">,</strong>
                                </div>
                                <strong class=" " v-else-if="!keys.includes(index)">{{ props.data[index] }}</strong>
                                <i class="far fa-copy fa-lg ml-2" v-if="index != 'address'"
                                    style="color: #b3b4b7;cursor: pointer;" @click="copyText(props.data[index])"></i>
                            </td>
                        </tr>
                    </template>
                    <!-- show address -->
                    <template v-for="(address, index) in address">
                        <tr>
                            <td colspan="1.5">
                                <strong class="">{{ label[index] }}: </strong>
                            </td>
                            <td colspan="1.5">
                                <div class=" pb-2 ">
                                    <strong class=" ">{{ address.city }}</strong>
                                    <i class="far fa-copy fa-lg ml-2" style="color: #b3b4b7;cursor: pointer;"
                                        @click="copyText(address.city)"></i>
                                </div>
                                <div class=" pb-2 ">
                                    <strong class=" ">{{ address.district }}</strong>
                                    <i class="far fa-copy fa-lg ml-2" style="color: #b3b4b7;cursor: pointer;"
                                        @click="copyText(address.district)"></i>
                                </div>
                                <div class=" pb-2 ">
                                    <strong class=" ">{{ address.ward }}</strong>
                                    <i class="far fa-copy fa-lg ml-2" style="color: #b3b4b7;cursor: pointer;"
                                        @click="copyText(address.ward)"></i>
                                </div>
                                <div class=" pb-2">
                                    <strong class="mr-2 ">Tên đường: </strong>
                                    <strong class=" ">{{ address.streetName }}</strong>
                                    <i class="far fa-copy fa-lg ml-2" style="color: #b3b4b7;cursor: pointer;"
                                        @click="copyText(address.streetName)"></i>
                                </div>
                            </td>
                        </tr>
                    </template>
                    <template v-for="i in file" :key="i">
                        <tr>
                            <td colspan="3">
                                <strong class="">{{ props.data.label[i] }}</strong>

                                <embed v-if="test(props.data[i]) == 'pdf'" :src="'/' + props.data[i]" type="application/pdf"
                                    width="100%" height="300px" />
                                <img v-else :src="'/' + props.data[i]" style="height:100px" alt="Image">
                            </td>
                        </tr>
                    </template>

                </tbody>
            </table>
        </div>
        <Footer />
    </div>
</template>

<style>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
</style>
