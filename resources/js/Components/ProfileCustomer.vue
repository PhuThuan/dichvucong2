<script setup>
import { Head, Link } from '@inertiajs/vue3';

let serviceList = [
    { name: "Đặt lịch khám bệnh", lastAccess: '1995-12-17T03:24:00' },
    { name: "Đặt lịch khám bệnh", lastAccess: '1995-12-17T03:24:00' },
    { name: "Đặt lịch khám bệnh", lastAccess: '1995-12-17T03:24:00' }
];
</script>
<template>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <div class="flex text-center font-semibold flex-wrap content-center bg-[#5de1e6] justify-between h-[2.5rem]">
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
    </div>

    <div class="text-[1rem] font-[600] p-[2rem]">
        <div>Sđt: <span class="text-slate-400">xxxxxxxx</span></div>
        <div>Dịch vụ đã xử dụng:</div>

        <!-- v-for  -->
        <template v-for="item in serviceList">
            <div
                class="block max-w-sm px-[1rem] pt-[.5rem] border border-gray-200 shadow hover:bg-gray-100 my-[.75rem] bg-[#f6f2f2]">
                <h5 class="text-[1rem] font-bold tracking-tight text-gray-900 bg-[#ffffff]">{{ item['name'] }}
                    <span>({{ new Date(item.lastAccess).getHours() }}/{{ new Date(item.lastAccess).getMinutes() }}/{{
                        new Date(item.lastAccess).getSeconds()
                    }}</span>
                    <br>
                    <span>{{ new Date(item.lastAccess).getDate() }}/{{ new Date(item.lastAccess).getMonth() }}/{{ new
                        Date(item.lastAccess).getFullYear() }})</span>
                </h5>
                <div class="text-right my-[.25rem]">
                    <Link href="#" class="bg-[#36b7ff] text-[.75rem] rounded-[24px] py-[0.25rem] px-[0.75rem]">Chi tiết
                    </Link>
                </div>
            </div>
        </template>

    </div>
</template>