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
    const { driver } = toRefs(props);
    const { vehicles } = toRefs(props);
    const { drivers } = toRefs(props);
    const props = defineProps(['driver', 'vehicles', 'drivers'])
    // Initialize the form with retrieved data
    const form = useForm({
        id: driver.value.id,
        first_name: driver.value.first_name,
        last_name: driver.value.last_name,
        vehicle_number: driver.value.vehicle_number,
    })
    // submitting form data
    const submit = () => {
        form.put(route('drivers.update', {id: form.id}), {
            onSuccess: () => {form.reset('first_name', 'last_name', 'vehicle_number')},
        });
    }
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Driver management"/>
        <div class="w-1/2 m-auto p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Mettre à jour le chauffeur: {{ driver.first_name }}  {{ driver.last_name }}</h3>
            <form @submit.prevent="submit">
                <div>
                            <InputLabel for="first_name" value="Prenom" />

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
                            <InputLabel for="last_name" value="Nom" />

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
                            <InputLabel for="vehicle_number" value="Nombre de Transport " />

                            <SelectInput
                                id="vehicle_number"
                                class="mt-1 block w-full"
                                v-model="form.vehicle_number"
                                required
                                autofocus
                            >
                                <template v-for="vehicle in vehicles">
                                    <option :value="vehicle.bus_number" :disabled="isRegistrationTaken(vehicle.bus_number)" :class="{ 'text-red-600': isRegistrationTaken(vehicle.bus_number) }">Transport: {{ vehicle.bus_number }}</option>
                                </template>
                            </SelectInput>
                            
                            <InputError class="mt-2" :message="form.errors.vehicle_number" />
                        </div>
                <div class="flex ">
                    <button type="submit" class="w-full text-white bg-gray-500 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm mt-4 px-5 py-2.5 text-center">Mettre à jour</button>
                    <Link :href="route('drivers.index')" class="w-full text-black bg-white border-2 hover:border-gray-500 border  focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm mt-5 px-5 py-2.5 text-center">Cancel</Link>
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
        isRegistrationTaken(vehicleNumber) {
      // Check if the vehiclenumber is already taken by a driver
      return this.drivers.some((driver) => driver.vehicle_number === vehicleNumber);
    },
    },
};

</script>
