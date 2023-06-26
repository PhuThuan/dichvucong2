<script setup>
import { Link } from '@inertiajs/vue3';
</script>
<template>
    <header class="sticky top-0 bg-[#37b6ff]">
        <div class="flex text-center font-semibold flex-wrap content-center h-16">
            <Link :href="route('dashboard')" class="flex-auto">
            Trang chủ
            </Link>
            <Link :href="route('contact')" class="flex-auto">
            Tổng đài hỗ trợ
            </Link>
            <Link href="/user/profile/service" v-if="$page.props.auth.user" class="flex-auto">Tài khoản</Link>
            <Link href="/login" v-else class="flex-auto">
            Đăng nhập
            </Link>
        </div>
    </header>
</template>