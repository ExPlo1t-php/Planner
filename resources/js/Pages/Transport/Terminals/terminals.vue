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
    import { Head, useForm, router } from '@inertiajs/vue3';
     
    const isShowModal = ref(false)
    function closeModal() {
        isShowModal.value = false
    }
    function showModal() {
        isShowModal.value = true
    }
    // form data manipulation 
    const form = useForm({
        name: '',
        address: '',
        vehicle_number: '',
        trajet: '',
    })
    const submit = () => {
        form.post(route('terminals.create'), {
            onSuccess: () => {form.reset('name', 'address', 'vehicle_number', 'trajet')},
        });
    }
    // search
    let search = ref('');
        watch(search, value=>{
    router.get(route('terminals.index'), { search: value }, { preserveState: true});
    })
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Paradas management"/>
        <div class="py-12 ">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 p-3 bg-white overflow-scroll">
                <!-- Modal toggle -->
                <div class="flex justify-between items-center mb-4">
                    <SearchBar v-model="search"/>
                    <button  @click="showModal" class="bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-colors duration-300">
                        Ajouter un nouvel Parada
                    </button>
                </div>  
                <!-- Main modal -->
                <Modal size="md" v-if="isShowModal" @close="closeModal">
                    <template #header>
                        <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Ajouter un nouvel Parada</h3>
                    </template>
                    <template #body>
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
                            <option value="Shift Administrative">Shift Administrative</option>
                            <option value="Shift 1">Shift 1</option>
                            <option value="Shift 2">Shift 2</option>
                            <option value="Shift 3">Shift 3</option>
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
                        
                        <button type="submit" class="w-full text-white bg-indigo-500 hover:bg-indigo-600 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm mt-4 px-5 py-2.5 text-center">Ajouter</button>
                    </form>
                    </template>
                </Modal>
                <!-- showing a list of drivers in a table ------------------------------------>
                <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                    <TableHead>
                        <TableHeadItem>Nom de Parada</TableHeadItem>
                        <TableHeadItem>Adresse</TableHeadItem>
                        <TableHeadItem>Trajet</TableHeadItem>
                        <TableHeadItem>Numéro de véhicule</TableHeadItem>
                    </TableHead>
                    <TableBody>
                        <template v-if="terminals && terminals.length > 0">
                        <TableRow v-for="terminal in terminals" :key="terminal.id">
                            <TableRowItem class="px-6 py-4">
                                <div class="text-gray-400">{{ terminal.name }}</div>
                            </TableRowItem>
                            <TableRowItem class="px-6 py-4">
                                <div class="text-gray-400">{{ terminal.address }}</div>
                            </TableRowItem>
                            <TableRowItem class="px-6 py-4">
                                <div class="text-gray-400">{{ terminal.trajet }}</div>
                            </TableRowItem>
                            <TableRowItem class="px-6 py-4">
                                <div class="text-gray-400">{{ terminal.vehicle_number }}</div>
                            </TableRowItem>
                            <TableRowItem>
                                <div class="flex justify-center gap-4">
                                    <EditLink :uid="terminal.id" :item="'terminals'"/>
                                    <DeleteLink :uid="terminal.id" :item="'terminals'"/>
                                </div>
                            </TableRowItem>
                        </TableRow>
                    </template>
                    <template v-else>
                    <TableRow>
                        <TableRowItem class="px-6 py-4" colspan="4">
                            Aucun Parada trouvé, cliquez sur ajouter un Parada pour en ajouter un Parada
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
        terminals: {
            type: Array,
        },
        vehicles: {
            type: Array,
        },
    },
    data(){
        return{
            form: {
                name: '',
                address: '',
                vehicle_number: '',
            }
        }
    },
    methods:{
    },
    components: { DeleteLink }
};
</script>