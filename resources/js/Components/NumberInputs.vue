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
let input = ref()

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
    if (props.services_fields.validate) {
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
    }
});
</script>

<template>
    <div class="">
        <label :for="services_fields.field_name" class="block font-medium text-gray-900 ">{{ services_fields.label
        }}:
            <span v-if="stringToObject.required">*</span>
        </label>
        <input v-model="input" type="number" :id="services_fields.field_name" class="text-sm shadow-sm bg-gray-50 
        border border-gray-300 text-gray-900 rounded-[9999px] 
            focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " :="stringToObject"
            :placeholder="services_fields.placeholder" @input="updateFormData(services_fields.field_name, input)" />
    </div>
</template>