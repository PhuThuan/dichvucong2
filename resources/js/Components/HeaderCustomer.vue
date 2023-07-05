<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { onMounted } from 'vue';
var isActive = 0
var open = ref(false)
function swap() {
    // var isActive1 = isActive

    var check = document.getElementById('check');
    if (open.value == false) {
        check.checked = !open.value;
        open.value = !open.value
    }
    else {
        check.checked = !open.value;
        open.value = !open.value
        // window.innerWidth <= 320px
    }

}
// initialize components based on data attribute selectors
onMounted(() => {
    isActive = 0
    var check = document.getElementById('check');
    check.checked = false;
    // initFlowbite();
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
    <nav class="bg-slate-100 border-gray-200">
        <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl p-4">
            <a href="" class="flex items-center">
                <img src="/storage/Titops DX4U Logo Square (1).png" class="h-8 mr-3" alt="Flowbite Logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap ">Dx4u</span>
            </a>
            <button id="mega-menu-full-cta-button" type="button"
                class="inline-flex items-center  ml-1 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100   "
                aria-controls="mega-menu-full-cta" aria-expanded="false">
                <div class="drawer">
                    <input id="my-drawer" type="checkbox" class="drawer-toggle" @input="swap()" />
                    <div class="drawer-content">
                        <!-- Page content here -->
                        <!-- <label for="my-drawer" class="btn btn-primary drawer-button">Open drawer</label> -->
                        <label for="my-drawer" class="btn btn-circle swap swap-rotate">

                            <!-- this hidden checkbox controls the state -->
                            <input type="checkbox" id="check" class="hidden" />

                            <!-- hamburger icon -->
                            <svg class="swap-off fill-current" xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                viewBox="0 0 512 512">
                                <path d="M64,384H448V341.33H64Zm0-106.67H448V234.67H64ZM64,128v42.67H448V128Z" />
                            </svg>

                            <!-- close icon -->
                            <svg class="swap-on fill-current" xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                viewBox="0 0 512 512">
                                <polygon
                                    points="400 145.49 366.51 112 256 222.51 145.49 112 112 145.49 222.51 256 112 366.51 145.49 400 256 289.49 366.51 400 400 366.51 289.49 256 400 145.49" />
                            </svg>

                        </label>
                    </div>
                    <div class="drawer-side z-[1]">
                        <label for="my-drawer" class="drawer-overlay"></label>
                        <ul class=" menu p-4 w-80 h-full bg-base-200 text-base-content">
                            <li class="text-lg flex justify-between flex-row items-center">
                                <h5 class=" font-semibold text-gray-500 uppercase ">
                                    Menu</h5>
                                <label for="my-drawer"><i class="fas fa-times fa-lg "></i></label>
                            </li>
                            <li class="ml-2 mt-2">
                                <Link :href="route('dashboard')"
                                    class="block text-lg p-2 text-gray-900 rounded-lg  hover:bg-gray-200 "
                                    aria-current="page">
                                <i class="fas fa-home fa-lg"></i>
                                <span class="ml-3">Trang chủ</span>
                                </Link>
                            </li>

                            <li class="ml-2 mt-2">
                                <Link :href="route('contact')"
                                    class="block text-lg p-2 text-gray-900 rounded-lg  hover:bg-gray-200 "
                                    aria-current="page">
                                <i class="fas fa-headset fa-lg"></i>
                                <span class="ml-3">Tổng đài hỗ trợ</span>
                                </Link>
                            </li>

                            <li class="ml-2 mt-2">
                                <Link href="/user/profile/service" v-if="$page.props.auth.user"
                                    class="block text-lg p-2 text-gray-900 rounded-lg  hover:bg-gray-200 "
                                    aria-current="page">
                                <i class="fas fa-user fa-lg"></i>
                                <span class="ml-3">Tài khoản</span>
                                </Link>
                                <Link href="/login" v-else
                                    class="block text-lg p-2 text-gray-900 rounded-lg  hover:bg-gray-200 "
                                    aria-current="page">
                                <i class="fas fa-sign-in-alt fa-lg"></i>
                                <span class="ml-3">Đăng nhập</span>
                                </Link>
                            </li>

                        </ul>
                    </div>
                </div>
            </button>
            <div id="mega-menu-full-cta" class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1">
                <ul class="flex flex-col mt-4 font-medium md:flex-row md:space-x-8 md:mt-0">
                    <li>
                        <Link :href="route('dashboard')"
                            class="block py-2 pl-3 pr-4 text-gray-900 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0  md:   md: "
                            aria-current="page">Trang chủ</Link>
                    </li>

                    <li>
                        <Link :href="route('contact')"
                            class="block py-2 pl-3 pr-4 text-gray-900 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0  md:   md: ">
                        Tổng đài hỗ trợ </Link>
                    </li>
                    <li>
                        <Link href="/user/profile/service" v-if="$page.props.auth.user"
                            class="block py-2 pl-3 pr-4 text-gray-900 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0  md:   md: ">
                        Tài khoản</Link>
                        <Link href="/login" v-else
                            class="block py-2 pl-3 pr-4 text-gray-900 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0  ">
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
