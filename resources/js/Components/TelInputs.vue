<script setup>
import { computed, ref, onMounted } from 'vue';
import InputError from '@/Components/InputError.vue';
const props = defineProps({
    services_fields: {
        type: Object,
    },
    formData: {
        type: Object,
    },
});
const emit = defineEmits(['telResponse']);

// Chạy sau khi render
onMounted(() => {
    emit('telResponse', {
        required: (stringToObject.value.required ? true : false)
    })
})

// Khởi tạo biến lấy giá trị của đầu vào (input)
let input = ref()

// Khởi tạo biến lưu các giá trị validate
let validate = ref({
    errors: {}
});

function updateFormData(attribute, value) {
    // Cập nhật giá trị của trường input trong biến formData của component cha
    validate.value[props.services_fields.field_name] = value;
    if (validateForm()) {

        Object.defineProperty(props.formData, attribute, {
            value: value,
            writable: true, // Cho phép ghi đè giá trị thuộc tính
            enumerable: true, // Có thể lặp qua thuộc tính
            configurable: true // Có thể cấu hình lại thuộc tính
        });
        validateForm()
    } else {
        delete props.formData[attribute];
        if (!stringToObject.value.required) {
            validate.value[props.services_fields.field_name] = null
        }
        validateForm()
    }
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

// Xác thực số điện thoại
const validateForm = () => {
    let isValid = true;

    // Validate phone
    const phoneRegex = /^(0|\\+?84)(3[2-9]|5[689]|7[06789]|8[1-5]|9[014689])[0-9]{7}$/;
    if (stringToObject.value.required) {
        if (!validate.value[props.services_fields.field_name]) {
            validate.value.errors[props.services_fields.field_name] = 'Số điện thoại không được bỏ trống.';
            isValid = false;
        }
        else if (!phoneRegex.test(validate.value[props.services_fields.field_name]) && validate.value[props.services_fields.field_name]) {
            validate.value.errors[props.services_fields.field_name] = 'Số điện thoại không đúng.';
            isValid = false;
        }
        else {
            validate.value.errors[props.services_fields.field_name] = '';
        }
    }
    else {
        if (!validate.value[props.services_fields.field_name]) {
            validate.value.errors[props.services_fields.field_name] = '';
        }
        else if (!phoneRegex.test(validate.value[props.services_fields.field_name]) && validate.value[props.services_fields.field_name]) {
            validate.value.errors[props.services_fields.field_name] = 'Số điện thoại không đúng.';
            isValid = false;
        }
        else {
            validate.value.errors[props.services_fields.field_name] = '';
        }
    }
    console.log(stringToObject);
    return isValid;
};
</script>

<template>
    <div class="">
        <label :for="services_fields.field_name" class="block font-medium text-gray-900 ">{{ services_fields.label
        }}:
            <span v-if="stringToObject?.required">*</span>
        </label>
        <input v-model="input" :id="services_fields.field_name" class="text-sm shadow-sm bg-gray-50 
        border border-gray-300 text-gray-900 rounded-[9999px] 
            focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " type="tel" autocomplete="tel"
            pattern="^(0|\\+?84)(3[2-9]|5[689]|7[06789]|8[1-5]|9[014689])[0-9]{7}$" title="" :="stringToObject"
            :placeholder="services_fields.placeholder" @input="updateFormData(services_fields.field_name, input)">
        <InputError class="mt-2" :message="validate.errors[props.services_fields.field_name]"
            :required="stringToObject?.required" />
    </div>
</template>
