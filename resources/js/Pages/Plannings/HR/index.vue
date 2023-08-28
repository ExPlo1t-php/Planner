<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/inertia-vue3';
// table items
import TableHead from '@/Components/Table/TableHead.vue';
import TableBody from '@/Components/Table/TableBody.vue';
import TableHeadItem from '@/Components/Table/TableHeadItem.vue';
import TableRowItem from '@/Components/Table/TableRowItem.vue';
import TableRow from '@/Components/Table/TableRow.vue';
import { objectFinder } from '@/utils';

</script>
<template>
    <AuthenticatedLayout>
        <Head title="HR Planning"/>
        <div class="bg-white my-6 max-w-full m-auto mx-20 overflow-auto">
            <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                <TableHead>
                    <TableHeadItem class="w-10">
                    </TableHeadItem>
                    <TableHeadItem class="w-10">
                        Mon
                    </TableHeadItem>
                    <TableHeadItem class="w-10">
                        Tue
                    </TableHeadItem>
                    <TableHeadItem class="w-10">
                        Wed
                    </TableHeadItem>
                    <TableHeadItem class="w-10">
                        Thu
                    </TableHeadItem>
                    <TableHeadItem class="w-10">
                        Fri
                    </TableHeadItem>
                </TableHead>
                <TableBody>
                    <template v-for="item in items" >
                        <TableRow>
                            <!-- side title -->
                            <TableHeadItem class="bg-gray-100 h-52 w-10">
                                IT
                            </TableHeadItem>
                            <!-- side title -->
                            <TableRowItem class="h-52 w-52 text-center border">
                                <template v-for="employeeId in Jason(item).MON.IT.employees">
                                    <div
                                        class="text-xs inline-flex items-center font-bold leading-sm uppercase px-3 py-1 bg-blue-200 text-blue-700 rounded-full"
                                    > {{objectFinder(employees, employeeId)}}</div>
                                </template>
                            </TableRowItem>
                            <TableRowItem class="h-52 w-52 text-center border">
                                {{  Jason(item).TUE.IT.employees}}
                            </TableRowItem>
                            <TableRowItem class="h-52 w-52 text-center border">
                                {{  Jason(item).WED.IT.employees}}
                            </TableRowItem>
                            <TableRowItem class="h-52 w-52 text-center border">
                                {{  Jason(item).THU.IT.employees}}
                            </TableRowItem>
                            <TableRowItem class="h-52 w-52 text-center border">
                                {{  Jason(item).FRI.IT.employees}}
                            </TableRowItem>
                        </TableRow>
                    </template>
                </TableBody>
            </table>
        </div>
    </AuthenticatedLayout>
</template>
<script>
export default {
    props: {
        items: Array,
        employees: Array,
    },
    methods:{
        Jason(item) {
            return JSON.parse(item.week_details);
        }
    }
}
</script>