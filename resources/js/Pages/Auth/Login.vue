<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/LayoutLogin.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    phone: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout style=" background: radial-gradient(#13a8ff, #dddef8);">
        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>
        <div class="text-blue-500 text-3xl text-center font-bold my-10">
            Đăng nhập
        </div>
        <form @submit.prevent="submit">
            <div>
                <InputLabel for="phone"  />

                <TextInput
                    id="phone"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.phone"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="Số điện thoại"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    placeholder="Mật khẩu"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="hidden mt-4">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>

            <div class="items-center justify-end mt-4 text-center">
                <PrimaryButton class="my-3 " :class="{ 'opacity-25': form.processing } " :disabled="form.processing"  >
                    Đăng nhập
                </PrimaryButton>
                <br>
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="font-semibold text-sm text-dark-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Quên mật khẩu?
                </Link>

                
                <div class="mt-10 font-semibold text-sm text-dark-600">
                    Bạn chưa có tài khoản?
                </div>
                <Link 
                :href="route('register')"
                class="font-semibold text-sm text-dark-600">
                    Tạo tài khoản mới
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>

