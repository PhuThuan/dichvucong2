<script setup>
import { onMounted, defineProps } from 'vue';
import Home_Admin from '@/Components/Home_Admin.vue';
import { Link, router,Head } from '@inertiajs/vue3';

const props = defineProps({ noti: Array });
// const noti = [
//     { id: '1', ho_va_ten: 'Le Phu', service_name: 'Đăt hẹn khám bệnh', created_at: '2023-06-22T01:36:10.000000Z', service_id: "1", phone: "0916123123" },
//     { id: '1', ho_va_ten: 'Le Phu', service_name: 'Làm căn cước công dân', created_at: '2023-06-22T01:36:10.000000Z', service_id: "1", phone: "0916123123" },
//     { id: '1', ho_va_ten: 'Minh Thiên', service_name: 'Cấp lại sổ BHXH do điều chỉnh nội dung đã ghi trên sổ BHXH - Dành cho tổ chức', created_at: '2023-06-21T01:36:10.000000Z', service_id: "2", phone: "0916123123" },
//     { id: '2', ho_va_ten: 'Le Phu', service_name: 'Cấp lại, đổi thẻ BHYT do mất, hỏng không thay đổi thông tin - Dành cho cá nhân', created_at: '2023-06-21T01:36:10.000000Z', service_id: "1", phone: "0916123123" },
//     { id: '1', ho_va_ten: 'Phú Thuận', service_name: 'Giải quyết hưởng chế độ ốm đau', created_at: '2023-06-21T01:36:10.000000Z', service_id: "1", phone: "0916123123" },
//     { id: '111', ho_va_ten: 'Mai Thắng ', service_name: 'Ký hợp đồng khám, chữa bệnh bảo hiểm y tế (hàng năm) - Dành cho tổ chức', created_at: '2023-06-20T01:36:10.000000Z', service_id: "23", phone: "0916123123" },

// ];

let showDate = (data) => {
    let date = new Date(data)
    let dateString = date.toLocaleDateString('en-GB', { day: 'numeric', month: 'numeric' }).replace(/\//g, '-');
    return dateString;
}
let showTime = (data) => {
    let time = new Date(data)
    const formatter = new Intl.DateTimeFormat('vi-VN', {
        hour: 'numeric',
        minute: 'numeric',

    });
    return formatter.format(time)
}
let realTime = () => {
    let date = new Date();
    let dateString = date.toLocaleDateString('en-GB', { day: 'numeric', month: 'numeric' }).replace(/\//g, '-');
    return dateString;
}

onMounted(() => {
    //sort creat_at
    props.noti = props.noti.sort((a, b) => a.created_at - b.created_at)
    //console.log(showDate(props.noti[1].created_at) - showDate(props.noti[1].created_at))
    props.noti.sort((a, b) => {
        const timeA = new Date(a.created_at);
        const timeB = new Date(b.created_at);
        return timeB - timeA;
    });
    
})



</script>

<template>
    <Head title="Thong bao" />
    <Home_Admin>
        <div class="my-3 text-lg">
            Thông báo
            <!-- <div v-for="(not ,index) in noti">{{ not }} </div> -->
        </div>
        <div v-if="noti.length==0">Không có thông báo mới nào!</div>
        <div class="h-full flex flex-col">
            <div class="w-full h-full shadow">
                <table class="table-auto w-full">
                    <tbody>
                        <template v-for="(not, index) in noti" :key="index">
                        <tr 
                            class="relative transform scale-100 text-sm py-1 hover:bg-gray-100 cursor-default bg-opacity-25 "
                            :class="{ 'bg-gray-200 hover:bg-gray-200': index % 2 == 0 }">
                            <Link class="block" :href="route('orderdetail', [not.service_id, not.id])">
                            <td class="pl-5 pr-48 whitespace-no-wrap ">
                                <div v-if="showDate(not.created_at) == realTime()" class="text-gray-500">Today</div>
                                <div v-else> {{ showDate(not.created_at) }} </div>
                                <div>{{ showTime(not.created_at) }}</div>
                            </td>

                            <td class="px-2 py-2 whitespace-no-wrap">
                                <div class=" text-gray-500 font-medium">Đơn hàng: {{ not.service_id }}0{{ not.id }}
                                </div>
                                <div class=" text-gray-900">{{ not.ho_va_ten }}, {{ not.phone }}</div>
                                <div class="l text-gray-800">{{ not.service_name }}</div>
                            </td>
                            </Link>

                        </tr>
                    </template>
                    </tbody>
                </table>
            </div>
        </div>
    </Home_Admin>
</template>
