<script setup>
import HeaderCustomer from '@/Components/HeaderCustomer.vue';
import Footer2 from '@/Components/Footer.vue';
import { Head,Link } from '@inertiajs/vue3';

defineProps({ services: Array })

</script>



<template>
    <Head title="Dashboard" />
    <HeaderCustomer />
    <ul class=" bt-5 text-center ">
        <li v-for="service in services" :key="service.id">
            <Link :href="route('test',[id_service=service.id])">
                <button
                class="justify-center m-3 inline-flex px-4 py-4 w-56 border border-transparent rounded-md  text-l tracking-widest hover:bg-blue-400 bg-[#38B6FF] transition ease-in-out duration-150">
                {{ service.name }}
            </button>
            </Link>
            
        </li>
    </ul>
    <Footer2/>
</template>
