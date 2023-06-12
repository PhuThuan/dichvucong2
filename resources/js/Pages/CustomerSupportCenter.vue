<script setup>
import HeaderCustomer from '@/Components/HeaderCustomer.vue';
import Footer2 from '@/Components/Footer.vue';
</script>
<template>
    <Head title="Hỗ trợ" />
    <HeaderCustomer />
    <div class="h-[70vh] flex flex-wrap justify-center content-center">
        <div class="sm:items-center sm:justify-between leading-relaxed align-middle 
            text-center bg-[#37b5ff] rounded-[2.5rem] sm:w-7/12 w-screen text-xl font-[600] py-[2rem] px-[8px]">
            <div>Tổng đài hỗ trợ: <span class="text-[#ff0000] font-[700]">0764142269</span></div>
            <div>Email: <span class="font-[700]">dx4uchuyendoiso@gmail.com</span></div>
            <div>Địa chỉ: <span class="font-[700]">Titops, đường sô 6, trung tâm văn hóa Tây Đô,
                    phường Hưng Thạnh, quận Cái Răng, TP Cần Thơ</span></div>
        </div>
    </div>
    <Footer2/>
</template>