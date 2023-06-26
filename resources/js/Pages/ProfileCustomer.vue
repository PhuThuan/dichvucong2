<script setup>
import { Head, Link } from '@inertiajs/vue3';
import HeaderCustomer from '@/Components/HeaderCustomer.vue';
import FooterVue from '@/Components/Footer.vue';
import { ref, onMounted } from 'vue';
const props = defineProps({
    data: {
        type: Array
    }
});

onMounted(() => {
    console.log(serviceList.value);
})

let showDate = (data) => {
    let date = new Date(data)
    let dateString = date.toLocaleDateString('en-GB', { day: 'numeric', month: 'numeric', year: 'numeric' }).replace(/\//g, '-');
    return dateString;
}
let showTime = (data) => {
    let time = new Date(data)
    const formatter = new Intl.DateTimeFormat('vi-VN', {
        hour: 'numeric',
        minute: 'numeric',
        second: 'numeric',
    });
    return formatter.format(time)
}

let serviceList = ref(props.data.service);

// let serviceList = [
//     {
//         "created_at": "2023-06-22 14:51:42",
//         "service_id": 1,
//         "service_name": "Kham"
//     },
//     {
//         "created_at": "2023-06-22 14:54:19",
//         "service_id": 1,
//         "service_name": "Kham"
//     }
// ]

</script>
<template>
    <HeaderCustomer />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <nav class="flex text-center font-semibold flex-wrap content-center bg-[#5de1e6] justify-between h-[2.5rem]">
        <Link href="/admin" class="flex content-center flex-wrap">
        <span class="material-symbols-outlined" style="font-size: 2rem;">
            arrow_back
        </span>
        </Link>
        <div class="flex content-center text-[1rem] flex-wrap font-[800]">
            Thông tin tài khoản
        </div>
        <div href="/customer-filter" class="flex content-center flex-wrap">
            <span class="material-symbols-outlined w-[32px]" style="font-size: 2rem;">
                <!-- filter_alt -->
            </span>
        </div>
    </nav>

    <div class="text-[1rem] font-[600] p-[2rem]">
        <div>Sđt: <span class="text-slate-400">{{ props.data?.phone }}</span></div>
        <div>Dịch vụ đã xử dụng:</div>

        <!-- v-for  -->
        <template v-for="item in serviceList">
            <div
                class="block max-w-sm px-[1rem] pt-[.5rem] border border-gray-200 shadow hover:bg-gray-100 my-[.75rem] bg-[#f6f2f2]">
                <h5 class="text-[1rem] font-bold tracking-tight text-gray-900 bg-[#ffffff]">{{ item['service_name'] }}
                    <span>({{ showTime(item['created_at']) }} {{ showDate(item['created_at']) }})</span>
                </h5>
                <div class="text-right my-[.25rem]">
                    <Link :href="`http://127.0.0.1:8000/admin/order/detail/${item.service_id}/${item.id}`"
                        class="bg-[#36b7ff] text-[.75rem] rounded-[24px] py-[0.25rem] px-[0.75rem]">Chi tiết
                    </Link>
                </div>
            </div>
        </template>
    </div>
    <FooterVue />
</template>