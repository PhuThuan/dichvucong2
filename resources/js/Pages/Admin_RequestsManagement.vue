<script setup>

import Home_Admin from '@/Components/Home_Admin.vue';

import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed, ref, onMounted } from 'vue';
var data = [{ id: '098', info: '09879979', service: 'Đặt lịch khám bệnh', status: 0 },
{ id: '0987', info: '09879979', service: 'd', status: 1 },
{ id: '098', info: '09879979', service: 'Đặt lịch khám bệnh', status: 0 },
{ id: '09979', info: '09879979', service: 'd', status: 0 },
{ id: '09', info: '09879979', service: 'Đặt lịch khám bệnh', status: 1 },
{ id: '9979', info: '09879979', service: 'b', status: 1 },
{ id: '7979', info: '09879979', service: 'a', status: 0 },]
var currentPage = ref(1)
var itemsPerPage = ref(2)
var totalItems = ref(data.length)
var listData = ref([])
const isOpen1 = ref(false)
const input1 = ref(null)
onMounted(() => {
    // input1.value.focus()
    input1.value = 'sadsd'
})
const totalPages = computed(() => {
    return Math.ceil(totalItems.value / itemsPerPage.value);
})
const visiblePages = computed(() => {
    const startPage = Math.max(1, currentPage.value - 2);
    const endPage = Math.min(startPage + 2, totalPages.value);
    return Array.from({ length: endPage - startPage + 1 }, (_, i) => startPage + i);
})
const displayData = computed(() => {
    return listData;
})
onMounted(() => {
    for (let i = 1; i <= itemsPerPage.value; i++) {
        listData.value.push(data[i - 1])
    }
})
const goToPage = (page) => {
    // Xử lý khi người dùng chọn trang
    listData.value = []
    currentPage.value = page;
    for (let i = page * 2 - 1; i <= page * 2; i++) {
        if (i > data.length) {
            break;
        }
        listData.value.push(data[i - 1])
        console.log(listData)
    }
    displayData
    // Gọi API hoặc thực hiện các tác vụ liên quan đến dữ liệu của trang mới
    // Ví dụ: this.fetchData(page);
}
const previousPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--;
        goToPage(currentPage.value)
        // Gọi API hoặc thực hiện các tác vụ liên quan đến dữ liệu của trang mới
        // Ví dụ: this.fetchData(this.currentPage);
    }
}
const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
        goToPage(currentPage.value)
        // Gọi API hoặc thực hiện các tác vụ liên quan đến dữ liệu của trang mới
        // Ví dụ: this.fetchData(this.currentPage);
    }
}

</script>


<template>
    <Head title="Quản Lý Tài Khoản" />
    <Home_Admin>
        <div class="relative flex items-center " style="justify-content: right;">

            <button
                class="text-white  hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-2 text-center inline-flex items-center      "
                type="button" @click="isOpen1 = !isOpen1" style="color: black;">
                <i class="fas fa-filter text-2xl"></i>
            </button>
            <div v-if="isOpen1" class="right-0  absolute mt-2 py-2 px-2 w-48 bg-white rounded-md shadow-lg" style="top: 35px;">
                <div class="flex items-center mb-2">
                    <input id="default-radio-1" type="radio" value="0" name="default-radio"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="default-radio-1" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Tất cả</label>
                </div>
                <div class="flex items-center mb-2">
                    <input checked id="default-radio-2" type="radio" value="1" name="default-radio"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="default-radio-2" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Chưa xử lý</label>
                </div>
                <div class="flex items-center">
                    <input checked id="default-radio-3" type="radio" value="2" name="default-radio"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="default-radio-3" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Đã xử lý</label>
                </div>
            </div>
            <Link>
            <button type="button" href="#"
                class="text-white ml-2 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2  focus:outline-none ">Thêm
                yêu cầu</button>
            </Link>
        </div>
        <div class="overflow-x-auto">
            <div class="min-w-screen ">
                <div class="w-full">
                    <div class="bg-white rounded my-2">
                        <table class="min-w-max w-full table-auto">
                            <thead>
                                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Mã đơn</th>
                                    <th class="py-3 px-6 text-left ">Thông tin khách hàng</th>
                                    <th class="py-3 px-6 text-left">Dịch vụ</th>
                                    <th class="py-3 px-6 text-left">Trạng thái</th>
                                    <th class="w-max "> </th>
                                </tr>
                            </thead>
                            <!-- :class="{ 'bg-gray-100 hover:bg-gray-100': service.id % 2 != 0 }" -->
                            <tbody class="text-gray-600 text-sm font-light">
                                <tr class="border-b border-gray-200  hover:bg-gray-100" v-for="(item, index) in listData"
                                    :key="index">
                                    <td class="py-3 px-6 text-left whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="font-medium">{{ item.id }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-6 text-left ">
                                        <div class="flex items-center">
                                            <span class="font-medium">{{ item.info }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-6 text-left whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="font-medium">{{ item.service }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-6 text-left whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span v-if="item.status == 0" class="font-medium">Chưa xử lý</span>
                                            <span v-else class="font-medium">Đã xử lý</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-6 ">
                                        <Link href="#">
                                        <svg style="width: 29px;" xmlns="http://www.w3.org/2000/svg" height="1em"
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
                    <button @click="goToPage(1)" :disabled="currentPage === 1"
                        class="px-3 py-1 bg-gray-200 rounded-l hover:bg-gray-400 focus:outline-none">
                        First
                    </button>
                </li>
                <li>
                    <button @click="previousPage" :disabled="currentPage === 1"
                        class="px-3 py-1 bg-gray-200 hover:bg-gray-400 focus:outline-none">
                        Previous
                    </button>
                </li>
                <li v-for="page in visiblePages" :key="page">
                    <button @click="goToPage(page)" :class="{
                        'px-3 py-1 bg-gray-200 hover:bg-gray-400 focus:outline-none': true,
                        'font-bold': currentPage === page
                    }">
                        {{ page }}
                    </button>
                </li>
                <li>
                    <button @click="nextPage" :disabled="currentPage === totalPages"
                        class="px-3 py-1 bg-gray-200 hover:bg-gray-400 focus:outline-none">
                        Next
                    </button>
                </li>
                <li>
                    <button @click="goToPage(totalPages)" :disabled="currentPage === totalPages"
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
