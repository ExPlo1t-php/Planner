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
    import Pagination from '@/Components/Table/Pagination.vue';
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
            onSuccess: () => {form.reset('bus_number' ,'registration_number', 'entree_date')},
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
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 p-3 bg-white overflow-auto">
                <!-- Modal toggle -->
                <div class="flex justify-between justify-end items-center mb-4">
                    <SearchBar v-model="search"/>
                    <button  @click="showModal" class="bg-gray-800 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-colors duration-300">
                        Ajouter une nouvelle Vehicule
                    </button>
                </div>  
                <!-- Main modal -->
                <Modal size="2xl" v-if="isShowModal" @close="closeModal">
                    <template #header>
                        <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Ajouter un nouvel utilisateur</h3>
                    </template>
                    <template #body>
                        <form @submit.prevent="submit" class="px-16">
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

                        
                        <button type="submit" class="w-full text-white bg-gray-800 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm mt-4 px-5 py-2.5 text-center">Ajouter</button>
                    </form>
                    </template>
                </Modal>
                <!-- showing a list of vehicles in a table ------------------------------------>
                <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                    <TableHead>
                        <TableHeadItem @click="sortTable(vehicles.data, 'bus_number')">Numero de transport</TableHeadItem>
                        <TableHeadItem @click="sortTable(vehicles.data, 'registration_number')">Matricule</TableHeadItem>
                        <TableHeadItem @click="sortTable(vehicles.data, 'entree_date')">Date d'entree</TableHeadItem>
                    </TableHead>
                    <TableBody>
                        <template v-if="vehicles.data && vehicles.data.length > 0">
                            <TableRow v-for="vehicle in sortedItems" :key="vehicle.id">
                                <TableRowItem>
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
                <!-- pagination -->
                <Pagination :links="vehicles.links"/>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
export default {
    props: {
        vehicles: {
            type: Object,
        },
    },
    data(){
        return{
            sortKey: '',
            sortDirection: 'asc',
        }
    },
    methods:{
        // table sort
        sortTable(collection, key) {
            if (this.sortKey === key) {
                this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                this.sortKey = key;
                this.sortDirection = 'asc';
            }
            this.sortedItems = this.getSortedItems(collection);
        },
        getSortedItems(collection) {
            const sortedItems = collection.slice().sort((a, b) => {
            const aValue = this.getSortValue(a, this.sortKey);
            const bValue = this.getSortValue(b, this.sortKey);

            if (aValue < bValue) return this.sortDirection === 'asc' ? -1 : 1;
            if (aValue > bValue) return this.sortDirection === 'asc' ? 1 : -1;
            return 0;
            });
            return sortedItems;
        },
        getSortValue(obj, key) {
            return obj[key];
        },
        },
    computed: {
        sortedItems() {
            return this.getSortedItems(this.vehicles.data);
        },
    },
    components: { DeleteLink, EditLink, Pagination }
};
</script>
