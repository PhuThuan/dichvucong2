<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

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
        <div class="text-blue-500 text-3xl text-center font-bold my-10">
            Đăng ký
        </div>
        <form @submit.prevent="submit">
            

            <div class="mt-4">
                

                <TextInput
                    id="phone"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.phone"
                    
                    placeholder="Số điện thoại"
                    autocomplete="username"
                />

                <InputError class="mt-2" v-if="form.errors.phone!='The phone has already been taken.'"  :message="form.errors.phone" />
                <InputError class="mt-2" v-if="form.errors.phone=='The phone has already been taken.'" :message="'Số điện thoại không khả dụng'"  />
            </div>

            <div class="mt-4">
                

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    
                    autocomplete="new-password"
                    placeholder="Mật khẩu"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    
                    autocomplete="new-password"
                    placeholder="Nhập lại mật khẩu"
                />

                <!-- <InputError class="mt-2" :message="form.errors.password_confirmation" /> -->
                <InputError class="mt-2" v-if="form.errors.password_confirmation == 'The password field confirmation does not match.'" message="Nhập lại mật khẩu" />

            </div>

            <div class="flex items-center justify-center mt-5">

                <PrimaryButton class="border-none bg-gradient-to-r from-[#b4b4b4] to-[#ededed] text-black" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" style="background: linear-gradient(to right, #4b4b4b, #ededed);">
                    Đăng ký
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
