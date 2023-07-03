<script setup>
import HeaderCustomer from '@/Components/HeaderCustomer.vue';
import Footer2 from '@/Components/Footer.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({ services: Array })

</script>



<template>
    <Head title="Dashboard" />
    <HeaderCustomer />
    <div class="w-full my-4 ">
        <ul class="w-96 text-center" style="margin: 0 auto;">
            <li 
                class="w-full text-lg font-bold text-neutral-500 border-b-2 border-neutral-100 border-opacity-100 py-4 ">
                Danh Sách Dịch Vụ
            </li>
            <li v-for="service in services" :key="service.id"
                class="w-full  border-b-2 border-neutral-100 border-opacity-100 py-4 hover:bg-slate-300">
                <Link class="block text-lg font-bold" :href="route('createService', [service.id])">
                {{ service.name }}
                </Link>
            </li>

        </ul>
    </div>
    <!-- <div class="overflow-x-auto h-96">
        <table class="table table-pin-rows text-center ">
            <thead>
                <tr class="text-lg">
                    <th>Chọn dịch vụ</th>
                </tr>
            </thead>
            <tbody class="">
                <ul class="w-96">
                    <li v-for="service in services" :key="service.id"
                        class="w-full border-b-2 border-neutral-100 border-opacity-100 py-4 hover:bg-slate-300">
                        <Link class="block text-lg font-bold" :href="route('createService', [service.id])">
                        {{ service.name }}
                        </Link>
                    </li>

                </ul>
                <tr v-for="service in services" :key="service.id">
                    <td class=" py-5 hover:bg-slate-300 ">
                        <Link class="block text-lg font-bold" :href="route('createService', [service.id])">
                        {{ service.name }}
                        </Link>

                    </td>
                </tr>
            </tbody>
        </table>
    </div> -->
    <!-- <ul class=" bt-5 text-center ">
        <li v-for="service in services" :key="service.id">
            <Link :href="route('createService', [id_service = service.id])">
            <button
                class="justify-center m-3 inline-flex px-4 py-4 w-56 border border-transparent rounded-md  text-l tracking-widest hover:bg-blue-400 bg-[#38B6FF] transition ease-in-out duration-150">
                {{ service.name }}
            </button>
            </Link>

        </li>
    </ul> -->
    <Footer2 />
</template>
