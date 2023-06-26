<!-- ? Error -->
<script setup>
import { computed, ref, onMounted, onUpdated, reactive } from 'vue';
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
const emit = defineEmits(['radioResponse']);

onUpdated(() => {
    eventSubmit();
})

// Chạy sau khi render
onMounted(() => {
    emit('radioResponse', {
        required: (stringToObject.value?.required ? true : false)
    })
})

// Dữ liệu lấy từ Database, mảng field input. http://127.0.0.1:8000/user/service/{id_service}
let service_field_value = ref(props.services_fields.service_field_value)

// Khởi tạo biến lấy giá trị của đầu vào (input)
let input = ref()
let inputValues = reactive([]); // Khởi tạo mảng động


// Khởi tạo biến lưu các giá trị validate
let validate = ref({
    errors: {}
});

function eventSubmit() {
    if (props.submitClicked) {
        updateFormData(props.services_fields.field_name.value, input)
    }
}

function createInputObject(array) {
    // Duyệt qua mảng gốc và tạo đối tượng cho mỗi phần tử
    array.value.forEach((item, index) => {
        let inputObject = {
            [item.name]: []
        };
        // console.log(inputObject)
        inputValues.push(inputObject); // Thêm đối tượng vào mảng inputValues
    });
}

// Gọi hàm createInputObject để tạo mảng đối tượng inputValues
createInputObject(service_field_value);

function updateFormData(attribute, id_service_field_value) {
    // Cập nhật giá trị của trường input trong biến formData của component cha
    // props.formData[attribute] = value;
    Object.defineProperty(props.formData, attribute, {
        value: `radio,${id_service_field_value}`,
        writable: true, // Cho phép ghi đè giá trị thuộc tính
        enumerable: true, // Có thể lặp qua thuộc tính
        configurable: true // Có thể cấu hình lại thuộc tính
    });

    validate.value[props.services_fields.field_name] = id_service_field_value;
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
    if (props.formData[props.services_fields.field_name] === 'radio')
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

// Xác thực checkbox
const validateForm = () => {
    let isValid = true;

    if (stringToObject.value?.required) {
        // console.log(props.formData[props.services_fields.field_name]);
        if (!props.formData[props.services_fields.field_name]) {
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
    <div class="">
        <div>{{ services_fields.label }}: <span class="text-[#fb4762]" v-if="stringToObject?.required">*</span></div>
        <div v-for="(item, index) in service_field_value" class="flex items-center" :key="item.id">
            <input type="radio" :id="services_fields.field_name + index" :name="services_fields.field_name" class="text-sm shadow-sm bg-gray-50 
        border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block w-4 h-4 rounded"
                :placeholder="services_fields.placeholder" :="stringToObject"
                @click="updateFormData(services_fields.field_name, item.id)" />
            <label :for="services_fields.field_name + index" class="block font-medium text-gray-900 ml-2">{{
                item.name }}
            </label>
        </div>
        <InputError class="mt-2" :message="validate.errors[props.services_fields.field_name]"
            :required="stringToObject?.required" />
    </div>
</template>