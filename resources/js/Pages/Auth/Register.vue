<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({

    phone: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
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
                    required
                    placeholder="Số điện thoại"
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.phone" />
            </div>

            <div class="mt-4">
                

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
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
                    required
                    autocomplete="new-password"
                    placeholder="Nhập lại mật khẩu"
                />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="flex items-center justify-center mt-5">

                <PrimaryButton class="border-none" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" style="background: linear-gradient(to right, #4b4b4b, #ededed);">
                    Đăng ký
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
