<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    // Form items
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import TextArea from '@/Components/Form/TextArea.vue';
    // Others
    import { ref, toRefs, watch } from 'vue'
    import { Head, useForm, Link, router } from '@inertiajs/vue3';
    const { project } = toRefs(props);
    const props = defineProps(['project'])
    // Initialize the form with retrieved data
    const form = useForm({
        id: project.value.id,
        name: project.value.name,
        details: project.value.details,
    })
    // submitting form data
    const submit = () => {
        form.put(route('projects.update', {id: form.id}), {
            onSuccess: () => {form.reset('name', 'details')},
        });
    }
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Project management"/>
        <div class="w-1/2 m-auto p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Mettre à jour le projet: {{ project.name }}</h3>
            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="name" value="Nom de Projet" />

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
                    <InputLabel for="details" value="Detail de Projet" />

                    <TextArea
                        id="details"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.details"
                        autofocus
                        autocomplete="details"
                    />
                    <InputError class="mt-2" :message="form.errors.details" />
                </div>
                <div class="flex ">
                    <button type="submit" class="w-full text-white bg-gray-500 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm mt-4 px-5 py-2.5 text-center">Mettre à jour</button>
                    <Link :href="route('projects.index')" class="w-full text-black bg-white border-2 hover:border-gray-500 border  focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm mt-5 px-5 py-2.5 text-center">Annuler</Link>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
