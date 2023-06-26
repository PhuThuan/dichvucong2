<script setup>
import axios from 'axios';
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
const emit = defineEmits(['addressResponse']);

onUpdated(() => {
    eventSubmit();
})

// Chạy sau khi render
onMounted(() => {
    emit('addressResponse', {
        required: (stringToObject.value?.required ? true : false)
    })
})

// Khởi tạo biến lấy giá trị của đầu vào (input)
let streetNameInput = ref()

// Khởi tạo biến lưu giá trị tạm cho input 
let inputData = ref({})

// Khởi tạo biến lưu các giá trị validate
let validate = ref({
    errors: {
        [props.services_fields.field_name]: {},
    },
    [props.services_fields.field_name]: {},
});

function eventSubmit() {
    if (props.submitClicked) {
        updateFormData()
    }
}

// function updateFormData(attribute, value) {
//     // Cập nhật giá trị của trường inputData 
//     Object.defineProperty(inputData.value, attribute, {
//         value: value,
//         writable: true, // Cho phép ghi đè giá trị thuộc tính
//         enumerable: true, // Có thể lặp qua thuộc tính
//         configurable: true // Có thể cấu hình lại thuộc tính
//     });

//     // Cập nhật dữ liệu vào formData
//     if (inputData.value.city === undefined) {
//         delete props.formData[props.services_fields.field_name]
//     } else {
//         props.formData[props.services_fields.field_name] = inputData.value;
//         props.formData[props.services_fields.field_name].streetName = streetNameInput.value;
//     }

//     validate.value[props.services_fields.field_name] = value;
//     if (validateForm()) {
//         validateForm()
//     } else {
//         // delete props.formData[props.services_fields.field_name];
//         if (!stringToObject.value?.required) {
//             validate.value[props.services_fields.field_name] = null
//         }
//         validateForm()
//     }
//     delete props.formData[props.services_fields.field_name]['undefined'];
//     // Xoá dữ liệu từ formData nếu input value rỗng
//     // console.log(props.formData[props.services_fields.field_name]);
//     // if (props.formData[props.services_fields.field_name] === 'checkbox')
//     //     delete props.formData[props.services_fields.field_name];
//     console.log(props.formData);
// };

function updateFormData(attribute, value) {
    // Cập nhật giá trị của trường inputData 
    Object.defineProperty(inputData.value, attribute, {
        value: value,
        writable: true, // Cho phép ghi đè giá trị thuộc tính
        enumerable: true, // Có thể lặp qua thuộc tính
        configurable: true // Có thể cấu hình lại thuộc tính
    });

    // Cập nhật dữ liệu vào validate
    if (inputData.value.city === undefined) {
        delete validate.value[props.services_fields.field_name]
    } else {
        validate.value[props.services_fields.field_name] = inputData.value;
        validate.value[props.services_fields.field_name].streetName = streetNameInput.value;
    }

    if (validateForm()) {
        validateForm()
    } else {
        // delete props.formData[props.services_fields.field_name];
        if (!stringToObject.value?.required) {
            validate.value[props.services_fields.field_name] = null
        }
        validateForm()
    }
    delete validate.value[props.services_fields.field_name]?.undefined;
    // Xoá dữ liệu từ formData nếu input value rỗng
    // console.log(validate.value[props.services_fields.field_name]?.streetName);
    if (validate.value[props.services_fields.field_name]?.city === undefined || validate.value[props.services_fields.field_name]?.streetName === undefined)
        delete props.formData[props.services_fields.field_name];
    // console.log(validate.value);

    // update vao formData
    props.formData[props.services_fields.field_name] = JSON.stringify(validate.value[props.services_fields.field_name]);
};

// Kiểm tra fetch dữ liệu
let isLoading = ref({});

let addressData = {};
// Khởi tạo các biến lưu địa chỉ
let citys = ref(null);
let districts = ref(null);
let wards = ref(null);

// Khởi tạo các biến lưu index của địa chỉ
let cityIndex = ref(null);
let districtIndex = ref(null);
let wardIndex = ref(null);

// Khởi tạo các hàm cập nhật cityIndex
function updateCity(attribute, value) {
    updateFormData(attribute, value);
    // Xoá dữ liệu khi chọn lại city
    updateFormData('district', undefined);
    updateFormData('ward', undefined);

    districtIndex.value = null;
    wardIndex.value = null;
    districts.value = null;
    wards.value = null;
    if (cityIndex.value !== null) {
        districts.value = addressData[cityIndex.value]['Districts'];
        // console.log(districts);
    } else {
        // Reset lại các giá trị
        districts.value = null;
        wards.value = null;
        districtIndex.value = null;
        wardIndex.value = null;
    }
}
// Khởi tạo các hàm cập nhật Index
function updateDistrict(attribute, value) {
    updateFormData(attribute, value);
    // Xoá dữ liệu khi chọn lại city
    updateFormData('ward', undefined);

    wardIndex.value = null;
    wards.value = null;
    // console.log(wardIndex);
    if (districtIndex.value !== null) {
        wards.value = addressData[cityIndex.value]['Districts'][districtIndex.value]['Wards'];
        // console.log(districts);
    } else {
        // Reset lại các giá trị
        wards.value = null;
        wardIndex.value = null;
    }
}

const fetchData = async () => {
    isLoading.value = true;
    try {
        await axios({
            method: 'get',
            url: '/get-address',
        }).then(function (response) {
            addressData = response.data;
            citys.value = response.data;
             console.log(addressData);
        })
    } catch (error) {
        console.error(error);
    }
    isLoading.value = false;
};
// Chạy sau khi render
onMounted(() => {
    fetchData();
})

