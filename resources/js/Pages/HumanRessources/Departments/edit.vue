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
    const { department, positions } = toRefs(props);
    const props = defineProps(['department', 'positions'])
    // Initialize the form with retrieved data
    const form = useForm({
        id: department.value.id,
        name: department.value.name,
        info: department.value.info,
        positions: JSON.parse(department.value.positions),
    })
    // submitting form data
    const submit = () => {
        form.put(route('departments.update', {id: form.id}), {
            onSuccess: () => {form.reset('name', 'info')},
        });
    }

    const isChecked = (positionName) => {
        console.log(positionName)
        if(positionName){
            const isChecked = form.positions.includes(positionName);
            console.log(positionName, form.positions, isChecked);
            return isChecked;
        }
    }
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Department management"/>
        <div class="w-1/2 m-auto p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Mettre à jour le projet: {{ department.name }}</h3>
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
                    <InputLabel value="Positions" />
                    <div class="grid grid-cols-5">
                        <template v-for="position in positions" >
                            <div>
                                <input
                                    type="checkbox"
                                    :id="'position-' + position.name"
                                    v-model="form.positions"
                                    class="rounded border-gray-300 text-gray-600 shadow-sm focus:ring-gray-500 m-2"
                                    :value="position.name"
                                    :checked="isChecked(position.name)"
                                    >
                                {{ position.name }}
                            </div>
                        </template>
                    </div>
                </div>
                <div>
                    <InputLabel for="info" value="Detail de Projet" />

                    <TextArea
                        id="info"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.info"
                        autofocus
                        autocomplete="info"
                    />
                    <InputError class="mt-2" :message="form.errors.info" />
                </div>
                <div class="flex ">
                    <button type="submit" class="w-full text-white bg-gray-500 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm mt-4 px-5 py-2.5 text-center">Mettre à jour</button>
                    <Link :href="route('departments.index')" class="w-full text-black bg-white border-2 hover:border-gray-500 border  focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm mt-5 px-5 py-2.5 text-center">Annuler</Link>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>