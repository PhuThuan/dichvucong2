<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import HeaderCustomer from '@/Components/HeaderCustomer.vue';
import Footer2 from '@/Components/Footer.vue';
import { Head } from '@inertiajs/vue3';

defineProps({ services: Array })

</script>



<template>
    <Head title="Dashboard" />
    <HeaderCustomer />
    <!-- <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="mb-10"></div>
                    

                </div>
            </div>

        </div>
    </AuthenticatedLayout> -->
    <ul class=" bt-5 text-center ">
        <li v-for="service in services" :key="service.id">
            <button
                class="justify-center m-3 inline-flex px-4 py-4 w-56 border border-transparent rounded-md  text-l tracking-widest hover:bg-blue-400 bg-[#38B6FF] transition ease-in-out duration-150">
                {{ service.name }}
            </button>
        </li>
    </ul>
    <Footer2/>
</template>
