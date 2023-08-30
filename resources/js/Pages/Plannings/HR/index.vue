<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { objectFinder,
    getWeekNumber,
    getCurrentYear,
    addDepartment,
    getNameById, getDepartmentPositions, getPositions, addObjectToArray  } from '@/utils';
import Modal from '@/Components/Modal.vue';
import { ref, watch } from 'vue'
import { Head, useForm, router, Link, usePage } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
// table items
import TableHead from '@/Components/Table/TableHead.vue';
import TableBody from '@/Components/Table/TableBody.vue';
import TableHeadItem from '@/Components/Table/TableHeadItem.vue';
import TableRowItem from '@/Components/Table/TableRowItem.vue';
import TableRow from '@/Components/Table/TableRow.vue';
// Form items
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import DateInput from '@/Components/Form/DateInput.vue';
import SelectInput from '@/Components/Form/SelectInput.vue';
import { MultiSelect, ModelListSelect } from 'vue-search-select'
import "vue-search-select/dist/VueSearchSelect.css"
// messages
import Error from '@/Components/Messages/Error.vue' 
const form = useForm({
    start_date: '',
    end_date: '',
    year: getCurrentYear(),
    week_number: getWeekNumber(),
    week_details: {}
})

// form
const department = ref('')
// form states
const dep_state = ref(false)

const days = ['MON','TUE','WED','THU','FRI'];
</script>
<template>
    <AuthenticatedLayout>
        <Head title="HR Planning"/>
        <div class="bg-white my-6 max-w-full m-auto mx-20 overflow-auto">
            <div class="flex">
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
                        <template v-if="items.length" v-for="item in items" >
                            <template v-for="(row, rowId) in Jason(item)">
                                <TableRow>
                                    <TableHeadItem class="bg-gray-100 h-52 w-10">
                                        {{ rowId }}
                                    </TableHeadItem>
                                        <template v-for="day in days">
                                            <TableRowItem>
                                                <template v-for="employeeId in row[day].employees">
                                                    <div
                                                        class="text-xs inline-flex items-center font-bold leading-sm uppercase px-3 py-1  rounded-full"
                                                        :class="Jason(item).IT.MON.absences.includes(employeeId)?'bg-red-200 text-red-700':'bg-blue-200 text-blue-700'">
                                                        
                                                        {{objectFinder(employees, employeeId).first_name}}
                                                        {{objectFinder(employees, employeeId).last_name}}
                                                    </div>
                                                </template>
                                                {{ row[day].employees.length }}
                                            </TableRowItem>
                                        </template>
                                </TableRow>
                            </template>
                        </template>
                        <template v-else>
                            <TableRowItem colspan="6">
                                <Modal :buttonId="1" :modals="modals"  :payload="{ id: 1, isOpen: false }">
                                    <template #button>
                                        <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M4 12H20M12 4V20" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </template>
                                    <template #content>
                                        <form @submit.prevent="submit" class="px-2">
                                            <div class="flex">
                                                <div class="pr-2 border-r-2">
                                                    <div class="my-2">
                                                        <InputLabel for="start_date" value="date debut" />
                                                            
                                                        <DateInput
                                                        id="start_date"
                                                        class="mt-1 block"
                                                        v-model="form.start_date"
                                                        required
                                                        autofocus
                                                        autocomplete="start_date"
                                                        />
                                                        
                                                        <InputError class="mt-2" :message="form.errors.end_date" />
                                                    </div>
                                                    <div class="my-2">
                                                        <InputLabel for="end_date" value="date fin" />
                                                            
                                                        <DateInput
                                                        id="end_date"
                                                        class="mt-1 block"
                                                        v-model="form.end_date"
                                                        required
                                                        autofocus
                                                        autocomplete="end_date"
                                                        />
                                                        
                                                        <InputError class="mt-2" :message="form.errors.end_date" />
                                                    </div>
                                                    <div class="my-2">
                                                        <InputLabel for="department" value="departments" />
    
                                                        <ModelListSelect
                                                            id="department"
                                                            :list="departments"
                                                            optionValue="id"
                                                            optionText="name"
                                                            v-model="department"
                                                            class="border-gray-300 focus:border-gray-500 focus:ring-gray-500 rounded-md shadow-sm mb-2"
                                                            placeholder="Choisir une departements">
                                                        </ModelListSelect>
                                                        <PrimaryButton @click="addDepartment(form.week_details, department)" :disabled="dep_state">
                                                            add department
                                                        </PrimaryButton>
                                                        <InputError class="mt-2" :message="form.errors.terminal_id" />
                                                    </div>
                                                    <div>

                                                    </div>
                                                </div>
                                                <div class="block lg:flex">

                                                    <template v-for="day in days">
                                                        <div class="mx-12 p-12 border w-full">
                                                            <span class="underline font-bold">{{ day }}</span>
                                                            <InputLabel for="employees" value="employees" />
    
                                                            <MultiSelect
                                                                id="employees"
                                                                :list="employees"
                                                                optionValue="id"
                                                                optionText="first_name"
                                                                v-model="form.week_details.department[day]"
                                                                class="border-gray-300 focus:border-gray-500 focus:ring-gray-500 rounded-md shadow-sm mb-2"
                                                                placeholder="Choisir employees">
                                                            </MultiSelect>
                                                            <InputError class="mt-2" :message="form.errors.terminal_id" />
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                        </form>
                                    </template>
                                </Modal>
                            </TableRowItem>
                        </template>
                    </TableBody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script>
export default {
    props: {
        items: Array,
        employees: Array,
        absences: Array,
        drivers: Array,
        terminals: Array,
        vehicles: Array,
        departments: Array
    },
    methods:{

        Jason(item) {
            return JSON.parse(item.week_details);
        }
    },
    data(){
        return{
            modals: [],
            formData: {
                planning_type: 'admin',
                rows: 0,
                start_date: '',
                end_date: '',
                year: '',
                week_number: null,
                number_of_columns: 0,
                week_details: {}
            }
        }
    },
}
</script>