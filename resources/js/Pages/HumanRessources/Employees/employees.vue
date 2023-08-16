<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    // Table items
    import TableHead from '@/Components/Table/TableHead.vue';
    import TableBody from '@/Components/Table/TableBody.vue';
    import TableHeadItem from '@/Components/Table/TableHeadItem.vue';
    import TableRowItem from '@/Components/Table/TableRowItem.vue';
    import TableRow from '@/Components/Table/TableRow.vue';
    import EditLink from '@/Components/Table/EditLink.vue';
    import DeleteLink from '@/Components/Table/DeleteLink.vue';
    import Pagination from '@/Components/Table/Pagination.vue';
    // Form items
    import { Modal, FileInput, Radio } from 'flowbite-vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    // import FileInput from '@/Components/Form/FileInput.vue';
    import TextArea from '@/Components/Form/TextArea.vue';
    import SelectInput from '@/Components/Form/SelectInput.vue';
    import SearchBar from '@/Components/Form/SearchBar.vue';
    // Others
    import { ref, watch } from 'vue'
    import { Head, useForm, router, Link } from '@inertiajs/vue3';
    const isShowModal = ref(false)
    function closeModal() {
        isShowModal.value = false
    }
    function showModal() {
        isShowModal.value = true
    }
    // form data manipulation 
    const form = useForm({
        photo: null,
        first_name: '',
        last_name: '',
        employee_number: '',
        department_id: '',
        project_id: '',
        position_id: '',
        station_id: '',
        team_leader_manager_id: null,
        team_id: '',
        terminal_id: '',
    })
    const submit = () => {
        form.post(route('employees.create'), {
            onSuccess: () => {form.reset("photo", "first_name", "last_name", "employee_number", "terminal_id")},
        });
    }
    // search
    let search = ref(null);
    watch(search, value => {
        router.visit(route('employees.index', { search: value, department: department.value||null, project: project.value||null }), { preserveState: true });
    });

    // filters
    const option = ref('');
    let department = ref(null);
    let project = ref(null);
    let team = ref(null);
    let position = ref(null);
    watch(department, value => {
        router.visit(route('employees.index', { search: search.value||null, department: department.value||null, project: project.value||null, team: team.value||null, position: position.value||null
    }), { preserveState: true });
    });
    watch(project, value => {
        router.visit(route('employees.index', { search: search.value||null, department: department.value||null, project: project.value||null, team: team.value||null, position: position.value||null
    }), { preserveState: true });
    });
    watch(team, value => {
        router.visit(route('employees.index', { search: search.value||null, department: department.value||null, project: project.value||null, team: team.value||null, position: position.value||null
    }), { preserveState: true });
    });
    watch(position, value => {
        router.visit(route('employees.index', { search: search.value||null, department: department.value||null, project: project.value||null, team: team.value||null, position: position.value||null
    , position: position.value||null}), { preserveState: true });
    });
    watch(() => form.project_id, (value)=>{
        const projectId = value;
        // console.log(projectId)
        if(projectId){
            router.visit(route('employees.index', {projectM: projectId }), { preserveState: true });
        }
    });
    //  filter reset
    const reset = () => {
        form.project_id=null;
        form.station_id=null;
        form.team_id=null;
    };
    watch(() => form.department_id,
    (value) =>{
        reset()
    }
    )
    const resetFilter = () => {
        search.value = null;
        department.value = null;
        project.value = null;
        team.value = null;
        position.value = null;
        router.visit(route('employees.index'), { preserveState: true });
    };
    
    
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Employees management"/>
        <div class="py-12 ">
            <div class="max-w-fit mx-auto sm:px-6 lg:px-8 p-3 bg-white overflow-auto">
                <!-- Modal toggle -->
                <div class="lg:flex sm:block md:block justify-between items-center mb-4">
                    <SearchBar v-model="search"/>
                    <div class="flex">
                        <select v-model="department" class="w-24 text-sm h-10 m-2">
                            <option selected :value="null">All Departments</option>
                            <option v-for="department in departments" :value="department.id" :key="department.id">{{ department.name }}</option>
                        </select>
                        <select v-model="project" class="w-24 text-sm h-10 m-2">
                            <option selected :value="null">All Projects</option>
                            <option v-for="project in projects" :value="project.id" :key="project.id">{{ project.name }}</option>
                        </select>
                        <select v-model="team" class="w-24 text-sm h-10 m-2">
                            <option selected :value="null">All Teams</option>
                            <option v-for="team in teamsF" :value="team.id" :key="team.id">{{ team.name }}</option>
                        </select>
                        <select v-model="position" class="w-24 text-sm h-10 m-2 m-2">
                            <option selected :value="null">All Positions</option>
                            <option v-for="position in positions" :value="position.id" :key="position.id">{{ position.name }}</option>
                        </select>
                        <button @click="resetFilter" class="bg-gray-800 hover:bg-gray-600 text-white font-semibold py-2 px-1 m-2 rounded-lg shadow-md transition-colors duration-300">
                            <span class="hidden sm:block md:block lg:block">
                            Reset Filter
                            </span>
                            <span class="sm:hidden md:hidden lg:hidden">
                                <svg fill="#fff" height="20px" width="20px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                                    viewBox="0 0 489.645 489.645" xml:space="preserve">
                                <g>
                                    <path d="M460.656,132.911c-58.7-122.1-212.2-166.5-331.8-104.1c-9.4,5.2-13.5,16.6-8.3,27c5.2,9.4,16.6,13.5,27,8.3
                                        c99.9-52,227.4-14.9,276.7,86.3c65.4,134.3-19,236.7-87.4,274.6c-93.1,51.7-211.2,17.4-267.6-70.7l69.3,14.5
                                        c10.4,2.1,21.8-4.2,23.9-15.6c2.1-10.4-4.2-21.8-15.6-23.9l-122.8-25c-20.6-2-25,16.6-23.9,22.9l15.6,123.8
                                        c1,10.4,9.4,17.7,19.8,17.7c12.8,0,20.8-12.5,19.8-23.9l-6-50.5c57.4,70.8,170.3,131.2,307.4,68.2
                                        C414.856,432.511,548.256,314.811,460.656,132.911z"/>
                                </g>
                                </svg>
                            </span>
                        </button>
                    </div>
                    <button  @click="showModal" class="bg-gray-800 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-colors duration-300">
                        <span class="hidden sm:block md:block lg:block">
                            Ajouter un nouvel Employee
                        </span>
                        <span class="sm:hidden md:hidden lg:hidden">
                            <svg width="20px" height="20px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <g id="add-user-left-7" transform="translate(-2 -2)">
                                    <path id="secondary" fill="#2ca9bc" d="M17.29,13.19a6,6,0,0,1-8.58,0A5,5,0,0,0,5,18v1s2,2,8,2,8-2,8-2V18a5,5,0,0,0-3.71-4.81Z"/>
                                    <path id="primary" d="M7,5H3M5,3V7" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                    <path id="primary-2" data-name="primary" d="M7.35,11A6,6,0,1,0,13,3a5.8,5.8,0,0,0-2,.35" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                    <path id="primary-3" data-name="primary" d="M17.29,13.19A5,5,0,0,1,21,18v1s-2,2-8,2-8-2-8-2V18a5,5,0,0,1,3.71-4.81" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                </g>
                            </svg>
                        </span>
                    </button>
                </div>  
                <!-- Main modal -->
                <Modal size="2xl" v-if="isShowModal" @close="closeModal">
                    <template #header>
                        <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Ajouter un nouvel Employee</h3>
                    </template>
                    <template #body>
                        <form @submit.prevent="submit" class="px-16">
                        <div>
                            <InputLabel for="employee_number" value="Matricule de l'employé" />

                            <TextInput
                                id="employee_number"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.employee_number"
                                required
                                autofocus
                                autocomplete="employee_number"
                            />

                            <InputError class="mt-2" :message="form.errors.employee_number" />
                        </div>
                        <div>
                            <InputLabel for="last_name" value="Nom de l'employé" />

                            <TextInput
                                id="last_name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.last_name"
                                required
                                autofocus
                                autocomplete="last_name"
                            />

                            <InputError class="mt-2" :message="form.errors.last_name" />
                        </div>
                        <div>
                            <InputLabel for="first_name" value="Prénom de l'employé" />

                            <TextInput
                                id="first_name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.first_name"
                                required
                                autofocus
                                autocomplete="first_name"
                            />

                            <InputError class="mt-2" :message="form.errors.first_name" />
                        </div> 
                        <div>
                            <InputLabel for="department_id" value="Departement " />
                            
                            <SelectInput
                                id="department_id"
                                class="mt-1 block w-full"
                                v-model="form.department_id"
                                required
                                autofocus
                                >
                            <option selected disabled hidden value="">Choisir une Departement</option>
                            <option value="">Aucun Departement</option>
                                <template v-for="department in departments">
                                    <option :value="department.id">{{ department.name }}</option>
                                </template>
                            </SelectInput>
                            
                            <InputError class="mt-2" :message="form.errors.department_id" />
                        </div>
                        <div v-if="form.department_id == 2">
                            <InputLabel for="project_id" value="Projet " />

                            <SelectInput
                                id="project_id"
                                class="mt-1 block w-full"
                                v-model="form.project_id"
                                autofocus
                            >
                            <option value="">Aucun Projet</option>
                            <option selected disabled hidden value="">Choisir un Projet</option>
                                <template v-for="project in projects">
                                    <option :value="project.id">{{ project.name }}</option>
                                </template>
                            </SelectInput>

                            <InputError class="mt-2" :message="form.errors.project_id" />
                        </div>
                        <div>
                            <InputLabel for="position_id" value="Position" />

                            <SelectInput
                                id="position_id"
                                class="mt-1 block w-full"
                                v-model="form.position_id"
                                required
                                autofocus
                            >
                            <option selected disabled hidden value="">Choisir un Position</option>
                            <template v-if="form.department_id">
                                <template v-for="position in getPositions(positions, getDepartmentPositions(departments, getNameById(departments, form.department_id)))">
                                    <option :value="position.id">{{ position.name }}</option>
                                </template>
                            </template>
                            <template v-else>
                                <option value="" disabled>Aucun Position (veuillez choisir une departement)</option>
                            </template>
                            
                            </SelectInput>

                            <InputError class="mt-2" :message="form.errors.position_id" />
                        </div>
                        <div v-if="form.department_id == 2 || form.department_id == 1">
                            <InputLabel for="station_id" value="Workstation " />
                            
                            <SelectInput
                            id="station_id"
                            class="mt-1 block w-full"
                            v-model="form.station_id"
                            autofocus
                            >
                            <option selected disabled hidden value="">Choisir un Workstation</option>
                            <template v-for="station in stationsFM">
                                <option :value="station.id">{{ station.name }}</option>
                            </template>
                        </SelectInput>
                        
                        <InputError class="mt-2" :message="form.errors.station_id" />
                        </div>
                        <div>
                            <InputLabel for="team_leader_manager_id" value="Team Leader/Manager" />

                            <SelectInput
                                id="team_leader_manager_id"
                                class="mt-1 block w-full"
                                v-model="form.team_leader_manager_id"
                                autofocus
                            >
                            <option selected disabled hidden value="">Choisir un Team Leader/Manager</option>
                            <option value="">Aucun Team Leader/Manager</option>
                            <template v-if="leaders && leaders.length > 0">
                                <template v-for="leader in leaders">
                                    <option :value="leader.id">{{ leader.first_name }}</option>
                                </template>
                            </template>
                            <template v-else>
                                <option value="" disabled>Aucun Team Leader/Manager disponible</option>
                            </template>
                            </SelectInput>

                            <InputError class="mt-2" :message="form.errors.team_leader_manager_id" />
                        </div>
                        <div v-if="form.department_id == 2 || form.department_id == 1">
                            <InputLabel for="team_id" value="Team" />
                            
                            <SelectInput
                            id="team_id"
                            class="mt-1 block w-full"
                            v-model="form.team_id"
                            autofocus
                            >
                                <option selected disabled hidden value="">Choisir un Team</option>
                                <option value="">Aucun Team</option>
                                <template v-for="team in teamsFM">
                                    <option :value="team.id">{{ team.name }}</option>
                                </template>
                            </SelectInput>
                    
                            <InputError class="mt-2" :message="form.errors.team_id" />
                        </div>
                        <div>
                            <InputLabel for="terminal_id" value="Parada" />

                            <SelectInput
                                id="terminal_id"
                                class="mt-1 block w-full"
                                v-model="form.terminal_id"
                                autofocus
                            >
                            <option selected disabled hidden value="">Choisir un Parada</option>
                            <option value="">Aucun Parada</option>
                                <template v-for="terminal in terminals">
                                    <option :value="terminal.id">{{ terminal.name }}</option>
                                </template>
                            </SelectInput>

                            <InputError class="mt-2" :message="form.errors.terminal_id" />
                        </div>
                        <div>
                            <InputLabel for="photo" value="Photo de l'employé" />

                            <FileInput
                                id="photo"
                                class="mt-1 block w-full"
                                v-model="form.photo"
                                autofocus
                            >
                            </FileInput>

                            <InputError class="mt-2" :message="form.errors.photo" />
                        </div>
                        <button type="submit" class="w-full text-white bg-gray-800 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm mt-4 px-5 py-2.5 text-center">Ajouter</button>
                    </form>
                    </template>
                </Modal>
                <!-- showing a list of items in a table ------------------------------------>
                <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                    <TableHead>
                        <TableHeadItem>Photo de l'employé</TableHeadItem>
                        <TableHeadItem @click="sortTable(employees.data, 'employee_number')">Matricule de l'employé</TableHeadItem>
                        <TableHeadItem @click="sortTable(employees.data, 'first_name')">Prénom de l'employé</TableHeadItem>
                        <TableHeadItem @click="sortTable(employees.data, 'last_name')">Nom de l'employé</TableHeadItem>
                        <TableHeadItem @click="sortTable(employees.data, 'department_id')">Departement</TableHeadItem>
                        <TableHeadItem @click="sortTable(employees.data, 'project_id')">Projet</TableHeadItem>
                        <TableHeadItem @click="sortTable(employees.data, 'position_id')">Position</TableHeadItem>
                        <TableHeadItem @click="sortTable(employees.data, 'station_id')">Workstation</TableHeadItem>
                        <TableHeadItem @click="sortTable(employees.data, 'team_leader_manager_id')">Team Leader/Manager</TableHeadItem>
                        <TableHeadItem @click="sortTable(employees.data, 'team')">Team</TableHeadItem>
                        <TableHeadItem @click="sortTable(employees.data, 'terminal_id')">Parada</TableHeadItem>
                    </TableHead>
                    <TableBody>
                        <template v-if="employees.data && employees.data.length > 0">
                        <TableRow v-for="employee in sortedItems" :key="employee.id">
                            <TableRowItem class="px-6 py-4 w-5 h-5">
                                <img :src="employee.photo" alt="">
                            </TableRowItem>
                            <TableRowItem>
                                <div class="text-gray-600">{{ employee.employee_number }}</div>
                            </TableRowItem>
                            <TableRowItem>
                                <div class="text-gray-600">{{ employee.first_name }}</div>
                            </TableRowItem>
                            <TableRowItem>
                                <div class="text-gray-600">{{ employee.last_name }}</div>
                            </TableRowItem>
                            <TableRowItem>
                                <div class="text-gray-600">{{ getNameById(departments, employee.department_id) }}</div>
                            </TableRowItem>
                            <TableRowItem>
                                <div class="text-gray-600">{{ getNameById(projects, employee.project_id ) }}</div>
                            </TableRowItem>
                            <TableRowItem>
                                <div class="text-gray-600">{{ getNameById(positions, employee.position_id) }}</div>
                            </TableRowItem>
                            <TableRowItem>
                                <template v-if="employee.station_id">
                                    {{ getNameById(stations, employee.station_id) }}
                                </template>
                                <template v-else>
                                    <div class="text-red-400">Pas de workstation</div>
                                </template>
                            </TableRowItem>
                            <TableRowItem>
                                <template v-if="employee.team_leader_manager_id">
                                    {{ getNameById(leaders, employee.team_leader_manager_id) }}
                                </template>
                                <template v-else>
                                    <div class="text-red-400">Pas de Team Leader/Manager</div>
                                </template>
                            </TableRowItem>
                            <TableRowItem>
                                <template v-if="employee.team_id">
                                    {{ getNameById(teams, employee.team_id) }}
                                </template>
                                <template v-else>
                                    <div class="text-red-400">Pas d'équipe</div>
                                </template>
                            </TableRowItem>
                            <TableRowItem>
                                <template v-if="employee.terminal_id">
                                    {{ getNameById(terminals, employee.terminal_id) }}
                                </template>
                                <template v-else>
                                    <div class="text-red-400">Pas de terminal</div>
                                </template>
                            </TableRowItem>
                            <TableRowItem>
                                <div class="flex justify-center gap-4">
                                    <EditLink :uid="employee.id" :item="'employees'"/>
                                    <DeleteLink :uid="employee.id" :item="'employees'"/>
                                </div>
                            </TableRowItem>
                        </TableRow>
                    </template>
                    <template v-else>
                    <TableRow>
                        <TableRowItem class="px-6 py-4" colspan="4">
                            Aucun Employee trouvé, cliquez sur ajouter un Employee pour en ajouter un Employee
                        </TableRowItem>
                    </TableRow>
                    </template>
                    </TableBody>
                </table>
                <!-- pagination -->
                <Pagination :links="employees.links"/>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
