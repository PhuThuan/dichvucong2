<script setup>
import { Head, Link } from '@inertiajs/vue3';
import HeaderAdmin from '@/Components/HeaderAdmin.vue'
</script>

<template>
    <Head title="Trang chủ" />
    <HeaderAdmin />
    <div class="min-h-screen  flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="">
            <!-- Link chuyen den trang Tong Quan -->
            <Link href="#">
            <button type="submit"
                class="flex flex-wrap content-center w-80  h-20 justify-center rounded-md   px-3 py-1.5  font-semibold leading-6 text-white shadow-sm  focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                style="background-color: #38B6FF;">
                <div style="width: 100%;"><i class="fas fa-chart-bar  text-4xl float-left"></i>
                    <p class="text-black text-2xl font-bold">Tổng Quan</p>
                </div>
            </button>
            </Link>
            <!-- Link chuyen den trang Tai Khoan -->
            <Link href="#">
            <button type="submit"
                class="mt-7 flex flex-wrap content-center w-80  h-20 justify-center rounded-md   px-3 py-1.5  font-semibold leading-6 text-white shadow-sm  focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                style="background-color: #38B6FF;">
                <div style="width: 100%;" class=""><i class="fas fa-users  text-4xl float-left"></i>
                    <p class="text-black text-2xl font-bold">Tài Khoản</p>
                </div>
            </button>
            </Link>
            <!-- Link chuyen den trang Yeu Cau -->
            <Link href="#">
            <button type="submit"
                class="mt-7 flex flex-wrap content-center w-80  h-20 justify-center rounded-md   px-3 py-1.5  font-semibold leading-6 text-white shadow-sm  focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                style="background-color: #38B6FF;">
                <div style="width: 100%;" class=""><i class="fas fa-shopping-cart  text-4xl float-left"></i>
                    <p class="text-black text-2xl font-bold">Yêu Cầu</p>
                </div>
            </button>
            </Link>
            <!-- Link chuyen den trang Dich Vu -->
            <Link href="#">
            <button type="submit"
                class="mt-7 flex flex-wrap content-center w-80  h-20 justify-center rounded-md   px-3 py-1.5  font-semibold leading-6 text-white shadow-sm  focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                style="background-color: #38B6FF;">
                <div style="width: 100%;" class=""><i class="fas fa-tag  text-4xl float-left"></i>
                    <p class="text-black text-2xl font-bold">Dịch Vụ</p>
                </div>
            </button>
            </Link>
            <!-- Link chuyen den trang Bao Cao -->
            <Link href="#">
            <button type="submit"
                class="mt-7 flex flex-wrap content-center w-80  h-20 justify-center rounded-md   px-3 py-1.5  font-semibold leading-6 text-white shadow-sm  focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                style="background-color: #38B6FF;">
                <div style="width: 100%;" class=""><i class="fas fa-file-alt  text-4xl float-left"></i>
                    <p class="text-black text-2xl font-bold">Báo Cáo</p>
                </div>
            </button>
            </Link>
        </div>

        <!-- <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <slot />
        </div> -->

    </div>
</template>

<style>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
</style>