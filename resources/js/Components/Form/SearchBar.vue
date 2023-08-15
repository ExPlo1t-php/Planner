<template>
        <input
            class="border border-gray-300 rounded-lg px-2 lg:w-40"
            type="search"
            name="search"
            placeholder="Recherche"
            v-model="search"
            >
</template>

<script setup> 
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3'
</script>