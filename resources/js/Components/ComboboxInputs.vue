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
const emit = defineEmits(['comboboxResponse']);

onUpdated(() => {
    eventSubmit();
})

// Chạy sau khi render
onMounted(() => {
    emit('comboboxResponse', {
        required: (stringToObject.value?.required ? true : false)
    })
})

// Khởi tạo biến lưu các giá trị validate
let validate = ref({
    errors: {}
});

function eventSubmit() {
    if (props.submitClicked) {
        updateFormData(props.services_fields.field_name.value, input)
    }
}

// Dữ liệu lấy từ Database, mảng field input. http://127.0.0.1:8000/user/service/{id_service}
let service_field_value = ref(props.services_fields.service_field_value)

// Khởi tạo biến lấy giá trị của đầu vào (input)
let input = ref(props.services_fields.placeholder)

function updateFormData(attribute, value) {
    // Cập nhật giá trị của trường input trong biến formData của component cha
    if (input !== props.services_fields.placeholder)
        props.formData[props.services_fields.field_name] = `select,${input.value}`;

    //
    validate.value[props.services_fields.field_name] = value;
    if (validateForm()) {
        validateForm()
    } else {
        delete props.formData[attribute];
        if (!stringToObject.value?.required) {
            validate.value[props.services_fields.field_name] = null
        }
        validateForm()
    }
    delete props.formData['undefined'];
    // Xoá dữ liệu từ formData nếu input value rỗng
    // console.log(props.formData[props.services_fields.field_name]);
    if (props.formData[props.services_fields.field_name] === `select,${props.services_fields?.placeholder}`)
        delete props.formData[props.services_fields.field_name];
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

// Xác thực combobox
const validateForm = () => {
    let isValid = true;

    if (stringToObject.value?.required) {
        if ((props.formData[props.services_fields.field_name] === `select,${props.services_fields?.placeholder}`) || !props.formData[props.services_fields.field_name]) {
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
    // console.log(validate.value);
    return isValid;
};
</script>

<template>
    <div class="">
        <label class="block font-medium text-gray-900">{{ services_fields.label }}: <span class="text-[#fb4762]" v-if="stringToObject?.required">*</span></label>
        <select v-model="input" class="text-sm bg-gray-50 border border-gray-300 text-gray-900 rounded-[9999px] focus:ring-blue-500 
                focus:border-blue-500 block w-full p-2.5" :aria-label="services_fields.label"
            :placeholder="services_fields?.placeholder" :="stringToObject"
            @change="updateFormData(services_fields.field_name, input)">
            <option selected>{{ services_fields?.placeholder }}</option>
            <option :value="value.id" v-for="(value, index) in service_field_value">{{ value.name }}</option>
        </select>
        <InputError class="mt-2" :message="validate.errors[props.services_fields.field_name]"
            :required="stringToObject?.required" />
    </div>
</template>
