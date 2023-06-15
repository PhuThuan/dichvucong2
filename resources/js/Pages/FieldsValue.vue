<script setup>
import HeaderAdmin from '@/Components/HeaderAdmin.vue'
import { ref, onMounted } from 'vue'
import { Head, useForm } from '@inertiajs/vue3';
const input = ref('')
const fieldList = ref([])
const dataList = ref([])
const addField = (id) => {
    const input = document.getElementById(id).value;
    const a = document.getElementById(id)
    const item = getData.find(item => item.id === id);
    if (input === '') {
        alert("Bạn chưa nhập giá trị")

    }
    else if (item.arr.includes(input)) {
        alert("Giá trị đã tồn tại")
        a.value = ''
    }
    else {
        const item = dataList.value.find(obj => obj.id === id);

        if (item) {
            // Thay đổi mảng arr trong đối tượng item
            item.arr.push(input);

            a.value = ''
        }
        console.log(dataList.value);

    }

}
const delField = (id, value) => {
    const item = dataList.value.find(obj => obj.id === id);

    if (item) {
        // Tìm vị trí của giá trị cần xóa trong mảng arr
        const index = item.arr.indexOf(value);

        // Kiểm tra nếu giá trị cần xóa tồn tại trong mảng
        if (index !== -1) {
            // Xóa giá trị khỏi mảng arr
            item.arr.splice(index, 1);
        }
    }
    console.log(dataList.value);

}

const getData = [
    {
        id: '1',
        field_name: "gioitinh",
        html_type: 'radio',
        db_type: 'string',
        label: 'Giới tính',
        arr: []
    },
    {
        id: '2',
        field_name: 'sothich',
        html_type: 'checkbox',
        db_type: 'string',
        label: 'Sở thích',
        arr: []
    },
    {
        id: '3',
        field_name: 'Lop',
        html_type: 'select',
        db_type: 'string',
        label: 'Lớp',
    },
]
onMounted(() => {
    for (let i in getData) {
        var temp = getData[i]
        temp.arr = []
        dataList.value.push(temp)
        console.log(dataList.value);
    }
})
const data = []

const submit = () => {

    const form = useForm(dataList.value)
    console.log(form);
    form.post(route('post3'));

};
</script>


<template>
    <Head title="Thêm Dịch Vụ" />
    <HeaderAdmin>
        <div class=" p-2" style="">
            <i class="fas fa-arrow-left text-2xl float-left"></i>
            <div style="width: 14rem; margin: 0 auto;" class="whitespace-nowrap">
                <p class="text-black text-xl font-bold pr-0">Thêm dịch vụ</p>
            </div>
        </div>
    </HeaderAdmin>
    <div class="p-2">
        <h2 class="font-bold text-xl mb-3">Thêm giá trị vào các trường</h2>

        <div class="font-bold" style="">
            <div v-for="item in  dataList " :key="item" class="mb-2">
                <div class="p-2 ">
                    <div class="flex text-lg" style="align-items:center;flex-wrap: wrap;">
                        <h5 class="whitespace-nowrap">{{ item.label }} - {{ item.field_name }} - {{ item.html_type }} - {{
                            item.db_type
                        }}</h5>
                        <input type="text" :id="item.id"
                            class="bg-gray-50 border  mx-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-50 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <i class="fas fa-plus fa-lg ml-2" style="color: #0ced10; cursor: pointer;"
                            @click="addField(item.id)"></i>
                    </div>
                    <div class=" mt-1 ml-2" style="">
                        <ul class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                            <li v-for=" i  in  item.arr" :key="i" class="flex " style="align-items:center;">
                                {{ i }} <i class="fas fa-times-circle fa-md ml-2" style="color: #ea1f10;cursor: pointer;"
                                    @click="delField(item.id, i)"></i>

                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <button type="button" @click="submit"
            class="text-white mt-3 bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Submit</button>
    </div>
</template>

<style>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
</style>