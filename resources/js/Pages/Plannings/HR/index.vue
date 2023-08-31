<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { objectFinder,
    getWeekNumber,
    getCurrentYear,
    addDepartment,
    } from '@/utils';
import Modal from '@/Components/Modal.vue';
import { ref, } from 'vue'
import { Head, useForm } from '@inertiajs/vue3';
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
import DateInput from '@/Components/Form/DateInput.vue';
import { ModelListSelect } from 'vue-search-select'
import VueMultiselect from 'vue-multiselect'
import "vue-search-select/dist/VueSearchSelect.css"

// preparing form to insert data
const form = useForm({
    start_date: '',
    end_date: '',
    year: getCurrentYear(),
    week_number: getWeekNumber(),
    week_details: []
})

// form
// department select input's selected value
const department = ref('')
// responsible of enabling/disabling the button that shows the form.week_details manipulation form
const show = ref(false)
// responsible of containing the value of the index of each department's row in week details
const index = ref(null)
// this functions responsible of altering the "show", and "index" variables values 
// along with the AddDepartment function which is responsible of adding a department row
function handleDepartmentClick(weekDetails, departmentId){
    addDepartment(weekDetails, departmentId)
    show.value = true
    index.value = weekDetails.findIndex(obj => obj.department === departmentId)
}
// an array of days to loop through
const days = ['MON','TUE','WED','THU','FRI'];
</script>
<template>
    <AuthenticatedLayout>
        <Head title="HR Planning"/>
        <div class="bg-white my-6 max-w-full m-auto mx-20 overflow-auto">
            <!-- A container of the table that's the departments data is gonna be shown in, this is probably outdated/messed up -->
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
                        <!-- here we're looping through the props.items that conatines the history of the planning, supposedly of the current day -->
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
                                <!-- here's the modal that is responsible  of manipulating a new planning data -->
                                <!-- I made a reusable component so you can use multiple modals in one page using a unique id "buttonId" -->
                                <Modal :buttonId="1" :modals="modals"  :payload="{ id: 1, isOpen: false }">
                                    <template #button>
                                        <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M4 12H20M12 4V20" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </template>
                                    <template #content>
                                        <!-- a form where the planning data is gonna be manipulated -->
                                        <form @submit.prevent="submit" class="px-2">
                                            <div class="flex">
                                                <div class="pr-2 border-r-2">
                                                    <div class="my-2">
                                                        <InputLabel for="start_date" value="date debut" />
                                                            
                                                        <DateInput
                                                        id="start_date"
                                                        class="mt-1 block"
                                                        v-model="form.start_date"
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
                                                        autofocus
                                                        autocomplete="end_date"
                                                        />
                                                        
                                                        <InputError class="mt-2" :message="form.errors.end_date" />
                                                    </div>
                                                    <div class="my-2">
                                                        <InputLabel for="department" value="departments" />
                                                        <!-- in this select input, the user chooses a department clicks on add department button then mainpulate the planning's data  -->
                                                        <!-- when the user finishes editing, a button that resets the disabled button in case the user wants to add more departments -->
                                                        <!-- also a finish button should be added to submit the form and insert the data into the database -->
                                                        <ModelListSelect
                                                            id="department"
                                                            :list="departments"
                                                            optionValue="id"
                                                            optionText="name"
                                                            v-model="department"
                                                            class="border-gray-300 focus:border-gray-500 focus:ring-gray-500 rounded-md shadow-sm mb-2 w-full"
                                                            placeholder="Choisir une departements">
                                                        </ModelListSelect>
                                                        <PrimaryButton @change="show = true" @click="handleDepartmentClick(form.week_details, department)" :disabled="show">
                                                            add department
                                                        </PrimaryButton>
                                                        <InputError class="mt-2" :message="form.errors.terminal_id" />
                                                    </div>
                                                    <div>

                                                    </div>
                                                </div>
                                                <div class="block mx-4 lg:flex">
                                                    <template v-if="show">
                                                        <!-- this is where the planning's manipulation select inputs gonna be loaded -->
                                                        <!-- for example this input is loaded into each day's planning managment -->
                                                        <!-- where every input is responsible of adding data to the selected department's day's data -->
                                                        <!-- For now the data added is the whole employee object, instead i wanted to load only id to optimize data storage -->
                                                        <template v-for="(day, dayI) in days">
                                                            <div class="mx-8 p-12 border w-full">
                                                                <span class="underline font-bold">{{ day }}</span>
                                                                <div>
                                                                    <label class="typo__label">Employees</label>
                                                                    <VueMultiselect
                                                                    v-model="form.week_details[index].days[dayI].employees"
                                                                    :options="employees"
                                                                    :multiple="true"
                                                                    :close-on-select="false"
                                                                    :clear-on-select="false"
                                                                    :preserve-search="true"
                                                                    placeholder="Pick some"
                                                                    label="first_name"
                                                                    track-by="id"
                                                                    :value="Number">
                                                                        <template slot="selection" slot-scope="{ form.week_details, search, isOpen }">
                                                                            <span class="multiselect__single" v-if="values.length" v-show="!isOpen">
                                                                                {{ values.length }} employees selected
                                                                            </span>
                                                                        </template>
                                                                    </VueMultiselect>
                                                                    <pre class="language-json"><code>{{ form.week_details[index].days[dayI].employees  }} </code></pre>
                                                                </div>
                                                                <InputError class="mt-2" :message="form.errors.terminal_id" />
                                                            </div>
                                                        </template>
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
    components: {
        VueMultiselect  
    },
    data(){
        return{
            // modal data
            modals: [],
            form: {
                planning_type: 'admin',
                rows: 0,
                start_date: '',
                end_date: '',
                year: '',
                week_number: null,
                number_of_columns: 0,
                week_details: []
            },
            selectedEmployees: []
        }
    },
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>