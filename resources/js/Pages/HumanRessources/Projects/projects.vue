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
    import TextArea from '@/Components/Form/TextArea.vue';
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
        name: '',
        details: '',
    })
    const submit = () => {
        form.post(route('projects.create'), {
            onSuccess: () => {form.reset('name', 'details')},
        });
    }
    // search
    let search = ref('');
        watch(search, value=>{
    router.get(route('projects.index'), { search: value }, { preserveState: true});
    })
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Projects management"/>
        <div class="py-12 ">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 p-3 bg-white overflow-scroll">
                <!-- Modal toggle -->
                <div class="flex justify-between items-center mb-4">
                    <SearchBar v-model="search"/>
                    <button  @click="showModal" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-colors duration-300">
                        Ajouter un nouvel Projet
                    </button>
                </div>  
                <!-- Main modal -->
                <Modal size="md" v-if="isShowModal" @close="closeModal">
                    <template #header>
                        <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Ajouter un nouvel Projet</h3>
                    </template>
                    <template #body>
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
                            <InputLabel for="details" value="Detail de Projet" />

                            <TextArea
                                id="details"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.details"
                                autofocus
                                autocomplete="details"
                            />
                            <InputError class="mt-2" :message="form.errors.details" />
                        </div>
                        <button type="submit" class="w-full text-white bg-gray-500 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm mt-4 px-5 py-2.5 text-center">Ajouter</button>
                    </form>
                    </template>
                </Modal>
                <!-- showing a list of drivers in a table ------------------------------------>
                <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                    <TableHead>
                        <TableHeadItem @click="sortTable(projects, 'name')">Nom de Projet</TableHeadItem>
                        <TableHeadItem>Detail de Projet</TableHeadItem>
                    </TableHead>
                    <TableBody>
                        <template v-if="projects && projects.length > 0">
                        <TableRow v-for="project in sortedItems" :key="project.id">
                            <TableRowItem class="px-6 py-4">
                                <div class="text-gray-400">{{ project.name }}</div>
                            </TableRowItem>
                            <TableRowItem class="px-6 py-4">
                                <div class="text-gray-400">{{ project.details }}</div>
                            </TableRowItem>
                            <TableRowItem>
                                <div class="flex justify-center gap-4">
                                    <EditLink :uid="project.id" :item="'projects'"/>
                                    <DeleteLink :uid="project.id" :item="'projects'"/>
                                </div>
                            </TableRowItem>
                        </TableRow>
                    </template>
                    <template v-else>
                    <TableRow>
                        <TableRowItem class="px-6 py-4" colspan="4">
                            Aucun projet trouvé, cliquez sur ajouter un projet pour en ajouter un projet
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
        projects: {
            type: Array,
        },
    },
    data(){
        return{
            form: {
                name: '',
                details: '',
            },
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
            return this.getSortedItems(this.projects);
        },
    },
    components: { DeleteLink, Link }
};
</script>
