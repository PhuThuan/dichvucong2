<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center justify-center items-center sm:pt-0 bg-gray-100">
    

        <div
            class="shadow-form py-[2rem] w-[95vw] min-[640px]:w-[24rem] px-6  bg-white shadow-md overflow-hidden sm:rounded-lg rounded-xl" 
        >
            <slot />
        </div>
    </div>
</template>

<style scoped>
    .shadow-form {
        filter: drop-shadow(0 0 0.25rem rgb(181, 181, 181));
    }
</style>