<script setup>
import { Link } from '@inertiajs/vue3';
import { onMounted } from 'vue';


// initialize components based on data attribute selectors
onMounted(() => {
    initFlowbite();
})
</script>
<template>
    <!-- <header class="sticky top-0 bg-[#37b6ff]">
        <div class="flex text-center font-semibold flex-wrap content-center h-16">
            <Link :href="route('dashboard')" class="flex-auto">
            Trang chủ
            </Link>
            <Link :href="route('contact')" class="flex-auto">
            Tổng đài hỗ trợ
            </Link>
            <Link href="/user/profile/service" v-if="$page.props.auth.user" class="flex-auto">Tài khoản</Link>
            <Link href="/login" v-else class="flex-auto">
            Đăng nhập
            </Link>
        </div>
    </header> -->
    

    <nav class="bg-slate-100 border-gray-200  ">
    <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl p-4">
        <a href="" class="flex items-center">
            <img src="/storage/Titops DX4U Logo Square (1).png" class="h-8 mr-3" alt="Flowbite Logo" />
            <span class="self-center text-2xl font-semibold whitespace-nowrap ">Dx4u</span>
        </a>
        <button id="mega-menu-full-cta-button" data-collapse-toggle="mega-menu-full-cta" type="button" class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200   " aria-controls="mega-menu-full-cta" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
        </button>
        <div id="mega-menu-full-cta" class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1">
            <ul class="flex flex-col mt-4 font-medium md:flex-row md:space-x-8 md:mt-0">
                <li>
                    <Link :href="route('dashboard')" class="block py-2 pl-3 pr-4 text-gray-900 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0  md:   md: " aria-current="page">Trang chủ</Link>
                </li>
                
                <li>
                    <Link :href="route('contact')" class="block py-2 pl-3 pr-4 text-gray-900 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0  md:   md: ">Tổng đài hỗ trợ </Link>
                </li>
                <li>
                    <Link href="/user/profile/service" v-if="$page.props.auth.user" class="block py-2 pl-3 pr-4 text-gray-900 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0  md:   md: ">Tài khoản</Link>
                    <Link href="/login" v-else class="block py-2 pl-3 pr-4 text-gray-900 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0  ">
            Đăng nhập
            </Link>
                </li>
                <li>
                </li>
                
            </ul>
        </div>
    </div>
    
</nav>


</template>