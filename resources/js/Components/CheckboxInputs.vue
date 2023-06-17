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
    <div v-for="(item, index) in service_field_value" class="flex items-center">
        <input :type="services_fields.html_type" :id="services_fields.field_name + index" class="text-sm shadow-sm bg-gray-50 
        border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block w-4 h-4 rounded"
            :placeholder="services_fields.placeholder" :="stringToObject" />
        <label :for="services_fields.field_name + index" class="block font-medium text-gray-900 ml-2">{{
            item.name }} <span v-if="stringToObject.required">*</span>
        </label>
    </div>
</template>