<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    // Form items
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import SelectInput from '@/Components/Form/SelectInput.vue';
    import { FileInput } from 'flowbite-vue';
    // Others
    import { ref, toRefs, watch } from 'vue';
    import { Head, useForm, Link } from '@inertiajs/vue3';
    const { employee, leaders, departments, projects, positions, stations, teams, terminals } = toRefs(props);
    const props = defineProps(['employee', 'leaders', 'departments', 'projects', 'positions', 'stations', 'teams', 'terminals'])
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
    })
    // submitting form data
    const submit = () => {
        form.post(route('employees.update', {id: form.id}), {
            onSuccess: () => {form.reset("photo", "first_name", "last_name", "employee_number", "terminal_id")},
        });
    }
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
                <div class="flex ">
                    <button type="submit" class="w-full text-white bg-indigo-500 hover:bg-indigo-600 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm mt-4 px-5 py-2.5 text-center">Mettre à jour</button>
                    <Link :href="route('employees.index')" class="w-full text-black bg-white border-2 hover:border-indigo-500 border  focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm mt-5 px-5 py-2.5 text-center">Annuler</Link>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>