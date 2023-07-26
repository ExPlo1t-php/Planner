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
    // Form items
    import { Modal, FileInput } from 'flowbite-vue';
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
    let search = ref('');
        watch(search, value=>{
    router.get(route('employees.index'), { search: value }, { preserveState: true});
    })
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Employees management"/>
        <div class="py-12 ">
            <div class="max-w-fit mx-auto sm:px-6 lg:px-8 p-3 bg-white overflow-scroll">
                <!-- Modal toggle -->
                <div class="flex justify-between items-center mb-4">
                    <SearchBar v-model="search"/>
                    <button  @click="showModal" class="bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-colors duration-300">
                        Ajouter un nouvel Employee
                    </button>
                </div>  
                <!-- Main modal -->
                <Modal size="md" v-if="isShowModal" @close="closeModal">
                    <template #header>
                        <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Ajouter un nouvel Employee</h3>
                    </template>
                    <template #body>
                        <form @submit.prevent="submit">
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
                                <template v-for="department in departments">
                                    <option :value="department.id">{{ department.name }}</option>
                                </template>
                            </SelectInput>

                            <InputError class="mt-2" :message="form.errors.department_id" />
                        </div>
                        <div>
                            <InputLabel for="project_id" value="Projet " />

                            <SelectInput
                                id="project_id"
                                class="mt-1 block w-full"
                                v-model="form.project_id"
                                required
                                autofocus
                            >
                            <option selected disabled hidden value="">Choisir un Projet</option>
                                <template v-for="project in projects">
                                    <option :value="project.id">{{ project.name }}</option>
                                </template>
                            </SelectInput>

                            <InputError class="mt-2" :message="form.errors.project_id" />
                        </div>
                        <div>
                            <InputLabel for="position_id" value="Poste " />

                            <SelectInput
                                id="position_id"
                                class="mt-1 block w-full"
                                v-model="form.position_id"
                                required
                                autofocus
                            >
                            <option selected disabled hidden value="">Choisir un Poste</option>
                                <template v-for="position in positions">
                                    <option :value="position.id">{{ position.name }}</option>
                                </template>
                            </SelectInput>

                            <InputError class="mt-2" :message="form.errors.position_id" />
                        </div>
                        <div>
                            <InputLabel for="station_id" value="Station " />

                            <SelectInput
                                id="station_id"
                                class="mt-1 block w-full"
                                v-model="form.station_id"
                                required
                                autofocus
                            >
                            <option selected disabled hidden value="">Choisir un Station</option>
                                <template v-for="station in stations">
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
                        <div>
                            <InputLabel for="team_id" value="Team" />

                            <SelectInput
                                id="team_id"
                                class="mt-1 block w-full"
                                v-model="form.team_id"
                                autofocus
                            >
                            <option selected disabled hidden value="">Choisir un Team</option>
                                <template v-for="team in teams">
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
                                <p class="!mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    SVG, PNG, JPG or GIF (MAX. 800x400px)
                                </p>
                            </FileInput>

                            <InputError class="mt-2" :message="form.errors.photo" />
                        </div>
                        <button type="submit" class="w-full text-white bg-indigo-500 hover:bg-indigo-600 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm mt-4 px-5 py-2.5 text-center">Ajouter</button>
                    </form>
                    </template>
                </Modal>
                <!-- showing a list of items in a table ------------------------------------>
                <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                    <TableHead>
                        <TableHeadItem>Photo de l'employé</TableHeadItem>
                        <TableHeadItem>Matricule de l'employé</TableHeadItem>
                        <TableHeadItem>Prénom de l'employé</TableHeadItem>
                        <TableHeadItem>Nom de l'employé</TableHeadItem>
                        <TableHeadItem>Departement</TableHeadItem>
                        <TableHeadItem>Projet</TableHeadItem>
                        <TableHeadItem>Poste</TableHeadItem>
                        <TableHeadItem>Station</TableHeadItem>
                        <TableHeadItem>Team Leader/Manager</TableHeadItem>
                        <TableHeadItem>Team</TableHeadItem>
                        <TableHeadItem>Terminal</TableHeadItem>
                    </TableHead>
                    <TableBody>
                        <template v-if="employees && employees.length > 0">
                        <TableRow v-for="employee in employees" :key="employee.id">
                            <TableRowItem class="px-6 py-4 w-5 h-5">
                                <img :src="employee.photo" alt="">
                            </TableRowItem>
                            <TableRowItem class="px-6 py-4">
                                <div class="text-gray-400">{{ employee.employee_number }}</div>
                            </TableRowItem>
                            <TableRowItem class="px-6 py-4">
                                <div class="text-gray-400">{{ employee.first_name }}</div>
                            </TableRowItem>
                            <TableRowItem class="px-6 py-4">
                                <div class="text-gray-400">{{ employee.last_name }}</div>
                            </TableRowItem>
                            <TableRowItem class="px-6 py-4">
                                <div class="text-gray-400">{{ getNameById(departments, employee.department_id) }}</div>
                            </TableRowItem>
                            <TableRowItem class="px-6 py-4">
                                <div class="text-gray-400">{{ getNameById(projects, employee.project_id ) }}</div>
                            </TableRowItem>
                            <TableRowItem class="px-6 py-4">
                                <div class="text-gray-400">{{ getNameById(positions, employee.position_id) }}</div>
                            </TableRowItem>
                            <TableRowItem class="px-6 py-4">
                                <div class="text-gray-400">{{ getNameById(stations, employee.station_id) }}</div>
                            </TableRowItem>
                            <TableRowItem class="px-6 py-4">
                                <template v-if="employee.team_leader_manager_id">
                                    <div class="text-gray-400">{{ getNameById(leaders, employee.team_leader_manager_id) }}</div>
                                </template>
                                <template v-else>
                                    <div class="text-red-400">Pas de Team Leader/Manager</div>
                                </template>
                            </TableRowItem>
                            <TableRowItem class="px-6 py-4">
                                <template v-if="employee.team_id">
                                    <div class="text-gray-400">{{ getNameById(teams, employee.team_id) }}</div>
                                </template>
                                <template v-else>
                                    <div class="text-red-400">Pas d'équipe</div>
                                </template>
                            </TableRowItem>
                            <TableRowItem class="px-6 py-4">
                                <div class="text-gray-400">{{ getNameById(terminals, employee.terminal_id) }}</div>
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
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
export default {
    props: {
        employees: {
            type: Array,
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
    },
    data(){
        return{
            form: {
                photo: '',
                employee_number: '',
                first_name: '',
                last_name: '',
                department_id: '',
                project_id: '',
                position_id: '',
                station_id: '',
                team_leader_manager_id: '',
                team_id: '',
                terminal_id: '',
            }
        }
    },
    methods: {
        getNameById(object, id) {
            const foundObject = object.find(obj => obj.id === id);
            if (foundObject.name){
                return foundObject ? foundObject.name : null;
            }else{
                return foundObject ? foundObject.first_name : null;
            }
        },
    },

    components: { DeleteLink, Link }
};
</script>
