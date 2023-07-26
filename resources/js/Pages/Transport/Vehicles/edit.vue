<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    // Form items
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import DateInput from '@/Components/Form/DateInput.vue';
    // Others
    import { ref, toRefs } from 'vue'
    import { Head, useForm, Link } from '@inertiajs/vue3';
    const { vehicle } = toRefs(props);
    const props = defineProps(['vehicle'])
    // Initialize the form with vehicle data
    const form = useForm({
        id: vehicle.value.id,
        bus_number: vehicle.value.bus_number,
        registration_number: vehicle.value.registration_number,
        entree_date: vehicle.value.entree_date,
    })
    // submitting form data
    const submit = () => {
        form.put(route('vehicles.update', {id: form.id}), {
            onSuccess: () => {form.reset('registration_number', 'entree_date')},
        });
    }
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Vehicle management"/>
        <div class="w-1/2 m-auto p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Mettre à jour la Vehicule: {{ vehicle.registration_number }}</h3>
            <form @submit.prevent="submit">
                <div>
                            <InputLabel for="bus_number" value="Numero de Transport" />

                            <TextInput
                                id="bus_number"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.bus_number"
                                required
                                autofocus
                                autocomplete="bus_number"
                            />

                            <InputError class="mt-2" :message="form.errors.bus_number" />
                        </div>
                <div>
                    <InputLabel for="registration_number" value="Matricule" />
                    <TextInput
                        id="registration_number"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.registration_number"
                        required
                        autofocus
                        autocomplete="registration_number"
                    />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>
                <div>
                    <InputLabel for="entree_date" value="Date d'entree" />
                        <DateInput
                            id="entree_date"
                            class="mt-1 block w-full"
                            v-model="form.entree_date"
                            required
                            autofocus
                            autocomplete="entree_date"
                        />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>
                <div class="flex ">
                    <button type="submit" class="w-full text-white bg-indigo-500 hover:bg-indigo-600 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm mt-4 px-5 py-2.5 text-center">Mettre à jour</button>
                    <Link :href="route('vehicles.index')" class="w-full text-black bg-white border-2 hover:border-indigo-500 border  focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm mt-5 px-5 py-2.5 text-center">Cancel</Link>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<script>
export default {
    props: {
        vehicle: Object,
    },
    methods:{

    },
};

</script>
