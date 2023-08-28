<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  link: {
      type: String,
      required: true,
    },
    active: {
      type: Boolean,
    }
});
const classes = computed(() =>
    props.active
        ? 'bg-red-700 transition duration-150 ease-in-out'
        : 'border p-0 max-w-xs p-3 text-center bg-gray-800 hover:bg-gray-600 dark:bg-gray-800 cursor-pointer transition duration-150 ease-in-out'
);
</script>
<template>
    <Link :href="route(link)" >
        <div :class="classes">
            <h6 class="font-semibold tracking-tight text-white">
                <slot/>
            </h6>
        </div>
    </Link>
</template>
        