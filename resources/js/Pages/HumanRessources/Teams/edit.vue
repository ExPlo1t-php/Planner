<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    // Form items
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import SelectInput from '@/Components/Form/SelectInput.vue';
    // Others
    import { ref, toRefs, watch } from 'vue'
    import { Head, useForm, Link, router } from '@inertiajs/vue3';
    const { team } = toRefs(props);
    const { projects } = toRefs(props);
    const props = defineProps(['team', 'projects'])
    // Initialize the form with retrieved data
    const form = useForm({
        id: team.value.id,
        name: team.value.name,
        shift: team.value.shift,
        project_id: team.value.project_id,
    })
    // submitting form data
    const submit = () => {
        form.put(route('teams.update', {id: form.id}), {
            onSuccess: () => {form.reset('name', 'shift', 'project_id')},
        });
    }
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Team management"/>
        <div class="w-1/2 m-auto p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Mettre à jour le Team: {{ team.name }}</h3>
            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="name" value="Nom de Team" />

                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                    />

                    <InputError class="mt-2" :message="form.errors.name" />
                </div>
                <div>
                    <InputLabel for="shift" value="Shift" />

                    <SelectInput
                        id="shift"
                        class="mt-1 block w-full"
                        v-model="form.shift"
                        required
                        autofocus
                    >
                    <option selected disabled hidden value="">Choisir un shift</option>
                    <option value="Shift Administrative">Shift Administrative (8h-18h)</option>
                    <option value="Shift Matin (07h-15h)">Shift Matin (07h-15h)</option>
                    <option value="Shift Soir (15h-23h)">Shift Soir (15h-23h)</option>
                    <option value="Shift Nuit (23h-7h)">Shift Nuit (23h-7h)</option>
                    </SelectInput>

                    <InputError class="mt-2" :message="form.errors.shift" />
                </div>
                <div>
                    <InputLabel for="project_id" value="Projet" />

                    <SelectInput
                        id="project_id"
                        class="mt-1 block w-full"
                        v-model="form.project_id"
                        autofocus
                    >
                        <template v-for="project in projects">
                            <option :value="project.id" 

                                    >Project: {{ project.name }}</option>
                        </template>
                    </SelectInput>
                    
                    <InputError class="mt-2" :message="form.errors.project_id" />
                </div>
                <div class="flex ">
                    <button type="submit" class="w-full text-white bg-gray-500 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm mt-4 px-5 py-2.5 text-center">Mettre à jour</button>
                    <Link :href="route('teams.index')" class="w-full text-black bg-white border-2 hover:border-gray-500 border  focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm mt-5 px-5 py-2.5 text-center">Annuler</Link>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
