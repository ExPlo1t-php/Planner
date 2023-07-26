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
    const { station } = toRefs(props);
    const { projects } = toRefs(props);
    const props = defineProps(['station', 'projects'])
    // Initialize the form with retrieved data
    const form = useForm({
        id: station.value.id,
        name: station.value.name,
        project_id: station.value.project_id,
    })
    // submitting form data
    const submit = () => {
        form.put(route('stations.update', {id: form.id}), {
            onSuccess: () => {form.reset('name', 'project_id')},
        });
    }
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Station management"/>
        <div class="w-1/2 m-auto p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Mettre à jour le station: {{ station.name }}</h3>
            <form @submit.prevent="submit">
                        <div>
                            <InputLabel for="name" value="Nom de Station" />

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
                            <InputLabel for="project_id" value="Projet" />

                            <SelectInput
                                id="project_id"
                                class="mt-1 block w-full"
                                v-model="form.project_id"
                                autofocus
                            >
                            <option  disabled hidden value="">Choisir un projet</option>
                                <template v-for="project in projects">
                                    <option :value="project.id">Project: {{ project.name }}</option>
                                </template>
                            </SelectInput>
                            
                            <InputError class="mt-2" :message="form.errors.project_id" />
                        </div>
                <div class="flex ">
                    <button type="submit" class="w-full text-white bg-indigo-500 hover:bg-indigo-600 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm mt-4 px-5 py-2.5 text-center">Mettre à jour</button>
                    <Link :href="route('stations.index')" class="w-full text-black bg-white border-2 hover:border-indigo-500 border  focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm mt-5 px-5 py-2.5 text-center">Annuler</Link>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
