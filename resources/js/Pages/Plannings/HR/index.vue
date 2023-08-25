<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/inertia-vue3';
// table items
import TableHead from '@/Components/Table/TableHead.vue';
import TableBody from '@/Components/Table/TableBody.vue';
import TableHeadItem from '@/Components/Table/TableHeadItem.vue';
import TableRowItem from '@/Components/Table/TableRowItem.vue';
import TableRow from '@/Components/Table/TableRow.vue';


// const {props} = defineProps(['items'])

</script>
<template>
    <AuthenticatedLayout>
        <Head title="HR Planning"/>
        <div class="bg-white my-6 max-w-full m-auto mx-20 overflow-auto">
            <GridStack :items="items"/>
        </div>
        <!-- <rawDisplayer class="col-3" :value="list" title="List" /> -->
    </AuthenticatedLayout>
</template>

<script>
// pain🥲⏬ 
import draggable from 'vuedraggable/src/vuedraggable'
import GridStack from '@/Pages/Plannings/GridStack.vue'
// import 'gridstack/dist/gridstack.min.css';
// import { GridStack } from 'gridstack';
    export default {
        props: {
            items: Array,
        },
        components: {
            GridStack
        },
        
    }
</script>