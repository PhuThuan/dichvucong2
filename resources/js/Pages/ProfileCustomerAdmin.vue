<script setup>
import { Head, Link } from '@inertiajs/vue3';
import HeaderCustomer from '@/Components/Home_Admin.vue';
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
    <HeaderCustomer >
  

    <div class="text-[1rem] font-[600] p-[2rem]">
        <div>Sđt: <span class="text-slate-400">{{ props.data?.phone }}</span></div>
        <div>Dịch vụ đã xử dụng:</div>

        <!-- v-for  -->
        <template v-for="item in serviceList">
            <div
                class="block max-w-sm px-[1rem] pt-[.5rem] border border-gray-200 shadow hover:bg-gray-100 my-[.75rem] bg-[#f6f2f2]">
                <h5 class="text-[1rem] font-bold tracking-tight text-gray-900 bg-[#ffffff]">{{ item['service_name'] }}
                    <span>({{ item['created_at'] }})</span>
                </h5>
                <div class="text-right my-[.25rem]">
                    <Link :href="`http://127.0.0.1:8000/admin/order/detail/${item.service_id}/${item.id}`"
                        class="bg-[#36b7ff] text-[.75rem] rounded-[24px] py-[0.25rem] px-[0.75rem]">Chi tiết
                    </Link>
                </div>
            </div>
        </template>
    </div>

    </HeaderCustomer>
</template>