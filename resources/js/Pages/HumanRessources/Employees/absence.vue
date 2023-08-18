<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    // Form items
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import TextArea from '@/Components/Form/TextArea.vue';
    import DateInput from '@/Components/Form/DateInput.vue';
    // Others
    import { ref, toRefs, watch } from 'vue';
    import { Head, useForm, Link, router } from '@inertiajs/vue3';
    const { employee, leaders, departments, projects, positions, stations, teams, terminals, stationsFM, teamsFM } = toRefs(props);
    const props = defineProps(['employee', 'leaders', 'departments', 'projects', 'positions', 'stations', 'teams', 'terminals', 'stationsFM', 'teamsFM'])
    // Initialize the form with retrieved data
    const form = useForm({
        id: employee.value.id,
        employee_id: employee.value.employee_number,
        reason: '',
        start_date: new Date().toISOString().split('T')[0],
        end_date: '',
    })
    // submitting form data
    const submit = () => {
        form.post(route('employees.post_absence', {id: form.id}), {
            onSuccess: () => {form.reset( "reason", 'end_date')},
        });
    }
</script>
<template>
    <AuthenticatedLayout>
        <Head title="Employee management"/>
        <div class="w-1/2 m-auto p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Nouveau absence pour l'employe: {{ employee.first_name }} {{ employee.last_name }}</h3>
            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="employee_id" value="Matricule de l'employé" />

                    <TextInput
                        id="employee_id"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.employee_id"
                        required
                        autofocus
                        disabled
                        autocomplete="employee_id"
                    />

                    <InputError class="mt-2" :message="form.errors.employee_id" />
                </div>
                <div>
                    <InputLabel for="reason" value="Motif" />

                    <TextArea
                        id="reason"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.reason"
                        required
                        autofocus
                        autocomplete="reason"
                    />

                    <InputError class="mt-2" :message="form.errors.last_name" />
                </div>
                <div>
                    <InputLabel for="start_date" value="Date de debut" />

                    <DateInput
                        id="start_date"
                        class="mt-1 block w-full"
                        v-model="form.start_date"
                        required
                        autofocus
                        autocomplete="start_date"
                    />

                    <InputError class="mt-2" :message="form.errors.start_date" />
                </div>
                <div>
                    <InputLabel for="end_date" value="Date de fin" />

                    <DateInput
                        id="end_date"
                        class="mt-1 block w-full"
                        v-model="form.end_date"
                        required
                        autofocus
                        autocomplete="end_date"
                    />

                    <InputError class="mt-2" :message="form.errors.end_date" />
                </div>

                <div class="flex ">
                    <button type="submit" class="w-full text-white bg-gray-800 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm mt-4 px-5 py-2.5 text-center">Nouveau absence</button>
                    <Link :href="route('employees.index')" class="w-full text-black bg-white border-2 hover:border-gray-800 border  focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm mt-5 px-5 py-2.5 text-center">Annuler</Link>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>