<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    // Form items
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import { ModelListSelect  } from 'vue-search-select'
    import "vue-search-select/dist/VueSearchSelect.css"
    import { FileInput } from 'flowbite-vue';
    // Others
    import { ref, toRefs, watch } from 'vue';
    import { Head, useForm, Link, router, usePage } from '@inertiajs/vue3';
    import { addObjectToArray, getDepartmentPositions, getPositions } from '@/utils';

    const { employee, leaders, departments, projects, positions, stations, teams, terminals, stationsFM, teamsFM } = toRefs(props);
    const props = defineProps(['employee', 'leaders', 'departments', 'projects', 'positions', 'stations', 'teams', 'terminals', 'stationsFM', 'teamsFM'])
    const page = usePage(); // Add this line to use the usePage function
    const role = page.props.auth.user.role; 

    // Initialize the form with retrieved data
    const form = useForm({
        id: employee.value.id,
        employee_number: employee.value.employee_number,
        first_name: employee.value.first_name,
        last_name: employee.value.last_name,
        department_id: employee.value.department_id,
        project_id: employee.value.project_id,
        position_id: employee.value.position_id,
        station_id: employee.value.station_id,
        team_leader_manager_id: employee.value.team_leader_manager_id,
        team_id: employee.value.team_id,
        terminal_id: employee.value.terminal_id,
        photo: employee.value.photo,
        user_role: employee.value.user_role,
    })
    // submitting form data
    const submit = () => {
        form.post(route('employees.update', {id: form.id}), {
            onSuccess: () => {form.reset("photo", "first_name", "last_name", "employee_number", "terminal_id")},
        });
    }
    // form filtering
    const reset = () => {
        form.project_id=null;
        form.position_id=null;
        form.station_id=null;
        form.team_id=null;
    };
 // filtering modal select inputs:
    let projectId = ref(null);
    let positionId = ref(null);
    // project filter
    watch(() => form.project_id,
    (value)=>{
        projectId = value;
        // console.log(projectId)
        if(projectId){
            router.visit(route('employees.edit', {id: form.id ,projectM: projectId||null}), { preserveState: true });
        }
    });
    // department filter
    watch(() => form.position_id,
    (value) =>{
        positionId = value;
        // console.log(positionId)
        if(positionId){
            router.visit(route('employees.edit', {id: form.id ,positionM: positionId||null}), { preserveState: true });
        }
    })
    watch(() => form.department_id,
    (value) =>{
        reset()
    }
    )

</script>

<template>
    <AuthenticatedLayout>
        <Head title="Employee management"/>
        <div class="w-1/2 m-auto p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Mettre à jour l'employe: {{ employee.first_name }} {{ employee.last_name }}</h3>
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
                    
                    <ModelListSelect
                        id="department_id"
                        :list="departments"
                        optionValue="id"
                        optionText="name"
                        v-model="form.department_id"
                        class="border-gray-300 focus:border-gray-500 focus:ring-gray-500 rounded-md shadow-sm"
                        placeholder="Choisir une Departement">
                    </ModelListSelect>
                    
                    <InputError class="mt-2" :message="form.errors.department_id" />
                </div>
                <div>
                    <InputLabel for="position_id" value="Position" />

                    <ModelListSelect
                        id="position_id"
                        :list="form.department_id ? getPositions(positions, getDepartmentPositions(departments, form.department_id)) : [{id: null,name: 'Aucun Position (veuillez choisir une departement)'}]"
                        optionValue="id"
                        optionText="name"
                        v-model="form.position_id"
                        class="border-gray-300 focus:border-gray-500 focus:ring-gray-500 rounded-md shadow-sm"
                        placeholder="Choisir une Position">
                    </ModelListSelect>

                    <InputError class="mt-2" :message="form.errors.position_id" />
                </div>
                <div v-if="form.position_id == 1">
                    <InputLabel for="project_id" value="Projet " />

                    <ModelListSelect
                        id="project_id"
                        :list="projects"
                        optionValue="id"
                        optionText="name"
                        v-model="form.project_id"
                        class="border-gray-300 focus:border-gray-500 focus:ring-gray-500 rounded-md shadow-sm"
                        placeholder="Choisir une Projet">
                    </ModelListSelect>

                    <InputError class="mt-2" :message="form.errors.project_id" />
                </div>
                <div v-if="form.department_id == 2 || form.department_id == 1 && form.position_id == 1">
                    <InputLabel for="station_id" value="Workstation " />
                    
                    <ModelListSelect
                        id="station_id"
                        :list="stationsFM"
                        optionValue="id"
                        optionText="name"
                        v-model="form.station_id"
                        class="border-gray-300 focus:border-gray-500 focus:ring-gray-500 rounded-md shadow-sm"
                        placeholder="Choisir une Station">
                    </ModelListSelect>
                
                <InputError class="mt-2" :message="form.errors.station_id" />
                </div>
                <div>
                    <InputLabel for="team_leader_manager_id" value="Team Leader/Manager" />


                    <ModelListSelect
                        id="team_leader_manager_id"
                        :list="leaders"
                        optionValue="id"
                        optionText="first_name"
                        v-model="form.team_leader_manager_id"
                        class="border-gray-300 focus:border-gray-500 focus:ring-gray-500 rounded-md shadow-sm"
                        placeholder="Choisir une Team Leader/Shift Leader/Manager">
                    </ModelListSelect>

                    <InputError class="mt-2" :message="form.errors.team_leader_manager_id" />
                </div>
                <div v-if="form.department_id == 2 || form.department_id == 1">
                    <InputLabel for="team_id" value="Team" />
                    
                    <ModelListSelect
                        id="team_id"
                        :list="teamsFM"
                        optionValue="id"
                        optionText="name"
                        v-model="form.team_id"
                        class="border-gray-300 focus:border-gray-500 focus:ring-gray-500 rounded-md shadow-sm"
                        placeholder="Choisir un Team">
                    </ModelListSelect>
            
                    <InputError class="mt-2" :message="form.errors.team_id" />
                </div>
                <div>
                    <InputLabel for="terminal_id" value="Parada" />

                    <ModelListSelect
                        id="terminal_id"
                        :list="terminals"
                        optionValue="id"
                        optionText="name"
                        v-model="form.terminal_id"
                        class="border-gray-300 focus:border-gray-500 focus:ring-gray-500 rounded-md shadow-sm"
                        placeholder="Choisir une Parada">
                    </ModelListSelect>

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
                {{ employee.user_role }}
                <div v-if="role == 'administrator'">
                    <InputLabel for="user_role" value="Role" />
                    
                    <ModelListSelect
                        id="user_role"
                        :list="[{id:'adminstrator', name: 'Administrateur'}, {id:'assembly', name: 'Éditeur d\'assemblage'}, {id:'injection', name: 'Éditeur d\'injection'},{id:'HR', name: 'Ressources Humaines'}]"
                        optionValue="id"
                        optionText="name"
                        v-model="form.user_role"
                        class="border-gray-300 focus:border-gray-500 focus:ring-gray-500 rounded-md shadow-sm"
                        placeholder="Choisir une Role">
                    </ModelListSelect>

                    <InputError class="mt-2" :message="form.errors.user_role" />
                </div>
                <div class="flex ">
                    <button type="submit" class="w-full text-white bg-gray-800 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm mt-4 px-5 py-2.5 text-center">Mettre à jour</button>
                    <Link :href="route('employees.index')" class="w-full text-black bg-white border-2 hover:border-gray-800 border  focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm mt-5 px-5 py-2.5 text-center">Annuler</Link>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
