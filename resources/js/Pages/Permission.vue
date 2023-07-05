<script setup>
import Home_Admin from '@/Components/Home_Admin.vue';
import { defineProps } from 'vue';
const props = defineProps({ data: Array });
import { Head, Link, useForm } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import { computed } from 'vue';
import { ref } from 'vue';

let currentGroup = ref([]);
const data = ref()
let url = [];
let vcheck = ref(true);

onMounted(() => {
    data.value = uniqueItems()
    console.log(props.data);
})
const uniqueItems = () => {
    return props.data.url.filter((value, index, self) => {
        return self.indexOf(value) === index;
    });
}
function checkArraysEqual(arr1, arr2) {
    // Kiểm tra độ dài của hai mảng
    if (arr1.length !== arr2.length) {
        return false;
    }

    // So sánh từng phần tử của hai mảng
    for (let i = 0; i < arr1.length; i++) {
        if (arr1[i] !== arr2[i]) {
            return false;
        }
    }

    // Các phần tử của hai mảng giống nhau
    return true;
}

const check = (id) => {
    var input = document.getElementById(id)
    var arr = currentGroup.value
    if (input.checked == true) {

        arr.push(input.value)
        vcheck.value = checkArraysEqual(arr, currentGroup.value)

    }
    else {
        // arr = arr.filter(item => item != input.value)
        let index = arr.indexOf(input.value);
        if (index > -1) {
            arr.splice(index, 1);
        }
        console.log(arr.length);
        vcheck.value = checkArraysEqual(arr, currentGroup.value)
    }

    console.log(vcheck);
}
const addArray = () => {
    url = []
    for (let index = 0; index < data.value.length; index++) {
        // addArray(index)

        let test = index.toString(10);

        let a = document.getElementById(test)
        if (a.checked == true)
            url.push(a.value)

    }
    //console.log(url);
}
function changeGroup() {
    currentGroup.value = [];

    if (document.getElementById('gr').value != 'Group ID') {
        //console.log(JSON.parse(props.data.group[0].permission));
        let gr_id = document.getElementById('gr').value;
        let find_gr_permission = props.data.group.filter((item) => {
            return item.id == gr_id;
        });
        //console.log(find_gr_permission[0].permission);
        currentGroup.value = JSON.parse(find_gr_permission[0].permission);
        // console.log(typeof(currentGroup));
    }

}
const submit = () => {
    addArray()
    if (document.getElementById('gr').value != 'Group ID') {
        const form = useForm({
            gr_id: document.getElementById('gr').value,
            permission: JSON.stringify(url)
        });
        console.log(form);
        form.put(route('update_setting_premission'), {
            onSuccess: () => alert("Thay đổi permision thành công"),
        });
    }

};
const formName = useForm({
    name: ''
})
const submitName = () => {
    if (formName.name) {
        console.log(formName);

        formName.post(route('store_setting_premission'), {
            onSuccess: () => {
                formName.name = ''
                alert("Thêm group thành công")
            },
        });
    }
    else {
        alert('Bạn chưa nhập giá trị')
    }

}


</script>
<template>
    <Head title="Setting Premission" />
    <Home_Admin>
        <div class="my-3 text-lg ">
            <strong>Permission</strong>

        </div>
        <div class="flex items-center my-4">
            <input type="text" id="name_placehoder" placeholder="Nhập tên group mới..." v-model="formName.name"
                class="bg-gray-50 border mr-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500  p-2.5   w-1/2         ">

            <button type="button" @click="submitName"
                class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300   font-medium rounded-lg text-sm px-5 py-2.5 text-center  mr-2 ">
                Thêm
            </button>

        </div>
        <form @submit.prevent="submit">
            <div class="">
                <div class="">
                    <select class="select select-bordered w-full max-w-xs mb-5 " id="gr" @change="changeGroup">
                        <option>Group ID</option>
                        <option v-for="items in props.data.group" :value="items.id">ID: {{ items.id }}, Name: {{ items.name
                        }}</option>

                    </select>

                </div>
                <div class=" grid grid-cols-3 gap-5">
                    <div class="form-control max-w-max" v-for="(item, index) in data">
                        <label class="label cursor-pointer">
                            <input type="checkbox" :checked="currentGroup.includes(item)" :id="index" :value="item"
                                class="checkbox mr-2" />
                            <span class="label-text ">{{ item }}</span>

                        </label>
                    </div>
                </div>


            </div>
            <div class="flex justify-center">
                <button type="submit" :disabled="!vcheck"
                    class=" disabled:opacity-25 text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300   font-medium rounded-lg text-sm px-5 py-2.5 text-center  mr-2 mb-2">Lưu</button>
            </div>


        </form>

    </Home_Admin>
</template>