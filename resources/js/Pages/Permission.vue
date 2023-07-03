<script setup>
import Home_Admin from '@/Components/Home_Admin.vue';
import { defineProps } from 'vue';
const props = defineProps({ settingEmail: Array });
import { Head, Link, useForm } from '@inertiajs/vue3';
let premision = []
const submit = () => {
    console.log(form);
    // form.post(route('mail_setting'), {
    //     onSuccess: () => alert,
    // });

};

const form = useForm({

});
</script>
<template>
    <Head title="Setting Premission" />
    <Home_Admin>
        <div class="my-3 text-lg">
            Premission

        </div>

        <form @submit.prevent="submit" >
            <div class="grid grid-cols-3 gap-5">

                <div class=" ...">
                    <div class="form-control max-w-max">
                <label class="label cursor-pointer">
                    <span class="label-text mr-2">Remember me</span>
                    <input type="checkbox" checked="checked" class="checkbox" />
                </label>
            </div>
                </div>
                <div class="...">
                    <select class="select select-bordered w-full max-w-xs mb-5 ">
                <option>Who shot first?</option>
                <option>Han Solo</option>
                <option>Greedo</option>
            </select>
            <select class="select select-bordered w-full max-w-xs">
                <option>Who shot first?</option>
                <option>Han Solo</option>
                <option>Greedo</option>
            </select>
                </div>

            </div>
            
            
        </form>

    </Home_Admin>
</template>