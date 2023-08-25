<template>
    <div>
      <template v-if="id">
        {{ getNameById(array, id) }}
      </template>
      <template v-else>
        <div class="text-red-400">N/A</div>
      </template>
    </div>
  </template>
  
  <script>
  import { getNameById } from '@/utils';
  export default {
    props: {
      id: {
        required: true,
      },
      array: {
        type: Array, 
        required: true,
      },
    },
    methods: {
      getNameById,
    },
  };
  </script>
  