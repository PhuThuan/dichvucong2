<script setup>
import { computed, ref } from 'vue';
const props = defineProps({
    services_fields: {
        type: Object,
    },
    formData: {
        type: Object,
    }
});

// Khởi tạo biến lấy giá trị của đầu vào (input)
let input = ref({})

function updateFormData(attribute, value) {
    // Cập nhật giá trị của trường input trong biến formData của component cha
    // props.formData[attribute] = value;
    Object.defineProperty(props.formData, attribute, {
        value: value,
        writable: true, // Cho phép ghi đè giá trị thuộc tính
        enumerable: true, // Có thể lặp qua thuộc tính
        configurable: true // Có thể cấu hình lại thuộc tính
    });
    console.log(props.formData);
};

// computed chuyển đổi chuỗi thành đối tượng
const stringToObject = computed(() => {
    const attributes = {};
    props.services_fields.validate.split(',').forEach(attr => {
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
});
</script>

<template>
    <div class="flex flex-wrap items-center">
        <label :for="services_fields.field_name" class="block font-medium text-gray-900">{{
            services_fields.field_name }} <span v-if="stringToObject.required">*</span>
        </label>
        <input v-on="input" type="file" :id="services_fields.field_name" class="
        text-sm shadow-sm bg-gray-50 border border-gray-300 text-gray-900 block w-full cursor-pointer 
        file:text-sm file:font-semibold file:py-2 file:px-4 file:bg-violet-50 file:text-[#3b82f6]
        file:rounded-full file:border-0 file:mr-4 hover:file:bg-violet-100 rounded-[9999px] focus:outline-[#3b82f6]"
            :placeholder="services_fields.placeholder" :="stringToObject"
            accept="image/png, image/jpeg, .doc, .docx, .pdf, .pptx"
            @input="updateFormData(services_fields.field_name, input)" />
    </div>
</template>