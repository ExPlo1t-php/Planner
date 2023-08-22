<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    // Table items
    import TableHead from '@/Components/Table/TableHead.vue';
    import TableBody from '@/Components/Table/TableBody.vue';
    import TableHeadItem from '@/Components/Table/TableHeadItem.vue';
    import TableRowItem from '@/Components/Table/TableRowItem.vue';
    import TableRow from '@/Components/Table/TableRow.vue';
    import Pagination from '@/Components/Table/Pagination.vue';
    import { getNameById, objectFinder, checkDateValidity, getValiditySvg, format, timeDiff } from '@/utils';
    import { ref, watch } from 'vue'
    import { router, usePage } from '@inertiajs/vue3';
    // search
    const { props } = usePage();
    let search = ref(props.filters.search||null);
    watch(search, value=>{
    router.get(route('employees.show_absences'), { search: value }, { preserveState: true});
    })
</script>
<template>
    <AuthenticatedLayout>
        <Head title="Absence management"/>
        <div class="py-12 ">
            <div class="max-w-fit mx-auto sm:px-6 lg:px-8 p-3 bg-white overflow-auto">
                <input
                        class="border border-gray-300 rounded-lg px-2 lg:w-40"
                        type="search"
                        name="search"
                        placeholder="Recherche"
                        v-model="search"
                        >
                <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                    <TableHead>
                        <TableHeadItem>Matricule de l'employé</TableHeadItem>
                        <TableHeadItem>Prénom de l'employé</TableHeadItem>
                        <TableHeadItem>Nom de l'employé</TableHeadItem>
                        <TableHeadItem>Motif</TableHeadItem>
                        <TableHeadItem>Date debut</TableHeadItem>
                        <TableHeadItem>Date fin</TableHeadItem>
                        <TableHeadItem>Duree</TableHeadItem>
                        <TableHeadItem>validite</TableHeadItem>
                    </TableHead>
                    <TableBody>
                        <template v-if="absences.data && absences.data.length > 0">
                        <TableRow v-for="absence in absences.data" :key="absence.id" >
                            <TableRowItem>
                                <div class="text-gray-600">{{ objectFinder(employees, absence.employee_id).employee_number }}</div>
                            </TableRowItem>
                            <TableRowItem>
                                <div class="text-gray-600">{{ objectFinder(employees, absence.employee_id).first_name }}</div>
                            </TableRowItem>
                            <TableRowItem>
                                <div class="text-gray-600">{{ objectFinder(employees, absence.employee_id).last_name }}</div>
                            </TableRowItem>
                            <TableRowItem>
                                <template v-if="absence.reason">
                                    {{ absence.reason }}
                                </template>
                                <template v-else>
                                    <div class="text-red-400">N/A</div>
                                </template>
                            </TableRowItem>
                            <TableRowItem>
                                <div class="text-gray-600">{{ format(absence.start_date) }}</div>
                            </TableRowItem>
                            <TableRowItem>
                                <div class="text-gray-600">{{ format(absence.end_date) }}</div>
                            </TableRowItem>
                            <TableRowItem>
                                <div class="text-gray-600">{{ timeDiff(absence.start_date, absence.end_date) }}</div>
                            </TableRowItem>
                            <TableRowItem>
                                <div class="" v-html="getValiditySvg(checkDateValidity(absence.end_date))"></div>
                            </TableRowItem>
                        </TableRow>
                    </template>
                    <template v-else>
                    <TableRow>
                        <TableRowItem class="px-6 py-4" colspan="4">
                            Aucun Absences trouvé
                        </TableRowItem>
                    </TableRow>
                    </template>
                    </TableBody>
                </table>
                <!-- pagination -->
                <Pagination :links="absences.links"/>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script>
    export default {
        props: {
            absences: Array,
            employees: Array,
        },

        components: { Pagination },
    }
</script>