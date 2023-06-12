<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center justify-center items-center sm:pt-0 bg-gray-100">
    

        <div
            class="w-[18rem] sm:w-full px-6  bg-white shadow-md overflow-hidden sm:rounded-lg rounded-xl" 
        >
            <slot />
        </div>
    </div>
</template>