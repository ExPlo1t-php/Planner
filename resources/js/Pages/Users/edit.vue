<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    // Form items
    import { Modal } from 'flowbite-vue'
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import SelectInput from '@/Components/Form/SelectInput.vue';
    // Others
    import { ref, toRefs } from 'vue'
    import { Head, useForm, Link } from '@inertiajs/vue3';
    const { user } = toRefs(props);
    const props = defineProps(['user'])
    // Initialize the form with user data
    const form = useForm({
        id: user.value.id,
        name: user.value.name,
        role: user.value.role,
        email: user.value.email,
        password: '',
        password_confirmation: '',
    });
    // submitting form data
    const submit = () => {
        form.put(route('users.update', {id: form.id}), {
            onSuccess: () => {form.reset('name', 'email', 'role', 'password', 'password_confirmation')},
        });
    }
</script>

<template>
    <AuthenticatedLayout>
        <Head title="User management"/>
        <div class="w-1/2 m-auto p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Mettre à jour l'utilisateur: {{ user.name }}</h3>
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
                                <option value="assembly_editor">Éditeur d'assemblage</option>
                                <option value="injection_editor">Éditeur d'injection </option>
                                <option value="administration_editor">Éditeur d'administration </option>
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
                                autocomplete="new-password"
                                />
                                
                            <InputError class="mt-2" :message="form.errors.password_confirmation" />
                        </div>
                        <div class="flex ">
                            <button type="submit" class="w-full text-white bg-indigo-500 hover:bg-indigo-600 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm mt-4 px-5 py-2.5 text-center">Mettre à jour</button>
                            <Link :href="route('users.index')" class="w-full text-black bg-white border-2 hover:border-indigo-500 border  focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm mt-5 px-5 py-2.5 text-center">Cancel</Link>
                        </div>
                    </form>
        </div>
    </AuthenticatedLayout>
</template>

<script>
export default {
    props: {
        user: Object,
    },
    methods:{

    },
};

</script>
