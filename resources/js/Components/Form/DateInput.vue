<template>
    <input
      class="border-gray-300 focus:border-gray-500 focus:ring-gray-500 rounded-md shadow-sm"
      type="date"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      ref="input"
    />
  </template>
  
  <script setup>
  import { onMounted, ref } from 'vue';
  import moment from 'moment';

  defineProps({
    modelValue: {
      type: String,
      required: true,
    },
  });

  const format = (value) => {
      return moment(value).format('DD-MM-YYYY');
  }
  
  defineEmits(['update:modelValue']);
  
  const input = ref(null);
  
  onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
      input.value.focus();
    }
  });
  
  defineExpose({ focus: () => input.value.focus() });
  </script>
  