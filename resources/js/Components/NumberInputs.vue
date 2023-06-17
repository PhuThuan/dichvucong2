<script setup>
import { computed, defineProps } from 'vue';
const props = defineProps({
    services_fields: {
        type: Object,
    },
    service_field_value: {
        type: Array,
    }
});
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
    <div class="">
        <label :for="services_fields.field_name" class="block font-medium text-gray-900 ">{{ services_fields.label
        }}:
            <span v-if="stringToObject.required">*</span>
        </label>
        <input :type="services_fields.html_type" :id="services_fields.field_name" class="text-sm shadow-sm bg-gray-50 
        border border-gray-300 text-gray-900 rounded-[9999px] 
            focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " :="stringToObject"
            :placeholder="services_fields.placeholder" />
    </div>
</template>