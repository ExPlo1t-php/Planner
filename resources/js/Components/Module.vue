<script setup>
import { Link } from '@inertiajs/vue3';
const props = defineProps({
  link: {
      type: String,
      required: true,
    },
});
</script>
<template>
  <Link :href="route(link)" class="m-4">
    <div class="max-w-xs p-3 text-center bg-white border border-gray-200 hover:bg-gray-400 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 cursor-pointer">
      <h5 class="mb-2 text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
          <slot/>
      </h5>
    </div>
  </Link>
</template>
