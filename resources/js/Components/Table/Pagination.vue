<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="mt-6">
        <Component
            :is="link.url ? 'Link' : 'span'"
            v-for="link in links"
            :href="link.url"
            v-html="link.label"
            class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
            :class="link.url ? '': 'hidden'"
        />
    </div>
</template>
<script>
export default {
    props: {
        links: Array
    },
    components: {
        Link,
    }
};
</script>