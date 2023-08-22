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
    import SelectInput from '@/Components/Form/SelectInput.vue';
    import SearchBar from '@/Components/Form/SearchBar.vue';
    // Others
    import { ref, watch } from 'vue'
    import { Head, useForm, router, Link, usePage } from '@inertiajs/vue3';
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
        shift: '',
        project_id: '',
    })
    const submit = () => {
        form.post(route('teams.create'), {
            onSuccess: () => {form.reset('name', 'shift', 'project_id')},
        });
    }
    // search
    const { props } = usePage();
    let search = ref(props.filters.search||null);
    watch(search, value=>{
    router.get(route('teams.index'), { search: value }, { preserveState: true});
    })
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Teams management"/>
        <div class="py-12 ">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 p-3 bg-white overflow-auto">
                <!-- Modal toggle -->
                <div class="flex justify-between items-center mb-4">
                    <input
                        class="border border-gray-300 rounded-lg px-2 lg:w-40"
                        type="search"
                        name="search"
                        placeholder="Recherche"
                        v-model="search"
                        >
                    <button  @click="showModal" class="bg-gray-800 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-colors duration-300">
                        Ajouter un nouvel Team
                    </button>
                </div>  
                <!-- Main modal -->
                <Modal size="md" v-if="isShowModal" @close="closeModal">
                    <template #header>
                        <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Ajouter un nouvel team</h3>
                    </template>
                    <template #body>
                        <form @submit.prevent="submit">
                        <div>
                            <InputLabel for="name" value="Nom de Team" />

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
                            <InputLabel for="shift" value="Shift" />

                            <SelectInput
                                id="shift"
                                class="mt-1 block w-full"
                                v-model="form.shift"
                                required
                                autofocus
                            >
                            <option selected disabled hidden value="">Choisir un shift</option>
                            <option value="Shift Administrative">Shift Administrative (8h-18h)</option>
                            <option value="Shift Matin (07h-15h)">Shift Matin (07h-15h)</option>
                            <option value="Shift Soir (15h-23h)">Shift Soir (15h-23h)</option>
                            <option value="Shift Nuit (23h-7h)">Shift Nuit (23h-7h)</option>
                            </SelectInput>

                            <InputError class="mt-2" :message="form.errors.trajet" />
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
                                    <option :value="project.id" 

                                            >Project: {{ project.name }}</option>
                                </template>
                            </SelectInput>
                            
                            <InputError class="mt-2" :message="form.errors.project_id" />
                        </div>
                        <button type="submit" class="w-full text-white bg-gray-800 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm mt-4 px-5 py-2.5 text-center">Ajouter</button>
                    </form>
                    </template>
                </Modal>
                <!-- showing a list of drivers in a table ------------------------------------>
                <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                    <TableHead>
                        <TableHeadItem @click="sortTable(teams.data, 'name')">Nom de Team</TableHeadItem>
                        <TableHeadItem @click="sortTable(teams.data, 'shift')">Shift de Team</TableHeadItem>
                        <TableHeadItem  @click="sortTable(teams.data, 'project_id')">Projet de Team</TableHeadItem>
                    </TableHead>
                    <TableBody>
                        <template v-if="teams.data && teams.data.length > 0">
                        <TableRow v-for="team in sortedItems" :key="team.id">
                           <TableRowItem>
                                {{ team.name }}
                            </TableRowItem>
                           <TableRowItem>
                                {{ team.shift }}
                            </TableRowItem>
                           <TableRowItem>
                                {{ getNameById(projects, team.project_id) }}
                            </TableRowItem>
                            <TableRowItem>
                                <div class="flex justify-center gap-4">
                                    <EditLink :uid="team.id" :item="'teams'"/>
                                    <DeleteLink :uid="team.id" :item="'teams'"/>
                                </div>
                            </TableRowItem>
                        </TableRow>
                    </template>
                    <template v-else>
                    <TableRow>
                        <TableRowItem class="px-6 py-4" colspan="4">
                            Aucun team trouvé, cliquez sur ajouter un team pour en ajouter un team
                        </TableRowItem>
                    </TableRow>
                    </template>
                    </TableBody>
                </table>
                <!-- pagination -->
                <Pagination :links="teams.links"/>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
export default {
    props: {
        teams: {
            type: Object,
        },
        projects: {
            type: Array,
        },
    },
    data(){
        return{
            form: {
                name: '',
                shift: '',
                project_id: '',
            },
            sortKey: '',
            sortDirection: 'asc',
        }
    },
    methods:{
        getNameById(object, id) {
            if(id!== null){
                const foundObject = object.find(obj => obj.id == id);
                // console.log(foundObject)
                if (foundObject.name){
                    return foundObject ? foundObject.name : null;
                }else{
                    return foundObject ? foundObject.first_name : null;
                }
            }
        },
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
            return this.getSortedItems(this.teams.data);
        },
    },
    components: { DeleteLink, Link, Pagination }
};
</script>