// computed chuyển đổi chuỗi thành đối tượng
const stringToObject = computed(() => {
    if (props.services_fields?.validate) {
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

// Xác thực address
const validateForm = () => {
    let isValid = true;

    if (stringToObject.value?.required) {
        // city, district, ward
        if (!validate.value[props.services_fields.field_name]?.city) {
            validate.value.errors[props.services_fields.field_name].city = `Tỉnh/Thành phố không được bỏ trống.`;
            validate.value.errors[props.services_fields.field_name].district = `Quận/Huyện không được bỏ trống.`;
            validate.value.errors[props.services_fields.field_name].ward = `Phường/Xã không được bỏ trống.`;
            isValid = false;
        }
        else if (!validate.value[props.services_fields.field_name]?.district) {
            validate.value.errors[props.services_fields.field_name].city = ``;
            validate.value.errors[props.services_fields.field_name].district = `Quận/Huyện không được bỏ trống.`;
            validate.value.errors[props.services_fields.field_name].ward = `Phường/Xã không được bỏ trống.`;
            isValid = false;
        }
        else if (!validate.value[props.services_fields.field_name]?.ward) {
            validate.value.errors[props.services_fields.field_name].city = ``;
            validate.value.errors[props.services_fields.field_name].district = ``;
            validate.value.errors[props.services_fields.field_name].ward = `Phường/Xã không được bỏ trống.`;
            isValid = false;
        }
        else {
            validate.value.errors[props.services_fields.field_name].city = ``;
            validate.value.errors[props.services_fields.field_name].district = ``;
            validate.value.errors[props.services_fields.field_name].ward = ``;
        }

        // streetName
        if (!validate.value[props.services_fields.field_name]?.streetName) {
            validate.value.errors[props.services_fields.field_name].streetName = `Tên đường không được bỏ trống.`;
            isValid = false;
        }
        else {
            validate.value.errors[props.services_fields.field_name].streetName = ``;
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
    <div class="d-flex text-dark">
        <!-- Chọn thành phố  -->
        <div class="">
            <label class="block font-medium text-gray-900">Tỉnh/Thành Phố: <span class="text-[#fb4762]"
                    v-if="stringToObject?.required">*</span></label>
            <select class="text-sm bg-gray-50 border border-gray-300 text-gray-900 rounded-[9999px] focus:ring-blue-500 
                focus:border-blue-500 block w-full p-2.5" v-model="cityIndex"
                @change="updateCity('city', addressData[cityIndex]?.Name)" aria-label="City" :="stringToObject">
                <option :value="null">Chọn Tỉnh/Thành Phố</option>
                <option v-for="(city, index) in citys" :value="index">{{ city.Name }}</option>
            </select>
            <InputError class="mt-2" :message="validate.errors[props.services_fields.field_name]?.city"
                :required="stringToObject?.required" />
        </div>

        <!-- Chọn Quận -->
        <div class="">
            <label class="block font-medium text-gray-900">Quận/Huyện: <span class="text-[#fb4762]"
                    v-if="stringToObject?.required">*</span></label>
            <select :disabled="!districts"
                class="text-sm bg-gray-50 border border-gray-300 text-gray-900 rounded-[9999px] block w-full p-2.5"
                v-model="districtIndex"
                @change="updateDistrict('district', addressData[cityIndex]['Districts'][districtIndex]?.Name)"
                aria-label="District" :="stringToObject">
                <option :value="null">Chọn Quận/Huyện</option>
                <option v-for="(district, index) in districts" :value="index">{{ district.Name }}</option>
            </select>
            <InputError class="mt-2" :message="validate.errors[props.services_fields.field_name]?.district"
                :required="stringToObject?.required" />
        </div>

        <!-- Chọn Phường  -->
        <div class="">
            <label class="block font-medium text-gray-900">Phường/Xã: <span class="text-[#fb4762]"
                    v-if="stringToObject?.required">*</span></label>
            <select
                @change="updateFormData('ward', addressData[cityIndex]['Districts'][districtIndex]['Wards'][wardIndex]?.Name)"
                :disabled="!wards" class="text-sm bg-gray-50 border border-gray-300 text-gray-900 rounded-[9999px] focus:ring-blue-500 
                focus:border-blue-500 block w-full p-2.5" v-model="wardIndex" aria-label="Ward" :="stringToObject">
                <option :value="null">Chọn Phường/Xã</option>
                <option v-for="(ward, index) in wards" :value="index">{{ ward.Name }}</option>
            </select>
            <InputError class="mt-2" :message="validate.errors[props.services_fields.field_name]?.ward"
                :required="stringToObject?.required" />
        </div>

        <!-- Tên đường -->
        <div class="">
            <label :for="services_fields.field_name" class="block font-medium text-gray-900 ">Địa chỉ:
                <span class="text-[#fb4762]" v-if="stringToObject?.required">*</span>
            </label>
            <input v-model="streetNameInput" type="text" :id="services_fields.field_name" class="text-sm shadow-sm bg-gray-50 
        border border-gray-300 text-gray-900 rounded-[9999px] 
            focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="Ấp, thôn, tổ, tên đường...."
                :="stringToObject" @input="updateFormData('streetName', streetNameInput)" />
            <InputError class="mt-2" :message="validate.errors[props.services_fields.field_name]?.streetName"
                :required="stringToObject?.required" />
        </div>
    </div>
</template>
