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
            <GridStack :items="gridItems"/>
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
        data() {
            return {
            gridItems: [
                { id: 1, x: 0, y: 0, width: 120, height: 1, content: 'Item 12' },
                { id: 2, x: 2, y: 0, width: 1, height: 1, content: 'Item 2' },
                // Add more items here
            ],
            };
        },
        
    }
</script>