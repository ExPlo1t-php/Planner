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
    const { terminal } = toRefs(props);
    const { vehicles } = toRefs(props);
    const props = defineProps(['terminal', 'vehicles'])
    // Initialize the form with terminal's data
    const form = useForm({
        id: terminal.value.id,
        name: terminal.value.name,
        address: terminal.value.address,
        trajet: terminal.value.trajet,
        vehicle_number: terminal.value.vehicle_number,
    })
    // submitting form data
    const submit = () => {
        form.put(route('terminals.update', {id: form.id}), {
            onSuccess: () => {form.reset('name', 'address', 'trajet', 'vehicle_number')},
        });
    }
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Terminal management"/>
        <div class="w-1/2 m-auto p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Mettre à jour la parada: {{ terminal.name }}</h3>
            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="name" value="Nom de Parada" />
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
                    <InputLabel for="address" value="Adresse" />

                        <TextInput
                            id="address"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.address"
                            required
                            autofocus
                            autocomplete="address"
                        />

                        <InputError class="mt-2" :message="form.errors.address" />
                </div>
                <div>
                    <InputLabel for="trajet" value="Trajet" />

                       <SelectInput
                            id="trajet"
                            class="mt-1 block w-full"
                            v-model="form.trajet"
                            required
                            autofocus
                        >
                            <option selected disabled hidden value="">Choisir un trajet</option>
                            <option value="Shift Administrative">Shift Administrative (8h-18h)</option>
                            <option value="Shift Matin (07h-15h)">Shift Matin (07h-15h)</option>
                            <option value="Shift Soir (15h-23h)">Shift Soir (15h-23h)</option>
                            <option value="Shift Nuit (23h-7h)">Shift Nuit (23h-7h)</option>
                        </SelectInput>

                    <InputError class="mt-2" :message="form.errors.trajet" />
                </div>
                <div>
                    <InputLabel for="vehicle_number" value="Numéro de véhicule " />

                    <SelectInput
                        id="vehicle_number"
                        class="mt-1 block w-full"
                        v-model="form.vehicle_number"
                        required
                        autofocus
                    >
                        <option selected disabled hidden value="">Choisir une vehicule</option>
                        <template v-for="vehicle in vehicles">
                            <option :value="vehicle.bus_number">Transport: {{ vehicle.bus_number }}</option>
                        </template>
                    </SelectInput>

                    <InputError class="mt-2" :message="form.errors.vehicle_number" />
                </div>
                <div class="flex ">
                    <button type="submit" class="w-full text-white bg-gray-500 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm mt-4 px-5 py-2.5 text-center">Mettre à jour</button>
                    <Link :href="route('terminals.index')" class="w-full text-black bg-white border-2 hover:border-gray-500 border  focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm mt-5 px-5 py-2.5 text-center">Cancel</Link>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<script>
export default {
    props: {
    },
    methods:{
    },
};

</script>
