<script setup>
import HeaderCustomer from '@/Components/Home_Admin.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({ services: Array })

</script>



<template>
    <Head title="Tạo đơn" />
    <HeaderCustomer>
       <div class="text-lg">Chọn dịch vụ</div>
        <div class="h-full flex flex-col">
            <div class="w-full h-full shadow">
                <table class="table-auto w-full">
                    <tbody>
                        <template v-for="(service,index) in services" :key="service.id">
                        <tr 
                            class="relative transform scale-100  py-1 hover:bg-gray-100 cursor-default bg-opacity-25 "
                            :class="{ 'bg-gray-300 hover:bg-gray-200': index % 2 == 0 }">
                            <Link class="block" :href="`/admin/service/list/${service.id}`">
                            <td class="pl-5 pr-48 py-5 whitespace-no-wrap ">
                                <div> {{ service.name }}</div>
                            </td>
                            </Link>
                        </tr>
                    </template>
                    </tbody>
                </table>
            </div>
        </div>
    </HeaderCustomer>
</template>
