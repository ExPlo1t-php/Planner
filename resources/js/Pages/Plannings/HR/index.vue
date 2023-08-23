<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/inertia-vue3';
// table items
import TableHead from '@/Components/Table/TableHead.vue';
import TableBody from '@/Components/Table/TableBody.vue';
import TableHeadItem from '@/Components/Table/TableHeadItem.vue';
import TableRowItem from '@/Components/Table/TableRowItem.vue';
import TableRow from '@/Components/Table/TableRow.vue';


const {props} = defineProps(['items'])
</script>
<template>
    <AuthenticatedLayout>
        <Head title="HR Planning"/>
        <div class="bg-white my-6 max-w-full m-auto mx-20 overflow-auto">
            <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                <TableHead>
                    <TableHeadItem class="w-10">
                        Head
                    </TableHeadItem>
                    <template v-for="item in items">
                        <TableHeadItem>
                            {{ item.name }}
                        </TableHeadItem>
                    </template>
                </TableHead>
                <TableBody>
<!-- ---------------------------------------------------------------------------------- -->
                <draggable v-model="list" tag="tbody" item-key="name">
                    <template #item="{ element }">
                        <TableRow>
                            <!-- side title -->
                            <TableRowItem class="bg-gray-100 h-52 w-10">
                                Pain
                            </TableRowItem>
                            <!-- side title -->
                        <template v-for="item in items" >
                            <template v-if="item.project_id == 3">
                                <TableRowItem class="h-52 w-52 text-center border">
                                    Pain{{ element.name }}
                                </TableRowItem>
                            </template>
                        </template>
                    </TableRow>
                </template>
                </draggable>
                <!-- ---------------------------------------------------------------------------------- -->
                </TableBody>
            </table>
        </div>
        <!-- <rawDisplayer class="col-3" :value="list" title="List" /> -->
    </AuthenticatedLayout>
</template>

<script>
// pain🥲⏬ 
import draggable from 'vuedraggable/src/vuedraggable'
    export default {
        name: "table-example",
        display: "Table",
        order: 8,
        components: {
            draggable
        },
    data() {
        return {
            list: [
                { id: 1, name: "Abby", sport: "basket" },
                { id: 2, name: "Brooke", sport: "foot" },
                { id: 3, name: "Courtenay", sport: "volley" },
                { id: 4, name: "David", sport: "rugby" }
            ],
            dragging: false
        }
    }
}
</script>