export default {
    props: {
        employees: {
            type: Object,
        },
        leaders: {
            type: Array,
        },
        departments: {
            type: Array,
        },
        projects: {
            type: Array,
        },
        positions: {
            type: Array,
        },
        stations: {
            type: Array,
        },
        teams: {
            type: Array,
        },
        terminals: {
            type: Array,
        },
        // filtered stations
        teamsF: {
            type: Array,
        },
        stationsFM: {
            type: Array,
        },
        teamsFM: {
            type: Array,
        },
    },
    data(){
        return{
            form: {
                photo: null,
                employee_number: '',
                first_name: '',
                last_name: '',
                department_id: '',
                project_id: '',
                position_id: '',
                station_id: '',
                team_leader_manager_id: null,
                team_id: '',
                terminal_id: '',
            },
            sortKey: '',
            sortDirection: 'asc',
        }
    },
    methods: {
        getNameById(object, id) {
            if(id!== null){
                const foundObject = object.find(obj => obj.id == id);
                // console.log(foundObject)
                if (foundObject.name){
                    return foundObject ? foundObject.name : null;
                }else{
                    return foundObject ? foundObject.first_name : null;
                }
            }
        },
        getDepartmentPositions(departments, name){
            // this  method fetches the  positions  available   in  the selected department 
            const department = departments.find(department => department.name === name);
            return JSON.parse(department.positions)
        },
        getPositions(positions, departmentPos){
            // this  method takes an array of department positions from "getDepartmentPositions"
            // then it fetches the positions based on the name key provided  in the getDepartmentPositions array
            const filteredData = positions.filter(object =>
            departmentPos.includes(object.name)
            );
            return filteredData
        },
        // table sort
        sortTable(collection, key) {
            if (this.sortKey === key) {
                this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                this.sortKey = key;
                this.sortDirection = 'asc';
            }
            this.sortedItems = this.getSortedItems(collection);
        },
        getSortedItems(collection) {
            const sortedItems = collection.slice().sort((a, b) => {
            const aValue = this.getSortValue(a, this.sortKey);
            const bValue = this.getSortValue(b, this.sortKey);

            if (aValue < bValue) return this.sortDirection === 'asc' ? -1 : 1;
            if (aValue > bValue) return this.sortDirection === 'asc' ? 1 : -1;
            return 0;
            });
            return sortedItems;
        },
        getSortValue(obj, key) {
            return obj[key];
        },
    },
    computed: {
        sortedItems() {
            return this.getSortedItems(this.employees.data);
        },
    },
    components: { DeleteLink, Link, Pagination },
};
</script>
