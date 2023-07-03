<script setup>

import Home_Admin from '@/Components/Home_Admin.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

import { router } from '@inertiajs/vue3';
import { computed, ref, onMounted,  } from 'vue';
const props = defineProps({
    data: Array,
    page: Number
});
var itemsPerPage = ref(10)
var listPage = ref([])
const total = ref()
var page = Number(props.page)
const totalPages = () => {
    total.value = Math.ceil(props.data.usersCount / itemsPerPage.value)
    return Math.ceil(props.data.usersCount / itemsPerPage.value);
}
const visiblePages = () => {
    // const startPage = Math.max(1, currentPage.value - 2);
    // const endPage = Math.min(startPage + 2, totalPages.value);
    // return Array.from({ length: endPage - startPage + 1 }, (_, i) => startPage + i);

    if (page == 1) {
        listPage.value.push(page)
        console.log(listPage.value);
        for (let i = 1; i < total.value; i++) {
            const sum = page + i
            console.log(sum);
            if (sum <= total.value) {
                listPage.value.push(sum)
                console.log(listPage.value);
            }
            if (listPage.value.length==3) {
                break
            }
        }
    }
    else if (page == total.value) {

        for (let i = 2; i > 0; i--) {
            if (page - i != 0) {
                listPage.value.push(page - i)

            }
        }
        listPage.value.push(page)
    }
    else {

        listPage.value.push(page - 1)
        listPage.value.push(page)
        listPage.value.push(page + 1)
    }
    // return listPage.value
}


onMounted(() => {
    totalPages()
    visiblePages()
    // console.log(formatDay('2023-06-20T11:00:05.000000Z'));
})
const goToPage = (page) => {

    router.get(`/admin/account/${page}`)

}
const previousPage = () => {
    if (page > 1) {
        page--;
        goToPage(page)
        // Gọi API hoặc thực hiện các tác vụ liên quan đến dữ liệu của trang mới
        // Ví dụ: this.fetchData(this.currentPage);
    }
}
const nextPage = () => {
    // console.log(page+' '+to);
    if (page < total.value) {
        page++;
        goToPage(page)
        // Gọi API hoặc thực hiện các tác vụ liên quan đến dữ liệu của trang mới
        // Ví dụ: this.fetchData(this.currentPage);
    }
}
const formatDay = (date) => {
    const utcTime = moment.utc(date);

    // Chuyển đổi sang múi giờ Việt Nam
    const vietnamTime = utcTime.utcOffset(7);

    // Định dạng đầu ra
    return vietnamTime.format('HH:mm DD-MM-YYYY');
    // return moment('2023-06-20T11:00:05.000000Z').format('YYYY-MM-DD');
};
</script>


<template>
    <Head title="Quản Lý Tài Khoản" />
    <Home_Admin>
        <h3>Tổng số lượng tài khoản: {{ props.data.usersCount }}</h3>
        <div class="overflow-x-auto">
            <div class="min-w-screen ">
                <div class="w-full">
                    <div class="bg-white rounded my-2">
                        <table class="min-w-max w-full table-auto">
                            <thead>
                                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Tài khoản</th>
                                    <th class="py-3 px-6 text-left">Thời gian truy cập</th>
                                    <th class="w-max "> </th>
                                </tr>
                            </thead>
                            <!-- :class="{ 'bg-gray-100 hover:bg-gray-100': service.id % 2 != 0 }" -->
                            <tbody class="text-gray-600 text-sm font-light">
                                <tr class="border-b border-gray-200  hover:bg-gray-100"
                                    v-for="(item, index) in props.data.users.data" :key="index">
                                    <td class="py-3 px-6 text-left whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="font-medium">{{ item.phone }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-6 text-left whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="font-medium">{{ formatDay(item.updated_at)
                                            }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-6 ">
                                        <Link :href="route('detailUser',[item.id])">
                                        <svg style="width: 29px;cursor: pointer;" xmlns="http://www.w3.org/2000/svg"
                                            height="1em"
                                            viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                            <path
                                                d="M288 144a110.94 110.94 0 0 0-31.24 5 55.4 55.4 0 0 1 7.24 27 56 56 0 0 1-56 56 55.4 55.4 0 0 1-27-7.24A111.71 111.71 0 1 0 288 144zm284.52 97.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400c-98.65 0-189.09-55-237.93-144C98.91 167 189.34 112 288 112s189.09 55 237.93 144C477.1 345 386.66 400 288 400z" />
                                        </svg>
                                        </Link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <nav aria-label="Page navigation example ">
            <ul class="list-style-none w-full md:w-auto flex mt-2 " style="flex-wrap: nowrap;justify-content: center;">
                <li>
                    <button @click="goToPage(1)" :disabled="props.page == 1"
                        class="px-3 py-1 bg-gray-200 rounded-l hover:bg-gray-400 focus:outline-none">
                        First
                    </button>
                </li>
                <li>
                    <button @click="previousPage" :disabled="props.page == 1"
                        class="px-3 py-1 bg-gray-200 hover:bg-gray-400 focus:outline-none">
                        Previous
                    </button>
                </li>
                <li v-for="page in listPage" :key="page">
                    <button @click="goToPage(page)" :class="{
                        'px-3 py-1 bg-gray-200 hover:bg-gray-400 focus:outline-none': true,
                        'font-bold': props.page == page
                    }">
                        {{ page }}
                    </button>
                </li>
                <li>
                    <button @click="nextPage" :disabled="props.page == totalPages"
                        class="px-3 py-1 bg-gray-200 hover:bg-gray-400 focus:outline-none">
                        Next
                    </button>
                </li>
                <li>
                    <button @click="goToPage(totalPages())" :disabled="props.page == totalPages"
                        class="px-3 py-1 bg-gray-200 rounded-r hover:bg-gray-400 focus:outline-none">
                        Last
                    </button>
                </li>
            </ul>
        </nav>

    </Home_Admin>
</template>
<style>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
</style>
