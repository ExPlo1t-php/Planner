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
        name: '',
        email: '',
        role: '',
        password: '',
        password_confirmation: '',
    })
    const submit = () => {
        form.post(route('users.create'), {
            onSuccess: () => {form.reset('name', 'email', 'role', 'password', 'password_confirmation')},
        });
    }
    // search
    let search = ref('');
        watch(search, value=>{
    router.get(route('users.index'), { search: value }, { preserveState: true});
    })
</script>

<template>
    <AuthenticatedLayout>
        <Head title="User management"/>
        <div class="py-12 ">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 p-3 bg-white overflow-auto">
                <!-- Modal toggle -->
                <div class="flex justify-between justify-end items-center mb-4">
                    <SearchBar v-model="search"/>
                    <button  @click="showModal" class="bg-gray-800 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-colors duration-300">
                        Ajouter un nouvel utilisateur
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
                            <InputLabel for="name" value="Name" />

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
                            <InputLabel for="role" value="Role" />

                            <SelectInput
                                id="role"
                                class="mt-1 block w-full"
                                v-model="form.role"
                                required
                                autofocus
                            >
                            <option value="administrator">Administrateur</option>
                            <option value="assembly">Éditeur d'assemblage</option>
                            <option value="injection">Éditeur d'injection </option>
                            <option value="HR">Ressources Humaines </option>
                            </SelectInput>

                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="email" value="Email" />

                            <TextInput
                                id="email"
                                type="email"
                                class="mt-1 block w-full"
                                v-model="form.email"
                                required
                                autocomplete="username"
                            />

                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="password" value="Password" />

                            <TextInput
                                id="password"
                                type="password"
                                class="mt-1 block w-full"
                                v-model="form.password"
                                required
                                autocomplete="new-password"
                            />

                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="password_confirmation" value="Confirm Password" />

                            <TextInput
                                id="password_confirmation"
                                type="password"
                                class="mt-1 block w-full"
                                v-model="form.password_confirmation"
                                required
                                autocomplete="new-password"
                            />

                            <InputError class="mt-2" :message="form.errors.password_confirmation" />
                        </div>
                        
                        <button type="submit" class="w-full text-white bg-gray-800 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm mt-4 px-5 py-2.5 text-center">Ajouter</button>
                    </form>
                    </template>
                </Modal>
                <!-- showing a list of users in a table ------------------------------------>
                <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                    <TableHead>
                        <TableHeadItem>Id</TableHeadItem>
                        <TableHeadItem>Name/E-mail</TableHeadItem>
                        <TableHeadItem>Role</TableHeadItem>
                    </TableHead>
                    <TableBody>
                        <TableRow v-for="user in users" :key="user.id">
                            <TableRowItem class="px-6 py-4">
                                <div class="text-gray-400">{{ user.id }}</div>
                            </TableRowItem>
                            <TableRowItem>
                                <div class="text-sm">
                                    <div class="font-medium text-gray-700">{{ user.name }}</div>
                                    <div class="text-gray-400">{{ user.email }}</div>
                                </div>
                            </TableRowItem>
                            <TableRowItem>
                                {{ user.role }}
                            </TableRowItem>
                            <TableRowItem>
                                <div class="flex justify-center gap-4">
                                    <EditLink :uid="user.id" :item="'users'"/>
                                    <DeleteLink :uid="user.id" :item="'users'"/>
                                </div>
                            </TableRowItem>

                        </TableRow>
                    </TableBody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
export default {
    props: {
        users: {
            type: Array,
        },
    },
    data(){
        return{
            form: {
                name: '',
                email: '',
                role: '',
                password: '',
                password_confirmation: ''
            }
        }
    },
    methods:{

    },
    components: { DeleteLink, EditLink, SearchBar }
};
</script>
