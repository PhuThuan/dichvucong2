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

// Dữ liệu lấy từ Database, mảng field input. http://127.0.0.1:8000/user/service/{id_service}/{id_services_fiedls}
let service_field_value = ref([
    {
        id: 1,
        services_fields_id: 3,
        name: 'Java', // Nội dung input radio, select,...
    },
    {
        id: 1,
        services_fields_id: 3,
        name: 'C++', // Nội dung input radio, select,...
    },
]);

// Khởi tạo biến lấy giá trị của đầu vào (input)
let input = ref(props.services_fields.placeholder)

function updateFormData(attribute, value) {
    // Cập nhật giá trị của trường input trong biến formData của component cha
    // props.formData[attribute] = value;

    // if (value === props.services_fields.placeholder) {
    //     Object.defineProperty(props.formData, attribute, {
    //         value: undefined,
    //         writable: true, // Cho phép ghi đè giá trị thuộc tính
    //         enumerable: true, // Có thể lặp qua thuộc tính
    //         configurable: true // Có thể cấu hình lại thuộc tính
    //     });
    // } else
    //     Object.defineProperty(props.formData, attribute, {
    //         value: value,
    //         writable: true, // Cho phép ghi đè giá trị thuộc tính
    //         enumerable: true, // Có thể lặp qua thuộc tính
    //         configurable: true // Có thể cấu hình lại thuộc tính
    //     });
    // console.log(props.formData);
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
        <label class="block font-medium text-gray-900">{{ services_fields.label }}: <span
                v-if="stringToObject?.required">*</span></label>
        <select v-model="input" class="text-sm bg-gray-50 border border-gray-300 text-gray-900 rounded-[9999px] focus:ring-blue-500 
                focus:border-blue-500 block w-full p-2.5" :aria-label="services_fields.label"
            :placeholder="services_fields.placeholder" :="stringToObject"
            @change="updateFormData(services_fields.field_name, input)">
            <option :value="services_fields.placeholder" selected>{{ services_fields?.placeholder }}</option>
            <option v-for="(value, index) in service_field_value">{{ value.name }}</option>
        </select>
    </div>
</template>
