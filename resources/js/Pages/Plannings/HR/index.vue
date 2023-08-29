<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/inertia-vue3';
import { objectFinder } from '@/utils';
import { Modal } from 'flowbite-vue'
import { ref } from 'vue'
// table items
import TableHead from '@/Components/Table/TableHead.vue';
import TableBody from '@/Components/Table/TableBody.vue';
import TableHeadItem from '@/Components/Table/TableHeadItem.vue';
import TableRowItem from '@/Components/Table/TableRowItem.vue';
import TableRow from '@/Components/Table/TableRow.vue';

const isShowModal = ref(false)
function closeModal() {
  isShowModal.value = false
}
function showModal() {
  isShowModal.value = true
}
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
                        <template v-for="(row, rowId) in Jason(item)">
                            <TableRow>
                                <TableHeadItem class="bg-gray-100 h-52 w-10">
                                    {{ rowId }}
                                </TableHeadItem>
                                <template v-for="day in ['MON','TUE','WED','THU','FRI']">
                                    <TableRowItem>
                                        <template v-for="employeeId in row[day].employees">
                                    <div
                                        class="text-xs inline-flex items-center font-bold leading-sm uppercase px-3 py-1  rounded-full"
                                        :class="Jason(item).IT.MON.absences.includes(employeeId)?'bg-red-200 text-red-700':'bg-blue-200 text-blue-700'">
                                        
                                         {{objectFinder(employees, employeeId).id}}
                                    {{objectFinder(employees, employeeId).first_name}}
                                    {{objectFinder(employees, employeeId).last_name}}</div>
                                </template>
                                    </TableRowItem>
                                    </template>
                            </TableRow>
                        </template>
                    </template>
                </TableBody>
            </table>
            <div @click="showModal" class="h-10 w-full flex justify-center hover:bg-gray-200">
                <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 12H20M12 4V20" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <Modal :size="size" v-if="isShowModal" @close="closeModal">
            <template #header>
                <div class="flex items-center text-lg">
                Terms of Service
                </div>
            </template>
            <template #footer>
                <div class="flex justify-between">
                <button @click="closeModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                    Decline
                </button>
                <button @click="closeModal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    I accept
                </button>
                </div>
            </template>
            </Modal>
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