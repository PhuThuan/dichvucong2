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
        <!-- <ul class="w-96 text-center" style="margin: 0 auto;">
            <li class="w-full text-lg font-bold text-neutral-500 border-b-2 border-neutral-100 border-opacity-100 py-4 ">
                Danh Sách Dịch Vụ
            </li>
            <li v-for="service in services" :key="service.id"
                class="w-full  border-b-2 border-neutral-100 border-opacity-100 py-4 hover:bg-slate-300">
                <Link class="block text-lg font-bold" :href="route('createService', [service.id])">
                {{ service.name }}
                </Link>
            </li>

        </ul> -->
        
        <ul class="max-w-md divide-y divide-gray-200 mx-auto">
            <template v-for="service in services" :key="service.id">
                <li class="mt-5 p-3 rounded-lg shadow-md lg:hover:shadow-xl">
                    <Link class="block" :href="route('createService', [service.id])">
                    <div class="flex items-center space-x-4">
                        <div class="flex-1 min-w-0">
                            <p class=" text-gray-900 truncate text-lg font-bold">

                                {{ service.name }}

                            </p>
                            <p class="text-sm text-gray-500 truncate text-ellipsis overflow-hidden">
                                {{ service.description }}
                            </p>
                        </div>
                        <div class="inline-flex items-center text-base font-semibold text-gray-900 ">
                            <i class="fas fa-angle-double-right fa-lg"></i>
                        </div>
                    </div>
                    </Link>
                </li>
            </template>
        </ul>
    </div>

    <Footer2 />
</template>
