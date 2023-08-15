<script setup>
const props = defineProps({
    value: {
        default: null,
    },
});

</script>

<template>
    <input
        type="checkbox"
        :value="value"
        class="rounded border-gray-300 text-gray-600 shadow-sm focus:ring-gray-500 m-2"
    />
</template>
