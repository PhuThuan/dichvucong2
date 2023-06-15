<script setup>
import { computed, ref, onMounted } from 'vue';
const isOpen = ref(false)

</script>
<template>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <header class="sticky top-0 flex h-16 flex-wrap content-center p-8" style="background-color: #37b6ff;justify-content: space-between;
    align-items: center;">
        <div class="relative">
            <!-- Button kích hoạt dropdown -->
            <button class="flex items-center   text-white  py-1 px-2 rounded" @click="isOpen = !isOpen">
                <span class="material-symbols-outlined icon">
                    account_circle
                </span>
                <div class="ms-2 text-xl font-bold">Admin</div>
            </button>

            <!-- Nội dung dropdown -->
            <div v-if="isOpen" class="absolute mt-2 py-2 w-48 bg-white rounded-md shadow-lg">
                <a href="/logout" class="block px-4 py-2 text-gray-800 hover:bg-blue-500 hover:text-white">
                    Đăng xuất
                </a>
                <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-blue-500 hover:text-white">
                    Lựa chọn 2
                </a>
                <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-blue-500 hover:text-white">
                    Lựa chọn 3
                </a>
            </div>
        </div>

        <div class="flex">
            <a href="#" class="flex-auto flex justify-center w-1/12">
                <span class="material-symbols-outlined icon icon-search">
                    search
                </span>
            </a>
            <a href="#" class="flex-auto flex justify-center w-1/12">
                <span class="material-symbols-outlined icon icon-bell">
                    notifications
                </span>
            </a>
        </div>

    </header>
    <div style="background-color: #5ce1e6;">

        <slot />
    </div>
</template>

<style>
span.icon-search,
span.icon-bell {
    font-weight: 100;
    font-size: 2em !important;
}

header span.icon {
    font-size: 2.25em;
    display: block;
    color: #ffffff;
}
</style>