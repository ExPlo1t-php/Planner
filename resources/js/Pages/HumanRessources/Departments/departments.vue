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
    import TextArea from '@/Components/Form/TextArea.vue';
    import SearchBar from '@/Components/Form/SearchBar.vue';
    // functions
    import { getNameById, parseAndJoinPositions } from '@/utils'
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
        info: '',
        positions: [],
    })
    const submit = () => {
        form.post(route('departments.create'), {
            onSuccess: () => {form.reset('name', 'info', 'positions')},
        });
    }
    // search
    const { props } = usePage();
    let search = ref(props.filters.search||null);
        watch(search, value=>{
    router.get(route('departments.index'), { search: value }, { preserveState: true});
    })
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Departments management"/>
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
                        Ajouter un nouvel Department
                    </button>
                </div>  
                <!-- Main modal -->
                <Modal size="md" v-if="isShowModal" @close="closeModal">
                    <template #header>
                        <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Ajouter un nouvel Department</h3>
                    </template>
                    <template #body>
                        <form @submit.prevent="submit">
                        <div>
                            <InputLabel for="name" value="Nom de Department" />

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
                            <InputLabel value="positions" />
                            <div class="grid grid-cols-5">
                                <template v-for="position in positions" >
                                    <div class="mx-3 flex">
                                        <input
                                         type="checkbox"
                                         :id="'position-' + position.name"
                                         v-model="form.positions"
                                         class="rounded border-gray-300 text-gray-600 shadow-sm focus:ring-gray-600 m-1"
                                         :value="position.id"
                                         >
                                        {{ position.name }}
                                    </div>
                                </template>
                            </div>
                        </div>
                        <div>
                            <InputLabel for="info" value="Info de Department" />

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
                        <button type="submit" class="w-full text-white bg-gray-800 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm mt-4 px-5 py-2.5 text-center">Ajouter</button>
                    </form>
                    </template>
                </Modal>
                <!-- showing a list of drivers in a table ------------------------------------>
                <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                    <TableHead>
                        <TableHeadItem @click="sortTable(departments.data, 'name')">Nom de Department</TableHeadItem>
                        <TableHeadItem @click="sortTable(departments.data, 'info')">Info de Department</TableHeadItem>
                        <TableHeadItem @click="sortTable(departments.data, 'positions')">Positions</TableHeadItem>
                    </TableHead>
                    <TableBody>
                        <template v-if="departments.data && departments.data.length > 0">
                        <TableRow v-for="department in sortedItems" :key="department.id">
                            <TableRowItem>
                                {{ department.name }}
                            </TableRowItem>
                            <TableRowItem>
                                {{ department.info }}
                            </TableRowItem>
                            <TableRowItem>
                                {{  this.parseAndJoinPositions(department.positions) }}
                            </TableRowItem>
                            <TableRowItem>
                                <div class="flex justify-center gap-4">
                                    <EditLink :uid="department.id" :item="'departments'"/>
                                    <DeleteLink :uid="department.id" :item="'departments'"/>
                                </div>
                            </TableRowItem>
                        </TableRow>
                    </template>
                    <template v-else>
                    <TableRow>
                        <TableRowItem class="px-6 py-4" colspan="4">
                            Aucun department trouvé, cliquez sur ajouter un department pour en ajouter un department
                        </TableRowItem>
                    </TableRow>
                    </template>
                    </TableBody>
                </table>
                <!-- pagination -->
                <Pagination :links="departments.links"/>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
export default {
    props: {
        departments: {
            type: Object,
        },
        positions: {
            type: Array,
        },
    },
    data(){
        return{
            form: {
                name: '',
                info: '',
                positions: [],
            },
            sortKey: '',
            sortDirection: 'asc',
        }
    },
    methods:{
        getNameById,
        parseAndJoinPositions,
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
            return this.getSortedItems(this.departments.data);
        },
    },
    components: { DeleteLink, Link, Pagination }
};
</script>
