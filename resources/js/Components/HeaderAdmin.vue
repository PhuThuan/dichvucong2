<script setup>

</script>
<template>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <header class="sticky top-0 flex h-16 flex-wrap content-center p-8" style="background-color: #37b6ff;">
        <a href="#" class="flex-auto flex justify-center w-1/12">
            <span class="material-symbols-outlined icon">
                account_circle
            </span>
        </a>
        <a href="#" class="flex-auto flex flex-wrap content-center w-9/12 text-xl font-bold">
            <div class="ms-2">Admin</div>
        </a>
        <a href="#" class="flex-auto flex justify-center w-1/12">
            <span class="material-symbols-outlined icon icon-search">
                search
            </span>
        </a>
        <a href="#" class="flex-auto flex justify-center w-1/12">
            <span class="material-symbols-outlined icon icon-bell">
                notifications
            </span>
        </a>
    </header>
    <div style="background-color: #5ce1e6;">

        <slot />
    </div>
</template>

<style>
span.icon-search,
span.icon-bell {
    font-weight: 100;
    font-size: 2em !important;
}

header span.icon {
    font-size: 2.25em;
    display: block;
    color: #ffffff;
}
</style>