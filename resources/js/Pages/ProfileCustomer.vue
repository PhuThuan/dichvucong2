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
    <div class="text-[1rem] font-[600] p-[2rem] w-[100%] sm:w-[40rem] mx-auto">
        <div>Sđt: <span class="text-[#565a5d] font-bold">{{ props.data?.phone }}</span></div>
        <div>Dịch vụ đã xử dụng:</div>

        <!-- v-for  -->
        <template v-for="item in serviceList">
            <div
                class="block max-w-sm px-[1rem] pt-[.5rem] border border-gray-200 shadow hover:bg-gray-100 my-[.75rem] bg-[#f6f2f2]">
                <h5 class="text-[1rem] font-bold tracking-tight text-gray-900 bg-[#ffffff]">{{ item['service_name'] }}
                    <span>({{ showTime(item['created_at']) }} {{ showDate(item['created_at']) }})</span>
                </h5>
                <div class="text-right my-[.25rem]">
                    <Link :href="route('order', [item.service_id, item.id])"
                        class="bg-[#36b7ff] text-[.75rem] rounded-[24px] py-[0.25rem] px-[0.75rem]">Chi tiết
                    </Link>
                </div>
            </div>
        </template>
        <!-- Logout -->
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <div
            class=" flex content-center justify-center flex-wrap mt-[2rem] sticky bottom-0">
            <div class="flex content-center justify-center flex-wrap h-[3rem] w-[15rem] bg-[#e0e9f8] rounded-[.25rem]">
                <span class="material-symbols-outlined">
                    logout
                </span>
                <Link class="mx-[2rem]" :href="route('logout')" method="post" as="button">
                Đăng xuất
                </Link>
            </div>
        </div>
    </div>
    <FooterVue />
</template>