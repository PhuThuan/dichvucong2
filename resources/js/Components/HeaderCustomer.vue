<script setup>
defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>
<template>
    <header class="sticky top-0" style="background-color: #37b6ff;">
        <div class="flex text-center font-semibold flex-wrap content-center h-16">
            <a href="/" class="flex-1 w-32 b">
                Trang chủ
            </a>
            <a href="/contact" class="flex-1 w-32">
                Tổng đài hỗ trợ
            </a>
            <a href="/profile" v-if="$page.props.auth.user" class="flex-1 w-32">Tài khoản</a>
            <a href="/login" v-else class="flex-1 w-32">
                Đăng nhập
            </a>
        </div>
    </header>
</template>