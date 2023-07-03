<script setup>
import Home_Admin from '@/Components/Home_Admin.vue';
import { defineProps } from 'vue';
const props = defineProps({ settingEmail: Array });
import { Head, Link, useForm } from '@inertiajs/vue3';
//let settingEmail=[{MAIL_USERNAME:"fsdfsdfas@mail.com",MAIL_ENCRYPTION:"tls",MAIL_FROM_NAME:"Dichvu",MAIL_PORT:'123',MAIL_HOST:'smtp@email.com'}]
const submit = () => {
   // console.log(form);
        form.post(route('mail_setting'), {
            onSuccess: () => alert,
        });
    
};

const form = useForm({
    MAIL_USERNAME: props.settingEmail.MAIL_USERNAME,
    MAIL_ENCRYPTION:props.settingEmail.MAIL_ENCRYPTION,
    MAIL_FROM_NAME:props.settingEmail.MAIL_FROM_NAME,
    MAIL_PORT:props.settingEmail.MAIL_PORT,
    MAIL_HOST:props.settingEmail.MAIL_HOST,
    MAIL_PASSWORD:''
});
</script>
<template>
    <Head title="Setting Email"/>
    <Home_Admin>
        <div class="my-3 text-lg">
            Cấu hình email
        </div>
       
<form @submit.prevent="submit">
    <div class="grid gap-6 mb-6 md:grid-cols-2">
        <div>
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 ">Mail User Name </label>
            <input type="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5      " placeholder="exmaple@email.com" required v-model="form.MAIL_USERNAME">
        </div>
        <div>
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 ">Mail Password</label>
            <input type="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5      " placeholder="•••••••••" required v-model="form.MAIL_PASSWORD">
        </div>
        <div>
            <label for="encryption" class="block mb-2 text-sm font-medium text-gray-900 ">Mail Encryption</label>
            <input type="text" id="encryption" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5      " placeholder="Mail Encryption" required v-model="form.MAIL_ENCRYPTION">
        </div>  
        <div>
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">Mail From Name</label>
            <input type="text" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5      " placeholder="Mail Name"  required v-model="form.MAIL_FROM_NAME">
        </div>
        <div>
            <label for="port" class="block mb-2 text-sm font-medium text-gray-900 ">Mail Port</label>
            <input type="text" id="port" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5      " placeholder="456" required v-model="form.MAIL_PORT">
        </div>
        <div>
            <label for="host" class="block mb-2 text-sm font-medium text-gray-900 ">Mail Host</label>
            <input type="text" id="host" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5      " placeholder="smtp.gmail.comx" required v-model="form.MAIL_HOST">
        </div>
    </div>
    
    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center   ">Submit</button>
</form>

    </Home_Admin>
</template>