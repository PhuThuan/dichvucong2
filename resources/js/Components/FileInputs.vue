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
    <div class="flex flex-wrap items-center">
        <label :for="services_fields.field_name" class="block font-medium text-gray-900">{{
            services_fields.field_name }} <span v-if="stringToObject.required">*</span>
        </label>
        <input :type="services_fields.html_type" :id="services_fields.field_name" class="
        text-sm shadow-sm bg-gray-50 border border-gray-300 text-gray-900 block w-full cursor-pointer 
        file:text-sm file:font-semibold file:py-2 file:px-4 file:bg-violet-50 file:text-[#3b82f6]
        file:rounded-full file:border-0 file:mr-4 hover:file:bg-violet-100 rounded-[9999px] focus:outline-[#3b82f6]"
            :placeholder="services_fields.placeholder" :="stringToObject"
            accept="image/png, image/jpeg, .doc, .docx, .pdf, .pptx" />
    </div>
</template>