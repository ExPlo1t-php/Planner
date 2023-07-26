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
    import SearchBar from '@/Components/Form/SearchBar.vue';
    import DateInput from '@/Components/Form/DateInput.vue';
    // Others
    import { ref, watch } from 'vue'
    import { Head, useForm, router } from '@inertiajs/vue3';
    // modal functionning
    const isShowModal = ref(false)
    function closeModal() {
        isShowModal.value = false
    }
    function showModal() {
        isShowModal.value = true
    }
    // form data manipulation 
    const form = useForm({
        bus_number: '',
        registration_number: '',
        entree_date: '',
    })
    const submit = () => {
        form.post(route('vehicles.create'), {
            onSuccess: () => {form.reset('registration_number' ,'registration_number', 'entree_date')},
        });
    }
    // search
    let search = ref('');
        watch(search, value=>{
    router.get(route('vehicles.index'), { search: value }, { preserveState: true});
    })
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Gestion Des Vehicules"/>
        <div class="py-12 ">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 p-3 bg-white overflow-scroll">
                <!-- Modal toggle -->
                <div class="flex justify-between justify-end items-center mb-4">
                    <SearchBar v-model="search"/>
                    <button  @click="showModal" class="bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-colors duration-300">
                        Ajouter une nouvelle Vehicule
                    </button>
                </div>  
                <!-- Main modal -->
                <Modal size="md" v-if="isShowModal" @close="closeModal">
                    <template #header>
                        <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Ajouter un nouvel utilisateur</h3>
                    </template>
                    <template #body>
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

                            <InputError class="mt-2" :message="form.errors.registration_number" />
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

                            <InputError class="mt-2" :message="form.errors.entree_date" />
                        </div>

                        
                        <button type="submit" class="w-full text-white bg-indigo-500 hover:bg-indigo-600 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm mt-4 px-5 py-2.5 text-center">Ajouter</button>
                    </form>
                    </template>
                </Modal>
                <!-- showing a list of vehicles in a table ------------------------------------>
                <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                    <TableHead>
                        <TableHeadItem>Numero de transport</TableHeadItem>
                        <TableHeadItem>Matricule</TableHeadItem>
                        <TableHeadItem>Date d'entree</TableHeadItem>
                    </TableHead>
                    <TableBody>
                        <template v-if="vehicles && vehicles.length > 0">
                            <TableRow v-for="vehicle in vehicles" :key="vehicle.id">
                                <TableRowItem class="px-6 py-4">
                                    <div class="text-black">{{ vehicle.bus_number }}</div>
                                </TableRowItem>
                                <TableRowItem>
                                    {{ vehicle.registration_number }}
                                </TableRowItem>
                                <TableRowItem>
                                    {{ vehicle.entree_date }}
                                </TableRowItem>
                                <TableRowItem>
                                    <div class="flex justify-center gap-4">
                                        <EditLink :uid="vehicle.id" :item="'vehicles'"/>
                                        <DeleteLink :uid="vehicle.id" :item="'vehicles'"/>
                                    </div>
                                </TableRowItem>
                            </TableRow>
                        </template>
                        <template v-else>
                            <TableRow>
                                <TableRowItem class="px-6 py-4" colspan="4">
                                    Aucun vehicule trouvé, cliquez sur ajouter une vehicule pour en ajouter une
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
        vehicles: {
            type: Array,
        },
    },
    components: { DeleteLink, EditLink, SearchBar }
};
</script>
