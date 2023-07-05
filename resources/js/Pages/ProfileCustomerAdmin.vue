<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import HeaderCustomer from '@/Components/Home_Admin.vue';
import FooterVue from '@/Components/Footer.vue';
import { ref, onMounted } from 'vue';
const props = defineProps({
    data: {
        type: Array
    }
});

onMounted(() => {
    console.log(props.data.role);
   
})
let serviceList = ref(props.data.service);

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
function changeGroup() {

    if (document.getElementById('gr').value != 'Group ID') {

        const form = useForm({
            gr_id: document.getElementById('gr').value,
            user_id : props.data.user_id
        });
        form.post(route('sendDetailUser',[props.data.user_id]), {
        onSuccess: () => alert,
        });
    console.log(form);
    }

}
function changeRole(){

    let role = document.getElementById('rl').value;
    console.log(role);
    const form = useForm({
        user_id : props.data.user_id,
        role: role
    });
    form.put(route('updateUserDetail',[props.data.user_id]))
}

// let serviceList = [
//     {
//         "created_at": "2023-06-22T01:36:10.000000Z",
//         "service_id": 1,
//         "service_name": "Kham"
//     },
//     {
//         "created_at": "2023-06-22T01:36:10.000000Z",
//         "service_id": 1,
//         "service_name": "Kham"
//     }
// ]

</script>
<template>
    <HeaderCustomer>


        <div class="text-[1rem] font-[600] p-[2rem]">
            <div>Số điện thoại: <span class="text-slate-400">{{ props.data?.phone }}</span></div>
            <div class="...">
                <select class="select select-bordered w-full max-w-xs mb-5 " id="gr" @change="changeGroup">
                    <option selected>Current Group ID: {{ props.data.currentGroup }}</option>
                    <option v-for="items in props.data.group" :value="items.id">ID: {{ items.id }}, Name: {{ items.name }}</option>

                </select>

            </div>
        
            <div class="...">
                <select class="select select-bordered w-full max-w-xs mb-5 " id="rl" @change="changeRole">
                    
                    <option v-for="(items,index) in props.data.role" :selected="props.data.currentRole==items" :value="items">{{ index }} - {{ items }}</option>

                </select>

            </div>
            <div>Dịch vụ đã xử dụng:</div>

            <!-- v-for  -->
            <!-- <template v-for="item in serviceList">
                <div
                    class="block max-w-sm px-[1rem] pt-[.5rem] border border-gray-200 shadow hover:bg-gray-100 my-[.75rem] bg-[#f6f2f2]">
                    <h5 class="text-[1rem] font-bold tracking-tight text-gray-900 bg-[#ffffff]">{{ item['service_name'] }}
                        <span>({{ showTime(item['created_at']) }} {{ showDate(item['created_at']) }})</span>
                    </h5>
                    <div class="text-right my-[.25rem]">
                        <Link :href="route('orderdetail', [item.service_id, item.id])"
                            class="bg-[#36b7ff] text-[.75rem] rounded-[24px] py-[0.25rem] px-[0.75rem]">Chi tiết
                        </Link>
                    </div>
                </div>
            </template> -->
            <template v-for="item in serviceList">
            <div
                class="block w-[30rem] px-[1rem] py-[.5rem] border border-gray-200 shadow hover:bg-gray-100 my-[.75rem] bg-[#ffffff] rounded-[.25rem]">
                <h5 class="text-[1rem] font-bold tracking-tight text-gray-900 p-[.5rem]">{{ item['service_name'] }}:
                    <span>({{ showTime(item['created_at']) }} {{ showDate(item['created_at']) }})</span>
                </h5>
                <div class="text-right my-[.5rem]">
                    <Link :href="route('orderdetail', [item.service_id, item.id])"
                        class="bg-[#36b7ff] text-white text-[.75rem] rounded-[.25rem] py-[0.5rem] px-[0.75rem]">Chi tiết
                    </Link>
                </div>
            </div>
        </template>
        </div>

    </HeaderCustomer>
</template>