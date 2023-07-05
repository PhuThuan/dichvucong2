<script setup>
//import GuestLayout from '@/Layouts/GuestLayout.vue';
import GuestLayout from '@/Layouts/LayoutLogin.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, defineProps, defineEmits } from 'vue';

const showPassword = ref(false);
const showPassword2 = ref(false);
const form = useForm({

    phone: '',
    password: '',
    password_confirmation: '',
});
const validateForm = () => {
    let isValid = true;

    // Validate phone
    const phoneRegex = /^([+]84|0|84)(3[2-9]|5[6|8|9]|7[0|6-9]|8[1-5]|9[0-4|6-9])[0-9]{7}$/;
    if (!form.phone) {
        form.errors.phone = 'Số điện thoại không được bỏ trống.';

        isValid = false;
    } else if (!phoneRegex.test(form.phone)) {


        form.errors.phone = 'Số điện thoại không đúng.';
        isValid = false;
    } else {
        form.errors.phone = '';
    }

    // Validate password
    if (!form.password) {
        form.errors.password = 'Mật khẩu không được bỏ trống.';
        isValid = false;
    } else if (form.password.length < 6 || form.password !== form.password_confirmation) {
        form.errors.password = 'Nhập lại mật khẩu.';
        isValid = false;
    } else {
        form.errors.password = '';
    }




    return isValid;
};

const submit = () => {
    if (validateForm()) {
        form.post(route('register'), {
            onFinish: () => form.reset('password', 'password_confirmation'),
        });
    }
};


</script>

<template>
    <GuestLayout style=" background: radial-gradient(#13a8ff, #dddef8);">

        <Head title="Register" />
        <div class="text-blue-500 text-3xl text-center font-bold mb-[2rem]">
            Đăng ký
        </div>
        <form @submit.prevent="submit">


            <div class="mt-4">
                <TextInput id="phone" type="text" class="text-sm shadow-sm bg-gray-50 border border-gray-300 rounded-[.25rem] focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" v-model="form.phone" placeholder="Số điện thoại"
                    autocomplete="username" />

                <InputError class="mt-2" v-if="form.errors.phone != 'The phone has already been taken.'"
                    :message="form.errors.phone" />
                <InputError class="mt-2" v-if="form.errors.phone == 'The phone has already been taken.'"
                    :message="'Số điện thoại không khả dụng'" />
            </div>
            <div class="relative mt-4">
                <TextInput 
                    id="password" 
                    :type="showPassword ? 'text' : 'password'" 
                    class="text-sm shadow-sm bg-gray-50 border border-gray-300 rounded-[.25rem] focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    v-model="form.password" 
                    autocomplete="current-password" 
                    placeholder="Mật khẩu"/>
                <button type="button" class="absolute right-0 top-0 h-full px-3 text-gray-300 focus:outline-none"
                    @click="showPassword = !showPassword">
                    <i class="fas fa-eye" :class="{ 'hidden': !showPassword, 'block': showPassword }"></i>
                    <i class="fas fa-eye-slash" :class="{ 'block': !showPassword, 'hidden': showPassword }"></i>
                </button>
                
            </div>
            <InputError class="" :message="form.errors.password" />


            <div class="relative mt-4">
                <TextInput id="password_confirmation" :type="showPassword2 ? 'text' : 'password'" class="text-sm shadow-sm bg-gray-50 border border-gray-300 rounded-[.25rem] focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    v-model="form.password_confirmation" autocomplete="current-password" placeholder="Nhập lại mật khẩu" />
                <button type="button" class="absolute right-0 top-0 h-full text-gray-300 px-3 focus:outline-none"
                    @click="showPassword2 = !showPassword2">
                    <i class="fas fa-eye" :class="{ 'hidden': !showPassword2, 'block': showPassword2 }"></i>
                    <i class="fas fa-eye-slash" :class="{ 'block': !showPassword2, 'hidden': showPassword2 }"></i>
                </button>
            
            </div>
            <InputError class=""
                    v-if="form.errors.password_confirmation == 'The password field confirmation does not match.'"
                    message="Nhập lại mật khẩu" />


            <div class="flex items-center justify-center ">

                <button
                    class="mt-[2rem] bg-gradient-to-r from-[#a5edff] to-[#27a1f3] text-black py-2 px-4 rounded-[.5rem] font-semibold"
                    :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Đăng ký
                </button>

            </div>
        </form>
    </GuestLayout>
</template>
