<script setup>
import { onMounted, defineProps } from 'vue';
import Home_Admin from '@/Components/Home_Admin.vue';

const noti = [
    { id: '1', ho_va_ten: 'Le Phu', name: 'Sua xe', created_at: '2023-06-19 03:02:01' , email:"0916123123"},
];

const alignmentClasses = computed(() => {
    
});
const text = "2023-06-19 03:02:01";
const regex = /(\S+)\s+(\S+)/;
const matches = text.match(regex);
if (matches) {
  const firstString = matches[1];
  const secondString = matches[2];
  console.log(firstString);
  console.log(secondString);
}
</script>

<template>
    <Home_Admin>
        <div class="my-3">
            Thông báo
        </div>
        <div class="h-full flex flex-col">
            <div class="w-full h-full shadow">
                <table class="w-full">
                    <tbody>
                        <tr v-for="(not, index) in noti" :key="index" class="relative transform scale-100 text-xs py-1 border-b-2 border-blue-100 cursor-default bg-opacity-25">
                            <td class="pl-5 pr-3 whitespace-no-wrap w-1/3" >
                                <div class="text-gray-400">Today</div>
                                <div>{{ not.created_at }}</div>
                            </td>
                            <td class="px-2 py-2 whitespace-no-wrap">
                                <div class="leading-5 text-gray-500 font-medium">Đơn hàng: {{ not.id }}</div>
                                <div class="leading-5 text-gray-900">{{ not.ho_va_ten }}, {{ not.email }}</div>
                                <div class="leading-5 text-gray-800">{{ not.name }}</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </Home_Admin>
</template>
