<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import HeaderAdmin from '@/Components/HeaderAdmin.vue'

import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed, ref, onMounted } from 'vue';
var data = [{ id: '09879979', time: '23/2/2023', service: 'a' },
{ id: '09879979', time: '23/2/2023', service: 'Đặt lịch khám bệnh' },
{ id: '09879979', time: '23/2/2023', service: 'b' },
{ id: '09879979', time: '23/2/2023', service: 'b' },
{ id: '09879979', time: '23/2/2023', service: 'c' },]
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
const copyText = () => {
    const textToCopy = 'Nội dung cần sao chép';
    // const input = this.$refs.input1; // Truy cập đến phần tử input sử dụng $refs
    // input.select(); // Chọn toàn bộ nội dung trong input
    // console.log(input1.value.value);
    navigator.clipboard.writeText(input1.value.value)
        .then(() => {
            console.log('Đã sao chép thành công!');
        })
        .catch((error) => {
            console.error('Lỗi sao chép:', error);
        });
}
</script>


<template>
    <Head title="Quản Lý Tài Khoản" />
    <HeaderAdmin>
        <div class="flex p-2" style="justify-content: space-between;align-items: center;">
            <i class="fas fa-arrow-left text-2xl"></i>
            <div style="width: 14rem;" class="whitespace-nowrap"><i
                    class="fas fa-users  text-2xl float-left text-white"></i>
                <p class="text-black text-xl font-bold">Quản lý khách hàng</p>
            </div>
            <div>
                <div class="relative">
                    <!-- Button kích hoạt dropdown -->
                    <button
                        class="text-white  hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-2 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button" @click="isOpen1 = !isOpen1" style="background-color: #5ce1e6;">
                        <i class="fas fa-filter text-2xl"></i>
                    </button>

                    <!-- Nội dung dropdown -->
                    <div v-if="isOpen1" class="right-0 absolute mt-2 py-2 w-48 bg-white rounded-md shadow-lg">
                        <div class="flex items-center mb-2 ml-2">
                            <input id="default-checkbox" type="checkbox" value=""
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="default-checkbox"
                                class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Default checkbox</label>
                        </div>
                        <div class="flex items-center mb-2 ml-2">
                            <input id="default-checkbox" type="checkbox" value=""
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="default-checkbox"
                                class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Default checkbox</label>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </HeaderAdmin>
    <div style="margin: 0 auto;" class="w-full sm:max-w-lg  px-6 py-4   sm:rounded-lg">

        <div class="flex flex-col w-30">
            <div class="overflow-x-auto  sm:-mx-6 lg:-mx-10">
                <div class="inline-block min-w-full  py-2 sm:px-2 lg:px-8">
                    <div class="overflow-hidden">
                        <table class="min-w-full border text-center text-sm font-light dark:border-neutral-500">
                            <thead class="border-b font-medium dark:border-neutral-500">
                                <tr style="background-color: #fcf6db;">
                                    <th scope="col" class="w-fit border-r px-6 py-4 dark:border-neutral-500">
                                        Tài khoản
                                    </th>
                                    <th scope="col" class="whitespace-nowrap border-r px-6 py-4 dark:border-neutral-500">
                                        Thời gian truy cập
                                    </th>
                                    <th scope="col" class="whitespace-nowrap border-r px-6 py-4 dark:border-neutral-500">
                                        Dịch vụ
                                    </th>
                                    <th scope="col" class="border-r px-6 py-4 dark:border-neutral-500">

                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in listData" :key="index" class="border-b dark:border-neutral-500">
                                    <td class="whitespace-nowrap border-r px-6 py-4 font-medium dark:border-neutral-500">
                                        {{ item.id }}
                                    </td>
                                    <td class="whitespace-nowrap border-r px-6 py-4 dark:border-neutral-500">
                                        {{ item.time }}
                                    </td>
                                    <td class=" border-r px-6 py-4 dark:border-neutral-500">
                                        {{ item.service }}
                                    </td>
                                    <td class=" px-6 py-4 text-center align-middle"><svg style="width: 29px;"
                                            xmlns="http://www.w3.org/2000/svg" height="1em"
                                            viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                            <path
                                                d="M288 144a110.94 110.94 0 0 0-31.24 5 55.4 55.4 0 0 1 7.24 27 56 56 0 0 1-56 56 55.4 55.4 0 0 1-27-7.24A111.71 111.71 0 1 0 288 144zm284.52 97.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400c-98.65 0-189.09-55-237.93-144C98.91 167 189.34 112 288 112s189.09 55 237.93 144C477.1 345 386.66 400 288 400z" />
                                        </svg></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Second navigation element with secondary theme -->
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

    </div>
</template>
<style>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
</style>
