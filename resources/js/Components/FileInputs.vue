<script setup>
import { computed, ref, onMounted, onUpdated } from 'vue';
import InputError from '@/Components/InputError.vue';
const props = defineProps({
    services_fields: {
        type: Object,
    },
    formData: {
        type: Object,
    },
    submitClicked: {
        type: Boolean,
    }
});

let type = ref('file');
const emit = defineEmits(['fileResponse']);

onUpdated(() => {
    eventSubmit();
})

// Chạy sau khi render
onMounted(() => {
    emit('fileResponse', {
        required: (stringToObject.value?.required ? true : false)
    })
})

// Khởi tạo biến lấy giá trị của đầu vào (input)
let input = ref()

// Khởi tạo biến lưu các giá trị validate
let validate = ref({
    errors: {}
});

function eventSubmit() {
    if (props.submitClicked) {
        updateFormData(props.services_fields.field_name.value, input)
    }
}

function updateFormData(attribute, value) {
    // Cập nhật giá trị của trường input trong biến formData của component cha
    // props.formData[attribute] = value;
    validate.value[props.services_fields.field_name] = value;
    if (validateForm()) {
        Object.defineProperty(props.formData, attribute, {
            value: value, // Chuyển đối tượng thành json 
            writable: true, // Cho phép ghi đè giá trị thuộc tính
            enumerable: true, // Có thể lặp qua thuộc tính
            configurable: true // Có thể cấu hình lại thuộc tính
        });
    } else {
        if (!stringToObject.value?.required) {
            validate.value[props.services_fields.field_name] = null
        }
        validateForm()
    }
    delete props.formData['undefined'];
    // Xoá dữ liệu từ formData nếu input value rỗng
    if (!value)
        delete props.formData[attribute];
    // console.log(props.formData);
};

// computed chuyển đổi chuỗi thành đối tượng
const stringToObject = computed(() => {
    if (props.services_fields?.validate) {
        const attributes = {};
        props.services_fields.validate.split('|').forEach(attr => {
            const [key, value] = attr.split('=');
            if (key) {
                const [subKey, subValue] = key.split(':');
                if (subValue) {
                    attributes[subKey.trim()] = subValue.trim();
                } else {
                    attributes[key.trim()] = value ? value.replace(/"/g, '').trim() : true;
                }
            }
        });
        return attributes;
    }
});

// Xác thực file
const validateForm = () => {
    let isValid = true;

    if (stringToObject.value?.required) {
        if (!validate.value[props.services_fields.field_name]) {
            validate.value.errors[props.services_fields.field_name] = `${props.services_fields.label} không được bỏ trống.`;
            isValid = false;
        }
        else {
            validate.value.errors[props.services_fields.field_name] = '';
        }
    }
    else {
        validate.value.errors[props.services_fields.field_name] = '';
    }
    // console.log(stringToObject);
    return isValid;
};
</script>

<template>
    <div class="flex flex-wrap items-center">
        <label :for="services_fields.field_name" class="block font-medium text-[1.05rem]">{{
            services_fields.field_name }}: <span class="text-[#fb4762]" v-if="stringToObject?.required">*</span>
        </label>
        <input v-model="input" :type="type" :id="services_fields.field_name" class="
        text-sm shadow-sm bg-gray-50 border border-gray-300 block w-full cursor-pointer 
        file:text-sm file:font-semibold file:py-2 file:px-4 file:rounded-[.25rem] file:border-0 file:mr-4 rounded-[.25rem]"
            :placeholder="services_fields.placeholder" :="stringToObject"
            accept="image/png, image/jpeg, .doc, .docx, .pdf, .pptx"
            @input="props.formData[services_fields.field_name] = $event.target?.files[0]" />
        <InputError class="mt-2" :message="validate.errors[props.services_fields.field_name]"
            :required="stringToObject?.required" />
    </div>
</template>
<style scoped>
input::file-selector-button {
    outline: #3b82f6;
    background-color: #1c4ed8;
}
input::file-selector-button:hover {
    background-color: #1e40af;
}
</style>