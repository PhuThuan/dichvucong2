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
        <label class="block font-medium text-gray-900">{{ services_fields.label }}: <span
                v-if="stringToObject.required">*</span></label>
        <select v-model="services_fields.placeholder" class="text-sm bg-gray-50 border border-gray-300 text-gray-900 rounded-[9999px] focus:ring-blue-500 
                focus:border-blue-500 block w-full p-2.5" :aria-label="services_fields.label"
            :placeholder="services_fields.placeholder" :="stringToObject">
            <option :value="services_fields.placeholder" selected>{{ services_fields.placeholder }}</option>
            <option v-for="(value, index) in service_field_value" :value="index">{{ value.name }}</option>
        </select>
    </div>
</template>
