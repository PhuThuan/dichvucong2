<script setup>
import HeaderCustomer from '@/Components/Home_Admin.vue';
import Footer2 from '@/Components/Footer.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({ services: Array })

</script>



<template>
    <Head title="Tạo đơn" />
    <HeaderCustomer>
        <ul class=" bt-5 text-center flex " style="flex-wrap: wrap;
    justify-content: space-evenly;
    align-items: center;">
            <li v-for="service in services" :key="service.id">
                <Link :href="route('createAdmin', [id_service = service.id])">
                <button
                    class="justify-center m-3 inline-flex px-4 py-4 w-56 border border-transparent rounded-md  text-l tracking-widest hover:bg-blue-400 bg-[#38B6FF] transition ease-in-out duration-150">
                    {{ service.name }}
                </button>
                </Link>

            </li>
        </ul>
    </HeaderCustomer>
</template>
