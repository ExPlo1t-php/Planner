<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import AccordionLink from '@/Components/AccordionLink.vue';
import Accordion from '@/Components/Accordion.vue'

</script>
<template>
    <AuthenticatedLayout>
        <div class="bg-white my-6 p-4 max-w-full m-auto mx-20 overflow-auto">
            <Accordion class="border border-gray-400 group">
                <template v-slot:title>
                    <span class="font-bold  group-hover:text-gray-600 underline underline-offset-2">
                        Première configuration
                    </span>
                </template>
                <template v-slot:content>
                    <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                        
                        <p class="mb-2 text-gray-500 dark:text-gray-400">Si c'est la première fois que vous ajoutez des données, vous devez suivre cet ordre:</p>
                        <p class="mb-2 text-gray-500 dark:text-gray-400"><span class="font-bold text-gray-800">Positions: </span> <br> Operator→ Team Leader→ Shift Leader→ Manager .....</p>
                        <p class="mb-2 text-gray-500 dark:text-gray-400"><span class="font-bold text-gray-800">Departments: </span> <br> Pre Assembly→ Assembly ....</p>
                    </div>
                </template>
            </Accordion>
        </div>
    </AuthenticatedLayout>
</template>