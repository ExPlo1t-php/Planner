<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    // Table items
    import TableHead from '@/Components/Table/TableHead.vue';
    import TableBody from '@/Components/Table/TableBody.vue';
    import TableHeadItem from '@/Components/Table/TableHeadItem.vue';
    import TableRowItem from '@/Components/Table/TableRowItem.vue';
    import TableRow from '@/Components/Table/TableRow.vue';
    import EditLink from '@/Components/Table/EditLink.vue';
    import DeleteLink from '@/Components/Table/DeleteLink.vue';
    // Form items
    import { Modal } from 'flowbite-vue'
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import SelectInput from '@/Components/Form/SelectInput.vue';
    import SearchBar from '@/Components/Form/SearchBar.vue';
    // Others
    import { ref, watch } from 'vue'
    import { Head, useForm, router, Link } from '@inertiajs/vue3';
    const isShowModal = ref(false)
    function closeModal() {
        isShowModal.value = false
    }
    function showModal() {
        isShowModal.value = true
    }
    // form data manipulation 
    const form = useForm({
        first_name: '',
        last_name: '',
        vehicle_number: '',
    })
    const submit = () => {
        form.post(route('drivers.create'), {
            onSuccess: () => {form.reset('first_name', 'last_name', 'vehicle_number')},
        });
    }
    // search
    let search = ref('');
        watch(search, value=>{
    router.get(route('drivers.index'), { search: value }, { preserveState: true});
    })
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Driver management"/>
        <div class="py-12 ">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 p-3 bg-white overflow-scroll">
                <!-- Modal toggle -->
                <div class="flex justify-between items-center mb-4">
                    <SearchBar v-model="search"/>
                    <button  @click="showModal" class="bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-colors duration-300">
                        Ajouter un nouvel chauffeur
                    </button>
                </div>  
                <!-- Main modal -->
                <Modal size="md" v-if="isShowModal" @close="closeModal">
                    <template #header>
                        <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Ajouter un nouvel chauffeur</h3>
                    </template>
                    <template #body>
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
                        
                        <button type="submit" class="w-full text-white bg-indigo-500 hover:bg-indigo-600 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm mt-4 px-5 py-2.5 text-center">Ajouter</button>
                        <Link :href="route('vehicles.index')" class="hover:text-indigo-500 text-sm m-4 ">Ajouter une nouvelle vehicule</Link>
                    </form>
                    </template>
                </Modal>
                <!-- showing a list of drivers in a table ------------------------------------>
                <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                    <TableHead>
                        <TableHeadItem>Prenom</TableHeadItem>
                        <TableHeadItem>Nom</TableHeadItem>
                        <TableHeadItem>Nombre de transport</TableHeadItem>
                    </TableHead>
                    <TableBody>
                        <template v-if="drivers && drivers.length > 0">
                        <TableRow v-for="driver in drivers" :key="driver.id">
                            <TableRowItem class="px-6 py-4">
                                <div class="text-gray-400">{{ driver.first_name }}</div>
                            </TableRowItem>
                            <TableRowItem class="px-6 py-4">
                                <div class="text-gray-400">{{ driver.last_name }}</div>
                            </TableRowItem>
                            <TableRowItem class="px-6 py-4">
                                <div class="text-gray-400">{{ driver.vehicle_number }}</div>
                            </TableRowItem>
                            <TableRowItem>
                                <div class="flex justify-center gap-4">
                                    <EditLink :uid="driver.id" :item="'drivers'"/>
                                    <DeleteLink :uid="driver.id" :item="'drivers'"/>
                                </div>
                            </TableRowItem>
                        </TableRow>
                    </template>
                    <template v-else>
                    <TableRow>
                        <TableRowItem class="px-6 py-4" colspan="4">
                            Aucun chauffeurs trouvé, cliquez sur ajouter un chauffeur pour en ajouter un chauffeur
                        </TableRowItem>
                    </TableRow>
                    </template>
                    </TableBody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
export default {
    props: {
        drivers: {
            type: Array,
        },
        vehicles: {
            type: Array,
        },
    },
    data(){
        return{
            form: {
                first_name: '',
                last_name: '',
                vehicle_number: '',
            }
        }
    },
    methods:{
        isRegistrationTaken(registrationNumber) {
      // Check if the registrationNumber is already taken by a driver
      return this.drivers.some((driver) => driver.vehicle_number === registrationNumber);
    },
    navigateToLink() {
      const url = route('vehicles.index'); 
      router.push(url);
    },
    },
    components: { DeleteLink, Link }
};
</script>
